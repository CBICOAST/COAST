<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS094
* Program Name     : Add/Edit List ShipTo
* contactpersonion      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 03-03-2015 14:39:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      contactpersonion
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS094 extends MY_Controller {

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

		$this->load->model('m_oas094', 'user_model');
		
	}

	function load_view()
	{
		$param['list_employee'] = $this->user_model->get_list();
		$this->load->view('v_oas094', $param);
	}

	function load_edit($companyname)
	{
		$param['employee_info'] = $this->user_model->get_list_info($companyname);
		$this->load->view('v_oas094', $param);
	}

	function load_read_only($companyname)
	{
		$param['list_employee'] = $this->user_model->get_list();
		$this->load->view('v_oas094', $param);
	}

	function submit_new_item()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']     				 = $this->user['email'];
			$sbmt['S_COMPANY']    			 = $this->input->post('companyname');
			$sbmt['S_CP']  			 = $this->input->post('contactperson');
			$sbmt['S_ADDRESS']  			 = $this->input->post('alamat');
			$sbmt['S_telpon']  			 = $this->input->post('telpon');
			$sbmt['S_EMAIL']  			 = $this->input->post('email');
			$sbmt['S_NPWP']  			 = $this->input->post('npwp');
            $response = $this->user_model->submitMenuList($sbmt);

            echo $response;
		}
	}

	function update_item()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']     				 = $this->user['email'];
			$sbmt['S_COMPANY']    			 = $this->input->post('companyname');
			$sbmt['S_CP']  			 = $this->input->post('contactperson');
			$sbmt['S_ADDRESS']  			 = $this->input->post('alamat');
			$sbmt['S_telpon']  			 = $this->input->post('telpon');
			$sbmt['S_EMAIL']  			 = $this->input->post('email');
			$sbmt['S_NPWP']  			 = $this->input->post('npwp');
            $response = $this->user_model->updateMenuList($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas094.php */
/* Location: ./application/controllers/c_oas094.php */