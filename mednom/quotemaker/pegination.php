<?php
include 'lib/database.php';
session_start();
// Very important to set the page number first.

if (!(isset($_GET['pagenum']))) {
    $pagenum = 1;
} else {
    $pagenum = intval($_GET['pagenum']);
}
//$db = pdo_db();
$username = $_SESSION['login_user'];
//Number of results displayed per page 	by default its 10.
$page_limit = ($_GET["show"] <> "" && is_numeric($_GET["show"]) ) ? intval($_GET["show"]) : 20;
if ($_SESSION['user_type'] == "users") {
    $abc = select_quote_organisation_without_limit($username);
    $cnt = count($abc);
} else {
    $cnt = count(selectAll('quote_organisation'));
}
$last = ceil($cnt / $page_limit);

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) {
    $pagenum = 1;
} elseif ($pagenum > $last) {
    $pagenum = $last;
}
$lower_limit = ($pagenum - 1) * $page_limit;
	if($lower_limit>-1)
	{
if ($_SESSION['user_type'] == "users"/* || $_SESSION['user_type'] == "admin"*/) {
    $res = select_quote_organisation_with_limit($username, $lower_limit, $page_limit);
} else {
    $res = select_quote_organisation_pegination($lower_limit, $page_limit);
}
	}
else
	{
	echo "no records found";
	exit(0);	
	}
?>
<div class="section group">
    <?php
    $i = 0;
    ?>
    <form id="mainform" action="" method="post">
        <table class="table table-hover table-nomargin dataTable table-bordered">
            <thead>
                <tr>
                    <th>Sr no.</th>
                    <th>Organization Name</th>
                    <th>Billing City</th>
                    <th>Website</th>
                    <th>Primary Phone</th>
                    <th>Assigned To</th>
                    <th></th>											
                </tr>
            </thead>
            <?php
            $r = 1;
            foreach ($res as $key => $row3) {
                ?>
                <tr>
                    <td><?php echo $r; ?></td>
                    <td><a href="organisationdetails.php?org_id=<?php echo $row3['org_id'] ?>"><?php echo $row3['org_name'] ?></a></td>
                    <td><?php echo $row3['org_billingcity'] ?></td>
                    <td><?php echo $row3['org_website'] ?></td>
                    <td><?php echo $row3['org_primaryphone'] ?></td>
                    <td><?php echo $row3['org_assignedto'] ?></td>
                    <td><div align="center"><a href="edit_organisation.php?org_id=<?php echo $row3['org_id'] ?>"><img src="assets/images/admin/edit.png" width="16" height="16" border="0" /></a></div></td>

                    <?php
                    $r++;
                }
                ?>
                </tbody>
        </table>
    </form>
</div>

<label> Rows Limit: 
    <select name="show" onChange="changeDisplayRowCount(this.value);">
        <option value="10" <?php
        if ($_GET["show"] == 10 || $_GET["show"] == "") {
            echo ' selected="selected"';
        }
        ?> >10</option>
        <option value="20" <?php
        if ($_GET["show"] == 20) {
            echo ' selected="selected"';
        }
        ?> >20</option>
        <option value="30" <?php
        if ($_GET["show"] == 30) {
            echo ' selected="selected"';
        }
        ?> >30</option>
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
