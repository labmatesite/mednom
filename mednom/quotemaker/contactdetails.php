<?php
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
include_once 'lib/header.php';
$cont_id = $_GET['cont_id'];
?>
<div class="container-fluid" id="content">			
    <div id="main">
        <?php
        date_default_timezone_set("Asia/Calcutta");
        $dt = date('F d, Y');
        $week = date('l');
        ?>
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Contacts</h1>
                </div>
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
                        <a href="#">Contacts</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">View Contact Details</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>

            <!-- Main content start -->

            <?php
            $where = array('cont_id' => $cont_id);
            $row_cont = selectAnd('quote_contacts', $where);
            ?>

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3><i class="icon-th-list"></i> View Contact Details</h3>
                        </div>
                        <div class="box-content nopadding">

                            <div class="tab-content padding tab-content-inline tab-content-bottom" style="padding:20px 0 !important">
                                <form action="" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                                    <div style="height:40px;font-size:18px" align="left"><strong>Basic Information</strong></div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">First Name<span style="color:#F00;">*</span></label>
                                        <div class="controls">
                                            <?php echo $row_cont['cont_sal'] . " " . $row_cont['cont_firstname']; ?>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Last Name<span style="color:#F00;">*</span></label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_lastname'] ?></label> 
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Primary Email<span style="color:#F00;">*</span></label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_primaryemail'] ?></label>

                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mobile Phone<span style="color:#F00;">*</span></label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mobilephone'] ?></label>
                                        </div> 

                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Secondary Email</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_secondaryemail'] ?></label>  
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Alt Phone</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_altphone'] ?></label>
                                        </div>
                                    </div>

                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Lead Source</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_leadsource'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Organisation Name</label>
                                        <div class="controls">

                                            <?php
                                            $where = array('org_id' => $row_cont['cont_orgid']);
                                            $row_sec3 = selectAnd('quote_organisation', $where);
                                            echo "<label>" . ucwords($row_sec3['org_name']) . "</label>";
                                            ?>

                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Department</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_orgdepart'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Assigned to<span style="color:#F00;">*</span></label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_assignedto'] ?></label>
                                        </div>
                                    </div>
                                    <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing Address</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingadd'] ?></label>

                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other Address</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_otheradd'] ?></label>

                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing PO Box</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingpob'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other PO Box</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_otherpob'] ?></label>

                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing City</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingcity'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other City</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_othercity'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing State</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingstate'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other State	
                                        </label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_otherstate'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing Postal Code</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingpoc'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other Postal Code</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_otherpoc'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Mailing Country</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_mailingcountry'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Other Country</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_othercountry'] ?></label>
                                        </div>
                                    </div>

                                    <div style="clear:both;"></div>
                                    <div class="control-group">
                                        <label for="textarea" class="control-label">Description</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_desc'] ?></label>
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Created By</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_createdby'] ?></label> 
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Created Date</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_createddt'] ?></label> 
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Updated By</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_updatedby'] ?></label> 
                                        </div>
                                    </div>
                                    <div class="control-group divhalf">
                                        <label for="textfield" class="control-label">Updated Date</label>
                                        <div class="controls">
                                            <label><?php echo $row_cont['cont_updateddt'] ?></label>  
                                        </div>
                                    </div>
                                    </form>
                                    <div class="form-actions" style="margin-top: 135px;">
                                        <a href="edit_contacts.php?cont_id=<?php echo $cont_id; ?>" style="margin-left:10px;"><button class="btn btn-primary">Edit Organisation</button></a>
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


