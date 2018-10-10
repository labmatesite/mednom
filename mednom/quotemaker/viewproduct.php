<?php
//include('../connection2.php');
include_once 'lib/dbfunctionjugal.php';
$val1=$_REQUEST['val1'];
if($val1!="")
{
	$multiple_data = get_multiple_productprice_bysku($val1);
	
		// if(count($multiple_data) > 1){
		// 	echo "<script> 
		// 		 swal({title : '<h4>Product Has Multiple Price</h4>";
		// 		foreach($multiple_data as $row){ 
		// 			echo "<p>".$row['sku']." : &nbsp;&nbsp;&nbsp; $ <a id=\"".$row['final_inr']."\" onclick=\"changeValue(this)\" >".$row['final_inr']."</a></p>"; 
		// 		} 
		// 	echo "',html:'You can use bold text</br>and other HTML tags'}); </script>";
		// } 
	
	$proattributes = get_product_attributes($val1);
	$proattribute = json_decode($proattributes['specifications']);
	//$optattribute = $proattributes['accessories_optional'];
	foreach ($proattribute as $key => $attr1) {
		if ($attr1) {
			echo  $key . " : ";
			if (is_object($attr1)){
				foreach ($attr1 as $n => $n_spec) {
					if ($n_spec) {
						echo "\n"."\t".$n . " : ".$n_spec. "";
					}
				}
				echo "\n";
			}else{
				$attr1 = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3',$attr1);
				echo htmlentities($attr1) ."\n";
			}
		}                                   
	}
	if(!empty($proattributes['rotor_selections'])){
		$value1 ="<h4 class=\"text-danger\">Mention : Rotor Selections</h4>".$proattributes['rotor_selections']."<br><br>"; 
		//$value1 = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3',$value1);
	}	
	if(!empty($proattributes['optional_blocks'])){	
		$value2 = "<h4 class=\"text-danger\">Mention : Optional Blocks</h4>".$proattributes['optional_blocks']."<br><br>"; 
		//$value2 = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3',$value2); 
	}
	if(!empty($proattributes['standard_safety_devices'])){	
		$value3 = "<h4 class=\"text-danger\">Mention : Standard Safety Devices</h4>".$proattributes['standard_safety_devices']."<br><br>"; 
		//$value2 = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3',$value2); 
	}
	if(!empty($proattributes['safety_unit'])){	
		$value4 = "<h4 class=\"text-danger\">Mention : Safety Unit</h4>".$proattributes['safety_unit']."<br><br>"; 
		//$value2 = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3',$value2); 
	}
	if(!empty($value1) || !empty($value2) || !empty($value3) || !empty($value4)){
		$value  = "<p class=\"text-center\">Please Copy Paste The Required Subparts !</p><br>
					<div class=\"text-center\">"
						.(!empty($value1) ? $value1 : '').""
						.(!empty($value2) ? $value2 : '').""
						.(!empty($value2) ? $value3 : '').""
						.(!empty($value3) ? $value4 : '')
					."</div>";       
		echo "<script>bootbox.alert({title:'Please Mention Product Sub Part',message:'".str_replace(array("\r","\n"),'',$value)."',size:'large'});</script>";
	}
}
?>  