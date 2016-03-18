<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS031
* Program Name     : List Document
* Description      :
* Environment      : PHP 5.4.4
* Author           : winni ok :)
* Version          : 01.00.00
* Creation Date    : 14-9-2015 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

 
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS031 extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$index		= $this->config->item('index_page');
		$host		= $this->config->item('base_url');
		$this->url	= empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));	
		$this->load->model('m_oas031', 'list_reportbt_model');		
	}
	function load_view()
	{
		$employeeID					= $this->user['id'];
		$param['this_id']	= $this->user['id']; 
		$param['submission_list']	= $this->list_reportbt_model->get_list();
		$param['doc_list']	= $this->list_reportbt_model->get_list();
		$param['this_email']		= $this->user['email'];	
		$param['this_name'] 		= $this->user['name'];
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		
		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);

		
		$this->load->view('v_oas031', $param);
	}
	
	function _get_post_data() 	
	{ 
		$search['doc_id']		= $this->input->get('doc_id'); 	
		$search['year']					= $this->input->get('year'); 	
		
 		return $search; 	
	} 
	
	function search() 
	{
		$search				= $this->_get_post_data();
		$param['this_id']	= $this->user['id']; 
		$employeeID					= $this->user['id'];
		$param['this_email']		= $this->user['email'];	
		$param['this_name'] 		= $this->user['name'];
		$param['doc_list']	= $this->list_reportbt_model->get_list();
		$param['submission_list']	= $this->list_reportbt_model->get_search_list($search);
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);

		
		$this->load->view('v_oas031', $param);  	
	} 	
	
	function delete_doc($id)
	{
	
		$item_id = $this->input->get('item_id');
	
		$deleteItem = $this->list_reportbt_model->delete_itemdoc($item_id);
		$param['item_list']		= $this->list_reportbt_model->get_item_list();
		$param['submission_list']	= $this->list_reportbt_model->get_list();
		$this->load->view('v_oas031', $param);
	}
}