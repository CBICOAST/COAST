<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS003
* Program Name     : Welcome Page
* Description      :
* Environment      : PHP 5.4.4
* Author           : [...]
* Version          : 01.00.00
* Creation Date    : [...]
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS003 extends MY_Controller {

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
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		
	}
	function load_view()
	{
		$param['this_id'] = $this->user['id'];
		$param['this_leave_left'] = $this->_get_employee_annual_leave_left($param['this_id']);
		$param['this_expense_left'] = $this->_get_employee_expense_claim_left($param['this_id']);
		$param['this_bntNikah'] = $this->_reupdate_bantuan($param['this_id']);
		$param['this_pwdStat'] = $this->_get_employee_pwdstatus($param['this_id']);
		$this->load->view('v_oas003', $param);
	}
	function change_password()
	{	
		$this->load->model('m_oas003', 'pwd_model');
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']   = $this->user['email'];
			$sbmt['EMPLOYEE_ID'] = $this->user['id'];
			$sbmt['password'] = md5($_POST['password']); 
            $response = $this->pwd_model->save_new_password($sbmt);
		}
		$this->load->view('v_oas003');
	}
}

/* End of file c_oas003.php */
/* Location: ./application/controllers/c_oas003.php */