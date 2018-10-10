<?php
include_once 'lib/dbfunctionjugal.php';
date_default_timezone_set('Asia/Kolkata');
$todaydt = date("Y-m-d H:i:s");
$id = $_REQUEST['id'];

$full_name = $_POST['full_name'];
$rights = $_POST['rights'];
$username = $_POST['username'];
$password = $_POST['password'];
$emailid = $_POST['emailid'];
$epassword = $_POST['epassword'];
$host = $_POST['host'];
$portno = $_POST['portno'];
$a_ipaddress = $_POST['a_ipaddress'];
$outside = $_POST['outside'];
$qt_cur = $_POST['qt_cur'];
$tnc = $_POST['tnc'];
$qt_price = $_POST['qt_price'];
$correct = 0;

/*$sql = "update admin set userType='$rights',password='$password',emailid='$emailid',emailpwd='$epassword',host='$host',port='$portno',a_ipaddress='$a_ipaddress',dt='$todaydt',outside='$outside' where id='$id'";*/

$res = update_admin_users($id, $full_name, $rights, $password, $emailid, $epassword, $tnc, $qt_cur, $qt_price, $host, $portno, $a_ipaddress, $todaydt, $outside);
//if($res)
//{
$correct = 1;
//	}
?>
<?php
if ($correct == 1) {
    ?>
    <script type="text/javascript">
        alert("Admin details updated successfully");
        window.open('view_admin.php', '_self');
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Cannot add . Please Try Again");
        history.go(-1);
    </script>
    <?php
}
?>

