<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS018
* Program Name     : Pengaturan User
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			16-12-2014			Winni Oktaviani		add fungsi2 untuk show procedure claim,bt,ca	
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS018 extends MY_Controller {

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
		
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas018', 'settings_model');
		
	}

	function index()
	{
	}

	function load_view()
	{
		$param['this_id'] = $this->user['id'];
		$param['this_name'] = $this->user['name'];
		$param['this_email'] = $this->user['email'];
		$param['employee_inform'] = $this->settings_model->getEmployeeInform($this->user['id']);

		$this->load->view('v_oas018', $param);
	}

	function change_pwd()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']     = $this->input->post('employeeId');
			
			$sbmt['passwd']	 = ($_POST['newPwd']);
			
			if ($sbmt['passwd'] == ""){
				$sbmt['NEW_PASSWORD']	 = ($_POST['newPwd']);
			}else{
			$sbmt['NEW_PASSWORD']	 = md5($_POST['newPwd']);
				}
				
			$sbmt['LEAVE_INFORM'] 	 = $this->input->post('inform_status');
			$sbmt['EXPENSE_INFORM'] 	 = $this->input->post('inform_ec_status');
			$sbmt['BT_INFORM'] 	 = $this->input->post('inform_bt_status');
			$sbmt['CA_INFORM'] 	 = $this->input->post('inform_ca_status');
			$sbmt['PR_INFORM'] 	 = $this->input->post('inform_pr_status');
			$sbmt['THIS_USER'] 		 = $this->user['email'];
			$sbmt['DATENOW'] 		 = date("Y-m-d H:i:s");
			$sbmt['PHONE']			 = $this->input->post('nomor_tlpn');
			$sbmt['ADDRESS'] 	 	 = $this->input->post('alamat');


            $response1 = $this->settings_model->change_settings($sbmt);
            $response2 = $this->settings_model->change_personal_data($sbmt);

            echo $response1+$response2;
		}
	}

	function check_pwd()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']     = $this->input->post('employeeId');
			$sbmt['PWD']  	 = md5($_POST['Pwd']);

            $response = $this->settings_model->check_password($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas018.php */
/* Location: ./application/controllers/c_oas018.php */