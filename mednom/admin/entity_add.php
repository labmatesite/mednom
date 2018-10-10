<?php
require_once("header.php");
?>



<?php

$entity_name = $_GET['en'];
$view_name = $_GET['vn'];
$entity_attr = et_get_entity_attributes($mysqli, $entity_name);



echo '<div class="main-title">' . $entity_attr['views'][$view_name]['display_name'] . '</div><br>';

//var_dump($_POST);


if(empty($_POST['submit'])){
    
    echo '<form action="' . $entity_attr['views'][$view_name]['view_file'] . '.php?en=' . $entity_name . '&vn='.$view_name . '" method="post">';
    echo '<table width="100%" class="form-table"><tbody>';


    foreach($entity_attr['columns_attributes'] as $column_attr) {
        if(empty($column_attr['hide_on_add'])){
            echo '<tr><td>' . $column_attr['display_name'] . (!empty($column_attr['not_empty'])? '*':'') . ' : </td><td> ';
            et_print_field($mysqli, $column_attr, 'add', 'fields');
            echo  ' </td></tr>';
        }
    }
    
    if(!empty($entity_attr['use_excels'])){
        $excel_info_fields = array();
        $excel_info_fields['excel_file_id'] = et_fill_default_column_attr(array(
            'name' => 'excel_file_id',
            'display_name' => 'Excel File ID',
            'data_type' => 'int_11',
            'selection_data' => array(
                'data_function' => 'et_selection_data',
                'data_function_args' => array(
                    'et_excel_files',
                    'id',
                    'name',
                    array('where' => array('entity' => $entity_attr['name'])),
                    array(
                        'show_value_on_display' => '1'
                    )
                )
            )
        ));
        //$excel_info_fields['excel_order'] = et_fill_default_column_attr(array(
        //    'name' => 'excel_order',
        //    'display_name' => 'Excel Order',
        //    'data_type' => 'int_11'
        //));
        $data_types = array();
        $data_type_rows = et_get_all($mysqli, 'et_data_types');
        foreach($data_type_rows as $data_type_row) {
            $data_types[$data_type_row['name']] = $data_type_row;
        }
        $excel_info_fields = et_insert_data_type_details($excel_info_fields, $data_types);
        
        foreach($excel_info_fields as $column_attr) {
            if(empty($column_attr['hide_on_add'])){
                echo '<tr><td>' . $column_attr['display_name'] . (!empty($column_attr['not_empty'])? '*':'') . ' : </td><td> ';
                et_print_field($mysqli, $column_attr, 'add', 'excel_info');
                echo  ' </td></tr>';
            }
        }
    }
    
    echo '</tbody></table>';

    
    echo '<div class="button-wrap"> <input class="button-sub" type="submit" name="submit" value="Submit"></div>';
    echo '</form>';
    
    
    
    
    
    
} else {
    echo '<br><br><br><br>';
    // process
    try {
        $mysqli->autocommit(FALSE);
        $excel_file_id = '';
        $excel_order = '';
        if(!empty($entity_attr['use_excels']) ) {
            if(!empty($_POST['excel_info']['excel_file_id'])){
                $excel_file = et_get_by_identifier($mysqli, 'et_excel_files', 'id', $_POST['excel_info']['excel_file_id']);
                if(empty($excel_file)) {
                   throw new Exception('Excel file not found'); 
                }
                //check excel file
                $excel_file_id = $_POST['excel_info']['excel_file_id'];
                //$excel_order = $_POST['excel_info']['excel_order'];
            } else {
                $excel_files = et_get_all($mysqli, 'et_excel_files', array('where' => array('name' => $entity_attr['name'], 'entity' => $entity_attr['name'])));
                if(empty($excel_files)){
                    throw new Exception('Default Excel file does not exist on add');
                } elseif(!et_check_file_access($config['excels_dir'] . '/' . $entity_attr['name'] . '/' . $excel_files[0]['name'] . '.xls')){
                    throw new Exception('No file access');
                }
                $excel_file_id = $excel_files[0]['id'];
            }
        }
        $ret_array = et_add_combined($mysqli, $entity_attr, $_POST['fields'], $excel_file_id);
        if(!empty($entity_attr['function_after_add'])) {
            $row = et_get_combined_by_identifier($mysqli, $entity_attr, 'id', $ret_array['table_row_id']);
            $entity_attr['function_after_add']($mysqli, $entity_attr, array($row));
        }
        $mysqli->commit();
        echo 'added successfully';
    } catch(Exception $e) {
        echo '<pre>';
        echo 'Error while adding >> ',  $e->getMessage(), "\n";
        echo 'Stack trace >> ', var_dump($e->getTrace()), "\n";
        echo '</pre>';
    }
    
    
}

    
    
?>


<?php
require_once("footer.php");
