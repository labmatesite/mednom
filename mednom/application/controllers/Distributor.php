<?php
class Distributor extends CI_Controller{
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
		$data['categories']		 = $this->Mymodel->get_parent_categories();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
		$data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
		$data['footer_cat']		= $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
		$data['random_product_list'] = $this->Mymodel->get_random_product();
		$data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
        $data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
        // $data['title'] = "mednom | Lab Equipment | Scientific Instruments";
		$this->load->view('header', $data);
		$this->load->view('login');
		$this->load->view('footer');
	}
	function email_check(){
		// print_r($_POST); die;
		$email = $this->input->post('email');
		$this->db->select('*');
		$this->db->where('email', $email);
		$query = $this->db->get('auth_user');
		if($query->num_rows() > 0){
			$msg = 1;
		}
		else{
			$msg = 0;
		}
	echo $msg;
	}
	function dashboard(){
			if(!empty($this->session->userdata('role'))){
		$data['categories']		 = $this->Mymodel->get_parent_categories();
        $data['all_categories'] = $this->Mymodel->get_all_categories();
        $data['product_category'] = $this->Mymodel->product_by_category();
		$data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
		$data['footer_cat']		= $this->Mymodel->get_footer_cat();
		$data['footer_prod']	 = $this->Mymodel->get_footer_prod();
		$data['random_product_list'] = $this->Mymodel->get_random_product();
		$data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
		$data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
		$data['users'] = $this->Mymodel->distributor_list();
        $data['title'] = "mednom | Lab Equipment | Scientific Instruments";
		$this->load->view('header', $data);
		$this->load->view('admin_access');
		$this->load->view('footer');
			}
			else{
				redirect('Distributor');
			}
	}
	function activate(){
		$user_id = $this->uri->segment(2);
		$this->Mymodel->activate_user($user_id);
		 redirect('dashboard');
	}

	function disable(){
		$user_id = $this->uri->segment(2);
		$this->Mymodel->disable_user($user_id);
		redirect('dashboard');
	}

	function check_login(){
		// print_r($_POST); die;
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$res = $this->Mymodel->check_user($email,$password);
		// print_r($res); die;
		if($res['msg'] == 1){
		   if($res['data'][0]['role'] == 'user' && ($res['data'][0]['inactive'] === '0')){
				$this->session->set_userdata('id', $res['data']['0']['id']);
				$this->session->set_userdata('name', $res['data']['0']['username']);
				$this->session->set_flashdata('suc_login', 1);
				redirect('');
				//echo $this->session->flashdata('suc_login');
			}
			elseif ($res['data'][0]['role'] == 'user' && ($res['data'][0]['inactive'] === '1')){
			   $this->session->set_flashdata('suc_inlogin', 1);
			   redirect('Distributor');
			}
			elseif($res['data'][0]['role'] == 'admin'){
			$this->session->set_userdata('id', $res['data']['0']['id']);
			$this->session->set_userdata('name', $res['data']['0']['username']);
			$this->session->set_userdata('role', $res['data']['0']['role']);
			   redirect('dashboard');
			}
		}
		else{
		  $this->session->set_flashdata('err_login', 2);
		  redirect('Distributor');
		}
	 }
	 function logout(){
	   $this->session->unset_userdata('id');
	   $this->session->set_flashdata('logout', 2);
	   redirect('');
	 }
	 
	 function insert_user_data(){
        $this->load->library('email');
		$username = $this->input->post('name');
		$company = $this->input->post('company_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
   		$location = $this->input->post('myCountry');

    if($this->input->post('address')){
    $address = $this->input->post('address');
    }
    else{
      $address = 'not mention';
    }
    if($this->input->post('phone')){
      $phone = $this->input->post('phone');
      }
      else{
        $phone = 'not mention';
      }
		$data = array(
		  'username' => $this->input->post('name'),
		  'company_name' => $this->input->post('company_name'),
		  'email' => $this->input->post('email'),
		  'password' => $this->input->post('password'),
		  'address' => $this->input->post('address'),
		  'location' => $this->input->post('myCountry'),
		  'phone' => $this->input->post('phone')
    );

			$msg_body1  = '
			<h2 style="text-align:center">New Distributor Request : mednom </h2>
			<h3><span style="color:teal">Sign Up Request From </span>'.$email.'<h3>
			<h3><span style="color:teal">Contact Person </span>-'.$username.'<h3>
			<h3><span style="color:teal">Company Name </span>-'.$company.'<h3>
			<h3><span style="color:teal">Country </span>-'.$location.'<h3>
			<h3><span style="color:teal">Address </span>-'.$address.'<h3>
			<h3><span style="color:teal">Phone </span>-'.$phone.'<h3><br>';
			$this->email->from('info@mednom.com', 'mednom - Account Registration');
			$this->email->to('info@pcdex.com');
			$this->email->subject('Account Registration');
			$this->email->message($msg_body1);
			$this->email->send(); 
			$msg_body  ='<style type="text/css">
			</style>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">
			<h1 class="alert alert-info"> We Have Received Your Sign Up Request..<br>
											 Please Keep patience your Account is currently under review..! 
			</h1>';
		$this->email->from('info@mednom.com', 'mednom - Account Registration');
		$this->email->to($email);
		$this->email->subject('Account Registration');
		$this->email->message($msg_body);
		$this->email->send();	
		$this->Mymodel->insert_user_data($data);
		$this->session->set_flashdata('suc_reg', 1);
		redirect('');
	  }
	  function forgot_password(){
		 // $this->load->view('header');
		  $this->load->view('forgot_password');
    }
   function reset_password(){
			$rand = rand(100000,999999);
			$this->load->library('email');
			$email = $this->input->post('email');
			//echo '<br>'.$email;
			$this->db->select('*');
			$this->db->where('email', $email);
			$query = $this->db->get('auth_user');
			if($query->num_rows() > 0){
			$res = $query->result_array();
			$this->email->from('info@mednom.com', 'mednom - Reset Password');
			$this->email->to($email);

			$this->email->subject('Reset Password');
			$this->email->message('<h2>mednom Scientific Ltd Verify Your Account</h2><br><br>
			<h4 style="color:Teal">Your Otp is <span style="font-style: italic; color:#990000; font-weight:600;"> "'.' '.$rand.'"</span></h4><br>
			<h5 style="font-style: italic; color:red"> Do Not share this One Time Password with anyone else </h5>
			');
			$this->email->send(); 
			// print_r ($res);
			$id = $res[0]['id']; 
			$otp = $res[0]['otp'];
			$this->db->where('id', $id);
			$this->db->set('otp', $rand);
			$this->db->update('auth_user');
			$data['id'] = $id;
			$this->session->set_userdata('User_valid', $id);
			$this->session->set_userdata('User_email', $email);
			$this->load->view('otp',$data);
			}
			else{
			$this->session->set_flashdata('err_forgot', 2);
			redirect('forgot-password');
		}
	  }
	function verify_otp(){
    if($this->session->userdata('User_valid')){
		$id = $this->input->post('id');
    $otp = $this->input->post('otp');
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->where('otp', $otp);
		$query = $this->db->get('auth_user');
		if($query->num_rows() > 0){
			$res = $query->result_array();
      $data['id'] = $res[0]['id'];
          
      $this->load->view('new_password', $data);
      
		}
		else{
      $this->session->set_flashdata('resend', 1);
      echo '<body onload="myFunction()"> 
 
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
           <script>
           function myFunction(){
           swal("Wrong Otp Entered", "", "error");
           }
           </script>
           </body>
      ';
      $data['id'] = $id;
     
     $this->load->view('otp', $data);

      
		}
  }
  else{
    echo '<body onload="myFunction()"> 
 
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
           <script>
           function myFunction(){
           swal("Session Expired", "", "info");
           }
           </script>
           </body>';
 
		$data['categories']		 = $this->Mymodel->get_parent_categories();
		$data['all_categories'] = $this->Mymodel->get_all_categories();
		$data['product_category'] = $this->Mymodel->product_by_category();	
       $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
       $data['footer_cat']		= $this->Mymodel->get_footer_cat();
       $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
       $data['random_product_list'] = $this->Mymodel->get_random_product();
       $data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
           $data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
           // $data['title'] = "mednom | Lab Equipment | Scientific Instruments";
       $this->load->view('header', $data);
       $this->load->view('account');
       $this->load->view('footer');
          
  }
}
	function update_new_password(){
    if($this->session->userdata('User_valid')){
      $this->load->library('email');
		$password = $this->input->post('new_password');
		$id = $this->input->post('id');

		$this->db->where('id',$id);
		$this->db->set('password', $password);
    $this->db->update('auth_user');

    $this->email->from('info@mednom.com', 'mednom - Update Password');
    $this->email->to($this->session->userdata('User_email'));
    $this->email->subject('Update Password');
    $this->email->message('<h2>mednom Scientific Ltd</h2><br>
    <h4 style="color:Teal">mednom will inform you that your password has been successfully updated </h4><br>
');

$this->email->send();
    $this->session->unset_userdata('User_valid');
    $this->session->unset_userdata('User_email');
		$this->session->set_flashdata('update_pass', 1); 
    redirect('Distributor');
    }
  else{
    echo '<body onload="myFunction()"> 
 
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
           <script>
           function myFunction(){
           swal("Session Expired", "", "info");
           }
           </script>
           </body>';
 
		$data['categories']		 = $this->Mymodel->get_parent_categories();
		$data['all_categories'] = $this->Mymodel->get_all_categories();
		$data['product_category'] = $this->Mymodel->product_by_category();
       $data['cat_data_home']	 = $this->Mymodel->get_random_home_data();
       $data['footer_cat']		= $this->Mymodel->get_footer_cat();
       $data['footer_prod']	 = $this->Mymodel->get_footer_prod();
       $data['random_product_list'] = $this->Mymodel->get_random_product();
       $data['random_product_list_1'] = $this->Mymodel->get_random_product_1();
           $data['random_product_list_2'] = $this->Mymodel->get_random_product_2();
           // $data['title'] = "mednom | Lab Equipment | Scientific Instruments";
       $this->load->view('header', $data);
       $this->load->view('account');
       $this->load->view('footer');
          
  }
}
}