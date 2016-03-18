<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS002
* Program Name     : Main Frame
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS002 extends MY_Controller {

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
		$this->load->model('m_oas002', 'main_frame_model');		
	}

	function index()
	{
		$param['this_id'] = $this->user['id'];
		
		$param['this_name'] = $this->user['name'];
		$param['this_email'] = $this->user['email'];
		$param['this_group'] = $this->user['group'];
		$param['this_rm'] = $this->_get_employee_rm($param['this_id']);
		$param['this_superAdmin'] = $this->_get_employee_superAdmin();
		$param['this_level'] = $this->_get_employee_level($param['this_id']);
		$param['menu_list'] = $this->main_frame_model->get_menu_list($param);
		$param['menu_superAdmin'] = $this->main_frame_model->get_menu_superAdmin();
		$param['this_pwdStat'] = $this->_get_employee_pwdstatus($param['this_id']);
		
		$this->load->view('v_oas002', $param);
	}

	
}

/* End of file c_oas002.php */
/* Location: ./application/controllers/c_oas002.php */