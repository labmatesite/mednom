<?php
class Mymodel extends CI_Model{
function get_sections(){

  $this->db->select('*');

  // $this->db->where('parent_id', 0);

  // $this->db->where('inactive', 0);

  $query = $this->db->get('sections');

  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}



function get_sub_cat($cat_name){
  $this->db->select('*'); 
  $this->db->where('section', $cat_name); 
  $query = $this->db->get('categories'); 
  // echo $this->db->last_query(); die;
  $res = $query->result_array(); 
  return $res; 
}










function get_data_for_catalog_by_sku($data){ 
  $this->db->select('*'); 
  $this->db->where('sku', $data); 
  $query = $this->db->get('products'); 
  $res = $query->result_array(); 
  return $res; 
}

function all_products_cat($id){
  $this->db->select('*');
  $this->db->where('parent_id', $id);
  $this->db->where('inactive', 0);
  $query = $this->db->get('categories');
  $res = array();
  if($query->num_rows() > 0){
    $res['data'] = $query->result_array();
    $res['msg'] = 1;
  }
  else{
    $res['msg'] = 0;
  }
  return $res;
}

function get_all_categories(){

  $this->db->select('c.*');

  $this->db->where('c.inactive', 0);

  $this->db->distinct();

  $this->db->order_by('c.name', 'ASC');

  $this->db->from('categories as c');

  $this->db->join('products as p', 'p.category_id = c.id');

  $query = $this->db->get();

  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function product_by_category(){
  $this->db->select('*');
  $this->db->where('level', 1);
  $this->db->order_by('name', 'ASC');
  $this->db->where('inactive', 0);
  $query = $this->db->get('categories');
  $res = "";
  if($query->num_rows() > 0){
    $res = $query->result_array();
  }
  return $res;
}

function get_random_home_data(){
  $this->db->select('*');
  // $this->db->order_by('title', 'random');
  $this->db->where('inactive', 0);
  $query = $this->db->get('categories');
  $res = "";
  if($query->num_rows() > 0){
    $res = $query->result_array();
  }
  return $res;
 }


 function get_footer_cat(){
   $this->db->select('*');
   $this->db->where('inactive', 0);
   $this->db->order_by('title', 'random');
   $this->db->limit(10);
   $query = $this->db->get('categories');
   $res = "";
   if($query->num_rows() > 0){
     $res = $query->result_array();
   }
   return $res;
 }

 function get_footer_prod(){

   $this->db->select('*');

   $this->db->where('inactive', 0);

   $this->db->order_by('title', 'random');

   $this->db->limit(4);

   $query = $this->db->get('products');

   $res = "";

   if($query->num_rows() > 0){

     $res = $query->result_array();

   }

   return $res;

 }









 function get_random_product(){

  $this->db->select('*');

  $this->db->order_by('title', 'RANDOM');

  $this->db->limit(10);

  $query = $this->db->get('products');

  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function get_random_product_1(){

  $this->db->select('*');

  $this->db->order_by('title', 'RANDOM');

  $this->db->limit(10);

  $query = $this->db->get('products');

  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function get_random_product_2(){

  $this->db->select('*');

  $this->db->order_by('title', 'RANDOM');

  $this->db->limit(10);

  $query = $this->db->get('products');



  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function product_name($main_id){

   $this->db->select('name');

   $this->db->where('inactive', 0);

   $this->db->where('id', $main_id);

   $query = $this->db->get('categories');

   $res = "";

   if($query->num_rows() > 0){

     $res = $query->result_array();

   }

   return $res;

}

 function get_cat_id($page_url){
   $this->db->select('*');
   $this->db->where('url_title', $page_url);
   $this->db->where('inactive', 0);
   $query = $this->db->get('categories');
  //  echo $this->db-last_query();
   $res = "";
   if($query->num_rows() > 0){
     $res = $query->result_array();
   }
   else{
     $url = str_replace('-',' ',$page_url);
     $this->db->select('*');
    $this->db->where('section', $url);
    $this->db->where('inactive', 0);
    $query = $this->db->get('categories');
    $res = $query->result_array();
   }
   return $res;
 }

 function get_prod_img($id){
  $this->db->select('image_urls');
  $this->db->where('category_id', $id);
  $query = $this->db->get('products');
  return $query->result_array();
 }

 function get_related_prod_1(){
   $this->db->select('*');
   $this->db->limit(4);
   $this->db->where('inactive', 0);
   $this->db->order_by('id', 'RANDOM');
   $query = $this->db->get('products');
   return $query->result_array();
 }

 function get_related_prod_2(){
   $this->db->select('*');
   $this->db->limit(4);
   $this->db->where('inactive', 0);
   $this->db->order_by('id', 'RANDOM');
   $query = $this->db->get('products');
   return $query->result_array();
 }

 function get_related_prod_3(){
   $this->db->select('*');
   $this->db->limit(4);
   $this->db->order_by('id', 'RANDOM');
   $query = $this->db->get('products');
   return $query->result_array();
 }

 function all_cat_products_list($cat_id){
   $this->db->select('ca.name sub_name , ca.page_url sub_url, ca.id sub_id,  ca.meta_description, p.*');
   $this->db->where('c.parent_id', $cat_id);
   $this->db->where('ca.inactive', 0);
   $this->db->from('categories as c');
   $this->db->join('categories as ca' , 'c.id = ca.parent_id', 'self');
   $this->db->join('products as p', 'ca.id = p.category_id', 'left');
   $query = $this->db->get();
   $res = "";
   if($query->num_rows() > 0){
     $res = $query->result_array();
  }
   else{
     $this->db->select('c.name sub_name , c.page_url sub_url, c.id sub_id,  c.meta_description, p.*');
     $this->db->where('parent_id', $cat_id);
     $this->db->where('c.inactive', 0);
     $this->db->from('categories as c');
     $this->db->join('products as p', 'c.id = p.category_id', 'left');
     $query = $this->db->get();
     if($query->num_rows() > 0){
     $res = $query->result_array();
      }
       else{
         $this->db->select('*');
         $this->db->where('inactive', 0);
         $this->db->where('category_id', $cat_id);
         $query = $this->db->get('products');
         $res =  $query->result_array();
       }
     }
   return $res;
 }

 function all_sub_cat_products_list($main_id){
   $this->db->select('*');
   $this->db->where('category_id', $main_id);
   $this->db->order_by('sku', 'ASC');
   $this->db->where('inactive', 0);
   $query = $this->db->get('products');
   if($query->num_rows() > 0){
   $res = $query->result_array();
 }
 else{
   $this->db->select('c.name sub_name , c.page_url sub_url, c.id sub_id,  c.meta_description, p.*');
   $this->db->where('c.parent_id', $main_id);
   $this->db->order_by('sku', 'ASC');
   $this->db->where('c.inactive', 0);
   $this->db->from('categories as c');
   $this->db->join('products as p', 'c.id = p.category_id', 'left');
   $query = $this->db->get();
   $res = $query->result_array();
 }
   return $res;
 }
 function get_cat_products_list($main_id){
   $this->db->select('*');
   $this->db->where('inactive', 0);
   $this->db->where('parent_id', $main_id);
   $query = $this->db->get('categories');
   $res = "";
   if($query->num_rows() > 0){
     $res = $query->result_array();
   }
   return $res;
 }
function products_list_data($product_sku){
  $this->db->select('*');
  $this->db->where('url_title', $product_sku);
  $query = $this->db->get('products');
  $res = "";
  if($query->num_rows() > 0){
    foreach ($query->result_array() as $value) {
    $res = $value;
    }
  }
  return $res;
}
function get_related_products($product_cat_id){
  $this->db->select('*');
  $this->db->where('category_id', $product_cat_id);
  $this->db->limit(4);
  $query = $this->db->get('products');
  $res = "";
  if($query->num_rows() > 0){
    $res = $query->result_array();
  }
 return $res;
}

function search_product_by_key($user_input){

 $this->db->select('*');
  $this->db->like('name', $user_input);
  $this->db->limit(28);
  $query = $this->db->get('products');
  $res= "";
  if($query->num_rows() > 0){
    $res = $query->result_array();
  }
  return $res;
}
function search_category_by_key($user_input){
  $this->db->select('*');

  $this->db->like('name', $user_input);

  $this->db->limit(28);

  $query = $this->db->get('categories');

  $res= "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function get_sub_cat_list($id){

  $this->db->select('*');

  $this->db->where('inactive', 0);

  $this->db->where('parent_id', $id);

  $query = $this->db->get('categories');

  $res = "";

  if($query->num_rows() > 0){

    $res = $query->result_array();

  }

  return $res;

}

function get_a_to_z(){
  $this->db->select('c.*');
  $this->db->distinct('p.id');
  $this->db->from('products as p');
  $this->db->join('categories as c', 'p.category_id = c.id', 'left');
  $query = $this->db->get();
  $res = $query->result_array();
  return $res;
}


function get_side_sub_cat($id){
  $this->db->select('*');
  $this->db->where('inactive', 0);
  $this->db->where('parent_id', $id);
  $query = $this->db->get('categories');
  $res = array();
  if($query->num_rows() > 0){
    $res['data'] = $query->result_array();
    $res['msg'] = 1;
  }
  else{
    $res = 0;
  }
  return $res;
}


function insert_user_data($data){

  $this->db->insert('auth_user', $data);

  return true;

}

function check_user($email,$password){

   $this->db->select('*');

   $this->db->where('email',$email);

   $this->db->where('password', $password);

   $query = $this->db->get('auth_user');

   $res = array();

   if($query->num_rows() > 0){

     $res['data'] = $query->result_array();

     $res['msg'] = 1;

   }

   else{

     $res['msg'] = 0;

   }

   return $res;

 }

//  function get_random_product(){

//   $this->db->select('*');

//   $this->db->order_by('title', 'RANDOM');

//   $this->db->limit(8);

//   $query = $this->db->get('products');

//   $res = "";

//   if($query->num_rows() > 0){

//     $res = $query->result_array();

//   }

//   return $res;

// }

// function get_random_product_1(){

//   $this->db->select('*');

//   $this->db->order_by('title', 'RANDOM');

//   $this->db->limit(8);

//   $query = $this->db->get('products');

//   $res = "";

//   if($query->num_rows() > 0){

//     $res = $query->result_array();

//   }

//   return $res;

// }

// function get_random_product_2(){

//   $this->db->select('*');

//   $this->db->order_by('title', 'RANDOM');

//   $this->db->limit(8);

//   $query = $this->db->get('products');



//   $res = "";

//   if($query->num_rows() > 0){

//     $res = $query->result_array();

//   }

//   return $res;

// }

function check_routes($last,$sku){
  $this->db->select('url_title');
  $this->db->where('url_title', $last);
  $query = $this->db->get('products');
  $res = "";
  if($query->num_rows() > 0){
    $res = 1;
  }
  if($sku){
    $this->db->select('url_title');
    $this->db->where('url_title', $sku);
    $query = $this->db->get('products');
    if($query->num_rows() > 0){
      $res = 2;
    }
  }
  else{
    $res = 0;
  }
  return $res;
}

  function get_sub_cat_catalogs($id){

    $this->db->select('*');

    $this->db->where('parent_id', $id);

    $query = $this->db->get('categories');

    return $query->result_array();

    // $this->db->select('cb.name , p.catalog_url');

    // $this->db->where('ca.id', 2);

    // $this->db->from('categories as ca');

    // $this->db->join('categories as cb', 'ca.id = cb.parent_id', 'self');

    // $this->db->join('products as p', 'cb.id = p.category_id', 'right');

    // $query = $this->db->get();

    // $response = $query->result_array();

    // return $response;

  }

  function catalog($id){

    $this->db->select('catalog_url');

    $this->db->where('category_id', $id);

    $query = $this->db->get('products');

    $res = "";

    if($query->num_rows() > 0){

    $res = $query->result_array();

    }

    else{

    $this->db->select('p.*');

    $this->db->where('ca.id', $id);

    $this->db->from('categories as ca');

    $this->db->join('products as p', 'ca.id = p.category_id', 'left');

    $query = $this->db->get();

    $res = $query->result_array();

    }

    return $res;

  }







  function get_main_categories(){

		$this->db->select('*')->from('categories')->where('inactive',0)->where('parent_id',0);

		$query = $this->db->get();

		$response = array();

		if($query->num_rows() > 0){

			$response = $query->result_array();

		}

		return $response;

  }

  



  function get_random_products(){

		$this->db->select('*')->from('products');

		$this->db->order_by('id','RANDOM');

		$this->db->limit(20);

		$query = $this->db->get();

		$response = array();

		if($query->num_rows() > 0){

			$response = $query->result_array();

		}

		return $response;

	}





	function retrieve($tableName, $tableFields, $where = null, $order = null, $group = null, $limit = null)

    {

        if (is_array($tableFields)) {

            $fields = implode(',', $tableFields['fields']);

        } else {

            $fields = $tableFields;

        }

        $condition = '';

        if (!empty($where['where'])) {

            $condition = 'WHERE ';

            $lastKey = count($where['where']);

            $i = 0;

            foreach ($where['where'] as $key => $val) {

                $condition .= "`$key` = '$val'";

                if (count($where['where']) > 1) {

                    if (++$i !== $lastKey) {

                        $condition .= ' AND ';

                    }

                }

            }

        }

        if (!empty($where['where_in'])) {

            $condition = 'WHERE inactive=0 AND ';

            foreach ($where['where_in'] as $k => $v) {

                $arr = '"' . implode('","', $v) . '"';

                $condition .= $k . ' IN ' . '(' . $arr . ')';

            }



        }

        if (!empty($order['orderby'])) {

            if (is_array($order['orderby'])) {

                $order = 'ORDER BY ' . implode(',', $order['orderby']);

            } else {

                $order = 'ORDER BY ' . $order['orderby'];

            }

        }

        if (!empty($group['groupBy'])) {

            if (is_array($group['groupBy'])) {

                $order = 'GROUP BY ' . implode(',', $group['groupBy']);

            } else {

                $order = 'GROUP BY ' . $group['groupBy'];

            }

        }

        $lim = '';

        if (!empty($limit)) {

            $lim = 'LIMIT ' . $limit['limit'];

        }

        $query = "SELECT $fields FROM $tableName $condition $order $lim";

        $result = $this->db->query($query);

        return $result->result_array();

    }

    function get_first_cat($cat_name){

      $this->db->select('id');

      $this->db->where('name', $cat_name);

      $query = $this->db->get('categories');

      $res = $query->result_array();

      $id = $res[0]['id'];

      $this->db->select('*');

      $this->db->where('category_id', $id);

      $query = $this->db->get('products');

      return $query->result_array();

    }

    function get_secound_cat($cat_id ,$cat_name){
      $this->db->select('*');
      $this->db->where('name', $cat_name );
      $query = $this->db->get('categories');
      $res = $query->result_array();
      $id = $res[0]['id'];


    

      $this->db->select('id, name');
      $this->db->where('parent_id', $id);
      $query = $this->db->get('categories');
      $res = $query->result_array();
      $pid = $res['0']['id'];

      if(!empty($pid)){
        $prod_id = $pid;
      }
      else{
        $prod_id = $id;
      }


      $this->db->select('*');
      $this->db->where('category_id', $prod_id);
      $query = $this->db->get('products');
      $data = $query->result_array();
      $rr = array();
      $rr[0]['catalog_url'] = $data[0]['catalog_url'];
      $rr[0]['name'] = $cat_name;

      // print_r($rr);
      // exit;

       return $rr;

    }

  function get_catalog_cat($cat_id){
   $this->db->select('*');
   $this->db->where('parent_id', $cat_id);
   $this->db->where('inactive', 0);
   $query = $this->db->get('categories');
   if($query->num_rows() > 0){
   $res = $query->result_array();
    }
     return $res;
    // print_r ($res); die;
}
}

?>

