  <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS067
* Program Name     : Form Approval  BT (GA)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati(Transportation) & Winni Oktaviani (Acomodation)
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS067 extends MY_Controller {

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

		$this->load->model('m_oas067', 'bt_model');		
	}


	function index()
	{		
		$this->load->view('v_oas067');
	}
	
	//Mengambil data untuk ditampilkan
	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($form_id);
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
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
		$this->load->view('v_oas067', $param);
	}
	
	function save_transport()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbt['BT_ID']  	  = $this->input->post('BT_ID');
		$sbt['DESTINATION']  	  = $this->input->post('DESTINATION');
		$sbt['TRANSPORTATION']  	  = $this->input->post('TRANSPORTATION');
		$sbt['TRANSPORTATION_CLASS']  	  = $this->input->post('TRANSPORTATION_CLASS');
		$sbt['ARRIVAL_DATE_IN_DESTINATION']  	  = $this->input->post('ARRIVAL_DATE_IN_DESTINATION');
		$sbt['A_HOUR_D']  	  = $this->input->post('A_HOUR_D');
		$sbt['A_MINUTE_D']  	  = $this->input->post('A_MINUTE_D');
		$sbt['DEPARTURE_FROM_THE_REGION_OF_ORIGIN']  	  = $this->input->post('DEPARTURE_FROM_THE_REGION_OF_ORIGIN');
		$sbt['D_HOUR_D']  	  = $this->input->post('D_HOUR_D');
		$sbt['D_MINUTE_D']  	  = $this->input->post('D_MINUTE_D');
		
		$sbt['PRICE_ARRIVAL']  	  = $this->input->post('PRICE_ARRIVAL');
		$sbt['REMARK']  	  = $this->input->post('REMARK');
		$param['not_info'] = $this->bt_model->transport_save($sbt);
        $param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($sbt['BT_ID']);
		$param['class'] = $this->bt_model->list_class();
		$param['submission_list']	= $this->bt_model->get_list_tr($sbt['BT_ID']);
		$param['submission_acc_list']	= $this->bt_model->get_list_ac($sbt['BT_ID']);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_ga2'] = $this->_get_employee_ga2($param['form_detail']['employee_id']);
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
 		$param['employee_list'] = $this->bt_model->get_employee_list(); 
		$this->load->view('v_oas067', $param);
			
		}
	}
	
	
	
	function save_konfirmGA()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbt['this_id'] = $this->user['id'];
		$sbt['this_name'] = $this->user['name'];
		$sbt['this_email'] = $this->user['email'];
		$sbt['BT_ID']  	  = $this->input->post('BT_ID');
		$sbt['status_id']  	  = $this->input->post('status_id');
		$sbt['GA2']  	  = $this->input->post('ga2');
		$sbt['GA2_NAME']  	  = $this->input->post('ga2_name');
		$sbt['GA2_EMAIL']  	  = $this->input->post('ga2_email');
		$sbt['GA']  	  = $this->input->post('ga');
		$sbmt['GA_EMAIL'] 	 		  = $this->input->post('ga_email');
		$sbmt['GA_NAME'] 	 		  = $this->input->post('ga_name');
		$sbt['REMARK']  	  = $this->input->post('REMARK');
		
		$sbt['ref_no']  	  = $this->input->post('ref_no');
		$sbt['REQUESTER']  	  = $this->input->post('treveller');
		$sbt['REQUESTER_NAME']  	  = $this->input->post('treveller_name');
		$sbt['REQUESTER_EMAIL']  	  = $this->input->post('treveller_email');
		$sbt['SENDER_EMPLOYEE_ID']  	  = $this->input->post('SENDER_EMPLOYEE_ID');
		$sbt['ACTIVITY_TYPE_ID']  	  = $this->input->post('ACTIVITY_TYPE_ID');
		
		$response = $this->bt_model->konfirmGA_save($sbt);
        
			
        
			
		}
	}
	
	
	function save_accomodation()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbt['BT_ID']  	  = $this->input->post('BT_ID');
		$sbt['BOOKING_NAME']  	  = $this->input->post('BOOKING_NAME');
		$sbt['HOTEL_NAME']  	  = $this->input->post('HOTEL_NAME');
		$sbt['ADDRESS']  	  = $this->input->post('ADDRESS');
		$sbt['CHECKIN_DATE']  	  = $this->input->post('CHECKIN_DATE');
		$sbt['CHECKIN_HOUR']  	  = $this->input->post('CHECKIN_HOUR');
		$sbt['CHECKIN_MINUTE']  	  = $this->input->post('CHECKIN_MINUTE');
		$sbt['CHECKOUT_DATE']  	  = $this->input->post('CHECKOUT_DATE');
		$sbt['CHECKOUT_HOUR']  	  = $this->input->post('CHECKOUT_HOUR');
		$sbt['CHECKOUT_MINUTE']  	  = $this->input->post('CHECKOUT_MINUTE');
		$sbt['REMARKS']  	  = $this->input->post('REMARKS');
		$sbt['ROOM_RATE']  	  = $this->input->post('ROOM_RATE');
		
		$param['acc_save'] = $this->bt_model->accomodation_save($sbt);
        $param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($sbt['BT_ID']);
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
		$param['submission_list']	= $this->bt_model->get_list_tr($sbt['BT_ID']);
		$param['submission_acc_list']	= $this->bt_model->get_list_ac($sbt['BT_ID']);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_ga2'] = $this->_get_employee_ga2($param['form_detail']['employee_id']);
		$param['class'] = $this->bt_model->list_class();
 		$param['employee_list'] = $this->bt_model->get_employee_list(); 
		$this->load->view('v_oas067', $param);
			
		}
	}
	function del_acc($acid,$btid)
	{
	
		$param['del_acc'] = $this->bt_model->delete_accomodation($acid);
		$employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['submission_list']	= $this->bt_model->get_list_tr($btid);
		$param['submission_acc_list']	= $this->bt_model->get_list_ac($btid);
		$param['class'] = $this->bt_model->list_class();
 		$param['employee_list'] = $this->bt_model->get_employee_list(); 
		$param['form_detail'] = $this->bt_model->get_form_detail($btid);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_ga2'] = $this->_get_employee_ga2($param['form_detail']['employee_id']);
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
		$this->load->view('v_oas067', $param);
	}
	
	function del_transport($trid,$btid)
	{
	
		$param['del_transport'] = $this->bt_model->delete_transportation($trid);
		$employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['submission_list']	= $this->bt_model->get_list_tr($btid);
		$param['submission_acc_list']	= $this->bt_model->get_list_ac($btid);
		$param['class'] = $this->bt_model->list_class();
 		$param['employee_list'] = $this->bt_model->get_employee_list(); 
		$param['form_detail'] = $this->bt_model->get_form_detail($btid);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_ga2'] = $this->_get_employee_ga2($param['form_detail']['employee_id']);
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
		$this->load->view('v_oas067', $param);
	}
}