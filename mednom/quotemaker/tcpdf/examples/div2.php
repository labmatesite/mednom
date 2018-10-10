<?php
session_start();
include('../../../connection2.php');
$userid=$_SESSION['user1'];
$sql_usr="select * from admin where username='$userid'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_array($res_usr);
$usremail=$row_usr['emailid'];
$host=$row_usr['host'];
$portno=$row_usr['port'];
$ipaddress = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];
date_default_timezone_set("Asia/Calcutta");
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');

$ref_no=$_GET['refid'];

$sql_pd1="select * from quote_product where qt_refid='$ref_no'";
$res_pd1=mysql_query($sql_pd1);
$tot_pd1=mysql_num_rows($res_pd1);
$strOutput="";

if($tot_pd1>=1)
{

while($row_pd1=mysql_fetch_array($res_pd1))
{
$sp=str_replace(',', '', $row_pd1['product_sellingprice']);
 $totsp=$sp * $row_pd1['product_quantity'];
 $product_desc=str_replace('<br>','\n',$row_pd1['product_desc']);
 $product_desc1=htmlspecialchars($product_desc);
 $product_desc2=str_replace('\n','<br>',$product_desc1);
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
      <td nobr="true" width="50%" valign="top"><div style="padding:10px;" contenteditable="true"> <strong>'. $row_pd1['product_name'].'</strong><br><table><tr nobr="true"><td nobr="true" style="padding:10px;">'.nl2br($product_desc3).'</td></tr></table></div></td>
      <td nobr="true" width="20%" valign="top"><p align="right" contenteditable="true">'.number_format($sp, 2, '.', ',').'  </p></td>
      <td nobr="true" width="10%" valign="top"><p align="center" contenteditable="true">'.$row_pd1['product_quantity']. '  </p></td>
      <td nobr="true" width="20%" valign="top"><p align="right" contenteditable="true">'.number_format($totsp, 2, '.', ','). '  </p></td>
    </tr>';	
}
}




$sql_qt1="select * from quotations where qt_refid='$ref_no'";
$res_qt1=mysql_query($sql_qt1);
$row_qt1=mysql_fetch_array($res_qt1);

if($row_qt1['qt_tax']!="" && $row_qt1['qt_tax']!=0.00)
{
$sql_tax1="select * from quote_tax where qt_refid='$ref_no'";
$res_tax1=mysql_query($sql_tax1);
$strTax1="";
$strTax2="";	
	while($row_tax1=mysql_fetch_array($res_tax1))
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

$currency=$row_qt1['qt_currency'];


if($currency=="dollar")
{
	$qt_currency="($)";
}
elseif($currency=="pounds")
{
	$qt_currency="(£)";
}
else
{
	$qt_currency="(Rs)";	
}

$sql_contacts="select * from quote_contacts where cont_id='".$row_qt1['qt_contacts']."'";
$res_contacts=mysql_query($sql_contacts);
$row_contacts=mysql_fetch_array($res_contacts);

$sql_org="select * from quote_organisation where org_id='".$row_qt1['qt_organisationid']."'";
$res_org=mysql_query($sql_org);
$row_org=mysql_fetch_array($res_org);
if($row_org['org_name']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_name'].'<br>';	
	}

	if($row_org['org_billingadd']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingadd'].'<br>';	
	}
	
	if($row_org['org_billingcity']=="")
	{
	}

	else
	{
		$strOrg.=$row_org['org_billingcity'];	
	}
if($row_org['org_billingpoc']=="")
	{
	}
	else
	{
		$strOrg.='-'.$row_org['org_billingpoc'].'<br>';	
	}
	if($row_org['org_billingstate']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingstate'].'<br>';	
	}
	if($row_org['org_billingcountry']=="")
	{
	}
	else
	{
		$strOrg.=$row_org['org_billingcountry'].'<br>';	
	}
	

$sql_sd="insert into quote_savedlogs (sd_userid,sd_subject,sd_qt_refid,sd_date,sd_ipaddress) values ('$userid','".$row_qt1['qt_subject']."','$ref_no','$dt','$ipaddress')";
$res_sd=mysql_query($sql_sd);


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
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Labocon');
$pdf->SetTitle($ref_no);
$pdf->SetSubject('Invoice for' + $ref_no);
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("logo.jpg", "180");
//$pdf->SetPrintHeader(false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// add a page
$pdf->AddPage();
$pdf->SetPrintHeader(false);
// set font
$pdf->SetFont('helvetica', 'B', 20);

$pdf->writeHTML($html, true, 0, true, 0);

// create some HTML content
$html = '<div style="font-size:17px;"><hr><div align="center" contenteditable="true"><strong>Proforma Invoice</strong><hr></div></div><br><table><tr nobr="true"><td nobr="true"><p contenteditable="true"><strong> To,<br>'.ucwords($row_contacts['cont_sal']).' '.ucwords($row_contacts['cont_firstname']).' '.ucwords($row_contacts['cont_lastname']).'</strong><br />
  '.$strOrg.'</p></td><td nobr="true" align="right"><p contenteditable="true"><strong>Invoice  No : '.$ref_no.' </strong> <br />
  <strong>Date </strong><strong>: '.$temp_dt.'</strong></p></td></tr></table>
<div style="clear:both"></div><table border="1" cellspacing="0" cellpadding="2" width="100%" contenteditable="true" nobr="true"><thead><tr nobr="true">
      <td nobr="true" width="50%" valign="top"><p align="center" contenteditable="true"><strong>Description</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p align="center" contenteditable="true"><strong>Unit Price '.$qt_currency.' </strong></p></td>
      <td nobr="true" width="10%" valign="top"><p align="center" contenteditable="true"><strong>QTY</strong></p></td>
      <td nobr="true" width="20%" valign="top"><p align="center" contenteditable="true"><strong>Total Price '.$qt_currency.' </strong></p></td>
    </tr></thead>'.$strOutput.'
    <tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center" contenteditable="true">Price </p></td>
      <td nobr="true"  valign="top"><p align="right" contenteditable="true">'.$row_qt1['qt_itemtotal'].'  </p></td>
    </tr>'.$strDiscount.$strTax2.'
    
    <tr nobr="true">
      <td nobr="true" colspan="3" valign="top"><p align="center" contenteditable="true">Packing, Forwarding &amp; Shipping Charges </p></td>
      <td nobr="true"  valign="top"><p align="right">'.$row_qt1['qt_shipping_charges'].'  </p></td>
    </tr>
    <tr nobr="true">
      <td nobr="true"  colspan="3" valign="top"><p align="center"><strong>GRAND TOTAL '.$qt_currency.' </strong></p></td>
      <td nobr="true"  valign="top"><p align="right"><strong>'.$row_qt1['qt_grandtotal'].'  </strong></p></td>
    </tr>
  </table><br><br><table border="1" width="100%" cellpadding="10" contenteditable="true"><tr nobr="true"><td nobr="true" width="70%"><p><strong><em> Terms and Conditions</em></strong><br></p>'.$row_qt1['qt_tnc'].'</td><td nobr="true" width="30%"><br><br><br><img src="images/Labocon-Stamp-and-Signatutre.png"  width="113" height="85"></td></tr></table>';

// set UTF-8 Unicode font
$pdf->SetFont('times', '', 10);

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
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>';
//echo $html;
$html = mysql_real_escape_string($_GET['show']);
mysql_query("insert into testdata set data='$html'");
$pdf->writeHTML($_GET['show'], true, 0, true, 0);
//$pdf->writeHTML($html1, true, 0, true, 0);
//$pdf->writeHTML($html1, true, 0, true, 0);
// reset pointer to the last page
//$pdf->Image('images/Labocon-Stamp-and-Signatutre.png', '148', '210', '', '', '', '', '', false, 300, '', false, false,'', false, false, false);
$pdf->lastPage();



// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output($ref_no.'.pdf', 'D');
$pdf->Output('savedpdf/'.$ref_no.'.pdf', 'F');
exit(0);
//============================================================+
// END OF FILE
//============================================================+
?>