<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
include_once 'lib/header.php';
$org_id = $_GET['org_id'];
?>
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
        $row_org = selectAnd('quote_organisation', $where);

        ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="box box-bordered box-color">
                    <div class="box-title">
                        <h3><i class="icon-th-list"></i> View Organisation</h3>
                    </div>
                    <div class="box-content nopadding">

                        <div class="tab-content padding tab-content-inline tab-content-bottom" style="padding:20px 0 !important">
                            <form action="" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                                <div style="height:40px;font-size:18px" align="left"><strong>Organization Details</strong></div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Organisation Name<span style="color:#F00;">*</span></label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_name'] ?></label>
                                        <span id="comp_1" style="color:#FF0000;"></span>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Email<span style="color:#F00;">*</span></label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_primaryemail'] ?></label>
                                        <span style="color:#FF0000;" id="comp_2"></span>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Primary Phone<span style="color:#F00;">*</span></label>
                                    <div class="controls">

                                        <label><?php echo $row_org['org_primaryphone'] ?></label>
                                    </div> 

                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Secondary Email</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_secondaryemail'] ?></label>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Alt Phone</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_altphone'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Tertiary Email</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_tertiaryemail'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Fax</label>
                                    <div class="controls">
                                        <?php echo $row_org['org_fax'] ?>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Website</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_website'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Assigned to<span style="color:#F00;">*</span></label>
                                    <div class="controls">
                                        <?php echo ucwords($row_org['org_assignedto']); ?>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Industry</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_industry'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">CST</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_cst'] ?></label>											
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">VAT</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_vat'] ?></label>											
                                    </div>
                                </div>
                                <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Address</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingadd'] ?></label>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Address</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingadd'] ?></label>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing PO Box</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingpob'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping PO Box</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingpob'] ?></label>

                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing City</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingcity'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping City</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingcity'] ?></label>
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing State</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingstate'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping State	
                                    </label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingstate'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Postal Code</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingpoc'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Postal Code</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingpoc'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Billing Country</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_billingcountry'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Shipping Country</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_shippingcountry'] ?></label>  
                                    </div>
                                </div>

                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Created By</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_createdby'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Created Date</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_createddt'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Updated By</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_updatedby'] ?></label> 
                                    </div>
                                </div>
                                <div class="control-group divhalf">
                                    <label for="textfield" class="control-label">Updated Date</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_updateddt'] ?></label>  
                                    </div>
                                </div>

                                <div style="clear:both;"></div>
                                <div class="control-group">
                                    <label for="textarea" class="control-label">Description</label>
                                    <div class="controls">
                                        <label><?php echo $row_org['org_desc'] ?></label>
                                    </div>
                                </div>
                            </form>
                            <div class="form-actions">
                                <a href="edit_organisation.php?org_id=<?php echo $org_id; ?>" style="margin-left:10px;"><button class="btn btn-primary">Edit Organisation</button></a>
                                <button type="button" onClick="window.history.back()" class="btn">Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content end -->

        </div>
    </div></div>

</body>


</html>

