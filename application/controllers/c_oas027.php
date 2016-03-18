<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS027
* Program Name     : Add/Edit Jenis Charge Code
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 04-10-2014 32:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS027 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas027', 'charge_code_model');
		
	}

	function index()
	{
	}
	function load_form()
	{
		$param['list_division'] = $this->charge_code_model->get_division_list();
		$this->load->view('v_oas027', $param);		
	}

	function load_edit_form($typeid)
	{
		$param['list_division'] = $this->charge_code_model->get_division_list();
		$param['type_data'] = $this->charge_code_model->charge_code_get_type($typeid);
		$this->load->view('v_oas027', $param);
	}
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_email']				= $this->user['email'];
			$sbmt['CHARGE_CODE']     		= $this->input->post('id');
			$sbmt['PROJECT_DESCRIPTION']	= $this->input->post('descript_project');
			$sbmt['TYPE']					= $this->input->post('description_type');
			$sbmt['DIVISION_ID']			= $this->input->post('cc_division');
			$sbmt['STATUS'] 	   	 		= $this->input->post('status');
			$cek_cc = $this->charge_code_model->cek_chargecode($sbmt);
			if ($cek_cc == '0'){	
				$response = $this->charge_code_model->charge_code_new_type($sbmt);
				echo "<script language='javascript'>
						$('#new-chargecode-msg').html('Charge Code Berhasil ditambahkan');
						setTimeout(function(){
							form_dialog_close();
						}, 1000);  
					</script>";	
			}
			else{
				echo "<script language='javascript'>
						$('#new-chargecode-msg').html('<code>Charge Code telah ada, silahkan  ganti chargecode</code>');
					</script>";	
					
			}
		}
	}

	function update_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']				= $this->input->post('cc_id');
			$sbmt['this_email']				= $this->user['email'];
			$sbmt['CHARGE_CODE']     		= $this->input->post('id');
			$sbmt['PROJECT_DESCRIPTION']	= $this->input->post('descript_project');
			$sbmt['TYPE']					= $this->input->post('description_type');
			$sbmt['DIVISION_ID']			= $this->input->post('cc_division');
			$sbmt['STATUS'] 		   	 	= $this->input->post('status');
			
            $response = $this->charge_code_model->update_charge_code_type($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas027.php */
/* Location: ./application/controllers/c_oas027.php */
?>