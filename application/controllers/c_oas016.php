<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS016
* Program Name     : Master Tanggal Libur
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS016 extends MY_Controller {

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
		
		// $this->load->model('mMain');
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas016', 'list_model');
		
	}

	function index()
	{
		$this->load->view('v_oas016');
	}

	function load_view()
	{
		$typeID = $this->user['id'];

		$param['type_list'] = $this->list_model->get_list($typeID);

		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);

		$this->load->view('v_oas016', $param);
	}
	
	
	function load_view_read_only()
	{
		$typeID = $this->user['id'];

		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);

		$param['type_list'] = $this->list_model->get_list($typeID);
		$param['readonly'] = 1;
		
		// printz($submission_list);
		$this->load->view('v_oas016', $param);
	}

	function search_readonly()
	{
		$search['year'] = $this->input->get('year');
		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);
		$param['type_list'] = $this->list_model->get_search_list($search);
		$param['search_param'] = $search;
		$param['readonly'] = 1;
		$this->load->view('v_oas016', $param);

	}
	
	function search()
	{
		$search['year'] = $this->input->get('year');
		$param['type_list'] = $this->list_model->get_search_list($search);
		$param['search_param'] = $search;

		$param['year_list'][0] = array(	  "id" => DATE("Y")-1,
										"name" => DATE("Y")-1);
		$param['year_list'][1] = array(	  "id" => DATE("Y"),
										"name" => DATE("Y"));
		$param['year_list'][2] = array(	  "id" => DATE("Y")+1,
										"name" => DATE("Y")+1);

		$this->load->view('v_oas016', $param);

		// printz($param);
	}
}
/* End of file c_oas016.php */
/* Location: ./application/controllers/c_oas016.php */
