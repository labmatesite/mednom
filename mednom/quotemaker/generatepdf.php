<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('tcpdf_include.php');
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
//$pdf->SetTitle($ref_no);
//$pdf->SetSubject('Invoice for' + $ref_no);
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
$myfindata = fetch_edited_quote($refid);
// add a page
$pdf->AddPage();
$pdf->SetPrintHeader(false);
// set font
$pdf->SetFont('helvetica', 'B', 20);

$pdf->writeHTML($html, true, 0, true, 0);

// create some HTML content
$html = $myfindata['quotedata'];

// set UTF-8 Unicode font
$pdf->SetFont('times', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);
// reset pointer to the last page
//$pdf->Image('images/Labocon-Stamp-and-Signatutre.png', '148', '210', '', '', '', '', '', false, 300, '', false, false,'', false, false, false);
$pdf->lastPage();

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output($ref_no.'.pdf', 'D');
$pdf->Output('savedpdf/'.$ref_no.'.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
?>