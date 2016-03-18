<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS050
* Program Name     : Informasi Pengajuan Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 16-12-2014 13:10:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0		     28-03-2015	       Metta Kharisma	      Add Function to show status ca
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS050 extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
		$this->load->model('m_oas050','info_model_ca');
		
		$show_it = $this->info_model_ca->get_show_status_ca($this->user['id']);

		if($show_it != "1"){
			redirect("c_oas038/load_view");
		}
	}

	function load_view()
	{
	
		$this->load->view('v_oas050');
	}
	
	function dont_show_again()
	{
		$response = $this->info_model_ca->turn_off_ca_information($this->user['id']);
		echo $response;
	}
	
}

/* End of file c_oas050.php */
/* Location: ./application/controllers/c_oas050.php */