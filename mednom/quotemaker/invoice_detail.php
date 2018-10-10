<?php
session_start();
if(!isset($_SESSION['login_user'])){	
header('Location:index.php');
}else{
	include_once 'lib/header.php';
        include_once 'lib/dbfunctionjugal.php';

	// echo $_SESSION['login_user'];
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- PageGuide -->
	<link rel="stylesheet" href="css/plugins/pageguide/pageguide.css">
    	<!-- dataTables -->
	<link rel="stylesheet" href="css/plugins/datatable/TableTools.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">
	<!-- select2 -->
	<link rel="stylesheet" href="css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">
    <style>
	.btn{
		padding:1px 2px !important;
	}
	</style>

<script src="js/jquery-1.8.3.js"></script>

<script>
	$(document).ready(function(e) {
        
		$("#selectall").click(function(){
			$(".case").attr("checked",this.checked);
		});
		
		$(".case").click(function(){
			if($(".case").length==$(".case:checked").length){
				$("#selectall").attr("checked","checked");
			}
			else{
				$("#selectall").removeAttr("checked");
			}
		});
		
    });
	</script>
	<!-- jQuery -->
	<!-- Nice Scroll -->

	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
    	<!-- dataTables -->

	<!-- Theme framework -->
	<script src="js/eakroko.min.js"></script>
	<!-- Theme scripts -->
	<script src="js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="js/demonstration.min.js"></script>
    

    

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

</head>

<body  class="theme-red" data-theme="theme-red">


            
            <!-- main menu -->
			<div class="user">
				
				<div class="dropdown asdf">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo $_SESSION['user1'] ?> </a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="crm_settings.php">CRM Settings</a>
						</li>
						<li>
							<a href="logout.php">Sign out</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="content">
			
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					
                      <?php 
				date_default_timezone_set("Asia/Calcutta");
				$dt=date('F d, Y');
				$week=date('l');
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
								
								</h3>
							</div>
                             
							<div class="box-content nopadding">
                          <?php
						  $qdetails = fetch_edited_quote($_REQUEST['refid']);
						  echo utf8_encode($qdetails['quotedata']);
						  ?>
                         
                 
							</div>
						</div>
					</div>
				</div>
				
	 <!-- Main content end -->		
			</div>
		</div></div>
		
	</body>

	
</html>
