  <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS057
* Program Name     : Form Approval BT
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
		
		$param['submission_list']	= $this->bt_model->get_list_tr($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		$param['class'] = $this->bt_model->list_class();
		$param['h_m'] = $this->bt_model->list_h_m();
		$param['h_m_h'] = $this->bt_model->list_h_m_h();
		
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
		$sbt['ARRIVAL_DATE_IN_REGION_OF_ORIGIN']  	  = $this->input->post('ARRIVAL_DATE_IN_REGION_OF_ORIGIN');
		$sbt['A_HOUR_R']  	  = $this->input->post('A_HOUR_R');
		$sbt['A_MINUTE_R']  	  = $this->input->post('A_MINUTE_R');
		$sbt['DEPARTURE_FROM_THE_DESTINATION']  	  = $this->input->post('DEPARTURE_FROM_THE_DESTINATION');
		$sbt['D_HOUR_R']  	  = $this->input->post('D_HOUR_R');
		$sbt['D_MINUTE_R']  	  = $this->input->post('D_MINUTE_R');
		$sbt['PRICE_ARRIVAL']  	  = $this->input->post('PRICE_ARRIVAL');
		$sbt['PRICE_DEPARTURE']  	  = $this->input->post('PRICE_DEPARTURE');
		$sbt['REMARK']  	  = $this->input->post('REMARK');
		$param['not_info'] = $this->bt_model->transport_save($sbt);
        $param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($sbt['BT_ID']);
		
		$param['submission_list']	= $this->bt_model->get_list_tr($sbt['BT_ID']);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		
		// printz($param);
		$this->load->view('v_oas067', $param);
			
		}
	}
}