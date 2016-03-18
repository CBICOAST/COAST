<?php /************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id   	   : OAS059
* Program Name     : Daftar Sisa Cuti Tahunan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 18-12-2014 13:14:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description* 
* 1					16/02/2015 		   Dwi Irawati			Edit Annual Leave
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS059 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas059', 'list_model');
		
	}

	function index()
	{
		
	}
	function load_view()
	{
		$employeeID = $this->user['id'];
		$year = date("Y");
		$param['employeeGroup'] = $this->user['group'];
		$param['status_edit'] = 0;
		$param['this_id'] = $this->user['id'];
		$param['submission_list']  = $this->list_model->get_employee_list($year);
		$this->load->view('v_oas059', $param);
	}
	
	function load_edit($id_empl)
	{
		$year = date("Y");
		$param['form_detail'] = $this->list_model->get_form_detail($year, $id_empl);

		$param['status_edit'] = 1;
		
		$this->load->view('v_oas059', $param);
	}
	
	function update_annualleave()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']		= $this->user['id'];
			$sbmt['this_name']		= $this->user['name'];
			$sbmt['this_email']		= $this->user['email'];			
			
            $sbmt['YEAR']	 		= $this->input->post('YEAR');
			$sbmt['BALANCE']	 		= $this->input->post('BALANCE');
			$sbmt['EMPLOYEE_ID']	 		= $this->input->post('EMPLOYEE_ID');

            $response = $this->list_model->updateannualleave($sbmt);
		
		
		$employeeID = $this->user['id'];
		$year = date("Y");
		$param['employeeGroup'] = $this->user['group'];
		$param['status_edit'] = 0;
		$param['this_id'] = $this->user['id'];
		$param['submission_list']  = $this->list_model->get_employee_list($year);
		$this->load->view('v_oas059', $param);

		}
}
	
	
	
}

/* End of file c_oas059.php */
/* Location: ./application/controllers/c_oas059.php */