<?php



include 'lib/database.php';

include 'lib/function.php';



$res_fd = select_table_orderbydesc('quote_contactactivity','ca_id');

date_default_timezone_set('Asia/Kolkata');



function time_ago($date, $granularity = 2) {

    $retval = "";

    $date = strtotime($date);

    $difference = time() - $date;

    $periods = array('decade' => 315360000,

        'year' => 31536000,

        'month' => 2628000,

        'week' => 604800,

        'day' => 86400,

        'hour' => 3600,

        'minute' => 60,

        'second' => 1);

    if ($difference < 5) { // less than 5 seconds ago, let's say "just now"

        $retval = "posted just now";

        return $retval;

    } else {

        foreach ($periods as $key => $value) {

            if ($difference >= $value) {

                $time = floor($difference / $value);

                $difference %= $value;

                $retval .= ($retval ? ' ' : '') . $time . ' ';

                $retval .= (($time > 1) ? $key . 's' : $key);

                $granularity--;

            }

            if ($granularity == '0') {

                break;

            }

        }

        return ' posted ' . $retval . ' ago';

    }

}

foreach($res_fd as $key => $row_fd){

    echo "<tr><td><span class='label label-success'><i class='icon-user'></i></span>" . ucwords($row_fd['ca_userid']) . " " . ucwords($row_fd['ca_activity']) . "<br>" . $row_fd['ca_activity_details'] . "<br> in " . $row_fd['ca_dbtype'] . "<br><span style='color:#339933;float:right'>" . time_ago($row_fd['ca_date']) . "</span></td></tr>";

}

?>

