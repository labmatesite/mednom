<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// connecting database
function pdo_db() {
    include 'config.php';
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function selectAll($table) {
    $db = pdo_db();
    $sql = "select * from $table ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    //$stmt->fetch(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}

/// select query with AND condition $where parameter is a array
function selectAnd($table, $where) {
    $i = 0;
    $db = pdo_db();
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    if ($i == 1) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0]));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($i == 2) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ? AND $col[1]=?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0], $val[1]));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function selectOr($table, $where) {
    $i = 0;
    $db = pdo_db();
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    if ($i == 1) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0]));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($i == 2) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ? OR $col[1]=?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0], $val[1]));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($i == 3) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ? OR $col[1]=? OR $col[2]=?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0], $val[1], $val[2]));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function selectQuery($sql) {
    $db = pdo_db();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function selectQueryWithAnd($sql) {
    $db = pdo_db();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
}

function insert_into_quote_organisation($db, $param) {
    $sql = "INSERT INTO quote_organisation(org_name,org_primaryemail,org_secondaryemail,org_tertiaryemail,org_primaryphone,org_altphone,org_fax,org_website,org_assignedto,org_industry,org_cst,org_vat,org_billingadd,org_billingpob,org_billingcity,org_billingstate,org_billingpoc,org_billingcountry,org_shippingadd,org_shippingpob,org_shippingcity,org_shippingstate,org_shippingpoc,org_shippingcountry,org_desc,org_createdby,org_createddt,org_updatedby,org_updateddt)"
            . "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

function insert_into_quote_contactactivity($db, $param) {
    $sql = "INSERT INTO quote_contactactivity (ca_userid,ca_activity,ca_activity_details,ca_dbtype,ca_date) VALUES(?,?,?,?,?) ";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

function update_quote_organisation($db, $param) {
    $sql = "UPDATE quote_organisation 
        SET org_name=?,org_primaryemail=?,org_secondaryemail=?,org_tertiaryemail=?,org_primaryphone=?,org_altphone=?,org_fax=?,org_cst=?,org_vat=?,org_website=?,org_industry=?,org_billingadd=?,org_billingpob=?,org_billingcity=?,org_billingstate=?,org_billingpoc=?,org_billingcountry=?,org_shippingadd=?,org_shippingpob=?,org_shippingcity=?,org_shippingstate=?,org_shippingpoc=?,org_shippingcountry=?,org_desc=?,org_updatedby=?,org_updateddt=?       
        WHERE org_id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

function insert_into_quote_contacts($db, $param) {

    $sql = "INSERT INTO quote_contacts(cont_type,cont_sal,cont_firstname,cont_lastname,cont_primaryemail,cont_secondaryemail,cont_mobilephone,cont_altphone,cont_leadsource,cont_orgid,cont_orgdepart,cont_assignedto,cont_mailingadd,cont_mailingpob,cont_mailingcity,cont_mailingstate,cont_mailingpoc,cont_mailingcountry,cont_otheradd,cont_otherpob,cont_othercity,cont_otherstate,cont_otherpoc,cont_othercountry,cont_desc,cont_createdby,cont_createddt,cont_updatedby,cont_updateddt)"
            . "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

function update_quote_contacts($db, $param) {
    $sql = "UPDATE quote_contacts       
        SET cont_type=?,cont_sal=?,cont_firstname=?,cont_lastname=?,cont_primaryemail=?,cont_secondaryemail=?,cont_mobilephone=?,cont_altphone=?,cont_leadsource=?,cont_orgid=?,cont_orgdepart=?,cont_mailingadd=?,cont_mailingpob=?,cont_mailingcity=?,cont_mailingstate=?,cont_mailingpoc=?,cont_mailingcountry=?,cont_otheradd=?,cont_otherpob=?,cont_othercity=?,cont_otherstate=?,cont_otherpoc=?,cont_othercountry=?,cont_desc=?,cont_updatedby=?,cont_updateddt=?       
        WHERE cont_id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

// these functions used in contact pegination and organisation pegination
function select_quote_organisation_without_limit($username) {
    $db = pdo_db();
    $sql = "SELECT c.`org_id`,c.`org_name` FROM `quote_organisation` c WHERE c.`org_assignedto` LIKE '$username' UNION SELECT a.`org_id`,a.`org_name` FROM `quote_organisation` a, quote_share b WHERE b.shd_assignto LIKE '$username' AND a.org_id = b.shd_orgid";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_quote_organisation_with_limit($username, $lower_limit, $page_limit) {
    $db = pdo_db();
    $sql = "SELECT c.`org_id`,c.`org_name`,c.`org_billingcity`,c.`org_website`,c.`org_primaryphone`,c.`org_assignedto` FROM `quote_organisation` c WHERE c.`org_assignedto` LIKE '$username' UNION SELECT a.`org_id`,a.`org_name`,a.`org_billingcity`,a.`org_website`,a.`org_primaryphone`,a.`org_assignedto` FROM `quote_organisation` a, quote_share b WHERE b.shd_assignto LIKE '$username' AND a.org_id = b.shd_orgid limit " . $lower_limit . "," . $page_limit . "";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_table_orderby($table, $orderby) {
    $db = pdo_db();
    $sql = "SELECT * FROM $table ORDER BY $orderby ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_table_orderbydesc($table, $orderby) {
    $db = pdo_db();
    $sql = "SELECT * FROM $table ORDER BY $orderby DESC limit 500 ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_quote_contacts_without_limit($username) {
    $db = pdo_db();
    $sql = "SELECT c.`cont_firstname`,c.`cont_lastname`,c.`cont_primaryemail`,c.`cont_mobilephone`,c.`cont_assignedto`,c.`cont_orgid`,c.`cont_id` FROM `quote_contacts` c WHERE c.`cont_assignedto` LIKE '$username' UNION SELECT a.`cont_firstname`,a.`cont_lastname`,a.`cont_primaryemail`,a.`cont_mobilephone`,a.`cont_assignedto`,a.`cont_orgid`,a.`cont_id` FROM `quote_contacts` a, quote_share b WHERE b.shd_assignto LIKE '$username' AND a.cont_id = b.shd_contid";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_quote_contacts_with_limit($username, $lower_limit, $page_limit) {
    $db = pdo_db();
    $sql = "SELECT c.`cont_firstname`,c.`cont_lastname`,c.`cont_primaryemail`,c.`cont_mobilephone`,c.`cont_assignedto`,c.`cont_orgid`,c.`cont_id` FROM `quote_contacts` c WHERE c.`cont_assignedto` LIKE '$username' UNION SELECT a.`cont_firstname`,a.`cont_lastname`,a.`cont_primaryemail`,a.`cont_mobilephone`,a.`cont_assignedto`,a.`cont_orgid`,a.`cont_id` FROM `quote_contacts` a, quote_share b WHERE b.shd_assignto LIKE '$username' AND a.cont_id = b.shd_contid limit " . $lower_limit . "," . $page_limit . "";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_with_limit($lower_limit, $page_limit) {
    $db = pdo_db();
    $sql = "select * from quote_contacts order by cont_id desc limit " . $lower_limit . "," . $page_limit . "";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_quote_organisation_pegination($lower_limit, $page_limit) {
    $db = pdo_db();
    $sql = "select * from quote_organisation order by org_name limit " . $lower_limit . "," . $page_limit . "";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_where_count($table, $where) {
    $i = 0;
    $db = pdo_db();
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    if ($i == 1) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0]));
        return $stmt->rowCount();
    }
}

function select_all_count() {
    $db = pdo_db();
    $sql = "SELECT * FROM $table ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function insert_into_tax_cal($param) {
    $db = pdo_db();
    $sql = "INSERT INTO tax_cal(tax_name,tax_value,tax_status,tax_dt,tax_update)VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute($param);
    return $result;
}

function update_tax_cal($param) {
    $db = pdo_db();
    $sql = "UPDATE tax_cal
            SET tax_status= ? 
            WHERE tax_id=? ";
    $stmt = $db->prepare($sql);
    return $stmt->execute($param);
}

function update_table($table, $col, $value) {
    $db = pdo_db();
    try {
        $colom = "";
        $update = "UPDATE $table SET " . " ";
        $last = count($col) - 2;

        for ($i = 0; $i < count($col) - 1; $i++) {

            if ($col[$i] == $col[$last]) {
                $colom.= $col[$i] . ' =?';
                break;
            }
            $colom.= $col[$i] . ' =?, ';
        }
        $where = ' WHERE ' . end($col) . ' =?';
        $sql = "$update $colom $where ";
        $stmt = $db->prepare($sql);
        return $stmt->execute($value);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function insert_into_termsncond($param) {
    $db = pdo_db();
    $sql = "INSERT INTO termsncond(tnc_orgid,tnc_content,tnc_dt) VALUES(?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute($param);
}

function select_orderby_limit($table, $orderby, $limit) {
    $db = pdo_db();
    $sql = "SELECT * FROM $table ORDER BY $orderby limit $limit";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function select_quote_emaillogs_orderby($usr) {
    $db = pdo_db();
    $sql = "select * from quote_emaillogs where el_userid='$usr' order by el_date desc";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function selectWhere($table, $where) {
    $i = 0;
    $db = pdo_db();
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    if ($i == 1) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0]));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function select_count_between($table, $as, $where, $col1, $value1, $value2) {
    $db = pdo_db();
    $i = 0;
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    $sql = "SELECT count(*) AS $as FROM $table WHERE $col[0]= '$val[0]' AND  $col1 BETWEEN '$value1' AND '$value2' ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function select_count($table, $as, $where) {
    $db = pdo_db();
    $i = 0;
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    $sql = "SELECT count(*) AS $as FROM $table WHERE $col[0]= '$val[0]'  ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function selectAndOrderby($table, $where, $orderby) {
    $i = 0;
    $db = pdo_db();
    foreach ($where as $colom => $value) {
        $col[] = $colom;
        $val[] = $value;
        $i++;
    }
    if ($i == 1) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ? ORDER BY $orderby ";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0]));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($i == 2) {
        $sql = "SELECT * FROM $table WHERE $col[0]= ? AND $col[1]=? ORDER BY $orderby";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($val[0], $val[1]));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function admin_not_equal() {
    $db = pdo_db();
    $sql = "select * from admin where userType='users' and username <> '$username'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function report_pegi() {
    $db = pdo_db();
    $sql3 = "SELECT q . * , (

SELECT org_name FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS org_name,
(SELECT org_shippingcity FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS city,
(SELECT org_shippingstate FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS state,
(SELECT org_shippingcountry FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS country,
qp.product_name, qp.product_sku, qp.product_sellingprice
FROM quotations AS q
LEFT JOIN quote_product AS qp ON q.qt_refid = qp.qt_refid ";
    $stmt = $db->prepare($sql3);
    $stmt->execute();
    return $stmt->rowCount();
}
function report_pegi_with_limit($lower_limit,$page_limit) {
    $db = pdo_db();
    $sql3 = "SELECT q . * , (
SELECT org_name FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS org_name,
(SELECT org_shippingcity FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS city,
(SELECT org_shippingstate FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS state,
(SELECT org_shippingcountry FROM quote_organisation AS qo WHERE qo.org_id = q.qt_organisationid ) AS country,
qp.product_name, qp.product_sku, qp.product_sellingprice
FROM quotations AS q
LEFT JOIN quote_product AS qp ON q.qt_refid = qp.qt_refid LIMIT $lower_limit ,$page_limit";
    $stmt = $db->prepare($sql3);
    $stmt->execute();
    return $stmt->fetchAll();
}
function quote_contact_limit($where){
    $db = pdo_db();
    $sql = "select * from quote_contacts where cont_id= $where limit 0,1" ;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
}
