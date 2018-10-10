<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include 'lib/header.php';
$tax = 0;
$a = 1;
$row_tax = select_taxes();
foreach ($row_tax as $row_tax1) {
    $tax = $tax + $row_tax1['tax_value'];
}
?><!-- PLUpload -->
<script src="assets/js/createquote.js"></script>

<script type="text/javascript">
    function stopRKey(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text")) {
            return false;
        }
    }
    document.onkeypress = stopRKey;
</script> 

<script type="text/javascript">
    function loadingImg()
    {
        jquery("#loadingImg").show();
    }
</script>

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

<div class="container-fluid" id="content">
    <input type="text"  name="hid_tx"  id="hid_tx" value="<?php echo $tax; ?>" style="display:none;">
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Create Quote</h1>
                </div>
                <?php
                date_default_timezone_set("Asia/Calcutta");
                $dt = date('F d, Y');
                $week = date('l');
                ?>
                 <?php
                            
                                $udetails = admindetails_byusername($_SESSION['login_user']);

                                $usremail = $udetails[0]['emailid'];
								
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
                        <a href="#">Create Quote</a>
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
                            <h3><i class="icon-th-list"></i>Create Quote</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form  method="POST" action="createquoteaction.php" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
                                <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Group Tax</h3>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-hover table-nomargin dataTable table-bordered">
                                            <thead><tr><td>Tax Name</td><td>Tax Value</td><td>Tax Status</td></tr></thead>							<?php
                                            //while($row_tx=mysql_fetch_array($res_tx))
                                            $taxamount = select_taxes();
                                            foreach ($taxamount as $ttaxes) {
                                                ?>
                                                <tr><td><?php echo $ttaxes['tax_name']; ?></td><td><?php echo $ttaxes['tax_value'] . "%"; ?></td><td><input type="checkbox" name="st<?php echo $ttaxes['tax_id']; ?>" id="st<?php echo $ttaxes['tax_id']; ?>" <?php if ($ttaxes['tax_status'] == "active") { ?>; checked <?php } ?> onClick="tax('<?php echo $ttaxes['tax_id']; ?>', '<?php echo $ttaxes['tax_value']; ?>', '<?php echo $ttaxes['tax_status']; ?>', '<?php echo $ttaxes['tax_name']; ?>')" ></td></tr>
                                                <?php
                                            }
                                            ?>
                                        </table>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>

                                </div>

                                <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Set Disocunt For : <span id="DiscPrice"></span></h3>
                                        <table class="table table-hover table-nomargin dataTable table-bordered">
                                            <tr><td><input type="radio" name="discount_final" checked value="zero" onClick="return DiscFinal(this.value)"> Zero Discount</td><td></td></tr>
                                            <tr><td><input type="radio" name="discount_final" value="r_perprice" onClick="return DiscFinal(this.value)"> % Price</td><td><input  type="text" id="per_price" name="per_price" value="" style="width:100px;display:none;" onBlur="DiscFinal('r_perprice')"/> %</td></tr>
                                            <tr><td><input type="radio" name="discount_final" value="r_dpr" onClick="return DiscFinal(this.value)"> Direct Price Reduction</td><td><input  type="text" id="dpr" name="dpr" value="" style="width:100px;display:none;" onBlur="DiscFinal('r_dpr')" /></td></tr>        
                                        </table>
                                    </div>
                                    <div class="modal-body">


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>

                                </div>

                                <input type="text"  name="numoftxt"  id="numoftxt" value="" style="display:none;"><input type="text"  name="qt_itemtotal"  id="qt_itemtotal" value="" style="display:none;">
                                <div id="organisationid" class="control-group ">
                                    <label for="textfield" class="control-label">Organisation</label>
                                    <div class="controls">
                                        <?php
                                        $orgnames = get_organisation();

                                        ?>
                                        <select id="qt_organisationid" data-rule-required="true" class='select2-me input-xlarge' name="qt_organisationid" data-placeholder="Organisation Name" onChange="Organisation(this.value);" style="width:200px;">
                                            <option value="">-- Select Organisation --</option>
                                            <option value="-1">-- Add New Organisation --</option>
                                            <option value="0">-- Individual --</option>
                                            <?php
                                            foreach ($orgnames as $values) {
                                                ?>
                                                <option value="<?php echo $values['org_id'] ?>">-- <?php echo $values['org_name'] ?> --</option>
                                                <?php
                                            }
                                            ?>

                                        </select>

                                    </div>

                                </div> 
                                <div id="myorgdetails" class="control-group " style="display:none" >
                                </div>

                                <div id="contactsid" class="control-group ">
                                    <label for="textfield" class="control-label">Contacts</label>
                                    <div class="controls">
                                        <select id="qt_contacts" data-rule-required="true" disabled name="qt_contacts"  data-placeholder="Contacts Name" onChange="Contac(this.value);">
                                            <option value="">-- Select Contacts --</option>
                                            <option value="-1">-- Add New --</option>
                                            <?php
                                            if ($row_ad['userType'] != "Superadmin") {
                                                $sql_sec3 = "select * from quote_contacts where cont_assignedto='" . $username . "' order by cont_firstname,cont_lastname";
                                            } else {
                                                $sql_sec3 = "select * from quote_contacts order by cont_firstname,cont_lastname";
                                            }
                                            $res_sec3 = mysqli_query($sql_sec3);
                                            while ($row_sec3 = mysqli_fetch_array($res_sec3)) {
                                                ?>
                                                <?php
                                                echo "<option value='" . $row_sec3['cont_id'] . "'>" . ucwords($row_sec3['cont_firstname'] . " " . $row_sec3['cont_lastname']) . "</option>";
                                            }
                                            ?>
                                        </select>


                                    </div>

                                </div> 
                                <div style="clear:both;"></div>


                                <div class="control-group" class="control-group divhalf" style="display:none" id="mycontdet">

                                </div>

                                <div class="control-group" class="control-group divhalf">
                                    <label for="textfield" class="control-label">Subject</label>
                                    <div class="controls">
                                        <input type="text" id="qt_subject" data-rule-required="true" name="qt_subject" class="input-xlarge" data-placeholder="Subject">
                                    </div> 
                                </div>

                                <div class="control-group" class="control-group divhalf">
                                    <label for="textfield" class="control-label">Additional info</label>
                                    <div class="controls">
                                        <input type="text" id="qt_addinfo" name="qt_addinfo" class="input-xlarge" data-placeholder="Info">
                                    </div> 
                                </div>

                                <div class="control-group">
                                    <label for="textarea" class="control-label">Terms &amp; Conditions</label>
                                    <div class="controls">
                                        <textarea name="content1" id="elm1" rows="5" class="input-block-level"><?php 
										if($udetails[0]['tnc']!='')
										{
											echo $udetails[0]['tnc'];
										}
										else
										{
$terms = select_trmandcond(); 
echo $terms['tnc_content'];
										}

 ?></textarea>
                                    </div>
                                </div> <!-- qt tnc-->

                                <table class="table table-hover table-nomargin dataTable table-bordered authors-list">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Item Details</th>
                                            <th>Currency <select id="qt_cur" name="qt_cur" class="select2-me input-xsmall" required>
                                            <?php
											if($udetails[0]['currency']!='')
											{
												//$ucurren = $udetails[0]['currency'];
											?>
                               <?php if($udetails[0]['currency']=="inr"){?> <option value="inr" selected>India, Rupees (₹) </option><?php } ?>
                      <?php if($udetails[0]['currency']=="dollar"){?><option value="dollar" selected>USA, Dollar ($)</option><?php } ?>
                         <?php if($udetails[0]['currency']=="pounds"){?><option value="pounds" selected>UK, Pounds (£)</option><?php } ?>
                                                    <?php
													}
													else
													{
													?>
                                             <option value="inr">India, Rupees (₹) </option>       
                                                    <?php
													}
													?>
                                                </select>  </th>
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
                                        <tr id="addrowid1">
                                            <th></th>
                                            <th>
                                    <div class="control-group">

                                        <div class="controls">
                                             <?php 
											if($udetails[0]['price']!='')
											{
												$upr = $udetails[0]['price'];
											}
											else
											{
												$upr ="final_inr";
											}
											 
											  ?>  
                                            <select name="product_name" id="product_name" data-rule-required="true" class='select2-me input-xlarge' data-placeholder="Product Name" onChange="product_Desc(this.value, '1'); product_Price(this.value, '1','<?php echo $udetails[0]['username'];  ?>','<?php echo $upr;  ?>');">
                                                <option value="">-- Select Product --</option>
                                                <option value="other/other">-- Other --</option>
                                                <?php
                                                $pronames = get_products();
                                                foreach ($pronames as $values) {
                                                    ?>
                                                    <option value="<?php echo $values['sku'] . "/" . utf8_encode(ucwords($values['name'])); ?>">-- <?php echo utf8_encode(ucwords($values['name'])); ?> --</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                            <textarea name="product_desc1" id="product_desc1" rows="5" class="input-block-level"></textarea> <input type="text"  name="prod_fullname1" id="prod_fullname1" value="" style="display:none;"><input type="text"  name="prod_sku1" id="prod_sku1" value="" style="display:;">
                                            <div id="product_catalog1"></div><input type="checkbox" id="prod_spec_show1" name="prod_spec_show1" value="yes" checked="checked" /> Show Specification
                                        </div>
                                    </div></th>
                                    <th><input type="text"  name="quantity1" id="quantity1" value="1" class="input-xsmall" style="width:150px;" data-rule-required="true" onBlur="sqty(this.value,1)"></th>
                                    <!--
                                        for multiple price code added at
                                        Goto file : quotemaker/viewproduct.php 
                                    -->
                                    <th><div><input type="text"  name="selling_price1" id="selling_price1" placeholder="0.00" value="0.00" class="input-xsmall currency" style="width:150px;" data-rule-required="true" onBlur="sord(this.value, '1')" onChange="sord(this.value, '1');"></div><div>(-) Discount : </div><div>Total After Discount : </div></th>
                                    <th><div id="tot1">0</div><div id="disc1">0</div><div id="tadisc1">0.00</div></th>
                                    <th><div id="net1" class="net">0.00</div></th>
                                    </tr>

                                    </tbody>
                                </table><!-- javascript: return null; -->
          <div style="padding:10px 50px"><a href="javascript:void(0);" onClick="AddRow('<?php echo $udetails[0]['username'];  ?>');" class="btn btn-primary"> + Add New Product</a></div>
                                <table class="table table-hover table-nomargin dataTable table-bordered">
                                    <tr><td style="text-align:right">Items Total</td><td style="text-align:right"><div id="ittot1">0</div></td></tr>
                                    <tr><td style="text-align:right"><a href="#modal-2" role="button" class="btn" data-toggle="modal" onClick="taxval();"><strong style="color:#56AF45"><strong>(-)Discount</strong></strong></a></td><td style="text-align:right"><div id="ittot2">0.00</div><input type="text"  name="qt_discount" id="qt_discount" value="" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><strong>(+) Shipping & Handling Charges</strong> </td><td style="text-align:right"><input type="text"  name="shippin_charges" id="shippin_charges" placeholder="0.00" value="0.00" class="input-xsmall currency" style="width:150px;text-align:right" data-rule-required="true" onBlur="scharge(this.value)"></td></tr>
                                    <tr><td style="text-align:right"><strong>(+) Bank Charges</strong></td><td style="text-align:right"><!-- <div id="ittot7"> -->30.00<!-- </div> --><input type="text"  name="bankCharges" id="bankCharges" value="" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right">Pre Tax Total</td><td style="text-align:right"><div id="ittot3">0.00</div><input type="text"  name="pretaxtotal" id="pretaxtotal" value="" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><a href="#modal-1" role="button" class="btn" data-toggle="modal" onClick="taxval();"><span>

                                                    <?php
                                                    $taxamount = select_taxes();
                                                    foreach ($taxamount as $ttaxes) {
                                                        echo "(" . $ttaxes['tax_name'] . " " . $ttaxes['tax_value'] . "%) ";
                                                    }

                                                    ?>


                                                </span><strong style="color:#56AF45">(+)Tax</strong></a></td><td style="text-align:right"><div id="ittot4">0.00</div><input type="text"  name="tax_total" id="tax_total" value="" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td><td style="text-align:right"><div id="ittot5">0.00</div></td></tr>
                                    <tr><td style="text-align:right">Adjustment <span><input type="radio" id="add" name="group1" value="add" checked onClick="sadjust1();"> Add</span><span>
                                                <input type="radio" id="subtract" name="group1" value="subtract" onClick="sadjust1();"> Subtract</span>
                                        </td><td style="text-align:right"><input type="text"  name="adjustment" id="adjustment" placeholder="0.00" value="0.00"  class="input-xsmall currency" style="width:150px;text-align:right" data-rule-required="true" onBlur="sadjust(this.value)"></td></tr>
                                    <tr><td style="text-align:right;font-size:20px">Grand Total</td><td style="text-align:right"><div id="ittot6" style="font-size:20px;">0.00</div><input type="text"  name="grandtotal" id="grandtotal" value="" style="display:none;"></td></tr>
                                </table>
                               
                                <div class="form-actions" style="background:none !important;">
                                    <button id="save" name="save" type="submit"  class="btn btn-primary">Save</button>
                                    <button <?php if ($usremail == "") { ?> disabled <?php } ?> id="savensend" name="savensend" type="submit"  class="btn btn-primary">Save and Send PDF</button>
                                    <button <?php if ($usremail == "") { ?> disabled <?php } ?> id="emailwithpdf" name="emailwithpdf" type="submit"  class="btn btn-primary">Send Email with PDF</button>
                                    <button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content end -->
        </div>
    </div></div>

</body>


</html>