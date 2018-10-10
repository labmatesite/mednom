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
          <li><a href="#">All Product</a></li>
        </ul>
      </div></div></div>
</section>
<!--SLIDER --> 






    <!-- Courses Start -->
        <div id="rs-courses-2" class="rs-courses-2 sec-spacer">
      <div class="container">
        <div class="sec-title mb-50">
 
                  <div class="view-more">
                    <a href="#">View All Products <i class="fa fa-angle-double-right"></i></a>
                  </div>
                </div>

        <div class="row">
  

 <div class="row">
      <?php 
        $img=0;
        for( $i = 1; $i < 13; $i++ ){
        if($i>8){
        $img=0;
        }
        $img++;            
         ?> 
          <div class="col-lg-4 col-md-6">
                    <div class="cource-item">
                        <div class="cource-img">
                            <a href="product.php"><img src="image/img/<?php echo $img?>.png" alt="" /></a>
                                <a class="image-link" href="product.php" title="">
                                    <i class="fa fa-link"></i>
                                </a>
                        </div>
                        <div class="course-body">
                          <a href="product.php" class="course-category"><strong>Price</strong> $250 </a>
                          <h4 class="course-title"><a href="product.php">Medical Treatment Trolley KTR-A201</a></h4>
                          <div class="course-desc">
                            <p>
                              Medical Treatment Trolley KTR-A201 is a dedicated nursing care transport cart built with ABS plastic exterior surface with metallic over-bridge...
                            </p>
                          </div>
                          <a href="product.php" class="cource-btn enq">More Info</a>
                        </div>
                    </div>            
               </div>
            <?php } ?>
        </div>
      </div>
      </div>
        </div>
        <!-- Courses End -->
      
    <!-- Testimonial Start -->
        <div id="rs-testimonial-2" class="rs-testimonial-2 pt-50">
      <div class="container">
        <div class="sec-title mb-50">
          <h2>Related Products</h2>          
        </div>
        <div class="row">
              <div class="col-md-12">
            <div  class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="1200" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true" data-ipad-device-dots="false" data-md-device="2" data-md-device-nav="true" data-md-device-dots="false">

              					<?php 
              					$img=0;
              					for( $i = 1; $i < 8; $i++ ){
              					if($i>8){
              					$img=0;
              					}
              					$img++;            
              					?> 
                      <div class="testimonial-item">
                          <div class="testi-img">
                              <a href="product.php"><img src="image/img/<?php echo $img?>.png" alt=""></a>
                          </div>
                          <div class="testi-desc">
                              <a href="product.php"><h4 class="testi-name">Medical Treatment Trolley KTR-A201</h4></a>
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
                      </div>
                  <?php } ?>
                
                   
              </div>
          </div>
      </div>
        </div>
        <!-- Testimonial End -->
     
<?php 
include('footer.php');
?>

