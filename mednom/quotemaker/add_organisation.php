<?php
session_start();
include 'lib/function.php';
include 'lib/database.php';
checkUser();
if (isset($_POST['submit'])) {
    $re = add_quote();
    if ($re == 1) {
        header('location:organisation.php');
    }
}
include_once 'lib/header.php';
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
        <!-- main containt start -->
        <div class="row-fluid">
            <div class="span12">
                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h3><i class="icon-th-list"></i> Add Organisation</h3>
                    </div>
                    <div class="box-content nopadding">
                        <div class="tab-content padding tab-content-inline tab-content-bottom" style="padding:20px 0 !important">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                                <?php
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
                                        <input type="text" name="org_name" id="org_name" placeholder="Organisation Name" class="input-xlarge" data-rule-required="true" data-rule-minlength="3" onblur="Organisation(this.value);">
                                        <span id="comp_1" style="color:#FF0000;"></span>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Email</label>
                                    <div class="controls">
                                        <input type="text" onblur="PrimaryEmail(this.value);" data-rule-email="true" class="input-xlarge" placeholder="Primary Email" id="org_primaryemail" name="org_primaryemail">
                                        <span style="color:#FF0000;" id="comp_2"></span>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Phone</label>
                                    <div class="controls">

                                        <input type="text"  id="org_primaryphone" name="org_primaryphone" placeholder="Only numbers">
                                    </div> 

                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Secondary Email</label>
                                    <div class="controls">
                                        <input type="text" data-rule-email="true" class="input-xlarge" placeholder="Secondary Email" id="org_secondaryemail" name="org_secondaryemail">

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Alt Phone</label>
                                    <div class="controls">
                                        <input type="text"  id="org_altphone" name="org_altphone" placeholder="Only numbers">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Tertiary Email</label>
                                    <div class="controls">
                                        <input type="text"  data-rule-email="true" class="input-xlarge" placeholder="Tertiary Email" id="org_tertiaryemail" name="org_tertiaryemail">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Fax</label>
                                    <div class="controls">
                                        <input type="text"  id="org_fax" name="org_fax" placeholder="Only numbers">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Website</label>
                                    <div class="controls">
                                        <input type="text" data-rule-minlength="3" class="input-xlarge" placeholder="Website" id="org_website" name="org_website">
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Assigned to<span style="color:#F00;">*</span></label>
                                    <div class="controls">                                     
                                        <select id="org_assignedto" name="org_assignedto" disabled class='select2-me input-xlarge' data-rule-required="true">
                                            <option value="">Select an Option</option>
                                            <option selected value="<?php echo $_SESSION['login_user'] ?>"><?php echo ucwords($_SESSION['login_user']); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Industry</label>
                                    <div class="controls">
                                        <select id="org_industry" name="org_industry" class='select2-me input-xlarge'>
                                            <option value="">Select an Option</option>
                                            <option value="apparel">Apparel</option>
                                            <option value="hospitality">Hospitality</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="machinery">Machinery</option>
                                            <option value="media">Media</option>
                                            <option value="not_for_profit">Not For Profit</option>
                                            <option value="recreation">Recreation</option>
                                            <option value="Retail">Retail</option>
                                            <option value="shipping">Shipping</option>
                                            <option value="apparel">Apparel</option>
                                            <option value="hospitality">Hospitality</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="machinery">Machinery</option>
                                            <option value="media">Media</option>
                                            <option value="not_for_profit">Not For Profit</option>
                                            <option value="recreation">Recreation</option>
                                            <option value="retail">Retail</option>
                                            <option value="shipping">Shipping</option>
                                            <option value="technology">Technology</option>
                                            <option value="telecommunications">Telecommunications</option>
                                            <option value="healthcare">Healthcare</option>
                                            <option value="food_beverage">Food &amp; Beverage</option>
                                            <option value="biotechnology">Biotechnology</option>
                                            <option value="chemicals">Chemicals</option>
                                            <option value="other">Other</option>
                                            <option value="recreation">Recreation</option>
                                            <option value="Retail">Retail</option>
                                            <option value="shipping">Shipping</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">CST</label>
                                    <div class="controls">
                                        <input type="text" name="org_cst" id="org_cst" placeholder="Organisation CST" class="input-xlarge">

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">VAT</label>
                                    <div class="controls">
                                        <input type="text" name="org_vat" id="org_vat" placeholder="Organisation VAT" class="input-xlarge">

                                    </div>
                                </div>
                                <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Address</label>
                                    <div class="controls">
                                        <textarea id="org_billingadd" name="org_billingadd"></textarea>
                                        <a onClick="copyshippingaddress()" href="javascript: void(0);">Copy Shipping Address</a>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Address</label>
                                    <div class="controls">
                                        <textarea id="org_shippingadd" name="org_shippingadd"></textarea>
                                        <a onClick="copybillingaddress()" href="javascript: void(0);">Copy Billing Address</a>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing PO Box</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingpob" id="org_billingpob" placeholder="Billing PO Box" class="input-xlarge" >
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping PO Box</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingpob" id="org_shippingpob" placeholder="Shipping PO Box" class="input-xlarge" >

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing City</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingcity" id="org_billingcity" placeholder="Billing City" class="input-xlarge" > 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping City</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingcity" id="org_shippingcity" placeholder="Shipping City" class="input-xlarge" >
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing State</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingstate" id="org_billingstate" placeholder="Billing State" class="input-xlarge" >  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping State	
                                    </label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingstate" id="org_shippingstate" placeholder="Shipping State" class="input-xlarge" >  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Postal Code</label>
                                    <div class="controls">
                                        <input type="text"  id="org_billingpoc" name="org_billingpoc" placeholder="Only numbers"> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Postal Code</label>
                                    <div class="controls">
                                        <input type="text"   id="org_shippingpoc" name="org_shippingpoc" placeholder="Only numbers"> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Country</label>
                                    <div class="controls">
                                        <input type="text" name="org_billingcountry" id="org_billingcountry" placeholder="Billing Country" class="input-xlarge" >  
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Country</label>
                                    <div class="controls">
                                        <input type="text" name="org_shippingcountry" id="org_shippingcountry" placeholder="Shipping Country" class="input-xlarge" >   
                                    </div>
                                </div>

                                <div style="clear:both;"></div>
                                <div class="control-group">
                                    <label for="textarea" class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="org_desc" id="elm1" rows="5" class="input-block-level"></textarea>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button name="submit" type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" onClick="window.history.back()" class="btn">Cancel</button>
                                </div> 
                            </form>
                        </div>
                    </div>
