<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS090
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

class C_OAS090 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->load->model('m_oas090','setting_list_item');
	}	

	function load_view()
	{		
		$param['item_list']		= $this->setting_list_item->get_item_list();
		$param['cost_list']		= $this->setting_list_item->get_search_list();
		$param['item_pr_list']		= $this->setting_list_item->get_item_pr();
		$this->load->view('v_oas090', $param);
	}
	
	function search()
	{
		$search['destination']	= $this->input->get('destination');
		$param['item_pr_list']		= $this->setting_list_item->get_item_list();
		$param['cost_list']		= $this->setting_list_item->get_search_list($search['destination']);
		$param['search_param']	= $search;
		
		$this->load->view('v_oas090', $param);
	}
	
	function delete_item_pr()
	{
		$item_id = $this->input->get('item_id');
	
		$deleteItem = $this->setting_list_item->delete_itempr($item_id);$param['item_list']		= $this->setting_list_item->get_item_list();
		$param['cost_list']		= $this->setting_list_item->get_search_list();
	
            echo $response;

		$this->load->view('v_oas090', $param);
	}
	
}

/* End of file c_oas090.php */
/* Location: ./application/controllers/c_oas090.php */