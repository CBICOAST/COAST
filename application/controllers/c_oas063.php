<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS063
* Program Name     : Setting Dim Per Level
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 08:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS063 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->load->model('m_oas063','setting_cost_model');
	}	

	function load_view()
	{		
		$param['destination_list']		= $this->setting_cost_model->get_destination_list();
		$param['cost_list']		= $this->setting_cost_model->get_search_list();
		$this->load->view('v_oas063', $param);
	}
	
	function search()
	{
		$search['destination']	= $this->input->get('destination');
		$param['cost_list']		= $this->setting_cost_model->get_search_list($search['destination']);
		$param['search_param']	= $search;
		
		$this->load->view('v_oas063', $param);
	}
	
}

/* End of file c_oas063.php */
/* Location: ./application/controllers/c_oas063.php */