<?php
require_once("header.php");
?>


<?php

$entity_name = $_GET['en'];
$view_name = $_GET['vn'];
$identifier_name = $_GET['in'];
$identifier_value = $_GET['iv'];
$entity_attr = et_get_entity_attributes($mysqli, $entity_name);



echo '<div class="main-title">' . $entity_attr['views'][$view_name]['display_name'] . '</div><br>';

//var_dump($_POST);
echo '<br><br><br><br>';

if(empty($_POST['confirm'])){
    
    echo ' Are you sure you want to delete "' . $entity_attr['name'] . '" where "' . $identifier_name . '" = "' . $identifier_value . '" ?';
    
    echo '<form action="' . $entity_attr['views'][$view_name]['view_file'] . '.php?en=' . $entity_name . '&vn='.$view_name . '&in='.$identifier_name. '&iv='.$identifier_value . '" method="post">';
    
    echo '<div class="button-wrap"> <input class="button-sub" type="submit" name="confirm" value="Confirm"></div>';
    echo '</form>';
    
} else {
    
    // process
    try {
        $mysqli->autocommit(FALSE);
        $row = et_get_combined_by_identifier($mysqli, $entity_attr, $identifier_name, $identifier_value);
        if(empty($row)) {
            throw new Exception('row does not exist');
        }
        if(!empty($entity_attr['use_excels'])) {
            $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $row[$entity_attr['excel_identifier']]);
            if(empty($excel_entry)) {
                throw new Exception('excel entry does not exist');
            }
            $excel_file = et_get_by_identifier($mysqli, 'et_excel_files', 'id', $excel_entry['excel_file_id']);
            if(empty($excel_file)) {
               throw new Exception('Excel file not found'); 
            }
        }
        if(!empty($entity_attr['function_after_delete'])) {
            $entity_attr['function_after_delete']($mysqli, $entity_attr, array($row));
        }
        et_delete_combined_by_identifier($mysqli, $entity_attr, $identifier_name, $identifier_value);
        $mysqli->commit();
        echo 'deleted successfully';
    } catch(Exception $e) {
        echo '<pre>';
        echo 'Error while deleting >> ',  $e->getMessage(), "\n";
        echo 'Stack trace >> ', var_dump($e->getTrace()), "\n";
        echo '</pre>';
    }
    
    
}

    ?>

<?php
require_once("footer.php");
