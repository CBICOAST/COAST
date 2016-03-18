  <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS043
* Program Name     : Detail Report Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni OKtaviani
* Version          : 01.00.00
* Creation Date    : 23-11-2014 08:54:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS043 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas041', 'ca_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas043');
	}
	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->ca_form_model->get_form_detail($form_id);
		
		$param['form_settle_detail']	= $this->ca_form_model->get_settle_detail($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['this_id']);		
		$param['detail_akun2'] = $this->_get_employee_akun2($param['this_id']);		
		$param['detail_dir'] = $this->_get_employee_dir($param['this_id']);	
		
		$this->load->view('v_oas043', $param);
	}
	
}