 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS040
* Program Name     : Form Approval CA
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 07:36:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS040 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas040', 'ca_form_model');	
		$this->load->model('m_oas044', 'list_ca_model');		
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas040');
	}

	function load_form ($form_id)
	{
		$param['this_id'] 		= $this->user['id'];
		$param['form_detail'] 	= $this->ca_form_model->get_form_detail($form_id);

		$param['detail_group'] 	= $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_dir'] 	= $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_akun']	 = $this->_get_employee_akun($param['form_detail']['employee_id']);
		$param['detail_akun2']	 = $this->_get_employee_akun2($param['form_detail']['employee_id']);
		
		$this->load->view('v_oas040', $param);
	}
	
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] 	= $this->user['id'];
			$sbmt['this_name'] 	= $this->user['name'];
			$sbmt['FORM_TYPE_ID']	= $this->input->post('form_type_id');
			$sbmt['FORM_ID']    = $this->input->post('form_id');
			$sbmt['FINAL_APPROVE']  = $this->input->post('akuntan');
			$sbmt['FINAL_APPROVE_EMAIL']= $this->input->post('akuntan_email');
			$sbmt['FINAL_APPROVE_NAMA'] = $this->input->post('akuntan_nama');
			$sbmt['F2_APPROVE']  = $this->input->post('akuntan2');
			$sbmt['F2_APPROVE_EMAIL']= $this->input->post('akuntan2_email');
			$sbmt['F2_APPROVE_NAMA'] = $this->input->post('akuntan2_nama');
			$sbmt['DIR_APPROVE']= $this->input->post('dir');
			$sbmt['DIR_APPROVE_EMAIL']	= $this->input->post('dir_email');
			$sbmt['DIR_APPROVE_NAMA']	= $this->input->post('dir_nama');
			$sbmt['ACTIVITY_TYPE_ID'] 	= $this->input->post('activity');
			$sbmt['STATUS']  	= $this->input->post('approval');
			$sbmt['REMARKS']	= $this->input->post('remarks');
			$sbmt['REQUESTER']	= $this->input->post('requesterid');
			$sbmt['REQUESTER_EMAIL']= $this->input->post('requester_email');
			$sbmt['REQUESTER_NAMA'] = $this->input->post('requester_nama');
			$sbmt['SENDER_EMPLOYEE_ID']	= $this->input->post('aprove');
			$sbmt['GROUP_HEAD']	= $this->input->post('group_head');
			$sbmt['status_id']	= $this->input->post('status_id');
			$sbmt['AMOUNT']		= $this->input->post('amount');
			$sbmt['LIMIT']		= $this->input->post('limit');
			$sbmt['ref_no']		= $this->input->post('ref_no');
			$sbmt['this_email'] = $this->user['email'];
			$sbmt['CA_TYPE_ID'] = $this->input->post('catype');
			$sbmt['category_id']= $this->input->post('category_id');
			$sbmt['status_name']= $this->input->post('status_name');
			$sbmt['divid']		= $this->input->post('divid');
			
			
            $response = $this->ca_form_model->save_confirmation($sbmt);

           $employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['month_list']		= $this->month_list;	
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
		$param['detail_akun2'] 		= $this->_get_employee_akun2($employeeID);
		$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);

		$param['list_group']		= $this->list_ca_model->get_group_list();
		$param['list_chargecodetype']		= $this->list_ca_model->get_chargecodetype_list();
		$param['list_cash_advance_type'] 	= $this->list_ca_model->get_cash_advance_type();
		$param['employee_list']		= $this->list_ca_model->get_employee_list();
		$param['submission_list']	= $this->list_ca_model->get_list($param);
		
		$this->load->view('v_oas044', $param);

		}
	}
}