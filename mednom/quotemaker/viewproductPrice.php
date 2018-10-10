<?php
include_once 'lib/dbfunctionjugal.php';
$val1 = $_REQUEST['val1'];
$cnt1 = $_REQUEST['cnt1'];
$price = $_REQUEST['price'];
$username = $_REQUEST['username'];
$data = get_productprice_byskunew($val1,$price);
$multiple_data = get_multiple_productprice_bysku($val1);
if($data != ""){
    echo $data['final_inr'];
}//elseif($multiple_data != ""){ 
   // foreach($multiple_data as $row){
     //   echo $row['sku']." -> ".$row['final_inr']." | ";
    //} 
//}   
?>
