<?php
include 'lib/database.php';
include 'lib/function.php';
?>

<?php
if (isset($_REQUEST['txid'])) {
    $txid = $_REQUEST['txid'];
    $where = array('tax_id' => $txid);
    $row_tx2 = selectAnd('tax_cal', $where);
    if ($row_tx2['tax_status'] == "active") {
        $status = "deactive";
    } elseif ($row_tx2['tax_status'] == "deactive") {
        $status = "active";
    }
    $param = array($status, $txid);
    $row_tx = update_tax_cal($param);
    $res_tx = select_table_orderby('tax_cal', 'tax_id');
    ?>
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
<?php }
?>
<?php
if (isset($_REQUEST['id'])) {
    $tax_id = $_REQUEST['id'];
    $where = array('tax_id' => $tax_id);
    $row = selectAnd('tax_cal', $where);
        ?>
       
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Edit Tax Calculations</h3>
        </div>
        <div class="modal-body">
            <form  method="POST" action="edittaxcalaction.php?tax_id=<?php echo $tax_id; ?>" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">
                <div class="control-group">
                    <label for="textfield" class="control-label">Tax Name</label>
                    <div class="controls">
                        <input type="text" name="tax_name" id="tax_name"  placeholder="Tax Name" class="input-xlarge" value="<?php echo $row['tax_name']; ?>" data-rule-required="true" data-rule-digits="true"> </div>
                </div>

                <div class="control-group">
                    <label for="textfield" class="control-label">Tax Value</label>
                    <div class="controls">
                        <input type="text" name="tax_value" id="tax_value"  class="input-xlarge" placeholder="Tax Value"   value="<?php echo $row['tax_value']; ?>"  data-rule-required="true">
                    </div>
                </div>



                <div class="form-actions" style="background:none !important;">
                    <button id="submit" type="submit"  class="btn btn-primary" >Save</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>

            </form>
        </div>

        <?php

    }

 if (isset($_REQUEST['tnc_orgid'])) {

$tnc_orgid=$_REQUEST['tnc_orgid'];
$where = array('tnc_orgid' => $tnc_orgid);
$row_tx2 = selectAnd('termsncond',$where);

echo $row_tx2['tnc_content'];


 }
?>
 