<?php
session_start();
if(!isset($_SESSION['login_user'])){	
header('Location:index.php');
}else{
	include_once 'lib/header.php';
        include_once 'lib/dbfunctionjugal.php';

	// echo $_SESSION['login_user'];
}


$refid=$_REQUEST['id'];

/*$sql_vd1="select * from quotations where qt_refid='$refid'";
$res_vd1=mysql_query($sql_vd1);
$row_vd1=mysql_fetch_array($res_vd1);
*/

$row_vd1 = get_quotedetail($refid);
//var_dump($row_vd1);
$quote_products = get_quoteproducts($refid);
$cont = count($quote_products);


$tax=0;
$a=1;
$row_tax = select_taxes();
foreach($row_tax as $row_tax1)
{
$tax=$tax+$row_tax1['tax_value'];	

}
/*$tax=0;
$sql_tax1="select * from tax_cal where tax_status='active'";
$res_tax1=mysql_query($sql_tax1);
$a=1;
while($row_tax1=mysql_fetch_array($res_tax1))
{
 $tax=$tax+$row_tax1['tax_value'];	
}
$a++;*/
?>

<!doctype html>
<html>

<head>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- PageGuide -->
	<link rel="stylesheet" href="css/plugins/pageguide/pageguide.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- Datepicker -->
	<link rel="stylesheet" href="css/plugins/datepicker/datepicker.css">
    <!-- select2 -->
	<link rel="stylesheet" href="css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">
    	<!-- Plupload -->
	<link rel="stylesheet" href="css/plugins/plupload/jquery.plupload.queue.css">
    <!-- XEditable -->
	<link rel="stylesheet" href="css/plugins/xeditable/bootstrap-editable.css">




	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- Nice Scroll -->
	<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.draggable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
	<!-- Touch enable for jquery UI -->
	<script src="js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
	<!-- slimScroll -->
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- vmap -->
	<script src="js/plugins/vmap/jquery.vmap.min.js"></script>
	<script src="js/plugins/vmap/jquery.vmap.world.js"></script>
	<script src="js/plugins/vmap/jquery.vmap.sampledata.js"></script>
	<!-- Bootbox -->
	<script src="js/plugins/bootbox/jquery.bootbox.js"></script>
	<!-- Flot -->
	<script src="js/plugins/flot/jquery.flot.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.bar.order.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.resize.min.js"></script>
	<!-- imagesLoaded -->
	<script src="js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- PageGuide -->
	<script src="js/plugins/pageguide/jquery.pageguide.js"></script>
	<!-- FullCalendar -->
	<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<!-- Chosen -->
	<script src="js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>
	<!-- Validation -->
	<script src="js/plugins/validation/jquery.validate.min.js"></script>
	<script src="js/plugins/validation/additional-methods.min.js"></script>
	<!-- Theme framework -->
	<script src="js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="js/demonstration.min.js"></script>
    
    	<!-- PLUpload -->
	<script src="js/plugins/plupload/plupload.full.js"></script>
	<script src="js/plugins/plupload/jquery.plupload.queue.js"></script>
	<!-- Custom file upload -->
	<script src="js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
    <!-- Datepicker -->
	<script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- XEditable -->
	<script src="js/plugins/momentjs/jquery.moment.js"></script>
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
	<script src="js/plugins/xeditable/bootstrap-editable.min.js"></script>
	<script src="js/plugins/xeditable/demo.js"></script>
	<script src="js/plugins/xeditable/address.js"></script>
<script type="text/javascript">
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}
document.onkeypress = stopRKey;
</script> 
    
<script type="text/javascript">
function loadingImg()
{
	jquery("#loadingImg").show();
}
</script>

    
<script src="tinymce/tinymce.min.js" type="text/javascript"></script>
    
<script>
tinymce.init({
	
	
	
    selector: "textarea#elm1,textarea#elm2",
    theme: "modern",
    width: "100%",
    height: 300,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 });

</script>




	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

</head>
<body onLoad="" class="theme-red" data-theme="theme-red">
	<input type="text"  name="hid_tx"  id="hid_tx" value="<?php echo $tax; ?>" style="display:none;">
    <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
		Total After Discount = <?php echo $row_vd1['qt_itemtotal']; ?><br>
        Tax = 	 <?php echo $row_vd1['qt_tax']; ?><br><br>
        Total Tax Amount =<?php echo $row_vd1['qt_tax']; ?>
        </div>
        <div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
		
	</div>
	
<!--	<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">Admin Panel</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
			
            
            <?php
            include('admin_menu.php');

			?>-->
            
            <!-- main menu -->
			<div class="user">
				<div class="dropdown asdf">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo @$_SESSION['user1'] ?> </a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="crm_settings.php">CRM Settings</a>
						</li>
						<li>
							<a href="logout.php">Sign out</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="content">
			
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>View Quotation Details</h1>
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
							<a href="#">View Quotation Details</a>
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
								<h3><i class="icon-th-list"></i>View Quotation Details</h3>
							</div>
							<div class="box-content nopadding">
								<form  method="POST" action="#" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb"><input type="text"  name="numoftxt"  id="numoftxt" value="" style="display:none;"><input type="text"  name="qt_itemtotal"  id="qt_itemtotal" value="" style="display:none;">
                                                        <div  class="control-group divhalf">
                                                            <label for="textfield" class="control-label">Organisation</label>
                                                            <div class="controls">
                                                 <?php
                                                 if($row_vd1['qt_organisationid']==0)
                                                 {
                                                  echo "<label>Individual</label>";
                                                 }
                                                 else
                                                 {
                                                $quoteorg = get_organisation_byid($row_vd1['qt_organisationid']);
						 echo "<label>".ucwords($quoteorg['org_name'])."</label>";
                                                 }
					// $sql_sec3="select * from quote_organisation where org_id='".$row_vd1['qt_organisationid']."' order by org_name";
												// $res_sec3=mysql_query($sql_sec3);
												// $row_sec3=mysql_fetch_array($res_sec3);
												
												  ?>
                                           
                                                 
                                                 </div>
                                                        </div>
                                                        <div class="control-group divhalf">
                                                            <label for="textfield" class="control-label">Contacts</label>
                                                            <div class="controls">
                                                 
                                                 <?php
                                                 $row_sec3 = contact_details($row_vd1['qt_contacts']);
												// $sql_sec3="select * from quote_contacts where cont_id='".$row_vd1['qt_contacts']."'";
												// $res_sec3=mysql_query($sql_sec3);
												// $row_sec3=mysql_fetch_array($res_sec3);
												 	echo "<label>".ucwords($row_sec3['cont_firstname']." ".$row_sec3['cont_lastname'])."</label>";
												  ?>
                                             </select>
                                                 
                                                 
                                                 </div>
                                                            
                                                        </div>
                                                         <div style="clear:both;"></div>
                                                         <div  class="control-group divhalf">
                                                            <label for="textfield" class="control-label">Additional info</label>
                                                            <div class="controls">
                                                 			<?php echo $row_vd1['qt_addinfo']; ?>
                                                        </div> 
                                                        </div>
                                                         <!-- qt orgid-->
                                                     	 <!-- qt tnc-->
                                            			<!--<div class="control-group">
										<label for="textarea" class="control-label">Description details</label>
										<div class="controls">
											<textarea name="content2" id="elm" rows="5" class="input-block-level"></textarea>
										</div>
								</div>-->
                                <table class="table table-hover table-nomargin dataTable table-bordered authors-list">
									<thead>
                                    	<tr>
                                       		<th colspan="3">Item Details</th>
                                            <th>Currency   
                                                 <label > <?php if($row_vd1['qt_currency']=="inr"){?>India, Rupees (₹) <?php } ?></label>
                                                 <label > <?php if($row_vd1['qt_currency']=="dollar"){?>USA, Dollar ($)<?php } ?></label>
                                                 <label > <?php if($row_vd1['qt_currency']=="pounds"){?>UK, Pounds (£)<?php } ?></label>
                                                 </th>
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
									//$sql_vd2="select * from quote_product where qt_refid='$refid'";
									//$res_vd2=mysql_query($sql_vd2);
									$y=1;
$qprod = get_quoteproducts($refid);
									//while($row_vd2=mysql_fetch_array($res_vd2))
									foreach($qprod as $row_vd2)
									{
									?>
     									<tr>
                                       		<th></th>
                                            <th>
                                          <div class="control-group">
                                         
	                                            <div class="controls">
    		                                    <label><strong><?php echo $row_vd2['product_name']; ?></strong></label>
                                             
                                             <label><?php echo nl2br($row_vd2['product_desc']); ?></label>
                                             <?php
											 if($row_vd2['product_catalog']!="No Catalog Found")
											 {
											 ?>
                                              Catalog :<a target="new" href="../../catalog/<?php echo $row_vd2['product_catalog'].".pdf"; ?>"><?php echo $row_vd2['product_catalog'].".pdf"; ?></a>
                                             <?php
											 }
											 
											 ?>
                                             <br><input type="checkbox" id="prod_spec_show<?php echo $y; ?>" name="prod_spec_show<?php echo $y; ?>" disabled <?php if($row_vd2['product_spec_show']=="yes"){?> checked="checked" <?php } ?>  /> Show Specification
											<?php
											  $sp=str_replace(',', '', $row_vd2['product_sellingprice']);
											 	   $totsp=$sp * $row_vd2['product_quantity'];
											  ?>
                                             
                                             </div>
                                	</div></th>
											<th><label><?php echo $row_vd2['product_quantity']; ?></label></th>
                                            <th><div><label><?php echo number_format($sp, 2, '.', ','); ?></label></div><div>(-) Discount : </div><div>Total After Discount : </div></th>
                                            <th><label><?php echo number_format($totsp, 2, '.', ','); ?></label><label >0</label><label><?php echo number_format($totsp, 2, '.', ','); ?></label></th>
                                         	<th><label><?php echo number_format($totsp, 2, '.', ','); ?></label></th>
										</tr>
                                      <?php
									  $y++;
									}
									
									//$sql_tx1="select * from quote_tax where qt_refid='$refid'";
									//$res_tx1=mysql_query($sql_tx1);
									$res_tx1 = quote_taxes_forquote($refid);
									$strTax1="";
									foreach($res_tx1 as $row_tx1)
									{
									$strTax1 .= '<span>'.$row_tx1['qt_taxname'].'('.$row_tx1['qt_taxvalue'].') (%) </span>';
	
									} ?>
									
									</tbody>
								</table>
                                
                                <table class="table table-hover table-nomargin dataTable table-bordered">
                                <tr><td style="text-align:right">Items Total</td><td style="text-align:right"><label><?php echo $row_vd1['qt_itemtotal']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(-)Discount</strong> <?php if($row_vd1['qt_discountpercent']!="" && $row_vd1['qt_discountpercent']!=0){ echo "(".$row_vd1['qt_discountpercent']."%)"; }?></td><td style="text-align:right"><label><?php echo $row_vd1['qt_discount']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(+) Shipping & Handling Charges</strong> </td><td style="text-align:right"><label><?php echo $row_vd1['qt_shipping_charges']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(+) Bank Charges</strong> </td><td style="text-align:right"><label>30.00</label></td></tr>
                                <tr><td style="text-align:right">Pre Tax Total</td><td style="text-align:right"><label><?php echo $row_vd1['qt_pretax_total']; ?></label></td></tr>
                                <tr><td style="text-align:right"><?php echo $strTax1; ?><a href="#modal-1" role="button" class="btn" data-toggle="modal" onClick="taxval();"><strong style="color:#56AF45">(+)Tax</strong></a></td><td style="text-align:right"><label><?php echo $row_vd1['qt_tax']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td><td style="text-align:right"><div id="ittot5">0.00</div></td></tr>
                                <tr><td style="text-align:right">Adjustment
</td><td style="text-align:right"><label><?php if($row_vd1['qt_adj_add']!=""){ echo $row_vd1['qt_adj_add'];}elseif($row_vd1['qt_adj_sub']!=""){echo $row_vd1['qt_adj_sub'];}else{ echo "0";} ?></label></td></tr>
                                <tr><td style="text-align:right;font-size:20px">Grand Total</td><td style="text-align:right"><label><?php echo $row_vd1['qt_grandtotal']; ?></label></td></tr>
                                </table>
                                                        <div class="control-group">
										<label for="textarea" class="control-label">Terms &amp; Conditions</label>
										<div class="controls">
											<label><?php echo $row_vd1['qt_tnc'];?></label>
										</div>
								</div>              	
                                                        <div class="form-actions" style="background:none !important;">
                                                     
                                                            
                                                        </div>
                                                    
                                                    </form>
                                                    <?php
                              /* $sql_usr="select * from admin where username='$user'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_array($res_usr);
$usremail=$row_usr['emailid'];*/
 $udetails =admindetails_byusername($_SESSION['login_user']);

$usremail=$udetails[0]['emailid'];
?> 
													<a href="edit_quote.php?id=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Edit</button></a>
                                                    <a  href="tcpdf/examples/index.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Save As PDF</button></a>
                            						<!--<a  href="tcpdf/examples/index4.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">UK Invoice</button></a>-->
                            						<a  href="invoice_edit.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Invoice</button></a>
                            						
                            						<a  href="tcpdf/examples/index6.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">UAE Invoice</button></a>
                            						<a  href="tcpdf/examples/index5.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Print Invoice</button></a>
                            						<a  href="tcpdf/examples/index10.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Print Quotation</button></a>
                                                    <a  href="tcpdf/examples/index3.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button <?php if($usremail==""){?> disabled <?php } ?> class="btn btn-primary">Send Email with PDF</button></a>
                                                    <button id="reset" type="button" class="btn" onClick="window.history.back()" >Close</button>
                                                    <br><br>
							</div> 
						</div>
					</div>
				</div>
                
                <!-- Main content end -->
				
				
			</div>
		</div></div>
		
	</body>


	
</html>