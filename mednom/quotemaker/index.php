<?php
include 'lib/database.php';
?>
<?php 
	include 'lib/function.php';
	if(isset($_POST['submit'])){
		doLogin();
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login :: Admin Panel</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="assets/css/themes.css">

	<!-- jQuery -->
	<script src="assets/js/jquery.min.js"></script>
	<!-- Nice Scroll -->
	<script src="assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- Validation -->
	<script src="assets/js/plugins/validation/jquery.validate.min.js"></script>
	<script src="assets/js/plugins/validation/additional-methods.min.js"></script>
	<!-- Bootstrap -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/eakroko.js"></script>
</head>
<body class="login theme-red" data-theme="theme-red">
	<div class="wrapper">
		<h1><a href="index-2.html"><img src="../admin/images/laboconlogo.jpg" alt="" class='retina-ready'>Admin Panel</a></h1>
		<div class="login-body">
			<h2>SIGN IN</h2>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post' class='form-validate' id="test">
				<div class="control-group">
					<div class="pw controls">
						<input type="text" name="uemail" id="uemail" placeholder="Username" class="input-block-level" data-rule-required="true" data-rule-minlength="3">
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<input type="password" name="upw" id="upw" placeholder="Password" class='input-block-level' data-rule-required="true">
					</div>
				</div>
				<div class="submit">
					<input type="submit"  name="submit" value="Sign me in" class='btn btn-primary'>
				</div>
			</form>
			<div class="forget">
				<a href="#"><span>Forgot password?</span></a>
			</div>
		</div>
	</div>
	
</body>
</html>