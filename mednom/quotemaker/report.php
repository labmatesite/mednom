<?php

session_start();

include 'lib/database.php';

include 'lib/function.php';

checkUser();

if ($_SESSION['user_type'] == "Admin") {

    header('location:index.php');

    exit;

}

include 'lib/header.php';

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<div class="container-fluid" id="content">

    <div id="main">

        <div class="container-fluid">

            <div class="page-header">

                <div class="pull-left">

                    <h1>Reports</h1>

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

                        <a href="#">report</a>

                        <i class="icon-angle-right"></i>

                    </li>

                    <li>

                        <a href="#">View report</a>

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

                                Reports

                            </h3>

                        </div>

                        <div class="box-content nopadding">

                            <br>

                            </table>

                            <?php

                            if ($_SESSION['user_type'] == "Superadmin" || $_SESSION['user_type'] == "users") {

                                ?>

                                <form action="" enctype="multipart/form-data" method="post" name="mzForm">

                                </form>

                            <?php } ?>

<div id="results"></div>

<div class="loader"></div>


                        </div>

                    </div>

                </div>

            </div>



            <!-- Main content end -->		

        </div>

    </div></div>





<script type="text/javascript">

    // fetching records

    function displayRecords(numRecords, pageNum) {

        $.ajax({

            type: "GET",

            url: "report_pegination.php",

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

        displayRecords(50, 1);

    });

</script>

</body>

</html>





