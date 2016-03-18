
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
* 1.0				 04 Nov 2014	   Metta Kharisma H		 Merubah submitEmployeeForm
* 2.0				 04 Nov 2014	   Metta Kharisma H		 Merubah updateEmployeeForm
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS006 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function submitEmployeeForm($data)
	{
		$ack = 0;

		// [1] Insert data into employee table
		$sql = "INSERT INTO
						tb_m_employee (	EMPLOYEE_ID,
										ID_CARD_NUMBER,
										POSITION_ID,
										LEVEL_ID,
										POSITION_DEPTH_ID,
										MARITAL_STATUS,
										DEPENDANT,
										GROUP_ID,
										DIVISION_ID,
										EMPLOYEE_NAME,
										GENDER_ID,
										BIRTH_DATE,
										PHONE,
										STATUS_ID,
										ADDRESS,
										PRIVILEGE_CA,
										STATUS,
										ANNUAL_LEAVE_ENTITLEMENT,
										PERIODE_MEDICAL_CLAIM,
										EXPENSE_CLAIM_MEDICAL_ENTITLEMENT,
										EXPENSE_CLAIM_TRANSPORTATION_ENTITLEMENT,
										EXPENSE_CLAIM_TELECOMMUNICATION_ENTITLEMENT,
										TANGGUNGAN,
										JOIN_DATE,
										CREATED_BY,
										CREATED_DT)
				VALUES (
							 '$data[EMPLOYEE_ID]',
							 '$data[ID_CARD_NUMBER]',
							 '$data[POSITION_ID]',
							 '$data[LEVEL_ID]',
					         '$data[POSITION_DEPTH_ID]',
					         '$data[MARITAL_STATUS]',
					         '$data[DEPENDANT]',
					         '$data[GROUP_ID]',
					         '$data[DIVISION_ID]',
					         '$data[EMPLOYEE_NAME]',
					         '$data[GENDER_ID]',
					         '$data[BIRTH_DATE]',
					         '$data[PHONE]',
							 '$data[STATUS_KARYAWAN]',
					         '$data[ADDRESS]',
							 '$data[PRIVILEGE_CA]',
							 '1',
					         '$data[PERIODE_MEDICAL]',
					         '$data[ANNUAL_LEAVE_ENTITLEMENT]',
							 '$data[ANNUAL_CLAIM_MEDICAL_ENTITLEMENT]',					 
							 '$data[ANNUAL_CLAIM_TRANSPORT_ENTITLEMENT]',
							 '$data[ANNUAL_CLAIM_TELEKOMUNIKASI_ENTITLEMENT]',
							 '3',
					         '$data[JOIN_DATE]',
					         'user: $data[this_user]',
					         '".date("Y-m-d H:i:s")."')";
		
		if($this->db->query($sql))
		{ $ack = 1; }

		// [2] Insert employee's reporting manager data
		if($ack == 1)
		{
			$sql = "INSERT INTO
							tb_m_employee_reporting_manager
										 (	EMPLOYEE_ID,
											REPORTING_MANAGER_ID,
											CREATED_BY,
											CREATED_DT)
					VALUES (
								 '$data[EMPLOYEE_ID]',
								 '$data[REPORTING_MANAGER_ID]',
						         'user: $data[this_user]',
						         '".date("Y-m-d H:i:s")."')";
		    if($this->db->query($sql))
			{ $ack = 2; }	
		}

		// [3] Insert employee's annual leave entitlement
		if($ack == 2)
		{
			$sql = "INSERT INTO
							tb_r_annual_leave
										 (	EMPLOYEE_ID,
											YEAR,
											ANNUAL_BALANCE,
											CREATED_BY,
											CREATED_DT)
					VALUES (
								 '$data[EMPLOYEE_ID]',
								 '".date("Y")."',
						         '$data[ANNUAL_LEAVE_ENTITLEMENT]',
						         'user: $data[this_user]',
						         '".date("Y-m-d H:i:s")."')";
		    if($this->db->query($sql))
			{ $ack = 3; }	
		}

		// [4] Insert employee's annual leave balance
		if($ack == 3)
		{
			$sql = "INSERT INTO
							tb_r_annual_leave_trx
										 (	EMPLOYEE_ID,
											YEAR,
											BALANCE,
											CREATED_BY,
											CREATED_DT)
					VALUES (
								 '$data[EMPLOYEE_ID]',
								 '".date("Y")."',
						         '$data[balance]',
						         'user: $data[this_user]',
						         '".date("Y-m-d H:i:s")."')";
		    if($this->db->query($sql))
			{ $ack = 4; }	
		}

		// [4] Insert employee's data to account table
		if($ack == 4)
		{
			$sql = "INSERT INTO
							tb_m_user
										 (	EMPLOYEE_ID,
											USER_GROUP_ID,
											USER_EMAIL,
											USER_PASSWORD,
											USER_STATUS,
											SHOW_LEAVE_INFORMATION,
											STATUS_PASSWORD,
											CREATED_BY,
											CREATED_DT)
					VALUES (
								 '$data[EMPLOYEE_ID]',
								 '$data[USER_GROUP_ID]',
						         '$data[USER_EMAIL]',
						         '$data[USER_PASSWORD]',
						         '$data[USER_STATUS]',
						         '1',
								 'OLD',
						         'user: $data[this_user]',
						         '".date("Y-m-d H:i:s")."')";
		    if($this->db->query($sql))
			{ $ack = 5; }	
		}
		

		return $ack;
	}

	function updateEmployeeForm($data)
	{
		$ack = 0;

		// [1] update employee table data
		$sql = "UPDATE
						tb_m_employee
				SET
							EMPLOYEE_ID = '$data[EMPLOYEE_ID]',
							ID_CARD_NUMBER = '$data[ID_CARD_NUMBER]',
							POSITION_ID = '$data[POSITION_ID]',
							LEVEL_ID = '$data[LEVEL_ID]',
							POSITION_DEPTH_ID = '$data[POSITION_DEPTH_ID]',
							GROUP_ID = '$data[GROUP_ID]',
							DIVISION_ID = '$data[DIVISION_ID]',
							EMPLOYEE_NAME = '$data[EMPLOYEE_NAME]',
							MARITAL_STATUS = '$data[MARITAL_STATUS]',
							DEPENDANT = '$data[DEPENDANT]',
							GENDER_ID = '$data[GENDER_ID]',
							BIRTH_DATE = '$data[BIRTH_DATE]',
							PHONE = '$data[PHONE]',
							STATUS_ID = '$data[STATUS_KARYAWAN]',
							ADDRESS = '$data[ADDRESS]',
							PRIVILEGE_CA = '$data[PRIVILEGE_CA]',
							STATUS = '$data[USER_STATUS]',
							PERIODE_MEDICAL_CLAIM = '$data[PERIODE_MEDICAL]',
							ANNUAL_LEAVE_ENTITLEMENT = '$data[ANNUAL_LEAVE_ENTITLEMENT]',
							
							JOIN_DATE = '$data[JOIN_DATE]',
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						EMPLOYEE_ID = '$data[EMPLOYEE_ID]'";        
		if($this->db->query($sql))
		{ $ack = 1; }

		// [2] Update employee's reporting manager data
		if($ack == 1)
		{
			$sql = "UPDATE
							tb_m_employee_reporting_manager
					SET
										 	
							REPORTING_MANAGER_ID = '$data[REPORTING_MANAGER_ID]',
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
					WHERE
								EMPLOYEE_ID = '$data[EMPLOYEE_ID]' ";
		    if($this->db->query($sql))
			{ $ack = 2; }	
		}

		// [3] Insert employee's annual leave entitlement
		if($ack == 2)
		{
			$sql = "UPDATE
							tb_m_user
					SET
						 	USER_EMAIL = '$data[USER_EMAIL]',
							USER_GROUP_ID = '$data[USER_GROUP_ID]',
							USER_PASSWORD = '$data[USER_PASSWORD]',
							USER_STATUS = '$data[USER_STATUS]',
						
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				    WHERE
				    		EMPLOYEE_ID = '$data[EMPLOYEE_ID]' ";
		    if($this->db->query($sql))
			{ $ack = 3; }	
		}
		return $ack;
	}
	

	function get_gender_list() 
	{
		$sql = " SELECT
							sys.VALUE name,
							sys.SYS_CD id
							
				FROM
							tb_m_system sys
				WHERE
							sys.SYS_CAT = '4'   ";
		return fetchArray($sql, 'all');
	}

	function get_marital_list() 
	{
		$sql = " SELECT
							sys.VALUE name,
							sys.SYS_CD id
							
				FROM
							tb_m_system sys
				WHERE
							sys.SYS_CAT = '14'   ";
		return fetchArray($sql, 'all');
	}
	function get_user_group_list()
	{
		$sql = " SELECT
							ug.USER_GROUP_NAME name,
							ug.USER_GROUP_ID id
							
				FROM
							tb_m_user_group ug   ";
		return fetchArray($sql, 'all');
	}

	function get_position_depth_list()
	{
		$sql = " SELECT
							pd.POSITION_DEPTH_ID id,
							pd.POSITION_DEPTH_TITLE name
							
							
				FROM
							tb_m_position_depth pd   ";
		return fetchArray($sql, 'all');
	}

	function get_position_level_list()
	{
		$sql = " SELECT
							pl.LEVEL_ID id,
							pl.LEVEL_NAME name
							
							
				FROM
							tb_m_position_level pl   ";
		return fetchArray($sql, 'all');
	}

	function get_group_list()
	{
		$sql = " SELECT
							pos.POSITION_ID id,
							pos.POSITION_NAME name
							
							
				FROM
							tb_m_position pos 
				WHERE
							pos.POSITION_DEPTH_ID = '2' ";
		return fetchArray($sql, 'all');
	}

	function get_division_list($group_id = '')
	{
		$sql = " SELECT
							pos.POSITION_ID id,
							pos.POSITION_NAME name
							
							
				FROM
							tb_m_position pos 
				WHERE
							pos.POSITION_DEPTH_ID = '3' ";

		if($group_id !=''){
			$sql .= "AND pos.MANAGER_ID = '$group_id' ";	
		}
		return fetchArray($sql, 'all');
	}

	function get_employee_list()
	{
		$sql = " SELECT
							empl.EMPLOYEE_ID id,
							empl.EMPLOYEE_NAME name
							
							
				FROM
							tb_m_employee empl 
				ORDER BY
							empl.EMPLOYEE_ID ASC";
		return fetchArray($sql, 'all');
	}

	function count_employee_id($empl_id)
	{
		$sql = " SELECT
							COUNT(*)
				FROM
							tb_m_employee empl 
				WHERE
							empl.EMPLOYEE_ID = '$empl_id' ";
		return fetchArray($sql, 'one');
	}

	function count_employee_email($email)
	{
		$sql = " SELECT
							COUNT(*)
				FROM
							tb_m_user usr
				WHERE
							usr.USER_EMAIL = '$email' ";
		return fetchArray($sql, 'one');
	}

	function get_employee_info($employeeId)
	{
		$sql = " SELECT
							empl.*,
							rm.REPORTING_MANAGER_ID,
							usr.USER_GROUP_ID,
							usr.USER_EMAIL,
							usr.USER_PASSWORD,
							usr.USER_STATUS
				FROM
							tb_m_employee empl,
							tb_m_employee_reporting_manager rm,
							tb_m_user usr  
				WHERE
							empl.EMPLOYEE_ID = '$employeeId' AND
							rm.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = empl.EMPLOYEE_ID ";
		return fetchArray($sql, 'row');
	}

	function get_group($divid)
	{
		$sql = " SELECT
							pos.MANAGER_ID
				FROM
							tb_m_position pos
				WHERE
							pos.POSITION_ID = '$divid' ";
		return fetchArray($sql, 'one');
	}
	function cek_approval($empid)
	{
		$sql = " SELECT COUNT(*) FROM tb_m_approval apr, tb_m_employee emp
				WHERE emp.EMPLOYEE_ID = apr.EMPLOYEE_ID AND 
					emp.EMPLOYEE_ID = '$empid' ";
		return fetchArray($sql, 'one');
	}
}