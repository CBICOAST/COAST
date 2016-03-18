<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS014
* Program Name     : Detail Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS014 extends MY_Controller {

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
		
		$this->load->model('m_oas014', 'lv_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas014');
	}

	function load_form ($form_id)
	{
		$param['form_detail'] = $this->lv_form_model->get_form_detail($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);

		$param['form_remarks'] = $this->lv_form_model->get_form_remarks($form_id);

		// Jika cuti tahunan, ambil sisa cuti dari sisa cuti tahunan keryawan
		if($param['form_detail'] == '1'){
			$param['leave_left'] = $this->_get_employee_annual_leave_left($param['form_detail']['employee_id']);
		}else
		// Jika bukan cuti tahunan, ambil jatah cuti maksimal dari tabel cuti
		{

			$param['leave_left'] = $param['form_detail']['length'];
		}
		
		$param['detail_leave_left'] = $param['leave_left'] - $param['form_detail']['amount'];

		// printz($param);
		$this->load->view('v_oas014', $param);
	}


}

/* End of file c_oas014.php */
/* Location: ./application/controllers/c_oas014.php */