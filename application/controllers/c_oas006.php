<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS006
* Program Name     : Add/Edit User or Employee Information
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili & Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 & 16-10-2014 10:52:00ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04 Nov 2014	   Metta Kharisma H		 Merubah Submit New Employee
* 2.0				 04 Nov 2014	   Metta Kharisma H		 Merubah Update Employee
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS006 extends MY_Controller {

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

		$this->load->model('m_oas006', 'user_model');
		
	}

	function load_view()
	{
		$param['list_gender'] = $this->user_model->get_gender_list();
		$param['list_marital'] = $this->user_model->get_marital_list();
		$param['list_user_group'] = $this->user_model->get_user_group_list();
		$param['list_position_depth'] = $this->user_model->get_position_depth_list();
		$param['list_position_level'] = $this->user_model->get_position_level_list();
		$param['list_group'] = $this->user_model->get_group_list();
		$param['list_employee'] = $this->user_model->get_employee_list();
		$this->load->view('v_oas006', $param);
	}

	function load_edit($employeeId)
	{
		$param['groupid'] = null;
		$param['divisionid'] = null;

		$param['list_gender'] = $this->user_model->get_gender_list();
		$param['list_marital'] = $this->user_model->get_marital_list();
		$param['list_user_group'] = $this->user_model->get_user_group_list();
		$param['list_position_depth'] = $this->user_model->get_position_depth_list();
		$param['list_position_level'] = $this->user_model->get_position_level_list();
		$param['list_group'] = $this->user_model->get_group_list();
		$param['list_division'] = $this->user_model->get_division_list();
		$param['list_employee'] = $this->user_model->get_employee_list();

		$param['employee_info'] = $this->user_model->get_employee_info($employeeId);

		$param['status_edit'] = 1;

		if($param['employee_info']['POSITION_DEPTH_ID']!='1')
		{
			if($param['employee_info']['POSITION_DEPTH_ID']=='2')
			{
				$param['groupid'] = $param['employee_info']['POSITION_ID'];
			}else
			{
				$param['divisionid'] = $param['employee_info']['POSITION_ID'];
				$param['groupid'] = $this->user_model->get_group($param['divisionid']);
			}
		}

		$this->load->view('v_oas006', $param);
	}

	function load_read_only($employeeId)
	{
		$param['groupid'] = null;
		$param['divisionid'] = null;

		$param['list_gender'] = $this->user_model->get_gender_list();
		$param['list_marital'] = $this->user_model->get_marital_list();
		$param['list_user_group'] = $this->user_model->get_user_group_list();
		$param['list_position_depth'] = $this->user_model->get_position_depth_list();
		$param['list_position_level'] = $this->user_model->get_position_level_list();
		$param['list_group'] = $this->user_model->get_group_list();
		$param['list_division'] = $this->user_model->get_division_list();
		$param['list_employee'] = $this->user_model->get_employee_list();

		$param['employee_info'] = $this->user_model->get_employee_info($employeeId);

		$param['status_edit'] = 1;
		$param['status_read_only'] = 1;

		if($param['employee_info']['POSITION_DEPTH_ID']!='1')
		{
			if($param['employee_info']['POSITION_DEPTH_ID']=='2')
			{
				$param['groupid'] = $param['employee_info']['POSITION_ID'];
			}else
			{
				$param['divisionid'] = $param['employee_info']['POSITION_ID'];
				$param['groupid'] = $this->user_model->get_group($param['divisionid']);
			}
		}

		$this->load->view('v_oas006', $param);
	}

	function load_division($group_id)
	{
		$out = array();
		$division_list = $this->user_model->get_division_list($group_id);
		header('Content-Type: application/x-json; charset=utf-8');
		if(isset($division_list)){
			foreach ($division_list as $division) {
				$out[$division['id']] = $division['name'];
			}
		}else{
			$out['0'] = '-- DATA NOT FOUND --';
		}
		echo(json_encode($out));
	}

	function check_data()
	{
		if($this->input->post('ajax') == '1')
		{
			$response = 0;
			$empl_id    			 = $this->input->post('employeeId');
			$email 		 			 = $this->input->post('email');
            


            if($this->user_model->count_employee_id($empl_id) != "0"){
            	$response = $response + 1;
            }

            if($this->user_model->count_employee_email($email) != "0"){
            	$response = $response + 2;
            }

            echo $response;
		}
	}

	function submit_new_employee()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']     				 = $this->user['email'];
			

			$sbmt['EMPLOYEE_ID']    			 = $this->input->post('employeeId');
			$sbmt['ID_CARD_NUMBER']  			 = $this->input->post('nik');
			$sbmt['EMPLOYEE_NAME']  			 = $this->input->post('name');
			$sbmt['JOIN_DATE']  	 			 = $this->input->post('join_dt');
			$sbmt['MARITAL_STATUS'] 	   	 			 = $this->input->post('marital');
			$sbmt['DEPENDANT'] 	   	 			 = $this->input->post('Dependant');
			$sbmt['GENDER_ID'] 	   	 			 = $this->input->post('gender');
			$sbmt['BIRTH_DATE'] 		  	 	 = $this->input->post('birth');
			$sbmt['ADDRESS']	 		  	 	 = $this->input->post('address');
			$sbmt['PHONE'] 				  	 	 = $this->input->post('phone');
			$sbmt['STATUS_KARYAWAN']				 = $this->input->post('statuskar');
			$sbmt['PRIVILEGE_CA'] 				  	 	 = $this->input->post('employeepriv');
			$sbmt['STATUS'] 				  	 	 = $this->input->post('statusem');
			$sbmt['USER_EMAIL'] 			 	 = $this->input->post('email');
			$sbmt['USER_PASSWORD'] = md5($_POST['password']); 
            $sbmt['USER_GROUP_ID']				 = $this->input->post('user_group');
            $sbmt['USER_STATUS']				 = $this->input->post('status');
            $sbmt['POSITION_DEPTH_ID']		 	 = $this->input->post('title');
            $sbmt['LEVEL_ID']					 = $this->input->post('level');
			$sbmt['GET_LEVEL']					 = $this->input->post('getLevel');
			$sbmt['PERIODE_MEDICAL']	 = $this->input->post('periode');
            
            $sbmt['POSITION_ID'] 				 = $this->input->post('position');

			$sbmt['GROUP_ID'] 					 = $this->input->post('group_id');
			$sbmt['DIVISION_ID'] 				 = $this->input->post('division_id');          
            
            $sbmt['REPORTING_MANAGER_ID']	 	 = $this->input->post('rm');
            $sbmt['ANNUAL_LEAVE_ENTITLEMENT']	 = $this->input->post('annual_leave');
			$sbmt['ANNUAL_CLAIM_MEDICAL_ENTITLEMENT']	 = $this->input->post('annual_medical');
			$sbmt['ANNUAL_CLAIM_TRANSPORT_ENTITLEMENT']	 = $this->input->post('annual_transport');
			$sbmt['ANNUAL_CLAIM_TELEKOMUNIKASI_ENTITLEMENT']	 = $this->input->post('annual_komunikasi');
            $sbmt['joint_holiday_total']         = $this->_get_joint_holiday_total($sbmt['JOIN_DATE']);

            $sbmt['balance']	 = $sbmt['ANNUAL_LEAVE_ENTITLEMENT'] - $sbmt['joint_holiday_total'];
            $response = $this->user_model->submitEmployeeForm($sbmt);

            echo $response;
		}
	}

	function update_employee()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']     				 = $this->user['email'];
			$sbmt['EMPLOYEE_ID']    			 = $this->input->post('employeeId');
			$sbmt['ID_CARD_NUMBER']  			 = $this->input->post('nik');
			$sbmt['EMPLOYEE_NAME']  			 = $this->input->post('name');
			$sbmt['JOIN_DATE']  	 			 = $this->input->post('join_dt');
			$sbmt['MARITAL_STATUS'] 	   	 	 = $this->input->post('marital');
			$sbmt['DEPENDANT'] 	   	 			 = $this->input->post('Dependant');
			$sbmt['GENDER_ID'] 	   	 			 = $this->input->post('gender');
			$sbmt['BIRTH_DATE'] 		  	 	 = $this->input->post('birth');
			$sbmt['ADDRESS']	 		  	 	 = $this->input->post('address');
			$sbmt['PHONE'] 				  	 	 = $this->input->post('phone');
			$sbmt['STATUS_KARYAWAN']			 = $this->input->post('statuskar');
			$sbmt['PRIVILEGE_CA'] 				 = $this->input->post('employeepriv');
            $sbmt['STATUS']				 = $this->input->post('status');
			$sbmt['USER_EMAIL'] 			 	 = $this->input->post('email');
            $sbmt['FIELD_PASSWORD']  			 = ($_POST['password']);
            $sbmt['CEK_PASSWORD']  			 = $this->input->post('cekPwd');
			if ( $sbmt['FIELD_PASSWORD'] == $sbmt['CEK_PASSWORD'] ){
			 $sbmt['USER_PASSWORD']  			 = ($_POST['password']);}
			else if ( $sbmt['FIELD_PASSWORD'] != $sbmt['CEK_PASSWORD'] )
			{
			 $sbmt['USER_PASSWORD']  			 = md5($_POST['password']);
			}
            $sbmt['USER_GROUP_ID']				 = $this->input->post('user_group');
            $sbmt['USER_STATUS']				 = $this->input->post('status');
            $sbmt['POSITION_DEPTH_ID']		 	 = $this->input->post('title');
            $sbmt['LEVEL_ID']					 = $this->input->post('level'); 
			$sbmt['GET_LEVEL']					 = $this->input->post('getLevel');
            
            $sbmt['POSITION_ID'] 				 = $this->input->post('position');

            $sbmt['GROUP_ID'] 					 = $this->input->post('group_id');
			$sbmt['DIVISION_ID'] 				 = $this->input->post('division_id');
            
            $sbmt['REPORTING_MANAGER_ID']	 	 = $this->input->post('rm');
            $sbmt['ANNUAL_LEAVE_ENTITLEMENT']	 = $this->input->post('annual_leave');
			$sbmt['PERIODE_MEDICAL']	 = $this->input->post('periode');
		

            $response = $this->user_model->updateEmployeeForm($sbmt);
			if ($sbmt['STATUS_KARYAWAN'] == '1')
			{
				if ($sbmt['LEVEL_ID'] != $sbmt['GET_LEVEL']){
				$response3= $this->_update_employee_bantuan_left($sbmt['EMPLOYEE_ID']);
				
				$response2 = $this->_get_employee_bantuan_left($sbmt['EMPLOYEE_ID'],$sbmt['LEVEL_ID']);
				
				}else{
				

				$response2 = $this->_get_employee_bantuan_left($sbmt['EMPLOYEE_ID'],$sbmt['LEVEL_ID']);			  
				echo $response2;
				}
			}
			else{
				$response3= $this->_delete_employee_bantuan_left($sbmt['EMPLOYEE_ID']);
			}
		}
	}
	function cekapproval06(){
		$employeeID = $this->input->get('code');
		$cekapproval= $this->user_model->cek_approval($employeeID);
		if ($cekapproval > 0)
		{
			echo "User ini adalah Approval. Untuk menonaktifkan user ini, silahkan ganti Approval terlebih dahulu melalui menu Claim Management";
			?><script>$('#simpan-data06').hide();</script><?
		}
		else
		{
			echo "";
		}
	}
}

/* End of file c_oas006.php */
/* Location: ./application/controllers/c_oas006.php */