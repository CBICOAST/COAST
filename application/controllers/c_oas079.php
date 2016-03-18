 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS079
* Program Name     : Form Konfirmasi Purchase Order 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS079 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas071', 'pr_form_model');
		$this->load->model('m_oas079', 'po_form_model');
		$this->load->model('m_oas078', 'listpo_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas079');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['form_detail'] = $this->po_form_model->get_form_detail($form_id);
		$param['detail_vendor'] = $this->pr_form_model->get_vendor($param['form_detail']['pr_id']);
		$param['detail_shipto'] = $this->pr_form_model->get_shipto($param['form_detail']['pr_id']);
		$param['list_pr'] = $this->po_form_model->get_list_tmppr($form_id);	
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_dir'] = $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_pur'] = $this->_get_employee_pur($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		
		$this->load->view('v_oas079', $param);
	}
	
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['this_email'] 	  = $this->user['email'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['ACTIVITY_TYPE_ID']  	  = $this->input->post('activity');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['FINAL_APPROVE'] 	 		  = $this->input->post('akuntan');
			$sbmt['PURCHASE'] 	 		  = $this->input->post('pur');
			$sbmt['PURCHASE_EMAIL'] 	  = $this->input->post('pur_email');
			$sbmt['PURCHASE_NAME'] 		  = $this->input->post('pur_name');
			$sbmt['AKUNTAN_EMAIL'] 	 		  = $this->input->post('akuntan_email');
			$sbmt['AKUNTAN_NAME'] 	 		  = $this->input->post('akuntan_name');
			$sbmt['STATUS']  	 	  = $this->input->post('approval');
			$sbmt['REMARKS']		  = $this->input->post('remarks');
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['REQUESTER_NAME']		  = $this->input->post('requester_name');
			$sbmt['REQUESTER_EMAIL']		  = $this->input->post('requester_email');
			$sbmt['SENDER_EMPLOYEE_ID']	= $this->input->post('aprove');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['ref_no']			  = $this->input->post('refno');
			
			$sbmt['PR_ID']			  = $this->input->post('pr_id');

			$response = $this->po_form_model->save_confirmation($sbmt);
			
			$employeeID					= $this->user['id'];
			$param['employeeGroup']		= $this->user['group'];
			$param['this_id']			= $this->user['id'];
			$param['submission_list']	= $this->listpo_form_model->get_list($param);
			$param['detail_admin']		= $this->_get_employee_admin($employeeID);
			$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
			$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
			$param['detail_pur'] 		= $this->_get_employee_pur($employeeID);
			$param['list_group']		= $this->listpo_form_model->get_group_list();
			$param['list_chargecodetype']		= $this->listpo_form_model->get_chargecodetype_list();
			$param['month_list']		= $this->month_list;	
			$param['employee_list']		= $this->listpo_form_model->get_employee_list();
		
			$this->load->view('v_oas078', $param);
		}
	}
}