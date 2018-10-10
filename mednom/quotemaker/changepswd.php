<?php
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
if ($_SESSION['user_type'] == "Admin") {
    header('location:index.php');
    exit;
}
if (isset($_POST['submit'])) {
    $Uname = $_POST['username'];
    $Upassword = $_POST['old_pass'];
    $newpass = $_POST['pwfield'];
    $confirmpass = $_POST['confirmfield'];
    $param = array(
        'uname' => $Uname,
        'upswd' => $Upassword,
        'newpswd' => $newpass,
        'confirpswd' => $confirmpass
    );
    change_pasword($param);
}
include 'lib/header.php';
?>
<div class="container-fluid" id="content">
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Change Password</h1>
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
                        <a href="#">Change Password</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Change Password</a>
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
                            <h3><i class="icon-th-list"></i>Change Password</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
                                <div class="control-group">
                                    <label for="textfield" class="control-label">Username</label>
                                    <div class="controls">
                                        <input type="text" name="username" id="username"  placeholder="Username" value="<?php echo $_SESSION['login_user']; ?>" readonly class="input-xlarge" data-rule-required="true" data-rule-minlength="3"> </div>

                                </div>

                                <div class="control-group">
                                    <label for="textfield" class="control-label">Old Password</label>
                                    <div class="controls">
                                        <input type="text" name="old_pass" id="old_pass"  class="input-xlarge" placeholder="Old Password"  data-rule-minlength="3" value=""  data-rule-required="true">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="pwfield" class="control-label">New Password</label>
                                    <div class="controls">
                                        <input type="password" name="pwfield" id="pwfield" placeholder="New Password" class="input-xlarge"  data-rule-minlength="6" data-rule-maxlength="15" data-rule-required="true">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="confirmfield" class="control-label">Confirm password</label>
                                    <div class="controls">
                                        <input type="password" name="confirmfield" id="confirmfield" placeholder="Confirm Password" class="input-xlarge"  data-rule-minlength="6" data-rule-maxlength="15" data-rule-equalTo="#pwfield" data-rule-required="true">
                                    </div>
                                </div>

                                <div class="form-actions" style="background:none !important;">
                                    <button id="submit" type="submit" name="submit" class="btn btn-primary" >Save</button>
                                    <button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>
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




