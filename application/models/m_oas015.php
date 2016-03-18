<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS015
* Program Name     : Leave Request List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS015 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_list($data)
	{
		$sql = "SELECT 
						lv.LEAVE_ID leave_id,
					    lv.REF_NO no_ref,
					    lv.DATE_START start_dt,
						lv.DATE_END end_dt,
					    sys.VALUE status,
					    fs.STATUS status_id,
					    lv.EMPLOYEE_ID employee_id,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
                        (SELECT lv_trx.BALANCE FROM tb_r_annual_leave_trx lv_trx WHERE empl.EMPLOYEE_ID = lv_trx.EMPLOYEE_ID AND YEAR = '".$data['year']."' ) balance_leave,
					    usr.USER_EMAIL employee_email,
					    lt.LEAVE_TYPE_NAME leave_type,
						lv.SUBMITTED_DATE submitted_dt,
						tbrm.REPORTING_MANAGER_ID rm_id
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_leave lv,
					    tb_m_user usr,
					    tb_m_leave_type lt,
					    tb_m_system sys
				WHERE ";

		if($data['employeeGroup'] != '1'){
			$sql .= "    	(fs.TARGET_EMPLOYEE_ID = '$data[this_id]' OR lv.EMPLOYEE_ID = '$data[this_id]') AND";	
		}

		$sql .= "		fs.FORM_TYPE_ID = '1' AND
					    lv.LEAVE_ID = fs.FORM_ID AND
					    lt.LEAVE_TYPE_ID = lv.LEAVE_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '2'
				    
				ORDER BY
				    	(fs.STATUS = '0') DESC, lv.REF_NO DESC";	
		return fetchArray($sql, 'all');
	}	

	function get_search_list($employeeID, $searchparam)
	{
		$thun = date("Y");
		$sql = "SELECT 
						lv.LEAVE_ID leave_id,
					    lv.REF_NO no_ref,
					    lv.DATE_START start_dt,
						lv.DATE_END end_dt,
					    sys.VALUE status,
					    fs.STATUS status_id,
					    lv.EMPLOYEE_ID employee_id,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
                        (SELECT lv_trx.BALANCE FROM tb_r_annual_leave_trx lv_trx WHERE empl.EMPLOYEE_ID = lv_trx.EMPLOYEE_ID AND YEAR = '$thun' ) balance_leave,
					    usr.USER_EMAIL employee_email,
					    lt.LEAVE_TYPE_NAME leave_type,
						lv.SUBMITTED_DATE submitted_dt,
						tbrm.REPORTING_MANAGER_ID rm_id
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_leave lv,
					    tb_m_user usr,
					    tb_m_leave_type lt,
					    tb_m_system sys
				WHERE
				    	
						fs.FORM_TYPE_ID = '1' AND
					    lv.LEAVE_ID = fs.FORM_ID AND
					    lt.LEAVE_TYPE_ID = lv.LEAVE_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '2'";

		if($employeeID != '' && $searchparam['employeeGroup'] != '1'){
			$sql .=	" AND  (fs.TARGET_EMPLOYEE_ID = '$employeeID' OR lv.EMPLOYEE_ID = '$employeeID') ";
		}			    
		
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  lv.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  empl.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['leavetype'] != ''){
			$sql .=	" AND  lv.LEAVE_TYPE_ID = '$searchparam[leavetype]' ";
		}
		// if($searchparam['position'] != ''){
		// 	$sql .=	" AND  empl.POSITION_ID = '$searchparam[position]' ";
		// }
		
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['leavestatus'] != '-1'){
			$sql .=	" AND  fs.STATUS = '$searchparam[leavestatus]' ";
		}
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(lv.SUBMITTED_DATE) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND  (MONTH(lv.DATE_START) = '$searchparam[month]' OR MONTH(lv.DATE_END) = '$searchparam[month]') ";
		}

		$sql .=	"ORDER BY
				    	(fs.STATUS = '0') DESC, lv.REF_NO DESC ";	
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

	function get_leave_type_list()
	{
		$sql = " SELECT
							lt.LEAVE_TYPE_ID id,
							lt.LEAVE_TYPE_NAME name
							
							
				FROM
							tb_m_leave_type lt";
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
}