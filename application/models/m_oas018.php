<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS018
* Program Name     : Pengaturan User
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			16-12-2014			Winni Oktaviani		add fungsi2 untuk show procedure claim,bt,ca
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS018 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function getEmployeeInform($employeeID)
	{
		$sql = "SELECT
						usr.SHOW_LEAVE_INFORMATION,
						usr.SHOW_EXPENSE_INFORMATION,
						usr.SHOW_BUSINESS_TRAVEL_INFORMATION,
						usr.SHOW_CA_INFORMATION,
						usr.SHOW_PR_INFORMATION,
						usr.USER_PASSWORD,
						empl.PHONE,
						empl.ADDRESS
				FROM 
						tb_m_user usr,
						tb_m_employee empl
				WHERE 
						usr.EMPLOYEE_ID = '$employeeID' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID";	
		return fetchArray($sql, 'row');
	}

	function change_settings($data)
	{
		$ack = '0';

		$sql = "UPDATE
						tb_m_user usr
				SET ";

		if($data['LEAVE_INFORM']!=""){
			$sql .= " usr.SHOW_LEAVE_INFORMATION = '$data[LEAVE_INFORM]', ";
		}
		if($data['EXPENSE_INFORM']!=""){
			$sql .= " usr.SHOW_EXPENSE_INFORMATION = '$data[EXPENSE_INFORM]', ";
		}
		if($data['BT_INFORM']!=""){
			$sql .= " usr.SHOW_BUSINESS_TRAVEL_INFORMATION = '$data[BT_INFORM]', ";
		}
		
		if($data['CA_INFORM']!=""){
			$sql .= " usr.SHOW_CA_INFORMATION = '$data[CA_INFORM]', ";
		}
		
		if($data['PR_INFORM']!=""){
			$sql .= " usr.SHOW_PR_INFORMATION = '$data[PR_INFORM]', ";
		}
	

		if($data['NEW_PASSWORD']!=""){
			$sql .= " usr.USER_PASSWORD = '$data[NEW_PASSWORD]', ";
		}
						
		$sql .=	"		usr.UPDATED_DT = '$data[DATENOW]',
						usr.UPDATED_BY = 'user: $data[THIS_USER]'
				 WHERE 
						usr.EMPLOYEE_ID = '$data[EMPLOYEE_ID]' ";

		if($this->db->query($sql))
		{
			$ack = '1';
		}

		return $ack;
	}

	function check_password($data)
	{
		$sql = "SELECT
						COUNT(usr.EMPLOYEE_ID)
				FROM 
						tb_m_user usr
				WHERE 
						usr.EMPLOYEE_ID = '$data[EMPLOYEE_ID]' AND
						(usr.USER_PASSWORD = '$data[PWD]' OR
						usr.TEMPORARY_PASSWORD = '$data[PWD]')";	
		return fetchArray($sql, 'one');
	}

	function change_personal_data($data)
	{
		$ack = '0';

		$sql = "UPDATE
						tb_m_employee usr
				SET 
						usr.ADDRESS = '$data[ADDRESS]',
						usr.PHONE 	= '$data[PHONE]'
				WHERE 
						usr.EMPLOYEE_ID = '$data[EMPLOYEE_ID]' ";

		if($this->db->query($sql))
		{
			$ack = '1';
		}

		return $ack;
	}
}