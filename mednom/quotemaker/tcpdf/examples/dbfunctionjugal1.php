<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

 include "database.php";



//admin tab functions

function update_admin_users($uid,$rights,$password,$emailid,$epassword,$host,$portno,$a_ipaddress,$todaydt,$outside)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("update admin set userType='$rights',password='$password',emailid='$emailid',emailpwd='$epassword',host='$host',port='$portno',a_ipaddress='$a_ipaddress',dt='$todaydt',outside='$outside' where id=?");
   $stmt->execute(array($uid));
   //return $stmt->fetch(PDO::FETCH_ASSOC);
}


function find_admin_usersbyid($uid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from admin where id=?");
   $stmt->execute(array($uid));
   return $stmt->fetch(PDO::FETCH_ASSOC);
}


function find_admin_users($username,$rights)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from admin where username=? and userType=?");
   $stmt->execute(array($username,$rights));
   return $stmt->rowCount();
}


function list_admin_users()
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from admin order by id");
   $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);


}

function create_admin_users($rights,$username,$password,$emailid,$epassword,$host,$portno,$todaydt,$a_ipaddress,$outside)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into admin(userType,username,password,emailid,emailpwd,host,port,dt,a_ipaddress,outside) value (?,?,?,?,?,?,?,?,?,?)");
   $stmt->execute(array($rights,$username,$password,$emailid,$epassword,$host,$portno,$todaydt,$a_ipaddress,$outside));
   //return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//
//edit quote functions

function get_crndata()
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from crn order by crn_id desc limit 0,1");
   $stmt->execute();
   return $stmt->fetch(PDO::FETCH_ASSOC);

}


function create_admin_user($username,$password,$email)
{
$pdo = pdo_db();
$stmt= $pdo->prepare("insert into admin(username,password,emailid) values(?,?,?)");
$stmt->execute(array($username,$password,$email));
//$stmt->execute();

}
//$quotedetails =create_admin_user('jugal','rathod','test@testmail.com');
//var_dump($quotedetails);

function get_quotedetail($refid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * from quotations where qt_refid=?");
    $stmt->execute(array($refid));
    $stmt->execute();
   return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function save_edited_quote($refid,$generatedby,$generatedon,$quotedata)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_edited(refid,generatedby,generatedon,quotedata) values(?,?,?,?)");
    $stmt->execute(array($refid,$generatedby,$generatedon,$quotedata));
return $pdo->lastInsertId();
   // $stmt->execute();
  // return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function list_edited_quote($refid)
{
  $pdo = pdo_db();
if($refid!='')
{
    $stmt = $pdo->prepare("SELECT * from quote_edited where refid=?");
    $stmt->execute(array($refid));
}
else
{
 $stmt = $pdo->prepare("SELECT * from quote_edited where 1");
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
    $stmt = $pdo->prepare("SELECT * from quote_edited where id=?");
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
    $stmt = $pdo->prepare("SELECT * from quote_product where qt_refid=?");
    $stmt->execute(array($refid));
    $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


//add quote functions
function quote_contactactivity($ca_userid,$ca_activity,$ca_activity_details,$ca_dbtype,$ca_date)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_contactactivity (ca_userid,ca_activity,ca_activity_details,ca_dbtype,ca_date) values (?,?,?,?,?)");
    $stmt->execute(array($ca_userid,$ca_activity,$ca_activity_details,$ca_dbtype,$ca_date));
   // $stmt->execute();

}


function update_crn($qt_stseq,$up_refid,$qt_createdby,$todaydt,$crn_id)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("update crn set crn_stseq ='$qt_stseq',crn_prefix='$up_refid',crn_updatedby='$qt_createdby',crn_updatedt='$todaydt' where crn_id=?");
    $stmt->execute(array($crn_id));
 // $stmt->execute();

}

function insert_quote($qt_organisationid,$qt_contacts,$qt_subject,$qt_refid,$qt_tnc,$qt_addinfo,$qt_currency,$qt_itemtotal,$qt_discount,$qt_discountpercent,$qt_shipping_charges,$qt_pretax_total,$qt_tax,$qt_adj_add,$qt_adj_sub,$qt_grandtotal,$qt_createdby,$qt_createddt,$qt_updatedby,$qt_updateddt)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quotations (qt_organisationid,qt_contacts,qt_subject,qt_refid,qt_tnc,qt_addinfo,qt_currency,qt_itemtotal,qt_discount,qt_discountpercent,qt_shipping_charges,qt_pretax_total,qt_tax,qt_adj_add,qt_adj_sub,qt_grandtotal,qt_createdby,qt_createddt,qt_updatedby,qt_updateddt) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    


$stmt->execute(array($qt_organisationid,$qt_contacts,$qt_subject,$qt_refid,$qt_tnc,$qt_addinfo,
$qt_currency,$qt_itemtotal,$qt_discount,$qt_discountpercent,$qt_shipping_charges,$qt_pretax_total,$qt_tax,$qt_adj_add,$qt_adj_sub,$qt_grandtotal,$qt_createdby,$qt_createddt,$qt_updatedby,$qt_updateddt));
   // $stmt->execute();



}

function update_quote($qt_organisationid,$qt_contacts,$qt_subject,$qt_tnc,$qt_addinfo,$qt_cur,$qt_itemtotal,$qt_discount,$qt_discountpercent,$qt_shipping_charges,$qt_pretax_total,$qt_tax,$qt_adj_add,$qt_adj_sub,$qt_grandtotal,$qt_updatedby,$qt_updateddt,$up_qt_refid)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("update quotations set qt_organisationid='$qt_organisationid',qt_contacts='$qt_contacts',qt_subject='$qt_subject',qt_tnc='$qt_tnc',qt_addinfo='$qt_addinfo',qt_currency='$qt_cur',qt_itemtotal='$qt_itemtotal',qt_discount='$qt_discount',qt_discountpercent='$qt_discountpercent',qt_shipping_charges='$qt_shipping_charges',qt_pretax_total='$qt_pretax_total',qt_tax='$qt_tax',qt_adj_add='$qt_adj_add',qt_adj_sub='$qt_adj_sub',qt_grandtotal='$qt_grandtotal',qt_updatedby='$qt_updatedby',qt_updateddt='$qt_updateddt' where qt_refid=?");
    
$stmt->execute(array($up_qt_refid));
   // $stmt->execute();



}




function insert_quote_org($org_name,$org_primaryemail,$org_billingadd,$org_billingcity,$org_billingstate)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_organisation(org_name,org_primaryemail,org_billingadd,org_billingcity,org_billingstate) values (?,?,?,?,?)");
   $stmt->execute(array($org_name,$org_primaryemail,$org_billingadd,$org_billingcity,$org_billingstate));
   // $stmt->execute();
return $pdo->lastInsertId();
}
function insert_quote_contact($cont_sal,$cfname,$clname,$cemail)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_contacts(cont_sal,cont_firstname,cont_lastname,cont_primaryemail) values (?,?,?,?)");
    $stmt->execute(array("$cont_sal","$cfname","$clname","$cemail"));
   // $stmt->execute();
return $pdo->lastInsertId();

}
//$contid = insert_quote_contact('ii','uj','jj','ll');
//echo "sdfdsfsd".$contid;
function insert_quote_tax($qt_refid,$qt_taxname,$qt_taxvalue,$todaydt)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_tax (qt_refid,qt_taxname,qt_taxvalue,qt_taxdt) values (?,?,?,?)");
    $stmt->execute(array($qt_refid,$qt_taxname,$qt_taxvalue,$todaydt));
   // $stmt->execute();

}

function delete_quote_taxes($qt_refid)
{
$pdo = pdo_db();
    $stmt = $pdo->prepare("delete from quote_tax where qt_refid=?");
    $stmt->execute(array($qt_refid));
}
function quote_taxes_forquote($qt_refid)
{
$pdo = pdo_db();
    $stmt = $pdo->prepare("select * from quote_tax where qt_refid=?");
     $stmt->execute(array($qt_refid));
    $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function delete_quote_product($qt_refid)
{

  $pdo = pdo_db();
    $stmt = $pdo->prepare("delete from quote_product where qt_refid=?");
    $stmt->execute(array($qt_refid));
   // $stmt->execute();
//$inid = $pdo->lastInsertId();

}
function insert_quote_product($qt_refid,$qt_product_sku,$qt_product_name,$qt_product_desc,$qt_product_qty,$qt_selling_price,
$qt_product_spec_show)
{
 $pdo = pdo_db();
    $stmt = $pdo->prepare("insert into quote_product (qt_refid,product_sku,product_name,product_desc,product_quantity,product_sellingprice,product_spec_show) values (?,?,?,?,?,?,?)");

$stmt->execute(array($qt_refid,$qt_product_sku,$qt_product_name,$qt_product_desc,$qt_product_qty,$qt_selling_price,
$qt_product_spec_show));
   // $stmt->execute();
   //return $stmt->fetchAll(PDO::FETCH_ASSOC)

}
function quote_emaillogs($refid)
{

  $pdo = pdo_db();
    $stmt = $pdo->prepare("select count(*) as ref_count from quote_emaillogs where el_refid=?");
    $stmt->execute(array($refid));
  //  $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function contact_details($contid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from quote_contacts where cont_id=?");
    $stmt->execute(array($contid));
   // $stmt->execute();
   return $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function select_taxes()
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from tax_cal where tax_status='active'");
    $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_quotelist($username,$start,$end)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from admin where username=?");
    $stmt->execute(array($username));
 //   $stmt->execute();
   $udetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
$str ='';
//echo $start;
if($start!='')
{
$str .=" limit $start , $end" ;
//echo "888".$str;
}

if($udetails[0]['userType']=="users")
{
  $stmt = $pdo->prepare("select * from quotations where qt_createdby='$username' order by qt_id desc $str");
}
else
{
 $stmt = $pdo->prepare("select * from quotations order by qt_id Desc $str");
}
$stmt->execute();
 return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//$pagdata = get_quotelist($username,'0','8');
//var_dump($pagdata);
function admindetails_byusername($username)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from admin where username=?");
    $stmt->execute(array($username));
  //  $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function select_taxdetails($taxid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from tax_cal where tax_id=?");
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
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` where org_id=?");
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
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function get_organisation_byname($orgname)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` where org_name=?");
    $stmt->execute(array($orgname));

   return $stmt->rowCount();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function get_organisation_byemail($orgemail)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT org_id,org_name FROM `quote_organisation` where org_primaryemail=?");
    $stmt->execute(array($orgemail));

   return $stmt->rowCount();
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_product_attributes($proid)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select b.name,a.value from product_productattribute a, product_attributeoption b,product_product pp where a.option_id=b.id and a.product_id =pp.id and pp.sku =? order by a.id limit 0,4");
$stmt->execute(array($proid));

  //  $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_productdetails_bysku($sku)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * from product_product where sku =?");
    $stmt->execute(array($sku));
   // $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}


//$dats = get_product_attributes(2880);
//var_dump($dats);

function get_products()
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `product_product`");
    $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_contacts_byemail($cemail)
{
  $pdo = pdo_db();
    $stmt = $pdo->prepare("select * from quote_contacts where  cont_primaryemail=? or cont_secondaryemail=?");
    $stmt->execute(array($cemail,$cemail));
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
    $stmt = $pdo->prepare("SELECT cont_id,cont_sal,cont_firstname,cont_lastname FROM `quote_contacts` where cont_orgid=?");
$stmt->execute(array($orgid));
 return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//$dats = get_organisation();
//foreach($dats as $value)
//{
//echo $value['org_name'];

//}
//var_dump($dats);
?>