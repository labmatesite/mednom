
  <?php 
         include('header.php');
        ?>
 
<section class="inner-header">
    <div class="container">
      <div class="row">
        <div class="col-md-12 sec-title colored text-center">
          <h2 class="text-white">Product list</h2>
          <ul class="breadcumb">
            <li><a href="index.php">Home</a></li>
            <li><i class="fa fa-angle-right text-white"></i></li>
            <li><span class="text-white">Product list</span></li>
          </ul>
          
        </div>
      </div>
    </div>
  </section>
  

  <section class="recent-causes sec-padding">
    <div class="container">
      <div class="row causes-style">
<div class="col-lg-3 list_con">
<div class="col-lg-12 product_cat">
          <span class="txt_pr"><span class="col_or">Product </span> List</span>
            </div>

<div class="main_list show_drop">
<span class="main_name_list">Medical Diagnostic  <i class="fa fa-plus plus_ico"></i> <i class="fa fa-minus minus_ico"></i></span>
<div class="sub_pro_show">
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Medical X-ray Imaging</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Breast Scanning System</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Medical Ultrasound</a></div> 
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Dental X-Ray  Imaging</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Colposcope</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Dermatoscope</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>ECG Machines</a></div>
</div>
</div>
<?php 
  $img=0;
  for( $i = 1; $i < 6; $i++ ){
  if($i>8){
  $img=0;
  }
  $img++;            
   ?> 
<div class="main_list">
<span class="main_name_list">Surgical  <i class="fa fa-plus plus_ico"></i> <i class="fa fa-minus minus_ico"></i></span>
<div class="sub_pro_show">
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Anaesthesia Machines</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>C-Arm X-ray Imaging</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Endoscopy Monitor</a></div> 
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Surgical Diathermy</a></div>
 
</div>
</div>

<div class="main_list">
<span class="main_name_list">Critical Care  <i class="fa fa-plus plus_ico"></i> <i class="fa fa-minus minus_ico"></i></span>
<div class="sub_pro_show">
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Infant Incubator</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Infant Warmer</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Phototherapy Device</a></div> 
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Defibrillator</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Infusion Pump</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Patient Monitoring Systems</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Ventilators</a></div>
</div>
</div>

<div class="main_list">
<span class="main_name_list">In-Vitro Diagnosti  <i class="fa fa-plus plus_ico"></i> <i class="fa fa-minus minus_ico"></i></span>
<div class="sub_pro_show">
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Slide Stainer</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Laboratory Analysers</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Medical Refrigeration Systems</a></div> 
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Platelet Agitators</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Platelet Agitator Incubators</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Haemocytometer</a></div>
<div class="all_sub_pro_name"><a href="product.php"><i class="fa fa-caret-right ext" aria-hidden="true"></i>Plasma Thawer</a></div>
</div>
</div>
<?php } ?>


</div>

<div class="col-lg-9 pro_list_con">
 
 <div class="col-lg-12 sub_nm">

<a href="subproduct.php"><span class="sub_txt">Laboratory Balances</span></a>
<a href="subproduct.php"><span class="sub_txt">Centrifuge</span></a>
<a href="subproduct.php"><span class="sub_txt">Furnaces</span></a>
<a href="subproduct.php"><span class="sub_txt">Homogenizer</span></a>
<a href="subproduct.php"><span class="sub_txt">Lab Incubator</span></a>
<a href="subproduct.php"><span class="sub_txt">Microplate Reader</span></a>
<a href="subproduct.php"><span class="sub_txt">Microplate Washer</span></a>
<a href="subproduct.php"><span class="sub_txt">Mixers and Vortexers</span></a>
<a href="subproduct.php"><span class="sub_txt">Oil Baths</span></a>
<a href="subproduct.php"><span class="sub_txt">Spectrophotometer</span></a>
<a href="subproduct.php"><span class="sub_txt">Autoclave</span></a>
<a href="subproduct.php"><span class="sub_txt">Seive shaker</span></a>
<a href="subproduct.php"><span class="sub_txt">Freeze Dryer</span></a>

</div>

<?php 
  $img=0;
  for( $i = 1; $i < 10; $i++ ){
  if($i>8){
  $img=0;
  }
  $img++;            
   ?> 

<div class="col-lg-12 full_list">
<div class="col-lg-3 list_img">
<a href="product.php"><img src="image/img/<?php echo $img?>.png" class="img_list"></a>
</div>
<div class="col-lg-9 name_list">
<a href="product.php"> <h5 class="list_txt">Stationary X-Ray Machine KSX-A100</h5></a>
<div class="tbl">
  <table class="table table-bordered bdt_table hometbl"> 
  <tbody>
  <tr class="trset1">
  <td><strong>Temperature Range</strong></td>
  <td>300°C</td>                       
  </tr>
  <tr class="trset1">
  <td><strong>Internal Dimension</strong></td>
  <td>70x310x145 mm</td>                       
  </tr>
  <tr class="trset1">
  <td><strong>Overall Dimension</strong></td>
  <td>150x3875x265 mm</td>                       
  </tr>
  <tr class="trset1">
  <td><strong>Power</strong></td>
  <td>600 W</td>                       
  </tr>
  </tbody>
  </table>
</div>
<div class="mor_list">
<a href="product.php"><span class="mor_list_add">More Info</span></a>
<span class="com_pare">
<label class="add_comm">
<input class="check-hidden checkbox" type="checkbox" autocomplete="off" value="25">
<i class="fa fa-plus plus_add onclick1"></i>
<i class="fa fa-check check_add onclick1"></i>
</label>
<span class="comp_txt">Add To Compare</span>
</span>

</div>
</div>

</div>
<?php } ?>



</div>


</div>
</section>

 

    <?php 
         include('footer.php');
    ?>