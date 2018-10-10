<?php
class Home extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->library('session');
		$this->load->model('Mymodel');
	}

	function index(){ 
        $data['sections'] = $this->Mymodel->get_sections();
        $data['random_product_list'] = $this->Mymodel->get_random_product();
		$data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
		$data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
		$data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
		$data['footer_cat']		= $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
		$this->load->view('header', $data);
		$this->load->view('index');
		$this->load->view('footer');
    }
    function all_products(){
        $data['categories']		 = $this->Mymodel->get_parent_categories();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
		$data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
		$data['footer_cat']		= $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
		$data['random_product_list'] = $this->Mymodel->get_random_product();
		$data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
		$data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
		$this->load->view('header', $data);
		$this->load->view('allproducts');
		$this->load->view('footer');
    }
	function routes(){
        $page_url = $this->uri->segment_array();
        $last = end($page_url);
        // echo $last; die;
        $count = count($page_url);
        $sku = $page_url[1];
        $ex = (explode("-",$sku));
        $name_count = count($ex);
        $sku = $ex[$name_count-2].'-'.$ex[$name_count-1];
         $msg = $this->Mymodel->check_routes($last,$sku);
		if($msg == 1){
            // echo $last; die;
                return $this->products_description($last);
            } 
            elseif($msg == 2){
                return $this->products_description($sku);   
		}
		else
		{
			return $this->catrgories_products_list($page_url);
        }
    }
    
  function a_z_products(){
    $data['sections'] = $this->Mymodel->get_sections();
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['footer_cat'] = $this->Mymodel->get_footer_cat();
    $data['footer_prod'] = $this->Mymodel->get_footer_prod();
    $this->load->view('header',$data);
    $data['cat'] = $this->Mymodel->get_a_to_z();
   $this->load->view('all-products', $data);
}
    function page_not_found(){
        $data['categories']		 = $this->Mymodel->get_parent_categories();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
		$data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
		$data['footer_cat']		= $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
		$data['random_product_list'] = $this->Mymodel->get_random_product();
		$data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
		$data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
        $this->load->view('header',$data);
        $this->load->view('404',$data);
        //$this->load->view('footer',$data);
    }
	function catrgories_products_list($page_url){
        // print_r($page_url); die;
		$get_page_url = $this->uri->segment_array();
		$link_count = count($get_page_url);
		if($link_count == 1){
        $page_url = $get_page_url[1];
        // echo $page_url; die;
        $id = $this->Mymodel->get_cat_id($page_url);
        $main_id = $id[0]['id'];
        //
		$data['cat_data'] = $id[0];
		$sub_cat_id = $this->Mymodel->get_cat_products_list($main_id);
        $data['sub_cat_list'] = $sub_cat_id;
		$data['products_list'] = $this->Mymodel->all_cat_products_list($main_id);
	}
	if($link_count == 2){
        $page_url = $get_page_url[2];
        // echo $page_url; die;
        $id = $this->Mymodel->get_cat_id($page_url);
        // print_r($id); die;
        $main_id = $id[0]['id'];
        // echo $main_id; die;
		$data['cat_data'] = $id[0];
		$data['sub_cat_list'] = $this->Mymodel->get_cat_products_list($main_id);
        $data['products_list'] = $this->Mymodel->all_sub_cat_products_list($main_id);

	}
	if($link_count == 3){
		$page_url =  $get_page_url[3];
        $id = $this->Mymodel->get_cat_id($page_url);
        // echo '<pre>';
        // print_r($id); die;
		$main_id = $id[0]['id'];
		$data['cat_data'] = $id[0];
		$data['sub_cat_list'] = $this->Mymodel->get_cat_products_list($main_id);
		$data['products_list'] = $this->Mymodel->all_sub_cat_products_list($main_id);
	}
   //header start
   $data['product_name'] = $this->Mymodel->product_name($main_id);
//    $data['sections'] = $this->Mymodel->get_sections();
   $data['sections'] = $this->Mymodel->get_sections();
   $data['all_categories'] = $this->Mymodel->get_all_categories();
   $data['product_category'] = $this->Mymodel->product_by_category();
   $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
   $data['footer_cat']		= $this->Mymodel->get_footer_cat();
   $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
   $data['all_categories'] = $this->Mymodel->get_all_categories();
   $data['product_category'] = $this->Mymodel->product_by_category();
   $data['title'] = $this->uri->segment_array();
   if($data['products_list'][0]['description']){
   $data['meta'] = $data['products_list'][0]['description'];
   $data['keywords'] = $data['products_list'][0]['head_title'];
   }
//    if(empty($main_id)){
//     return $this->page_not_found();
//    }
//    else{
   // header end
//    print_r($data['products_list']); die;

   $data['breadcrumb'] = $this->uri->segment_array();
   $data['footer_cat'] = $this->Mymodel->get_footer_cat();
   $data['footer_prod'] = $this->Mymodel->get_footer_prod();
//    echo '<pre>';
//    print_r($data);   

   $this->load->view('header',$data);
   $this->load->view('productlist');
   $this->load->view('footer');
    // }
}

function products_description($sku){
    // $data['product_category'] = $this->Mymodel->product_by_category();
    // print_r($page_url); exit;
    $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
    $data['footer_cat']		= $this->Mymodel->get_footer_cat();
    $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
    // if($sku){
        $product_sku = $sku;
    // }
    // else{
    //     $product_sku = end($page_url);
    // }
  
     $data['sections'] = $this->Mymodel->get_sections();
    $data['products_list'] = $this->Mymodel->products_list_data($product_sku);
    // print_r($data['products_list']); die;
    $product_cat_id = $data['products_list']['category_id'];
    $data['related_product'] = $this->Mymodel->get_related_products($product_cat_id);
    //header start

    $data['title'] = $this->uri->segment_array();
    $data['meta'] = $data['products_list']['description'];
    $data['keywords'] = $data['products_list']['head_title'];
    $this->load->view('header',$data);
    $this->load->view('product');
	$this->load->view('footer');
  }

    function get_subcat(){
      $id = $this->input->post('id');
      $res['sub_list'] = $this->Mymodel->get_sub_cat_list($id);
      $this->load->view('sub_cat_view', $res);
      $this->load->view('footer');
    }

  function register(){
    $data['sections'] = $this->Mymodel->get_sections();
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['footer_cat'] = $this->Mymodel->get_footer_cat();
    $data['footer_prod'] = $this->Mymodel->get_footer_prod();
    $this->load->view('header',$data);
    $this->load->view('register');
	$this->load->view('footer');
  }
  function insert_user_data(){
    $data = array(
      'username' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'password' => $this->input->post('password')
    );
    $this->Mymodel->insert_user_data($data);
    $this->session->set_flashdata('suc_reg', 1);
    redirect('');
  }

  function login(){
    $data['sections'] = $this->Mymodel->get_sections();
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['footer_cat'] = $this->Mymodel->get_footer_cat();
    $data['footer_prod'] = $this->Mymodel->get_footer_prod();
    $this->load->view('header',$data);
    $this->load->view('login');
    // $this->load->view('footer');
  }

  function check_login(){
     $email = $this->input->post('email');
     $password = $this->input->post('password');
     $res = $this->Mymodel->check_user($email,$password);
     if($res['msg'] == 1){
       $this->session->set_userdata('id', $res['data']['0']['id']);
       $this->session->set_userdata('name', $res['data']['0']['username']);
       $this->session->set_flashdata('suc_login', 1);
       redirect('');
     }
     else{
       $this->session->set_flashdata('err_login', 2);
       redirect('');
     }
  }
  function logout(){
    $this->session->unset_userdata('id');
    $this->session->set_flashdata('logout', 2);
    redirect('');
  }

  function search_products(){
    // $data['categories']		 = $this->Mymodel->get_parent_categories();
    $data['sections'] = $this->Mymodel->get_sections();
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
    $data['footer_cat']		= $this->Mymodel->get_footer_cat();
    $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
      $res['page_url'] = $this->uri->segment_array();
      $user_input = $this->input->get('search');
      $product = $this->Mymodel->search_product_by_key($user_input);
      $category = $this->Mymodel->search_category_by_key($user_input);
      if($product){
        $data['searched_products'] = $product; 
      }
      if($category){
        $data['searched_category'] = $category; 
      }
      $data['search_key'] = $user_input;
      $this->load->view('header', $data);
      $this->load->view('search_products');
      $this->load->view('footer');
    }

  function about_us(){
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
    $data['footer_cat']		= $this->Mymodel->get_footer_cat();
    $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
    $data['sections'] = $this->Mymodel->get_sections();

    $data['footer_cat'] = $this->Mymodel->get_footer_cat();

    $data['footer_prod'] = $this->Mymodel->get_footer_prod();

    $this->load->view('header',$data);
    $this->load->view('aboutus');
    $this->load->view('footer');
  }
  function contact_us(){
    $data['all_categories'] = $this->Mymodel->get_all_categories();
    $data['product_category'] = $this->Mymodel->product_by_category();
    $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
    $data['footer_cat']		= $this->Mymodel->get_footer_cat();
    $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
    $data['sections'] = $this->Mymodel->get_sections();
    $data['footer_cat'] = $this->Mymodel->get_footer_cat();
    $data['footer_prod'] = $this->Mymodel->get_footer_prod();
    $this->load->view('header',$data);
    $this->load->view('contactus');
    $this->load->view('footer');
  }
  function mypdf(){
    $this->load->library('pdf');
    $this->pdf->load_view('mypdf');
    $this->pdf->render();
    $this->pdf->stream("welcome.pdf");
}

function send_enquiry(){
    $this->load->library('email');
    $name = $this->input->post('name');
    $number = $this->input->post('mobile');
    $email = $this->input->post('email');
    $message = $this->input->post('message');
    $location = $this->input->post('location');

    $msg_body  ='<style type="text/css">

                </style>

                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">

                <div class="table-responsive">

                    <h1 style="text-align:center;">Quotation Request From <a style="color:#007f96;" href="www.mednom.com">mednom.com</a></h1>

                    <br>

                    <table class="table ">

                      <tr>

                          <td>

                              <h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$product.'">' . $product . '</a></h3>

                          </td>

                      </tr>

                        <tr>

                            <td>

                                <h3><b>Name : </b>' . $name . '</h3>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                <h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$email.'">' . $email . '</a></h3>

                            </td>

                        </tr>





                        <tr>

                            <td>

                                <h3>

                                    <b>Location : <span style="color:green;">'.$location.'</span></b>

                                </h3>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                <h3><b>Subject : </b>' . $subject . '</h3>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                <h3><b>Message : </b>' . $message . '</h3>

                            </td>

                        </tr>

                    </table>

                </div>  ';

    $headSubject = 'Product Quote - www.mednom.com';

    $to = 'info@mednom.com';

    $cc = 'info@pcdex.com';

    $from = $email;

    $headers = "MIME-Version: 1.0" . "\r\n";

    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers

    $headers .= 'From:' . $from . "\r\n";

    $headers .= 'Cc:' . $cc . "\r\n";

    if(mail($to,$headSubject,$msg_body,$headers)){

        $data['sent_fare_quote'] = 'Thank you for contacting us, we will get back to you soon';

    }else {

        $data['sent_fare_quote_err'] = 'Something went wrong, please try again!';

    }

    $this->session->set_flashdata('suc_send', 1);

    redirect('');

  }





  function send_quote(){
    print_r($_POST); die;

      $this->load->library('email');

      $product = $this->input->post('product');

      $name = $this->input->post('name');

      $email = $this->input->post('email');

      $subject = $this->input->post('subject');

      $message = $this->input->post('message');

      $location = $this->input->post('location');

      $msg_body  ='<style type="text/css">

                  </style>

                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">

                  <div class="table-responsive">

                      <h1 style="text-align:center;">Quotation Request From <a style="color:#007f96;" href="www.mednom.com">mednom.com</a></h1>

                      <br>

                      <table class="table ">

                        <tr>

                            <td>

                                <h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$product.'">' . $product . '</a></h3>

                            </td>

                        </tr>

                          <tr>

                              <td>

                                  <h3><b>Name : </b>' . $name . '</h3>

                              </td>

                          </tr>

                          <tr>

                              <td>

                                  <h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$email.'">' . $email . '</a></h3>

                              </td>

                          </tr>





                          <tr>

                              <td>

                                  <h3>

                                      <b>Location : <span style="color:green;">'.$location.'</span></b>

                                  </h3>

                              </td>

                          </tr>

                          <tr>

                              <td>

                                  <h3><b>Subject : </b>' . $subject . '</h3>

                              </td>

                          </tr>

                          <tr>

                              <td>

                                  <h3><b>Message : </b>' . $message . '</h3>

                              </td>

                          </tr>

                      </table>

                  </div>  ';

      $headSubject = 'Product Quote - www.mednom.com';

      $to = 'info@mednom.com';

      $cc = 'info@pcdex.com';

      $from = $email;

      $headers = "MIME-Version: 1.0" . "\r\n";

      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers

      $headers .= 'From:' . $from . "\r\n";

      $headers .= 'Cc:' . $cc . "\r\n";

      if(mail($to,$headSubject,$msg_body,$headers)){

          $data['sent_fare_quote'] = 'Thank you for contacting us, we will get back to you soon';

      }else {

          $data['sent_fare_quote_err'] = 'Something went wrong, please try again!';

      }

      $this->session->set_flashdata('suc_send', 1);

      redirect('');

    }





    function buildTree($elements = array(), $parentId = 0)

	{

        $branch = array();

        foreach ($elements as $element) {

            if ($element['parent_id'] == $parentId) {

                $children = $this->buildTree($elements, $element['id']);

             if ($children) {

                    $element['children'] = $children;

                }

                $branch[] = $element;

            }

        }

        return $branch;

    } 



    

	// function Catalogs(){

	// 	$categories	 = $this->Mymodel->get_parent_categories();

	// 	$footer_cat	 = $this->Mymodel->get_footer_cat();

	// 	$footer_prod	 = $this->Mymodel->get_footer_prod();
    //     $all_categories = $this->Mymodel->get_all_categories();
    //     $product_category = $this->Mymodel->product_by_category();
	// 	// $this->load->view('header', $data);

    //     // $this->load->view('catalog');

    //     $all_categories = $this->Mymodel->retrieve('categories', '*',

    //     array('where' => array('inactive' => 0)),

    //     array('orderby' => array('SUBSTR(name FROM 1 FOR 1),CAST(SUBSTR(name FROM 2) AS UNSIGNED)')));

    // $session_categories = $this->buildTree($all_categories);

    // foreach ($session_categories as $key => $parent)

    // {

    //     if (isset($parent['children']))

    //     {

    //         foreach ($parent['children'] as $id => $child){

    //             $get_products = $this->Mymodel->retrieve('products', '*', array('where' => array('category_id' => $child['id'])));

    //             if (!empty($get_products[0]['catalog_url'])) 

    //             {

    //                 $catalog_url = $get_products[0]['catalog_url'];

    //             }

    //             else

    //             {

    //                 $catalog_url = "";

    //             }

    //             $session_categories[$key]['children'][$id]['catalog_url'] = $catalog_url;

    //         }

    //     }

    //     else

    //     {

    //         $get_products = $this->Mymodel->retrieve('products', '*', array('where' => array('category_id' => $parent['id'])));

    //         if (!empty($get_products[0]['catalog_url']))

    //         {

    //             $catalog_url = $get_products[0]['catalog_url'];

    //         }

    //         else

    //         {

    //             $catalog_url = "";

    //         }

    //         $session_categories[$key]['catalog_url'] = $catalog_url;

    //     }

    // }

    // $main_cat = $this->Mymodel->get_main_categories();

    // $rand_prod = $this->Mymodel->get_random_products();

    // $title = "Catalogs | Labonics";

    // $description = "Labonics offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";

    // $keyword = str_replace('|',',',$title);

    // $this->load->view('catalog', array('product_category' => $product_category , 'all_categories' => $all_categories , 'footer_prod' => $footer_prod , 'footer_cat' => $footer_cat , 'categories' => $categories, 'session_categories' => $session_categories , 'main_cat' => $main_cat, 'title' => $title, 'description' => $description, 'keyword' => $keyword, 'rand_prod' => $rand_prod));

    // }

    





    function catalogs(){
        $sku = $this->uri->segment(2); 

        $data['product'] = $this->Mymodel->get_data_for_catalog_by_sku($sku);
		// /* echo "<pre>";
		// print_r($data['product']);die; */
		// $data['main_cat'] = $this->general_model->get_main_categories();
		// $data['rand_prod'] = $this->general_model->get_random_products();
		// $data['main_section'] = $this->general_model->get_main_section();
		// $data['title'] = "Catalog | Labonics";
		// $data['description'] = "Labonics is a recognized global leader of Laboratory furniture, Laminar Airflow cabinets, Bio Safety Cabinets, Fume hoods, Safety containment cabinets etc.";
        // $data['keyword'] = str_replace('|',',',$title);
        $data['footer_cat']		 = $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
        $data['sections'] = $this->Mymodel->get_sections();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
        $this->load->view('catalog', $data);
        // echo 'hello';
	}









	public function compare() {

			$ids = '';

			if ($this->input->get('product_id')) {

					$ids = explode(',', $this->input->get('product_id'));

			}

	// print_r($ids);

			$results = $this->db->where_in('id', $ids)

					->order_by('name')

					->group_by('id')

					->get('products')

					->result_array();

			$keys = array();

			$uni = array();

			foreach ($results as $row) {

					$spec = json_decode($row['specifications'], true);

					foreach ($spec as $key => $value) {

							if (!in_array($key, $uni)) {

									$uni[] = $key;

							}

					}

			}

			foreach ($results as $row) {

					$spec = json_decode($row['specifications'], true);

					foreach ($uni as $k) {

							if (!isset($spec[$k])) {

									$keys[$k]['child'][] = "&mdash;";

							} else {

									$keys[$k]['child'][] = $spec[$k];

							}

					}



			}

			// echo '<pre>';

			// print_r ($keys);

			// Print_r ($results);

			// $this->load->title('Products Comparision | Lab Equipment');

            $data['sections'] = $this->Mymodel->get_sections();

			

			$data['footer_cat'] = $this->Mymodel->get_footer_cat();

			$data['footer_prod'] = $this->Mymodel->get_footer_prod();

			$this->load->view('header',$data);

            $this->load->view('compare',array('keys' => $keys, 
                                                'sections' => $data['sections'],
                                             'products' => $results));

			 $this->load->view('footer');

	}

}

?>

