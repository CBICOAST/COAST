<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS033
* Program Name     : Approval Claim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-09-2014 07:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS033 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas033', 'cl_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas033');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->cl_model->get_form_detail($form_id);
		$param['form_remarks'] = $this->cl_model->get_form_remarks($form_id);
		$param['form_edit_detail'] = $this->cl_model->get_edit_detail($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['div_cc'] = $this->cl_model->get_chargecode_div($form_id);
			
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		$param['get_f2'] = $this->_get_employee_pur($param['this_id']);
		$param['get_dir'] = $this->_get_employee_dir($param['this_id']);
		$param['detail_admin']	= $this->_get_employee_admin($param['this_id']);
		$param['this_balance'] = $this->cl_model->get_balance_bantuan($form_id,$param['form_detail']['id']);
		$param['this_balance_tnj'] = $this->cl_model->get_balance_tunjangan($form_id,$param['form_detail']['id']);
		
		$this->load->view('v_oas033', $param);
	}
	
	function submit_approval()
	{
		if(($this->input->post('ajax') == '0') || ($this->input->post('ajax') == '8'))
		{
			$sbmt['this_id'] = $this->user['id'];
			
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['USER'] 	 		  = $this->input->post('akuntan');
				$sbmt['USER_EMAIL'] 	 		  = $this->input->post('akuntan_email');
			$sbmt['USER_NAME'] 	 		  = $this->input->post('akuntan_name');
			$sbmt['STATUS']  	 	  = $this->input->post('Approval');
			$sbmt['STATUS_NOTIF']  	 	  = $this->input->post('status_notif');
			$sbmt['REMARKS']		  = $this->input->post('Remarks');
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['REQUESTER_EMAIL']		  = $this->input->post('requesteremail');
			$sbmt['REQUESTER_NAME']		  = $this->input->post('requestername');
			$sbmt['SENDER_EMPLOYEE_ID']		  	= $this->input->post('aprove');
			$sbmt['month']		 	  = $this->input->post('month');
			$sbmt['year']		  	  = $this->input->post('year');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['total']			  = $this->input->post('total');
			$sbmt['ref_no']			  = $this->input->post('ref_no');
			$sbmt['this_email'] 	  = $this->user['email'];
			$sbmt['claim_type_id']    = $this->input->post('claimtypeid');
			$sbmt['category_id']      = $this->input->post('category_id');
			$sbmt['status_name']      = $this->input->post('status_name');
			
            $response = $this->cl_model->save_confirmation_divisi($sbmt);}
			
			if(($this->input->post('ajax') == '1') ||($this->input->post('ajax') == '11')||($this->input->post('ajax') == '9'))
		{
			$sbmt['this_id'] = $this->user['id'];
			
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['USER'] 	 		  = $this->input->post('akuntan');
			$sbmt['USER_EMAIL'] 	 		  = $this->input->post('akuntan_email');
			$sbmt['USER_NAME'] 	 		  = $this->input->post('akuntan_name');
			$sbmt['STATUS']  	 	  = $this->input->post('Approval');
			$sbmt['STATUS_NOTIF']  	 	  = $this->input->post('status_notif');
			$sbmt['REMARKS']		  = $this->input->post('Remarks');
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['REQUESTER_EMAIL']		  = $this->input->post('requesteremail');
			$sbmt['REQUESTER_NAME']		  = $this->input->post('requestername');
			$sbmt['SENDER_EMPLOYEE_ID']		  	= $this->input->post('aprove');
			$sbmt['month']		 	  = $this->input->post('month');
			$sbmt['year']		  	  = $this->input->post('year');
			$sbmt['periode']      = $this->input->post('periode');
			$sbmt['limitReq']      = $this->input->post('limitReq');
			$sbmt['saveRemain']      = $this->input->post('saveRemain');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['total']			  = $this->input->post('total');
			$sbmt['ref_no']			  = $this->input->post('ref_no');
			$sbmt['this_email'] 	  = $this->user['email'];
			$sbmt['claim_type_id']    = $this->input->post('claimtypeid');
			$sbmt['category_id']      = $this->input->post('category_id');
			$sbmt['status_name']      = $this->input->post('status_name');
			$sbmt['chargecode']      = $this->input->post('chargecode');
			$sbmt['get_f2_id'] 	 		  = $this->input->post('f2_id');
			$sbmt['get_f2_email'] 	 		  = $this->input->post('f2_email');
			$sbmt['get_dir_id'] 	 		  = $this->input->post('dir_id');
			$sbmt['get_dir_email'] 	 		  = $this->input->post('dir_email');
			
            $response = $this->cl_model->save_confirmation_individu($sbmt);

            echo $response;
         }
	}


	

}

/* End of file c_oas033.php */
/* Location: ./application/controllers/c_oas033.php */