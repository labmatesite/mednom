<?php
session_start();
include 'lib/database.php';
if (!isset($_SESSION['login_user'])) {
    header('Location:index.php');
} else {
    require_once 'lib/header.php';
}
?>
<script>
    function Rptwise(eadd) {
        $.ajax({
            type: "GET",
            url: "viewrptwise.php",
            data: "eadd=" + eadd,
            cache: false,
            success: function (html) {
                $("#tbodyid").html(html);
            }
        });

    }

</script>
<div class="container-fluid" id="content">

    <div id="main">
        <?php
        date_default_timezone_set("Asia/Calcutta");
        $dt = date('F d, Y');
        $week = date('l');
        ?>
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Dashboard</h1>
                </div>
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

            <div class="row-fluid">
                <?php
                if ($_SESSION['user_type'] == "Superadmin") {
                    ?>  
                    <div class="span6">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-table"></i>
                                    User Activity logs
                                </h3>
                            </div>
                            <div class="box-content nopadding">

                                <form id="mainform" action="#" method="post">
                                    <table class="table table-hover table-nomargin dataTable table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Users</th>
                                                <th>Saved Pdf</th>
                                                <th>Email</th>
                                            </tr>
                                            <tr><td colspan="3" style="text-align:center"><select id="rpt_wise" name="rpt_wise" style="width:20%;" class='select2-me input-xlarge' onChange="Rptwise(this.value);">
                                                        <option value="">Select Range</option>
                                                        <option value="today">Today</option>
                                                        <option value="yesterday">Yesterday</option>
                                                        <option value="week">Week</option>
                                                        <option value="month">Month</option>
                                                    </select></td></tr>
                                        </thead>
                                        <tbody id="tbodyid">
                                            <?php
                                            date_default_timezone_set("Asia/Calcutta");
                                            $dt = date('Y-m-d');
                                            $username = $_SESSION['login_user'];
                                            $res_u = selectAll('admin');
                                            $r = 1;
                                            foreach ($res_u as $key => $row_u) {

                                                $where = array('sd_userid' => $row_u['username']);
                                                $row_u1 = select_count('quote_savedlogs', 'savedpdf', $where);

//                                                $sql_u1 = "select count(*) as savedpdf from quote_savedlogs where sd_userid='" . $row_u['username'] . "'";
//                                                $row_u1 = selectQueryWithAnd($sql_u1);
                                                $where1 = array('el_userid' => $row_u['username']);
                                                $row_u2 = select_count('quote_emaillogs', 'emailsent', $where1);
//                                                $sql_u2 = "select count(*) as emailsent from quote_emaillogs where el_userid='" . $row_u['username'] . "'";
//                                                $row_u2 = selectQueryWithAnd($sql_u2);
                                                ?>
                                                <tr>
                                                    <td><?php echo $row_u['username']; ?></td>
                                                    <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
                                                    <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
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
                    <?php
                }
                ?>
                <?php
                if ($_SESSION['user_type'] != "logistics") {
                    ?>  
                    <div class="span6">
                        <div class="box box-color box-bordered green">
                            <div class="box-title">
                                <h3><i class="icon-bullhorn"></i>Users Feeds</h3>

                            </div>
                            <div class="box-content nopadding" style="height:400px;overflow-y:scroll;" >
                                <table  class="table table-hover table-nomargin dataTable table-bordered dataTable-scroller" id="randomFeed">

                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>
<script>
    function getFeed() {
        $.ajax({
            type: "GET",
            url: "feeddata.php",
            cache: false,
            success: function (html) {
                $("#randomFeed").html(html);
            }
        });
    }

    window.onload = getFeed();
</script>
</body>
</html>


