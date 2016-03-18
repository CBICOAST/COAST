<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS025
* Program Name     : Detail Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 01-10-2014 23:46:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS025 extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		$this->load->model('m_oas025', 'cl_form_model');		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';		
	}

	function index()
	{		
		$this->load->view('v_oas025');
	}

	function load_form ($form_id,$tipe_detail)
	{		
		$param['tipe_detail'] 	= $tipe_detail;
		$param['form_detail'] 	= $this->cl_form_model->get_form_detail($form_id);
		$param['detail_rm'] 	= $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group']	= $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['form_remarks'] 	= $this->cl_form_model->get_form_remarks($form_id);
		$param['div_cc'] 		= $this->cl_form_model->get_chargecode_div($form_id);
		$this->load->view('v_oas025', $param);
	}
}

/* End of file c_oas025.php */
/* Location: ./application/controllers/c_oas025.php */