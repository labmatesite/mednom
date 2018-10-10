<?php

session_start();

include 'lib/database.php';

include 'lib/function.php';

checkUser();

$cont_id = $_REQUEST['cont_id'];

$where = array('cont_id' => $cont_id);

$row_cont = selectAnd('quote_contacts', $where);

if (isset($_POST['submit'])) {

    $todaydt = date("Y-m-d H:i:s");

    $param = array(

        'cont_primaryemail' => $_POST['cont_primaryemail'],

        'cont_mobilephone' => $_POST['cont_mobilephone'],

        'cont_type' => $_POST['cont_type'],

        'cont_sal' => $_POST['cont_sal'],

        'cont_firstname' => $_POST['cont_firstname'],

        'cont_lastname' => $_POST['cont_lastname'],

        'cont_secondaryemail' => $_POST['cont_secondaryemail'],

        'cont_altphone' => $_POST['cont_altphone'],

        'cont_leadsource' => $_POST['cont_leadsource'],

        'cont_orgid' => $_POST['cont_orgid'],

        'cont_orgdepart' => $_POST['cont_orgdepart'],

        'cont_mailingadd' => $_POST['cont_mailingadd'],

        'cont_mailingpob' => $_POST['cont_mailingpob'],

        'cont_mailingcity' => $_POST['cont_mailingcity'],

        'cont_mailingstate' => $_POST['cont_mailingstate'],

        'cont_mailingpoc' => $_POST['cont_mailingpoc'],

        'cont_mailingcountry' => $_POST['cont_mailingcountry'],

        'cont_otheradd' => $_POST['cont_otheradd'],

        'cont_otherpob' => $_POST['cont_otherpob'],

        'cont_othercity' => $_POST['cont_othercity'],

        'cont_otherstate' => $_POST['cont_otherstate'],

        'cont_otherpoc' => $_POST['cont_otherpoc'],

        'cont_othercountry' => $_POST['cont_othercountry'],

        'cont_desc' => $_POST['cont_desc'],

        'cont_createdby' => "",

        'cont_createddt' => "",

        'cont_updateddt' => $todaydt,

        'cont_updatedby' => $_SESSION['login_user']);

    

        // call update_contact function for update quote_contact table

        $results=update_contact($param);

        if($results==1){

            header('location:contacts.php');

        }

}

include_once 'lib/header.php';

?>



<script>

   

       function PrimaryEmail(email) {

        $.ajax({

            type: "GET",

            url: "searchcontacts.php",

            data: "email=" + email,

            cache: false,

            success: function (html) {

                $("#comp_2").html(html);

            }

        });

    }

    function OrgName(org_id) {

           $.ajax({

            type: "GET",

            url: "searchcontacts.php",

            data: "orgid=" + org_id,

            cache: false,

            success: function (html) {

                $("#addr_details").html(html);

            }

        });

       

    }

      

      function copymailingaddress() {

		var madd=document.getElementById('cont_mailingadd').value;

		document.getElementById('cont_otheradd').value=madd;

		

		var mpob=document.getElementById('cont_mailingpob').value;

		document.getElementById('cont_otherpob').value=mpob;

		

		var mcity=document.getElementById('cont_mailingcity').value;

		document.getElementById('cont_othercity').value=mcity;

		

		var mstate=document.getElementById('cont_mailingstate').value;

		document.getElementById('cont_otherstate').value=mstate;

		

		var mpoc=document.getElementById('cont_mailingpoc').value;

		document.getElementById('cont_otherpoc').value=mpoc;

		

		var mcountry=document.getElementById('cont_mailingcountry').value;

		document.getElementById('cont_othercountry').value=mcountry;

		

								

	}

	

	function copyotheraddress() {

		var oadd=document.getElementById('cont_otheradd').value;

		document.getElementById('cont_mailingadd').value=oadd;

		

		var opob=document.getElementById('cont_otherpob').value;

		document.getElementById('cont_mailingpob').value=opob;

		

		var ocity=document.getElementById('cont_othercity').value;

		document.getElementById('cont_mailingcity').value=ocity;

		

		var ostate=document.getElementById('cont_otherstate').value;

		document.getElementById('cont_mailingstate').value=ostate;

		

		var opoc=document.getElementById('cont_otherpoc').value;

		document.getElementById('cont_mailingpoc').value=opoc;

		

		var ocountry=document.getElementById('cont_othercountry').value;

		document.getElementById('cont_mailingcountry').value=ocountry;						

	}	

    

    </script>



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

                        <a href="#">Edit Contacts</a>

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

                            <h3><i class="icon-th-list"></i> Edit Contacts</h3>

                        </div>

                        <div class="box-content nopadding">



                            <div class="tab-content padding tab-content-inline tab-content-bottom" style="padding:20px 0 !important">

                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?cont_id=' . $cont_id; ?>" method="POST" class='form-horizontal form-bordered form-validate' id="bb">

                                    <?php

                                    if (isset($_POST['submit'])) {

                                        if ($results == 0) {

                                            echo '<div class="msg"><p>Some error has occurred during updation. Please try again.</p></div>';

                                        }

                                    }

                                    ?>

                                    

                                    <div style="height:40px;font-size:18px" align="left"><strong>Basic Information</strong></div>

                                    <div class="control-group">

                                        <label for="textfield" class="control-label">Type<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <select id="cont_type" name="cont_type" style="width:15%;" class='select2-me input-xlarge'>

                                                <option <?php if ($row_cont['cont_type'] == "normal") { ?> selected <?php } ?> value="normal">Normal</option>

                                                <option <?php if ($row_cont['cont_type'] == "dealer") { ?> selected <?php } ?> value="dealer">Dealer</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">First Name<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <select id="cont_sal" name="cont_sal" style="width:15%;" class='select2-me input-xlarge'>

                                                <option <?php if ($row_cont['cont_sal'] == "") { ?> selected <?php } ?> value="">None</option>

                                                <option <?php if ($row_cont['cont_sal'] == "mr") { ?> selected <?php } ?> value="mr">Mr.</option>

                                                <option <?php if ($row_cont['cont_sal'] == "ms") { ?> selected  <?php } ?> value="ms">Ms.</option>

                                                <option <?php if ($row_cont['cont_sal'] == "mrs") { ?>  selected  <?php } ?> value="mrs">Mrs.</option>

                                                <option <?php if ($row_cont['cont_sal'] == "dr") { ?>  selected  <?php } ?> value="dr">Dr.</option>

                                                <option <?php if ($row_cont['cont_sal'] == "prof") { ?>  selected  <?php } ?> value="prof">Prof.</option>

                                            </select><input type="text" data-rule-required="true" name="cont_firstname" value="<?php echo $row_cont['cont_firstname'] ?>" id="cont_firstname" placeholder="First Name" class="input-xsmall">

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Last Name<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <input type="text" value="<?php echo $row_cont['cont_lastname'] ?>"  class="input-xlarge" placeholder="Last Name" id="cont_lastname" name="cont_lastname">





                                        </div>

                                    </div>

                                    <div style="clear:both"></div>

                                    <div id="pemail" class="control-group divhalf">

                                        <label for="textfield" class="control-label">Primary Email<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <input type="text" value="<?php echo $row_cont['cont_primaryemail'] ?>" data-rule-required="true" onchange="PrimaryEmail(this.value);" data-rule-email="true" class="input-xlarge" placeholder="Primary Email" id="cont_primaryemail" name="cont_primaryemail">

                                            <span style="color:#FF0000;" id="comp_2"></span>



                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Mobile Phone<span style="color:#F00;">*</span></label>

                                        <div class="controls">



                                            <input type="text"  value="<?php echo $row_cont['cont_mobilephone'] ?>" id="cont_mobilephone" name="cont_mobilephone" placeholder="Only numbers">

                                        </div> 



                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Secondary Email</label>

                                        <div class="controls">

                                            <input type="text"  data-rule-email="true" class="input-xlarge" value="<?php echo $row_cont['cont_secondaryemail'] ?>" placeholder="Secondary Email" id="cont_secondaryemail" name="cont_secondaryemail">



                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Alt Phone</label>

                                        <div class="controls">

                                            <input type="text"  id="cont_altphone" name="cont_altphone" value="<?php echo $row_cont['cont_altphone'] ?>" placeholder="Only numbers">

                                        </div>

                                    </div>



                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Lead Source</label>

                                        <div class="controls">

                                            <select id="cont_leadsource" name="cont_leadsource" class='select2-me input-xlarge'>

                                                <option value="">Select an Option</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "cold_call") { ?> selected <?php } ?> value="cold_call">Cold Call</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "website") { ?> selected <?php } ?> value="website">Website</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "direct_mall") { ?> selected <?php } ?> value="direct_mall">Direct Mail</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "employee") { ?> selected <?php } ?> value="employee">Employee</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "Self Generated") { ?> selected <?php } ?> value="self_generated">Self Generated</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "exisiting_customer") { ?> selected <?php } ?> value="exisiting_customer">Existing Customer</option>

                                                <option <?php if ($row_cont['cont_leadsource'] == "other") { ?> selected <?php } ?> value="other">Other</option>

                                            </select>  </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Organisation Name</label>

                                        <div class="controls">

                                            <select id="cont_orgid" name="cont_orgid" class='select2-me input-xlarge' data-placeholder="Organisation Name" onchange="OrgName(this.value);">

                                                <option value="">-- Select Organisation --</option>

                                                <option value="0">-- Individual --</option>

                                                <?php

                                                $username = $_SESSION['login_user'];

                                                $where = array('username' => $username);

                                                $row_ad = selectAnd('admin', $where);

                                                if ($row_ad['userType'] == "users") {

                                                    $result = select_quote_organisation_without_limit($username);

                                                    //$sql = "SELECT c.`org_id`,c.`org_name` FROM `quote_organisation` c WHERE c.`org_assignedto` LIKE '$username' UNION SELECT a.`org_id`,a.`org_name` FROM `quote_organisation` a, quote_share b WHERE b.shd_assignto LIKE '$username' AND a.org_id = b.shd_orgid";

                                                } else {

                                                    $result = select_table_orderby('quote_organisation','org_name');

                                                    

                                                }

                                                foreach ($result as $key => $value) {

                                                    ?>

                                                    <option <?php if ($row_cont['cont_orgid'] == $value['org_id']) { ?> selected <?php } ?>  value="<?php echo $value['org_id'] ?>"><?php echo ucwords($value['org_name']) ?></option>

                                                    <?php

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Department</label>

                                        <div class="controls">

                                            <input type="text" data-rule-minlength="3" class="input-xlarge" value="<?php echo $row_cont['cont_orgdepart'] ?>" placeholder="Department" id="cont_orgdepart" name="cont_orgdepart">

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Assigned to<span style="color:#F00;">*</span></label>

                                        <div class="controls">                                            

                                            <?php

                                            $row = selectAll('admin');

                                            ?>

                                            <select id="cont_assignedto" disabled="" name="cont_assignedto" data-rule-required="true">

                                                <?php

                                                foreach ($row as $key => $row_a) {

                                                    ?>                                                

                                                    <option <?php if ($row_a['username'] == $row_cont['cont_assignedto']) { ?> selected <?php  } ?> value="<?php echo $row_a['username'] ?>"><?php echo ucwords($row_a['username']); ?></option>

                                                    <?php

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                    <div id="addr_details">  

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Address</label>

                                            <div class="controls">

                                                <textarea id="cont_mailingadd" name="cont_mailingadd"><?php echo $row_cont['cont_mailingadd'] ?></textarea>

                                                <a href="javascript: void(0);" onClick="copyotheraddress();" >Copy Other Address</a>

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Address</label>

                                            <div class="controls">

                                                <textarea id="cont_otheradd" name="cont_otheradd"><?php echo $row_cont['cont_otheradd'] ?></textarea>

                                                <a href="javascript: void(0);" onClick="copymailingaddress();">Copy Mailing Address</a>

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing PO Box</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingpob" value="<?php echo $row_cont['cont_mailingpob'] ?>" id="cont_mailingpob" placeholder="Mailing PO Box" class="input-xlarge" >

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other PO Box</label>

                                            <div class="controls">

                                                <input type="text" name="cont_otherpob" value="<?php echo $row_cont['cont_otherpob'] ?>" id="cont_otherpob" placeholder="Other PO Box" class="input-xlarge" >



                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing City</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingcity" value="<?php echo $row_cont['cont_mailingcity'] ?>" id="cont_mailingcity" placeholder="Mailing City" class="input-xlarge" > 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other City</label>

                                            <div class="controls">

                                                <input type="text" name="cont_othercity" value="<?php echo $row_cont['cont_othercity'] ?>" id="cont_othercity" placeholder="Other City" class="input-xlarge" >

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing State</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingstate" value="<?php echo $row_cont['cont_mailingstate'] ?>" id="cont_mailingstate" placeholder="Mailing State" class="input-xlarge" >  

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other State	

                                            </label>

                                            <div class="controls">

                                                <input type="text" name="cont_otherstate" value="<?php echo $row_cont['cont_otherstate'] ?>" id="cont_otherstate" placeholder="Other  State" class="input-xlarge" >  

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Postal Code</label>

                                            <div class="controls">

                                                <input type="text"   id="cont_mailingpoc" name="cont_mailingpoc" value="<?php echo $row_cont['cont_mailingpoc'] ?>" placeholder="Only numbers"> 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Postal Code</label>

                                            <div class="controls">

                                                <input type="text"   id="cont_otherpoc" name="cont_otherpoc" value="<?php echo $row_cont['cont_otherpoc'] ?>" placeholder="Only numbers"> 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Country</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingcountry" id="cont_mailingcountry" value="<?php echo $row_cont['cont_mailingcountry'] ?>" placeholder="Mailing Country" class="input-xlarge" >  	

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Country</label>

                                            <div class="controls">

                                                <input type="text" name="cont_othercountry" id="cont_othercountry" value="<?php echo $row_cont['cont_othercountry'] ?>" placeholder="Other Country" class="input-xlarge" >   

                                            </div>

                                        </div>

                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="control-group">

                                        <label for="textarea" class="control-label">Description</label>

                                        <div class="controls">

                                            <textarea name="cont_desc" id="elm1" rows="5" class="input-block-level"><?php echo $row_cont['cont_desc'] ?></textarea>

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

</div>

</body>





</html>







