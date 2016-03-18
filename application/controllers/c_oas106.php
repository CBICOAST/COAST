<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS106
* Program Name     : Setting Item Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 23-02-215 10:40:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS106 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->load->model('m_oas106','setting_list_item');
	}	

	function load_view()
	{		
		$param['item_list']		= $this->setting_list_item->get_item_list();
		$param['cost_list']		= $this->setting_list_item->get_search_list();
		$this->load->view('v_oas106', $param);
	}
	
	function search()
	{
		$search['destination']	= $this->input->get('destination');
		$param['item_list']		= $this->setting_list_item->get_item_list();
		$param['cost_list']		= $this->setting_list_item->get_search_list($search['destination']);
		$param['search_param']	= $search;
		
		$this->load->view('v_oas106', $param);
	}
	
	function delete_item_pr($id)
	{
	
		$param['delete_item_pr'] = $this->setting_list_item->delete_itempr($id);
		$param['this_id']	 		= $this->user['id'];
		$param['cost_list'] = $this->setting_list_item->get_search_list();		
	

		$this->load->view('v_oas106', $param);
	}
	
}

/* End of file c_oas106.php */
/* Location: ./application/controllers/c_oas106.php */