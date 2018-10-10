<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "database.php";


function show_table_column()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SHOW columns FROM price_list WHERE FIELD NOT IN ('id', 'sku');");
    $stmt->execute();
    // return $stmt->rowCount();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function insert_quote_emaillogs($userid, $usremail, $emailId, $addcc, $addBCC, $e_subject, $body, $atta, $dt, $ipaddress)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_emaillogs (el_userid,el_from,el_to,el_acc,el_bcc,el_subject,el_content,el_attachments,el_date,el_ipaddress) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($userid, $usremail, $emailId, $addcc, $addBCC, $e_subject, $body, $atta, $dt, $ipaddress));

}

function select_upload_data($refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_uploaddata WHERE up_refid=?");
    $stmt->execute(array($refid));
    // return $stmt->rowCount();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function quote_uploaddata($refid, $file_name, $file_size, $file_type)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_uploaddata (up_refid,up_file_name,up_file_size,up_file_type) VALUES(?,?,?,?)");
    $stmt->execute(array($refid, $file_name, $file_size, $file_type));

}

function delete_upload_data($refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM quote_uploaddata WHERE up_refid=?");
    $stmt->execute(array($refid));
    return $stmt->rowCount();
}

//admin tab functions

function update_admin_users($uid, $full_name, $rights, $password, $emailid, $epassword, $tnc, $qt_cur, $qt_price, $host, $portno, $a_ipaddress, $todaydt, $outside)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("update admin set full_name='$full_name', userType='$rights',password='$password',emailid='$emailid',emailpwd='$epassword',
 tnc='$tnc',currency='$qt_cur',price='$qt_price',host='$host',port='$portno',a_ipaddress='$a_ipaddress',dt='$todaydt',outside='$outside' where id=?");
    $stmt->execute(array($uid));
    //return $stmt->fetch(PDO::FETCH_ASSOC);
}


function find_admin_usersbyuserid($uid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id=?");
    $stmt->execute(array($uid));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function find_admin_usersbyid($uid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->execute(array($uid));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function find_admin_users($username, $rights)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=? AND userType=?");
    $stmt->execute(array($username, $rights));
    return $stmt->rowCount();
}


function list_admin_users()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


}

function create_admin_users($rights, $full_name, $username, $password, $emailid, $epassword, $host, $portno, $todaydt, $a_ipaddress, $outside, $tnc, $qt_cur, $qt_price)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO admin(userType,full_name,username,password,emailid,emailpwd,tnc,currency,price,host,port,dt,a_ipaddress,outside) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($rights, $full_name, $username, $password, $emailid, $epassword, $tnc, $qt_cur, $qt_price, $host, $portno, $todaydt, $a_ipaddress, $outside));
    //return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//
//edit quote functions

function get_crndata()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM crn ORDER BY crn_id DESC LIMIT 0,1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}


function create_admin_user($username, $password, $email)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO admin(username,password,emailid) VALUES(?,?,?)");
    $stmt->execute(array($username, $password, $email));
//$stmt->execute();

}

//$quotedetails =create_admin_user('jugal','rathod','test@testmail.com');
//var_dump($quotedetails);

function get_quotedetail($refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quotations WHERE qt_refid=?");
    $stmt->execute(array($refid));
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function save_edited_quote($refid, $generatedby, $generatedon, $quotedata)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_edited(refid,generatedby,generatedon,quotedata) VALUES(?,?,?,?)");
    $stmt->execute(array($refid, $generatedby, $generatedon, $quotedata));
    return $pdo->lastInsertId();
    // $stmt->execute();
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function list_edited_quote($refid)
{
    $pdo = pdo_db();
    if ($refid != '') {
        $stmt = $pdo->prepare("SELECT * FROM quote_edited WHERE refid=?");
        $stmt->execute(array($refid));
    } else {
        $stmt = $pdo->prepare("SELECT * FROM quote_edited WHERE 1");
        $stmt->execute();

    }
    //$stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $stmt->execute();
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function fetch_edited_quote($refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_edited WHERE id=?");
    $stmt->execute(array($refid));
    //$stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    // $stmt->execute();
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function get_quoteproducts($refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_product WHERE qt_refid=?");
    $stmt->execute(array($refid));
    //$stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


//add quote functions
function quote_contactactivity($ca_userid, $ca_activity, $ca_activity_details, $ca_dbtype, $ca_date)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_contactactivity(ca_userid,ca_activity,ca_activity_details,ca_dbtype,ca_date) VALUES (?,?,?,?,?)");
    $stmt->execute(array($ca_userid, $ca_activity, $ca_activity_details, $ca_dbtype, $ca_date));
    // $stmt->execute();
    return $stmt->rowCount();

}


function update_crn($qt_stseq, $up_refid, $qt_createdby, $todaydt, $crn_id)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("update crn set crn_stseq ='$qt_stseq',crn_prefix='$up_refid',crn_updatedby='$qt_createdby',crn_updatedt='$todaydt' where crn_id=?");
    $stmt->execute(array($crn_id));
    // $stmt->execute();

}

function insert_quote($qt_organisationid, $qt_contacts, $qt_subject, $qt_refid, $qt_tnc, $qt_addinfo, $qt_desc, $qt_currency, $qt_itemtotal, $qt_discount, $qt_discountpercent, $qt_shipping_charges, $qt_pretax_total, $qt_tax, $qt_adj_add, $qt_adj_sub, $qt_grandtotal, $qt_createdby, $qt_createddt, $qt_updatedby, $qt_updateddt)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quotations (qt_organisationid,qt_contacts,qt_subject,qt_refid,qt_tnc,qt_addinfo,qt_desc,qt_currency,qt_itemtotal,qt_discount,qt_discountpercent,qt_shipping_charges,qt_pretax_total,qt_tax,qt_adj_add,qt_adj_sub,qt_grandtotal,qt_createdby,qt_createddt,qt_updatedby,qt_updateddt) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");


    $stmt->execute(array($qt_organisationid, $qt_contacts, $qt_subject, $qt_refid, $qt_tnc, $qt_addinfo, $qt_desc, $qt_currency, $qt_itemtotal, $qt_discount, $qt_discountpercent, $qt_shipping_charges, $qt_pretax_total, $qt_tax, $qt_adj_add, $qt_adj_sub, $qt_grandtotal, $qt_createdby, $qt_createddt, $qt_updatedby, $qt_updateddt));
    // $stmt->execute();


}

function update_quote($qt_organisationid, $qt_contacts, $qt_subject, $qt_tnc, $qt_addinfo, $qt_cur, $qt_itemtotal, $qt_discount, $qt_discountpercent, $qt_shipping_charges, $qt_pretax_total, $qt_tax, $qt_adj_add, $qt_adj_sub, $qt_grandtotal, $qt_updatedby, $qt_updateddt, $up_qt_refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("update quotations set qt_organisationid='$qt_organisationid',qt_contacts='$qt_contacts',qt_subject='$qt_subject',qt_tnc='$qt_tnc',qt_addinfo='$qt_addinfo',qt_currency='$qt_cur',qt_itemtotal='$qt_itemtotal',qt_discount='$qt_discount',qt_discountpercent='$qt_discountpercent',qt_shipping_charges='$qt_shipping_charges',qt_pretax_total='$qt_pretax_total',qt_tax='$qt_tax',qt_adj_add='$qt_adj_add',qt_adj_sub='$qt_adj_sub',qt_grandtotal='$qt_grandtotal',qt_updatedby='$qt_updatedby',qt_updateddt='$qt_updateddt' where qt_refid=?");

    $stmt->execute(array($up_qt_refid));
    // $stmt->execute();


}


function insert_quote_org($org_name, $org_primaryemail, $org_billingadd, $org_billingcity, $org_billingstate, $org_createdby, $org_createddt)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_organisation(org_name,org_primaryemail,org_billingadd,org_billingcity,org_billingstate,org_createdby,org_createddt) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array($org_name, $org_primaryemail, $org_billingadd, $org_billingcity, $org_billingstate, $org_createdby, $org_createddt));
    // $stmt->execute();
    return $pdo->lastInsertId();
}

function insert_quote_contact($cont_sal, $cfname, $clname, $cemail, $qt_organisationid, $cont_createdby, $cont_createddt)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_contacts(cont_sal,cont_firstname,cont_lastname,cont_primaryemail,cont_orgid,cont_createdby,cont_createddt) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array("$cont_sal", "$cfname", "$clname", "$cemail", "$qt_organisationid", "$cont_createdby", "$cont_createddt"));
    // $stmt->execute();
    return $pdo->lastInsertId();

}

//$contid = insert_quote_contact('ii','uj','jj','ll');
//echo "sdfdsfsd".$contid;
function insert_quote_tax($qt_refid, $qt_taxname, $qt_taxvalue, $todaydt)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_tax (qt_refid,qt_taxname,qt_taxvalue,qt_taxdt) VALUES (?,?,?,?)");
    $stmt->execute(array($qt_refid, $qt_taxname, $qt_taxvalue, $todaydt));
    // $stmt->execute();

}


function delete_quote_taxes($qt_refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM quote_tax WHERE qt_refid=?");
    $stmt->execute(array($qt_refid));
}

function quote_taxes_forquote($qt_refid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_tax WHERE qt_refid=?");
    $stmt->execute(array($qt_refid));
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delete_quote_product($qt_refid)
{

    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM quote_product WHERE qt_refid=?");
    $stmt->execute(array($qt_refid));
    // $stmt->execute();
//$inid = $pdo->lastInsertId();

}

function insert_quote_product($qt_refid, $qt_product_sku, $qt_product_name, $qt_product_desc, $qt_product_qty, $qt_selling_price,
                              $qt_product_spec_show)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("INSERT INTO quote_product (qt_refid,product_sku,product_name,product_desc,product_quantity,product_sellingprice,product_spec_show) VALUES (?,?,?,?,?,?,?)");

    $stmt->execute(array($qt_refid, $qt_product_sku, $qt_product_name, $qt_product_desc, $qt_product_qty, $qt_selling_price,
        $qt_product_spec_show));
    // $stmt->execute();
    //return $stmt->fetchAll(PDO::FETCH_ASSOC)

}

function quote_emaillogs($refid)
{

    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT count(*) AS ref_count FROM quote_emaillogs WHERE el_refid=?");
    $stmt->execute(array($refid));
    //  $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function contact_details($contid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_contacts WHERE cont_id=?");
    $stmt->execute(array($contid));
    // $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function select_taxes()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM tax_cal WHERE tax_status='active'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_quotelist($username, $start, $end)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->execute(array($username));
    //   $stmt->execute();
    $udetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $str = '';
//echo $start;
    if ($start != '') {
        $str .= " limit $start , $end";
//echo "888".$str;
    }

    if ($udetails[0]['userType'] == "users") {
        $stmt = $pdo->prepare("select * from quotations where qt_createdby='$username' order by qt_id desc $str");
    } 
    elseif ($udetails[0]['userType'] == "admin") {
        $stmt = $pdo->prepare("select * from quotations where qt_createdby='$username' order by qt_id desc $str");
    }
    else {
        $stmt = $pdo->prepare("select * from quotations order by qt_id Desc $str");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/* Function For searching The Quotation by user session*/
function get_all_quotelist($username)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->execute(array($username)); 
    $udetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($udetails[0]['userType'] == "users") {
        $stmt = $pdo->prepare("select * from quotations where qt_createdby='$username'");
    }
    elseif ($udetails[0]['userType'] == "admin") {
        $stmt = $pdo->prepare("select * from quotations where qt_createdby='$username'");
    } else {
        $stmt = $pdo->prepare("select * from quotations");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
/* */
function admindetails_byusername($username)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->execute(array($username));
    //  $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function select_taxdetails($taxid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM tax_cal WHERE tax_id=?");
    $stmt->execute(array($taxid));
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

//$taxdet = select_taxdetails(1);
//echo $taxdet[0]['tax_status'];

function get_organisation_byid($orgid)
{
    $pdo = pdo_db();
    // $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` where org_id=?");
    $stmt = $pdo->prepare("SELECT * FROM `quote_organisation` WHERE org_id=?");
    $stmt->execute(array($orgid));
    return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_organisation()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}
function get_quotation()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `quotations`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

function get_organisation_byname($orgname)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` WHERE org_name=?");
    $stmt->execute(array($orgname));

    return $stmt->rowCount();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_organisation_byemail($orgemail)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` WHERE org_primaryemail=?");
    $stmt->execute(array($orgemail));

    return $stmt->rowCount();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

/*function get_product_attributes($proid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select b.name,a.value from productsattribute a, product_attributeoption b,products pp where a.option_id=b.id and a.product_id =pp.id and pp.sku =? order by a.id limit 0,4");
$stmt->execute(array($proid));
 return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_product_attributes($proid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select b.name,a.value from product_productattribute a, product_attributeoption b,products pp where pp.sku =? and a.option_id=b.id and a.product_id =pp.id  order by a.id limit 0,4");
$stmt->execute(array($proid));
 return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
*/

function get_product_attributes($proid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE sku =?");
    $stmt->execute(array($proid));

    return $stmt->fetch(PDO::FETCH_ASSOC);

}


function get_productdetails_bysku($sku)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE sku =?");
    $stmt->execute(array($sku));
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// function by Aquib

function get_product_catalog_byname($name)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT category_id,catalog_url FROM products WHERE name =?");
    $stmt->execute(array($name));
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}




function get_product_catalog_bysku($sku)
{
    $pdo = pdo_db();

    $stmt = $pdo->prepare("SELECT category_id,catalog_url FROM products WHERE sku =?");
    $stmt->execute(array($sku));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_category_name_by_id($id)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT name FROM `categories` WHERE id =?");
    $stmt->execute(array($id));
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


//end of Aquib function

function get_productprice_bysku($sku)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM price_list WHERE sku =?");
    $stmt->execute(array($sku));
    // $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_productprice_byskunew($sku, $price)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT {$price} from price_list where sku = ?");
    $stmt->execute(array($sku));
    // $stmt->execute();
    return $stmt->fetch();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function get_multiple_productprice_bysku($sku){
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * from price_list where sku LIKE '%".$sku."%' ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//$dats = get_product_attributes(2880);
//var_dump($dats);

function get_products()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `products`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_contacts_byemail($cemail)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM quote_contacts WHERE  cont_primaryemail=? OR cont_secondaryemail=?");
    $stmt->execute(array($cemail, $cemail));
    return $stmt->rowCount();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_contacts()
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT cont_id,cont_sal,cont_firstname,cont_lastname FROM `quote_contacts`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_contactbyorgid($orgid)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT cont_id,cont_sal,cont_firstname,cont_lastname FROM `quote_contacts` WHERE cont_orgid=?");
    $stmt->execute(array($orgid));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function exportCSV($resultset) {    
    $fh = fopen( 'php://output', 'w' );
    $heading = false;      
    while( $rows = mysqli_fetch_assoc($resultset) ) {           
        if(!$heading) {
          fputcsv($fh, array_keys($rows));
          $heading = true;
        }
         fputcsv($fh, $rows);           
    }   
    fclose($fh);        
}

function get_org_id($id)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare(" SELECT * FROM quotations WHERE qt_refid = ?");
    /*$stmt = $pdo->prepare(" SELECT * 
                            FROM quotations WHERE qt_refid = ".$refid."
                            JOIN quote_organisation ON quotations.qt_organisationid = quote_organisation.org_id ");*/
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function pdf_file_name($ref_id)
{
    $pdo = pdo_db();
    $stmt = $pdo->prepare(" SELECT * FROM quote_organisation WHERE org_id = ?");
    /*$stmt = $pdo->prepare(" SELECT * 
                            FROM quotations WHERE qt_refid = ".$refid."
                            JOIN quote_organisation ON quotations.qt_organisationid = quote_organisation.org_id ");*/
    $stmt->execute(array($ref_id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>