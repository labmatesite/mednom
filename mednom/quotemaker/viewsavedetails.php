<?php
session_start();
include 'lib/function.php';
include 'lib/database.php';
checkUser();
if ($_SESSION['user_type'] == "Admin") {
    header('location:home.php');
    exit;
}
include 'lib/header.php';
$usr = $_REQUEST['usr'];
$where = array('sd_userid' => $usr);
$results = selectWhere('quote_savedlogs', $where);
?>
<script>
    $(document).ready(function (e) {

        $("#selectall").click(function () {
            $(".case").attr("checked", this.checked);
        });

        $(".case").click(function () {
            if ($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
            }
            else {
                $("#selectall").removeAttr("checked");
            }
        });
    });
</script>

<div class="container-fluid" id="content">

    <div id="main">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-color box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="icon-table"></i>
                                View Saved Details <?php echo $usr ?>
                            </h3>
                        </div>
                        <div class="box-content nopadding">
                            <form id="mainform" action="#" method="post">
                                <table class="table table-hover table-nomargin table-bordered">
                                    <thead >
                                        <tr>
                                            <th>Sr no.</th>
                                            <th>Subject</th>
                                            <th>Quote ID</th>
                                            <th>Date</th>
                                            <th>Ip Address</th>
                                            <th></th>											
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        date_default_timezone_set("Asia/Calcutta");
                                        $dt = date('Y-m-d');
                                        $r = 1;
                                        foreach ($results as $row_u1) {
                                            ?>
                                            <tr>
                                                <td><?php echo $r; ?></td>
                                                <td><?php echo $row_u1['sd_subject'] ?></td>
                                                <td><?php echo $row_u1['sd_qt_refid'] ?></td>
                                                <td><?php echo $row_u1['sd_date'] ?></td>
                                                <td><?php echo $row_u1['sd_ipaddress'] ?></td>
                                                <?php
                                                $r++;
                                            }
                                            ?>
                                    </tbody>
                                </table>
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