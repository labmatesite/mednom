<?php
date_default_timezone_set("Asia/Kolkata");
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
$userid=$_SESSION['login_user'];
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');
$ref_no=$_GET['refid'];
if(isset($_POST['mydata']))
{

$temp2 = trim($_POST['mydata']);
$quid = save_edited_quote($ref_no,$userid,$temp_dt,$temp2);
if($_POST['type']=='save')
{
header("location:tcpdf/examples/generatepdf.php?refid=$quid");
}
if($_POST['type']=='email')
{
header("location:tcpdf/examples/generatepdf.php?refid=$quid&idm='email'");
}
}
header('Content-Type: text/html; charset=utf-8');
include  'lib/header.php' ;
//$temp_dt=date('d F Y');

//$ref_no=$_GET['refid'];



//include('../../../connection2.php');
//$userid=$_SESSION['user1'];

// echo $userid;
//$sql_usr="select * from admin where username='$userid'";
//$res_usr=mysql_query($sql_usr);
//$row_usr=mysql_fetch_array($res_usr);
$row_usr= admindetails_byusername($userid);
//var_dump($row_usr);
//$usremail=$row_usr['emailid'];
//$host=$row_usr['host'];
//$portno=$row_usr['port'];
$ipaddress = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];


//$sql_pd1="select * from quote_product where qt_refid='$ref_no'";
//$res_pd1=mysql_query($sql_pd1);
//$tot_pd1=mysql_num_rows($res_pd1);
$res_pd1 = get_quoteproducts($ref_no);
//var_dump($res_pd1);
$tot_pd1=count($res_pd1);
$strOutput="";
//get_quotedetail($refid)

if($tot_pd1>=1)
{

//while($row_pd1=mysql_fetch_array($res_pd1))
foreach($res_pd1 as $row_pd1)
{
$sp=str_replace(',', '', $row_pd1['product_sellingprice']);
 $totsp=$sp * $row_pd1['product_quantity'];
 $product_desc=str_replace('<br>','\n',$row_pd1['product_desc']);
// $product_desc1=htmlspecialchars($product_desc);
$product_desc1=$product_desc;
 //$product_desc2=str_replace('\n','<br>',$product_desc1);
$product_desc2=$product_desc1;
 if($row_pd1['product_spec_show']=="yes")
 {
	$product_desc3 = nl2br($product_desc2);
 }
 else
 {
	 $product_desc3="";
 }

/*$strOutput .= '<tr nobr="true">
      <td nobr="true" width="50%" valign="top"><p align="center" contenteditable="true"><strong>Description</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p><strong contenteditable="true">Unit Price (Rs.)</strong></p></td>
      <td nobr="true" width="10%" valign="top"><p align="center" contenteditable="true"><strong>QTY</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p contenteditable="true"><strong>Total Price (Rs.)</strong></p></td>
    </tr>';*/
$strOutput .='<tr nobr="true">
      <td nobr="true" width="50%" valign="top"><div style="padding:10px;" contenteditable="true"><strong>'.$row_pd1['product_name'].'</strong><br><table><tr nobr="true"><td nobr="true" style="padding:10px;  font-family:Helvetica;line-height: 1.8;  ">'.utf8_decode(trim($product_desc3)).'</td></tr></table></div></td>
      <td nobr="true" width="20%" valign="top"><p align="right" contenteditable="true">'.number_format($sp, 2, '.', ',').'</p></td>
      <td nobr="true" width="10%" valign="top"><p align="center" contenteditable="true">'.$row_pd1['product_quantity']. '</p></td>
      <td nobr="true" width="20%" valign="top"><p align="right" contenteditable="true">'.number_format($totsp, 2, '.', ','). '</p></td>
    </tr>';	
}
}




//$sql_qt1="select * from quotations where qt_refid='$ref_no'";
//$res_qt1=mysql_query($sql_qt1);
//$row_qt1=mysql_fetch_array($res_qt1);
$row_qt1=get_quotedetail($ref_no);

if($row_qt1['qt_tax']!="" && $row_qt1['qt_tax']!=0.00)
{
//$sql_tax1="select * from quote_tax where qt_refid='$ref_no'";
//$res_tax1=mysql_query($sql_tax1);
$strTax1="";
$strTax2="";	
$res_tax1 = quote_taxes_forquote($ref_no);

	//while($row_tax1=mysql_fetch_array($res_tax1))
	//var_dump($res_tax1);
	foreach($res_tax1 as $row_tax1)
	{
	$strTax1 .= '<span>'.$row_tax1['qt_taxname'].'('.$row_tax1['qt_taxvalue'].') (%) </span>';
	}
	
	$strTax2 .='<tr nobr="true">
      <td nobr="true"  colspan="3" valign="top"><p align="center">'.$strTax1.'  </p></td>
      <td nobr="true"  valign="top"><p align="right">'.$row_qt1['qt_tax'].'  </p></td>
    </tr>';
}
else
{
	$strTax2='';
}



$strDiscountper="";
 if($row_qt1['qt_discountpercent']!="" && $row_qt1['qt_discountpercent']!=0)
 {
	  $strDiscountper="(".$row_qt1['qt_discountpercent']."%)"; 
 }
 else
 {
	$strDiscountper=''; 
 }

$strDiscount="";
if($row_qt1['qt_discount']!="" && $row_qt1['qt_discount']!="0.00"){
	 $strDiscount='<tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center">Discount '.$strDiscountper.' </p></td>
      <td nobr="true"  valign="top"><p align="right">'.$row_qt1['qt_discount'].'  </p></td>
    </tr>';
}
else
{
	$strDiscount='';
}

$currency=trim($row_qt1['qt_currency']);


if($currency=="dollar")
{
	$qt_currency="(USD $)";
}
elseif($currency=="pounds")
{
	$qt_currency="(£)";
}
else
{
	$qt_currency="(Rs)";	
}

//$sql_contacts="select * from quote_contacts where cont_id='".$row_qt1['qt_contacts']."'";
//$res_contacts=mysql_query($sql_contacts);
//$row_contacts=mysql_fetch_array($res_contacts);
$row_contacts=contact_details($row_qt1['qt_contacts']);

//$sql_org="select * from quote_organisation where org_id='".$row_qt1['qt_organisationid']."'";
//$res_org=mysql_query($sql_org);
//$row_org=mysql_fetch_array($res_org);
$row_org=get_organisation_byid($row_qt1['qt_organisationid']);
$strOrg='';
//var_dump($row_org);
if(isset($row_org['org_name']))
{
if($row_org['org_name']=="")
	{
	}
	else
	{
		$strOrg.=trim($row_org['org_name']).'<br>';	
	}
}
//echo $row_org['org_billingadd'];
if(isset($row_org['org_billingadd'])){
	if($row_org['org_billingadd']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingadd'].'<br>';	
	}
	}
	if(isset($row_org['org_billingcity'])){
	if($row_org['org_billingcity']=="")
	{
	}

	else
	{
		$strOrg.=$row_org['org_billingcity'].'<br>';	
	}
	}
if(isset($row_org['org_billingpoc'])){
if($row_org['org_billingpoc']=="")
	{
	}
	else
	{
		$strOrg.='-'.$row_org['org_billingpoc'].'<br>';	
	}
}
if(isset($row_org['org_billingstate'])){
	if($row_org['org_billingstate']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingstate'].'<br>';	
	}
}

if(isset($row_org['org_billingcountry'])){
	if($row_org['org_billingcountry']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingcountry'].'<br>';	
	}
}
	
//to be changed later
//$sql_sd="insert into quote_savedlogs (sd_userid,sd_subject,sd_qt_refid,sd_date,sd_ipaddress) values ('$userid','".$row_qt1['qt_subject']."','$ref_no','$dt','$ipaddress')";
//$res_sd=mysql_query($sql_sd);


//============================================================+
// File name   : example_039.php
// Begin       : 2008-10-16
// Last Update : 2013-05-14
//
// Description : Example 039 for TCPDF class
//               HTML justification
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML justification
 * @author Nicola Asuni
 * @since 2008-10-18
 */

// Include the main TCPDF library (search for installation path).
$contac ='';
if($row_contacts['cont_sal']!='')
{
$contac .=ucwords(trim($row_contacts['cont_sal']))." ";
}
if($row_contacts['cont_firstname']!='')
{
$contac .=ucwords(trim($row_contacts['cont_firstname']))."&nbsp;&nbsp;";
}
if($row_contacts['cont_lastname']!='')
{
$contac .=ucwords(trim($row_contacts['cont_lastname']));
}
if($row_qt1['qt_organisationid']==0)
{
$contac .="<br>".ucwords(trim($row_contacts['cont_mailingadd']));
}

// create some HTML content
$html = '<div id="datatosave" class="datatosave"><div style="font-size:17px;"><hr><div align="center" contenteditable="true"><strong>Proforma Invoice</strong><hr></div></div><br><table><tr nobr="true"><td nobr="true" width="50%"><p contenteditable="true"><strong>To,<br>'.$contac.'</strong><br />'.$strOrg.'</p></td><td nobr="true" align="right" valign="top"><p contenteditable="true"><strong>Invoice No: '.$ref_no.'</strong><br><strong>Date</strong><strong>:'.$temp_dt.'</strong></p></td></tr></table>
<div style="clear:both"></div><table border="1" cellspacing="0" cellpadding="2" width="100%" contenteditable="true" nobr="true"><thead><tr nobr="true">
      <td nobr="true" width="50%" valign="top"><p align="center" contenteditable="true"><strong>Description</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p align="center" contenteditable="true"><strong>Unit Price'.$qt_currency.'</strong></p></td>
      <td nobr="true" width="10%" valign="top"><p align="center" contenteditable="true"><strong>QTY</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p align="center" contenteditable="true"><strong>Total Price'.$qt_currency.'</strong></p></td>
    </tr></thead>'.utf8_encode($strOutput).'
    <tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center" contenteditable="true">Price</p></td>
      <td nobr="true"  valign="top"><p align="right" contenteditable="true">'.$row_qt1['qt_itemtotal'].'</p></td>
    </tr>'.$strDiscount.$strTax2.'
    
    <tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center" contenteditable="true">Packing, Forwarding &amp; Shipping Charges</p></td>
      <td nobr="true"  valign="top"><p align="right">'.$row_qt1['qt_shipping_charges'].'</p></td>
    </tr>
    <tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center" contenteditable="true">Bank Charges</p></td>
      <td nobr="true"  valign="top"><p align="right">30.00</p></td>
    </tr>
    <tr nobr="true">
      <td nobr="true"  colspan="3" valign="top"><p align="center"><strong>GRAND TOTAL'.$qt_currency.'</strong></p></td>
      <td nobr="true"  valign="top"><p align="right"><strong>'.$row_qt1['qt_grandtotal'].'</strong></p></td>
    </tr>
  </table><div contenteditable="true"><p><strong>Terms and Conditions</strong></p>'.trim($row_qt1['qt_tnc']).'</div></div>';

// set UTF-8 Unicode font

// output the HTML content
$html1='<table border="1" cellpadding="2" cellspacing="2">
<thead>
 <tr style="background-color:#FFFF00;color:#0000FF;">
  <td width="30" align="center"><b>A</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
 <tr style="background-color:#FF0000;color:#FFFF00;">
  <td width="30" align="center"><b>B</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
</thead>
 <tr>
  <td width="30" align="center">1.</td>
  <td width="140" rowspan="6">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center" rowspan="3">2.</td>
  <td width="140" rowspan="3">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80" rowspan="2" >RRRRRR<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">3.</td>
  <td width="140">XXXX1<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">4.</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>8
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>';
echo $html;

//$pdf->writeHTML($html1, true, 0, true, 0);
//$pdf->writeHTML($html1, true, 0, true, 0);
// reset pointer to the last page
//$pdf->Image('images/Labocon-Stamp-and-Signatutre.png', '148', '210', '', '', '', '', '', false, 300, '', false, false,'', false, false, false);




// ---------------------------------------------------------
//ob_end_clean();
//Close and output PDF document
//$pdf->Output($ref_no.'.pdf', 'D');
//$pdf->Output('savedpdf/'.$ref_no.'.pdf', 'F');
//exit(0);
//============================================================+
// END OF FILE
//============================================================+
?>
<form method="post" id="myform">
<input type="text" value='' name="mydata" id="mydata">
<input type="text" value='' name="type" id="type">
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
swal("Alert!", "Make Sure You Add Rotor If Any Product Contains Accessories");
function myfunction(valt)
{
//alert("ök");
var sh=$("div.datatosave").html();
document.getElementById("mydata").value=sh;
document.getElementById("type").value=valt;
document.getElementById("myform").submit();
}


</script>
<input type="button" value="Generate" name="Generate" onClick="myfunction('save');" ><input type="button" value="Generate and Send" name="Generate and Send" onClick="myfunction('email');" >