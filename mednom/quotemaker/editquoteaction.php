<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
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
//echo  "jugal";	
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
//echo "jugal";
//exit(0);

			if(isset($_POST['selling_price'.$i])&& $_POST['selling_price'.$i]!= "")
			{
				//$qt_selling_price=mysql_real_escape_string($_POST['selling_price'.$i]);
$qt_selling_price=$_POST['selling_price'.$i];
			}
			else
			{
			$qt_selling_price=0;
			}

			//	if($qt_selling_price!=0)
				//{
					$sql_product="insert into quote_product (qt_refid,product_sku,product_name,product_desc,product_quantity,product_sellingprice,,product_spec_show) values ('$up_qt_refid','$qt_product_sku','$qt_product_name','$qt_product_desc','$qt_product_qty','$qt_selling_price','$qt_product_spec_show')";
					//$res_product=mysql_query($sql_product);
//echo $sql_product; 

insert_quote_product($up_qt_refid,$qt_product_sku,$qt_product_name,$qt_product_desc,$qt_product_qty,$qt_selling_price,$qt_product_spec_show);

//echo "jugal";
//exit(0);

				/*}
				else
				{
			]
					$correct=2;
					?>
<script type="text/javascript">
		alert("Some Error has occured, Please Try Again");
		history.go(-1);
		</script>
<?php
				}*/
			$i++;	
		}
		
		if($correct==2)
		{
		?>
		<script type="text/javascript">
		alert("Blank selling Price");
		history.go(-1);
		</script>
		<?php	
		}
		else
		{


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
	
	if($res_ua > 0){$correct=1;}
	
//}
?>
<script type="text/javascript">
					window.open('view_quote.php','_self');
					
		alert("Quote Updated Successfully");
window.open('view_quote.php','_self');
		//history.go(-1);

				</script>
<?php
	if($correct==1)
	{
		
		 if (isset($_POST['save'])) {
			 ?>
       			<script type="text/javascript">
					//window.open('view_quote.php','_self');
					
		//alert("Quote Updated Successfully");
window.open('view_quote.php','_self');
		//history.go(-1);

				</script>
    		<?php
            }
   		 elseif (isset($_POST['savensend'])) {
			 ?>
			 <script type="text/javascript">
				
				window.open('tcpdf/examples/index2.php?refid=<?php echo $qt_refid; ?>','_self');
			</script>
       <?php
    		}
			elseif (isset($_POST['emailwithpdf'])) {
			?>
            <script type="text/javascript">
				window.open('tcpdf/examples/index3.php?refid=<?php echo $qt_refid; ?>','_self');
			</script>
            <?php
			}

	}
	else
	{
?>
	<script type="text/javascript">
		alert("Quote Updated Successfully");
window.open('view_quote.php','_self');
		//history.go(-1);
		</script>
<?php
	}
		}
}
else
{
?>
		<script type="text/javascript">
		alert("Please Try Again");
		history.go(-1);
		</script>
<?php	
}
?>