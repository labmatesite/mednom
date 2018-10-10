<?php
require_once("header.php");
?>
<script>
    function new_master_password_change(ele, target_field_name) {
        var parent = $(ele).parent();
        var pass = parent.find('.new_master_password');
        var pass_con = parent.find('.new_master_password_confirm');
        var new_pass = $('[name="' + target_field_name + '"]');
        
        pass.css('border-color', '');
        pass_con.css('border-color', '');
        new_pass.val('');
        if (pass.val() != '') {
            pass.css('border-color', 'green');
            if (pass.val() == pass_con.val() != '') {
                pass_con.css('border-color', 'green');
                new_pass.val(pass.val());
            } else {
                pass_con.css('border-color', 'red');
            }
        } else {
            pass.css('border-color', 'red');
        }
    }
</script>

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
        
        echo '<tr><td>' . 'Old Master Password' . ' : </td><td> ';
        echo '<input type="hidden" name="passwords[' . $password_alias['id'] . '][master_password]">';
        echo '<input type="password" class="field_text" onchange="password_hash_check_change(this, \'' . 'passwords[' . $password_alias['id'] . '][master_password]' . '\', \'' . $password_alias['check_hash'] . '\')">';
        echo  ' </td></tr>';
        
        echo '<tr><td>' . 'New Master Password' . ' : </td><td> ';
        echo '<input type="hidden" name="passwords[' . $password_alias['id'] . '][new_master_password]">';
        echo '<input type="password" class="new_master_password field_text" placeholder="Password" onchange="new_master_password_change(this, \'' . 'passwords[' . $password_alias['id'] . '][new_master_password]' . '\')">';
        echo '<br><input type="password" class="new_master_password_confirm field_text" placeholder="Password Confirm" onchange="new_master_password_change(this, \'' . 'passwords[' . $password_alias['id'] . '][new_master_password]' . '\')">';
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
            if(!empty($passwords[$password_alias['id']]['master_password']) && !empty($passwords[$password_alias['id']]['new_master_password'])){
                if(preg_match('/^[a-f0-9]{128}$/', slowaes_decrypt($password_alias['check_hash'],$passwords[$password_alias['id']]['master_password']))){
                    $new_salt = gen_password_salt();
                    $new_check_hash = slowaes_encrypt($new_salt, $passwords[$password_alias['id']]['new_master_password']);
                    et_edit_by_identifier($mysqli, 'dm_password_alias', array('check_hash' => $new_check_hash), 'id', $password_alias['id'], true);
                    $rows = et_get_combined_all($mysqli, $entity_attr, array('where' => array('password_alias' => $password_alias['name'])));
                    $decrypted_count = 0;
                    foreach($rows as $row) {
                        if($row['password_encrypted'] != '') {
                            $decrypted_password_with_salt = slowaes_decrypt($row['password_encrypted'], $passwords[$password_alias['id']]['master_password']);
                            if(preg_match('/^[a-f0-9]{128}$/', substr($decrypted_password_with_salt,0,128))){ // check if salt is in proper form
                                $decrypted_password = substr($decrypted_password_with_salt, 128); // salt is 128 chars long
                                $salt = gen_password_salt(); // salt of 128 chars
                                $encrypted_password = slowaes_encrypt($salt . $decrypted_password, $passwords[$password_alias['id']]['new_master_password']);
                                $edit_row = array('password' => '', 'password_encrypted' => $encrypted_password);
                                et_edit_combined_by_identifier($mysqli, $entity_attr, $edit_row, 'id', $row['id'], false, false);
                                $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $row['excel_identifier_value']);
                                if(!in_array($excel_entry['excel_file_id'], $edited_excel_file_ids)) {
                                    $edited_excel_file_ids[] = $excel_entry['excel_file_id'];
                                }
                                $decrypted_count++;
                            } else {
                                echo '<br> could not decrypt, ID: ' . $row['id'] . '<br>';
                            }
                        }
                    }
                    echo '<br><h4>Master Password changed for Alias: ' . ((empty($password_alias['name']))?"[BLANK]":$password_alias['name']) . '</h4><br>';
                    echo 'passwords changed: ' . $decrypted_count . '<br>';
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
        echo 'passwords changed successfully';
    } catch(Exception $e) {
        echo '<pre>';
        echo 'Error while changing master passwords >> ',  $e->getMessage(), "\n";
        echo 'Stack trace >> ', var_dump($e->getTrace()), "\n";
        echo '</pre>';
    }
    
    
}

    ?>

<?php
require_once("footer.php");
