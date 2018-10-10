<?php 
include('header.php');
?>

<!--  SLIDER  -->
<section class="about_hed">
 <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
      	<ul class="hed">
      		<li><a href="index.php">Home</a></li>
      		<li><a href="javascript:;">|</a></li>
      		<li><a href="#">Register</a></li>
      	</ul>
      </div></div></div>
</section>
<!--SLIDER -->

 <div class="rs-history sec-spacer">
            <div class="container">
                <div class="row">

                  <div class="col-md-4"> 

                  </div>

                    <div class="col-md-4 col-sm-6 col-xs-12 cont_rol"> 
                            <!-- <div class="col-lg-4 col-lg-offset-4 cont_rol"> -->
                            <form method="POST" class="act_form">  
            <div class="full_form form-bottom jumbotron">

                <p class="text-success">Distributor Registration !!!</p>
                 <div class="form-group">
                    <label title="Email Id">Company Name <span>*</span></label>
                    <input class="form-control br0" name="Company" type="text" placeholder="Enter your Company Name" required="required">
                </div>
                 <div class="form-group">
                    <label title="Email Id">Contact Person <span>*</span></label>
                    <input class="form-control br0" name="Person" type="text" placeholder="Enter your Contact Person" required="required">
                </div>
                 <div class="form-group">
                    <label title="Email Id">Email Id <span>*</span></label>
                    <input class="form-control br0" name="email" type="text" placeholder="Enter your Email Id" required="required">
                </div>
                 <div class="form-group">
                    <label title="Password">Password <span>*</span></label>
                    <input class="form-control br0" name="password" type="password" placeholder="Enter your Password" required="required">
                </div>

                 <div class="form-group">
                    <label title="Password">Re-Password <span>*</span></label>
                    <input class="form-control br0" name="password" type="password" placeholder="Enter your Re-Password" required="required">
                </div>

                 <div class="form-group">
                    <label title="Password">Contact No <span>*</span></label>
                    <input class="form-control br0" name="phone" type="text" placeholder="Enter your Contact No" required="required">
                </div>
                 <div class="form-group">
                    <label title="Password">Country</label>
                    <input class="form-control br0" name="Country" type="text" placeholder="Enter your Country" required="required">
                </div>
                  <div class="form-group">
                    <label title="Password">Address</label>
                    <textarea name="megs" class="form-control br0" placeholder="Address"></textarea>
                </div>

                <div class="btn_login_div">
                    <input class="btn_login" type="submit" value="Register" name="btn_login">
                </div>

                <div class="reg_txt">Already have an account? <span><a href="login.php"> Login here.</a></span></div>

            </div>
        </form>
                            </div>

                    <div class="col-md-4"> 

                  </div>
                    
                </div>
            </div>
        </div>

   
<?php 
include('footer.php');
?>

