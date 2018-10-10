<?php
//include('../connection2.php');
 include_once 'lib/dbfunctionjugal.php';

if (isset($_REQUEST['orgname'])&&!empty($_REQUEST['orgname']))
{
$orgname=$_REQUEST['orgname'];

if($orgname!="")
{

//$sql_pin="select * from quote_organisation where org_name='$orgname'";
//$res_pin=mysql_query($sql_pin);
$tot_pin=get_organisation_byname($orgname);

?>

				<?php
				if($tot_pin==0)
				{	
				?>			
				<input type="text" id="orgnameid"  style="display:none" value="1"  /><span style="color:#063">Available</span>
                
				<?php
			
			  }
			  else
			  {
				  ?>
				<input type="text" id="orgnameid" style="display:none"  value="2"   /> <span> Not Avaliable</span>
			  
              <?php
			   }
}
}
else
{
}
			  ?>
