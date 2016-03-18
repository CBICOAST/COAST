<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS097
* Program Name     : Add/Edit Setting Limit Nominal Notif to Director Untuk PR
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma 
* Version          : 01.00.00
* Creation Date    : 16-03-2015 19:30:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS097 extends MY_Controller {

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

		$this->load->model('m_oas097', 'limit_nominal_model');
		
	}

	function index()
	{
	}

//=====================  FORM SUBSMISSION  =====================
	function load_form()
	{
		$param['list_type'] = $this->limit_nominal_model->get_type_list();		
		$param['list_employee'] = $this->limit_nominal_model->get_employee_list();
		$this->load->view('v_oas097');
		
	}
	
	function load_edit_form($typeid)
	{
		$param['type_data'] = $this->limit_nominal_model->getFormInfo($typeid);
		$param['list_type'] = $this->limit_nominal_model->get_type_list();
		$this->load->view('v_oas097', $param);
	}

	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			// $sbmt['LeaveNewType']     		= $this->input->post('LeaveNewType');
			$sbmt['this_email'] 	= $this->user['email'];
			$sbmt['CURRENCY']	= $this->input->post('currencyid');
			$sbmt['NOMINAL_PR']		= $this->input->post('limit_nominal');
			
            $response = $this->limit_nominal_model->limit_nominal_new_type($sbmt);

            echo $response;
		}
	}

	function update_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_email'] 	= $this->user['email'];
			$sbmt['CURRENCY']	= $this->input->post('currencyid');
			$sbmt['NOMINAL_PR']		= $this->input->post('limit_nominal');
            $response = $this->limit_nominal_model->update_limit_nominal_new_typePR($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas097.php */
/* Location: ./application/controllers/c_oas097.php */
?>