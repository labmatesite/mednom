<?php
session_start();
include 'lib/function.php';
checkUser();
include_once 'lib/dbfunctionjugal.php';
include  'lib/header.php' ;
?>
	<div class="container-fluid" id="content">
			
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					
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
				
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div>
                <?php 
				//$sql_a2="select * from admin order by id";
				//$res_a2=mysql_query($sql_a2);
				
	?>
     <!-- Main content start -->

				<div class="row-fluid">
					<div class="span12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									Admin Rights
								</h3>
							</div>
                             
							<div class="box-content nopadding">
                            <br>
                         
                            <form id="mainform" action="" method="post">
								<table class="table table-bordered dataTable dataTable-scroll-x">
									<thead>
										<tr>
                                       		<th>Sr no.</th>
                                       		<th>Ref Id</th>
											<th>Generated By</th>
                                            <th>Generated On </th>
                                           	<th>Details</th>
                                            
										</tr>
									</thead>
									<tbody>
                                      <?php

if(isset($_REQUEST['refid'])&&($_REQUEST['refid']!=''))
{
$myid=$_REQUEST['refid'];
}
else
{
$myid='';

}


$res_a2 =list_edited_quote($myid);


									  $r=1;


//$res_a2 = list_admin_users();
	  foreach($res_a2 as $row_a2)
	  {
		  
	  ?>
										<tr>
                                            <td><?php echo $r; ?></td>
                                            <td><?php echo $row_a2['refid'] ?></td>
                                            <td><?php echo $row_a2['generatedby'] ?></td>
                                            <td><?php echo $row_a2['generatedon'] ?></td>
                                            <td><a href="invoice_detail.php?refid=<?php echo $row_a2['id']; ?>">Details</a></td>
                                           
										</tr>
                                         <?php
		$r++;
	  }
	  ?>
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
		
	</body>

	
</html>
