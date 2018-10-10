<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include 'lib/header.php';

$refid = $_REQUEST['id'];

$row_vd1 = get_quotedetail($refid);

$quote_products = get_quoteproducts($refid);
$cont = count($quote_products);
$mycon = $cont;
$tot_sec4 = $mycon;

$tax = 0;
$a = 1;
$row_tax = select_taxes();
foreach ($row_tax as $row_tax1) {
    $tax = $tax + $row_tax1['tax_value'];
}

?>
<script>
    var cnt = <?php echo $mycon; ?>;
    function AddRow() {

        cnt++;

        var newRow = jQuery('<tr id="addrowid' + cnt + '"></tr>'); // add new tr with dynamic id and then add new row with textfield.
        jQuery('table.authors-list').append(newRow);
        
            $.ajax({
            type: "GET",
            url: "addnewrow.php",
            data: "cnt=" + cnt,
            cache: false,
            success: function (html) {
                $("#addrowid" + cnt).html(html);
                $("#product_name" + cnt).select2();              
            }
        });

    }
</script>
<script src="assets/js/editquote.js"></script>

<div class="container-fluid" id="content">

    <div id="main">
        <input type="text"  name="hid_tx"  id="hid_tx" value="<?php echo $tax; ?>" style="display:none;">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Edit Quote no : <?php echo $row_vd1['qt_refid'] ?></h1>
                </div>
                <?php
                date_default_timezone_set("Asia/Calcutta");
                $dt = date('F d, Y');
                $week = date('l');
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
                        <a href="#">Edit Quote</a>
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
                            <h3><i class="icon-th-list"></i>Edit Quote no : <?php echo $row_vd1['qt_refid'] ?></h3>
                        </div>
                        <div class="box-content nopadding">
                            <form  method="POST" action="editquoteaction.php?refid=<?php echo $row_vd1['qt_refid']; ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
                                <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Group Tax</h3>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-hover table-nomargin dataTable table-bordered">
                                            <thead><tr><td>Tax Name</td><td>Tax Value</td><td>Tax Status</td></tr></thead>							<?php
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
                                            <tr><td><input type="radio" name="discount_final" <?php if ($row_vd1['qt_discountpercent'] == "zero") { ?> checked <?php } ?> value="zero" onClick="return DiscFinal(this.value)"> Zero Discount</td><td></td></tr>
                                            <tr><td><input type="radio" name="discount_final" <?php if ($row_vd1['qt_discountpercent'] != "zero" && $row_vd1['qt_discountpercent'] != "dpr") { ?> checked <?php } ?> value="r_perprice" onClick="return DiscFinal(this.value)"> % Price</td><td><input  type="text" id="per_price" name="per_price" <?php if ($row_vd1['qt_discountpercent'] != "zero" && $row_vd1['qt_discountpercent'] != "dpr") { ?> value="<?php echo $row_vd1['qt_discountpercent']; ?>" style="width:100px;display:block;" <?php } else { ?> style="width:100px;display:none;" <?php } ?> onBlur="DiscFinal('r_perprice')"/> %</td></tr>
                                            <tr><td><input type="radio" name="discount_final" <?php if ($row_vd1['qt_discountpercent'] == "dpr") { ?> checked <?php } ?> value="r_dpr" onClick="return DiscFinal(this.value)"> Direct Price Reduction</td><td><input  type="text" id="dpr" name="dpr" <?php if ($row_vd1['qt_discountpercent'] == "dpr") { ?> value="<?php echo $row_vd1['qt_discount'] ?>"  style="width:100px;display:block;" <?php } else { ?> style="width:100px;display:none;" <?php } ?> onBlur="DiscFinal('r_dpr')" /></td></tr>        
                                        </table>
                                    </div>
                                    <div class="modal-body">


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>

                                </div>

                                <input type="text"  name="numoftxt"  id="numoftxt" value="<?php echo $tot_sec4 ?>" style="display:none;"><input type="text"  name="qt_itemtotal"  id="qt_itemtotal" value="<?php echo $row_vd1['qt_itemtotal']; ?>" style="display:none;">
                                <div id="organisationid" class="control-group">
                                    <label for="textfield" class="control-label">Organisation</label>
                                    <div class="controls">
                                        <?php
                                        $orgnames = get_organisation();
                                        ?>

                                        <select id="qt_organisationid" class='select2-me input-xlarge' data-rule-required="true" name="qt_organisationid" class="select2-me input-xlarge" data-placeholder="Organisation Name" onChange="Organisation(this.value);">
                                            <option value="">-- Select Organisation --</option>
                                            <option value="0" <?php
                                            if ($row_vd1['qt_organisationid'] == 0) {
                                                echo "selected";
                                            }
                                            ?>>-- Individual--</option>
                                            <option value="-1">-- Add New --</option>
                                            <?php
                                            foreach ($orgnames as $values) {
                                                ?>
                                                <option value="<?php echo $values['org_id'] ?>" <?php if ($values['org_id'] == $row_vd1['qt_organisationid']) { ?> selected <?php } ?>>-- <?php echo ucwords($values['org_name']); ?> --</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div> 
                                <div id="myorgdetails" class="control-group " style="display:none" >
                                </div>

                                <div id="contactsid" class="control-group">
                                    <label for="textfield" class="control-label">Contacts</label>
                                    <div class="controls">
                                            <!-- <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="Contacts(this.value);showcontdata(this.value);">-->
                                        <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="showcontdata(this.value);">
                                            <option value="">-- Select Contacts --</option>
                                            <option value="-1">-- Add New --</option>
                                            <?php
                                            $contactdet = get_contacts();
                                            foreach ($contactdet as $values) {
                                                ?>
                                                <option <?php if ($values['cont_id'] == $row_vd1['qt_contacts']) { ?> selected <?php } ?> value="<?php echo $values['cont_id'] ?>"><?php echo ucwords($values['cont_firstname'] . " " . $values['cont_lastname']) ?></option>
                                                <?php
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
                                        <input type="text" id="qt_subject" data-rule-required="true" name="qt_subject" class="input-xlarge" value="<?php echo $row_vd1['qt_subject']; ?>" data-placeholder="Subject">
                                    </div> 
                                </div>
                                <div class="control-group" class="control-group divhalf">
                                    <label for="textfield" class="control-label">Additional info</label>
                                    <div class="controls">
                                        <input type="text" id="qt_addinfo" name="qt_addinfo" class="input-xlarge" data-placeholder="Info" value="<?php echo $row_vd1['qt_addinfo']; ?>">
                                    </div> 
                                </div>

                                <div class="control-group">
                                    <label for="textarea" class="control-label">Terms &amp; Conditions</label>
                                    <div class="controls">
                                        <textarea name="content1" id="elm1" rows="5" class="input-block-level"><?php echo $row_vd1['qt_tnc']; ?></textarea>
                                    </div>
                                </div> <!-- qt tnc-->
                                <table id="myTable1" class="table table-hover table-nomargin dataTable table-bordered authors-list">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Item Details</th>
                                            <th>Currency <select id="qt_cur" name="qt_cur">
                                                    <option <?php if ($row_vd1['qt_currency'] == " ") { ?> selected <?php } ?> value="">Select Type</option>
                                                    <option <?php if ($row_vd1['qt_currency'] == "inr") { ?> selected <?php } ?> value="inr" selected>India, Rupees (₹) </option>
                                                    <option <?php if ($row_vd1['qt_currency'] == "dollar") { ?> selected <?php } ?> value="dollar">USA, Dollar ($)</option>
                                                    <option <?php if ($row_vd1['qt_currency'] == "pounds") { ?> selected <?php } ?> value="pounds">UK, Pounds (£)</option>
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
                                        <?php
                                        $k = 1;

                                        $quote_products = get_quoteproducts($refid);

                                        foreach ($quote_products as $values) {

                                            echo $values['product_sku'];
                                            ?>
                                            <tr id="addrowid<?php echo $k ?>">
                                                <th><?php if ($k > 1) { ?> <a href="#" onclick="RemoveRow('<?php echo $k; ?>')">Del</a> <?php } ?></th>
                                                <th>
                                        <div class="control-group">

                                            <div class="controls">
                                                <select name="product_name<?php echo $k ?>" id="product_name<?php echo $k ?>" data-rule-required="true"  onChange="product_Desc(this.value, '<?php echo $k ?>');
                                                        product_Price(this.value, '1');
                                                        sord(this.value, '1')">
                                                    <option value="">-- Select Product --</option>
                                                    <option<?php if ($values['product_sku'] == "other") { ?> selected <?php } ?> value="other/other">-- Other --</option>
                                                    <?php
                                                    $pro_list = get_products();

                                                    foreach ($pro_list as $row_sec4) {
                                                        ?>

                                                        <option <?php if ($values['product_sku'] == $row_sec4['sku']) { ?> selected <?php } ?> value="<?php echo $row_sec4['sku'] . "/" . utf8_encode($row_sec4['name']) ?>"><?php echo utf8_encode(ucwords($row_sec4['name'])) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                                <textarea name="product_desc<?php echo $k ?>" id="product_desc<?php echo $k ?>" rows="5" class="input-block-level"><?php echo $values['product_desc'] ?></textarea> <input type="text"  name="prod_fullname<?php echo $k ?>" id="prod_fullname<?php echo $k ?>" value="<?php echo $values['product_name'] ?>" <?php if ($values['product_sku'] != "other") { ?> style="display:none;" <?php } else { ?>  style="display:block;" <?php } ?>><input type="text"  name="prod_sku<?php echo $k ?>" id="prod_sku<?php echo $k ?>" value="<?php echo $values['product_sku']; ?>" style="display:none;">
                                                <div id="product_catalog<?php echo $k ?>"><?php if ($values['product_catalog'] != "No Catalog Found") { ?><a target="new" href="catalog/<?php echo $values['product_catalog'] . ".pdf" ?>"><?php echo utf8_encode($values['product_catalog']) . ".pdf" ?></a><?php } ?><input type="text"  name="prod_catalog<?php echo $k; ?>" id="prod_catalog<?php echo $k; ?>" value="<?php echo $values['product_catalog']; ?>" style="display:none;"></div><input type="checkbox" id="prod_spec_show<?php echo $k; ?>" name="prod_spec_show<?php echo $k; ?>" value="yes" <?php if ($values['product_spec_show'] == "yes") { ?> checked="checked" <?php } ?>  /> Show Specification
                                            </div>
                                        </div>
                                        <?php
                                        $sp = str_replace(',', '', $values['product_sellingprice']);
                                        $totsp = $sp * $values['product_quantity'];
                                        ?>
                                        </th>
                                        <th><input type="text"  name="quantity<?php echo $k ?>" onBlur="sqty(this.value, '<?php echo $k ?>')" id="quantity<?php echo $k ?>" value="<?php echo $values['product_quantity']; ?>" class="input-xsmall" style="width:150px;" data-rule-required="true" ></th>
                                        <th><div><input type="text"  name="selling_price<?php echo $k ?>" id="selling_price<?php echo $k ?>" placeholder="0.00" value="<?php echo $values['product_sellingprice']; ?>" class="input-xsmall currency" style="width:150px;" data-rule-required="true" onBlur="sord(this.value, '<?php echo $k ?>')"></div><div>(-) Discount : </div><div>Total After Discount : </div></th>
                                        <th><div id="tot<?php echo $k ?>"><?php echo number_format($totsp, 2, '.', ','); ?></div>
                                        <div id="disc<?php echo $k ?>">0</div>
                                        <div id="tadisc<?php echo $k ?>"><?php echo number_format($totsp, 2, '.', ','); ?></div></th>
                                        <th><div id="net<?php echo $k ?>" class="net"><?php echo number_format($totsp, 2, '.', ','); ?></div></th>
                                        </tr>
                                        <?php
                                        $k++;
                                    }
                                    ?>
                                    </tbody>
                                </table>

                                <?php
                                $adjustment = "";
                                if ($row_vd1['qt_adj_add'] != 0.00 && $row_vd1['qt_adj_add'] != "") {
                                    $adjustment = $row_vd1['qt_adj_add'];
                                } elseif ($row_vd1['qt_adj_sub'] != 0.00 && $row_vd1['qt_adj_sub'] != "") {
                                    $adjustment = $row_vd1['qt_adj_sub'];
                                } else {
                                    $adjustment = "0.00";
                                }
                                ?>

                                <div style="padding:10px 50px"><a href="javascript:void(0);" onClick="AddRow();" class="btn btn-primary"> + Add New Product</a></div>
                                <table class="table table-hover table-nomargin dataTable table-bordered">
                                    <tr><td style="text-align:right">Items Total</td><td style="text-align:right"><div id="ittot1"><?php echo $row_vd1['qt_itemtotal']; ?></div></td></tr>
                                    <tr><td style="text-align:right"><a href="#modal-2" role="button" class="btn" data-toggle="modal" onClick="taxval();"><strong style="color:#56AF45">(-)Discount</strong></a></td><td style="text-align:right"><div id="ittot2"><?php echo $row_vd1['qt_discount']; ?></div><input type="text"  name="qt_discount" id="qt_discount" value="<?php echo $row_vd1['qt_discount']; ?>" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><strong>(+) Shipping & Handling Charges</strong> </td><td style="text-align:right"><input type="text"  name="shippin_charges" id="shippin_charges" placeholder="0.00" value="<?php echo $row_vd1['qt_shipping_charges']; ?>" class="input-xsmall" style="width:150px;text-align:right" data-rule-required="true" onBlur="scharge(this.value)"></td></tr>
                                    <tr><td style="text-align:right">Pre Tax Total</td><td style="text-align:right"><div id="ittot3"><?php echo $row_vd1['qt_pretax_total']; ?></div><input type="text"  name="pretaxtotal" id="pretaxtotal" value="<?php echo $row_vd1['qt_pretax_total']; ?>" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><a href="#modal-1" role="button" class="btn" data-toggle="modal" onClick="taxval();"><span><?php
                                                    $taxamount = select_taxes();
                                                    foreach ($taxamount as $ttaxes) {
                                                        echo "(" . $ttaxes['tax_name'] . " " . $ttaxes['tax_value'] . "%) ";
                                                    }
                                                    ?>

                                                </span><strong style="color:#56AF45">(+)Tax</strong></a></td><td style="text-align:right"><div id="ittot4"><?php echo $row_vd1['qt_tax']; ?></div><input type="text"  name="tax_total" id="tax_total" value="<?php echo $row_vd1['qt_tax']; ?>" style="display:none;"></td></tr>
                                    <tr><td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td><td style="text-align:right"><div id="ittot5">0.00</div></td></tr>
                                    <tr><td style="text-align:right">Adjustment <span><input type="radio" id="add" name="group1" value="add" <?php if ($row_vd1['qt_adj_add'] != "") { ?> checked <?php } ?> onClick="sadjust1();"> Add</span><span>
                                                <input type="radio" id="subtract" name="group1" value="subtract" <?php if ($row_vd1['qt_adj_sub'] != "") { ?> checked <?php } ?> onClick="sadjust1();"> Subtract</span>
                                        </td><td style="text-align:right"><input type="text"  name="adjustment" id="adjustment" placeholder="0.00" value="<?php echo $adjustment; ?>"  class="input-xsmall" style="width:150px;text-align:right" data-rule-required="true" onBlur="sadjust(this.value)"></td></tr>
                                    <tr><td style="text-align:right;font-size:20px">Grand Total</td><td style="text-align:right"><div id="ittot6" style="font-size:20px;"><?php echo $row_vd1['qt_grandtotal'] ?></div><input type="text"  name="grandtotal" id="grandtotal" value="<?php echo $row_vd1['qt_grandtotal'] ?>" style="display:none;"></td></tr>
                                </table>
                                <?php
                              
                                $udetails = admindetails_byusername($_SESSION['login_user']);

                                $usremail = $udetails[0]['emailid'];
                                ?>



                                <div class="form-actions" style="background:none !important;">
                                    <button id="save" name="save" type="submit"  class="btn btn-primary">Save</button>
<?php /* ?><button <?php if($usremail==""){?> disabled <?php } ?> id="savensend" name="savensend" type="submit"  class="btn btn-primary">Save and Send PDF</button><?php */ ?>
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