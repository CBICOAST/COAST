<?php 
date_default_timezone_set("Asia/Jakarta");
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS037
* Program Name     : Form Pengajuan Business Travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 9:19:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS037 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
				
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas037', 'bt_model');
		$this->load->model('m_oas045', 'list_reportbt_model');
		
	}
	
	function index()
	{
		echo date("N", strtotime("2014-08-18"));
		echo $this->isWeekend("2014-08-18");
		echo "<br>";
		$holidays =$this->holidayList("2014-08-19", "2014-08-30");
		echo "Final result: ".$this->get_bDay_Holiday_Total($holidays);
        die();
	}
function load_chargecode($group_id)
	{
	
		$out = array();
		$chargecode_list = $this->bt_model->get_ccode_list($group_id);
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

	// mendapatkan daftar project description berdasarkan tipe charge code
	function get_pd(){
	$this_id = $this->user['id'];
	$id 	= $this->input->get('code');	
	$tampil	= $this->bt_model->get_project_description($id);?>
	
	<select id="cc"><?
			foreach($tampil as $data)
			{?>				
				<option style="display: none;" value="-">--choose one---</option>
				<option value="<?php echo $data['CHARGE_CODE']?>"><?php echo $data['PROJECT_DESCRIPTION']; ?></option><?
			}?>
		</select><?
	}
	
	
	// mendapatkan cost setiap destination BT CA
	function get_cost(){
	$destination 		= $this->input->get('btr_destination');
	$show_destination	= $this->bt_model->get_cost_destination($destination);?>
	
		<select id="cost"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['cost']?>"></option><?
			}?>
		</select>
		<select id="costUsd"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['usd']?>"></option><?
			}?>
		</select>
		<select id="amountid"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid']?>"></option><?
			}?>
		</select>
		<select id="amountid1"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid1']?>"></option><?
			}?>
		</select>
		<select id="amountid2"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid2']?>"></option><?
			}?>
		</select><?
	}
		
		function get_traveller(){
		$traveller 		= $this->input->get('bt_traveller_name');
		$show_destination	= $this->bt_model->get_traveller_group($traveller);?>
	
		<select id="traveller"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['traveller']?>"></option><?
			}?>
		</select>
		<select id="groupid"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['groupid']?>"></option><?
			}?>
		</select>
		<select id="posid"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['posid']?>"></option><?
			}?>
		</select>
		<select id="divisionid"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['divisionid']?>"></option><?
			}?>
		</select>
		<select id="amountid"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid']?>"></option><?
			}?>
		</select>
		<select id="amountid1"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid1']?>"></option><?
			}?>
		</select>
		<select id="amountid2"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['amountid2']?>"></option><?
			}?>
		</select>
		<select id="approval"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['approval']?>"></option><?
			}?>
		</select>
		<?
	}
		
	function load_view()
	{	
		$employeeID					= $this->user['id'];
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['status_open'] 		= $this->bt_model->cek_status_open($param['this_id']);
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['code'] = $this->_get_employee_codediv($param['this_division']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['detail_dir'] = $this->_get_employee_dir($employeeID);	
		$param['detail_ga2'] = $this->_get_employee_ga2($employeeID);
			
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['this_role']			= $this->_get_employee_role($param['this_id']);
		$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);				
		$param['list_cctype'] = $this->bt_model->get_cctype_list();
		$param['destination']		= $this->bt_model->get_bt_destination_list();
		$param['traveller']		= $this->bt_model->get_name_list();
		$param['transportation']		= $this->bt_model->get_bt_transportation_list();		
		$param['charge_code_type']	= $this->bt_model->get_charge_code_type();	
		$param['currency'] 			= $this->bt_model->get_currency_list();
		$param['name_list']	= $this->bt_model->get_name_list();
		
		
		
		$date1 = new DateTime(Date($param['this_join']));
			$date2 = new DateTime(Date("Y-m-d"));
			$interval = $date1->diff($date2);

		$this->load->view('v_oas037', $param);
	}
	
	function load_edit_form($formId)
	{
	$param['cctypeid'] = null;
		$param['chargecodeid'] = null;
		$param['form_data'] = $this->bt_model->getFormInfo($formId);
		$param['edit_stat'] = '1';
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['status_edit'] = 1;
		$param['status_read_only'] = 1;
		$param['name_list']	= $this->bt_model->get_name_list();
		$param['traveller']		= $this->bt_model->get_name_list();
		$param['transportation']		= $this->bt_model->get_bt_transportation_list();
		$param['destination']		= $this->bt_model->get_bt_destination_list();
		$param['charge_code_type']	= $this->bt_model->get_charge_code_type();		
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['detail_dir'] = $this->_get_employee_dir($param['this_id']);	
		$param['detail_ga2'] = $this->_get_employee_ga2($param['this_id']);	
		$param['this_role']			= $this->_get_employee_role($param['this_id']);
		$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);	
		$param['list_cctype'] = $this->bt_model->get_cctype_list();
		$param['list_chargecode'] = $this->bt_model->get_ccode_list();
		$param['chargecodeid'] = $param['form_data']['cc'];
		$param['cctypeid'] = $this->bt_model->get_cctype($param['chargecodeid']);
		$param['this_approval'] = $this->bt_model->get_approval($param['this_group']);

		$this->load->view('v_oas037', $param);
	}

	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{	
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['this_division'] = $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
			$sbmt['this_name'] 		= $this->user['name'];
			$sbmt['code'] = $this->_get_employee_codediv($sbmt['this_division']);
			$sbmt['CLIENT_NAME'] 		 = $this->input->post('client');
			$sbmt['BUSINESS_PURPOSE'] 		 = $this->input->post('bp');
			$sbmt['CUSTOMER_LOCATION'] 		 = $this->input->post('cust');
			$sbmt['TRANSPORTATION_BY'] 	 = $this->input->post('transportby');
			$sbmt['CHARGE_CODE']  	 = $this->input->post('chargeCode');
			$sbmt['DESTINATION'] 	 = $this->input->post('tujuan');
			$sbmt['CURRENCY'] 		 = $this->input->post('mata_uang');
            $sbmt['PAYMENT_METHOD']	 = $this->input->post('paymentMethod');
            $sbmt['DEPARTURE'] 	  = $this->input->post('start_date');
            $sbmt['RETURN_DATE']		  = $this->input->post('end_date');
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
            $sbmt['REMARKS']	 	 = $this->input->post('remark');			  
			$sbmt['APPROVAL'] 	   	 = $this->input->post('approval');				  
			$sbmt['APPROVAL_NAME']	 = $this->input->post('approval_name');			  
			$sbmt['APPROVAL_EMAIL']  = $this->input->post('approval_email');	  
			$sbmt['TRAVELLER'] 	   	 = $this->input->post('traveller');
			$sbmt['TRAVELLER_NAME'] 	   	 = $this->input->post('employee_name');
			$sbmt['DURATION'] 	   	 = $this->input->post('duration'); 
			$sbmt['AMOUNTDIM'] 	   	 = $this->input->post('amountdim');
			$sbmt['TRANSPORT'] 	   	 = $this->input->post('amounttransport');
			

            $response = $this->bt_model->submitCaForm($sbmt);

            echo $response;
		}
	}
	
	function submit_update_form()
	{
		if($this->input->post('ajax') == '1')
		{		
			$sbmt['this_id']    	 = $this->user['id'];
			$sbmt['this_email'] 	 = $this->user['email'];

			$sbmt['BT_ID']  		 = $this->input->post('formid');
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['CLIENT_NAME'] 		 = $this->input->post('client');
			$sbmt['BUSINESS_PURPOSE'] 		 = $this->input->post('bp');
			$sbmt['CUSTOMER_LOCATION'] 		 = $this->input->post('cust');			
			$sbmt['TRAVELLER_NAME'] 	   	 = $this->input->post('employee_name');
			$sbmt['TRANSPORTATION_BY'] 	 = $this->input->post('transportby');
			$sbmt['CHARGE_CODE']  	 = $this->input->post('chargeCode');
			$sbmt['DESTINATION'] 	 = $this->input->post('tujuan');
            $sbmt['PAYMENT_METHOD']	 = $this->input->post('paymentMethod');
            $sbmt['DEPARTURE'] 	  = $this->input->post('start_date');
            $sbmt['RETURN_DATE']		  = $this->input->post('end_date');
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
            $sbmt['REMARKS']	 	 = $this->input->post('remark');			  
			$sbmt['APPROVAL'] 	   	 = $this->input->post('approval');	
			$sbmt['APPROVAL_NAME']	 = $this->input->post('approval_name');			  
			$sbmt['APPROVAL_EMAIL']  = $this->input->post('approval_email');			
			$sbmt['TRAVELLER'] 	   	 = $this->input->post('traveller');	  
			$sbmt['DURATION'] 	   	 = $this->input->post('duration'); 
			$sbmt['AMOUNTDIM'] 	   	 = $this->input->post('amountdim');
			$sbmt['TRANSPORT'] 	   	 = $this->input->post('amounttransport');

            $response = $this->bt_model->updateBtForm($sbmt);

		}
	}
	
	function get_calculate(){
		if($this->input->post('ajax') == '1')
		{
			$start = $this->input->post('start_date');
			$end = $this->input->post('end_date');
			echo $end - $start;
		}
	}
	
// =====================  FOR FORM ELEMENT INTERACTION  =====================
	
}


/* End of file c_oas037.php */
/* Location: ./application/controllers/c_oas037.php */