<?php 
date_default_timezone_set("Asia/Jakarta");
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS038
* Program Name     : Cash Advance General GA Form
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 13-11-2014 11:54:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS038 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->load->helper(array('form', 'url','html'));
		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas038', 'ca_model');		
		$this->load->model('m_oas044', 'list_ca_model');
	}


	function index()
	{		
		$this->load->view('v_oas038', array('error' => ' ' ));
	}

	function load_view()
	{
	
		$employeeID 			= $this->user['id'];
		$param['this_id']	 	= $this->user['id'];
		$param['this_name'] 	= $this->user['name'];
		$param['this_email'] 	= $this->user['email'];
		$param['employeeGroup']	= $this->user['group'];

		$param['this_group'] 	= $this->_get_employee_group($param['this_id']);
		$param['detail_dir'] 	= $this->_get_employee_dir($param['this_id']);
		$param['detail_approval'] = $this->_get_employee_approval($param['this_group']);	
		$param['detail_akun'] 	= $this->_get_employee_akun($param['this_id']);		
		$param['this_division'] = $this->_get_employee_division($param['this_id']);
		$param['code'] 			= $this->_get_employee_codediv($param['this_division']);
		$param['detail_posid'] 	= $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] 	= $this->_get_employee_level($param['this_id']);
		
		$param['submission_list'] = $this->ca_model->get_list($param);

		$param['list_catype'] = $this->ca_model->get_catype_list();		
		$param['list_cctype'] = $this->ca_model->get_cctype_list();
		
		$param['approval_internal'] = $this->ca_model->get_approval_internal($param['this_group']);
		$param['approval_pro_tra'] 	= $this->ca_model->get_approval_pro_tra();
		$param['approval_license'] 	= $this->ca_model->get_approval_license();
		
		$param['tgl_ca'] = $this->ca_model->tgl_terakhir_ca($param['this_id']);

			$date1 = new DateTime(Date($param['tgl_ca']));
			$date2 = new DateTime(Date("Y-m-d"));
			$interval = $date1->diff($date2);

			if($interval->days < 30){
				$param['status_open'] = 0;		
			}else{
				$param['status_open'] = 1;
			}
        
		$this->load->view('v_oas038', $param);
	}
	
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['this_division'] 	 = $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
			$sbmt['code'] 			 = $this->_get_employee_codediv($sbmt['this_division']);
			$sbmt['CA_TYPE_ID'] 	 = $this->input->post('type_ca');
			$sbmt['ACTIVITY_TYPE_ID']= $this->input->post('activity');
			$sbmt['CHARGE_CODE']  	 = $this->input->post('cc');
			$sbmt['AMOUNT'] 		 = $this->input->post('amount');
			$sbmt['REMARK'] 		 = $this->input->post('remarks');
			$sbmt['CURRENCY'] 	   	 = $this->input->post('currency');	
			$sbmt['APPROVAL'] 	   	 = $this->input->post('approval');
            $sbmt['PAYMENT_METHOD']	 = $this->input->post('payment');
			$sbmt['EMPLOYEE_NAME']   = $this->user['name'];
			$sbmt['APPROVAL'] 	   	 = $this->input->post('approval');
			$sbmt['APPROVAL_NAME'] 	 = $this->input->post('nameapproval');
			$sbmt['APPROVAL_EMAIL']	 = $this->input->post('emailapproval');		  
			
            $response = $this->ca_model->submit_form($sbmt);

            echo $response;
         }
	}
	
	function load_edit($form_id)
	{
		$employeeID					= $this->user['id'];
		$param['cctypeid'] 		= null;
		$param['chargecodeid'] 	= null;
		$param['this_id'] 		= $this->user['id'];
		$param['this_name'] 	= $this->user['name'];
		$param['this_email'] 	= $this->user['email'];
		$param['this_group'] 	= $this->_get_employee_group($param['this_id']);
		$param['detail_dir'] 	= $this->_get_employee_dir($param['this_id']);			
		$param['detail_approval'] = $this->_get_employee_approval($param['this_group']);		
		$param['detail_level'] 	= $this->_get_employee_level($param['this_id']);
		$param['this_division'] = $this->_get_employee_division($param['this_id']);
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);
		$param['detail_akun2'] 		= $this->_get_employee_akun2($employeeID);
		$param['list_catype'] 	= $this->ca_model->get_catype_list();
		$param['list_cctype'] 	= $this->ca_model->get_cctype_list();
		$param['list_chargecode'] = $this->ca_model->get_ccode_list();
		
		$param['approval_internal'] = $this->ca_model->get_approval_internal($param['this_group']);
		$param['approval_pro_tra'] = $this->ca_model->get_approval_pro_tra();
		$param['approval_license'] = $this->ca_model->get_approval_license();
		
		$param['form_detail'] = $this->ca_model->get_form_detail($form_id);

		$param['status_edit'] = 1;
		$param['status_open'] = 0;
			if($param['form_detail']['type_id']!='1')
		{
			
				$param['chargecodeid'] = $param['form_detail']['chargecode'];
				$param['cctypeid'] = $this->ca_model->get_cctype($param['chargecodeid']);
			
		}

		$this->load->view('v_oas038', $param);
	}
	
	function  load_read_only($form_id)
	{
		
		$param['cctypeid'] 		= null;
		$param['chargecodeid'] 	= null;
		$param['this_id'] 		= $this->user['id'];
		$param['this_name'] 	= $this->user['name'];
		$param['this_email'] 	= $this->user['email'];
		$param['this_group'] 	= $this->_get_employee_group($param['this_id']);
		$param['detail_dir'] 	= $this->_get_employee_dir($param['this_id']);		
		$param['detail_approval'] 	= $this->_get_employee_approval($param['this_group']);		
		$param['detail_akun'] 	= $this->_get_employee_akun($param['this_id']);		

		$param['list_catype'] 	= $this->ca_model->get_catype_list();
		$param['list_cctype'] 	= $this->ca_model->get_cctype_list();
		$param['this_division'] = $this->_get_employee_division($param['this_id']);
		$param['list_chargecode'] 	= $this->ca_model->get_ccode_list();
		$param['approval_internal'] = $this->ca_model->get_approval_internal($param['this_group']);
		$param['approval_pro_tra'] 	= $this->ca_model->get_approval_pro_tra();
		$param['approval_license'] 	= $this->ca_model->get_approval_license();
		$param['detail_level'] 		= $this->_get_employee_level($param['this_id']);	
		$param['this_approval'] 	= $this->ca_model->get_approval($param['this_group']);
		$param['form_detail'] 	= $this->ca_model->get_form_detail($form_id);
		$param['status_edit'] 	= 1;
		$param['status_read_only'] 	= 1;
		$param['status_open'] 	= 0;
			if($param['form_detail']['type_id']!='1')
		{
			$param['chargecodeid'] 	= $param['form_detail']['chargecode'];
			$param['cctypeid'] 		= $this->ca_model->get_cctype($param['chargecodeid']);
		}

		$this->load->view('v_oas038', $param);
	}
	
	function load_chargecode($group_id)
	{
	
		$out = array();
		$chargecode_list = $this->ca_model->get_ccode_list($group_id);
		header('Content-Type: application/x-json; charset=utf-8');
		if(isset($chargecode_list)){
			foreach ($chargecode_list as $chargecode) {
				$out[$chargecode['id']] = $chargecode['name'];
			}
		}else{
			$out['0'] = '-- DATA NOT FOUND --';
		}
		echo(json_encode($out));
	}
	
	function update_ca()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']		= $this->user['id'];
			$sbmt['this_name']		= $this->user['name'];
			$sbmt['this_email']		= $this->user['email'];			
			$sbmt['ref_no'] 		= $this->input->post('no_ref');
			$sbmt['CA_TYPE_ID'] 	= $this->input->post('type_ca');
			$sbmt['ACTIVITY_TYPE_ID'] 	= $this->input->post('activity');
			$sbmt['CHARGE_CODE']  	= $this->input->post('cc');
			$sbmt['AMOUNT'] 		= $this->input->post('amount');
			$sbmt['REMARK'] 		= $this->input->post('remarks');
			$sbmt['DESTINATION'] 	= $this->input->post('destination');
			$sbmt['CURRENCY'] 	   	= $this->input->post('currency');	
			$sbmt['REQNAME'] 	    = $this->input->post('reqname');
			$sbmt['APPROVAL'] 	    = $this->input->post('approval');
			$sbmt['APPROVAL_NAME'] 	= $this->input->post('nameapproval');
			$sbmt['APPROVAL_EMAIL']	= $this->input->post('emailapproval');	
			$sbmt['F2_APPROVE']  = $this->input->post('akuntan2');
			$sbmt['F2_APPROVE_EMAIL']= $this->input->post('akuntan2_email');
			$sbmt['F2_APPROVE_NAMA'] = $this->input->post('akuntan2_nama');	
			$sbmt['APPROVAL'] 	   	= $this->input->post('approval');
			$sbmt['status_id'] 	   	= $this->input->post('status_id');
			$sbmt['PAYMENT_METHOD']	= $this->input->post('payment');
            $sbmt['CA_ID']	 		= $this->input->post('ca_id');

            $response = $this->ca_model->updateCaForm($sbmt);
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
	
}}

