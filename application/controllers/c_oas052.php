 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS052
* Program Name     : Form Approval Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 18-11-2014 07:36:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS052 extends MY_Controller {

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
		
		$this->load->model('m_oas052', 'ca_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas052');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);
		$param['form_detail']		= $this->ca_form_model->get_form_detail($form_id);
		$param['detail_rm']			= $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group']		= $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division']	= $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role']		= $this->_get_employee_role($param['form_detail']['employee_id']);		
		$param['detail_dir']		= $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_akun']		= $this->_get_employee_akun($param['form_detail']['employee_id']);
		$this->load->view('v_oas052', $param);
	}
	
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']	= $this->user['id'];
			$sbmt['this_email']  = $this->user['email'];		
			$sbmt['this_name']	= $this->user['name'];
			$sbmt['FORM_ID']	= $this->input->post('form_id');
			$sbmt['STATUS'] 	= $this->input->post('status');
			$sbmt['REMARKS']	= $this->input->post('remarks');
			$sbmt['REQUESTER']	= $this->input->post('requesterid');
			$sbmt['REQ_NAME']	= $this->input->post('requester_name');
			$sbmt['REQ_EMAIL']	= $this->input->post('requester_email');
			$sbmt['ref_no']		= $this->input->post('ref_no');
			$sbmt['status_name']		= $this->input->post('status_name');
			$sbmt['openclose']	= $this->input->post('openclose');
			$sbmt['SENDER_ID']	= $this->input->post('sender');			
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
            $response			= $this->ca_form_model->save_confirmation($sbmt);
		}
	}


	

}