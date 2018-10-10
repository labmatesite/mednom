<?php
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
if (isset($_POST['trmandcond'])) {
    date_default_timezone_set('Asia/Kolkata');
    $todaydt = date("Y-m-d H:i:s");
    $tnc_orgid = $_POST['tnc_orgid'];
    $tnc_content = $_POST['tnc_content'];
    $param = array(
        'tnc_orgid' => $tnc_orgid,
        'tnc_content' => $tnc_content,
        'todaydt' => $todaydt,
    );
    $result = trmandcond($param);
    if ($result) {
        header('location:crm_settings.php#second22');
    }
}
if (isset($_POST['tax_calculation'])) {
    $todaydt = date("Y-m-d H:i:s");
    $tax_name = $_POST['tax_name'];
    $tax_value = $_POST['tax_value'];
    $tax_status = "active";
    $tax_update = "admin";
    $param = array(
        'todaydt' => $todaydt,
        'tax_name' => $tax_name,
        'tax_value' => $tax_value,
        'tax_status' => $tax_status,
        'tax_update' => $tax_update
    );
    tax_calculation($param);
}
if (isset($_POST['crn'])) {
    date_default_timezone_set('Asia/Kolkata');
    $todaydt = date("Y-m-d H:i:s");

    $crn_prefix = $_POST['crn_prefix'];
    $crn_prefix_dt = $_POST['prefix_dt'];
    $crn_join = $crn_prefix . $crn_prefix_dt;
    $crn_stseq = $_POST['crn_stseq'];
    $crn_updatedby = $_SESSION['user1'];
    $crn_updatedt = $todaydt;
    
    $col= array('crn_prefix','crn_stseq','crn_updatedby','crn_updatedt','crn_id');
    $value = array($crn_join,$crn_stseq,$crn_updatedby,$crn_updatedt,'1');
    $res1 = update_table('crn', $col, $value);
    if($res1){
        header('location:crm_settings.php');
    }
   // $sql_crn="update crn set crn_prefix='$crn_join',crn_stseq='$crn_stseq',crn_updatedby='$crn_updatedby',crn_updatedt='$crn_updatedt' where crn_id='1'";
}
include_once 'lib/header.php';
date_default_timezone_set('Asia/Kolkata');
$todayyear = date("y");
$todaymonth = date("m");
?>

<script>
    function tax(txid) {
        $.ajax({
            type: "GET",
            url: "crm_ajax.php",
            data: "txid=" + txid,
            cache: false,
            success: function (html) {
                $("#tx").html(html);
            }
        });
    }
    function Edittax(id)
    {
        $.ajax({
            type: "GET",
            url: "crm_ajax.php",
            data: "id=" + id,
            cache: false,
            success: function (html) {
                $("#modal-1").html(html);
            }
        });
    }

function tnc(tnc_orgid){
        
      $.ajax({
            type: "GET",
            url: "crm_ajax.php",
            data: "tnc_orgid=" + tnc_orgid,
            cache: false,
            success: function (html) {
                
                 tinyMCE.activeEditor.setContent(html);
                
            }
        });

    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Edit Tax Calculations</h3>
    </div>
    <div class="modal-body">
        <form  method="POST" action="edittaxcalaction.php" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="editbb">
            <div class="control-group">
                <label for="textfield" class="control-label">Tax Name</label>
                <div class="controls">
                    <input type="text" name="tax_name" id="tax_name"  placeholder="Tax Name" value="" class="input-xlarge" data-rule-required="true"> </div>

            </div>

            <div class="control-group">
                <label for="textfield" class="control-label">Tax Value</label>
                <div class="controls">
                    <input type="text" name="tax_value" id="tax_value"  class="input-xlarge" placeholder="Tax Value"   value=""  data-rule-required="true">
                </div>
            </div>

            <div class="form-actions" style="background:none !important;">
                <button id="submit" type="submit"  button class="btn btn-primary" data-dismiss="modal">Save</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>

        </form>
    </div>
</div>
<div class="container-fluid" id="content">
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>CRM Settings</h1>
                </div>
                <?php
                date_default_timezone_set("Asia/Calcutta");
                $dt = date('F d, Y');
                $week = date('l');
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
                        <a href="#">CRM Settings</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>

            <!-- Main content start -->

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3><i class="icon-th-list"></i>CRM Settings</h3>
                        </div>
                        <div class="box-content nopadding">
                            <ul class="tabs tabs-inline tabs-top">
                                <li class='active'>
                                    <a href="#first11" data-toggle='tab'><i class="icon-inbox"></i> Tax Calculations</a>
                                </li>
                                <li>
                                    <a href="#second22" data-toggle='tab'><i class="icon-share-alt"></i> Terms & Conditions</a>
                                </li>
                                <li>
                                    <a href="#thirds3322" data-toggle='tab'><i class="icon-tag"></i>Customize Record Numbering</a>
                                </li>
                                <li>
                                    <a href="#thirds33" data-toggle='tab'><i class="icon-trash"></i> Currency</a>
                                </li>
                            </ul>
                            <div class="tab-content padding tab-content-inline tab-content-bottom">
                                <div class="tab-pane active" id="first11">
                                    <form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
                                        <div class="control-group">
                                            <label for="textfield" class="control-label">Tax Name</label>
                                            <div class="controls">
                                                <input type="text" name="tax_name" id="tax_name"  placeholder="Tax Name" value="" class="input-xlarge"  data-rule-required="true"> </div>

                                        </div>

                                        <div class="control-group">
                                            <label for="textfield" class="control-label">Tax Value</label>
                                            <div class="controls">
                                                <input type="text" name="tax_value" id="tax_value"  class="input-xlarge" placeholder="Tax Value"   value=""  data-rule-number="true" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="form-actions" style="background:none !important;">
                                            <button id="submit" name="tax_calculation" type="submit"  class="btn btn-primary" >Save</button>
                                            <button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>
                                        </div>

                                    </form>
                                    <?php
                                    $res_tx = select_table_orderby('tax_cal', 'tax_id');
                                    ?>
                                    <form id="mainform" action="deletetaxcal.php" method="post">
                                        <table id="tx" class="table table-hover table-nomargin dataTable table-bordered">
                                            <thead><tr><td>Tax Name</td><td>Tax Value</td><td>Tax Status</td><td>Edit</td></tr></thead>

                                            <?php
                                            foreach ($res_tx as $row_tx) {
                                                ?>
                                                <tr><td><?php echo $row_tx['tax_name']; ?></td><td><?php echo $row_tx['tax_value'] . "%"; ?></td><td><input type="checkbox" name="st<?php echo $row_tx['tax_id']; ?>" id="st<?php echo $row_tx['tax_id']; ?>" <?php if ($row_tx['tax_status'] == "active") { ?>; checked <?php } ?> onClick="tax('<?php echo $row_tx['tax_id']; ?>')" ></td><td><a href="#modal-1" role="button" class="btn" data-toggle="modal" onClick="Edittax('<?php echo $row_tx['tax_id']; ?>')"><img src="assets/images/admin/edit.png"></a></td></tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </form>                      
                                </div>
                                <div class="tab-pane" id="second22">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="mainform1">
                                        <div class="control-group">
                                            <label for="textfield" class="control-label">Terms &amp; Conditions</label>
                                            <div class="controls">
                                                <select id="tnc_orgid" name="tnc_orgid" data-rule-required="true" onChange="tnc(this.value);">
                                                    <option value="Terms">Terms</option>
                                                    <!--<option value="indianscientific">Indian Scientific</option>
                                                    <option value="labocon">Labocon</option>
                                                    <option value="labnic">Labnics</option>-->
                                                </select></div>
                                        </div>


                                        <div class="control-group">
                                            <label for="textarea" class="control-label">Terms &amp; Conditions Description</label>
                                            <div class="controls">
                                                <textarea name="tnc_content" id="elm1" rows="5" class="input-block-level">
<?php 
$terms = select_trmandcond(); 
echo $terms['tnc_content'];

 ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-actions" style="background:none !important;">
                                            <button id="submit" name="trmandcond" type="trmandcond"  class="btn btn-primary" >Save</button>
                                            <button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>
                                        </div>
                                    </form>   
                                </div>

                                <div class="tab-pane" id="thirds3322">
                                    <?php
                                    $limit = ' 0,1';
                                    $orderby = 'crn_id';
                                    $results = select_orderby_limit('crn', $orderby, $limit);
                                    foreach ($results as $row_crn1) {
                                     $prefix = substr($row_crn1['crn_prefix'], 0, -4);
                                        ?>

                                        <form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="editbb">
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Prefix</label>
                                                <div class="controls">
                                                    <input type="text" name="crn_prefix" id="crn_prefix"  placeholder="" class="input-xsmall" value="<?php echo $prefix; ?>" data-rule-required="true" style="width:150px">  <input type="text" name="prefix_dt" id="prefix_dt"  placeholder="" value="<?php echo $todaymonth . $todayyear; ?>" class="input-xsmall"  style="width:150px"></div>

                                            </div>

                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Start Sequence<span style="color:#F00;">*</span></label>
                                                <div class="controls">
                                                    <input type="text" name="crn_stseq" id="crn_stseq"  class="input-xlarge" placeholder=""  value="<?php echo $row_crn1['crn_stseq']; ?>"  data-rule-required="true"  style="width:150px">
                                                </div>
                                            </div>
                                            <div class="form-actions" style="background:none !important;">
                                                <button id="submit" name="crn" type="submit"  button class="btn btn-primary" data-dismiss="modal">Save</button>
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                            </div>

                                        </form>
                                    <?php }
                                    ?>
                                </div>
                                <div class="tab-pane" id="thirds33">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem tempore accusamus officiis et nihil qui ea voluptatem itaque enim obcaecati iure distinctio quam molestiae deleniti iste necessitatibus dolorem quos rerum inventore suscipit! Temporibus suscipit excepturi molestias harum tempora nihil sed placeat atque nobis a minima sit id deserunt expedita ex! Tempore incidunt animi iste vitae dignissimos adipisci nisi impedit doloribus blanditiis unde nobis totam laboriosam maxime in quam repudiandae eos atque illum. Eaque facilis voluptates architecto suscipit sed dolor possimus earum molestiae ratione porro necessitatibus nihil sint recusandae optio eligendi ipsum maiores cum impedit dolores soluta ullam similique quas quod assumenda laudantium unde excepturi sequi hic aperiam tenetur explicabo laboriosam maxime perspiciatis placeat commodi illo dolorem corporis tempora voluptatem culpa nobis veritatis consequatur veniam mollitia ex animi qui omnis dolore et quae. Natus itaque quisquam repellat enim accusamus vel deserunt veniam vitae earum nostrum nulla maxime quas ipsa cum rem ut fugiat repellendus quis voluptates eligendi voluptatibus animi obcaecati esse illo incidunt? Amet repudiandae ducimus vel sit neque magni optio eveniet ut eum adipisci incidunt laudantium consectetur debitis veniam tempore temporibus maiores inventore! Libero hic quisquam nihil pariatur perspiciatis beatae non at commodi sint dolore tempora corporis explicabo quam saepe? 
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content end -->

        </div>
    </div></div>

</body>
</html>