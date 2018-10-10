<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include 'lib/header.php';
?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<style>
.choiceChosen, .productChosen {
  width: 250px !important;
}
.chosen-container .chosen-drop{
    width: 150%;
}
</style>

<div class="container-fluid" id="content">

    <div id="main">

        <div class="container-fluid">

            <div class="page-header">

                <div class="pull-left">

                    <h1>Contacts</h1>

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

                        <a href="#">Contacts</a>

                        <i class="icon-angle-right"></i>

                    </li>

                    <li>

                        <a href="#">View Contacts</a>

                    </li>

                </ul>

                <div class="close-bread">

                    <a href="#"><i class="icon-remove"></i></a>

                </div>

            </div>



            <!-- Main content start -->



            <div class="row-fluid">

                <div class="span12">

                    <div class="box box-color box-bordered">

                        <div class="box-title">

                            <h3>

                                <i class="icon-table"></i>

                                Contacts

                            </h3>

                        </div>

                        <div class="box-content nopadding">

                            <br>



                            <a href="add_contacts.php" style="margin-left:10px;"><button class="btn btn-primary">Add Contacts</button></a>

                            <br><br>



                            <?php

                            if (isset($_FILES['mzFile']['tmp_name']) != "") {

                                $myFile = $_FILES['mzFile']['tmp_name'];

                                include('Excel/reader.php');



                                $data = new Spreadsheet_Excel_Reader();

                                $data->setOutputEncoding('CP1251');

                                if (isset($myFile) and $myFile != '') {

                                    $data->read($myFile);



                                    for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {

                                        if (isset($data->sheets[0]["cells"][$x][1])) {

                                            $cont_sal = $data->sheets[0]["cells"][$x][1];

                                        } else {

                                            $cont_sal = '';

                                        }



                                        if (isset($data->sheets[0]["cells"][$x][2])) {

                                            $cont_firstname = $data->sheets[0]["cells"][$x][2];

                                        } else {

                                            $cont_firstname = '';

                                        }



                                        if (isset($data->sheets[0]["cells"][$x][3])) {

                                            $cont_lastname = $data->sheets[0]["cells"][$x][3];

                                        } else {

                                            $cont_lastname = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][4])) {

                                            $cont_primaryemail = $data->sheets[0]["cells"][$x][4];

                                        } else {

                                            $cont_primaryemail = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][5])) {

                                            $cont_secondaryemail = $data->sheets[0]["cells"][$x][5];

                                        } else {

                                            $cont_secondaryemail = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][6])) {

                                            $cont_mobilephone = $data->sheets[0]["cells"][$x][6];

                                        } else {

                                            $cont_mobilephone = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][7])) {

                                            $cont_altphone = $data->sheets[0]["cells"][$x][7];

                                        } else {

                                            $cont_altphone = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][8])) {

                                            $cont_dob = $data->sheets[0]["cells"][$x][8];

                                        } else {

                                            $cont_dob = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][9])) {

                                            $cont_leadsource = $data->sheets[0]["cells"][$x][9];

                                        } else {

                                            $cont_leadsource = '';

                                        }



                                        if (isset($data->sheets[0]["cells"][$x][10])) {

                                            $cont_orgid = $data->sheets[0]["cells"][$x][10];

                                        } else {

                                            $cont_orgid = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][11])) {

                                            $cont_orgdepart = $data->sheets[0]["cells"][$x][11];

                                        } else {

                                            $cont_orgdepart = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][12])) {

                                            $cont_assignedto = $data->sheets[0]["cells"][$x][12];

                                        } else {

                                            $cont_assignedto = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][13])) {

                                            $cont_dnc = $data->sheets[0]["cells"][$x][13];

                                        } else {

                                            $cont_dnc = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][14])) {

                                            $cont_mailingadd = $data->sheets[0]["cells"][$x][14];

                                        } else {

                                            $cont_mailingadd = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][15])) {

                                            $cont_mailingpob = $data->sheets[0]["cells"][$x][15];

                                        } else {

                                            $cont_mailingpob = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][16])) {

                                            $cont_mailingcity = $data->sheets[0]["cells"][$x][16];

                                        } else {

                                            $cont_mailingcity = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][17])) {

                                            $cont_mailingstate = $data->sheets[0]["cells"][$x][17];

                                        } else {

                                            $cont_mailingstate = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][18])) {

                                            $cont_mailingpoc = $data->sheets[0]["cells"][$x][18];

                                        } else {

                                            $cont_mailingpoc = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][19])) {

                                            $cont_mailingcountry = $data->sheets[0]["cells"][$x][19];

                                        } else {

                                            $cont_mailingcountry = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][20])) {

                                            $cont_otheradd = $data->sheets[0]["cells"][$x][20];

                                        } else {

                                            $cont_otheradd = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][21])) {

                                            $cont_otherpob = $data->sheets[0]["cells"][$x][21];

                                        } else {

                                            $cont_otherpob = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][22])) {

                                            $cont_othercity = $data->sheets[0]["cells"][$x][22];

                                        } else {

                                            $cont_othercity = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][23])) {

                                            $cont_otherstate = $data->sheets[0]["cells"][$x][23];

                                        } else {

                                            $cont_otherstate = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][24])) {

                                            $cont_otherpoc = $data->sheets[0]["cells"][$x][24];

                                        } else {

                                            $cont_otherpoc = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][25])) {

                                            $cont_othercountry = $data->sheets[0]["cells"][$x][25];

                                        } else {

                                            $cont_othercountry = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][26])) {

                                            $cont_desc = $data->sheets[0]["cells"][$x][26];

                                        } else {

                                            $cont_desc = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][27])) {

                                            $cont_createdby = $data->sheets[0]["cells"][$x][27];

                                        } else {

                                            $cont_createdby = '';

                                        }



                                        if (isset($data->sheets[0]["cells"][$x][28])) {

                                            $cont_createddt = $data->sheets[0]["cells"][$x][28];

                                        } else {

                                            $cont_createddt = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][29])) {

                                            $cont_updatedby = $data->sheets[0]["cells"][$x][29];

                                        } else {

                                            $cont_updatedby = '';

                                        }

                                        if (isset($data->sheets[0]["cells"][$x][30])) {

                                            $cont_updateddt = $data->sheets[0]["cells"][$x][30];

                                        } else {

                                            $cont_updateddt = '';

                                        }

                                        $sql1 = "select * from  quote_contacts where cont_primaryemail='$cont_primaryemail'";

                                        $res1 = mysql_query($sql1);

                                        $tot = mysql_num_rows($res1);

                                        /*

                                          if($tot==0)

                                          { */

                                        $sql = "insert into quote_contacts (cont_sal,cont_firstname,cont_lastname,cont_primaryemail,cont_secondaryemail,cont_mobilephone,cont_altphone,cont_dob,cont_leadsource,cont_orgid,cont_orgdepart,cont_assignedto,cont_dnc,cont_mailingadd,cont_mailingpob,cont_mailingcity,cont_mailingstate,cont_mailingpoc,cont_mailingcountry,cont_otheradd,cont_otherpob,cont_othercity,cont_otherstate,cont_otherpoc,cont_othercountry,cont_desc,cont_createdby,cont_createddt,cont_updatedby,cont_updateddt) values ('$cont_sal','$cont_firstname','$cont_lastname','$cont_primaryemail','$cont_secondaryemail','$cont_mobilephone','$cont_altphone','$cont_dob','$cont_leadsource','$cont_orgid','$cont_orgdepart','$cont_assignedto','$cont_dnc','$cont_mailingadd','$cont_mailingpob','$cont_mailingcity','$cont_mailingstate','$cont_mailingpoc','$cont_mailingcountry','$cont_otheradd','$cont_otherpob','$cont_othercity','$cont_otherstate','$cont_otherpoc','$cont_othercountry','$cont_desc','$cont_createdby','$cont_createddt','$cont_updatedby','$cont_updateddt')";

                                        $res = mysql_query($sql);

                                        if ($res) {

                                            

                                        }

                                        /* }

                                          else

                                          {



                                          echo "Contacts Already Exists <br>".$cont_primaryemail	;

                                          }

                                         */

                                    }

                                }

                            }

                            ?>

                            </table>



                            <?php

                            if ($_SESSION['user_type'] == "Superadmin" || $_SESSION['user_type'] == "users") {

                                ?>



                                <form action="" enctype="multipart/form-data" method="post" name="mzForm">

                                    <table style="background-color:#EEEEEE;" border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table"><tr>

                                            <td>Bulk Data : upload Excel File(2003 format)</td>

                                            <td><input type="file" name="mzFile" /></td>

                                            <td><input  class="btn btn-primary" type="submit" name="mzSubmit" value="Upload"/></td>

                                        </tr></table>

                                </form>

                            <?php } ?>

                        <!-- SEARCH BAR -->

                            <div class="control-group container-fluid">
                                <?php
                                $abc = select_all_contact();
                                ?>
                                <label class="control-label"><h4><b>Search Contact</b></h4></label>
                                <select id="combobox" data-rule-required="true" class='choiceChosen select2-me input-xlarge' name="cfname" data-placeholder="Contact Name" onchange="location=this.value" style="width:200px;">
                                    <option value="">-- Select Contact --</option> 
                                    <?php
                                    foreach ($abc as $values) {
                                        ?>
                                        <option value="contactdetails.php?cont_id=<?php echo $values['cont_id'] ?>"><?php echo $values['cont_firstname'] ?> <?php echo $values['cont_lastname'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                             </br>
                        <!-- SERACH BAR  -->

                            <div id="results"></div>

                            <div class="loader"></div>

                            <script type="text/javascript">

                                // fetching records

                                function displayRecords(numRecords, pageNum) {

                                    $.ajax({

                                        type: "GET",

                                        url: "contact_pegination.php",

                                        data: "show=" + numRecords + "&pagenum=" + pageNum,

                                        cache: false,

                                        beforeSend: function () {

                                            $('.loader').html('<img src="assets/images/loader.gif" alt="" width="24" height="24" style="padding-left: 400px; margin-top:10px;" >');

                                        },

                                        success: function (html) {

                                            $("#results").html(html);

                                            $('.loader').html('');

                                        }

                                    });

                                }



                                // used when user change row limit

                                function changeDisplayRowCount(numRecords) {

                                    displayRecords(numRecords, 1);

                                }



                                $(document).ready(function () {

                                    displayRecords(20, 1);

                                });

                            </script>
                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>


                            <script>
                                $(document).ready(function(){
                                //Chosen
                                $(".choiceChosen, .productChosen").chosen({});
                              //Logic
                              $(".choiceChosen").change(function(){
                                if($(".choiceChosen option:selected").val()=="no"){
                                  $(".productChosen option[value='2']").attr('disabled',true).trigger("chosen:updated");
                                  $(".productChosen option[value='1']").removeAttr('disabled',true).trigger("chosen:updated");
                              } else {
                                  $(".productChosen option[value='1']").attr('disabled',true).trigger("chosen:updated");
                                  $(".productChosen option[value='2']").removeAttr('disabled',true).trigger("chosen:updated");
                              }
                              })
                              })
                            </script>
                            </body>

                            </html>