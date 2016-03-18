<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS047
* Program Name     : Daftar Setting Limit Nominal Notif to Director
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 22-11-2014 19:16:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS047 extends MY_Controller {

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

		$this->load->model('m_oas047','currency_list_model');
		
	}

	function index()
	{
	}

	function load_view()
	{
		$param['user_list']		= $this->currency_list_model->get_user();
		$param['currency_list'] = $this->currency_list_model->get_currency_list();
		$this->load->view('v_oas047', $param);
	}

	function load_view_read_only()
	{
		$param['user_list']		= $this->currency_list_model->get_user();
		$param['currency_list'] = $this->currency_list_model->get_currency_list();
		$param['readonly']		= 1;
		$this->load->view('v_oas047', $param);
	}

	function search_readonly()
	{
		$search['currencyid'] = $this->input->get('currencyid');
		$param['user_list'] = $this->currency_list_model->get_user($search['currencyid']);
		$param['search_param'] = $search;
		$param['currency_list'] = $this->currency_list_model->get_currency_list();
		$param['readonly'] = 1;
		$this->load->view('v_oas047', $param);
	}
	
	function search()
	{
		$search['currencyid'] = $this->input->get('currencyid');
		$param['user_list'] = $this->currency_list_model->get_user($search['currencyid']);
		$param['search_param'] = $search;
		$param['currency_list'] = $this->currency_list_model->get_currency_list();
		$this->load->view('v_oas047', $param);
	}
}

/* End of file v_oas047.php */
/* Location: ./application/controllers/v_oas047.php */