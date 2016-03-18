 <?php
 /************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS023
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00				4 Maret 2015	Winni Oktaviani
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS023 extends MY_Controller {
	function __construct()
	{
		parent::__construct();		
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->load->model('m_oas023', 'edit_model');
	}
	
	function load_form_edit($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['this_group'] = $this->_get_employee_group($param['this_id']);
		$param['this_division'] = $this->_get_employee_division($param['this_id']);		
		$param['info']		= $this->edit_model->get_info($form_id);
		$param['approval']	= $this->edit_model->get_approval_name($form_id);
		$param['allcc']		= $this->edit_model->get_charge_code($form_id);
		
		$param['tipechargecode']	= $this->edit_model->get_tipechargecode($form_id);
		$param['alltypechargecode']	= $this->edit_model->get_charge_code_type();
		$param['this_CC']	= $this->edit_model->get_thisCC($form_id);
			
		$param['head_group'] = $this->_get_employee_approval($param['this_group']);	
		$param['director'] = $this->_get_employee_dir($param['this_id']);	
		$param['depth'] = $this->_get_employee_posid($param['this_id']);
		$param['app_project'] = $this->edit_model->get_approval_pro();
		$param['head_div'] = $this->_get_division_head($param['this_division']);
		$param['this_balance'] = $this->edit_model->get_balance_bantuan($form_id,$param['info']['id']);
		$param['this_balance_tnj'] = $this->edit_model->get_balance_tunjangan($form_id,$param['info']['id']);
		$param['edit_mode'] = 1;

		$this->load->view('v_oas023', $param);
	}
	
	function submit_edit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			
			$sbmt['this_name']	= $this->user['name'];
			
			$sbmt['APPROVAL']	= $this->input->post('aprove');
			$sbmt['APPROVAL_NAME']	= $this->input->post('aprove_name');
			$sbmt['APPROVAL_EMAIL']	= $this->input->post('aprove_email');
			
			$sbmt['ref_no']		= $this->input->post('ref_no');
			$sbmt['this_email'] = $this->user['email'];
			
			$sbmt['CLAIM_ID'] 	= $this->input->post('claim_id');
			$sbmt['CHARGE_CODE']		= $this->input->post('chargecode');	
			$sbmt['ORI_CHARGE_CODE']	= $this->input->post('ori_chargecode');	
			$sbmt['ORI_AMOUNT']			= $this->input->post('ori_amount');	
			$sbmt['ORI_DATE']			= $this->input->post('ori_date');	
			$sbmt['ORI_REMARKS']		= $this->input->post('ori_remarks');		
			$sbmt['TANGGAL_KWITANSI']  	= $this->input->post('receipt_date');
			$sbmt['TOTAL'] 				= $this->input->post('amount');
			$sbmt['KETERANGAN']  	 	= $this->input->post('remarks');
			$sbmt['KATEGORI']  	 		= $this->input->post('categoryclaim');
			$sbmt['status_id']  	 	= $this->input->post('status_id');
			$sbmt['statRevise']  	 	= $this->input->post('statRevise');
            $response = $this->edit_model->claim_update($sbmt);

            echo $response;
		}
	}
	
	function ambilkode2(){
		$id = $this->input->get('code');
		$this_id = $this->user['id'];
		$div = $this->_get_employee_division($this_id);
		$tampil = $this->edit_model->get_ccByTipe($id, $div);?>			
		<select id="edit_cc_claim" >
			<option style="display: none;" value=""> --choose one---</option>
			<?foreach($tampil as $data){?>
				<option value="<?php echo $data['CHARGE_CODE']?>"><?php echo $data['PROJECT_DESCRIPTION']; ?></option>
			<?}?>
		</select><?
	}
	
	function ambilapproval(){
		$id = $this->input->get('code');
		$this_id = $this->user['id'];
		$div = $this->_get_employee_division($this_id);
		$tampil = $this->edit_model->get_ccByCC($id);?>
		<?foreach($tampil as $data){?>
			<input type="text" readonly value="<?php echo $data['approval']?>">
			<input type="hidden" id="edit-get-approval" readonly value="<?php echo $data['empid']?>">
		<?}		
	}
	
	function getTunjangan(){
		$employeeID = $this->user['id'];
		$expense = $this->input->get('code');
		$year = $this->input->get('year_kw');
		$month = $this->input->get('month_kw');
		$tnj = $this->edit_model-> get_tunjangan($employeeID, $expense, $year,$month);?>
		<select  id="hd_edit_tunjangan" hidden><?
		foreach($tnj as $data){?>
			<option value="<?= $data['amount']?>"><?= $data['amount'] ?></option><?php } ?>
		</select> <?
	}
}

/* End of file c_oas023.php */
/* Location: ./application/controllers/c_oas023.php */
?>