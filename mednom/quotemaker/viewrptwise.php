<?php
include 'lib/database.php';
date_default_timezone_set('Asia/Kolkata');
$todaydt = date("Y-m-d");

$eadd = $_REQUEST['eadd'];
if ($eadd == "today") {
    $res_u = selectAll('admin');

    $r = 1;
    foreach ($res_u as $row_u) {
        $where = array('sd_userid' => $row_u['username']);
        $val1 = $todaydt . ' 00:00:00';
        $val2 = $todaydt . ' 23:59:59';
        $row_u1 = select_count_between('quote_savedlogs', 'savedpdf', $where, 'sd_date', $val1, $val2);

        $where1 = array('el_userid' => $row_u['username']);
        $row_u2 = select_count_between('quote_emaillogs', 'emailsent', $where1, 'el_date', $val1, $val2);
        ?>
        <tr>
            <td><?php echo $row_u['username']; ?></td>
            <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
            <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
        </tr>
        <?php
        $r++;
    }
} elseif ($eadd == "yesterday") {
    $yestdt = date("Y-m-d", time() - 60 * 60 * 24);
    $res_u = selectAll('admin');

    $r = 1;
    foreach ($res_u as $row_u) {

        $where = array('sd_userid' => $row_u['username']);
        $val1 = $yestdt . ' 00:00:00 ';
        $val2 = $yestdt . '23:59:59 ';
        $row_u1 = select_count_between('quote_savedlogs', 'savedpdf', $where, 'sd_date', $val1, $val2);

        $where1 = array('el_userid' => $row_u['username']);
        $row_u2 = select_count_between('quote_emaillogs', 'emailsent', $where1, 'el_date', $val1, $val2);
        ?>
        <tr>
            <td><?php echo $row_u['username']; ?></td>
            <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
            <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
        </tr>
        <?php
        $r++;
    }
} elseif ($eadd == "week") {
    $weekdt = date("Y-m-d", time() - 60 * 60 * 24 * 7);
    $res_u = selectAll('admin');
    $r = 1;
    foreach ($res_u as $row_u) {
        $val1 = $weekdt;
        $val2 = $todaydt;

        $where = array('sd_userid' => $row_u['username']);
        $row_u1 = select_count_between('quote_savedlogs', 'savedpdf', $where, 'sd_date', $val1, $val2);

        $where1 = array('el_userid' => $row_u['username']);
        $row_u2 = select_count_between('quote_emaillogs', 'emailsent', $where1, 'el_date', $val1, $val2);
        ?>
        <tr>
            <td><?php echo $row_u['username']; ?></td>
            <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
            <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
        </tr>
        <?php
        $r++;
    }
} elseif ($eadd == "month") {
    $mondt = date("Y-m-d", strtotime('-1 months'));
    $res_u = selectAll('admin');
    $r = 1;
    foreach ($res_u as $row_u) {

        $where = array('sd_userid' => $row_u['username']);
        $row_u1 = select_count_between('quote_savedlogs', 'savedpdf', $where, 'sd_date', $mondt, $todaydt);

        $where1 = array('el_userid' => $row_u['username']);
        $row_u2 = select_count_between('quote_emaillogs', 'emailsent', $where1, 'el_date', $mondt, $todaydt);
        ?>
        <tr>
            <td><?php echo $row_u['username']; ?></td>
            <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
            <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
        </tr>
        <?php
        $r++;
    }
} else {
    $res_u = selectAll('admin');
    $r = 1;
    foreach ($res_u as $row_u) {
        $where = array('sd_userid' => $row_u['username']);
        $row_u1 = select_count('quote_savedlogs', 'savedpdf', $where);

        $where1 = array('el_userid' => $row_u['username']);
        $row_u2 = select_count('quote_emaillogs', 'emailsent', $where1);
        ?>
        <tr>
            <td><?php echo $row_u['username']; ?></td>
            <td><?php if ($row_u1['savedpdf'] != 0) { ?><a href="viewsavedetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u1['savedpdf']; ?></a> <?php } else { ?><?php echo $row_u1['savedpdf']; ?> <?php } ?></td>
            <td><?php if ($row_u2['emailsent'] != 0) { ?><a href="viewemaildetails.php?usr=<?php echo $row_u['username'] ?>" target="new"><?php echo $row_u2['emailsent']; ?></a> <?php } else { ?><?php echo $row_u2['emailsent']; ?> <?php } ?></td>
        </tr>
        <?php
        $r++;
    }
}
?>
 
