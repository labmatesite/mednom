<?php
require_once("header.php");
?>
<script>
    function decrypt_password(container, password){
        container.html('<input type="text" value="' + encode_html_special_chars(slowaes_decrypt(container.attr('data-password-encrypted'), password).substr(128)) + '" readonly>');
    }
    
    function view_password(ele) {
        var parent = $(ele).parent();
        var password = parent.find('.password_input');
        if (password.val()) {
            decrypt_password(parent, password.val());
        }
    }
    
    function view_all_passwords(){
        var master_passwords = {};
        $('.master_password').each(function(){
            var self = $(this);
            if (self.val() != '') {
                master_passwords[self.attr('data-password-alias')] = self.val();
            }
            
        });
        
        $('.password_encrypted').each(function(){
            var self = $(this);
            if (master_passwords[self.attr('data-password-alias')]) {
                decrypt_password(self, master_passwords[self.attr('data-password-alias')]);
            }
        });
        
    }
</script>

<?php

// need to display names, search by any value on fields
$entity_name = $_GET['en'];
$view_name = $_GET['vn'];
$entity_attr = et_get_entity_attributes($mysqli, $entity_name);

$identifier_name = 'id';

$edit_view = '';
$edit_view_name = '';
$delete_view = '';
$delete_view_name = '';
foreach($entity_attr['views'] as $view) {
    if($view['type'] == 'edit') {
        $edit_view = $view['view_file'] . '.php';
        $edit_view_name = $view['name'];
    } else if($view['type'] == 'delete') {
        $delete_view = $view['view_file'] . '.php';
        $delete_view_name = $view['name'];
    }
}



$rows = et_get_combined_all($mysqli, $entity_attr);


?>


<div class="main-title"><?php echo $entity_attr['views'][$view_name]['display_name']; ?></div>
<?php

    $password_aliases = et_get_all($mysqli, 'dm_password_alias');

    
    foreach($password_aliases as $password_alias) {
        echo '<br><br><h4>Alias: ' . ((empty($password_alias['name']))? '[BLANK]': $password_alias['name']) . '</h4>';
        echo '<table width="100%" class="form-table"><tbody>';
        
        echo '<tr><td>' . 'Master Password' . ' : </td><td> ';
        echo '<input type="hidden" class="master_password" data-password-alias="' . $password_alias['name'] . '"  name="passwords[' . $password_alias['id'] . '][master_password]">';
        echo '<input type="password" class="field_text" onchange="password_hash_check_change(this, \'' . 'passwords[' . $password_alias['id'] . '][master_password]' . '\', \'' . $password_alias['check_hash'] . '\')">';
        echo  ' </td></tr>';
        
        echo '</tbody></table>';
    }

    echo '<input type="button" value="View All" onclick="view_all_passwords()"><br><br>';

?>


<table class="view-product-table ">
    <thead>
        <tr>
            <td></td>
            <?php
                foreach($rows[0] as $key => $value) {
                    echo '<td>' . $key . '</td>';
                }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($rows as $row){
                echo '<tr><td><a href="' . $edit_view . '?en=' . $entity_name . '&vn='. $edit_view_name . '&in='.$identifier_name. '&iv='.$row[$identifier_name].'"><img src="assets/images/edit-icon.png" alt="Edit-icon" /></a> <a href="' . $delete_view . '?en=' . $entity_name . '&vn='.$delete_view_name. '&in='.$identifier_name. '&iv='.$row[$identifier_name].'"><img src="assets/images/delete-icon.png" alt="Delete-icon" /></a></td>';
                foreach($row as $key => $value) {
                    if($key != 'password_encrypted' || empty($value)){
                        $val =  htmlspecialchars($value);
                        if(strlen($val) > 50 ) {
                            $val =  substr($val, 0,60) . '...';
                        }
                        echo '<td>' . $val . '</td>';
                    } else {
                        echo '<td class="password_encrypted" data-password-encrypted="' . $value . '" data-password-alias="' . $row['password_alias'] . '">' . '<input type="password" class="password_input" placeholder="Master Password"> <input type="button" value="View" onclick="view_password(this)">' . '</td>';
                    }
                }
                echo '</tr>';
            }
        ?>
    </tbody>
</table>


<?php
require_once("footer.php");
