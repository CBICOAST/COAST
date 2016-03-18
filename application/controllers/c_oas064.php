<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS064
* Program Name     : Add/Edit Dim Per Level
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 07:20:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS064 extends MY_Controller {

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

		$this->load->model('m_oas064', 'cost_model');
		
	}

	
	function load_edit($costId)
	{
		$param['cost_info'] = $this->cost_model->get_cost_info($costId);
		$param['status_edit'] = 1;

		$this->load->view('v_oas064', $param);
	}
	
	function check_data()
	{
		if($this->input->post('ajax') == '1')
		{
			$response = 0;
			$empl_id    			 = $this->input->post('employeeId');
			$email 		 			 = $this->input->post('email');         

            if($this->cost_model->count_employee_id($empl_id) != "0"){
            	$response = $response + 1;
            }

            if($this->cost_model->count_employee_email($email) != "0"){
            	$response = $response + 2;
            }

            echo $response;
		}
	}


	function update_employee()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']					= $this->user['email'];
			$sbmt['LEVEL_ID']  			= $this->input->post('cost_id');
			$sbmt['LEVEL_NAME']  			= $this->input->post('destination');
            $sbmt['DIM_AMOUNT']	= $this->input->post('amount_dim');
			$sbmt['DIM_AMOUNT_DOMESTIK']	= $this->input->post('amount_dim_dom');
			$sbmt['DIM_AMOUNT_INTERNATIONAL']	= $this->input->post('amount_dim_int');
            $response = $this->cost_model->updateCostBTR($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas064.php */
/* Location: ./application/controllers/c_oas064.php */