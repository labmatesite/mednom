<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include  'lib/header.php' ;

$refid=$_REQUEST['id'];

$row_vd1 = get_quotedetail($refid);
//var_dump($row_vd1);
$quote_products = get_quoteproducts($refid);
$cont = count($quote_products);
$mycon = $cont;
//$taxes = select_taxes();

$tax=0;
$a=1;
$row_tax = select_taxes();
foreach($row_tax as $row_tax1)
{
	$tax=$tax+$row_tax1['tax_value'];	

}
/*

$sql_vd1="select * from quotations where qt_refid='$refid'";
$res_vd1=mysql_query($sql_vd1);
$row_vd1=mysql_fetch_array($res_vd1);

$tax=0;
$sql_tax1="select * from tax_cal where tax_status='active'";
$res_tax1=mysql_query($sql_tax1);
$a=1;
while($row_tax1=mysql_fetch_array($res_tax1))
{
 $tax=$tax+$row_tax1['tax_value'];	
}
$a++;

$sql_tax2="select * from tax_cal where tax_status='active'";
$res_tax2=mysql_query($sql_tax2);
$taxn="";
$sql_sec4="select * from quote_product where qt_refid='$refid'";
$res_sec4=mysql_query($sql_sec4);
$tot_sec4=mysql_num_rows($res_sec4);

*/	
?>
<?php
if (isset($_POST['save']) || isset($_POST['savensend']) || isset($_POST['emailwithpdf']))
{
	
//include('../connection2.php');
$qt_shipping_charges=$_POST['shippin_charges'];
//echo $qt_shipping_charges;
//exit(0);
//$up_qt_refid=mysql_real_escape_string($_REQUEST['refid']);
$up_qt_refid=$_REQUEST['refid'];

delete_quote_product($up_qt_refid);
delete_quote_taxes($up_qt_refid);
/*$sql_up_qt1="delete from quote_product where qt_refid='$up_qt_refid'";
$res_up_qt1=mysql_query($sql_up_qt1);

$sql_up_qt2="delete from quote_tax where qt_refid='$up_qt_refid'";
$res_up_qt2=mysql_query($sql_up_qt2);*/


date_default_timezone_set('Asia/Kolkata');
$todaydt = date("Y-m-d H:i:s");
$curmonth = date("m");
$curyear = date("y");
$i=1;
$correct=0;

		while($i<=$_POST['numoftxt'])	
		{
			
			//$qt_product_sku=mysql_real_escape_string($_POST['prod_sku'.$i]);
$qt_product_sku=$_POST['prod_sku'.$i];
			if(isset($_POST['prod_spec_show'.$i]) && $_POST['prod_spec_show'.$i]!="")
			{
				$qt_product_spec_show="yes";
			}
			else
			{
				$qt_product_spec_show="no";
			}
			/*$qt_product_name=mysql_real_escape_string($_POST['prod_fullname'.$i]);
			$qt_product_catalog=$_POST['prod_catalog'.$i];
			$qt_product_desc=mysql_real_escape_string($_POST['product_desc'.$i]);
			$qt_product_qty=mysql_real_escape_string($_POST['quantity'.$i]);*/

$qt_product_name=$_POST['prod_fullname'.$i];
			//$qt_product_catalog=$_POST['prod_catalog'.$i];
			//$qt_product_desc=$_POST['product_desc'.$i];
$qt_product_catalog='';
$qt_product_desc=$_POST['product_desc'.$i];
			$qt_product_qty=$_POST['quantity'.$i];


			if(isset($_POST['selling_price'.$i])&& $_POST['selling_price'.$i]!= "")
			{
				//$qt_selling_price=mysql_real_escape_string($_POST['selling_price'.$i]);
$qt_selling_price=$_POST['selling_price'.$i];
			}
			else
			{
			$qt_selling_price=0;
			}

				if($qt_selling_price!=0)
				{
					/*$sql_product="insert into quote_product (qt_refid,product_sku,product_name,product_desc,product_quantity,product_sellingprice,product_catalog,product_spec_show) values ('$up_qt_refid','$qt_product_sku','$qt_product_name','$qt_product_desc','$qt_product_qty','$qt_selling_price','$qt_product_catalog','$qt_product_spec_show')";
					$res_product=mysql_query($sql_product);*/

insert_quote_product($up_qt_refid,$qt_product_sku,$qt_product_name,$qt_product_desc,$qt_product_qty,$qt_selling_price,$qt_product_spec_show);

				}
	
			$i++;	
		}
		
	

//$sql_tx1="select * from tax_cal order by tax_id";
//$res_tx1=mysql_query($sql_tx1);
//while($row_tx1=mysql_fetch_array($res_tx1))
$mytaxes = select_taxes();
foreach($mytaxes as $row_tx1)
{
	$tax_id=$row_tx1['tax_id'];
	$qt_taxname=$row_tx1['tax_name'];
	$qt_taxvalue=$row_tx1['tax_value'];
	if (isset($_POST['st'.$tax_id])) {
	/*$sql_tx2="insert into quote_tax (qt_refid,qt_taxname,qt_taxvalue,qt_taxdt) values ('$up_qt_refid','$qt_taxname','$qt_taxvalue','$todaydt')";
$res_tx2=mysql_query($sql_tx2);*/
 insert_quote_tax($up_qt_refid,$qt_taxname,$qt_taxvalue,$todaydt);
	} 		
}

/*$qt_subject=mysql_real_escape_string($_POST['qt_subject']);
$qt_organisationid=mysql_real_escape_string($_POST['qt_organisationid']);
$qt_contacts=mysql_real_escape_string($_POST['qt_contacts']);
$qt_addinfo=mysql_real_escape_string($_POST['qt_addinfo']);
$qt_tnc=mysql_real_escape_string($_POST['content1']);
$qt_cur=mysql_real_escape_string($_POST['qt_cur']);*/

$qt_subject=$_POST['qt_subject'];
$qt_organisationid=$_POST['qt_organisationid'];
$qt_contacts=$_POST['qt_contacts'];
$qt_addinfo=$_POST['qt_addinfo'];
$qt_tnc=$_POST['content1'];
$qt_cur=$_POST['qt_cur'];


if($qt_cur=="inr")
{
	$qt_cur1="₹";	
}
elseif($qt_cur=="dollar")
{
	$qt_cur1="$";
}
elseif($qt_cur=="pounds"){
	$qt_cur1="£";
}
/*$qt_itemtotal=mysql_real_escape_string($_POST['qt_itemtotal']);
$qt_discount=mysql_real_escape_string($_POST['qt_discount']);
$qt_discounttype=mysql_real_escape_string($_POST['discount_final']);*/

$qt_itemtotal=$_POST['qt_itemtotal'];
$qt_discount=$_POST['qt_discount'];
$qt_discounttype=$_POST['discount_final'];

if($qt_discounttype=="r_perprice")
{
//$qt_discountpercent=mysql_real_escape_string($_POST['per_price']);
$qt_discountpercent=$_POST['per_price'];
}
elseif($qt_discounttype=="r_dpr")
{
$qt_discountpercent="dpr";
}
else
{
$qt_discountpercent="zero";
}

/*$qt_shipping_charges=mysql_real_escape_string($_POST['shippin_charges']);
$qt_pretax_total=mysql_real_escape_string($_POST['pretaxtotal']);
$qt_tax=mysql_real_escape_string($_POST['tax_total']);
$qt_adjustment=mysql_real_escape_string($_POST['group1']);*/

$qt_shipping_charges=$_POST['shippin_charges'];

$qt_pretax_total=$_POST['pretaxtotal'];
$qt_tax=$_POST['tax_total'];
$qt_adjustment=$_POST['group1'];

if($qt_adjustment=="add")
{
	//$qt_adj_add=mysql_real_escape_string($_POST['adjustment']);
$qt_adj_add=$_POST['adjustment'];
	$qt_adj_sub="";
}
elseif($qt_adjustment=="subtract")
{
	$qt_adj_add="";
	//$qt_adj_sub=mysql_real_escape_string($_POST['adjustment']);
$qt_adj_sub=$_POST['adjustment'];
}
//$qt_grandtotal=mysql_real_escape_string($_POST['grandtotal']);
$qt_grandtotal=$_POST['grandtotal'];
$qt_updateddt=$todaydt;
$qt_updatedby=$_SESSION['login_user'];


if($qt_organisationid=='-1')
	{

$myorgname =$_POST['myorgname'];
$orgemail =$_POST['orgemail'];
$orgbill =$_POST['orgbill'];
$orgcity =$_POST['orgcity'];
$orgstate =$_POST['orgstate'];

		//echo "great";
		/*mysql_query("insert into quote_organisation set org_name ='".mysql_real_escape_string($myorgname)."',org_primaryemail ='".mysql_real_escape_string($orgemail)."',org_billingadd='".mysql_real_escape_string($orgbill)."',org_billingcity ='".mysql_real_escape_string($orgcity)."'
,org_billingstate ='".mysql_real_escape_string($orgstate)."'");*/
$qt_organisationid = insert_quote_org($myorgname,$orgemail,$orgbill,$orgcity,$orgstate,$qt_updatedby,$todaydt);
//$org_insertid ='';
	}
	
	if($qt_contacts=='-1')
	{
$cont_sal =$_POST['cont_sal'];
$cfname =$_POST['cfname'];
$clname =$_POST['clname'];
$cemail =$_POST['cemail'];
/*
mysql_query("insert into quote_contacts set cont_sal ='".mysql_real_escape_string($cont_sal)."',cont_firstname ='".mysql_real_escape_string($cfname)."',cont_lastname ='".mysql_real_escape_string($clname)."',cont_primaryemail ='".mysql_real_escape_string($cemail)."'");*/
$qt_contacts = insert_quote_contact($cont_sal,$cfname,$clname,$cemail,$qt_organisationid,$qt_updatedby,$todaydt);
//$lastId = $dbh->lastInsertId();

$contact_insertid ='';
	}



/*$sql_or="select org_name from quote_organisation where org_id='".$qt_organisationid."'";
$res_or=mysql_query($sql_or);
$row_or=mysql_fetch_array($res_or);*/
$row_or =get_organisation_byid($qt_organisationid);

$qt_refid1="<a href='#'>".$qt_subject." - ".$up_qt_refid."</a>";
$qt_refid2=$qt_refid1." for <span style=color:#4285F4>".$row_or['org_name']."</span> with an amount of <span style=color:#4285F4><strong>".$qt_cur1.$qt_grandtotal."</strong></span>";
$qt_refid2=str_replace("'","&#146;",$qt_refid2);


$sql_qt="update quotations set qt_organisationid='$qt_organisationid',qt_contacts='$qt_contacts',qt_subject='$qt_subject',qt_tnc='$qt_tnc',qt_addinfo='$qt_addinfo',qt_currency='$qt_cur',qt_itemtotal='$qt_itemtotal',qt_discount='$qt_discount',qt_discountpercent='$qt_discountpercent',qt_shipping_charges='$qt_shipping_charges',qt_pretax_total='$qt_pretax_total',qt_tax='$qt_tax',qt_adj_add='$qt_adj_add',qt_adj_sub='$qt_adj_sub',qt_grandtotal='$qt_grandtotal',qt_updatedby='$qt_updatedby',qt_updateddt='$qt_updateddt' where qt_refid='$up_qt_refid'";

$res_qt= update_quote($qt_organisationid,$qt_contacts,$qt_subject,$qt_tnc,$qt_addinfo,$qt_cur,$qt_itemtotal,$qt_discount,$qt_discountpercent,$qt_shipping_charges,$qt_pretax_total,$qt_tax,$qt_adj_add,$qt_adj_sub,$qt_grandtotal,$qt_updatedby,$qt_updateddt,$up_qt_refid);

//$res_qt=mysql_query($sql_qt);
//if($res_qt)
//{
	$sql_ua = "insert into quote_contactactivity (ca_userid,ca_activity,ca_activity_details,ca_dbtype,ca_date) values ('$qt_updatedby','Updated','$qt_refid2','Quotation','$qt_updateddt')";
	//$res_ua=mysql_query($sql_ua);
$res_ua = quote_contactactivity("$qt_updatedby","Updated","$qt_refid2","Quotation","$qt_updateddt");

	
//}
?>

	<script type="text/javascript">
		alert("Quote Updated Successfully");
window.open('view_quote.php','_self');
		history.go(-1);
		</script>
<?php

		
}

?>
<script>
var cnt = <?php echo $mycon; ?>;
	function AddRow(){

	cnt++;
//alert(cnt);
    var newRow = jQuery('<tr id="addrowid' + cnt + '"></tr>'); // add new tr with dynamic id and then add new row with textfield.
    jQuery('table.authors-list').append(newRow);	
	
	var strURL="addnewrow.php?cnt="+cnt;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('addrowid' + cnt).innerHTML=req.responseText;
						$("#product_name" + cnt).select2();						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}
</script>
<script src="assets/js/editquote.js"></script>

<div class="container-fluid" id="content">

	<div id="main">
<input type="text"  name="hid_tx"  id="hid_tx" value="<?php echo $tax; ?>" style="display:none;">
		<div class="container-fluid">
			<div class="page-header">
				<div class="pull-left">
					<h1>Edit Quote no : <?php echo $row_vd1['qt_refid'] ?></h1>
				</div>
				<?php 
				date_default_timezone_set("Asia/Calcutta");
				$dt=date('F d, Y');
				$week=date('l');
				?>
				<div class="pull-right">
					<ul class="stats">
						<li class='lightred'>
							<i class="icon-calendar"></i>
							<div class="details">
								<span class="big"><?php echo $dt; ?></span>
								<span><?php echo $week; ?></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="breadcrumbs">
				<ul>
					<li>
						<a href="home.php">Home</a>
						<i class="icon-angle-right"></i>
					</li>
					<li>
						<a href="#">Quotations</a>
						<i class="icon-angle-right"></i>
					</li>
					<li>
						<a href="#">Edit Quote</a>
					</li>
				</ul>
				<div class="close-bread">
					<a href="#"><i class="icon-remove"></i></a>
				</div>
			</div>

			<!-- Main content start -->




			<div class="row-fluid">
				<div class="span12">
					<div class="box box-bordered box-color">
						<div class="box-title">
							<h3><i class="icon-th-list"></i>Edit Quote no : <?php echo $row_vd1['qt_refid'] ?></h3>
						</div>
						<div class="box-content nopadding">
							<form  method="POST" action="edit_quote2.php?refid=<?php echo $row_vd1['qt_refid']; ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
								<div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Group Tax</h3>
									</div>
									<div class="modal-body">
										<?php
							//  $sql_tx="select * from tax_cal order by tax_id";
							 // $res_tx=mysql_query($sql_tx);
										?>


										<table class="table table-hover table-nomargin dataTable table-bordered">
											<thead><tr><td>Tax Name</td><td>Tax Value</td><td>Tax Status</td></tr></thead>							<?php $taxamount = select_taxes();
											foreach($taxamount as $ttaxes)
												{ ?>
											<tr><td><?php echo $ttaxes['tax_name']; ?></td><td><?php echo $ttaxes['tax_value']."%"; ?></td><td><input type="checkbox" name="st<?php echo $ttaxes['tax_id']; ?>" id="st<?php echo $ttaxes['tax_id']; ?>" <?php if($ttaxes['tax_status']=="active") { ?>; checked <?php } ?> onClick="tax('<?php echo $ttaxes['tax_id']; ?>','<?php echo $ttaxes['tax_value']; ?>','<?php echo $ttaxes['tax_status']; ?>','<?php echo $ttaxes['tax_name']; ?>')" ></td></tr>
											<?php
										}
										?>
									</table>

								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
								</div>

							</div>



							<div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel">Set Disocunt For : <span id="DiscPrice"></span></h3>
									<table class="table table-hover table-nomargin dataTable table-bordered">
										<tr><td><input type="radio" name="discount_final" <?php if($row_vd1['qt_discountpercent']=="zero") {?> checked <?php } ?> value="zero" onClick="return DiscFinal(this.value)"> Zero Discount</td><td></td></tr>
										<tr><td><input type="radio" name="discount_final" <?php if($row_vd1['qt_discountpercent']!="zero" && $row_vd1['qt_discountpercent']!="dpr") {?> checked <?php } ?> value="r_perprice" onClick="return DiscFinal(this.value)"> % Price</td><td><input  type="text" id="per_price" name="per_price" <?php if($row_vd1['qt_discountpercent']!="zero" && $row_vd1['qt_discountpercent']!="dpr") {?> value="<?php echo $row_vd1['qt_discountpercent']; ?>" style="width:100px;display:block;" <?php } else { ?> style="width:100px;display:none;" <?php } ?> onBlur="DiscFinal('r_perprice')"/> %</td></tr>
										<tr><td><input type="radio" name="discount_final" <?php if($row_vd1['qt_discountpercent']=="dpr") {?> checked <?php } ?> value="r_dpr" onClick="return DiscFinal(this.value)"> Direct Price Reduction</td><td><input  type="text" id="dpr" name="dpr" <?php if($row_vd1['qt_discountpercent']=="dpr") {?> value="<?php echo $row_vd1['qt_discount'] ?>"  style="width:100px;display:block;" <?php }else { ?> style="width:100px;display:none;" <?php } ?> onBlur="DiscFinal('r_dpr')" /></td></tr>        
									</table>
								</div>
								<div class="modal-body">


								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
								</div>

							</div>

							<input type="text"  name="numoftxt"  id="numoftxt" value="<?php echo $tot_sec4 ?>" style="display:none;"><input type="text"  name="qt_itemtotal"  id="qt_itemtotal" value="<?php echo $row_vd1['qt_itemtotal']; ?>" style="display:none;">
							<div id="organisationid" class="control-group">
								<label for="textfield" class="control-label">Organisation</label>
								<div class="controls">
									<?php 
									$orgnames = get_organisation();	
									?>

									<select id="qt_organisationid" class='select2-me input-xlarge' data-rule-required="true" name="qt_organisationid" class="select2-me input-xlarge" data-placeholder="Organisation Name" onChange="Organisation(this.value);">>
										<option value="">-- Select Organisation --</option>
										<option value="0" <?php if($row_vd1['qt_organisationid']==0){echo "selected";}  ?>>-- Individual--</option>
										<option value="-1">-- Add New --</option>
										<?php
										foreach($orgnames as $values)
										{
											?>
											<option value="<?php echo $values['org_id'] ?>" <?php if($values['org_id']==$row_vd1['qt_organisationid']){?> selected <?php } ?>>-- <?php echo ucwords($values['org_name']); ?> --</option>
											<?php
										}


												/* while($row_sec3=mysql_fetch_array($res_sec3))
												  {
												?>
                                                  <option <?php if($row_sec3['org_id']==$row_vd1['qt_organisationid']){?> selected <?php } ?> value="<?php echo $row_sec3['org_id'] ?>"><?php echo ucwords($row_sec3['org_name'])?></option>;
												 <?php
												}*/
												?>
											</select>


										</div>

									</div> 
									<div id="myorgdetails" class="control-group " style="display:none" >


									</div>

									<div id="contactsid" class="control-group">
										<label for="textfield" class="control-label">Contacts</label>
										<div class="controls">
											<!-- <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="Contacts(this.value);showcontdata(this.value);">-->
											<select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="showcontdata(this.value);">
												<option value="">-- Select Contacts --</option>
												<option value="-1">-- Add New --</option>
												<?php
												
												$contactdet = get_contacts();
												foreach($contactdet as $values)
												{
												
													?>
													<option <?php if($values['cont_id']==$row_vd1['qt_contacts']){?> selected <?php } ?> value="<?php echo $values['cont_id'] ?>"><?php echo ucwords($values['cont_firstname']." ".$values['cont_lastname']) ?></option>
													<?php
												}
												?>
											</select>


										</div>

									</div> 

									<div style="clear:both;"></div>

									<div class="control-group" class="control-group divhalf" style="display:none" id="mycontdet">

									</div>
									<div class="control-group" class="control-group divhalf">
										<label for="textfield" class="control-label">Subject</label>
										<div class="controls">
											<input type="text" id="qt_subject" data-rule-required="true" name="qt_subject" class="input-xlarge" value="<?php echo $row_vd1['qt_subject']; ?>" data-placeholder="Subject">
										</div> 
									</div>
									<div class="control-group" class="control-group divhalf">
										<label for="textfield" class="control-label">Additional info</label>
										<div class="controls">
											<input type="text" id="qt_addinfo" name="qt_addinfo" class="input-xlarge" data-placeholder="Info" value="<?php echo $row_vd1['qt_addinfo']; ?>">
										</div> 
									</div>

									<div class="control-group">
										<label for="textarea" class="control-label">Terms &amp; Conditions</label>
										<div class="controls">
											<textarea name="content1" id="elm1" rows="5" class="input-block-level"><?php echo $row_vd1['qt_tnc']; ?></textarea>
										</div>
									</div> <!-- qt tnc-->
                                            			<!--<div class="control-group">
										<label for="textarea" class="control-label">Description details</label>
										<div class="controls">
											<textarea name="content2" id="elm" rows="5" class="input-block-level"></textarea>
										</div>
									</div>-->

									<table id="myTable1" class="table table-hover table-nomargin dataTable table-bordered authors-list">
										<thead>
											<tr>
												<th colspan="3">Item Details</th>
												<th>Currency <select id="qt_cur" name="qt_cur">
													<option <?php if($row_vd1['qt_currency']==" "){?> selected <?php } ?> value="">Select Type</option>
													<option <?php if($row_vd1['qt_currency']=="inr"){?> selected <?php } ?> value="inr" selected>India, Rupees (₹) </option>
													<option <?php if($row_vd1['qt_currency']=="dollar"){?> selected <?php } ?> value="dollar">USA, Dollar ($)</option>
													<option <?php if($row_vd1['qt_currency']=="pounds"){?> selected <?php } ?> value="pounds">UK, Pounds (£)</option>
												</select>  </th>
												<th colspan="2"><!--Tax Mode--> </th>
											</tr>
											<tr>
												<th>Sr no.</th>
												<th>Item Name</th>
												<th>Quantity</th>
												<th>Selling Price</th>
												<th>Total</th>
												<th>Net Price</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$k=1;
									//$sql_vd2="select * from quote_product where qt_refid='$refid'";
									//$res_vd2=mysql_query($sql_vd2);
											$quote_products = get_quoteproducts($refid);
//var_dump($quote_products);
									//while($row_vd2=mysql_fetch_array($res_vd2))
											foreach($quote_products as $values)

											{
//echo $k;
												echo $values['product_sku']	;
												?>
												<tr id="addrowid<?php echo $k ?>">
													<th><?php if($k>1){?> <a href="#" onclick="RemoveRow('<?php echo $k; ?>')">Del</a> <?php }?></th>
													<th>
														<div class="control-group">

															<div class="controls">
																<select name="product_name<?php echo $k ?>" id="product_name<?php echo $k ?>" data-rule-required="true"  onChange="product_Desc(this.value,'<?php echo $k ?>');product_Price(this.value, '1');sord(this.value,'1')">
																	<option value="">-- Select Product --</option>
																	<option<?php if($values['product_sku']=="other") {?> selected <?php } ?> value="other/other">-- Other --</option>
																	<?php
												// $sql_sec4="select * from product_product order by name";
												 //$res_sec4=mysql_query($sql_sec4);
																	$pro_list = get_products();

												// while($row_sec4=mysql_fetch_array($res_sec4))
												//  {
																	foreach($pro_list as $row_sec4)

																	{


																		?>

																		<option <?php if($values['product_sku']==$row_sec4['sku']) {?> selected <?php } ?> value="<?php echo $row_sec4['sku']."/".utf8_encode($row_sec4['name'])?>"><?php echo utf8_encode(ucwords($row_sec4['name']))?></option>
																		<?php
																	}
																	?>
																</select>

																<textarea name="product_desc<?php echo $k ?>" id="product_desc<?php echo $k ?>" rows="5" class="input-block-level"><?php echo $values['product_desc'] ?></textarea> <input type="text"  name="prod_fullname<?php echo $k ?>" id="prod_fullname<?php echo $k ?>" value="<?php echo $values['product_name'] ?>" <?php if($values['product_sku']!="other") { ?> style="display:none;" <?php } else { ?>  style="display:block;" <?php } ?>><input type="text"  name="prod_sku<?php echo $k ?>" id="prod_sku<?php echo $k ?>" value="<?php echo $values['product_sku']; ?>" style="display:none;">
																<div id="product_catalog<?php echo $k ?>"><?php if($values['product_catalog']!="No Catalog Found") {?><a target="new" href="catalog/<?php echo $row_vd2['product_catalog'].".pdf" ?>"><?php echo utf8_encode($values['product_catalog']).".pdf" ?></a><?php } ?><input type="text"  name="prod_catalog<?php echo $k; ?>" id="prod_catalog<?php echo $k; ?>" value="<?php echo $row_vd2['product_catalog']; ?>" style="display:none;"></div><input type="checkbox" id="prod_spec_show<?php echo $k; ?>" name="prod_spec_show<?php echo $k; ?>" value="yes" <?php if($values['product_spec_show']=="yes"){?> checked="checked" <?php } ?>  /> Show Specification
															</div>
														</div>
														<?php $sp=str_replace(',', '', $values['product_sellingprice']);
														$totsp=$sp * $values['product_quantity'];
														?>
													</th>
													<th><input type="text"  name="quantity<?php echo $k ?>" onBlur="sqty(this.value,'<?php echo $k ?>')" id="quantity<?php echo $k ?>" value="<?php echo $values['product_quantity'];  ?>" class="input-xsmall" style="width:150px;" data-rule-required="true" ></th>
													<th><div><input type="text"  name="selling_price<?php echo $k ?>" id="selling_price<?php echo $k ?>" placeholder="0.00" value="<?php echo $values['product_sellingprice'];  ?>" class="input-xsmall currency" style="width:150px;" data-rule-required="true" onBlur="sord(this.value,'<?php echo $k ?>')"></div><div>(-) Discount : </div><div>Total After Discount : </div></th>
													<th><div id="tot<?php echo $k ?>"><?php echo number_format($totsp, 2, '.', ','); ?></div>
														<div id="disc<?php echo $k ?>">0</div>
														<div id="tadisc<?php echo $k ?>"><?php echo number_format($totsp, 2, '.', ','); ?></div></th>
														<th><div id="net<?php echo $k ?>" class="net"><?php echo number_format($totsp, 2, '.', ','); ?></div></th>
													</tr>
													<?php
													$k++;
												}
												?>
											</tbody>
										</table>

										<?php
										$adjustment="";
										if($row_vd1['qt_adj_add']!=0.00 && $row_vd1['qt_adj_add']!="")
										{
											$adjustment=$row_vd1['qt_adj_add'];	
										}
										elseif($row_vd1['qt_adj_sub']!=0.00 && $row_vd1['qt_adj_sub']!="")
										{
											$adjustment=$row_vd1['qt_adj_sub'];	
										}
										else
										{
											$adjustment="0.00";
										}
										?>

										<div style="padding:10px 50px"><a href="javascript:void(0);" onClick="AddRow();" class="btn btn-primary"> + Add New Product</a></div>
										<table class="table table-hover table-nomargin dataTable table-bordered">
											<tr><td style="text-align:right">Items Total</td><td style="text-align:right"><div id="ittot1"><?php echo $row_vd1['qt_itemtotal']; ?></div></td></tr>
											<tr><td style="text-align:right"><a href="#modal-2" role="button" class="btn" data-toggle="modal" onClick="taxval();"><strong style="color:#56AF45">(-)Discount</strong></a></td><td style="text-align:right"><div id="ittot2"><?php echo $row_vd1['qt_discount']; ?></div><input type="text"  name="qt_discount" id="qt_discount" value="<?php echo $row_vd1['qt_discount']; ?>" style="display:none;"></td></tr>
											<tr><td style="text-align:right"><strong>(+) Shipping & Handling Charges</strong> </td><td style="text-align:right"><input type="text"  name="shippin_charges" id="shippin_charges" placeholder="0.00" value="<?php echo $row_vd1['qt_shipping_charges']; ?>" class="input-xsmall" style="width:150px;text-align:right" data-rule-required="true" onBlur="scharge(this.value)"></td></tr>
											<tr><td style="text-align:right">Pre Tax Total</td><td style="text-align:right"><div id="ittot3"><?php echo $row_vd1['qt_pretax_total']; ?></div><input type="text"  name="pretaxtotal" id="pretaxtotal" value="<?php echo $row_vd1['qt_pretax_total']; ?>" style="display:none;"></td></tr>
											<tr><td style="text-align:right"><a href="#modal-1" role="button" class="btn" data-toggle="modal" onClick="taxval();"><span><?php

											$taxamount = select_taxes();
											foreach($taxamount as $ttaxes)
											{
												echo "(". $ttaxes['tax_name']." ".$ttaxes['tax_value']."%) ";
											}

                                // while($row_taxn=mysql_fetch_array($res_tax2)){ echo "(". $row_taxn['tax_name']." ".$row_taxn['tax_value']."%) ";}
											?>

										</span><strong style="color:#56AF45">(+)Tax</strong></a></td><td style="text-align:right"><div id="ittot4"><?php echo $row_vd1['qt_tax']; ?></div><input type="text"  name="tax_total" id="tax_total" value="<?php echo $row_vd1['qt_tax']; ?>" style="display:none;"></td></tr>
										<tr><td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td><td style="text-align:right"><div id="ittot5">0.00</div></td></tr>
										<tr><td style="text-align:right">Adjustment <span><input type="radio" id="add" name="group1" value="add" <?php if($row_vd1['qt_adj_add']!="") { ?> checked <?php } ?> onClick="sadjust1();"> Add</span><span>
											<input type="radio" id="subtract" name="group1" value="subtract" <?php if($row_vd1['qt_adj_sub']!="") {?> checked <?php } ?> onClick="sadjust1();"> Subtract</span>
										</td><td style="text-align:right"><input type="text"  name="adjustment" id="adjustment" placeholder="0.00" value="<?php echo $adjustment; ?>"  class="input-xsmall" style="width:150px;text-align:right" data-rule-required="true" onBlur="sadjust(this.value)"></td></tr>
										<tr><td style="text-align:right;font-size:20px">Grand Total</td><td style="text-align:right"><div id="ittot6" style="font-size:20px;"><?php echo $row_vd1['qt_grandtotal'] ?></div><input type="text"  name="grandtotal" id="grandtotal" value="<?php echo $row_vd1['qt_grandtotal'] ?>" style="display:none;"></td></tr>
									</table>
									<?php
                              // $sql_usr="select * from admin where username='$user'";
							//   $res_usr=mysql_query($sql_usr);
							  // $row_usr=mysql_fetch_array($res_usr);
							  // $usremail=$row_usr['emailid'];
									$udetails =admindetails_byusername($_SESSION['login_user']);

									$usremail=$udetails[0]['emailid'];
									?>



									<div class="form-actions" style="background:none !important;">
										<button id="save" name="save" type="submit"  class="btn btn-primary">Save</button>
										<?php /*?><button <?php if($usremail==""){?> disabled <?php } ?> id="savensend" name="savensend" type="submit"  class="btn btn-primary">Save and Send PDF</button><?php */?>
										<button <?php if($usremail==""){?> disabled <?php } ?> id="emailwithpdf" name="emailwithpdf" type="submit"  class="btn btn-primary">Send Email with PDF</button>
										<button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>

									</div>

								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Main content end -->
				
				
			</div>
		</div></div>
		
	</body>

	
	</html>