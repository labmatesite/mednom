<?php

function doLogin() {
// if we found an error save the error message in this variable
    $errorMessage = '';

    $userName = $_POST['uemail'];
    $password = $_POST['upw'];

    if ($userName == '') {
        $errorMessage = 'You must enter your username';
    } else if ($password == '') {
        $errorMessage = 'You must enter the password';
    } else {
        $arr = array('username' => $userName, 'password' => $password);
        $result = selectAnd('admin', $arr);
        if ($result) {
            session_start();
            $username = $result['username'];
            $userType = $result['userType'];
            $_SESSION['login_user'] = $username;
            $_SESSION['user_type'] = $userType;
            header('Location: home.php');
        } else {
            echo 'Your username or password is wrong';
        }
    }
}

function checkUser() {
    if (!isset($_SESSION['login_user'])) {
        header('Location:index.php');
        exit;
    }
}

// insert into quote_organisation table  on action of add_organisation page
function add_quote() {
    $todaydt = date("Y-m-d H:i:s");
    $org_name = $_POST['org_name'];
    $org_primaryemail = $_POST['org_primaryemail'];
    $org_primaryphone = $_POST['org_primaryphone'];
    $org_secondaryemail = $_POST['org_secondaryemail'];
    $org_tertiaryemail = $_POST['org_tertiaryemail'];
    $org_website = $_POST['org_website'];
    $org_industry = $_POST['org_industry'];
    $org_assignedto = $_SESSION['login_user'];
    $org_fax = $_POST['org_fax'];
    $org_altphone = $_POST['org_altphone'];
    $org_cst = $_POST['org_cst'];
    $org_vat = $_POST['org_vat'];
    $org_billingadd = $_POST['org_billingadd'];
    $org_billingpob = $_POST['org_billingpob'];
    $org_billingcity = $_POST['org_billingcity'];
    $org_billingstate = $_POST['org_billingstate'];
    $org_billingpoc = $_POST['org_billingpoc'];
    $org_billingcountry = $_POST['org_billingcountry'];
    $org_shippingadd = $_POST['org_shippingadd'];
    $org_shippingpob = $_POST['org_shippingpob'];
    $org_shippingcity = $_POST['org_shippingcity'];
    $org_shippingstate = $_POST['org_shippingstate'];
    $org_shippingpoc = $_POST['org_shippingpoc'];
    $org_shippingcountry = $_POST['org_shippingcountry'];
    $org_desc = $_POST['org_desc'];
    $org_createdby = $_SESSION['login_user'];
    $org_createddt = $todaydt;
    $org_updateddt = "";
    $org_updatedby = "";
    $org_name1 = "<a href='#'>" . $org_name . "</a>";
    $org_name2 = str_replace("'", "&#146;", $org_name1);
    $where = array('org_name' => $org_name);
    $total = selectAnd('quote_organisation', $where);
    $db = pdo_db();
    $flag = FALSE;

    if ($total == 0) {
        $db->beginTransaction();
        try {
            $param = array($org_name, $org_primaryemail, $org_secondaryemail, $org_tertiaryemail, $org_primaryphone, $org_altphone, $org_fax, $org_website, $org_assignedto, $org_industry, $org_cst, $org_vat, $org_billingadd, $org_billingpob, $org_billingcity, $org_billingstate, $org_billingpoc, $org_billingcountry, $org_shippingadd, $org_shippingpob, $org_shippingcity, $org_shippingstate, $org_shippingpoc, $org_shippingcountry, $org_desc, $org_createdby, $org_createddt, $org_updatedby, $org_updateddt);
            insert_into_quote_organisation($db, $param);

            $param1 = array($org_createdby, 'Created', $org_name2, 'Organisation', $org_createddt);
            insert_into_quote_contactactivity($db, $param1);
            $db->commit();
            $flag = TRUE;
        } catch (PDOException $ex) {
            $db->rollBack();
        }

        return $flag;
    }
}

function uploadExcel() {
    $myFile = $_FILES['mzFile']['tmp_name'];
    include('Excel/reader.php');
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    if (isset($myFile) and $myFile != '') {
        $data->read($myFile);
        for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
            if (isset($data->sheets[0]["cells"][$x][1])) {
                $org_name = $data->sheets[0]["cells"][$x][1];
            } else {
                $org_name = '';
            }

            if (isset($data->sheets[0]["cells"][$x][2])) {
                $org_primaryemail = $data->sheets[0]["cells"][$x][2];
            } else {
                $org_primaryemail = '';
            }

            if (isset($data->sheets[0]["cells"][$x][3])) {
                $org_secondaryemail = $data->sheets[0]["cells"][$x][3];
            } else {
                $org_secondaryemail = '';
            }
            if (isset($data->sheets[0]["cells"][$x][4])) {
                $org_tertiaryemail = $data->sheets[0]["cells"][$x][4];
            } else {
                $org_tertiaryemail = '';
            }
            if (isset($data->sheets[0]["cells"][$x][5])) {
                $org_primaryphone = $data->sheets[0]["cells"][$x][5];
            } else {
                $org_primaryphone = '';
            }
            if (isset($data->sheets[0]["cells"][$x][6])) {
                $org_altphone = $data->sheets[0]["cells"][$x][6];
            } else {
                $org_altphone = '';
            }
            if (isset($data->sheets[0]["cells"][$x][7])) {
                $org_fax = $data->sheets[0]["cells"][$x][7];
            } else {
                $org_fax = '';
            }
            if (isset($data->sheets[0]["cells"][$x][8])) {
                $org_website = $data->sheets[0]["cells"][$x][8];
            } else {
                $org_website = '';
            }
            if (isset($data->sheets[0]["cells"][$x][9])) {
                $org_assignedto = $data->sheets[0]["cells"][$x][9];
            } else {
                $org_assignedto = '';
            }

            if (isset($data->sheets[0]["cells"][$x][10])) {
                $org_industry = $data->sheets[0]["cells"][$x][10];
            } else {
                $org_industry = '';
            }
            if (isset($data->sheets[0]["cells"][$x][11])) {
                $org_billingadd = $data->sheets[0]["cells"][$x][11];
            } else {
                $org_billingadd = '';
            }
            if (isset($data->sheets[0]["cells"][$x][12])) {
                $org_billingpob = $data->sheets[0]["cells"][$x][12];
            } else {
                $org_billingpob = '';
            }
            if (isset($data->sheets[0]["cells"][$x][13])) {
                $org_billingcity = $data->sheets[0]["cells"][$x][13];
            } else {
                $org_billingcity = '';
            }
            if (isset($data->sheets[0]["cells"][$x][14])) {
                $org_billingstate = $data->sheets[0]["cells"][$x][14];
            } else {
                $org_billingstate = '';
            }
            if (isset($data->sheets[0]["cells"][$x][15])) {
                $org_billingpoc = $data->sheets[0]["cells"][$x][15];
            } else {
                $org_billingpoc = '';
            }
            if (isset($data->sheets[0]["cells"][$x][16])) {
                $org_billingcountry = $data->sheets[0]["cells"][$x][16];
            } else {
                $org_billingcountry = '';
            }
            if (isset($data->sheets[0]["cells"][$x][17])) {
                $org_shippingadd = $data->sheets[0]["cells"][$x][17];
            } else {
                $org_shippingadd = '';
            }
            if (isset($data->sheets[0]["cells"][$x][18])) {
                $org_shippingpob = $data->sheets[0]["cells"][$x][18];
            } else {
                $org_shippingpob = '';
            }
            if (isset($data->sheets[0]["cells"][$x][19])) {
                $org_shippingcity = $data->sheets[0]["cells"][$x][19];
            } else {
                $org_shippingcity = '';
            }
            if (isset($data->sheets[0]["cells"][$x][20])) {
                $org_shippingstate = $data->sheets[0]["cells"][$x][20];
            } else {
                $org_shippingstate = '';
            }
            if (isset($data->sheets[0]["cells"][$x][21])) {
                $org_shippingpoc = $data->sheets[0]["cells"][$x][21];
            } else {
                $org_shippingpoc = '';
            }
            if (isset($data->sheets[0]["cells"][$x][22])) {
                $org_shippingcountry = $data->sheets[0]["cells"][$x][22];
            } else {
                $org_shippingcountry = '';
            }
            if (isset($data->sheets[0]["cells"][$x][23])) {
                $org_desc = $data->sheets[0]["cells"][$x][23];
            } else {
                $org_desc = '';
            }
            if (isset($data->sheets[0]["cells"][$x][24])) {
                $org_createdby = $data->sheets[0]["cells"][$x][24];
            } else {
                $org_createdby = '';
            }

            if (isset($data->sheets[0]["cells"][$x][25])) {
                $org_createddt = $data->sheets[0]["cells"][$x][25];
            } else {
                $org_createddt = '';
            }
            if (isset($data->sheets[0]["cells"][$x][26])) {
                $org_updatedby = $data->sheets[0]["cells"][$x][26];
            } else {
                $org_updatedby = '';
            }
            if (isset($data->sheets[0]["cells"][$x][27])) {
                $org_updateddt = $data->sheets[0]["cells"][$x][27];
            } else {
                $org_updateddt = '';
            }

            $sql1 = "select * from  quote_organisation where org_name='$org_name'";
            $res1 = mysql_query($sql1);
            $tot = mysql_num_rows($res1);

            if ($tot == 0) {
                $sql = "insert into quote_organisation (org_name,org_primaryemail,org_secondaryemail,org_tertiaryemail,org_primaryphone,org_altphone,org_fax,org_website,org_assignedto,org_industry,org_billingadd,org_billingpob,org_billingcity,org_billingstate,org_billingpoc,org_billingcountry,org_shippingadd,org_shippingpob,org_shippingcity,org_shippingstate,org_shippingpoc,org_shippingcountry,org_desc,org_createdby,org_createddt,org_updatedby,org_updateddt) values ('$org_name','$org_primaryemail','$org_secondaryemail','$org_tertiaryemail','$org_primaryphone','$org_altphone','$org_fax','$org_website','$org_assignedto','$org_industry','$org_billingadd','$org_billingpob','$org_billingcity','$org_billingstate','$org_billingpoc','$org_billingcountry','$org_shippingadd','$org_shippingpob','$org_shippingcity','$org_shippingstate','$org_shippingpoc','$org_shippingcountry','$org_desc','$org_createdby','$org_createddt','$org_updatedby','$org_updateddt')";
                $res = mysql_query($sql);
                echo mysql_error();
                if ($res) {
                    
                }
            } else {

                echo "Organisation Already Exists <br>" . $org_name;
            }
        }
    }
}

function update_organisation() {
    $todaydt = date("Y-m-d H:i:s");
    $org_id = $_GET['org_id'];
    $org_name = $_POST['org_name'];

    $org_primaryemail = $_POST['org_primaryemail'];
    $org_primaryphone = $_POST['org_primaryphone'];

    $org_secondaryemail = $_POST['org_secondaryemail'];
    $org_tertiaryemail = $_POST['org_tertiaryemail'];
    $org_website = $_POST['org_website'];
    $org_industry = $_POST['org_industry'];
    $org_fax = $_POST['org_fax'];
    $org_altphone = $_POST['org_altphone'];
    $org_cst = $_POST['org_cst'];
    $org_vat = $_POST['org_vat'];

    $org_billingadd = $_POST['org_billingadd'];
    $org_billingpob = $_POST['org_billingpob'];
    $org_billingcity = $_POST['org_billingcity'];
    $org_billingstate = $_POST['org_billingstate'];
    $org_billingpoc = $_POST['org_billingpoc'];
    $org_billingcountry = $_POST['org_billingcountry'];

    $org_shippingadd = $_POST['org_shippingadd'];
    $org_shippingpob = $_POST['org_shippingpob'];
    $org_shippingcity = $_POST['org_shippingcity'];
    $org_shippingstate = $_POST['org_shippingstate'];
    $org_shippingpoc = $_POST['org_shippingpoc'];
    $org_shippingcountry = $_POST['org_shippingcountry'];
    $org_desc = $_POST['org_desc'];
    $org_updateddt = $todaydt;
    $org_updatedby = $_SESSION['login_user'];

    $org_name1 = "<a href='#'>" . $org_name . "</a>";
    $org_name2 = str_replace("'", "&#146;", $org_name1);
    $where = array('org_id' => $org_id);
    $row1 = selectAnd('quote_organisation', $where);
    $tot_update = "";
    if ($org_name == $row1['org_name']) {
        $org_name1 = "<a href='#'>" . $org_name . "</a>";
        $org_name2 = str_replace("'", "&#146;", $org_name1);
    } else {
        $org_name1 = "Name : <a href='#'>" . $row1['org_name'] . " to " . $org_name . "</a>";
        $tot_update.=str_replace("'", "&#146;", $org_name1) . "<br>";
    }

    if ($org_primaryemail != $row1['org_primaryemail']) {
        $emai1 = "Primary Email : <a href='#'>" . $row1['org_primaryemail'] . " to " . $org_primaryemail . "</a>";
        $tot_update.=str_replace("'", "&#146;", $emai1) . "<br>";
    }

    if ($org_primaryphone != $row1['org_primaryphone']) {
        $primaryphone = "Primary Phone : <a href='#'>" . $row1['org_primaryphone'] . " to " . $org_primaryphone . "</a>";
        $tot_update.=str_replace("'", "&#146;", $primaryphone) . "<br>";
    }

    if ($org_secondaryemail != $row1['org_secondaryemail']) {
        $secondaryemail = "Secondary Email : <a href='#'>" . $row1['org_secondaryemail'] . " to " . $org_secondaryemail . "</a>";
        $tot_update.=str_replace("'", "&#146;", $secondaryemail) . "<br>";
    }

    if ($org_tertiaryemail != $row1['org_tertiaryemail']) {
        $tertiaryemail = "Tertiary Email : <a href='#'>" . $row1['org_tertiaryemail'] . " to " . $tertiaryemail . "</a>";
        $tot_update.=str_replace("'", "&#146;", $tertiaryemail) . "<br>";
    }

    if ($org_website != $row1['org_website']) {
        $website = "Website : <a href='#'>" . $row1['org_website'] . " to " . $org_website . "</a>";
        $tot_update.=str_replace("'", "&#146;", $website) . "<br>";
    }

    if ($org_industry != $row1['org_industry']) {
        $industry = "Industry : <a href='#'>" . $row1['org_industry'] . " to " . $org_industry . "</a>";
        $tot_update.=str_replace("'", "&#146;", $industry) . "<br>";
    }

    if ($org_fax != $row1['org_fax']) {
        $fax = "Fax : <a href='#'>" . $row1['org_fax'] . " to " . $org_fax . "</a>";
        $tot_update.=str_replace("'", "&#146;", $fax) . "<br>";
    }

    if ($org_cst != $row1['org_cst']) {
        $cst = "CST : <a href='#'>" . $row1['org_cst'] . " to " . $org_cst . "</a>";
        $tot_update.=str_replace("'", "&#146;", $cst) . "<br>";
    }

    if ($org_vat != $row1['org_vat']) {
        $vat = "VAT : <a href='#'>" . $row1['org_vat'] . " to " . $org_vat . "</a>";
        $tot_update.=str_replace("'", "&#146;", $vat) . "<br>";
    }

    if ($org_altphone != $row1['org_altphone']) {
        $altphone = "Altphone : <a href='#'>" . $row1['org_altphone'] . " to " . $org_altphone . "</a>";
        $tot_update.=str_replace("'", "&#146;", $altphone) . "<br>";
    }
    if ($org_billingadd != $row1['org_billingadd']) {
        $billingadd = "Billing Address : <a href='#'>" . $row1['org_billingadd'] . " to " . $org_billingadd . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingadd) . "<br>";
    }
    if ($org_billingpob != $row1['org_billingpob']) {
        $billingpob = "Billing PO Box : <a href='#'>" . $row1['org_billingpob'] . " to " . $org_billingpob . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingpob) . "<br>";
    }
    if ($org_billingcity != $row1['org_billingcity']) {
        $billingcity = "Billing City : <a href='#'>" . $row1['org_billingcity'] . " to " . $org_billingcity . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingcity) . "<br>";
    }
    if ($org_billingstate != $row1['org_billingstate']) {
        $billingstate = "Billing State : <a href='#'>" . $row1['org_billingstate'] . " to " . $org_billingstate . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingstate) . "<br>";
    }
    if ($org_billingpoc != $row1['org_billingpoc']) {
        $billingpoc = "Billing Pincode : <a href='#'>" . $row1['org_billingpoc'] . " to " . $org_billingpoc . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingpoc) . "<br>";
    }
    if ($org_billingcountry != $row1['org_billingcountry']) {
        $billingcountry = "Billing Country : <a href='#'>" . $row1['org_billingcountry'] . " to " . $org_billingcountry . "</a>";
        $tot_update.=str_replace("'", "&#146;", $billingcountry) . "<br>";
    }
    if ($org_shippingadd != $row1['org_shippingadd']) {
        $shippingadd = "Shipping Address : <a href='#'>" . $row1['org_shippingadd'] . " to " . $org_shippingadd . "</a>";
        $tot_update.=str_replace("'", "&#146;", $shippingadd) . "<br>";
    }
    if ($org_shippingpob != $row1['org_shippingpob']) {
        $shippingpob = "Shipping PO Box : <a href='#'>" . $row1['org_shippingpob'] . " to " . $org_shippingpob . "</a>";
        $tot_update.=str_replace("'", "&#146;", $org_shippingpob) . "<br>";
    }
    if ($org_shippingcity != $row1['org_shippingcity']) {
        $shippingcity = "Shipping City : <a href='#'>" . $row1['org_shippingcity'] . " to " . $org_shippingcity . "</a>";
        $tot_update.=str_replace("'", "&#146;", $shippingcity) . "<br>";
    }
    if ($org_shippingstate != $row1['org_shippingstate']) {
        $shippingstate = "Shipping State : <a href='#'>" . $row1['org_shippingstate'] . " to " . $org_shippingstate . "</a>";
        $tot_update.=str_replace("'", "&#146;", $shippingstate) . "<br>";
    }
    if ($org_shippingpoc != $row1['org_shippingpoc']) {
        $shippingpoc = "Shipping Pincode : <a href='#'>" . $row1['org_shippingpoc'] . " to " . $org_shippingpoc . "</a>";
        $tot_update.=str_replace("'", "&#146;", $shippingpoc) . "<br>";
    }
    if ($org_shippingcountry != $row1['org_shippingcountry']) {
        $shippingcountry = "Shipping Country: <a href='#'>" . $row1['org_shippingcountry'] . " to " . $org_shippingcountry . "</a>";
        $tot_update.=str_replace("'", "&#146;", $shippingcountry) . "<br>";
    }
    if ($org_desc != $row1['org_desc']) {
        $desc = "Description : <a href='#'>" . $row1['org_desc'] . " to " . $org_desc . "</a>";
        $tot_update.=str_replace("'", "&#146;", $desc) . "<br>";
    }
    $db = pdo_db();
    $flag = FALSE;
    if ($row1 !== 0) {
        $db->beginTransaction();
        try {
            $param = array($org_name, $org_primaryemail, $org_secondaryemail, $org_tertiaryemail, $org_primaryphone, $org_altphone, $org_fax, $org_cst, $org_vat, $org_website, $org_industry, $org_billingadd, $org_billingpob, $org_billingcity, $org_billingstate, $org_billingpoc, $org_billingcountry, $org_shippingadd, $org_shippingpob, $org_shippingcity, $org_shippingstate, $org_shippingpoc, $org_shippingcountry, $org_desc, $org_updatedby, $org_updateddt, $org_id);
            update_quote_organisation($db, $param);

            $param = array($org_updatedby, 'Updated', $tot_update, $org_name2 . 'Organisation', $org_updateddt);
            insert_into_quote_contactactivity($db, $param);
            $db->commit();
            $flag = TRUE;
        } catch (PDOException $ex) {
            $db->rollBack();
        }
    }
    return $flag;
}

function add_contact() {
    date_default_timezone_set('Asia/Kolkata');
    $todaydt = date("Y-m-d H:i:s");
    $cont_primaryemail = $_POST['cont_primaryemail'];

    $cont_mobilephone = $_POST['cont_mobilephone'];
    $cont_type = $_POST['cont_type'];
    $cont_sal = $_POST['cont_sal'];
    $cont_firstname = $_POST['cont_firstname'];
    $cont_lastname = $_POST['cont_lastname'];
    $cont_secondaryemail = $_POST['cont_secondaryemail'];
    $cont_altphone = $_POST['cont_altphone'];
    $cont_leadsource = $_POST['cont_leadsource'];
    $cont_orgid = $_POST['cont_orgid'];
    $cont_orgdepart = $_POST['cont_orgdepart'];
    $cont_assignedto = $_SESSION['login_user'];
    $cont_mailingadd = $_POST['cont_mailingadd'];
    $cont_mailingpob = $_POST['cont_mailingpob'];
    $cont_mailingcity = $_POST['cont_mailingcity'];
    $cont_mailingstate = $_POST['cont_mailingstate'];
    $cont_mailingpoc = $_POST['cont_mailingpoc'];
    $cont_mailingcountry = $_POST['cont_mailingcountry'];

    $cont_otheradd = $_POST['cont_otheradd'];
    $cont_otherpob = $_POST['cont_otherpob'];
    $cont_othercity = $_POST['cont_othercity'];
    $cont_otherstate = $_POST['cont_otherstate'];
    $cont_otherpoc = $_POST['cont_otherpoc'];
    $cont_othercountry = $_POST['cont_othercountry'];

    $cont_desc = $_POST['cont_desc'];

    $cont_createdby = $_SESSION['login_user'];
    $cont_createddt = $todaydt;
    $cont_updateddt = "";
    $cont_updatedby = "";

    $ful_name = "<a href='#'>" . $cont_firstname . " " . $cont_lastname . "</a>";
    $ful_name1 = str_replace("'", "&#146;", $ful_name);
    $db = pdo_db();
    $flag = FALSE;
    if ($cont_type == "normal") {

        $where = array('cont_primaryemail' => $cont_primaryemail);
        $total = selectAnd('quote_contacts', $where);

        if ($total == 0) {
            $param = array($cont_type, $cont_sal, $cont_firstname, $cont_lastname, $cont_primaryemail, $cont_secondaryemail, $cont_mobilephone, $cont_altphone, $cont_leadsource, $cont_orgid, $cont_orgdepart, $cont_assignedto, $cont_mailingadd, $cont_mailingpob, $cont_mailingcity, $cont_mailingstate, $cont_mailingpoc, $cont_mailingcountry, $cont_otheradd, $cont_otherpob, $cont_othercity, $cont_otherstate, $cont_otherpoc, $cont_othercountry, $cont_desc, $cont_createdby, $cont_createddt, $cont_updatedby, $cont_updateddt);
            $db->beginTransaction();
            try {
                insert_into_quote_contacts($db, $param);
                $param1 = array($cont_createdby, 'Created', $ful_name1, 'Contacts', $cont_createddt);

                insert_into_quote_contactactivity($db, $param1);
                $db->commit();
                $flag = TRUE;
            } catch (PDOException $ex) {
                $db->rollBack();
            }
        }
    } elseif ($cont_type == "dealer") {
        $flag = FALSE;
        $db->beginTransaction();
        try {
            $param = array($cont_type, $cont_sal, $cont_firstname, $cont_lastname, $cont_primaryemail, $cont_secondaryemail, $cont_mobilephone, $cont_altphone, $cont_leadsource, $cont_orgid, $cont_orgdepart, $cont_assignedto, $cont_mailingadd, $cont_mailingpob, $cont_mailingcity, $cont_mailingstate, $cont_mailingpoc, $cont_mailingcountry, $cont_otheradd, $cont_otherpob, $cont_othercity, $cont_otherstate, $cont_otherpoc, $cont_othercountry, $cont_desc, $cont_createdby, $cont_createddt, $cont_updatedby, $cont_updateddt);
            insert_into_quote_contacts($db, $param);

            $param1 = array($cont_createdby, 'Created', $ful_name1, 'Contacts', $cont_createddt);
            insert_into_quote_contactactivity($db, $param1);
            $db->commit();
            $flag = TRUE;
        } catch (PDOException $ex) {
            $db->rollBack();
        }
    }
    return $flag;
}

function update_contact($param) {
    $cont_id = $_GET['cont_id'];
    $where = array('cont_id' => $cont_id);
    $row1 = selectAnd('quote_contacts', $where);
    $tot_update = "";
    if ($param['cont_firstname'] == $row1['cont_firstname'] && $param['cont_lastname'] == $row1['cont_lastname']) {
        $ful_name = "<a href='#'>" . $param['cont_firstname'] . " " . $param['cont_lastname'] . "</a>";
        $ful_name = str_replace("'", "&#146;", $ful_name);
    } else {
        $ful_name = "<a href='#'>" . $row1['cont_firstname'] . " " . $row1['cont_lastname'] . " to " . $param['cont_firstname'] . " " . $param['cont_lastname'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $ful_name);
    }

    if ($param['cont_primaryemail'] != $row1['cont_primaryemail']) {
        $emai1 = "Primary Email : <a href='#'>" . $row1['cont_primaryemail'] . " to " . $param['cont_primaryemail'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $emai1) . "<br>";
    }

    if ($param['cont_mobilephone'] != $row1['cont_mobilephone']) {
        $mobilephone = "Mobile Phone : <a href='#'>" . $row1['cont_mobilephone'] . " to " . $param['cont_mobilephone'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mobilephone) . "<br>";
    }

    if ($param['cont_type'] != $row1['cont_type']) {
        $type = "Type : <a href='#'>" . $row1['cont_type'] . " to " . $param['cont_type'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $type) . "<br>";
    }


    if ($param['cont_sal'] != $row1['cont_sal']) {
        $sal = "Saluation : <a href='#'>" . $row1['cont_sal'] . " to " . $param['cont_sal'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $sal) . "<br>";
    }

    if ($param['cont_secondaryemail'] != $row1['cont_secondaryemail']) {
        $secondaryemail = "Secondary Email : <a href='#'>" . $row1['cont_secondaryemail'] . " to " . $param['cont_secondaryemail'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $secondaryemail) . "<br>";
    }


    if ($param['cont_altphone'] != $row1['cont_altphone']) {
        $altphone = "Alt Phone : <a href='#'>" . $row1['cont_altphone'] . " to " . $param['cont_altphone'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $altphone) . "<br>";
    }


    if ($param['cont_leadsource'] != $row1['cont_leadsource']) {
        $leadsource = "Lead Source : <a href='#'>" . $row1['cont_leadsource'] . " to " . $param['cont_leadsource'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $leadsource) . "<br>";
    }


    if ($param['cont_orgid'] != $row1['cont_orgid']) {
        $orgid = "Organisation : <a href='#'>" . $row1['cont_orgid'] . " to " . $param['cont_orgid'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $orgid) . "<br>";
    }


    if ($param['cont_orgdepart'] != $row1['cont_orgdepart']) {
        $orgdepart = "Org Depart : <a href='#'>" . $row1['cont_orgdepart'] . " to " . $param['cont_orgdepart'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $orgdepart) . "<br>";
    }

//    if ($param['cont_assignedto'] != $row1['cont_assignedto']) {
//        $assignedto = "Assigned To : <a href='#'>" . $row1['cont_assignedto'] . " to " . $param['cont_assignedto'] . "</a>";
//        $tot_update.=str_replace("'", "&#146;", $assignedto) . "<br>";
//    }



    if ($param['cont_mailingadd'] != $row1['cont_mailingadd']) {
        $mailingadd = "Mailing Address : <a href='#'>" . $row1['cont_mailingadd'] . " to " . $param['cont_mailingadd'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingadd) . "<br>";
    }

    if ($param['cont_mailingpob'] != $row1['cont_mailingpob']) {
        $mailingpob = "Mailing PO Box : <a href='#'>" . $row1['cont_mailingpob'] . " to " . $param['cont_mailingpob'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingpob) . "<br>";
    }


    if ($param['cont_mailingcity'] != $row1['cont_mailingcity']) {
        $mailingcity = "Mailing City : <a href='#'>" . $row1['cont_mailingcity'] . " to " . $param['cont_mailingcity'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingcity) . "<br>";
    }


    if ($param['cont_mailingstate'] != $row1['cont_mailingstate']) {
        $mailingstate = "Mailing State : <a href='#'>" . $row1['cont_mailingstate'] . " to " . $param['cont_mailingstate'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingstate) . "<br>";
    }


    if ($param['cont_mailingpoc'] != $row1['cont_mailingpoc']) {
        $mailingpoc = "Mailing Pincode : <a href='#'>" . $row1['cont_mailingpoc'] . " to " . $param['cont_mailingpoc'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingpoc) . "<br>";
    }

    if ($param['cont_mailingcountry'] != $row1['cont_mailingcountry']) {
        $mailingcountry = "Mailing Country : <a href='#'>" . $row1['cont_mailingcountry'] . " to " . $param['cont_mailingcountry'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $mailingcountry) . "<br>";
    }

    if ($param['cont_otheradd'] != $row1['cont_otheradd']) {
        $otheradd = "Other Address : <a href='#'>" . $row1['cont_otheradd'] . " to " . $param['cont_otheradd'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $otheradd) . "<br>";
    }


    if ($param['cont_otherpob'] != $row1['cont_otherpob']) {
        $otherpob = "Other PO Box : <a href='#'>" . $row1['cont_otherpob'] . " to " . $param['cont_otherpob'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $otherpob) . "<br>";
    }

    if ($param['cont_othercity'] != $row1['cont_othercity']) {
        $othercity = "Other City : <a href='#'>" . $row1['cont_othercity'] . " to " . $param['cont_othercity'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $othercity) . "<br>";
    }


    if ($param['cont_otherstate'] != $row1['cont_otherstate']) {
        $otherstate = "Other State : <a href='#'>" . $row1['cont_otherstate'] . " to " . $param['cont_otherstate'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $otherstate) . "<br>";
    }


    if ($param['cont_otherpoc'] != $row1['cont_otherpoc']) {
        $otherpoc = "Other Pincode : <a href='#'>" . $row1['cont_otherpoc'] . " to " . $param['cont_otherpoc'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $otherpoc) . "<br>";
    }


    if ($param['cont_othercountry'] != $row1['cont_othercountry']) {
        $othercountry = "Other Country : <a href='#'>" . $row1['cont_othercountry'] . " to " . $param['cont_othercountry'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $othercountry) . "<br>";
    }


    if ($param['cont_desc'] != $row1['cont_desc']) {
        $desc = "Desc : <a href='#'>" . $row1['cont_desc'] . " to " . $param['cont_desc'] . "</a>";
        $tot_update.=str_replace("'", "&#146;", $desc) . "<br>";
    }

    if ($row1 !== 0) {
        $db = pdo_db();
        $flag = FALSE;
        $db->beginTransaction();
        try {
            $param1 = array($param['cont_type'], $param['cont_sal'], $param['cont_firstname'], $param['cont_lastname'], $param['cont_primaryemail'], $param['cont_secondaryemail'], $param['cont_mobilephone'], $param['cont_altphone'], $param['cont_leadsource'], $param['cont_orgid'], $param['cont_orgdepart'], $param['cont_mailingadd'], $param['cont_mailingpob'], $param['cont_mailingcity'], $param['cont_mailingstate'], $param['cont_mailingpoc'], $param['cont_mailingcountry'], $param['cont_otheradd'], $param['cont_otherpob'], $param['cont_othercity'], $param['cont_otherstate'], $param['cont_otherpoc'], $param['cont_othercountry'], $param['cont_desc'], $param['cont_updatedby'], $param['cont_updateddt'], $cont_id);
            update_quote_contacts($db, $param1);

            $param2 = array($param['cont_updatedby'], 'Updated', $tot_update, $ful_name . 'Contact', $param['cont_updateddt']);
            insert_into_quote_contactactivity($db, $param2);
            $db->commit();
            $flag = TRUE;
        } catch (PDOException $ex) {
            $db->rollBack();
        }
    }
    return $flag;
}

function tax_calculation($param) {

    $where = array('lower(tax_name)' => strtolower($param['tax_name']));
    $total = select_where_count('tax_cal', $where);
    $correct = 0;
    if ($total == 0) {
        $param1 = array($param['tax_name'], $param['tax_value'], $param['tax_status'], $param['todaydt'], $param['tax_update']);
        $res = insert_into_tax_cal($param1);
        if ($res) {
            $correct = 1;
        }
        ?>
        <?php
        if ($correct == 1) {
            ?>
            <script type="text/javascript">
                window.open('crm_settings.php#first11', '_self');
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Cannot add . Please Try Again");
                history.go(-1);
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("Tax Name Already exist");
            history.go(-1);
        </script>
        <?php
    }
}

function select_trmandcond()
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from termsncond where 1");
   $stmt->execute();
  // return $stmt->rowCount();
return $stmt->fetch(PDO::FETCH_ASSOC);
}


function trmandcond($param) {
    $where = array('lower(tnc_orgid)' => strtolower($param['tnc_orgid']));
    $total = select_where_count('termsncond', $where);
    if ($total == 0) {
        $param1 = array($param['tnc_orgid'], $param['tnc_content'], $param['todaydt']);
        $res = insert_into_termsncond($param1);
    } else {

        $col = array('tnc_content', 'tnc_dt', 'tnc_orgid');
        $value = array($param['tnc_content'], $param['todaydt'], $param['tnc_orgid']);
        $res = update_table('termsncond', $col, $value);
    }
    return $res;
}

function change_pasword($param) {
    $where = array('username' => $param['uname']);
    $row = selectAnd('admin', $where);
    $correct = 0;
    if ($row['password'] == $param['upswd']) {
        if ($param['newpswd'] = $param['confirpswd']) {
            $col = array('password', 'username');
            $value = array($param['newpswd'], $param['uname']);
            update_table('admin', $col, $value);
            $correct = 1;
        } else {
            $correct = 2;
            //echo "Re-enter the New Password and Confirm Password again";
        }
    } else {
        $correct = 3;
        //echo "Username And Password Do Not Match";
    }
    if($correct==1)
    {
    ?>
    <script type="text/javascript">
        alert("Password successfully changed");
        window.open('home.php', '_self');
    </script>
    <?php
} elseif($correct==2) {
    ?>
    <script type="text/javascript">
        alert("Re-enter the New Password and Confirm Password again");
        history.go(-1);
    </script>
    <?php
} elseif($correct==3) {
    ?>
    <script type="text/javascript">
        alert("Username and Password do not match");
        history.go(-1);
    </script>
    <?php
}

}
?>