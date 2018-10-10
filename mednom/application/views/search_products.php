<style>
.btn-body .details_btn
{
	padding-left: 6.75rem;
	padding-right: 6.75rem;
	margin-top: 14px;
	background-color: #0F3661;
	border-color: #0F3661;
}
</style> 
<ol class="breadcrumb"> 
  <li class="container">Search Keyword : <span style="font-style:italic; color:red;"><?php echo $search_key; ?></span></li>     
</ol> 
<div class="container">
  <div class="row">
  <div class="container">
  <?php 
    if($searched_category !== ""){ 
      echo '<h4>Searched Result : <h4>';  
      
      foreach($searched_category as $key => $value){
        
  ?>
        <div class="col-md-3">
          <ul>
            <li><h5><a href="<?= base_url($value['page_url']);?>"> <?= $value['name'] ?></a></h5></li>
          <ul>
        </div>    
  <?php 
       } 
    } 
  ?>
</div>
<hr>
  <?php if($searched_products !== ""){
    foreach ($searched_products as $key => $value) { ?>
      <div class="col-md-3 col-sm-6 col-xs-12" >
        <?php $count_cat = substr_count($value['page_url'], "/");
        if($count_cat == 2){ ?>
      <a href="<?php echo base_url(); echo $value['page_url']; ?>">
      <?php } else { ?>
    <a href="<?php echo base_url().$value['page_url']; ?>">
        <?php } ?>
        <div class="thumbnail" style="height:330px;box-shadow:7px 6px 11px 0px #f7f7f7">
        <?php
        $json = str_replace(array("\t","\n"), "", $value['image_urls']);
        $data = json_decode($json);
        $i=0; foreach ($data as $key => $value_img) {
        $related_prod_img['img'][$i] = $value_img;
        $i++; } ?> 
        <img itemprop="image" src="<?php echo base_url().$related_prod_img['img']['1'] ?>" alt="<?php echo $value['name']; ?>">
        <div class="caption">
          <p title="<?= $value['name']; ?>" style="color:rgb(240, 90, 43);"><?php echo substr($value['name'], 0, 45).".."; ?></p>
          <p> 
           
        </div>
      </div>
    </a>
    </div>
  <?php } } else {?>
    <div class="alert alert-danger">No Products Founds </div>
  <?php } ?>
  </div>
</div>

<footer id="footer" class="footer-simple footer-dark">

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.hoverIntent.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waypoints-sticky.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.debouncedresize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.lavalamp.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/js/countdown.js"></script>
</body>
</html>