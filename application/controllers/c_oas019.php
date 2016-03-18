<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS019
* Program Name     : Add/Edit Jenis Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS019 extends MY_Controller {

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

		$this->load->model('m_oas019', 'leave_type_model');
		
	}

	function index()
	{
	}
//=====================  FORM SUBSMISSION  =====================

	function load_form()
	{
		$this->load->view('v_oas019');
	}

	function load_edit_form($typeid)
	{
		$param['type_data'] = $this->leave_type_model->leave_get_type($typeid);
		$this->load->view('v_oas019', $param);
	}
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_email'] 				= $this->user['email'];
			$sbmt['LEAVE_TYPE_NAME']     		= $this->input->post('name_leave');
			$sbmt['LEAVE_LENGTH']  				= $this->input->post('length_leave');
			$sbmt['LEAVE_TYPE_DESCRIPTION'] 	= $this->input->post('description_type');
			$sbmt['LEAVE_SUBMISSION_MIN']  	 	= $this->input->post('submission_leave');
			$sbmt['GENDER_TYPE'] 	   	 		= $this->input->post('type_gender');
			$sbmt['STATUS'] 		   	 		= $this->input->post('status');
			
            $response = $this->leave_type_model->leave_new_type($sbmt);

            echo $response;
		}
	}

	function update_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] 					= $this->input->post('leave_id');
			$sbmt['this_email'] 				= $this->user['email'];
			$sbmt['LEAVE_TYPE_NAME']     		= $this->input->post('name_leave');
			$sbmt['LEAVE_LENGTH']  				= $this->input->post('length_leave');
			$sbmt['LEAVE_TYPE_DESCRIPTION'] 	= $this->input->post('description_type');
			$sbmt['LEAVE_SUBMISSION_MIN']  	 	= $this->input->post('submission_leave');
			$sbmt['GENDER_TYPE'] 	   	 		= $this->input->post('type_gender');
			$sbmt['STATUS'] 		   	 		= $this->input->post('status');
			
            $response = $this->leave_type_model->update_leave_type($sbmt);

            echo $response;
		}
	}
}

/* End of file c_oas019.php */
/* Location: ./application/controllers/c_oas019.php */
?>