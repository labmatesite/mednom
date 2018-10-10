<?php
//include('../connection2.php');
    include_once 'lib/dbfunctionjugal.php';
$cnt=$_REQUEST['cnt'];
$username=$_REQUEST['username'];
$udetails = admindetails_byusername($username);
	if($udetails[0]['price']!='')
											{
												$upr = $udetails[0]['price'];
											}
											else
											{
												$upr ="final_inr";
											}
											 
?>

    

                                       		
<th><a href="javascript:void(0);" onclick="RemoveRow('<?php echo $cnt; ?>')">Del</a></th>
                                            <th>
                                          <div class="control-group">
                                         <div class="controls">
    	<select name="product_name<?php echo $cnt; ?>" id="product_name<?php echo $cnt; ?>"  class="select2-me input-xlarge" data-placeholder="Product Name" onChange="product_Desc(this.value,<?php echo $cnt ?>);product_Price(this.value,'<?php echo $cnt ?>','<?php echo $username ?>','<?php echo $upr  ?>')">
                                                 <option value="">-- Select Product --</option>
                                                 <option value="other/other">-- Other --</option>
                                                 <?php
$pronames = get_products();
foreach($pronames as $values)
{
?>
 <option value="<?php echo $values['sku']."/".utf8_encode(ucwords($values['name'])); ?>">-- <?php echo utf8_encode(ucwords($values['name'])); ?> --</option>
<?php
}
	
											
												  ?>
                                            	 </select>
                                             
                                             <textarea name="product_desc<?php echo $cnt; ?>" id="product_desc<?php echo $cnt; ?>" rows="5" class="input-block-level"></textarea> <input type="text"  name="prod_fullname<?php echo $cnt; ?>" id="prod_fullname<?php echo $cnt; ?>" value="" style="display:none;"><input type="text"  name="prod_sku<?php echo $cnt; ?>" id="prod_sku<?php echo $cnt; ?>" value="" style="display:none;">
                                              <div id="product_catalog<?php echo $cnt; ?>"></div><input type="checkbox" id="prod_spec_show<?php echo $cnt; ?>" name="prod_spec_show<?php echo $cnt; ?>" value="yes" checked="checked" /> Show Specification
                                             </div>
                                	</div></th>
											<th><input type="text"  name="quantity<?php echo $cnt; ?>" onBlur="sqty(this.value,<?php echo $cnt; ?>)" id="quantity<?php echo $cnt; ?>" value="1" class="input-xsmall" style="width:150px;" data-rule-required="true" ></th>
                                            <th><div><input type="text"  name="selling_price<?php echo $cnt; ?>" id="selling_price<?php echo $cnt; ?>" value="0.00" class="input-xsmall  currency" style="width:150px;" data-rule-required="true" onBlur="sord(this.value,<?php echo $cnt; ?>)"></div><div>(-) Discount : </div><div>Total After Discount : </div></th>
                                            <th><div id="tot<?php echo $cnt; ?>">0</div><div id="disc<?php echo $cnt; ?>">0</div><div id="tadisc<?php echo $cnt; ?>">0.00</div></th>
                                         	<th><div id="net<?php echo $cnt; ?>" class="net">0.00</div></th>
								