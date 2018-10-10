<?php

session_start();

include 'lib/function.php';

checkUser();

include_once 'lib/dbfunctionjugal.php';

if (isset($_POST['submit'])) {
    $re = add_contact();
    if ($re == 1) {
        header('location:contacts.php');
    }
}

include_once 'lib/header.php';

?>

<script type="text/javascript">



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

        var madd = document.getElementById('cont_mailingadd').value;

        document.getElementById('cont_otheradd').value = madd;

        var mpob = document.getElementById('cont_mailingpob').value;

        document.getElementById('cont_otherpob').value = mpob;

        var mcity = document.getElementById('cont_mailingcity').value;

        document.getElementById('cont_othercity').value = mcity;

        var mstate = document.getElementById('cont_mailingstate').value;

        document.getElementById('cont_otherstate').value = mstate;

        var mpoc = document.getElementById('cont_mailingpoc').value;

        document.getElementById('cont_otherpoc').value = mpoc;

        var mcountry = document.getElementById('cont_mailingcountry').value;

        document.getElementById('cont_othercountry').value = mcountry;

    }



    function copyotheraddress() {

        var oadd = document.getElementById('cont_otheradd').value;

        document.getElementById('cont_mailingadd').value = oadd;

        var opob = document.getElementById('cont_otherpob').value;

        document.getElementById('cont_mailingpob').value = opob;

        var ocity = document.getElementById('cont_othercity').value;

        document.getElementById('cont_mailingcity').value = ocity;

        var ostate = document.getElementById('cont_otherstate').value;

        document.getElementById('cont_mailingstate').value = ostate;

        var opoc = document.getElementById('cont_otherpoc').value;

        document.getElementById('cont_mailingpoc').value = opoc;

        var ocountry = document.getElementById('cont_othercountry').value;

        document.getElementById('cont_mailingcountry').value = ocountry;

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

                        <a href="#">Add Contacts</a>

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

                            <h3><i class="icon-th-list"></i> Add Contacts</h3>

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

                                    <div style="height:40px;font-size:18px" align="left"><strong>Basic Information</strong></div>

                                    <div class="control-group">

                                        <label for="textfield" class="control-label">Type<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <select id="cont_type" name="cont_type" style="width:15%;" class='select2-me input-xlarge' onChange="ContType(this.value);">

                                                <option value="normal" selected>Normal</option>

                                                <option value="dealer">Dealer</option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">First Name<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <select id="cont_sal" name="cont_sal" style="width:15%;" class='select2-me input-xlarge'>

                                                <option value="" selected>None</option>

                                                <option value="mr">Mr.</option>

                                                <option value="ms">Ms.</option>

                                                <option value="mrs">Mrs.</option>

                                                <option value="dr">Dr.</option>

                                                <option value="prof">Prof.</option>

                                            </select><input type="text" data-rule-required="true" name="cont_firstname" id="cont_firstname" placeholder="First Name" class="input-xsmall">

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Last Name<span style="color:#F00;"></span></label>

                                        <div class="controls">

                                            <input type="text"   class="input-xlarge" placeholder="Last Name" id="cont_lastname" name="cont_lastname">





                                        </div>

                                    </div>

                                    <div style="clear:both"></div>

                                    <div id="pemail" class="control-group divhalf">

                                        <label for="textfield" class="control-label">Primary Email<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <input type="text" data-rule-required="true" onblur="PrimaryEmail(this.value);" data-rule-email="true" class="input-xlarge" placeholder="Primary Email" id="cont_primaryemail" name="cont_primaryemail">

                                            <span style="color:#FF0000;" id="comp_2"></span>



                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Mobile Phone</label>

                                        <div class="controls">



                                            <input type="text"  id="cont_mobilephone" name="cont_mobilephone" placeholder="Only numbers">

                                        </div> 



                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Secondary Email</label>

                                        <div class="controls">

                                            <input type="text"  data-rule-email="true" class="input-xlarge" placeholder="Secondary Email" id="cont_secondaryemail" name="cont_secondaryemail">



                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Alt Phone</label>

                                        <div class="controls">

                                            <input type="text"  id="cont_altphone" name="cont_altphone" placeholder="Only numbers">

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Lead Source</label>

                                        <div class="controls">

                                            <select id="cont_leadsource" name="cont_leadsource" class='select2-me input-xlarge'>

                                                <option value="">Select an Option</option>

                                                <option value="cold_call">Cold Call</option>

                                                <option value="website">Website</option>

                                                <option value="direct_mall">Direct Mail</option>

                                                <option value="employee">Employee</option>

                                                <option value="self_generated">Self Generated</option>

                                                <option value="exisiting_customer">Existing Customer</option>

                                                <option value="other">Other</option>

                                            </select>  

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Organisation Name</label>

                                        <div class="controls">

                                            <select id="cont_orgid"  name="cont_orgid" class='select2-me input-xlarge'  data-placeholder="Organisation Name" onChange="OrgName(this.value);">

                                                <option value="">-- Select Organisation --</option>

                                                <option value="0">-- Individual --</option>

                                                <?php

                                                $username = $_SESSION['login_user'];

                                                if ($_SESSION['user_type'] == "users") {

                                                   $res_sec5 = select_quote_organisation_without_limit($username);

                                                } else {

                                                   $res_sec5 = select_table_orderby('quote_organisation', 'org_name');

                                                  

                                                }

                                              

                                                foreach ($res_sec5 as $key => $row_sec5) {

                                                    ?>

                                                    <option value="<?php echo $row_sec5['org_id'] ?>"><?php echo ucwords($row_sec5['org_name']) ?></option>

                                                    <?php

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield" class="control-label">Department</label>

                                        <div class="controls">

                                            <input type="text" data-rule-minlength="3" class="input-xlarge" placeholder="Department" id="cont_orgdepart" name="cont_orgdepart">

                                        </div>

                                    </div>

                                    <div class="control-group divhalf">

                                        <label for="textfield"  class="control-label">Assigned to<span style="color:#F00;">*</span></label>

                                        <div class="controls">

                                            <select id="cont_assignedto" disabled name="cont_assignedto" class='select2-me input-xlarge'>

                                                <option value="">Select an Option</option>

                                                <option  selected  value="<?php echo $_SESSION['login_user']; ?>"><?php echo ucwords($_SESSION['login_user']); ?></option>

                                            </select>

                                        </div>

                                    </div>

                                    <div style="clear:both;height:40px;font-size:18px;padding-top:15px;" align="left"><strong>Address Details</strong></div>

                                    <div id="addr_details"> 

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Address</label>

                                            <div class="controls">

                                                <textarea id="cont_mailingadd" name="cont_mailingadd"></textarea>

                                                <a href="javascript: void(0);" onClick="copyotheraddress();" >Copy Other Address</a>

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Address</label>

                                            <div class="controls">

                                                <textarea id="cont_otheradd" name="cont_otheradd"></textarea>

                                                <a href="javascript: void(0);" onClick="copymailingaddress();">Copy Mailing Address</a>

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing PO Box</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingpob" id="cont_mailingpob" placeholder="Mailing PO Box" class="input-xlarge" >

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other PO Box</label>

                                            <div class="controls">

                                                <input type="text" name="cont_otherpob" id="cont_otherpob" placeholder="Other PO Box" class="input-xlarge" >



                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing City</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingcity" id="cont_mailingcity" placeholder="Mailing City" class="input-xlarge" > 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other City</label>

                                            <div class="controls">

                                                <input type="text" name="cont_othercity" id="cont_othercity" placeholder="Other City" class="input-xlarge" >

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing State</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingstate" id="cont_mailingstate" placeholder="Mailing State" class="input-xlarge" >  

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other State	

                                            </label>

                                            <div class="controls">

                                                <input type="text" name="cont_otherstate" id="cont_otherstate" placeholder="Other  State" class="input-xlarge" >  

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Postal Code</label>

                                            <div class="controls">

                                                <input type="text"   id="cont_mailingpoc" name="cont_mailingpoc" placeholder="Only numbers"> 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Postal Code</label>

                                            <div class="controls">

                                                <input type="text"   id="cont_otherpoc" name="cont_otherpoc" placeholder="Only numbers"> 

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Mailing Country</label>

                                            <div class="controls">

                                                <input type="text" name="cont_mailingcountry" id="cont_mailingcountry" placeholder="Mailing Country" class="input-xlarge" >  	

                                            </div>

                                        </div>

                                        <div class="control-group divhalf">

                                            <label for="textfield" class="control-label">Other Country</label>

                                            <div class="controls">

                                                <input type="text" name="cont_othercountry" id="cont_othercountry" placeholder="Other Country" class="input-xlarge" >   

                                            </div>

                                        </div>

                                    </div>

                                    <div style="clear:both;"></div>

                                    <div class="control-group">

                                        <label for="textarea" class="control-label">Description</label>

                                        <div class="controls">

                                            <textarea name="cont_desc" id="elm1" rows="5" class="input-block-level"></textarea>

                                        </div>

                                    </div>



                                    <div class="form-actions">

                                        <button type="submit"  name="submit" class="btn btn-primary">Save changes</button>

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



