 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS080
* Program Name     : Form Detail Purchase Order 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS080 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas071', 'pr_form_model');
		$this->load->model('m_oas080', 'po_form_model');
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas080');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['form_detail'] = $this->po_form_model->get_form_detail($form_id);
		$param['form_status'] = $this->po_form_model->status_po($form_id);
		$param['list_pr'] = $this->po_form_model->get_list_tmppr($form_id);	
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_vendor'] = $this->pr_form_model->get_vendor($form_id);
		$param['detail_shipto'] = $this->pr_form_model->get_shipto($form_id);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_dir'] = $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_pur'] = $this->_get_employee_pur($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		
		$this->load->view('v_oas080', $param);
	}
	
}