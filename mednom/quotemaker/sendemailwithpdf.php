<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include  'lib/header.php' ;
$tax=0;
$a=1;

?><!-- PLUpload -->


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
<script type="text/javascript">

function OnAddcc()
{
	document.getElementById('addccid').style.display="block";
}
function OnAddBcc()
{
	document.getElementById('addBccid').style.display="block";
}
function Removecc()
{
	document.getElementById('addcc').value="";
	document.getElementById('addccid').style.display="none";
}
function RemoveBcc()
{
	document.getElementById('addBCC').value="";
	document.getElementById('addBccid').style.display="none";
}

</script>
	<div class="container-fluid" id="content">
			
		<div id="main">
			<?php 
				date_default_timezone_set("Asia/Calcutta");
				$dt=date('F d, Y');
				$week=date('l');
				$refid=$_REQUEST['refid'];
			?>
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>Send Email with PDF</h1>
					</div>
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
							<a href="#">Email Anyone</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
                
                <?php
				/*$sql_qt1="select * from quotations where qt_refid='$refid'";
				$res_qt1=mysql_query($sql_qt1);
				$row_qt1=mysql_fetch_array($res_qt1);*/
				$row_qt1 = get_quotedetail($refid);
				
				/*$sql_contacts="select * from quote_contacts where cont_id='".$row_qt1['qt_contacts']."'";
				$res_contacts=mysql_query($sql_contacts);
				$row_contacts=mysql_fetch_array($res_contacts);*/
				$row_contacts= contact_details($row_qt1['qt_contacts']);
				?>
                 <!-- Main content start -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3><i class="icon-th-list"></i> Email Anyone</h3>
							</div>
							<div class="box-content nopadding">
                            
                            <form action="sendemailwithpdfaction.php?refid=<?php echo $refid; ?>" enctype="multipart/form-data" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                            
                        
			      <?php /*var_dump($row_qt1); */?>
                                <div class="control-group">
                                            <label for="textfield" class="control-label">Email Address</label>
                                            <div class="controls">
                                                 <input type="text"  name="emailId" id="emailId" value="<?php echo $row_contacts['cont_primaryemail']; ?>" placeholder="Email" class="input-xlarge" data-rule-multiemail="true" data-rule-required="true">
                                            <a href="#" onClick="OnAddcc();">Addcc</a> | <a href="#" onClick="OnAddBcc();">AddBcc</a>
                                            </div>
                                </div>
                                
                                <div id="addccid" class="control-group" style="display:block;">
                                            <label for="textfield" class="control-label">Addcc</label>
                                            <div class="controls">
					      <?php $url = str_replace('www.', '',$_SERVER['HTTP_HOST']); ?>
                                                 <input type="text"  name="addcc" id="addcc" value="info@<?php echo $url ?>" placeholder="Addcc" class="input-xlarge" data-rule-multiemail="true" data-rule-required="true"> <a  href="#" onClick="Removecc();">del</a>
                                            </div>
                                </div>
                                
                                <div id="addBccid" class="control-group" style="display:none;">
                                            <label for="textfield" class="control-label">AddBcc</label>
                                            <div class="controls">
                                                 <input type="text"  name="addBCC" id="addBCC" value="" placeholder="addBCC" class="input-xlarge" data-rule-multiemail="true" data-rule-required="true"> <a href="#" onClick="RemoveBcc();">del</a>
                                            </div>
                                </div>
                                
                             	<div class="control-group">
                                            <label for="textfield" class="control-label">Email Subject</label>
                                            <div class="controls">
                                                 <input type="text"  name="subject" id="subject" placeholder="Subject" class="input-xlarge" value="<?php echo $row_qt1['qt_subject']; ?>" data-rule-required="true">
                                            </div>
                                </div>
				<?php
				$customer_name = $row_contacts['cont_firstname']." ".$row_contacts['cont_lastname'];
				$product_names = preg_replace('/,([^,]*)$/', ' and \1', $row_qt1['qt_desc']);
				$product_names_array = explode(",", $row_qt1['qt_desc']);
				//$catalog_links_array = array();
				//echo $product_names;
				foreach($product_names_array as $product_name){
				  if(!empty($product_name)){
				  	
				  	$sku = substr(trim($product_name), -7);
				  	$catalog_links_array[] = !empty(get_product_catalog_byname(trim($product_name))) ? get_product_catalog_byname(trim($product_name)) : get_product_catalog_bysku(trim($sku));
				  }
				}
				//var_dump($catalog_links_array);
				if (isset($catalog_links_array)){
				foreach($catalog_links_array as $array){
				  if(!empty($array)){
				    $cat_name = get_category_name_by_id($array[0]["category_id"]);
				    $cat_name = $cat_name[0]['name'];
				  $catalog_array[$cat_name] = $array[0]["catalog_url"];
				  }
				}
				$catalog_array = array_unique($catalog_array);
				$catalog = "<ul>";
				foreach($catalog_array as $key => $value){
				  $catalog .= "<li>".$key.": <a href='http://".$_SERVER['HTTP_HOST']."/".$value ."' data-mce-href='http://".$_SERVER['HTTP_HOST']."/".$value ."'>http://".$_SERVER['HTTP_HOST']."/".$value ."</a></li>";
				}
				$catalog .= "</ul>";
				}else {$catalog = " ";}
				//var_dump($catalog_array);
				$website = "http://".$_SERVER['HTTP_HOST'];
				$admin_details = find_admin_usersbyid($_SESSION['login_user']);
				
				$find_value = array('{{customer_name}}','{{product_names}}','{{catalog}}','{{admin_name}}','{{email}}','{{website}}');
				$replace_value = array($customer_name,$product_names,$catalog,$admin_details["full_name"],$admin_details["emailid"],$website);
				
				$message_temp = '<p>Dear {{customer_name}},</p>
				<p>Thank you for your recent inquiry, we really appreciate your interest in our product {{product_names}}.</p>
				<p>Please find attached a quotation for your consideration. For more details you can download the product catalog from this link</p>
				<p>{{catalog}}</p>
				<p>If you have any question or query, please do not hesitate to contact us.&nbsp;</p>
				<p>Best Regards,</p>
				<p>{{admin_name}}</p>
				<p>Product Specialist</p>
				<p>Email: <a href="mailto:{{email}}">{{email}}</a></p>
				<p>Website: <a href="{{website}}" data-mce-href="{{website}}">{{website}}</a></p>
				<p>&nbsp;</p>';				
				?>
				<?php
				$message_temp =  str_replace($find_value,$replace_value,$message_temp);
				?>
                                
                                <div class="control-group" id="dmessages" style="display:block;">
										<label for="textarea" class="control-label">Message</label>
										<div class="controls">
											<textarea name="content" id="elm1" rows="5" class="input-block-level"><?php echo $message_temp; ?></textarea>
										</div>
								</div>
                                
                              
                               
                               <?php 
					/*		   $sql_c1="select * from quote_product where qt_refid='$refid'";
							   $res_c1=mysql_query($sql_c1);
							   $catlog_name="";
							   $temp = get_quoteproducts($refid);
							   foreach($temp as $row_c1)
							  while($row_c1=mysql_fetch_array($res_c1))
							   {
								   $sql_c2="select id from product_product where sku='".$row_c1['product_sku']."'";
								   $res_c2=mysql_query($sql_c2);
								   $row_c2=mysql_fetch_array($res_c2);
								   //echo $row_c2['id'];
								   
								   $sql_c3="SELECT category_id FROM product_productcategory WHERE product_id='".$row_c2['id']."'";
								   $res_c3=mysql_query($sql_c3);
								   $row_c3=mysql_fetch_array($res_c3);
								   //echo $row_c3['category_id'];
								   
								   $sql_c4="select * from product_category where id='".$row_c3['category_id']."'";
								   $res_c4=mysql_query($sql_c4);
								   $row_c4=mysql_fetch_array($res_c4);
								   $catlog = $row_c4['slug'];
								   $catlog_name= $row_c4['name'];
							 
							   }
							   */
							   
							  
							   ?>
                               
                                
                                
                                <div class="control-group">
										<label for="textarea" class="control-label">Attachment</label>
										<div class="controls">
										<input type="file" name="mzAttach" id="mzAttach" value="" class="input-block-level" />
                                        <a target="new" href="tcpdf/examples/savedpdf/<?php echo $refid.".pdf" ?>"><?php echo $refid.".pdf" ?></a>
										</div>
								</div>
                                
                       <!-- <div class="control-group">
										<label for="textarea" class="control-label">Catalogs</label>
										<div class="controls">
                                        <?php
										$sql_ct="select * from quote_product where qt_refid='$refid' group by product_catalog";
										$res_ct=mysqli_query($sql_ct);
										while($row_ct=mysqli_fetch_array($res_ct))
										{
										?>
                                        <a target="new" href="../../catalog/<?php echo $row_ct['product_catalog'].".pdf" ?>"><?php echo $row_ct['product_catalog'].".pdf" ?></a>,
										<?php
                                        }
										?>
										</div>
								</div>-->
                                
                                <div class="control-group">
										<label for="textarea" class="control-label">Multi - Attachments</label>
										<div class="controls">
										<input type="file" name="files[]" multiple/>
                                      </div>
								</div>
                                
                               
                                
                                <div class="form-actions">
										<button type="submit" class="btn btn-primary">Save and Send</button>
										<button type="button" onClick="window.history.back()" class="btn">Cancel</button>
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
