<?php
date_default_timezone_set("Asia/Jakarta"); 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS039
* Program Name     : Add/Edit Settlement of Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 12-11-2014 10:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS039 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
				
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas039', 'ca_model');
		
	}
	
		
	function load_view()
	{
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['no_ref'] 			= $this->ca_model->cek_no_ref($param['this_id']);
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_level'] 		= $this->_get_employee_level($param['this_id']);		
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['count_settle'] 		= $this->ca_model->cek_count_settle($param['this_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['this_id']);
		
		$this->load->view('v_oas039', $param);
	}
	function get_noref(){
	$id 	= $this->input->get('code');
	$tampil	= $this->ca_model->get_detail_noRef($id);
	$typecc	= $this->ca_model->get_type_charge_code($id);
	$destination	= $this->ca_model->get_destination($id);
	$ref_bt	= $this->ca_model->get_ref_bt($id);?>
	
	<select id="select_id_ca"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo $data['id']?>"><?php echo $data['id']; ?></option><?
			}?>
		</select>
	
	<select id="select_ref_bt"><?
			foreach($ref_bt as $data)
			{?>			
				
				<option value="<?php echo $data['ref_bt']?>"><?php echo $data['ref_bt']; ?></option><?
			}?>
		</select>
	
	<select id="select_type_ca"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo $data['type_ca']?>"><?php echo $data['type_ca']; ?></option><?
			}?>
		</select>
		
		<select id="select_amount_save"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo $data['amount'];?>"><?php echo $data['amount']; ?></option><?
			}?>
		</select>
		
		<select id="select_amount"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo number_format($data['amount'],0,',','.');?>"><?php echo $data['amount']; ?></option><?
			}?>
		</select>
		
		<select id="select_charge_code"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo $data['charge_code']?>"><?php echo $data['charge_code']; ?></option><?
			}?>
		</select>
		<select id="select_currency"><?
			foreach($tampil as $data)
			{?>	
				<option value="<?php echo $data['currency']?>"><?php echo $data['currency']; ?></option><?
			}?>
		</select>
		
		<select id="select_description"><?
			foreach($tampil as $data)
			{?>			
				
				<option value="<?php echo $data['description']?>"><?php echo $data['description']; ?></option><?
			}?>
		</select>
		
		<select id="select_destination"><?
			foreach($destination as $data)
			{?>			
				
				<option value="<?php echo $data['destination']?>"><?php echo $data['destination']; ?></option><?
			}?>
		</select>
		
		
		<select id="select_typecc"><?
			foreach($typecc as $data)
			{?>			
				
				<option value="<?php echo $data['type_cc']?>"><?php echo $data['type_cc']; ?></option><?
			}?>
		</select><?
	}
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{		
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_NAME'] = $this->user['name'];
			$sbmt['EMPLOYEE_EMAIL'] = $this->user['email'];
			$sbmt['CA_ID']			= $this->input->post('ca_id');
			$sbmt['RECEIPT_DATE']  	= $this->input->post('tanggalKwitansi');
            $sbmt['AMOUNT'] 		= $this->input->post('amount');
            $sbmt['REMARKS']	 	= $this->input->post('remarks');
            $sbmt['REMAINING']	 	= $this->input->post('remaining');
            $sbmt['PAYMENT_METHOD']	 = $this->input->post('paymentMethod');
			$sbmt['NO_REF']	 		= $this->input->post('noRef1');
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
			$sbmt['FINANCE'] 	 		  = $this->input->post('akuntan');
			$sbmt['FINANCE_EMAIL'] 	 		  = $this->input->post('akuntan_email');
			$sbmt['FINANCE_NAMA'] 	 		  = $this->input->post('akuntan_nama');

            $response = $this->ca_model->submitSetForm($sbmt);

            echo $response;
		}
	}
	
	function load_edit ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['this_level'] 		= $this->_get_employee_level($param['this_id']);		
		
		$param['form_detail'] = $this->ca_model->get_form_detail($form_id);
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['no_ref'] 			= $this->ca_model->cek_no_ref($param['this_id']);
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['this_id']);
		$param['status_edit'] = 1;
		
		$this->load->view('v_oas039', $param);
	}

	function update_settle()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']    = $this->user['id'];
			
			$sbmt['EMPLOYEE_NAME'] = $this->user['name'];
			$sbmt['this_email'] = $this->user['email'];
			$sbmt['CA_ID']			= $this->input->post('ca_id');
			$sbmt['RECEIPT_DATE']  	= $this->input->post('tanggalKwitansi');
            $sbmt['AMOUNT'] 		= $this->input->post('amount');
            $sbmt['REMARKS']	 	= $this->input->post('remarks');
            $sbmt['REMAINING']	 	= $this->input->post('remaining');
            $sbmt['PAYMENT_METHOD'] = $this->input->post('paymentMethod');
			$sbmt['status_id']		= $this->input->post('status_id');
			$sbmt['NO_REF']			= $this->input->post('noRef');
			$sbmt['no_ref']			= $this->input->post('no_ref');
			$sbmt['FINANCE'] 	 		  = $this->input->post('akuntan');
			$sbmt['FINANCE_EMAIL'] 	 		  = $this->input->post('akuntan_email');
			$sbmt['FINANCE_NAMA'] 	 		  = $this->input->post('akuntan_nama');

            $response = $this->ca_model->updateSettleForm($sbmt);
		
		}
	}
	
}


/* End of file c_oas039.php */
/* Location: ./application/controllers/c_oas039.php */