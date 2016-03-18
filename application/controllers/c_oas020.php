<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS020
* Program Name     : Show Calendar
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 28-08-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS020 extends MY_Controller {

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

		$this->load->model('m_oas020', 'calendar_model');
		
	}

	function index()
	{
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
	}

	function load_calendar()
	{
		$this->load->view('v_oas020');
	}

	function feed_event()
	{
		$feed_list = array();
		$response = $this->calendar_model->get_leave_list_feed();
		foreach ($response as $key => $value) {
			$feed_list[] = array(
				'id' => $value['leave_id'],
				'start' => $value['start_dt'],
				'end' => $value['end_dt'],
				'title' => $value['employee_name']);
		}
		header("Content-Type: application/json");
		echo json_encode($feed_list);
	}
}

/* End of file c_oas020.php */
/* Location: ./application/controllers/c_oas020.php */