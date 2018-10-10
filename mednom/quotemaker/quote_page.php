<?php
session_start();
include_once 'lib/dbfunctionjugal.php';
// Very important to set the page number first.
if (!(isset($_GET['pagenum']))) { 
	$pagenum = 1; 
} else {
	$pagenum = intval($_GET['pagenum']); 		
}
//echo "jugasl";
//Number of results displayed per page 	by default its 10.
$page_limit =  ($_GET["show"] <> "" && is_numeric($_GET["show"]) ) ? intval($_GET["show"]) : 8;

// Get the total number of rows in the table
//$sql2 = mysqli_fetch_assoc($link->query("SELECT count(*) as count FROM icemakers WHERE product_id = '2' and status='1'")) ;

$st='';
$en='';
$cnt = count(get_quotelist($_SESSION['login_user'],$st,$en));

//echo "*********************************".$cnt;

//Calculate the last page based on total number of rows and rows per page. 
$last = ceil($cnt/$page_limit); 

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) { 
	$pagenum = 1; 
} elseif ($pagenum > $last)  { 
	$pagenum = $last; 
}
$lower_limit = ($pagenum - 1) * $page_limit;

//$sql3 = $link->query("SELECT * FROM icemakers WHERE product_id = '2' and status='1' limit ". ($lower_limit)." ,  ". ($page_limit). " ");

?>

<form id="mainform" action="#" method="post">
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead >
			<tr>
				<th>Sr no.</th>
				<th>Subject</th>
				<th>Reference Id</th>
				<th>Customer Name</th>
				<th>Total</th>
				<th>Created By</th>
				<th>Created Date</th>
				<th>Updated By</th>
				<th>Updated Date</th>
				<th>Email Count</th>
				<th>Invoices History</th>
				<th>Generated Invoices</th>
				<th></th>												
                           <!-- <th><a href="#"><input type="checkbox" id="selectall" /></a>
                           <input type="submit" name="main" value="Delete" style="margin-left:10px; width:80px;height:30px;font-size:16px" /></th>-->
                       </tr>
                   </thead>
                   <tbody>

                   	<?php 
                   	date_default_timezone_set("Asia/Calcutta");
                   	$dt = date('Y-m-d');

                   	$udetails =admindetails_byusername($_SESSION['login_user']); 
                   	if($lower_limit>-1)
                   	{
                   		$pronames = get_quotelist($_SESSION['login_user'],"$lower_limit","$page_limit");
                   	}
                   	else
                   	{
                   		echo "no records found";
                   		exit(0);	
                   	}
                   	$r=1;
                   	foreach($pronames as $row3)
                   	{
                   		$row_contacts= contact_details($row3['qt_contacts']);

                   		$row_emailcount= quote_emaillogs($row3['qt_refid']);
                   		?>
                   		<tr>
                   			<td><?php echo $r; ?></td>
                   			<td><?php echo $row3['qt_subject']; ?></td>
                   			<td><a href="view_quotedetail.php?id=<?php echo $row3['qt_refid']; ?>"><?php echo $row3['qt_refid']; ?></a></td>
                   			<td><?php echo $row_contacts['cont_firstname']." ".$row_contacts['cont_lastname']; ?></td>
                   			<td><strong><?php echo $row3['qt_grandtotal']; ?></strong></td>
                   			<td><?php echo $row3['qt_createdby']; ?></td>
                   			<td><?php echo $row3['qt_createddt']; ?></td>
                   			<td><?php echo $row3['qt_updatedby']; ?></td>
                   			<td><?php echo $row3['qt_updateddt']; ?></td>
                   			<td><?php echo $row_emailcount[0]['ref_count']; ?></td>
                   			<td><div align="center"><!--<a href="tcpdf/examples/index4.php?refid=<?php echo $row3['qt_refid']; ?>">UK</a>&nbsp;<a href="tcpdf/examples/index6.php?refid=<?php echo $row3['qt_refid']; ?>">UAE</a>&nbsp;<a href="tcpdf/examples/index5.php?refid=<?php echo $row3['qt_refid']; ?>">Invoice</a>--><a href="invoice_edit.php?refid=<?php echo $row3['qt_refid']; ?>">Invoice</a></div></td><td>
                   			<a href="list_invoices.php?refid=<?php echo $row3['qt_refid']; ?>">Invoice History</a></div></td>
                   			<td><div align="center"><a href="edit_quote.php?id=<?php echo $row3['qt_refid']; ?>"><img src="images/edit.png" width="16" height="16" border="0" /></a></div></td>

                   		</tr>
                   		<?php
                   		$r++;
                   	}
                   	?>



                   </tbody>
               </table>
               <label> Rows Limit: 
               	<select name="show" onChange="changeDisplayRowCount(this.value);">
               		<option value="10" <?php if ($_GET["show"] == 10 || $_GET["show"] == "" ) { echo ' selected="selected"'; }  ?> >10</option>
               		<option value="20" <?php if ($_GET["show"] == 20) { echo ' selected="selected"'; }  ?> >20</option>
               		<option value="30" <?php if ($_GET["show"] == 30) { echo ' selected="selected"'; }  ?> >30</option>
               	</select>
               </label>



               <?php
               if ( ($pagenum-1) > 0) {
               	?>	
               	<a href="javascript:void(0);" class="links" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo 1; ?>');">First</a>
               	<a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $pagenum-1; ?>');">Previous</a>
               	<?php
               }
	//Show page links
               for($i=1; $i<=$last; $i++) {
               	if ($i == $pagenum ) {
               		?>
               		<a href="javascript:void(0);" class="selected" ><?php echo $i ?></a>
               		<?php
               	} else {  
               		?>
               		<a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $i; ?>');" ><?php echo $i ?></a>
               		<?php 
               	}
               } 
               if ( ($pagenum+1) <= $last) {
               	?>
               	<a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $pagenum+1; ?>');" class="links">Next</a>
               	<?php } if ( ($pagenum) != $last) { ?>	
               	<a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit;  ?>', '<?php echo $last; ?>');" class="links" >Last</a> 
               	<?php
               } 
               ?>

               Page <?php echo $pagenum; ?> of <?php echo $last; ?>
