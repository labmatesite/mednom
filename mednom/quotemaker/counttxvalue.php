<?php
include_once 'lib/dbfunctionjugal.php';
$tax=0;
//$sql_tax1="select * from tax_cal where tax_status='active'";
//$res_tax1=mysql_query($sql_tax1);

$a=1;
$taxamount = select_taxes();
foreach($taxamount as $ttaxes)
{
$tax = $tax+$ttaxes['tax_value'];
}
//while($row_tax1=mysql_fetch_array($res_tax1))
//{
// $tax=$tax+$row_tax1['tax_value'];	
//}
$a++;
echo $tax;
?>
