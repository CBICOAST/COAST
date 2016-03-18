 <?php
 /************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS068
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS068 extends MY_Controller {


function __construct()
	{
		parent::__construct();
		
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas068', 'settings_model');
		
	}

	function index()
	{
	}
//=====================  FORM SUBSMISSION  =====================

	function load_form()
	{
		$this->load->view('v_oas068');
	}
	
	function submit_edit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['APPROVAL']		  	= $this->input->post('aprove');
			$sbmt['ref_no']			  = $this->input->post('ref_no');
			$sbmt['this_email'] 	  = $this->user['email'];
			$sbmt['CLAIM_ID']  				= $this->input->post('bt_id');
			$sbmt['CHARGE_CODE']  				= $this->input->post('chargecode');
			
			$sbmt['TANGGAL_KWITANSI']  		= $this->input->post('receipt_date');
			$sbmt['TOTAL'] 					= $this->input->post('amount');
			$sbmt['KETERANGAN']  	 		= $this->input->post('remarks');
			
            $response = $this->settings_model->claim_update($sbmt);

            echo $response;
		}
	}

	function load_form_edit($id)
	{
	
		$param['this_id'] = $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];	
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['claim_left']		= $this->_get_employee_annual_claim_left($param['this_id']);
		$param['claim_left_min1']	= $this->_get_employee_annual_claim_left_min1($param['this_id']);
		$param['claim_left_min2']	= $this->_get_employee_annual_claim_left_min2($param['this_id']);
		
		$param['claim_kelahiran_left']	= $this->_get_employee_annual_claim_kelahiran_left($param['this_id']);
		$param['claim_kacamata_left']	= $this->_get_employee_annual_claim_kacamata_left($param['this_id']);
		
		$param['claim_telekomunikasi_left']			= $this->_get_employee_annual_claim_telekomunikasi_left($param['this_id']);
		$param['claim_telekomunikasi_left_min1']	= $this->_get_employee_annual_claim_telekomunikasi_left_min1($param['this_id']);
		$param['claim_telekomunikasi_left_min2']	= $this->_get_employee_annual_claim_telekomunikasi_left_min2($param['this_id']);
		
		$param['claim_transport_left']		= $this->_get_employee_annual_claim_transport_left($param['this_id']);
		$param['claim_transport_left_min1']	= $this->_get_employee_annual_claim_transport_left_min1($param['this_id']);
		$param['claim_transport_left_min2']	= $this->_get_employee_annual_claim_transport_left_min2($param['this_id']);
		
		$param['info']		= $this->settings_model->get_info($id);
		$param['approval']	= $this->settings_model->get_approval_name($id);
		$param['allcc']		= $this->settings_model->get_charge_code($id);
		$param['tipechargecode']	= $this->settings_model->get_tipechargecode($id);
		$param['edit_mode'] = 1;

		$this->load->view('v_oas068', $param);
	}
}

/* End of file c_oas068.php */
/* Location: ./application/controllers/c_oas068.php */
?>