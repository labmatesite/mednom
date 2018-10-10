<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';

/* EXPORT TO EXCEL */
$username = $_SESSION['login_user'];
if(isset($_POST["ExportType"])){      
    switch($_POST["ExportType"]){
        case "export-to-csv" :
            $filename = "full-Organization-list.csv";       
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            //$conn = mysqli_connect("localhost","labtron0_site","Sunny@110","labtron0_site");
            include ('lib/config.php');
            $sql = "SELECT * FROM `quote_organisation`";
            $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
            exportCSV($resultset);          
            exit();
        default :
            die("Unknown action : ".$_POST["action"]);
            break;
    }
}
/* EXPORT TO EXCEL */

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

                        <h3>

                            <i class="icon-table"></i>

                            Organisation

                        </h3>

                    </div>

                    <div class="box-content nopadding">

                        <br>



                        <a href="add_organisation.php" style="margin-left:10px;"><button class="btn btn-primary">Add Organisation</button></a>

                        <br><br>

                        <?php

                        if (isset($_FILES['mzFile']['tmp_name']) != "") {

                            uploadExcel();

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


                        <!-- EXPORT TO CSV -->
                        <?php if ($_SESSION['user_type'] == "Superadmin") {

                            ?>
                        <table style="background-color:#EEEEEE;" border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                            <tr>

                                <td class="text-center"><b>Download The Organization Details In CSV (excel) format</b></td> 

                                <td><input class="btn btn-primary " type="button" id="export-to-csv" name="export-to-csv" value="Export To CSV" /></td>
                                <form action="organisation.php" method="post" id="export-form">
                                    <input type="hidden" value='export-to-csv' id='hidden-type' name='ExportType'/>
                                </form>

                            </tr>
                        </table>
                       <?php } ?>
                        <!-- EXPORT TO CSV -->


                        <!-- SEARCH BAR -->

                        <div class="control-group container-fluid">
                          <label class="control-label"><h4><b>Search Organisation</b></h4></label>
                          <?php
                          $orgnames = get_organisation();
                          ?>
                            <select id="combobox" data-rule-required="true" class='choiceChosen select2-me input-xlarge' name="qt_organisationid" data-placeholder="Organisation Name" onchange="location=this.value" style="width:200px;">
                            <option value="">-- Select Organisation --</option> 
                            <?php
                            foreach ($orgnames as $values) {
                                ?>
                                <option value="organisationdetails.php?org_id=<?php echo $values['org_id'] ?>"><a href="organisationdetails.php?org_id=<?php echo $values['org_id'] ?>"><?php echo $values['org_name'] ?></a></option>
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

                                    url: "pegination.php",

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
                        <script type="text/javascript">
                            
                            $(document).ready(function() {
                                jQuery('#export-to-csv').bind("click", function() {
                                    var target = $(this).attr('id');
                                    switch(target) {
                                        case 'export-to-csv' :
                                        $('#hidden-type').val(target);
                                        $('#export-form').submit();
                                        $('#hidden-type').val('');
                                        break
                                    }
                                });
                            });
                        </script>
                    </body>

                        </html>