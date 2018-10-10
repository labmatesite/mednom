
  <?php 
         include('header.php');
        ?>

 

    <div class="slid dis_none">
 <img src="image/banner1.png" alt="slider" class="img-responsive" title="banner">
    </div>


  <section class="recent-causes sec-padding dis_none">
    <div class="container">
      <div class="row causes-style">
<div class="col-lg-12 font_text">

<p>Medzire is a UK based leading manufacturers of medical devices served in the field of Hospitals, Biomedical industry, Pharmaceutical industry, Biotechnology industry, Education institutes and research laboratories.</p>

<p>Our aim is to achieve customer satisfaction by providing clinically superior and cost effective solutions improving patient life. We hold an extensive range of healthcare including medical monitors, diagnostic equipment’s, laboratory medical devices, measuring devices, life supporting medical equipment’s, treatment devices, accessories, consumables and hospital furniture’s providing comprehensive array of products for Medical and Hospital environment.</p>

<p>We assure quality and reliability of our products as all our equipment’s are clinically validated and tested by our engineers before dispatching the consignment.We have been accredited with standard certifications CE, ISO 9001: 2008 as per safety guidelines.</p>

</div>


</div>
</section>


  <section class="recent-causes sec-padding">
    <div class="container">
      <div class="row causes-style">
        <div class="col-lg-12 product_cat">
          <span class="txt_pr"><span class="col_or">Medical</span> Equipment Directory</span>
            </div>

    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Medical Diagnostic </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Surgical </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Critical Care </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> In-Vitro Diagnostic </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> General Aids </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> In-Patient Solutions </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> OR Solutions </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Patient Transfer Solutions </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Respiratory Aids </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Mobility Aids </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Daily Care </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Medical Consumables </span></a></div>
    <div class="col-lg-3 pro_con"><a href="productlist.php"><span class="pro_name"> Medical Disposables</span></a></div>
      
    </div>
  </div>
</section>


  <section class="recent-causes sec-padding">
    <div class="container">
      <div class="row causes-style">
        <div class="col-lg-12 product_cat">
          <span class="txt_pr"><span class="col_or">All</span> Products</span>
            </div>


            <?php 
              $img=0;
              for( $i = 1; $i < 16; $i++ ){
              if($i>8){
              $img=0;
              }
              $img++;            
               ?> 
              <div class="col-lg-3 marg_b">                
                <div class="ful_div">
                  <i class="bdr1"></i>
                <i class="bdr2"></i>
                <div class="ing_pro">
                  <a href="productlist.php"><img src="image/img/<?php echo $img?>.png" class="pro_img_siz"></a>
                </div>
                <a href="productlist.php"><div class="name_txt">
                  Stationary X-Ray Machine KSX-A100
                </div></a>
                <div class="more">
                  <a href="productlist.php"><span class="mor_i">More Info</span></a>
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