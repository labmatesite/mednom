<?php
include 'lib/database.php';
include 'lib/function.php';

$tax_id = $_REQUEST['tax_id'];
date_default_timezone_set('Asia/Kolkata');
$todaydt = date("Y-m-d H:i:s");
$tax_name = $_POST['tax_name'];
$tax_value = $_POST['tax_value'];
$tax_update = 'admin';
$col = array('tax_name', 'tax_value', 'tax_dt', 'tax_update', 'tax_id');
$value = array($tax_name, $tax_value, $todaydt, $tax_update, $tax_id);
$res = update_table('tax_cal', $col, $value);
if ($res) {
    header('location:crm_settings.php#first11');
}
?>
