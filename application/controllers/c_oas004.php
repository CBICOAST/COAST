<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS004
* Program Name     : Notification Page and Service
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
*
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS004 extends MY_Controller {

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
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		$this->load->model('m_oas004', 'notification_model');
		
	}

	function load_view()
	{
		$sbmt['this_id']     	= $this->user['id'];
		$param['feed_list'] 	= $this->notification_model->get_notif_list($sbmt);
		$this->notification_model->mark_as_read($sbmt);
		$this->load->view('v_oas004', $param);
	}

	function feed_notification_counter()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']     = $this->user['id'];

            $response = $this->notification_model->get_notif_count($sbmt);
            
            echo $response;
		}
	}

	function feed_leave_left_counter()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']     = $this->user['id'];

            $response = $this->notification_model->get_leave_left_count($sbmt);
			
            echo $response;
		}
	}
	function feed_claim_left_counter()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']     = $this->user['id'];

           $response = $this->notification_model->get_claim_left_count($sbmt);
			
			
            echo $response;
		}
	}
	
	
	
}

/* End of file c_oas004.php */
/* Location: ./application/controllers/c_oas004.php */