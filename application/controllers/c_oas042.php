<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS042
* Program Name     : Show Limit Status
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 17-11-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS042 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		$this->load->model('m_oas042','status_model');
	}

	function index()
	{
		echo "Direct access not allowed!";
		die();
		$date1 = new DateTime(Date("2014-07-24"));
		$date2 = new DateTime(Date("Y-m-d"));
		$interval = $date1->diff($date2);

		if($interval->days > 30){
			echo "ok";
		}

		echo $interval->days." days "; 
	}

	function load_view()
	{
		$year = date('Y');
		$month = date('m');
		$param['this_id'] = $this->user['id'];
		$param['this_leave_left'] = $this->_get_employee_annual_leave_left($param['this_id']);
		$param['this_leave'] = $this->status_model->get_limit_annual_leave($param['this_id']) ;
		$param['this_claim_left'] = $this->status_model->get_expense_claim_left($param['this_id'],$month,$year);
		$this->load->view('v_oas042', $param);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */