<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS048
* Program Name     : Daftar Setting Permission Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 20-02-2015 21:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS073 extends MY_Controller {

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

		$this->load->model('m_oas073','po_list_model');

	}
	
	function index()
	{
		
		$this->load->view('v_oas073');
	}

	function load_view()
	{
		$param['user_list']		= $this->po_list_model->get_user();
		$param['employee_list_po'] = $this->po_list_model->get_employee_list_po();
		$this->load->view('v_oas073', $param);
	}

	function load_view_read_only()
	{
		$param['user_list']		= $this->po_list_model->get_user();
		$param['employee_list_po'] = $this->po_list_model->get_employee_list_po();
		$param['readonly'] = 1;
		$this->load->view('v_oas073', $param);
	}

	function search_readonly()
	{
		$search['employeeid']	= $this->input->get('employeeid');
		$param['user_list']		= $this->po_list_model->get_user($search['employeeid']);
		$param['search_param']	= $search;
		$param['employee_list_po'] = $this->po_list_model->get_employee_list_po();
		$param['readonly']		= 1;
		$this->load->view('v_oas073', $param);
	}
	
	function search()
	{
		$search['employeeid']	= $this->input->get('employeeid');
		$param['user_list']		= $this->po_list_model->get_user($search['employeeid']);
		$param['search_param']	= $search;
		$param['employee_list_po'] = $this->po_list_model->get_employee_list_po();
		$this->load->view('v_oas073', $param);
	}
	
	function deladd_priv_po($id,$st)
	{
	
		$param['deladd_priv_po'] = $this->po_list_model->deladd_priv_po($id,$st);
		$param['user_list']		= $this->po_list_model->get_user();
		$param['employee_list_po'] = $this->po_list_model->get_employee_list_po();
		$this->load->view('v_oas073', $param);
	}
}

/* End of file c_oas073.php */
/* Location: ./application/controllers/c_oas073.php */