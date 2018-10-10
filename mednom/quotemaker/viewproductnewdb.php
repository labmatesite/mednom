<?php
//include('../connection2.php');
 include_once 'lib/dbfunctionjugal.php';
$val1=$_REQUEST['val1'];
if($val1!="")
{
//echo $val1;
$proattributes = get_product_attributes($val1);

//$proattributes = json_encode($proattributes);

$proattribute = json_decode($proattributes['specifications']);
//var_dump($proattributes);


				foreach($proattribute as $key=>$attr1){
//foreach($proattributes as $key$attri)
//{
	if(is_object($attr1))	{
	}
	else
	{
		if($attr1!='')
		{
echo utf8_encode(trim($key)).":".utf8_encode(trim($attr1))."\n";
		}
	}
}

}
			  ?>
 