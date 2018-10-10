<?php
//include('../connection2.php');
 include_once 'lib/dbfunctionjugal.php';
$val1 = $_REQUEST['val1'];
$cnt1 = $_REQUEST['cnt1'];
$money = $_REQUEST['money'];
if ($val1 != "") {
    //$sql_c2 = "select our_price,price,hide_price from product_product where sku='" . $val1 . "'";
    //$res_c2 = mysql_query($sql_c2);
   // $row_c2 = mysql_fetch_array($res_c2);
$data = get_productprice_bysku($val1);
//var_dump($data);
//echo "jugal singh";
if(count($data>0))
{
echo $data['final_inr'];
}
   
/*    if ($money == "pounds") {
        echo $data[0]['price'];
    } elseif ($money == "dollar") {
        echo $data[0]['hide_price'];
    } else {
        echo $data[0]['our_price'];
    }*/
}
