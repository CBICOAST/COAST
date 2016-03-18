<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS001
* Program Name     : Login Screen
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS001 extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		if ( $this->user['logged_in'])
        { 
            redirect(main_url());
        }
        else
        {
        	$this->load->view('v_oas001');	
        }
		
	}

	function do_the_logout(){
		$this->session->sess_destroy();
		redirect(main_url());
	}
	
	function resetPassword(){
	
		$this->load->model('m_oas001', 'login_model');
		if($this->input->post('ajax') == '1')
		{
			$sbmt['newReset']  	 = $this->input->post('newReset');
			$sbmt['emailReset']   = $this->input->post('emailReset');	
            $response = $this->login_model->save_temp_password($sbmt);			
		}
	}

	function do_the_login()
	{
		if($this->input->post('ajax') == '1')
		{
			$status = array();
			$status['email_field']    = "";
			$status['password_field'] = "";
			$status['message']		  = "";
			$status['status_id']	  = "";

			$input_email = $this->clean_input($this->input->post('email'));
			$input_password  = $this->clean_input(md5($_POST['password'])); 

			$status = $this->login_form_validate_check($input_email, $input_password);
			if($status['status_id'] != "1")
			{
				$this->load->model('m_oas001', 'login_model');
				$user = $this->login_model->get_user($input_email, $input_password);
				// $user = $this->m_oas001->check_user($input_email, $input_password);
				if($user === null)
				{
					// If username of password didn't match
					$status['message']		  = "Kombinasi email dan password salah!";
					$status['status_id']	  = "1";
				}
				else
				{
					// elseif username of password matched
					// echo "login successful";die();
					$userdata = array(
									'id' => $user['EMPLOYEE_ID'],
									'name' => $user['EMPLOYEE_NAME'],
									'gender' => $user['GENDER_ID'],
									'email' => $user['USER_EMAIL'],
									'group' => $user['USER_GROUP_ID'],
									'birth' => $user['BIRTH_DATE'],
									'logged_in' => TRUE
								);
					$this->session->set_userdata('user', base64_encode(serialize($userdata)));
					$status['message']		  = "Login berhasil!<br>Mengarahkan anda ke halaman utama...
												 <script>
												 		setTimeout(function() {
														  window.location.href = host;
														}, 2000);
												 </script>
												 ";
				}
			}
			echo json_encode($status);
		}
	}

	function login_form_validate_check($email, $password) 
	{
		if($this->input->post('ajax') == '1')
		{
			/**
			 * status id and *_field:
			 * 0 = There's no problem
			 * 1 = Found problem about this section
			 */
			$status['email_field']    = "0";
			$status['password_field'] = "0";
			$status['message']		  = "";
			$status['status_id']	  = "0";

			if($email != "")
			{
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
				{
					$status['message'] .= "Format email salah!<br>";
					$status['email_field'] = "1";
					$status['status_id'] = "1";
				}
			}
			else
			{
				$status['message'] .= "Email harap diisi!<br>";
				$status['email_field'] = "1";
				$status['status_id'] = "1";
			}

			if($password == ""){
				$status['message'] .= "Password harap diisi!<br>";
				$status['password_field'] = "1";
				$status['status_id'] = "1";
			}

			return $status;
		}
	}


	/**
	 * Fungsi ini berfungsi untuk membersihkan string yang ditangkap dari client
	 * dari simbol-simbol yang bisa saja menjadi script yang mengganggu.
	 * Misalnya didapat string "<script> alert("foo") </script>", hal ini dapat
	 * mengganggu.
	 * @param  string $data : string yang isinya akan dibersihkan
	 * @return string       : string yang telah dibersihkan
	 * 
	 */
	function clean_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function ComingSoonPage()
	{
		$this->load->view('v_comming_soon');
	}
}

/* End of file c_oas001.php */
/* Location: ./application/controllers/c_oas001.php */