<?php 
date_default_timezone_set("Asia/Jakarta");
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS011
* Program Name     : Create/Edit Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS011 extends MY_Controller {

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
		
		$this->load->model('m_oas011', 'lv_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		echo date("N", strtotime("2014-08-18"));
		echo $this->isWeekend("2014-08-18");
		echo "<br>";
		$holidays =$this->holidayList("2014-08-19", "2014-08-30");
		echo "Final result: ".$this->get_bDay_Holiday_Total($holidays);
        die();
	}
// =====================  FORM SUBSMISSION  =====================
	function load_form($formTypeId)
	{
		$param['form_data'] = $this->lv_form_model->getFormType($formTypeId);
		$param['this_id'] = $this->user['id'];
		$param['this_name'] = $this->user['name'];
		$param['this_email'] = $this->user['email'];
		$param['this_rm'] = $this->_get_employee_rm($param['this_id']);
		$param['this_group'] = $this->_get_employee_group($param['this_id']);
		$param['this_division'] = $this->_get_employee_division($param['this_id']);
		$param['this_role'] = $this->_get_employee_role($param['this_id']);
		$param['this_join'] = $this->_get_employee_join_date($param['this_id']);

		if($formTypeId == '1'){
			$date1 = new DateTime(Date($param['this_join']));
			$date2 = new DateTime(Date("Y-m-d"));
			$interval = $date1->diff($date2);

			if($interval->days > 90){
				$param['form_data']['length'] = $this->_get_employee_annual_leave_left($param['this_id']);		
			}else{
				$param['form_data']['length'] = 0;
			}

			
		}
		$this->load->view('v_oas011', $param);
	}

	function load_edit_form($formId)
	{
		$param['form_data'] = $this->lv_form_model->getFormInfo($formId);
		$param['edit_stat'] = '1';

		
		
		$param['this_rm'] = $this->_get_employee_rm($param['form_data']['employee_id']);
		$param['this_group'] = $this->_get_employee_group($param['form_data']['employee_id']);
		$param['this_division'] = $this->_get_employee_division($param['form_data']['employee_id']);
		$param['this_role'] = $this->_get_employee_role($param['form_data']['employee_id']);

		if($param['form_data']['id'] == '1'){
			$param['form_data']['length'] = $this->_get_employee_annual_leave_left($param['form_data']['employee_id']);	
		}

		$this->load->view('v_oas011', $param);
	}

	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['EMPLOYEE_NAME']  = $this->user['name'];
			$sbmt['LEAVE_TYPE_ID'] 	 = $this->input->post('leaveTypeId');
			$sbmt['RM_EMAIL'] 	 	= $this->input->post('emailrm');
			$sbmt['RM_NAME'] 	 	= $this->input->post('namarm');
			$sbmt['LEAVE_AMOUNT']  	 = $this->input->post('leaveAmount');
			$sbmt['ADDRESS'] 	   	 = $this->input->post('address');
			$sbmt['PHONE'] 		   	 = $this->input->post('phone');
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
            $sbmt['DATE_START'] 	 = $this->input->post('start_date');
            $sbmt['DATE_END']		 = $this->input->post('end_date');
            $sbmt['DATE_BACK']	 	 = $this->input->post('back_date');
            $sbmt['EMPLOYEE_RM_ID']	 = $this->input->post('employeerm');
			$response = $this->lv_form_model->submitLeaveForm($sbmt);
			echo $response;

            
		}
	}

	function submit_update_form()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id']    	 = $this->user['id'];
			$sbmt['this_email'] 	 = $this->user['email'];
			$sbmt['EMPLOYEE_NAME']  = $this->user['name'];
			$sbmt['RM_EMAIL'] 	 	= $this->input->post('emailrm');
			$sbmt['RM_NAME'] 	 	= $this->input->post('namarm');
			$sbmt['LEAVE_ID']  		 = $this->input->post('formid');
			$sbmt['LEAVE_AMOUNT']  	 = $this->input->post('leaveAmount');
			$sbmt['ADDRESS'] 	   	 = $this->input->post('address');
			$sbmt['PHONE'] 		   	 = $this->input->post('phone');
            $sbmt['SUBMITTED_DATE']  = $this->input->post('submittedDate');
            $sbmt['DATE_START'] 	 = $this->input->post('start_date');
            $sbmt['DATE_END']		 = $this->input->post('end_date');
            $sbmt['DATE_BACK']	 	 = $this->input->post('back_date');

            $response = $this->lv_form_model->updateLeaveForm($sbmt);

            echo $response;
		}
	}


// =====================  FOR FORM ELEMENT INTERACTION  =====================

	function ajax_get_total_holiday(){
		if($this->input->post('ajax') == '1')
		{
			$start = $this->input->post('start_date');
			$end = $this->input->post('end_date');
			$holidays = $this->holidayList($start, $end);

			$bDayHolidays = $this->get_bDay_Holiday_Total($holidays);

			echo $bDayHolidays;
		}
	}

	function get_bDay_Holiday_Total($holidays)
	{
		$total = 0;
		if($holidays)
		{
			foreach ($holidays as $holiday => $value)
			{
				if(!$this->isWeekend($value['TANGGAL']))
				{
					$total++;
				}
			}
		}
		return $total;
	}

	/**
	 * Fungsi untuk melakukan pengecekan apakah tanggal tersebut
	 * merupakan hari libur atau bukan.
	 * @param  string  $date format standar, ex. "2014-08-17"
	 * @return boolean       true of false
	 */
	function isWeekend($date) {
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}

	function isHoliday()
	{
		if($this->input->post('ajax') == '1')
		{

			$day = $this->input->post('day');
			$month = $this->input->post('month');
			$year = $this->input->post('year');			
			echo $this->lv_form_model->checkHoliday($day, $month,$year);
		}
	}

	function holidayList($dt_start, $dt_end){
		return $this->lv_form_model->get_holiday_list($dt_start, $dt_end);
	}
}

/* End of file c_oas011.php */
/* Location: ./application/controllers/c_oas011.php */