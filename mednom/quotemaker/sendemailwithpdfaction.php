  <?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include  'lib/header.php' ;
$userid=$_SESSION['login_user'];
//echo $userid;
/*$sql_usr="select * from admin where username='$userid'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_array($res_usr);*/
$row_usr = admindetails_byusername($userid);
//var_dump($row_usr);
$ipaddress = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];


$usremail=$row_usr[0]['emailid'];
//echo $usremail;
if($usremail!=""){
$emailpwd=$row_usr[0]['emailpwd'];
$host=$row_usr[0]['host'];
$portno=$row_usr[0]['port'];
require("PHPMailer/class.phpmailer.php");
date_default_timezone_set("Asia/Calcutta");
$dt=date('Y-m-d H:i:s');
$temp_dt=date('d F Y');

$refid=$_REQUEST['refid'];

$path = "user_data/".$refid."/";

/*$sql_up_del="delete from quote_uploaddata where up_refid='$refid'";
$res_up_del=mysql_query($sql_up_del);
$affected=mysql_affected_rows();*/
$affected = delete_upload_data($refid);

if($affected!=0)
{
// Loop over all of the files in the folder
foreach(glob($path ."*.*") as $file) {
    unlink($file); // Delete each file through the loop
}
rmdir($path);
}
else
{
}

if(isset($_FILES['files'])){  
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name =$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 5242880){
			$errors[]='File size must be less than 5 MB';
        }
		if($file_size != 0){		
     // $query="INSERT into quote_uploaddata (up_refid,up_file_name,up_file_size,up_file_type) VALUES('$refid','$file_name','$file_size','$file_type'); ";
       
	   
	    $desired_dir="user_data/".$refid;
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
			quote_uploaddata('$refid','$file_name','$file_size','$file_type');
		// mysql_query($query);
        }else{
                print_r($errors);
        }
		}
    }
	
}


	/*$emailId=mysql_real_escape_string($_POST['emailId']);
	$e_subject=mysql_real_escape_string($_POST['subject']);
	$addcc=mysql_real_escape_string($_POST['addcc']);
	$addBCC=mysql_real_escape_string($_POST['addBCC']);
	
	$msg1=mysql_real_escape_string($_POST['content']);*/
	
	$emailId=$_POST['emailId'];
	$e_subject=$_POST['subject'];
	$addcc=$_POST['addcc'];
	$addBCC=$_POST['addBCC'];
	$msg=$_POST['content'];
	$msg = stripslashes($msg);
	//$order   = array('\r\n', '\n', '\r');
	//$replace = '<br />';
	//$msg2 = str_replace($order, $replace, $msg1);
	//$char1=array("'","<p>","</p>");
	//$char2=array("&#146;","","");
	//$msg=str_replace($char1,$char2,$msg2);

	$mail = new PHPMailer(true);
	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = $portno;                    // set the SMTP server port
	$mail->Host       = $host; // SMTP server
	$mail->Username   = $usremail;     // SMTP server username
	$mail->Password   = $emailpwd;            // SMTP server password

	
	$mail->IsSendmail();  // tell the class to use Sendmail
			
	$mail->From     = $usremail;
	$mail->FromName = $usremail;
	
	$arr_emailId = explode(",",$emailId);
	$cnt=count($arr_emailId);
	$cntfinal=$cnt-1;
	for($i=0;$i<=$cntfinal;$i++)
	{
		$mail->AddAddress($arr_emailId[$i]);
	}
	
	if($addcc!="")
	{
	$arr_addcc = explode(",",$addcc);
	$cnt1=count($arr_addcc);
	$cntfinal1=$cnt1-1;	
		for($j=0;$j<=$cntfinal1;$j++)
		{	
		$mail->AddCC($arr_addcc[$j]);
		}
	}// optional name

	if($addBCC!="")
	{
	$arr_addBCC = explode(",",$addBCC);
	$cnt2=count($arr_addBCC);
	$cntfinal2=$cnt2-1;	
		for($k=0;$k<=$cntfinal2;$k++)
		{	
		$mail->AddBCC($arr_addBCC[$k]);	
		}
	}

	$mail->WordWrap = 50;                              // set word wrap

	$mail->IsHTML(true);                               // send as HTML

	$mail->Subject  =  $e_subject;

	if($msg!="")
	{
	$body = $msg;
	}else
	{
	$body = ".";
	}


	$mail->MsgHTML($body);

	if (isset($_FILES['mzAttach']) && $_FILES['mzAttach']['error'] == UPLOAD_ERR_OK) {   
						$mail->AddAttachment($_FILES['mzAttach']['tmp_name'],
											 $_FILES['mzAttach']['name']);
						}
						else
						{	
	   
	$mail->AddAttachment("tcpdf/examples/savedpdf/".$refid.".pdf"); 	
						}
					
	
	/*$sql_ct="select * from quote_product where qt_refid='$refid' group by product_catalog";
	$res_ct=mysql_query($sql_ct);
	$tot_ct=mysql_num_rows($res_ct);
	if($tot_ct!=0)
	{
		while($row_ct=mysql_fetch_array($res_ct))
		{
			if($row_ct['product_catalog']!="")
			{
					
					$filename = '../../catalog/'.$row_ct['product_catalog'].'pdf';
	
					if (file_exists($filename)) {
						
							$mail->AddAttachment("../../catalog/".$row_ct['product_catalog'].".pdf"); 
					} 
					else {
						
					}
			}
		}
		
	}*/
	
	
/*	$sql_up="select * from quote_uploaddata where up_refid='$refid'";
	$res_up=mysql_query($sql_up);
	$tot_up=mysql_num_rows($res_up);*/
	$res_up=select_upload_data($refid);
	$tot_up=count($res_up);
	//echo $tot_up;
	//var_dump($res_up);
	//exit(0);
	$atta="";
	if($tot_up > 0)
	{
		/*foreach($res_up as $row_up)
		{
	$mail->AddAttachment("user_data/".$refid."/".$row_up['up_file_name']); 
	$atta=$row_up['up_file_name'].",".$atta;	
		}*/
	}
					

	if(!$mail->Send())
	{ 
	   echo "Message was not sent <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}  
	else
	{ 
	/*$sql_esent="insert into quote_emaillogs (el_userid,el_from,el_to,el_acc,el_bcc,el_subject,el_content,el_attachments,el_date,el_ipaddress) values ('$userid','$usremail','$emailId','$addcc','$addBCC','$e_subject','$body','$atta','$dt','$ipaddress')";
	$res_esent=mysql_query($sql_esent);	*/
	insert_quote_emaillogs($userid,$usremail,$emailId,$addcc,$addBCC,$e_subject,$body,$atta,$dt,$ipaddress);
		
	?>
	<script type="text/javascript">
	window.open('view_quote.php','_self');
	</script>
	<?php
	}
}
else
{
?>
<script
 type="text/javascript">
alert("Email Issue. Kindly Contact Admin");
history.go(-1);
</script>
<?php
}
?>