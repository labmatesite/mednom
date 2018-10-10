<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include  'lib/header.php' ;


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<style>
.choiceChosen, .productChosen {
  width: 250px !important;
}
.chosen-container .chosen-drop{
    width: 150%;
}
.select2-container{
	display: none;
}
</style>
<div class="container-fluid" id="content">
			<!--<div id="left">
			<form action="#" method="GET" class='search-form'>
				<div class="search-pane">
					<input type="text" name="search" placeholder="Search here...">
					<button type="submit"><i class="icon-search"></i></button>
				</div>
			</form>
		</div>-->
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>View Quotations</h1>
					</div>
					<?php 
					date_default_timezone_set("Asia/Calcutta");
					$dt=date('F d, Y');
					$week=date('l');
					?>
					<div class="pull-right">
						<ul class="stats">
							<li class='lightred'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big"><?php echo $dt; ?></span>
									<span><?php echo $week; ?></span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="home.php">Home</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="#">Quotations</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="#">View Quotations</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>

				<!-- Main content start -->

				<div class="row-fluid">
					<div class="span12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									View Quotations
								</h3>
							</div>
							<div class="box-content nopadding">
								<br>
								<a href="create_quote.php" style="margin-left:10px;"><button class="btn btn-primary">Create Quote</button></a>
								<br><br>
								<!-- SEARCH BAR -->

								<div class="control-group container-fluid">
									<label class="control-label"><h4><b>Search Quotation</b></h4></label>
									<?php
									$pronames = get_all_quotelist($_SESSION['login_user']);
									?>
									<select id="combobox" data-rule-required="true" class='choiceChosen select2-me input-xlarge' name="qt_organisationid" data-placeholder="Quotations Name" onchange="location=this.value" style="width:200px;">
										<option value="">-- Select Quotation --</option> 
										<?php
										foreach($pronames as $row3)
					                   	{
					                   		$row_contacts= contact_details($row3['qt_contacts']);
					                   		$date = $row3['qt_createddt'];
					                   		$time = strtotime($date);
											$q_date = date("m/d/y g:i A", $time);
					                   		
					                   		$term = $row3['qt_createdby']." :: ".  $row_contacts['cont_firstname']." ".$row_contacts['cont_lastname'] ." - [ ". $q_date ." ] ";
											?>
											<option value="view_quotedetail.php?id=<?php echo $row3['qt_refid']; ?>">
											<?php echo $term ?>
												
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</br>
							<!-- SERACH BAR  -->


							<div id="results"></div>
							<div class="loader"></div>

						</tbody>
					</table>
				</form>

			</div>
		</div>
	</div>
</div>

<!-- Main content end -->		
</div>
</div></div> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> 
<script>
    $(document).ready(function(){
        //Chosen
        $(".choiceChosen, .productChosen").chosen({});
      //Logic
      $(".choiceChosen").change(function(){
        if($(".choiceChosen option:selected").val()=="no"){
          $(".productChosen option[value='2']").attr('disabled',true).trigger("chosen:updated");
          $(".productChosen option[value='1']").removeAttr('disabled',true).trigger("chosen:updated");
      } else {
          $(".productChosen option[value='1']").attr('disabled',true).trigger("chosen:updated");
          $(".productChosen option[value='2']").removeAttr('disabled',true).trigger("chosen:updated");
      }
    })
    })
</script>
<script type="text/javascript">
        // fetching records
        function displayRecords(numRecords, pageNum) {
                           // alert("hiiiiiiiii");
                           $.ajax({
                           	type: "GET",
                           	url: "quote_page.php",
                           	data: "show=" + numRecords + "&pagenum=" + pageNum,
                           	cache: false,
                           	beforeSend: function() {
                           		$('.loader').html('<img src="loader.gif" alt="" width="24" height="24" style="padding-left: 400px; margin-top:10px;" >');
                           	},
                           	success: function(html) {
                           		$("#results").html(html);
                           		$('.loader').html('');
                           	}
                           });
                       }

        // used when user change row limit
        function changeDisplayRowCount(numRecords) {
        	displayRecords(numRecords, 1);
        }

        $(document).ready(function() {
        	displayRecords(8, 1);
        });

    </script>
</body>


</html>