<?php
//include('../connection2.php');
include_once 'lib/dbfunctionjugal.php';
$txid=$_REQUEST['txid'];
$sql_tx2="select tax_status from tax_cal where tax_id='$txid'";
$res_tx2=mysql_query($sql_tx2);
$row_tx2=mysql_fetch_array($res_tx2);
$taxdet = select_taxdetails($txid);
//echo $taxdet[0]['tax_status'];
if($taxdet[0]['tax_status']=="active")
{
$status="deactive";	
}
elseif($taxdet[0]['tax_status']=="deactive")
{
$status="active";	
}

$sql_tx1="update tax_cal set tax_status='$status' where tax_id='$txid'";
$res_tx1=mysql_query($sql_tx1);
?>

								<table class="table table-hover table-nomargin dataTable table-bordered">
                                <thead><tr><td>Tax Name</td><td>Tax Value</td><td>Tax Status</td></tr></thead>							<?php //while($row_tx=mysql_fetch_array($res_tx))
$taxamount = select_taxes();
foreach($taxamount as $ttaxes)

								{ ?>
                                <tr><td><?php echo $ttaxes['tax_name']; ?></td><td><?php echo $ttaxes['tax_value']."%"; ?></td><td><input type="checkbox" name="st<?php echo $ttaxes['tax_id']; ?>" id="st<?php echo $ttaxes['tax_id']; ?>" <?php if($ttaxes['tax_status']=="active") { ?>; checked <?php } ?> onClick="tax('<?php echo $ttaxes['tax_id']; ?>','<?php echo $ttaxes['tax_value']; ?>','<?php echo $ttaxes['tax_status']; ?>')" ></td></tr>
                                <?php
								}
								?>
                                </table>
