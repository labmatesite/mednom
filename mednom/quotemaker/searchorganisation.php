<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'lib/database.php';
include 'lib/function.php';
if (isset($_REQUEST['value']) && !empty($_REQUEST['value'])) {
    $value = $_REQUEST['value'];
    $where = array('org_name' => $value);
    $total = selectAnd('quote_organisation', $where);
    if ($total == 0) {
        ?>			
        <span style="color:#063">Available</span>			
        <?php

    } else {
        ?>
        <span> Not Avaliable</span>
        <?php

    }
}
if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
    // select * from quote_organisation where org_name =$value
    $where = array('org_primaryemail' => $email, 'org_secondaryemail' => $email, 'org_tertiaryemail' => $email);
    $total = selectOr('quote_organisation', $where);
    if ($total == 0) {
        ?>          
        <span style="color:#063">Available</span>           
        <?php

    } else {
        ?>
        <span> Not Avaliable</span>
        <?php

    }
}
?>
