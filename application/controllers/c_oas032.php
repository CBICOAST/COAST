<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS032
* Program Name     : Paid 1
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 01-24-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS032 extends MY_Controller {

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

		$this->load->model('m_oas032', 'paid_model');		
	}


	function index()
	{		
		$this->load->view('v_oas032');
	}

	function load_form ($form_id)
	{
		$param['form_detail']		= $this->paid_model->get_form_detail($form_id);
		$param['detail_rm']			= $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group']		= $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division']	= $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role']		= $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['form_remarks']		= $this->paid_model->get_form_remarks($form_id);
		$this->load->view('v_oas032', $param);
	}

	
	
	function submit_paid()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
            $response = $this->paid_model->save_paid($sbmt);

            echo $response;
         }
	}
	
}

/* End of file c_oas032.php */
/* Location: ./application/controllers/c_oas032.php */