<?php
session_start();
include('../../../connection2.php');
$userid=$_SESSION['user1'];
$sql_usr="select * from admin where username='$userid'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_array($res_usr);
$usremail=$row_usr['emailid'];
if($usremail!=""){
$emailpwd=$row_usr['emailpwd'];
$host=$row_usr['host'];
$portno=$row_usr['port'];
require("../../PHPMailer/class.phpmailer.php");
date_default_timezone_set("Asia/Calcutta");
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');

$ref_no=$_REQUEST['refid'];

$sql_pd1="select * from quote_product where qt_refid='$ref_no'";
$res_pd1=mysql_query($sql_pd1);
$strOutput="";
while($row_pd1=mysql_fetch_array($res_pd1))
{

/*$strOutput .= '<tr>
      <td width="50%" valign="top"><p align="center"><strong>Description</strong></p></td>
      <td width="20%" valign="top"><p><strong>Unit Price (Rs.)</strong></p></td>
      <td width="10%" valign="top"><p align="center"><strong>QTY</strong></p></td>
      <td width="20%" valign="top"><p><strong>Total Price (Rs.)</strong></p></td>
    </tr>';*/
$strOutput .='<tr>
      <td width="50%" valign="top"><div style="padding:10px;">&nbsp;<strong>'.$row_pd1['product_name'].'</strong><br>'.$row_pd1['product_desc'].'</div></td>
      <td width="20%" valign="top"><p align="right">'.$row_pd1['product_sellingprice'].'  </p></td>
      <td width="10%" valign="top"><p align="center">'.$row_pd1['product_quantity'].'  </p></td>
      <td width="20%" valign="top"><p align="right">'.$row_pd1['product_sellingprice']*$row_pd1['product_quantity'].'  </p></td>
    </tr>';	
}

$sql_tax1="select * from quote_tax where qt_refid='$ref_no'";
$res_tax1=mysql_query($sql_tax1);
$strTax1="";
while($row_tax1=mysql_fetch_array($res_tax1))
{
$strTax1 .= '<span>'.$row_tax1['qt_taxname'].'('.$row_tax1['qt_taxvalue'].') (%)</span>';
}




$sql_qt1="select * from quotations where qt_refid='$ref_no'";
$res_qt1=mysql_query($sql_qt1);
$row_qt1=mysql_fetch_array($res_qt1);

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
	$qt_currency="(₹)";	
}

$sql_contacts="select * from quote_contacts where cont_id='".$row_qt1['qt_contacts']."'";
$res_contacts=mysql_query($sql_contacts);
$row_contacts=mysql_fetch_array($res_contacts);

$sql_org="select * from quote_organisation where org_id='".$row_qt1['qt_organisationid']."'";
$res_org=mysql_query($sql_org);
$row_org=mysql_fetch_array($res_org);

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
$pdf->SetSubject('Quotation for' + $ref_no);
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("logo.jpg", "180");

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

$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

// create some HTML content
$html = '<div align="center" style="font-size:17px;"><strong>Quotations</strong></div><table><tr><td><p><strong>'.$row_contacts['cont_sal'].' '.$row_contacts['cont_firstname'].' '.$row_contacts['cont_lastname'].'</strong><br />
  '.$row_org['org_name'].'<br />
  '.$row_org['org_billingadd'].'<br />
  '.$row_org['org_billingcity'].' - '.$row_org['org_billingcountry'].'.<br> '.$row_org['org_billingcountry'].'</p></td><td align="right"><p><strong>Ref  No :- '.$ref_no.' </strong> <br />
  <strong>Date </strong><strong>:- '.$temp_dt.'</strong></p></td></tr></table>
<div style="clear:both"></div><table border="1" cellspacing="0" cellpadding="0" width="100%"><tr>
      <td width="50%" valign="top"><p align="center"><strong>Description</strong></p></td>
      <td width="20%" valign="top"><p align="center"><strong>Unit Price '.$qt_currency.'</strong></p></td>
      <td width="10%" valign="top"><p align="center"><strong>QTY</strong></p></td>
      <td width="20%" valign="top"><p align="center"><strong>Total Price '.$qt_currency.'</strong></p></td>
    </tr>'.$strOutput.'
    <tr>
      <td colspan="3" valign="top"><p align="center">Price </p></td>
      <td  valign="top"><p align="right">'.$row_qt1['qt_itemtotal'].'  </p></td>
    </tr>
    <tr>
      <td  colspan="3" valign="top"><p align="center">'.$strTax1.'  </p></td>
      <td  valign="top"><p align="right">'.$row_qt1['qt_tax'].'  </p></td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><p align="center">Packing, Forwarding &amp; Shipping Charges </p></td>
      <td  valign="top"><p align="right">'.$row_qt1['qt_shipping_charges'].'  </p></td>
    </tr>
    <tr>
      <td  colspan="3" valign="top"><p align="center"><strong>GRAND TOTAL '.$qt_currency.'</strong></p></td>
      <td  valign="top"><p align="right"><strong>'.$row_qt1['qt_grandtotal'].'  </strong></p></td>
    </tr>
  </table> <p><strong><em>Terms and Conditions</em></strong><br></p>'.$row_qt1['qt_tnc'];


// set UTF-8 Unicode font
$pdf->SetFont('dejavusans', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('savedpdf/'.$ref_no.'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+

/*
date_default_timezone_set("Asia/Calcutta");
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');

$s_sender=$_POST['s_sender'];

$sql_send="select * from sender where sender_email_id='$s_sender'";
$res_send=mysql_query($sql_send);
$tot_send=mysql_num_rows($res_send);
$row_send=mysql_fetch_array($res_send);

if($tot_send=="1")
{

$send_email=$row_send['sender_email_id'];
$send_pwd=$row_send['sender_password'];
$send_name=$row_send['sender_name'];
$send_host=$row_send['sender_host'];
$send_port=$row_send['sender_port'];


$emailId=mysql_real_escape_string($_POST['emailId']);
$e_subject=mysql_real_escape_string($_POST['subject']);




$t_email=$_POST['t_email'];
if($t_email=="normal")
{
$msg1=mysql_real_escape_string($_POST['content']);
$order   = array('\r\n', '\n', '\r');
$replace = '<br />';
$msg2 = str_replace($order, $replace, $msg1);
$msg=str_replace("'","&#146;",$msg2);
}
elseif($t_email=="emailer")
{
$template=$_POST['e_templates'];	
}

$sql_esent="insert into email_management (email_from_emailid,email_to_emailid,email_subject,email_attachments,email_date,email_emailtype,email_opencount,email_sent) values ('$send_email','$emailId','$e_subject','','$dt','Anyone','','sent')";
$res_esent=mysql_query($sql_esent);

$sql_esent1="select id from email_management order by id desc limit 0,1";
$res_esent1=mysql_query($sql_esent1);
$row_esent1=mysql_fetch_array($res_esent1);
*/
	
	$mail = new PHPMailer(true);
	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = $portno;                    // set the SMTP server port
	$mail->Host       = $host; // SMTP server
	$mail->Username   = $usremail;     // SMTP server username
	$mail->Password   = $emailpwd;            // SMTP server password
	
$mail->IsSendmail();  // tell the class to use Sendmail
		
$mail->From     = $emailpwd;
$mail->FromName = $userid;
$mail->AddAddress($row_contacts['cont_primaryemail']);
              // optional name

$mail->WordWrap = 50;                              // set word wrap

$mail->IsHTML(true);                               // send as HTML

$mail->Subject  =  $row_qt1['qt_subject'];

/*if($t_email=="normal")
{
$body ="<div style='display:none'><img src='http://eximlon.com/linkin/admin/tracker.php?id=".$emailId."&eid=".$row_esent1['id']."' width='1px' height='1px' style='display:none' /></div>".$msg;
$mail->Body=$body;
}
elseif($t_email=="emailer")
{
$body = "<div style='display:none'><img src='http://eximlon.com/linkin/admin/tracker.php?id=".$emailId."&eid=".$row_esent1['id']."' width='1px' height='1px' style='display:none' /></div>".file_get_contents("templates/".$template);
$mail->MsgHTML($body);
}
*/

$body = "Dear ".$row_contacts['cont_sal'].' '.$row_contacts['cont_firstname'].' '.$row_contacts['cont_lastname'].",<br>Kindly find attached Quotation for ".$ref_no."<br><br> Thanks and Regards<br>Team Indian Scientific";
$mail->MsgHTML($body);



/*if (isset($_FILES['mzAttach']) && $_FILES['mzAttach']['error'] == UPLOAD_ERR_OK) {
					$mail->AddAttachment($_FILES['mzAttach']['tmp_name'],
										 $_FILES['mzAttach']['name']);
					}	*/

$mail->AddAttachment("savedpdf/".$ref_no.".pdf"); 					
					

if(!$mail->Send())
{
   echo "Message was not sent <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}  
else
{
	
	
?>
<script type="text/javascript">
window.open('../../view_quote.php','_self');
</script>
<?php
}
}
else
{
?>
<script type="text/javascript">
alert("Email Issue. Kindly Contact Admin");
history.go(-1);
</script>
<?php
	
}
?>

