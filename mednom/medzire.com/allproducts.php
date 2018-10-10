
  <?php 
         include('header.php');
        ?>
 
<section class="inner-header">
    <div class="container">
      <div class="row">
        <div class="col-md-12 sec-title colored text-center">
          <h2 class="text-white">All Products</h2>
          <ul class="breadcumb">
            <li><a href="index.php">Home</a></li>
            <li><i class="fa fa-angle-right text-white"></i></li>
            <li><span class="text-white">All Products</span></li>
          </ul>
          
        </div>
      </div>
    </div>
  </section>
  

  <section class="recent-causes sec-padding">
    <div class="container">
      <div class="row causes-style">
<?php 
              $img=0;
              for( $i = 1; $i < 16; $i++ ){
              if($i>8){
              $img=0;
              }
              $img++;            
               ?> 

<div class="col-lg-4 all_pro">
<div class="all_main_pro">
<i class="main_ico"></i>Medical Diagnostic 
</div> 
<div class="sub_div">
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Medical X-ray Imaging</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Breast Scanning System</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Medical Ultrasound</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Urea Breath Test Analyser</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Dental X-Ray  Imaging</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Colposcope</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Dermatoscope</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>ECG Machines</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Otoscope</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>ENT Diagnostic Kit</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Ultrasonic Doppler</a></div>
<div class="all_sub_pro_name"><a href="productlist.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>EEG Machines</a></div>






</div>
</div>
<?php } ?>

 


</div>
</section>

 
 


    <?php 
         include('footer.php');
    ?>