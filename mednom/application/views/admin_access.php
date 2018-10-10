<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
.sp_active{
	padding:0px 8px;
	border:2px solid #1a6f6d;
	background:#1a6f6d;
	color:#fff;
	border-radius:25px;
}
.sp_inactive{
	padding:0px 8px;
	border:2px solid #9c1b20;
	background:#9c1b20;
	color:#fff;
	border-radius:25px;
}
</style>

<section class="breadcrumbs_common bg_img pos_relative">
   <div class="overlay-innerpage"></div>
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <div class="breadcrumbs_content align_row_spacebetween">
                <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?= base_url(); ?>">Home </a>
                    <meta itemprop="position" content="1" ></li>/
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><a itemprop="item" href="javascript:;"><span itemprop="name">Admin Access</a></span>
                    <meta itemprop="position" content="2"></li>
                </ol> 
            </div>
         </div>
      </div>
   </div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2>Distributor's Information</h2>
			</div>
		</div>
	</div>
</section>

<section id="about-sev" class="padding hidden-xs">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="myTable" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th class="text-center" style="color:#9c1b20">Sr No.</th>
							<th class="text-center" style="color:#9c1b20">Name</th>
							<th class="text-center" style="color:#9c1b20">Address</th>
							<th class="text-center" style="color:#9c1b20">Contact No</th>
							<th class="text-center" style="color:#9c1b20">Registered Email</th>
							<th class="text-center" style="color:#9c1b20">Registered Password</th>
							<th class="text-center" style="color:#9c1b20">Status</th>
							<th class="text-center" style="color:#9c1b20">Activate User</th>
							<th class="text-center" style="color:#9c1b20">Blocked User</th>
						</tr>
					</thead>
					<tbody>
					<?php $z = 1;foreach($users as $res){ ?>
					<tr <?php if($res['inactive'] == 1){ ?> 
					class="info" 
					<?php } elseif($res['inactive'] == 2){ ?> 
					class="danger" 
					<?php } else { ?> 
					class="success" <?php } ?>	>
							<td class="text-center" ><?php echo $z ?></td>
							<td class="text-center" ><?php echo $res['username']?></td>
							<td class="text-center" ><?php echo $res['address']?></td>
							<td class="text-center" ><?php echo $res['phone']?></td>
							<td class="text-center" ><?php echo $res['email']?></td>
							<td class="text-center" ><?php echo $res['password']?></td>
							<td class="text-center" >
							<?php 	if($res['inactive'] == 1)
									{
										echo '<span class="btn btn-primary inactive">Inactive</span>';
									}
									elseif($res['inactive'] == 2)
									{
										echo '<span class="btn btn-danger inactive">Blocked</span>';
									}
									else
									{
										echo '<span class="btn btn-success active">Active</span>';
									}
							?>
							</td>
							<td class="text-center" ><a href="<?php echo base_url()?>activate/<?php echo $res['id']?>"><i class="fa fa-check" style="font-size:24px;color:green" ></i></a></td>
							<td class="text-center" ><a href="<?php echo base_url()?>disable/<?php echo $res['id']?>"><i class="fa fa-ban" style="font-size:24px;color:red"></i></a></td>
						</tr>
						
					<?php $z++; } ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>
	</div>
</div>

</section>
<footer id="footer" class="footer-simple footer-dark">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
