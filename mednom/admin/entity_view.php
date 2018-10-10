<?php
require_once("header.php");
?>


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
                    $val =  htmlspecialchars($value);
                    if(strlen($val) > 50 ) {
                        $val =  substr($val, 0,60) . '...';
                    }
                    echo '<td>' . $val . '</td>'; 
                }
                echo '</tr>';
            }
        ?>
    </tbody>
</table>


<?php
require_once("footer.php");
