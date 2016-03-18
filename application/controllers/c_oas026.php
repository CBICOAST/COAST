<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS026
* Program Name     : CHARGE CODE LIST
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS026 extends MY_Controller {

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

		$this->load->model('m_oas026', 'list_model');
		
	}

	function index()
	{
		
	}

	function _get_post_data()
	{
		$search['chargecodetype_id'] = $this->input->get('chargecodetype');
		$search['chargecode_id'] = $this->input->get('chargecode');
		$search['statuschargecode'] = $this->input->get('statuscc');
		return $search;
	}
	
	function load_view()
	{
		$typeID 						= $this->user['id'];
		$param['type_list']				= $this->list_model->get_list($typeID);
		$param['submission_list']		= $this->list_model->get_list($param);
		$param['list_chargecodetype']	= $this->list_model->get_chargecodetype_list();
		$param['status']	= $this->list_model->get_status();
		
		$this->load->view('v_oas026', $param);
	}
	
	function load_chargecode($chargecodetype_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($chargecodetype_id != ''){
			$chargecode_list = $this->list_model->get_chargecode_list($chargecodetype_id);
			if(isset($chargecode_list)){
				$out[''] = '-- All--';
				foreach ($chargecode_list as $chargecode) {
					$out[$chargecode['id']] = $chargecode['name'];
				}
			}else{
				$out['0'] = '-- DATA NOT FOUND --';
			}
		}
		else
		{
			$out[''] = '-- All --';
		}
		echo(json_encode($out));
	}
	 
	function search()
	{
		$search = $this->_get_post_data();
		$typeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_search_list($typeID, $search);
		$param['list_chargecodetype'] = $this->list_model->get_chargecodetype_list();		
		$param['status']	= $this->list_model->get_status();		
		if($search['chargecodetype_id'] != ''){
			$param['list_chargecode'] = $this->list_model->get_chargecode_list($search['chargecodetype_id']);
		}
		
		$param['search_param'] = $search;
		$this->load->view('v_oas026', $param);
	}
}
/* End of file v_oas026.php */
/* Location: ./application/controllers/v_oas026.php */