<?php 
include('header.php');
?>
     
     <div class="slid_1 dis_none" align="center">     
           <img src="image/slide1.jpg" alt="Slide1" />       
        </div>
     

        <!-- Why Choose Us Start-->
        <div class="rs-why-choose sec-spacer">
            <div class="container">
            <div class="row">
                    <div class="col-lg-12 col-md-12">                     
                        <div class="choose-desc dis_none">
                          <p>
                           Medofficesupplies is a UK based leading manufacturers of medical devices served in the field of Hospitals, Biomedical industry, Pharmaceutical industry, Biotechnology industry, Education institutes and research laboratories.</p>

<p>Our aim is to achieve customer satisfaction by providing clinically superior and cost effective solutions improving patient life. We hold an extensive range of healthcare including medical monitors, diagnostic equipment’s, laboratory medical devices, measuring devices, life supporting medical equipment’s, treatment devices, accessories, consumables and hospital furniture’s providing comprehensive array of products for Medical and Hospital environment.</p>

<p>We assure quality and reliability of our products as all our equipment’s are clinically validated and tested by our engineers before dispatching the consignment.We have been accredited with standard certifications CE, ISO 9001: 2008 as per safety guidelines.</p>

                        </div>


                      <div class="row">
                        <span class="pro_duct_name">Medical Equipment <span class="col_orr"> Directory</span></span>
                      </div>

                          <div class="row choose-list mtb-10">
                           

  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Medical Diagnostic</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Surgical</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Critical Care</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">In-Vitro Diagnostic</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">General Aids</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">In-Patient Solutions</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">OR Solutions</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Patient Transfer Solutions</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Respiratory Aids</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Mobility Aids</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Daily Care</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Medical Consumables</h3></a></div>
  <div class="col-md-3"><a class="bg_col" href="productlist.php"> <h3 class="dir_ect">Medical Disposables</h3></a></div>

 
                        </div>
                        
                    </div>
                     
             

            </div>
            </div>
        </div>
        <!-- Why Choose Us End -->

    <!-- Courses Start -->
        <div id="rs-courses-2" class="rs-courses-2 sec-spacer">
      <div class="container">
        <div class="row">
        <span class="pro_duct_name">All <span class="col_orr">Products</span></span>
      </div>
        <div class="row">



 <?php 
				          $img=0;
				          for( $i = 1; $i < 16; $i++ ){
				          if($i>8){
				          $img=0;
				          }
				          $img++;            
				           ?> 
          <div class="col-lg-4 col-md-6 ani_mat">
                    <div class="cource-item">
                        <div class="img_pro">
                            <a href="productlist.php"><img src="image/img/<?php echo $img?>.png" alt="" /></a>                               
                        </div>
                        <div class="course-body">                          
                          <h4 class="course-title"><a href="productlist.php">Medical Treatment Trolley KTR-A201</a></h4>
                          <div class="course-desc">
                            <table class="table table-bordered displayshow1 margb0"> 
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
                          <a href="productlist.php" class="cource-btn enq">More Info</a>
                        </div>
                    </div>            
          </div>
<?php } ?> 

     

          </div>
      </div>
        </div>
        <!-- Courses End -->
       
     
<?php 
include('footer.php');
?>

