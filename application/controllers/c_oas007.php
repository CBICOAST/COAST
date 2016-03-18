<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS007
* Program Name     : Informasi Permohonan bisnis travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 16-12-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS007 extends MY_Controller {

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

		$this->load->model('m_oas007','info_model');
		
		$show_it = $this->info_model->get_show_status($this->user['id']);

		if($show_it != "1"){
			redirect("c_oas037/load_view");
		}
	}

	function index()
	{
	}

	function load_view()
	{
		$this->load->view('v_oas007');
	}

	function dont_show_again()
	{
		$response = $this->info_model->turn_off_bt_information($this->user['id']);
		echo $response;
	}
}

/* End of file c_oas009.php */
/* Location: ./application/controllers/c_oas007.php */