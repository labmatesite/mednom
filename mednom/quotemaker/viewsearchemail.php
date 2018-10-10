<?php
//include('../connection2.php');
include_once 'lib/dbfunctionjugal.php';
if (isset($_REQUEST['eadd'])&&!empty($_REQUEST['eadd']))
{
$eadd=$_REQUEST['eadd'];

if($eadd!="")
{
//$sql_pin="select * from quote_organisation where org_primaryemail='$eadd' or org_secondaryemail='$eadd' or org_tertiaryemail ='$eadd'";
//$res_pin=mysql_query($sql_pin);
$tot_pin=get_organisation_byemail($eadd);
//echo $tot_pin;
?>

				<?php
				if($tot_pin==0)
				{	
				?>			
				<input type="text" id="primaryemailid"  style="display:none" value="1"  /><span style="color:#063">Available</span>
                
				<?php
			
			  }
			  else
			  {
				  ?>
				<input type="text" id="primaryemailid" style="display:none"  value="2"   /> <span> Not Avaliable</span>
			  
              <?php
			   }
}
}
else
{
}
			  ?>
