<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include 'lib/header.php';
?>
<style>
    .btn {
        padding: 1px 2px !important;
    }
</style>


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
            <div class="page-header">
                <div class="pull-left">
                    <h1>Admin Rights</h1>
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
                        <a href="#">Admin Rights</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">View Admin</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <?php
            //$sql_a2="select * from admin order by id";
            //$res_a2=mysql_query($sql_a2);

            ?>
            <!-- Main content start -->

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-color box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="icon-table"></i>
                                Admin Rights
                            </h3>
                        </div>

                        <div class="box-content nopadding">
                            <br>
                            <a href="add_admin.php" style="margin-left:10px;">
                                <button class="btn btn-primary">Add Admin</button>
                            </a>
                            <form id="mainform" action="deleteadmin.php" method="post">
                                <table class="table table-bordered dataTable dataTable-scroll-x">
                                    <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Full Name</th>
                                        <th>User Type</th>
                                        <th>Username</th>
                                        <th>Email Id</th>
                                        <th>Password</th>
                                        <th>Outside Access</th>
                                        <th>Date</th>
                                        <th></th>
                                        <th><a href="#"><input type="checkbox" id="selectall"/></a>
                                            <input type="submit" name="main" value="Delete"
                                                   style="margin-left:10px; font-size:16px"/></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $r = 1;
                                    $res_a2 = list_admin_users();

                                    foreach ($res_a2 as $row_a2) {

                                        ?>
                                        <tr>
                                            <td><?php echo $r; ?></td>
                                            <td><?php echo $row_a2['full_name'] ?></td>
                                            <td><?php echo $row_a2['userType'] ?></td>
                                            <td><?php echo $row_a2['username'] ?></td>
                                            <td><?php echo $row_a2['emailid'] ?></td>
                                            <td><?php echo $row_a2['password'] ?></td>
                                            <td><?php echo ucwords($row_a2['outside']); ?></td>
                                            <td><?php echo $row_a2['dt'] ?></td>
                                            <td>
                                                <div align="center"><a
                                                        href="edit_admin.php?id=<?php echo $row_a2['id'] ?>"><img
                                                            src="images/edit.png" width="16" height="16"
                                                            border="0"/></a></div>
                                            </td>
                                            <td>
                                                <div align="center"><input type="checkbox" class="case" name="admin[]"
                                                                           value="<?php echo $row_a2['id'] ?>"/></div>
                                            </td>
                                        </tr>
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
    </div>
</div>

</body>


</html>

