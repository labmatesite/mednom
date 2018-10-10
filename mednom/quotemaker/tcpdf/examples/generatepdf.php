<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include '../../lib/function.php';
include('../../lib/dbfunctionjugal.php');
//include 'function.php';
//include('dbfunctionjugal.php');
require_once('tcpdf_include.php');
//header('Content-Type: text/plain');
//$temp="tcpdf/examples/tcpdf_include.php";
//echo $temp;
$userid=$_SESSION['login_user'];
$ref_no=$_GET['refid'];
date_default_timezone_set("Asia/Calcutta");
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');
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
$myfindata = fetch_edited_quote($ref_no);

/*PDF FIOLE NAME*/
$org_by_id = get_org_id($myfindata["refid"]); 
$fileName = pdf_file_name($org_by_id["qt_organisationid"]); 
/*PDF FILE NAME*/

// add a page
$pdf->AddPage();
$pdf->SetPrintHeader(false);
// set font
$pdf->SetFont('helvetica', 'B', 10);
$html='';
//$html = "'".$myfindata["quotedata"]."'";
//$pdf->writeHTML($html, true, 0, true, 0);

// create some HTML content
//$html = '<div style="\&quot;font-size:17px;\&quot;"><hr><div align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;"><strong>Proforma Invoice</strong><hr></div></div><br><table><tbody><tr nobr="\&quot;true\&quot;"><td nobr="\&quot;true\&quot;" width="\&quot;\&quot;"><p contenteditable="\&quot;true\&quot;"><strong>To,<br>Nikhil&nbsp;&nbsp;Muskar</strong><br>nikhil<br>billing address<br>state<br>city<br></p></td><td nobr="\&quot;true\&quot;" align="\&quot;right\&quot;" valign="\&quot;top\&quot;"><p contenteditable="\&quot;true\&quot;"><strong>Invoice No: abafe04156839</strong><br><strong>Date</strong><strong>:05 May 2015</strong></p></td></tr></tbody></table><div style="\&quot;clear:both\&quot;"></div><table border="\&quot;1\&quot;" cellspacing="\&quot;0\&quot;" cellpadding="\&quot;2\&quot;" width="\&quot;100%\&quot;" contenteditable="\&quot;true\&quot;" nobr="\&quot;true\&quot;"><thead><tr nobr="\&quot;true\&quot;">      <td nobr="\&quot;true\&quot;" width="\&quot;50%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;"><strong>Description</strong></p></td>      <td nobr="\&quot;true\&quot;" width="\&quot;20%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;"><strong>Unit Price(Â£)</strong></p></td>      <td nobr="\&quot;true\&quot;" width="\&quot;10%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;"><strong>QTY</strong></p></td>      <td nobr="\&quot;true\&quot;" width="\&quot;20%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;"><strong>Total Price(Â£)</strong></p></td>    </tr></thead><tbody><tr nobr="\&quot;true\&quot;">      <td nobr="\&quot;true\&quot;" width="\&quot;50%\&quot;" valign="\&quot;top\&quot;"><div style="\&quot;padding:10px;\&quot;" contenteditable="\&quot;true\&quot;"><strong>Hot Air Sterilizer LHAS-202</strong><br><table><tbody><tr nobr="\&quot;true\&quot;"><td nobr="\&quot;true\&quot;" style="\&quot;padding:10px;" font-family:helvetica;line-height:="" 1.8;="" \"="">LHAS-202Capacity:146 Litres<br>Temp. Range:RT+5Â°C to 300Â°C<br>Temp. Accuracy:?1Â°C<br>Temp. Uniformity:Â±1Â°C<br></td></tr></tbody></table></div></td>      <td nobr="\&quot;true\&quot;" width="\&quot;20%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;right\&quot;" contenteditable="\&quot;true\&quot;">644,644.00</p></td>      <td nobr="\&quot;true\&quot;" width="\&quot;10%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;">1</p></td>      <td nobr="\&quot;true\&quot;" width="\&quot;20%\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;right\&quot;" contenteditable="\&quot;true\&quot;">644,644.00</p></td>    </tr>    <tr nobr="\&quot;true\&quot;">      <td nobr="\&quot;true\&quot;" colspan="\&quot;3\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;">Price</p></td>      <td nobr="\&quot;true\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;right\&quot;" contenteditable="\&quot;true\&quot;">644,644.00</p></td>    </tr>        <tr nobr="\&quot;true\&quot;">      <td nobr="\&quot;true\&quot;" colspan="\&quot;3\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;" contenteditable="\&quot;true\&quot;">Packing, Forwarding &amp; Shipping Charges</p></td>      <td nobr="\&quot;true\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;right\&quot;">0.00</p></td>    </tr>    <tr nobr="\&quot;true\&quot;">      <td nobr="\&quot;true\&quot;" colspan="\&quot;3\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;center\&quot;"><strong>GRAND TOTAL(Â£)</strong></p></td>      <td nobr="\&quot;true\&quot;" valign="\&quot;top\&quot;"><p align="\&quot;right\&quot;"><strong>644,644.00</strong></p></td>    </tr>  </tbody></table><div contenteditable="\&quot;true\&quot;"><p><strong>Terms and Conditions</strong></p><p>okkkkkkkk</p></div><br>';
$html =stripslashes($myfindata["quotedata"]);



// set UTF-8 Unicode font
$pdf->SetFont('times', '', 8);
//echo "--------".$html."--------";
// output the HTML content
$pdf->writeHTML($html , true, 0, true, 0);
// reset pointer to the last page
//$pdf->Image('images/Labocon-Stamp-and-Signatutre.png', '148', '210', '', '', '', '', '', false, 300, '', false, false,'', false, false, false);
$pdf->lastPage();
//echo $html;
// ---------------------------------------------------------
//ob_end_clean();
//Close and output PDF document
if(isset($_GET['idm'])&&($_GET['idm']!=''))
{
$pdf->Output('savedpdf/'.$myfindata["refid"].'.pdf', 'F');
?>
<script type="text/javascript">
window.open('../../sendemailwithpdf.php?refid=<?php echo $myfindata["refid"]; ?>','_self');
</script>
<?php
}
else
{

$pdf->Output($myfindata["refid"].'.pdf', 'D');
$pdf->Output('savedpdf/'.$myfindata["refid"].'.pdf', 'F');
}

//============================================================+
// END OF FILE
//============================================================+
?>