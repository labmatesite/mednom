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
    
    $password_aliases = et_get_all($mysqli, 'dm_password_alias');

    echo '<form action="' . $entity_attr['views'][$view_name]['view_file'] . '.php?en=' . $entity_name . '&vn='.$view_name . '" method="post">';
    
    foreach($password_aliases as $password_alias) {
        echo '<br><br><h4>Alias: ' . ((empty($password_alias['name']))? '[BLANK]': $password_alias['name']) . '</h4>';
        echo '<table width="100%" class="form-table"><tbody>';
        
        echo '<tr><td>' . 'Master Password' . ' : </td><td> ';
        echo '<input type="hidden" name="passwords[' . $password_alias['id'] . '][master_password]">';
        echo '<input type="password" class="field_text" onchange="password_hash_check_change(this, \'' . 'passwords[' . $password_alias['id'] . '][master_password]' . '\', \'' . $password_alias['check_hash'] . '\')">';
        echo  ' </td></tr>';
        
        echo '</tbody></table>';
    }
    
    echo '<div class="button-wrap"> <input class="button-sub" type="submit" name="submit" value="Submit"></div>';
    echo '</form>';
    
    
    
    
    
    
} else {
    echo '<br><br><br><br>';
    // process
    try {
        $mysqli->autocommit(FALSE);
        
        $passwords = $_POST['passwords'];
        $password_aliases = et_get_all($mysqli, 'dm_password_alias');
        $edited_excel_file_ids = array();
        foreach($password_aliases as $password_alias) {
            if(!empty($passwords[$password_alias['id']]['master_password'])){
                if(preg_match('/^[a-f0-9]{128}$/', slowaes_decrypt($password_alias['check_hash'],$passwords[$password_alias['id']]['master_password']))){
                    $rows = et_get_combined_all($mysqli, $entity_attr, array('where' => array('password_alias' => $password_alias['name'])));
                    $encrypted_count = 0;
                    foreach($rows as $row) {
                        if($row['password'] != '') {
                            $salt = gen_password_salt(); // salt of 128 chars
                            $encrypted_password = slowaes_encrypt($salt . $row['password'], $passwords[$password_alias['id']]['master_password']);
                            $edit_row = array('password' => '', 'password_encrypted' => $encrypted_password);
                            et_edit_combined_by_identifier($mysqli, $entity_attr, $edit_row, 'id', $row['id'], false, false);
                            $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $row['excel_identifier_value']);
                            if(!in_array($excel_entry['excel_file_id'], $edited_excel_file_ids)) {
                                $edited_excel_file_ids[] = $excel_entry['excel_file_id'];
                            }
                            $encrypted_count++;
                        }
                    }
                    echo '<br><h4>Alias: ' . ((empty($password_alias['name']))?"[BLANK]":$password_alias['name']) . '</h4><br>';
                    echo 'encrypted: ' . $encrypted_count . '<br>';
                } else {
                    // not necessary
                    echo '<br>Wrong password provided for Alias: ' . ((empty($password_alias['name']))?"[BLANK]":$password_alias['name']) . '<br>';
                }
            }
        }
        
        foreach($edited_excel_file_ids as $excel_file_id) {
            $ret = et_check_excel_file_by_identifier($mysqli, $entity_attr['name'], 'id', $excel_file_id);
            if($ret !== true){
                throw new Exception('problem with excel file id ' . $excel_file_id . ', ' . $ret);
            }
        }
        
        foreach($edited_excel_file_ids as $excel_file_id) {
            et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'id', $excel_file_id);
        }
        
        $mysqli->commit();
        echo 'encrypted successfully';
    } catch(Exception $e) {
        echo '<pre>';
        echo 'Error while encrypting >> ',  $e->getMessage(), "\n";
        echo 'Stack trace >> ', var_dump($e->getTrace()), "\n";
        echo '</pre>';
    }
    
    
}

    ?>

<?php
require_once("footer.php");
