<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS024
* Program Name     : Create Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS024 extends MY_Controller {
	function __construct()
	{
		parent::__construct();
				
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas024', 'cl_model');
		
	}
	function getCC(){
	
		$id = $this->input->get('code');
		$cc = $this->cl_model->getCc_CL($id);?>
	 
		<select  id="cl-cc">
			<option style="display: none;" value=""> --choose one---</option>
			<?php foreach ($cc as $key => $type) { ?>
				<option value="<?=$type['charge_code']?>"><?= $type['description'] ?></option>
			<?php } ?>
		</select> 
	<?}
	
	function getDivCC(){
	
		$id = $this->input->get('code');
		$cc = $this->cl_model->getCc_Div($id); 
		
			 foreach ($cc as $key => $type) { ?>
				<input type="text" id="tes" readonly class = "form-control holo" value="<?echo $type['divisi']?>">
			<?php } 
	}
	
	function getMedical(){
	
	$this->load->model('m_oas024', 'cl_model');
	$id = $this->input->get('code');
	$showMedisList = $this->cl_model->get_medis_type_list($id);
	$showCat = $this->cl_model->get_category_claim($id);?>
	<select id="medical_list" onchange="getSisa()">
		<?foreach($showMedisList as $data){?>				
				<option value="<?php echo $data['id']?>"><?php echo $data['name']; ?></option>
				<?
		}?>
		</select><?
		foreach($showCat as $data){?>
				<input  id="catCL"type="hidden" readonly value="<?php echo $data['cat']?>">
				<?
		}
		
	}
	
	function load_view()
	{
		
		$param['this_id'] = $this->user['id'];
		$param['this_name'] = $this->user['name'];
		$param['this_email'] = $this->user['email'];
		$param['this_group'] = $this->_get_employee_group($param['this_id']);
		$param['this_division'] = $this->_get_employee_division($param['this_id']);
		$param['this_rm'] = $this->_get_employee_rm($param['this_id']);		
		$param['this_role'] = $this->_get_employee_role($param['this_id']);
		$param['this_join'] = $this->_get_employee_join_date($param['this_id']);
		$param['this_status'] = $this->_get_employee_status($param['this_id']);
		$param['this_level'] = $this->_get_employee_level($param['this_id']);
		
		$param['list_claim_type'] = $this->cl_model->get_claim_type_list();
		$param['charge_code_type'] = $this->cl_model->get_charge_code_type();
		
		$param['detail_akun'] = $this->_get_employee_akun($param['this_id']);	
		$param['head_group'] = $this->_get_employee_approval($param['this_group']);	
		$param['director'] = $this->_get_employee_dir($param['this_id']);	
		$param['depth'] = $this->_get_employee_posid($param['this_id']);	
		$param['head_div'] = $this->_get_division_head($param['this_division']);		
		$param['approval_dir'] = $this->cl_model->_get_approval_dir();	
		$param['app_project'] = $this->cl_model->get_approval_pro();	
		$param['KODE'] 		= $this->_get_employee_codediv($param['this_division']);
		
		
		$this->load->view('v_oas024', $param);
	}

	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['EMPLOYEE_NAME']  = $this->user['name'];
			$sbmt['this_division']  =  $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
			$sbmt['CLAIM_TYPE_ID'] 	 = $this->input->post('claimTypeId');
			$sbmt['CHARGE_CODE']  	 = $this->input->post('chargeCode');
			$sbmt['TANGGAL_KWITANSI']= $this->input->post('tanggalKwitansi');
			$sbmt['TOTAL'] 		   	 = $this->input->post('total');
			$sbmt['KETERANGAN'] 	 = $this->input->post('keterangan');			
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
			$sbmt['APPROVAL'] 		   	 = $this->input->post('approval');			
			$sbmt['APPROVAL_NAME'] 		   	 = $this->input->post('approval_name');			
			$sbmt['APPROVAL_EMAIL'] 		   	 = $this->input->post('approval_email');		
			$sbmt['KODE'] 		= $this->_get_employee_codediv($sbmt['this_division']);

            $response = $this->cl_model->submitClaimForm_individu($sbmt);

            echo $response;
		}
		if($this->input->post('ajax') == '2')
		{
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['EMPLOYEE_NAME']  = $this->user['name'];
			$sbmt['this_division']  =  $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
			$sbmt['CLAIM_TYPE_ID'] 	 = $this->input->post('claimTypeId');
			$sbmt['CHARGE_CODE']  	 = $this->input->post('chargeCode');
			$sbmt['TANGGAL_KWITANSI'] 	   	 = $this->input->post('tanggalKwitansi');
			$sbmt['TOTAL'] 		   	 = $this->input->post('total');
			$sbmt['KETERANGAN'] 		   	 = $this->input->post('keterangan');
			
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
			$sbmt['APPROVAL'] 		   	 = $this->input->post('approval');
			$sbmt['APPROVAL_NAME'] 		   	 = $this->input->post('approval_name');			
			$sbmt['APPROVAL_EMAIL'] 		   	 = $this->input->post('approval_email');
			$sbmt['KODE'] 		= $this->_get_employee_codediv($sbmt['this_division']);

            $response = $this->cl_model->submitClaimForm_divisi($sbmt);

            echo $response;
		}
	}
	
	function getAmount(){
	
	$this->load->model('m_oas024');
	$employeeID = $this->user['id'];
	$expense = $this->input->get('code');
	$child = $this->input->get('child');
	$year = $this->input->get('year_kw');
	$bantu = $this->cl_model-> get_bantuan($employeeID, $expense, $child,$year);?>
	<select  id="bantuan" hidden><?
	foreach($bantu as $data){?>
		<option value="<?= $data['amount']?>"><?= $data['amount'] ?></option><?php } ?>
	</select> <?
	}
	
	function getTunjangan(){
	
	$this->load->model('m_oas024');
	$employeeID = $this->user['id'];
	$expense = $this->input->get('code');
	$child = $this->input->get('child');
	$year = $this->input->get('year_kw');
	$month = $this->input->get('month_kw');
	$tnj = $this->cl_model-> get_tunjangan($employeeID, $expense, $child,$year,$month);?>
	<select  id="hd_tunjangan" hidden><?
	foreach($tnj as $data){?>
		<option value="<?= $data['amount']?>"><?= $data['amount'] ?></option><?php } ?>
	</select> <?
	}

	
}


/* End of file c_oas024.php */
/* Location: ./application/controllers/c_oas024.php */