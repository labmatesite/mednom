<?php
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
if (isset($_POST['submit'])) {
  $re = update_organisation();
   if ($re == 1) {
        header('location:organisation.php');
    }
}
include_once 'lib/header.php';

$org_id = $_GET['org_id'];
?>
<script>
    function Organisation(value) {
        $.ajax({
            type: "GET",
            url: "searchorganisation.php",
            data: "value=" + value,
            cache: false,
            success: function (html) {
                $("#comp_1").html(html);
            }
        });
    }
    function PrimaryEmail(email) {
        $.ajax({
            type: "GET",
            url: "searchorganisation.php",
            data: "email=" + email,
            cache: false,
            success: function (html) {
                $("#comp_2").html(html);
            }
        });
    }
    function copybillingaddress() {
        var badd = document.getElementById('org_billingadd').value;
        document.getElementById('org_shippingadd').value = badd;

        var bpob = document.getElementById('org_billingpob').value;
        document.getElementById('org_shippingpob').value = bpob;

        var bcity = document.getElementById('org_billingcity').value;
        document.getElementById('org_shippingcity').value = bcity;

        var bstate = document.getElementById('org_billingstate').value;
        document.getElementById('org_shippingstate').value = bstate;

        var bpoc = document.getElementById('org_billingpoc').value;
        document.getElementById('org_shippingpoc').value = bpoc;

        var bcountry = document.getElementById('org_billingcountry').value;
        document.getElementById('org_shippingcountry').value = bcountry;

    }
    function copyshippingaddress() {
        var sadd = document.getElementById('org_shippingadd').value;
        document.getElementById('org_billingadd').value = sadd;

        var spob = document.getElementById('org_shippingpob').value;
        document.getElementById('org_billingpob').value = spob;

        var scity = document.getElementById('org_shippingcity').value;
        document.getElementById('org_billingcity').value = scity;

        var sstate = document.getElementById('org_shippingstate').value;
        document.getElementById('org_billingstate').value = sstate;

        var spoc = document.getElementById('org_shippingpoc').value;
        document.getElementById('org_billingpoc').value = spoc;

        var scountry = document.getElementById('org_shippingcountry').value;
        document.getElementById('org_billingcountry').value = scountry;
    }

</script>
<div id="results"></div>
<div class="loader"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div id="main">
    <div class="container-fluid">
        <div class="page-header">
            <div class="pull-left">
                <h1>Organisation</h1>
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
                    <a href="#">Organisation</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li>
                    <a href="#">View Organisation</a>
                </li>
            </ul>
            <div class="close-bread">
                <a href="#"><i class="icon-remove"></i></a>
            </div>
        </div>
        <!-- Main content start -->
        <?php
        $where = array('org_id' => $org_id);
        $row_org = selectAnd('quote_organisation', $where)
        ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="box box-bordered box-color">
                    <div class="box-title">
                        <h3><i class="icon-th-list"></i> Edit Organisation</h3>
                    </div>
                    <div class="box-content nopadding">
                        <div class="tab-content padding tab-content-inline tab-content-bottom" style="padding:20px 0 !important">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?org_id=' . $org_id; ?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                                 <?php
                                 // to show error during updating form
                                if (isset($_POST['submit'])) {
                                    if ($re == 0) {
                                        echo '<div class="msg"><p>Some error has occurred during submission. Please try again.</p></div>';
                                    }
                                }
                                ?>
                                <div style="height:40px;font-size:18px" align="left"><strong>Organization Details</strong></div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Organisation Name<span style="color:#F00;">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="org_name" id="org_name" placeholder="Organisation Name" class="input-xlarge" data-rule-required="true" data-rule-minlength="3" onchange="Organisation(this.value);" value="<?php echo $row_org['org_name'] ?>">
                                        <span id="comp_1" style="color:#FF0000;"></span>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Email</label>
                                    <div class="controls">
                                        <input type="text"  onchange="PrimaryEmail(this.value);" data-rule-email="true" class="input-xlarge" placeholder="Primary Email" id="org_primaryemail" name="org_primaryemail" value="<?php echo $row_org['org_primaryemail'] ?>">
                                        <span style="color:#FF0000;" id="comp_2"></span>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Phone</label>
                                    <div class="controls">
                                        <input type="text"  id="org_primaryphone" name="org_primaryphone" placeholder="Only numbers" value="<?php echo $row_org['org_primaryphone'] ?>">
                                    </div> 

                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Secondary Email</label>
                                    <div class="controls">
                                        <input type="text" data-rule-email="true" class="input-xlarge" placeholder="Secondary Email" id="org_secondaryemail" name="org_secondaryemail" value="<?php echo $row_org['org_secondaryemail'] ?>">

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Alt Phone</label>
                                    <div class="controls">
                                        <input type="text"  id="org_altphone" name="org_altphone" placeholder="Only numbers" value="<?php echo $row_org['org_altphone'] ?>">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Tertiary Email</label>
                                    <div class="controls">
                                        <input type="text"  data-rule-email="true" class="input-xlarge" placeholder="Tertiary Email" id="org_tertiaryemail" name="org_tertiaryemail" value="<?php echo $row_org['org_tertiaryemail'] ?>">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Fax</label>
                                    <div class="controls">
                                        <input type="text"  id="org_fax" name="org_fax" placeholder="Only numbers" value="<?php echo $row_org['org_fax'] ?>">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Website</label>
                                    <div class="controls">
                                        <input type="text" data-rule-minlength="3" class="input-xlarge" placeholder="Website" id="org_website" name="org_website" value="<?php echo $row_org['org_website'] ?>">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Assigned to<span style="color:#F00;">*</span></label>
                                    <div class="controls">
                                        <?php
                                        $row_a = selectAll('admin');
                                        ?>
                                        <select id="org_assignedto" name="org_assignedto" class='select2-me input-xlarge' disabled data-rule-required="true">
                                            <option value="">Select an Option</option>
                                            <?php
                                            foreach ($row_a as $key => $value) {
                                                ?>
                                                <option <?php if ($value['username'] == $row_org['org_assignedto']) { ?> selected <?php } ?> value="<?php echo $value['username'] ?>"><?php echo ucwords($value['username']); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label" >Industry</label>
                                    <div class="controls">
                                        <select id="org_industry" name="org_industry" class='select2-me input-xlarge'>
                                            <option <?php if ("" == $row_org['org_industry']) { ?> selected <?php } ?>  value="">Select an Option</option>
                                            <option <?php if ("apparel" == $row_org['org_industry']) { ?> selected <?php } ?>  value="apparel">Apparel</option>
                                            <option <?php if ("hospitality" == $row_org['org_industry']) { ?> selected <?php } ?>  value="hospitality">Hospitality</option>
                                            <option <?php if ("insurance" == $row_org['org_industry']) { ?> selected <?php } ?>  value="insurance">Insurance</option>
                                            <option <?php if ("shipping" == $row_org['org_industry']) { ?> selected <?php } ?>  value="shipping">Shipping</option>
                                            <option <?php if ("telecommunications" == $row_org['org_industry']) { ?> selected <?php } ?>  value="telecommunications">Technology</option>
                                            <option <?php if ("telecommunications" == $row_org['org_industry']) { ?> selected <?php } ?>  value="telecommunications">Telecommunications</option>
                                            <option <?php if ("healthcare" == $row_org['org_industry']) { ?> selected <?php } ?>  value="healthcare">Healthcare</option>
                                            <option <?php if ("biotechnology" == $row_org['org_industry']) { ?> selected <?php } ?>  value="biotechnology">Food &amp; Beverage</option>
                                            <option <?php if ("biotechnology" == $row_org['org_industry']) { ?> selected <?php } ?>  value="biotechnology">Biotechnology</option>
                                            <option <?php if ("chemicals" == $row_org['org_industry']) { ?> selected <?php } ?>  value="chemicals">Chemicals</option>
                                            <option <?php if ("other" == $row_org['org_industry']) { ?> selected <?php } ?>  value="other">Other</option>
                                            <option <?php if ("recreation" == $row_org['org_industry']) { ?> selected <?php } ?>  value="recreation">Recreation</option>
                                            <option <?php if ("retail" == $row_org['org_industry']) { ?> selected <?php } ?>  value="retail">Retail</option>
                                            <option <?php if ("shipping" == $row_org['org_industry']) { ?> selected <?php } ?>  value="shipping">Shipping</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">CST</label>
                                    <div class="controls">
                                        <input type="text" name="org_cst" id="org_cst" placeholder="Organisation CST" value="<?php echo $row_org['org_cst'] ?>" class="input-xlarge">

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">VAT</label>
                                    <div class="controls">
                                        <input type="text" name="org_vat" id="org_vat" placeholder="Organisation VAT" value="<?php echo $row_org['org_vat'] ?>" class="input-xlarge" >

                                    </div>
                                </div>

                                <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Address</label>
                                    <div class="controls">
                                        <textarea id="org_billingadd" name="org_billingadd"><?php echo $row_org['org_billingadd'] ?></textarea>
                                        <a onClick="copyshippingaddress()" href="javascript: void(0);">Copy Shipping Address</a>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Address</label>
                                    <div class="controls">
                                        <textarea id="org_shippingadd" name="org_shippingadd"><?php echo $row_org['org_shippingadd'] ?></textarea>
                                        <a onClick="copybillingaddress()" href="javascript: void(0);">Copy Billing Address</a>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing PO Box</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingpob" id="org_billingpob" value="<?php echo $row_org['org_billingpob'] ?>" placeholder="Billing PO Box" class="input-xlarge" >
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping PO Box</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingpob" id="org_shippingpob" value="<?php echo $row_org['org_shippingpob'] ?>" placeholder="Shipping PO Box" class="input-xlarge" >

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing City</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingcity" id="org_billingcity" value="<?php echo $row_org['org_billingcity'] ?>" placeholder="Billing City" class="input-xlarge" > 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping City</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingcity" id="org_shippingcity" value="<?php echo $row_org['org_shippingcity'] ?>" placeholder="Shipping City" class="input-xlarge" >
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing State</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingstate" id="org_billingstate" value="<?php echo $row_org['org_billingstate'] ?>" placeholder="Billing State" class="input-xlarge" >  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping State	
                                    </label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingstate" id="org_shippingstate" placeholder="Shipping State" value="<?php echo $row_org['org_shippingstate'] ?>" class="input-xlarge" >  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Postal Code</label>
                                    <div class="controls">
                                        <input type="text"  id="org_billingpoc" name="org_billingpoc" placeholder="Only numbers" value="<?php echo $row_org['org_billingpoc'] ?>"> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Postal Code</label>
                                    <div class="controls">
                                        <input type="text"   id="org_shippingpoc" name="org_shippingpoc" placeholder="Only numbers" value="<?php echo $row_org['org_shippingpoc'] ?>"> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Country</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingcountry" id="org_billingcountry" placeholder="Billing Country" class="input-xlarge" value="<?php echo $row_org['org_billingcountry'] ?>">  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Country</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingcountry" id="org_shippingcountry" placeholder="Shipping Country" class="input-xlarge" value="<?php echo $row_org['org_shippingcountry'] ?>">   
                                    </div>
                                </div>

                                <div style="clear:both;"></div>
                                <div class="control-group">
                                    <label for="textarea" class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="org_desc" id="elm1" rows="5" class="input-block-level"><?php echo $row_org['org_desc'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" onClick="window.history.back()" class="btn">Cancel</button>
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

