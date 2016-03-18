<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS021
* Program Name     : Informasi Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				28-03-2015			Metta Kharisma		 Add Function to show status expense
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS109 extends MY_Controller {

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

		$this->load->model('m_oas109','info_model_expense');
		
		$show_it = $this->info_model_expense->get_show_status_expense($this->user['id']);

		if($show_it != "1"){
			redirect("c_oas075/load_view");
		}
	}

	function index()
	{
	}

	function load_view()
	{
	
		$this->load->view('v_oas109');
	}

	function dont_show_again()
	{
		$response = $this->info_model_expense->turn_off_expense_information($this->user['id']);
		echo $response;
	}
}

/* End of file c_oas021.php */
/* Location: ./application/controllers/c_oas021.php */