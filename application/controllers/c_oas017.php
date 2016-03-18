<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS019
* Program Name     : Add/Edit Jenis Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS017 extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas017', 'settings_model');
		
	}

	function index()
	{
	}
//=====================  FORM SUBSMISSION  =====================

	function load_form()
	{


		$this->load->view('v_oas017');
	}
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['TANGGAL']  				= $this->input->post('new_date');
			$sbmt['TIPE_TANGGAL_LIBUR'] 	= $this->input->post('status');
			$sbmt['KETERANGAN']  	 		= $this->input->post('holiday_remarks');
			
            $response = $this->settings_model->leave_new_holiday($sbmt);

            echo $response;
		}
	}

	function submit_edit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['ID']  					= $this->input->post('id');
			$sbmt['TANGGAL']  				= $this->input->post('new_date');
			$sbmt['TIPE_TANGGAL_LIBUR'] 	= $this->input->post('status');
			$sbmt['KETERANGAN']  	 		= $this->input->post('holiday_remarks');
			
            $response = $this->settings_model->leave_update_holiday($sbmt);

            echo $response;
		}
	}

	function load_form_edit($id)
	{
		$param['info'] = $this->settings_model->get_info($id);
		$param['edit_mode'] = 1;

		$this->load->view('v_oas017', $param);
	}
}

/* End of file c_oas017.php */
/* Location: ./application/controllers/c_oas017.php */
?>