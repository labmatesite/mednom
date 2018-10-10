<?php
include 'lib/database.php';
session_start();

// Very important to set the page number first.
if (!(isset($_GET['pagenum']))) {
    $pagenum = 1;
} else {
    $pagenum = intval($_GET['pagenum']);
}
$username = $_SESSION['login_user'];
$page_limit = ($_GET["show"] <> "" && is_numeric($_GET["show"]) ) ? intval($_GET["show"]) : 20;

$cnt = report_pegi();
$last = ceil($cnt / $page_limit);
?>
<form id="mainform" action="#" method="post">
    <table class="table table-hover table-nomargin dataTable table-bordered">
        <thead >
            <tr>
                <th>Sr no.</th>
                <th>Reference Id</th>											
                <th>Organisation</th>											
                <th>Contacts</th>											
                <th>Country</th>											
                <th>State</th>											
                <th>City</th>											
                <th>Product name</th>
                <th>Sku</th>											
                <th>Product Price</th>											
                <th>Item total</th>											
                <th>Shipping</th>											
                <th>Discount</th>											
                <th>Tax</th>											
                <th>Grand Total</th>											
            </tr>
        </thead>  
        <tbody>
            <?php
            date_default_timezone_set("Asia/Calcutta");
            $dt = date('Y-m-d');
            $username = $_SESSION['login_user'];
            if ($pagenum < 1) {
                $pagenum = 1;
            } elseif ($pagenum > $last) {
                $pagenum = $last;
            }
            $lower_limit = ($pagenum - 1) * $page_limit;

            $res = report_pegi_with_limit($lower_limit, $page_limit);
            $r = 1;
            foreach ($res as $row3) {
                $where = $row3['qt_contacts'];
                $res_ad1 = quote_contact_limit($where);
                ?>
                <tr>
                    <td><?php echo $r; ?></td>
                    <td><a href="tcpdf/examples/preview.php?refid=<?php echo $row3['qt_refid']; ?>"><?php echo $row3['qt_refid']; ?></td>
                    <td><?php echo $row3['org_name']; ?></td>
                    <td><?php echo $res_ad1['cont_sal'] . ' ' . $res_ad1['cont_firstname'] . ' ' . $res_ad1['cont_lastname']; ?></td>
                    <td><?php echo $row3['country']; ?></td>
                    <td><?php echo $row3['state']; ?></td>
                    <td><?php echo $row3['city']; ?></td>
                    <td><?php echo $row3['product_name']; ?></td>
                    <td><?php echo $row3['product_sku']; ?></td>
                    <td><?php echo $row3['product_sellingprice']; ?></td>
                    <td><?php echo $row3['qt_itemtotal']; ?></td>
                    <td><?php echo $row3['qt_shipping_charges']; ?></td>
                    <td><?php echo $row3['qt_discount']; ?></td>
                    <td><?php echo $row3['qt_pretax_total']; ?></td>
                    <td><?php echo $row3['qt_grandtotal']; ?></td>
                </tr>
                <?php
                $r++;
            }
            ?>
        </tbody>
    </table>
</form>
<label> Rows Limit: 
    <select name="show" onChange="changeDisplayRowCount(this.value);">
        <option value="25" <?php
        if ($_GET["show"] == 25 || $_GET["show"] == "") {
            echo ' selected="selected"';
        }
        ?> >25</option>
        <option value="50" <?php
        if ($_GET["show"] == 50) {
            echo ' selected="selected"';
        }
        ?> >50</option>
        <option value="100" <?php
        if ($_GET["show"] == 100) {
            echo ' selected="selected"';
        }
        ?> >100</option>
    </select>
</label>
<div class="pegination-link">
    <?php
    if (($pagenum - 1) > 0) {
        ?>	
        <a href="javascript:void(0);" class="links" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo 1; ?>');">First</a>
        <a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $pagenum - 1; ?>');">Previous</a>
        <?php
    }
//Show page links
    for ($i = 1; $i <= $last; $i++) {
        if ($i == $pagenum) {
            ?>
            <a href="javascript:void(0);" class="selected" ><?php echo $i ?></a>
            <?php
        } else {
            ?>
            <a href="javascript:void(0);" class="links"  onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $i; ?>');" ><?php echo $i ?></a>
            <?php
        }
    }
    if (($pagenum + 1) <= $last) {
        ?>
        <a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $pagenum + 1; ?>');" class="links">Next</a>
    <?php } if (($pagenum) != $last) { ?>	
        <a href="javascript:void(0);" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $last; ?>');" class="links" >Last</a> 
        <?php
    }
    ?>
    Page <?php echo $pagenum; ?> of <?php echo $last; ?>
</div>
