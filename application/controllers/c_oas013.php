<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS012
* Program Name     : Pembatalan Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : M Fadhel K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 13:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS013 extends MY_Controller {

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
		
		$this->load->model('m_oas013', 'lv_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas013');
	}

	function load_form ($form_id)
	{
		$param['form_detail'] = $this->lv_form_model->get_form_detail($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		
		// Jika cuti tahunan, ambil sisa cuti dari sisa cuti tahunan keryawan
		if($param['form_detail']['id'] == '1'){
			$param['leave_left'] = $this->_get_employee_annual_leave_left($param['form_detail']['employee_id']);
		}else
		// Jika bukan cuti tahunan, ambil jatah cuti maksimal dari tabel cuti
		{

			$param['leave_left'] = $param['form_detail']['length'];
		}
		
		$param['detail_leave_left'] = $param['leave_left'];
		$this->load->view('v_oas013', $param);
	}


	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['USER'] 	 		  = $this->input->post('employeerm');
			$sbmt['STATUS']  	 	  = $this->input->post('Approval');
			$sbmt['AMOUNT']  	 	  = $this->input->post('amount');
			$sbmt['EMPLOYEE_NAME']    = $this->user['name'];
			$sbmt['RM_EMAIL'] 	 	  = $this->input->post('emailrm');
			$sbmt['RM_NAME'] 	 	  = $this->input->post('namarm');
			$sbmt['this_year']  	  = DATE("Y");
			$sbmt['REQUESTER']  	  = $this->input->post('requesterid');
			$sbmt['leave_type_id']    = $this->input->post('leavetypeid');
			$sbmt['this_email'] 	  = $this->user['email'];

			
            $response = $this->lv_form_model->save_confirmation($sbmt);

            echo $response;
         }
	}

}

/* End of file c_oas013.php */
/* Location: ./application/controllers/c_oas013.php */