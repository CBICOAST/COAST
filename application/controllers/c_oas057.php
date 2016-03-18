 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS057
* Program Name     : Form Approval  BT (RM and Finance)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS057 extends MY_Controller {

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

		$this->load->model('m_oas057', 'bt_model');		
	}


	function index()
	{		
		$this->load->view('v_oas057');
	}
	
	//Mengambil data untuk ditampilkan
	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($form_id);
		$param['submission_list']	= $this->bt_model->get_list_tr($form_id);
		$param['submission_acc_list']	= $this->bt_model->get_list_ac($form_id);
		
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_ga2'] = $this->_get_employee_ga2($param['form_detail']['employee_id']);
		$param['class'] = $this->bt_model->list_class();
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
		
 		$param['employee_list'] = $this->bt_model->get_employee_list(); 
		
		// printz($param);
		$this->load->view('v_oas057', $param);
	}
	
	//untuk mengambil data submit
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['this_email'] = $this->user['email'];
			
			$sbmt['GA'] 	 		  = $this->input->post('ga');
			$sbmt['GA_EMAIL'] 	 		  = $this->input->post('ga_email');
			$sbmt['GA_NAME'] 	 		  = $this->input->post('ga_name');
			
			$sbmt['REQUESTER']		  = $this->input->post('treveller');
			$sbmt['REQUESTER_NAME']		  = $this->input->post('treveller_name');
			$sbmt['REQUESTER_EMAIL']		  = $this->input->post('treveller_email');
			
			$sbmt['CREATED']		  = $this->input->post('created');
			$sbmt['CREATED_NAME']		  = $this->input->post('created_name');
			$sbmt['CREATED_EMAIL']		  = $this->input->post('created_email');
			
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['CA_ID']     	  = $this->input->post('CA_ID');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['ref_no_ca']		  = $this->input->post('ref_no_ca');
			$sbmt['ref_no']			  = $this->input->post('ref_no');
			$sbmt['this_email'] 	  = $this->user['email'];
			$sbmt['REMARKS']		  = $this->input->post('remarks');
			$sbmt['STATUS']  	 	  = $this->input->post('approval');
			$sbmt['status_name']  	 	  = $this->input->post('status_name');
			$sbmt['SENDER_EMPLOYEE_ID']		  	= $this->input->post('aprove');
			$sbmt['ACTIVITY_TYPE_ID']  	 	  = $this->input->post('activity');
			
			$sbmt['FINAL_APPROVE'] 	 		  = $this->input->post('ga2');
			$sbmt['FINAL_APPROVE_NAME'] 	 		  = $this->input->post('ga2_name');
			$sbmt['FINAL_APPROVE_EMAIL'] 	 		  = $this->input->post('ga2_email');
			
            $response = $this->bt_model->save_confirmation($sbmt);
			}
			
			
	}
	
	function save_accepted()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbt['this_id'] = $this->user['id'];
		$sbt['this_name'] = $this->user['name'];
		$sbt['this_email'] = $this->user['email'];
		
		$sbt['BT_ID']  	  = $this->input->post('BT_ID');
		$sbt['CA_ID']  	  = $this->input->post('CA_ID');
		
		$sbt['GA2']  	  = $this->input->post('ga2');
		$sbt['GA2_NAME']  	  = $this->input->post('ga2_name');
		$sbt['GA2_EMAIL']  	  = $this->input->post('ga2_email');
		
		$sbt['GA']  	  = $this->input->post('ga');
		$sbmt['GA_EMAIL'] 	 		  = $this->input->post('ga_email');
		$sbmt['GA_NAME'] 	 		  = $this->input->post('ga_name');
		$sbmt['status_name']  	 	  = $this->input->post('status_name');
		$sbt['REMARK']  	  = $this->input->post('REMARK');
		
		$sbt['ref_no']  	  = $this->input->post('ref_no');
		$sbt['ref_no_ca']  	  = $this->input->post('ref_no_ca');
		
		$sbt['REQUESTER']  	  = $this->input->post('treveller');
		$sbt['REQUESTER_NAME']  	  = $this->input->post('treveller_name');
		$sbt['REQUESTER_EMAIL']  	  = $this->input->post('treveller_email');
		
		$sbt['SENDER_EMPLOYEE_ID']  	  = $this->input->post('SENDER_EMPLOYEE_ID');
		$sbt['STATUS']  	  = $this->input->post('STATUS');
		$sbt['ACTIVITY_TYPE_ID']  	  = $this->input->post('ACTIVITY_TYPE_ID');
		$sbt['TOTAL_AMOUNT_TRANSPORTATION']  	  = $this->input->post('total_transport');
		$sbt['TOTAL_AMOUNT_ACOMODATION']  	  = $this->input->post('total_hotel');
		$sbt['TOTAL_AMOUNT_BT']  	  = $this->input->post('total_amounta_bt');
		
		$response = $this->bt_model->accepted_save($sbt);
        
			
        
			
		}
	}
}
