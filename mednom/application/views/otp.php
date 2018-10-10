<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.form-gap {
    padding-top: 70px;
}
</style>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php if(!empty($this->session->flashdata('err_forgot'))){?>
              <script>
                  // swal("Sorry, There is no Match for that Email Address", "Try Again", "error");
                  alert('Sorry, There is no Match for that Email Address');
              </script>
  <?php }?>
    



 <div class="form-gap"></div>
<div class="container">

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
    <h5 class="alert alert-danger">Email Not Received..? Check your Spam folder </h5>
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
 <h4 class="alert alert-info">We Have Send OTP on Your registered Email Id </h4> 
                  <h3><i class="fa fa-unlock fa-4x" aria-hidden="true"></i>
</h3>
                  <h2 class="text-center">OTP?</h2>
                  <?php if($this->session->flashdata('resend')==1){?>
  <h4 class="alert alert-primary"> Resend Verification Email </h4>   
    <?php }?>
                  <p>Enter Your OTP here.</p>
                  <?php if($this->session->flashdata('resend')){ ?>
        <div class="alert alert-info"> Resend OTP..! </div>
       <?php  } ?>
                  <div class="panel-body">
    
                    <form id="register-form" role="form" autocomplete="off" action="<?= base_url().'verify-otp';?>" class="form" method="post">
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-code" aria-hidden="true"></i></span>
                          <input id="otp" name="otp" placeholder="Enter Your Otp here" class="form-control" required  type="password">
                          <input type="hidden" name="id" value="<?= $id; ?>">
                        
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Verify " type="submit">
                      </div>
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>