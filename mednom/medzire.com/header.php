<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <title>medzire.com</title>
  <link type="image/x-icon" href="image/icon.png" rel="icon">

  <!-- responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- master stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <!-- responsive stylesheet -->
  <link rel="stylesheet" href="css/bootstrap-margin-padding.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="vendor/slider/css/nivo-slider.css" type="text/css">
  <link rel="stylesheet" href="vendor/slider/css/preview.css" type="text/css" media="screen">

<script src="js/onclick_jquery.min.js"></script>

<script type="text/javascript">
  

  $(function () {
    $('.main_name_list').click(function () {    
     $(this).parent().toggleClass('show_drop').siblings().removeClass('show_drop');
  });
}); 

    $(function () {
    $('.onclick1').click(function () {    
     $(this).parent().parent().toggleClass('show_compare');
  });
}); 

 $(function () {
    $('.get_quote_cs').click(function () {
     $('body').toggleClass('get_qt_open');
     // $(this).toggleClass('act');        
  });
}); 

  $(function () {
    $('.send_enq_clouse').click(function () {
     $('.get_qt_open').removeClass('get_qt_open');
     
  });
}); 


  $(function () {
    $('.login_pop').click(function () {
     $('body').toggleClass('sign_login');
     // $(this).toggleClass('act');        
  });
}); 

  $(function () {
    $('.btn_cluse').click(function () {
     $('.sign_login').removeClass('sign_login');
     
  });
}); 

$(function() {
    $(".account_new").click(function() {
        $(".rig_pop").toggleClass("show_hed")
    })
});


//  $(function () {
//     $('.all_pro_menu').hover(function () {
//     $('body').addClass('drop_add');    
//   });
// });

//   $(function () {
//     $('.popup_mnu').mouseleave(function () {
//     $('.home_add').removeClass('home_add');
//     $('.home_add1').removeClass('home_add1');
//     $('.act').removeClass('act');
//   });
// }); 

</script>

</head>
<body class="page-wrapper"> 


<div class="popup_login1">
                            <div class="rig_pop">
                                <div class="head_er"><span>Login</span><i class="fa fa-close btn_cluse"></i></div>
                                <div class="login_add">
                                    <div class="col-md-12">
                                        <form method="post" action="#"><span class="label_txt">Email Id</span>
                                            <input type="email" class="form_login" name="email" placeholder="Email Id"><span class="label_txt">Password</span>
                                            <input type="password" class="form_login" name="password" placeholder="Password"><span class="check_bx"><input type="checkbox" name=""><span class="remb_me">Remember Me</span></span>
                                            <button type="submit" class="btn_login">Login</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12"><span class="account_add">Don't have an account yet?</span><span class="account_new">Register Here</span></div>
                                </div>
                                <div class="register_add">
                                    <div class="col-md-12">
                                        <form method="post" action="https://www.labotronics.com/insert-user-data"><span class="label_txt">Name</span>
                                            <input type="text" class="form_login" name="username" placeholder="Name"><span class="label_txt">Email Id</span>
                                            <input type="email" class="form_login" name="email" placeholder="Email Id"><span class="label_txt">Password</span>
                                            <input type="password" class="form_login" name="password" placeholder="Password"><span class="check_bx"><input type="checkbox" name=""><span class="remb_me">I agree to the terms &amp; conditions</span></span>
                                            <button type="submit" class="btn_login">Register</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12"><span class="account_add">Don't have an account yet?</span><span class="account_new">Login account</span></div>
                                </div>
                            </div>
                        </div>








  <header class="header">
    <div class="container">
      <div class="logo pull-left">
        <a href="index.php">
          <img src="image/logo.png" alt="Awesome Image"/>
        </a>
      </div>
      <div class="header-right-info pull-right clearfix">
        <div class="single-header-info dis_none">
          <div class="icon-box">
            <div class="inner-box">
              <i class="flaticon-interface-2"></i>
            </div>
          </div>
          <div class="content">
            <p>info@medzire.com</p>
          </div>
        </div>
        <div class="single-header-info dis_none">
          <div class="icon-box">
            <div class="inner-box">
              <i class="flaticon-telephone"></i>
            </div>
          </div>
          <div class="content">
            <p><b>+44 2080 043 608</b></p>
          </div>
          <div class="content log">
            <p class="login_pop"><b><i class="fa fa-user us_er"></i> login</b></p>
          </div>
        </div>
       <div class="search_cl">
        <input type="text" class="sear_ch" placeholder="Search..." name="Search">
        <i class="fa fa-search src_add"></i>
       </div>
      </div>
    </div>
  </header> <!-- /.header -->

  <nav class="mainmenu-area stricky">
    <div class="container">
      <div class="navigation">
        <div class="nav-header frist_cap">
          <ul class="update_mob">
            <li><a href="#">Home</a></li>
            <li class="all_pro_menu"><a href="allproducts.php">All Products</a>
  <div class="all_product_drop">
<div class="drp_hed">

<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Anaesthesia Machines</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Anaesthetic Face Mask</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Ankle Braces</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Autopsy Table</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Breast Pump</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Breast Scanning System</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>C-Arm X-ray Imaging</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Canes</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Colposcope</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Conductive Ultrasonic/ECG Gels</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>CPAP Machine</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Crutches</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Defibrillator</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Dental Chair</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Dental X-Ray Imaging</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Dermatoscope</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Dialyser Reprocessing Machines</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Diaper Trolley</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Diathermy Plate</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Disposable Breathing Circuits</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Disposable Electrode Pads</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>ECG Machines</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>EEG Machines</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Endoscopy Driers</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Endoscopy Monitor</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>ENT Diagnostic Kit</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Haemocytometer</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Haemoglobinometer</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Hospital Beds</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Hydraulic Cylinders</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Infant Incubator</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Infant Warmer</div></a>
<a href="productlist.php"><div class="drop_all_pro"><i class="fa fa-caret-right extra" aria-hidden="true"></i>Infusion Pump</div></a> 
</div>
  </div>

            </li>
            <li><a href="#">Medical Devices</a>
              <ul class="submenu sub_mnu">
                <li><a href="productlist.php">Medical Diagnostic</a></li>
                <li><a href="productlist.php">Surgical</a></li>
                <li><a href="productlist.php">Critical Care</a></li>
                <li><a href="productlist.php">In-Vitro Diagnostic</a></li>
                <li><a href="productlist.php">General Aids</a>
              </ul>

            </li>
            <li><a href="#">Hospital Furnitures</a>
              <ul class="submenu sub_mnu">
                <li><a href="productlist.php">Medical Diagnostic</a></li>
                <li><a href="productlist.php">Surgical</a></li>
                <li><a href="productlist.php">Critical Care</a></li>
                <li><a href="productlist.php">In-Vitro Diagnostic</a></li>
                <li><a href="productlist.php">General Aids</a>
              </ul>
            </li>
            <li><a href="#">Medical Supplies</a>
              <ul class="submenu sub_mnu">
                <li><a href="productlist.php">Medical Diagnostic</a></li>
                <li><a href="productlist.php">Surgical</a></li>
                <li><a href="productlist.php">Critical Care</a></li>
                <li><a href="productlist.php">In-Vitro Diagnostic</a></li>
                <li><a href="productlist.php">General Aids</a>
              </ul>
            </li>
            <li><a href="#">Home Healthcare</a>
              <ul class="submenu sub_mnu">
                <li><a href="productlist.php">Medical Diagnostic</a></li>
                <li><a href="productlist.php">Surgical</a></li>
                <li><a href="productlist.php">Critical Care</a></li>
                <li><a href="productlist.php">In-Vitro Diagnostic</a></li>
                <li><a href="productlist.php">General Aids</a>
              </ul>
            </li>
            <li><a href="#">Catalogs</a></li>
            <li class="com_info"><a href="#">Company Info</a>
              <ul class="submenu">
                <li><a href="aboutus.php">About Us</a></li>                 
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="#">Site Map</a></li>
              </ul>

            </li>
          </ul>
        </div>
        <div class="nav-footer">
          <button><i class="fa fa-bars"></i></button>
        </div>
      </div>
    </div>
  </nav><!-- /.mainmenu-area -->

