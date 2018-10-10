<?php
include_once 'lib/dbfunctionjugal.php';
date_default_timezone_set('Asia/Kolkata');
$todaydt = date("Y-m-d H:i:s");

/*$rights=mysql_real_escape_string($_POST['rights']);
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$emailid=mysql_real_escape_string($_POST['emailid']);
$epassword=mysql_real_escape_string($_POST['epassword']);
$host=mysql_real_escape_string($_POST['host']);
$portno=mysql_real_escape_string($_POST['portno']);
$a_ipaddress=mysql_real_escape_string($_POST['a_ipaddress']);
$outside=mysql_real_escape_string($_POST['outside']);*/

$rights = $_POST['rights'];
$full_name = $_POST['full_name'];
$username = $_POST['username'];
$password = $_POST['password'];
$emailid = $_POST['emailid'];
$epassword = $_POST['epassword'];
$tnc = $_POST['tnc'];
$qt_cur = $_POST['qt_cur'];
$qt_price = $_POST['qt_price'];
$host = $_POST['host'];
$portno = $_POST['portno'];
$a_ipaddress = $_POST['a_ipaddress'];
$outside = $_POST['outside'];

$correct = 0;

//$sql1="select * from admin where username='$username' and userType='$rights'";
//$res1=mysql_query($sql1);
$tot1 = find_admin_users($username, $rights);
if ($tot1 == 0) {

    /*$sql = "insert into admin(userType,username,password,emailid,emailpwd,host,port,dt,a_ipaddress,outside) value ('$rights','$username','$password','$emailid','$epassword','$host','$portno','$todaydt','$a_ipaddress','$outside')";
    $res = mysql_query($sql);*/

    create_admin_users($rights,$full_name, $username, $password, $emailid, $epassword, $host, $portno, $todaydt, $a_ipaddress, $outside, $tnc, $qt_cur, $qt_price);

    /*if($res)
    {
    $correct=1;
    }*/
    ?>
    <script type="text/javascript">
        window.open('view_admin.php', '_self');
    </script>

    <?php
    /*	if($correct==1)
        {
    ?>
        <script type="text/javascript">
        window.open('view_admin.php','_self');
        </script>
    <?php
        }
        else
        {
    ?>
            <script type="text/javascript">
            alert("Cannot add . Please Try Again");
            history.go(-1);
            </script>
    <?php
        }*/
} else {
    ?>
    <script type="text/javascript">
        alert("Rights already assigned to Username(<?php echo $username; ?>)");
        history.go(-1);
    </script>
    <?php
}
?>

