<?php
include('../access1.php');
if($userType=="Admin")
{
	?>
    <script type="text/javascript">
	window.open('home.php','_self');
	</script>
    <?php
	exit;
}
include('../connection2.php');
$refid=$_REQUEST['id'];

$sql_vd1="select * from quotations where qt_refid='$refid'";
$res_vd1=mysql_query($sql_vd1);
$row_vd1=mysql_fetch_array($res_vd1);



$tax=0;
$sql_tax1="select * from tax_cal where tax_status='active'";
$res_tax1=mysql_query($sql_tax1);
$a=1;
while($row_tax1=mysql_fetch_array($res_tax1))
{
 $tax=$tax+$row_tax1['tax_value'];	
}
$a++;
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
<script language="javascript">
var cnt = 1;

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function AddRow(){
	cnt++;
    var newRow = jQuery('<tr id="addrowid' + cnt + '"></tr>'); // add new tr with dynamic id and then add new row with textfield.
    jQuery('table.authors-list').append(newRow);	
	
	var strURL="addnewrow.php?cnt="+cnt;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('addrowid' + cnt).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
			
		}		
	}
	
	
	function product_Desc(val1,cnt) {
		val2 = val1.substring(0, val1.indexOf('/'));
		val3 = val1.substring(val1.indexOf('/')+1);
		document.getElementById('prod_fullname' + cnt).value=val3;
		var strURL="viewproduct.php?val1="+val2;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('product_desc' + cnt).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
		}		
	}
	
	
	function sord(sp,cnt) // Selling Price field
	{
		var taxes=document.getElementById('hid_tx').value;
		var qty = document.getElementById('quantity'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		
		var tot = qty * sp;
		var temp_tax = taxes/100;
		
		document.getElementById('tot'+cnt).innerHTML=tot.toFixed(2);		
		document.getElementById('tadisc'+cnt).innerHTML=tot.toFixed(2);	
		document.getElementById('net'+cnt).innerHTML=tot.toFixed(2);
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		var i=1;x="";
		while(i<=numItems)	
		{
		 x=+x+ +document.getElementById('net'+i).innerHTML;
		 var taxes_tot=temp_tax * x;
		 var pre_tax=+x+ +sc;
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}	
		 document.getElementById('ittot1').innerHTML=x.toFixed(2);
		 document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		 document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2);
		 document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		 
		document.getElementById('qt_itemtotal').value=x.toFixed(2);
		document.getElementById('tax_total').value=taxes_tot.toFixed(2);
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		 i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
	
	}
	
	

	
	function sqty(qt,cnt) // Quantity Field
	{
		var sp=document.getElementById('selling_price'+ cnt).value;
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot= qt * sp;
		var temp_tax = taxes/100;
		
		document.getElementById('tot'+cnt).innerHTML=tot.toFixed(2);		
		document.getElementById('tadisc'+cnt).innerHTML=tot.toFixed(2);	
		document.getElementById('net'+cnt).innerHTML=tot.toFixed(2);
		
		var numItems = $('.net').length;// calculating the dynamic textfields(Sum and all)
		
		var i=1;x="";
		while(i<=numItems)	
		{
		 x=+x+ +document.getElementById('net'+i).innerHTML;
		 var taxes_tot=temp_tax * x;
		 var pre_tax=+x+ +sc;
		 var gttot=+taxes_tot+ + pre_tax;
		 if(document.getElementById("add").checked)
		{
			
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}
		document.getElementById('ittot1').innerHTML=x.toFixed(2);
		document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2);
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		
		document.getElementById('qt_itemtotal').value=x.toFixed(2); 
		document.getElementById('tax_total').value=taxes_tot.toFixed(2);
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		 i++;
		}
		document.getElementById('numoftxt').value=$('.net').length;
		
			
	}
	
	function scharge(sc) // Shipping and Handling Charges field
	{
		var tot=document.getElementById('ittot1').innerHTML;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}		
		
		document.getElementById('ittot3').innerHTML=pre_tax.toFixed(2);
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		
		document.getElementById('pretaxtotal').value=pre_tax.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
		
	}
	
	function sadjust(adj) // Adjustment Textfield
	{
		var sc=document.getElementById('shippin_charges').value;
		var adj=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot=document.getElementById('ittot1').innerHTML;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj;
		}
		else if(document.getElementById("subtract").checked)
		{
			var gttot1=gttot-adj;
		}
		
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
	}
	
	function sadjust1() // Adjustment Checkboxes (Add or Subtract)
	{
		var sc=document.getElementById('shippin_charges').value;
		var adj1=document.getElementById('adjustment').value;
		var taxes=document.getElementById('hid_tx').value;
		
		var tot=document.getElementById('ittot1').innerHTML;
		
		var temp_tax = taxes/100;
		var taxes_tot=temp_tax * tot;
		var pre_tax= +tot+ +sc;
		var gttot=taxes_tot + pre_tax;
		
		if(document.getElementById("add").checked)
		{
			var gttot1=+gttot+ +adj1;
		}
		else if(document.getElementById("subtract").checked)
		{
			
			var gttot1=gttot-adj1;
		}
		
		document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);
		document.getElementById('grandtotal').value=gttot1.toFixed(2);
	}
	
	function taxval() // taxes1 count active no of taxes and store in hidden txtfield
							{
								var strURL="counttxvalue.php";
								var req = getXMLHTTP();
								if (req) {
									req.onreadystatechange = function() {
										if (req.readyState == 4) {
											// only if "OK"
											if (req.status == 200) {
												document.getElementById('hid_tx').value =req.responseText;
											} else {
												alert("There was a problem while using XMLHTTP:\n" + req.statusText);
											}
										}				
									}			
									req.open("REQUEST", strURL, true);
									req.send(null);
								}	
							}
							
	function tnc(tnc_orgid) //  updating the terms and conditions textarea
	 {		
		var strURL="updatetnc.php?tnc_orgid="+tnc_orgid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						tinyMCE.activeEditor.setContent(req.responseText);						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
		}		
	}						
	
	function tax(txid,txvalue,txstatus) // taxes 
	 {
						
						var sc=document.getElementById('shippin_charges').value;
						var adj1=document.getElementById('adjustment').value;
						var taxes1=document.getElementById('hid_tx').value; // finding the total taxes
						var tot=document.getElementById('ittot1').innerHTML;
						
						if(txstatus=="active")
						{
							taxes2=taxes1-txvalue;
						}
						else if(txstatus=="deactive")
						{
							taxes2=+taxes1+ +txvalue;
						}
						document.getElementById('hid_tx').value=taxes2; // updating the taxes
						
						var temp_tax = taxes2/100;
						var taxes_tot=temp_tax * tot;
						var pre_tax= +tot+ +sc;
						var gttot=taxes_tot + pre_tax;
						if(document.getElementById("add").checked)
						{
							var gttot1=+gttot+ +adj1;
						}
						else if(document.getElementById("subtract").checked)
						{
							var gttot1=gttot-adj1;
						}
		
					document.getElementById('ittot4').innerHTML=taxes_tot.toFixed(2); // updating the taxes
					document.getElementById('ittot6').innerHTML=gttot1.toFixed(2);// updating the grandtotal
					
					document.getElementById('tax_total').value=taxes_tot.toFixed(2);
					document.getElementById('grandtotal').value=gttot1.toFixed(2);
					
								
		var strURL="updatetx.php?txid="+txid;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {	
						document.getElementById('mainform').innerHTML=req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("REQUEST", strURL, true);
			req.send(null);
			
		}		
	}
</script>



	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

</head>
<body onLoad="tnc('indianscientific')" class="theme-red" data-theme="theme-red">
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
	<div id="new-task" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add new task</h3>
		</div>
		<form action="#" class='new-task-form form-horizontal form-bordered'>
			<div class="modal-body nopadding">
				<div class="control-group">
					<label for="tasktitel" class="control-label">Icon</label>
					<div class="controls">
						<select name="icons" id="icons" class='select2-me input-xlarge'>
							<option value="icon-adjust">icon-adjust</option>
							<option value="icon-asterisk">icon-asterisk</option>
							<option value="icon-ban-circle">icon-ban-circle</option>
							<option value="icon-bar-chart">icon-bar-chart</option>
							<option value="icon-barcode">icon-barcode</option>
							<option value="icon-beaker">icon-beaker</option>
							<option value="icon-beer">icon-beer</option>
							<option value="icon-bell">icon-bell</option>
							<option value="icon-bell-alt">icon-bell-alt</option>
							<option value="icon-bolt">icon-bolt</option>
							<option value="icon-book">icon-book</option>
							<option value="icon-bookmark">icon-bookmark</option>
							<option value="icon-bookmark-empty">icon-bookmark-empty</option>
							<option value="icon-briefcase">icon-briefcase</option>
							<option value="icon-bullhorn">icon-bullhorn</option>
							<option value="icon-calendar">icon-calendar</option>
							<option value="icon-camera">icon-camera</option>
							<option value="icon-camera-retro">icon-camera-retro</option>
							<option value="icon-certificate">icon-certificate</option>
							<option value="icon-check">icon-check</option>
							<option value="icon-check-empty">icon-check-empty</option>
							<option value="icon-circle">icon-circle</option>
							<option value="icon-circle-blank">icon-circle-blank</option>
							<option value="icon-cloud">icon-cloud</option>
							<option value="icon-cloud-download">icon-cloud-download</option>
							<option value="icon-cloud-upload">icon-cloud-upload</option>
							<option value="icon-coffee">icon-coffee</option>
							<option value="icon-cog">icon-cog</option>
							<option value="icon-cogs">icon-cogs</option>
							<option value="icon-comment">icon-comment</option>
							<option value="icon-comment-alt">icon-comment-alt</option>
							<option value="icon-comments">icon-comments</option>
							<option value="icon-comments-alt">icon-comments-alt</option>
							<option value="icon-credit-card">icon-credit-card</option>
							<option value="icon-dashboard">icon-dashboard</option>
							<option value="icon-desktop">icon-desktop</option>
							<option value="icon-download">icon-download</option>
							<option value="icon-download-alt">icon-download-alt</option>
							<option value="icon-edit">icon-edit</option>
							<option value="icon-envelope">icon-envelope</option>
							<option value="icon-envelope-alt">icon-envelope-alt</option>
							<option value="icon-exchange">icon-exchange</option>
							<option value="icon-exclamation-sign">icon-exclamation-sign</option>
							<option value="icon-external-link">icon-external-link</option>
							<option value="icon-eye-close">icon-eye-close</option>
							<option value="icon-eye-open">icon-eye-open</option>
							<option value="icon-facetime-video">icon-facetime-video</option>
							<option value="icon-fighter-jet">icon-fighter-jet</option>
							<option value="icon-film">icon-film</option>
							<option value="icon-filter">icon-filter</option>
							<option value="icon-fire">icon-fire</option>
							<option value="icon-flag">icon-flag</option>
							<option value="icon-folder-close">icon-folder-close</option>
							<option value="icon-folder-open">icon-folder-open</option>
							<option value="icon-folder-close-alt">icon-folder-close-alt</option>
							<option value="icon-folder-open-alt">icon-folder-open-alt</option>
							<option value="icon-food">icon-food</option>
							<option value="icon-gift">icon-gift</option>
							<option value="icon-glass">icon-glass</option>
							<option value="icon-globe">icon-globe</option>
							<option value="icon-group">icon-group</option>
							<option value="icon-hdd">icon-hdd</option>
							<option value="icon-headphones">icon-headphones</option>
							<option value="icon-heart">icon-heart</option>
							<option value="icon-heart-empty">icon-heart-empty</option>
							<option value="icon-home">icon-home</option>
							<option value="icon-inbox">icon-inbox</option>
							<option value="icon-info-sign">icon-info-sign</option>
							<option value="icon-key">icon-key</option>
							<option value="icon-leaf">icon-leaf</option>
							<option value="icon-laptop">icon-laptop</option>
							<option value="icon-legal">icon-legal</option>
							<option value="icon-lemon">icon-lemon</option>
							<option value="icon-lightbulb">icon-lightbulb</option>
							<option value="icon-lock">icon-lock</option>
							<option value="icon-unlock">icon-unlock</option>
							<option value="icon-magic">icon-magic</option>
							<option value="icon-magnet">icon-magnet</option>
							<option value="icon-map-marker">icon-map-marker</option>
							<option value="icon-minus">icon-minus</option>
							<option value="icon-minus-sign">icon-minus-sign</option>
							<option value="icon-mobile-phone">icon-mobile-phone</option>
							<option value="icon-money">icon-money</option>
							<option value="icon-move">icon-move</option>
							<option value="icon-music">icon-music</option>
							<option value="icon-off">icon-off</option>
							<option value="icon-ok">icon-ok</option>
							<option value="icon-ok-circle">icon-ok-circle</option>
							<option value="icon-ok-sign">icon-ok-sign</option>
							<option value="icon-pencil">icon-pencil</option>
							<option value="icon-picture">icon-picture</option>
							<option value="icon-plane">icon-plane</option>
							<option value="icon-plus">icon-plus</option>
							<option value="icon-plus-sign">icon-plus-sign</option>
							<option value="icon-print">icon-print</option>
							<option value="icon-pushpin">icon-pushpin</option>
							<option value="icon-qrcode">icon-qrcode</option>
							<option value="icon-question-sign">icon-question-sign</option>
							<option value="icon-quote-left">icon-quote-left</option>
							<option value="icon-quote-right">icon-quote-right</option>
							<option value="icon-random">icon-random</option>
							<option value="icon-refresh">icon-refresh</option>
							<option value="icon-remove">icon-remove</option>
							<option value="icon-remove-circle">icon-remove-circle</option>
							<option value="icon-remove-sign">icon-remove-sign</option>
							<option value="icon-reorder">icon-reorder</option>
							<option value="icon-reply">icon-reply</option>
							<option value="icon-resize-horizontal">icon-resize-horizontal</option>
							<option value="icon-resize-vertical">icon-resize-vertical</option>
							<option value="icon-retweet">icon-retweet</option>
							<option value="icon-road">icon-road</option>
							<option value="icon-rss">icon-rss</option>
							<option value="icon-screenshot">icon-screenshot</option>
							<option value="icon-search">icon-search</option>
							<option value="icon-share">icon-share</option>
							<option value="icon-share-alt">icon-share-alt</option>
							<option value="icon-shopping-cart">icon-shopping-cart</option>
							<option value="icon-signal">icon-signal</option>
							<option value="icon-signin">icon-signin</option>
							<option value="icon-signout">icon-signout</option>
							<option value="icon-sitemap">icon-sitemap</option>
							<option value="icon-sort">icon-sort</option>
							<option value="icon-sort-down">icon-sort-down</option>
							<option value="icon-sort-up">icon-sort-up</option>
							<option value="icon-spinner">icon-spinner</option>
							<option value="icon-star">icon-star</option>
							<option value="icon-star-empty">icon-star-empty</option>
							<option value="icon-star-half">icon-star-half</option>
							<option value="icon-tablet">icon-tablet</option>
							<option value="icon-tag">icon-tag</option>
							<option value="icon-tags">icon-tags</option>
							<option value="icon-tasks">icon-tasks</option>
							<option value="icon-thumbs-down">icon-thumbs-down</option>
							<option value="icon-thumbs-up">icon-thumbs-up</option>
							<option value="icon-time">icon-time</option>
							<option value="icon-tint">icon-tint</option>
							<option value="icon-trash">icon-trash</option>
							<option value="icon-trophy">icon-trophy</option>
							<option value="icon-truck">icon-truck</option>
							<option value="icon-umbrella">icon-umbrella</option>
							<option value="icon-upload">icon-upload</option>
							<option value="icon-upload-alt">icon-upload-alt</option>
							<option value="icon-user">icon-user</option>
							<option value="icon-user-md">icon-user-md</option>
							<option value="icon-volume-off">icon-volume-off</option>
							<option value="icon-volume-down">icon-volume-down</option>
							<option value="icon-volume-up">icon-volume-up</option>
							<option value="icon-warning-sign">icon-warning-sign</option>
							<option value="icon-wrench">icon-wrench</option>
							<option value="icon-zoom-in">icon-zoom-in</option>
							<option value="icon-zoom-out">icon-zoom-out</option>
							<option value="icon-file">icon-file</option>
							<option value="icon-file-alt">icon-file-alt</option>
							<option value="icon-cut">icon-cut</option>
							<option value="icon-copy">icon-copy</option>
							<option value="icon-paste">icon-paste</option>
							<option value="icon-save">icon-save</option>
							<option value="icon-undo">icon-undo</option>
							<option value="icon-repeat">icon-repeat</option>
							<option value="icon-text-height">icon-text-height</option>
							<option value="icon-text-width">icon-text-width</option>
							<option value="icon-align-left">icon-align-left</option>
							<option value="icon-align-center">icon-align-center</option>
							<option value="icon-align-right">icon-align-right</option>
							<option value="icon-align-justify">icon-align-justify</option>
							<option value="icon-indent-left">icon-indent-left</option>
							<option value="icon-indent-right">icon-indent-right</option>
							<option value="icon-font">icon-font</option>
							<option value="icon-bold">icon-bold</option>
							<option value="icon-italic">icon-italic</option>
							<option value="icon-strikethrough">icon-strikethrough</option>
							<option value="icon-underline">icon-underline</option>
							<option value="icon-link">icon-link</option>
							<option value="icon-paper-clip">icon-paper-clip</option>
							<option value="icon-columns">icon-columns</option>
							<option value="icon-table">icon-table</option>
							<option value="icon-th-large">icon-th-large</option>
							<option value="icon-th">icon-th</option>
							<option value="icon-th-list">icon-th-list</option>
							<option value="icon-list">icon-list</option>
							<option value="icon-list-ol">icon-list-ol</option>
							<option value="icon-list-ul">icon-list-ul</option>
							<option value="icon-list-alt">icon-list-alt</option>
							<option value="icon-angle-left">icon-angle-left</option>
							<option value="icon-angle-right">icon-angle-right</option>
							<option value="icon-angle-up">icon-angle-up</option>
							<option value="icon-angle-down">icon-angle-down</option>
							<option value="icon-arrow-down">icon-arrow-down</option>
							<option value="icon-arrow-left">icon-arrow-left</option>
							<option value="icon-arrow-right">icon-arrow-right</option>
							<option value="icon-arrow-up">icon-arrow-up</option>
							<option value="icon-caret-down">icon-caret-down</option>
							<option value="icon-caret-left">icon-caret-left</option>
							<option value="icon-caret-right">icon-caret-right</option>
							<option value="icon-caret-up">icon-caret-up</option>
							<option value="icon-chevron-down">icon-chevron-down</option>
							<option value="icon-chevron-left">icon-chevron-left</option>
							<option value="icon-chevron-right">icon-chevron-right</option>
							<option value="icon-chevron-up">icon-chevron-up</option>
							<option value="icon-circle-arrow-down">icon-circle-arrow-down</option>
							<option value="icon-circle-arrow-left">icon-circle-arrow-left</option>
							<option value="icon-circle-arrow-right">icon-circle-arrow-right</option>
							<option value="icon-circle-arrow-up">icon-circle-arrow-up</option>
							<option value="icon-double-angle-left">icon-double-angle-left</option>
							<option value="icon-double-angle-right">icon-double-angle-right</option>
							<option value="icon-double-angle-up">icon-double-angle-up</option>
							<option value="icon-double-angle-down">icon-double-angle-down</option>
							<option value="icon-hand-down">icon-hand-down</option>
							<option value="icon-hand-left">icon-hand-left</option>
							<option value="icon-hand-right">icon-hand-right</option>
							<option value="icon-hand-up">icon-hand-up</option>
							<option value="icon-circle">icon-circle</option>
							<option value="icon-circle-blank">icon-circle-blank</option>
							<option value="icon-play-circle">icon-play-circle</option>
							<option value="icon-play">icon-play</option>
							<option value="icon-pause">icon-pause</option>
							<option value="icon-stop">icon-stop</option>
							<option value="icon-step-backward">icon-step-backward</option>
							<option value="icon-fast-backward">icon-fast-backward</option>
							<option value="icon-backward">icon-backward</option>
							<option value="icon-forward">icon-forward</option>
							<option value="icon-fast-forward">icon-fast-forward</option>
							<option value="icon-step-forward">icon-step-forward</option>
							<option value="icon-eject">icon-eject</option>
							<option value="icon-fullscreen">icon-fullscreen</option>
							<option value="icon-resize-full">icon-resize-full</option>
							<option value="icon-resize-small">icon-resize-small</option>
							<option value="icon-phone">icon-phone</option>
							<option value="icon-phone-sign">icon-phone-sign</option>
							<option value="icon-facebook">icon-facebook</option>
							<option value="icon-facebook-sign">icon-facebook-sign</option>
							<option value="icon-twitter">icon-twitter</option>
							<option value="icon-twitter-sign">icon-twitter-sign</option>
							<option value="icon-github">icon-github</option>
							<option value="icon-github-alt">icon-github-alt</option>
							<option value="icon-github-sign">icon-github-sign</option>
							<option value="icon-linkedin">icon-linkedin</option>
							<option value="icon-linkedin-sign">icon-linkedin-sign</option>
							<option value="icon-pinterest">icon-pinterest</option>
							<option value="icon-pinterest-sign">icon-pinterest-sign</option>
							<option value="icon-google-plus">icon-google-plus</option>
							<option value="icon-google-plus-sign">icon-google-plus-sign</option>
							<option value="icon-sign-blank">icon-sign-blank</option>
							<option value="icon-ambulance">icon-ambulance</option>
							<option value="icon-beaker">icon-beaker</option>
							<option value="icon-h-sign">icon-h-sign</option>
							<option value="icon-hospital">icon-hospital</option>
							<option value="icon-medkit">icon-medkit</option>
							<option value="icon-plus-sign-alt">icon-plus-sign-alt</option>
							<option value="icon-stethoscope">icon-stethoscope</option>
							<option value="icon-user-md">icon-user-md</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label for="task-name" class="control-label">Task</label>
					<div class="controls">
						<input type="text" name="task-name">
					</div>
				</div>
				<div class="control-group">
					<label for="tasktitel" class="control-label"></label>
					<div class="controls">
						<label class="checkbox"><input type="checkbox" name="task-bookmarked" value="yep"> Mark as important</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Add task">
			</div>
		</form>

	</div>
	<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">Admin Panel</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
			<!-- main menu -->
            
            <?php
            include('admin_menu.php');
			?>
            
            <!-- main menu -->
			<div class="user">
				
				<div class="dropdown asdf">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo $_SESSION['user1'] ?> </a>
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
												 $sql_sec3="select * from quote_organisation where org_id='".$row_vd1['qt_organisationid']."' order by org_name";
												 $res_sec3=mysql_query($sql_sec3);
												 $row_sec3=mysql_fetch_array($res_sec3);
												 echo "<label>".ucwords($row_sec3['org_name'])."</label>";
												  ?>
                                           
                                                 
                                                 </div>
                                                        </div>
                                                        <div class="control-group divhalf">
                                                            <label for="textfield" class="control-label">Contacts</label>
                                                            <div class="controls">
                                                 
                                                 <?php
												 $sql_sec3="select * from quote_contacts where cont_id='".$row_vd1['qt_contacts']."'";
												 $res_sec3=mysql_query($sql_sec3);
												 $row_sec3=mysql_fetch_array($res_sec3);
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
									$sql_vd2="select * from quote_product where qt_refid='$refid'";
									$res_vd2=mysql_query($sql_vd2);
									$y=1;

									while($row_vd2=mysql_fetch_array($res_vd2))
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
									
									$sql_tx1="select * from quote_tax where qt_refid='$refid'";
									$res_tx1=mysql_query($sql_tx1);
									$strTax1="";
									while($row_tx1=mysql_fetch_array($res_tx1))
									{
									$strTax1 .= '<span>'.$row_tx1['qt_taxname'].'('.$row_tx1['qt_taxvalue'].') (%) </span>';
	
									} ?>
									
									</tbody>
								</table>
                                
                                <table class="table table-hover table-nomargin dataTable table-bordered">
                                <tr><td style="text-align:right">Items Total</td><td style="text-align:right"><label><?php echo $row_vd1['qt_itemtotal']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(-)Discount</strong> <?php if($row_vd1['qt_discountpercent']!="" && $row_vd1['qt_discountpercent']!=0){ echo "(".$row_vd1['qt_discountpercent']."%)"; }?></td><td style="text-align:right"><label><?php echo $row_vd1['qt_discount']; ?></label></td></tr>
                                <tr><td style="text-align:right"><strong>(+) Shipping & Handling Charges</strong> </td><td style="text-align:right"><label><?php echo $row_vd1['qt_shipping_charges']; ?></label></td></tr>
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
                               $sql_usr="select * from admin where username='$user'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_array($res_usr);
$usremail=$row_usr['emailid'];
?> 
													<a href="edit_quote.php?id=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Edit</button></a>
                                                    <a  href="tcpdf/examples/index.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">Save As PDF</button></a>
                            						<a  href="tcpdf/examples/index4.php?refid=<?php echo $refid; ?>" style="margin-left:10px;"><button class="btn btn-primary">UK Invoice</button></a>
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

