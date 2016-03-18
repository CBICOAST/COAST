<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS005
* Program Name     : Daftar User & Karyawan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 24-08-2014 15:46:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1					 09-11-2014			Metta Kharisma 		 Function get employee status, get user, get list
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS005 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	
	function get_list($employee_id = '') 
	{
		$sql = " SELECT
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '27' AND empl.STATUS_ID = sys.SYS_CD) STATUSEMP,
							empl.*,
							usr.*,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '5' AND usr.USER_STATUS = sys.SYS_CD) STATUS,
							ug.USER_GROUP_NAME,
							pl.LEVEL_NAME,
							pd.POSITION_DEPTH_TITLE,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '4' AND empl.GENDER_ID = sys.SYS_CD) GENDER
							
				FROM
							tb_m_user usr,
							tb_m_employee empl,
							tb_m_user_group ug,
							tb_m_position_level pl,
							tb_m_position_depth pd
				WHERE
							usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							usr.USER_GROUP_ID = ug.USER_GROUP_ID AND
							empl.LEVEL_ID = pl.LEVEL_ID AND
							empl.POSITION_DEPTH_ID = pd.POSITION_DEPTH_ID    ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_user($employeeID, $searchparam)
	{
		$sql = " SELECT
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '27' AND empl.STATUS_ID = sys.SYS_CD) STATUSEMP,
							empl.*,
							usr.*,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '5' AND usr.USER_STATUS = sys.SYS_CD) STATUS,
							ug.USER_GROUP_NAME,
							pl.LEVEL_NAME,
							pd.POSITION_DEPTH_TITLE,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '4' AND empl.GENDER_ID = sys.SYS_CD) GENDER
							
				FROM
							tb_m_user usr,
							tb_m_employee empl,
							tb_m_user_group ug,
							tb_m_position_level pl,
							tb_m_position_depth pd
				WHERE
							usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							usr.USER_GROUP_ID = ug.USER_GROUP_ID AND
							empl.LEVEL_ID = pl.LEVEL_ID AND
							empl.POSITION_DEPTH_ID = pd.POSITION_DEPTH_ID   ";
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  empl.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['statusid'] != '-1'){
			$sql .=	" AND  empl.STATUS = '$searchparam[statusid]' ";
		}
		else if($searchparam['statusid'] == '-1'){
			$sql .=	" AND  empl.STATUS = '1' ";
		}
		
		$sql .= " ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}

	function get_employee_list()
	{
		$sql = " SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_employee_status()
	{
		$sql = " SELECT
							lt.SYS_CD id,
							lt.VALUE STATUS
							
							
				FROM
							tb_m_system lt
				WHERE
				lt.SYS_CAT ='13'";
		return fetchArray($sql, 'all');
	}

}