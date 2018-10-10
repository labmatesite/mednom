<?php
session_start();
include 'lib/database.php';
include 'lib/function.php';
checkUser();
if ($_SESSION['user_type'] == "Admin") {
    header('location:index.php');
    exit;
}
include 'lib/header.php';
?>
<script>
    function Organisation(orgid) {
        $.ajax({
            type: "GET",
            url: "shared_ajax.php",
            data: "orgid=" + orgid,
            cache: false,
            success: function (html) {
                $("#contactsid").html(html);
            }
        });
    }
    
    function Contacts(contid) {
          $.ajax({
            type: "GET",
            url: "shared_ajax.php",
            data: "contid=" + contid,
            cache: false,
            success: function (html) {
                $("#organisationid").html(html);
            }
        });
    }

    $(document).ready(function (e) {

        $("#selectall").click(function () {
            $(".case").attr("checked", this.checked);
        });

        $(".case").click(function () {
            if ($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
            }
            else {
                $("#selectall").removeAttr("checked");
            }
        });

    });

</script>
<div id="contactid">
</div>
<div class="container-fluid" id="content">
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Share Organisation</h1>
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
                        <a href="#">Share Organisation</a>
                        <i class="icon-angle-right"></i>
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
                                Share Organisation
                            </h3>
                        </div>
                        <div class="box-content nopadding">
                            <form  method="POST" action="sharedaction.php" enctype="multipart/form-data" class='form-horizontal form-bordered form-validate' id="bb">       
                                <div id="organisationid" class="control-group" style="float:left;width:37.33%">
                                    <label for="textfield" class="control-label">Organisation</label>
                                    <div class="controls"  style="margin-left: 150px;">
                                        <select id="qt_organisationid" data-rule-required="true" name="qt_organisationid" class="select2-me input-xlarge" data-placeholder="Organisation Name" onChange="Organisation(this.value);">>
                                            <option value="">-- Select Organisation --</option>
                                            <option value="0">-- Individual --</option>
                                            <?php
                                            $username = $_SESSION['login_user'];
                                            $where = array('username' => $username);
                                            $row_ad = selectAnd('admin', $where);

                                            if ($row_ad['userType'] == "users") {
                                                $where1 = array('org_assignedto' => $username);
                                                $res_sec3 = selectAndOrderby('quote_organisation', $where1, 'org_name');
                                            } else {
                                                $res_sec3 = select_table_orderby('quote_organisation', 'org_name');
                                            }
                                            foreach ($res_sec3 as $row_sec3) {
                                                ?>
                                                <?php
                                                echo "<option value='" . $row_sec3['org_id'] . "'>" . ucwords($row_sec3['org_name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                                <div id="contactsid" class="control-group" style="float:left;width:37.33%">
                                    <label for="textfield" class="control-label">Contacts</label>
                                    <div class="controls"  style="margin-left: 150px;">
                                        <select id="qt_contacts" data-rule-required="true" name="qt_contacts" class='select2-me input-xlarge' data-placeholder="Contacts Name" onChange="Contacts(this.value);">
                                            <option value="">-- Select Contacts --</option>
                                            <?php
                                            if ($row_ad['userType'] == "users") {

                                                $where1 = array('cont_assignedto' => $username);
                                                $res_sec3 = selectAndOrderby('quote_contacts', $where1, 'cont_firstname,cont_lastname');
                                            } else {
                                                $res_sec3 = select_table_orderby('quote_contacts', 'cont_firstname,cont_lastname');
                                            }

                                            foreach ($res_sec3 as $row_sec3) {
                                                ?>
                                                <?php
                                                echo "<option value='" . $row_sec3['cont_id'] . "'>" . ucwords($row_sec3['cont_firstname'] . " " . $row_sec3['cont_lastname']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="assigned" class="control-group" style="float:left;width:25.33%">
                                    <label for="textfield" class="control-label">Assigned</label>
                                    <div class="controls" style="margin-left: 150px;">
                                        <select id="sh_assigned" data-rule-required="true" name="sh_assigned" class='select2-me input-medium' data-placeholder="Assigned Name">
                                            <option value="">Select Assigned</option>
                                            <?php
                                            $res_ad2 = admin_not_equal($username);

                                            foreach ($res_ad2 as $row_ad2) {
                                                ?>
                                                <option value="<?php echo $row_ad2['username']; ?>" ><?php echo ucwords($row_ad2['username']); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-actions" style="float:left;width:15%;">
                                    <button id="save" name="save" type="submit"  class="btn btn-primary">Save</button>
                                    <button id="reset" type="button" class="btn" onClick="window.history.back()" >Cancel</button>

                                </div>
                            </form> 

                            <br>

                            <form id="mainform" action="#" method="post">
                                <table class="table table-hover table-nomargin dataTable table-bordered">
                                    <thead >
                                        <tr>
                                            <th>Sr no.</th>
                                            <th>Organisation</th>
                                            <th>Contacts</th>
                                            <th>Assigned to</th>
                                            <th></th>											
<!-- <th><a href="#"><input type="checkbox" id="selectall" /></a>
<input type="submit" name="main" value="Delete" style="margin-left:10px; width:80px;height:30px;font-size:16px" /></th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        date_default_timezone_set("Asia/Calcutta");
//                                        $dt = date('Y-m-d');
//                                        
//                                        $sql3 = "select * from quote_share where shd_shdby='$username' order by shd_id";
//                                        $res3 = mysql_query($sql3);
//                                        $j = 1;

//                                        while ($row3 = mysql_fetch_array($res3)) {
                                            ?>
                                            <tr>
                                                <td><?php// echo $j; ?></td>
                                                <td>

                                                    <?php
//                                                    $sql_og = "select * from quote_organisation where org_id='" . $row3['shd_orgid'] . "'";
//                                                    $res_og = mysql_query($sql_og);
//                                                    $row_og = mysql_fetch_array($res_og);
//                                                    echo $row_og['org_name'];
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
//                                                    $sql_ct = "select * from quote_contacts where cont_id='" . $row3['shd_contid'] . "'";
//                                                    $res_ct = mysql_query($sql_ct);
//                                                    $row_ct = mysql_fetch_array($res_ct);
//                                                    echo $row_ct['cont_sal'] . $row_ct['cont_firstname'] . $row_ct['cont_lastname'];
                                                    ?>
                                                </td>
                                                <td><?php // echo $row3['shd_assignto'] ?></td>
                                                <td><div align="center"><a href="edit_shipper.php?sh_id=<?php  // echo $row3['shd_id'] ?>"><img src="images/edit.png" width="16" height="16" border="0" /></a></div></td>
                                                <?php /* ?><td><div align="center"><input type="checkbox" class="case" name="products[]" value="<?php echo $row3['id']?>" /></div></td><?php */ ?>
                                            </tr>
                                            <?php
                                           // $j++;
                                       // }
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


