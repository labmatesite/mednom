<?php
//include('../connection2.php');
 include_once 'lib/dbfunctionjugal.php';

if (isset($_REQUEST['eadd'])&&!empty($_REQUEST['eadd']))
{
$eadd=$_REQUEST['eadd'];

if($eadd!="")
{
//$sql_pin="select * from quote_contacts where  cont_primaryemail='$eadd' or cont_secondaryemail='$eadd'";
//$res_pin=mysql_query($sql_pin);

$tot_pin=get_contacts_byemail($eadd);

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
