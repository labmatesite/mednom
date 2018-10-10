<?php
session_start();
include 'lib/function.php';
include 'lib/database.php';
checkUser();
if($_SESSION['user_type'] =="Admin")
{
	header('location:home.php');
	exit;
}
$usr=$_REQUEST['usr'];
$result = select_quote_emaillogs_orderby($usr);

include 'lib/header.php';

?>
<script>
	$(document).ready(function(e) {
        
		$("#selectall").click(function(){
			$(".case").attr("checked",this.checked);
		});
		
		$(".case").click(function(){
			if($(".case").length==$(".case:checked").length){
				$("#selectall").attr("checked","checked");
			}
			else{
				$("#selectall").removeAttr("checked");
			}
		});
		
    });
	</script>
<div class="container-fluid" id="content">

    <div id="main">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-color box-bordered">
                        <div class="box-title">
                            <h3>
                                <i class="icon-table"></i>
                                View Saved Details <?php echo $usr ?>
                            </h3>
                        </div>
                        <div class="box-content nopadding">
                            <form id="mainform" action="#" method="post">
                                <table class="table table-hover table-bordered">
                                    <thead >
                                        <tr>
                                            <th>Sr no.</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>cc</th>
                                            <th>Bcc</th>
                                            <th>Subject</th>
                                            <th>Content</th>
                                            <th>Attach</th>
                                            <th>Date</th>
                                            <th>Ip Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        date_default_timezone_set("Asia/Calcutta");
                                        $dt = date('Y-m-d');
                                        $r = 1;
                                        foreach ($result as $row_u1){
                                        //while ($row_u1 = mysql_fetch_array($res_u1)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $r; ?></td>
                                                <td><?php echo $row_u1['el_from'] ?></td>
                                                <td><?php echo $row_u1['el_to'] ?></td>
                                                <td><?php echo $row_u1['el_acc'] ?></td>
                                                <td><?php echo $row_u1['el_bcc'] ?></td>
                                                <td><?php echo $row_u1['el_subject'] ?></td>
                                                <td><?php echo $row_u1['el_content'] ?></td>
                                                <td><?php echo $row_u1['el_attachments'] ?></td>
                                                <td><?php echo $row_u1['el_date'] ?></td>
                                                <td><?php echo $row_u1['el_ipaddress'] ?></td>

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
