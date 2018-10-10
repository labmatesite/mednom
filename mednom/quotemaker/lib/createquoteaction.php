<?php
session_start();
if (isset($_POST['save']) || isset($_POST['savensend']) || isset($_POST['emailwithpdf']))
{
//include('../connection2.php');
include_once 'lib/dbfunctionjugal.php';

	date_default_timezone_set('Asia/Kolkata'); // calculate date
	$todaydt = date("Y-m-d H:i:s");
	$curmonth = date("m");
	$curyear = date("y");

	$sql_crn="select * from crn order by crn_id desc limit 0,1"; // fetch crn no and  update by 1
	//$res_crn=mysql_query($sql_crn);
	$row_crn=mysql_fetch_array($res_crn);
	$qt_stseq=$row_crn['crn_stseq'] + 1; 
	$temp_mon=substr($row_crn['crn_prefix'],-4,2);

	if($curmonth!=$temp_mon) // if month is not equals to current month
	{
		$temp_prefix=substr($row_crn['crn_prefix'],0,-4);
		$qt_refid=$temp_prefix.$curmonth.$curyear.$qt_stseq;
		$up_refid=$temp_prefix.$curmonth.$curyear;
	}
	else
	{
		$qt_refid=$row_crn['crn_prefix'].$qt_stseq;
		$up_refid=$row_crn['crn_prefix'];
	}
	
 

$i=1;
$correct=0;

		while($i<=$_POST['numoftxt'])	
		{
			$qt_product_sku=$_POST['prod_sku'.$i];
			if(isset($_POST['prod_spec_show'.$i]) && $_POST['prod_spec_show'.$i]!="")
			{
				$qt_product_spec_show="yes";
			}
			else
			{
				$qt_product_spec_show="no";
			}
			$qt_product_name=$_POST['prod_fullname'.$i];
			$qt_product_catalog=$_POST['prod_catalog'.$i];
			$qt_product_desc=mysql_real_escape_string($_POST['product_desc'.$i]);
			$qt_product_qty=mysql_real_escape_string($_POST['quantity'.$i]);
			if(isset($_POST['selling_price'.$i])&& $_POST['selling_price'.$i]!= "")
			{
				$qt_selling_price=mysql_real_escape_string($_POST['selling_price'.$i]);
			}
			else
			{
			$qt_selling_price=0;
			}

				if($qt_selling_price!=0)
				{
					$sql_product="insert into quote_product (qt_refid,product_sku,product_name,product_desc,product_quantity,product_sellingprice,product_catalog,product_spec_show) values ('$qt_refid','$qt_product_sku','$qt_product_name','$qt_product_desc','$qt_product_qty','$qt_selling_price','$qt_product_catalog','$qt_product_spec_show')";
					//$res_product=mysql_query($sql_product);
				}
				else
				{
					$sql_product1="delete from quote_product where qt_refid='$qt_refid'";
				//	$res_product1=mysql_query($sql_product1);
					$correct=2;
				}
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

$sql_tx1="select * from tax_cal order by tax_id";
//$res_tx1=mysql_query($sql_tx1);
while($row_tx1=mysql_fetch_array($res_tx1))
{
	$tax_id=$row_tx1['tax_id'];
	$qt_taxname=$row_tx1['tax_name'];
	$qt_taxvalue=$row_tx1['tax_value'];
	
	if (isset($_POST['st'.$tax_id])) 
	{
	$sql_tx2="insert into quote_tax (qt_refid,qt_taxname,qt_taxvalue,qt_taxdt) values ('$qt_refid','$qt_taxname','$qt_taxvalue','$todaydt')";
	//$res_tx2=mysql_query($sql_tx2);
	} 		
}

	$qt_subject=mysql_real_escape_string($_POST['qt_subject']);
	$qt_organisationid=mysql_real_escape_string($_POST['qt_organisationid']);
	$qt_contacts=mysql_real_escape_string($_POST['qt_contacts']);
	$qt_addinfo=mysql_real_escape_string($_POST['qt_addinfo']);
	/*$qt_orgid=mysql_real_escape_string($_POST['qt_orgid']);
	*/$qt_tnc=mysql_real_escape_string($_POST['content1']);
	/*$qt_desc=mysql_real_escape_string($_POST['content2']);
	*/$qt_cur=mysql_real_escape_string($_POST['qt_cur']);

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
	
	$qt_itemtotal=mysql_real_escape_string($_POST['qt_itemtotal']);
	$qt_discount=mysql_real_escape_string($_POST['qt_discount']);
	$qt_discounttype=mysql_real_escape_string($_POST['discount_final']);



	if($qt_discounttype=="r_perprice")
	{
	$qt_discountpercent=mysql_real_escape_string($_POST['per_price']);
	}
	elseif($qt_discounttype=="r_dpr")
	{
	$qt_discountpercent="dpr";
	}
	else
	{
	$qt_discountpercent="zero";
	}

	$qt_shipping_charges=mysql_real_escape_string($_POST['shippin_charges']);
	$qt_pretax_total=mysql_real_escape_string($_POST['pretaxtotal']);
	$qt_tax=mysql_real_escape_string($_POST['tax_total']);
	$qt_adjustment=mysql_real_escape_string($_POST['group1']);
	
	if($qt_adjustment=="add")
	{
		$qt_adj_add=mysql_real_escape_string($_POST['adjustment']);
		$qt_adj_sub="";
	}
	elseif($qt_adjustment=="subtract")
	{
		$qt_adj_add="";
		$qt_adj_sub=mysql_real_escape_string($_POST['adjustment']);
	}
	
	$qt_grandtotal=mysql_real_escape_string($_POST['grandtotal']);
	$qt_createdby=$_SESSION['user1'];
	$qt_createddt=$todaydt;
	$qt_updateddt="";
	$qt_updatedby="";
	$ipaddress = '';
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	if($qt_organisationid=='-1')
	{
		//echo "great";
		mysql_query("insert into quote_organisation set org_name ='".mysql_real_escape_string($_POST['myorgname'])."'");
	}
	
	if($qt_contacts=='-1')
	{
	mysql_query("insert into quote_contacts set cont_sal ='".mysql_real_escape_string($_POST['myorgname'])."',cont_sal ='".mysql_real_escape_string($_POST['myorgname'])."',cont_sal ='".mysql_real_escape_string($_POST['myorgname'])."'");
	}
	

$sql_or="select org_name from quote_organisation where org_id='".$qt_organisationid."'";
$res_or=mysql_query($sql_or);
$row_or=mysql_fetch_array($res_or);



$qt_refid1="<a href='#'>".$qt_subject." - ".$qt_refid."</a>";
$qt_refid2=$qt_refid1." for <span style=color:#4285F4>".$row_or['org_name']."</span> with an amount of <span style=color:#4285F4><strong>".$qt_cur1.$qt_grandtotal."</strong></span>";
$qt_refid2=str_replace("'","&#146;",$qt_refid2);




$sql_qt="insert into quotations (qt_organisationid,qt_contacts,qt_subject,qt_refid,qt_tnc,qt_addinfo,qt_currency,qt_itemtotal,qt_discount,qt_discountpercent,qt_shipping_charges,qt_pretax_total,qt_tax,qt_adj_add,qt_adj_sub,qt_grandtotal,qt_createdby,qt_createddt,qt_updatedby,qt_updateddt) values ('$qt_organisationid','$qt_contacts','$qt_subject','$qt_refid','$qt_tnc','$qt_addinfo','$qt_cur','$qt_itemtotal','$qt_discount','$qt_discountpercent','$qt_shipping_charges','$qt_pretax_total','$qt_tax','$qt_adj_add','$qt_adj_sub','$qt_grandtotal','$qt_createdby','$qt_createddt','$qt_updatedby','$qt_updateddt')";
//$res_qt=mysql_query($sql_qt);
if($res_qt)
{
	$sql_crn1="update crn set crn_stseq ='$qt_stseq',crn_prefix='$up_refid',crn_updatedby='$qt_createdby',crn_updatedt='$todaydt' where crn_id='".$row_crn['crn_id']."'";
	//$res_crn1=mysql_query($sql_crn1);
	
	$sql_ua = "insert into quote_contactactivity (ca_userid,ca_activity,ca_activity_details,ca_dbtype,ca_date) values ('$qt_createdby','Created','$qt_refid2','Quotation','$qt_createddt')";
//	$res_ua=mysql_query($sql_ua);
	
	if($res_ua)
	{
		$correct=1;
	}
}
?>
<?php
	if($correct==1)
	{
		 if (isset($_POST['save'])) {
			 ?>
       			<script type="text/javascript">
					window.open('view_quote.php','_self');
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
	   ?>
<?php
	}
	else
	{
?>
		<script type="text/javascript">
		alert("Cannot add . Please Try Again");
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
		//history.go(-1);
		</script>
<?php	
}

?>