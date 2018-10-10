<?php
include 'lib/database.php';
session_start();
if (!(isset($_GET['pagenum']))) {
    $pagenum = 1;
} else {
    $pagenum = intval($_GET['pagenum']);
}
$username = $_SESSION['login_user'];
//Number of results displayed per page 	by default its 10.
$page_limit = ($_GET["show"] <> "" && is_numeric($_GET["show"]) ) ? intval($_GET["show"]) : 20;
if ($_SESSION['user_type'] == "users") {
   $abc = select_quote_contacts_without_limit($username);
   $cnt = count($abc);
} else {
   $cnt = count(selectAll('quote_contacts'));
}

$last = ceil($cnt / $page_limit);

//this makes sure the page number isn't below one, or more than our maximum pages 
if ($pagenum < 1) {
    $pagenum = 1;
} elseif ($pagenum > $last) {
    $pagenum = $last;
}
$lower_limit = ($pagenum - 1) * $page_limit;
if ($lower_limit < 0) {
   // $record = ;
    ?>
    <form id="mainform" action="deleteorganisation.php" method="post">
        <table class="table table-hover table-nomargin dataTable table-bordered">
            <thead>
                <tr>
                    <th>Sr no.</th>
                    <th>Contact Name</th>
                    <th>Organisation Name</th>
                    <th>Primary Email</th>
                    <th>Phone No</th>
                    <th>Assigned To</th>
                    <th></th>											
                </tr>
                <tr><?php echo 'No data available in tables'; ?></tr>
            </thead>
        </table>
    </form>
            <?php
        } else {
            if ($_SESSION['user_type'] == "users") {
                echo $lower_limit;
                $res = select_quote_contacts_with_limit($username, $lower_limit, $page_limit);
                
            } else {
                $res = select_with_limit($lower_limit, $page_limit);
                
            }
            ?>
            <div class="section group">
                <?php
                $i = 0;
                ?>
                <form id="mainform" action="deleteorganisation.php" method="post">
                    <table class="table table-hover table-nomargin dataTable table-bordered">
                        <thead>
                            <tr>
                                <th>Sr no.</th>
                                <th>Contact Name</th>
                                <th>Organisation Name</th>
                                <th>Primary Email</th>
                                <th>Phone No</th>
                                <th>Assigned To</th>
                                <th></th>											
                            </tr>
                        </thead>
                        <?php
                        $r = 1;

                        foreach ($res as $key => $row3) {

                            $where = array('org_id' => $row3['cont_orgid']);
                            $row_org = selectAnd('quote_organisation', $where);
                            ?>
                            <tr>
                                <td><?php echo $r; ?></td>
                                <td><a href="contactdetails.php?cont_id=<?php echo $row3['cont_id'] ?>"><?php echo $row3['cont_firstname'] ?> <?php echo $row3['cont_lastname'] ?> </a></td>
                                <td><?php echo $row_org['org_name'] ?></td>
                                <td><?php echo $row3['cont_primaryemail'] ?></td>
                                <td><?php echo $row3['cont_mobilephone'] ?></td>
                                <td><?php echo $row3['cont_assignedto'] ?></td>
                                <td><div align="center"><a href="edit_contacts.php?cont_id=<?php echo $row3['cont_id'] ?>"><img src="assets/images/admin/edit.png" width="16" height="16" border="0" /></a></div></td>
                            </tr>
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
        <?php
        }?>