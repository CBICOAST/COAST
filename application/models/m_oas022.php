<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS022
* Program Name     : Daftar Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 26-09-2014 13:14:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS022 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_list($data)
	{
		$sql = "SELECT 
						lv.CLAIM_ID claim_id,
					    lv.REF_NO no_ref,
                        lv.CLAIM_TYPE_ID type_id,
                        et.CLAIM_CATEGORY category,
                        lv.TOTAL total,			
					    sys.VALUE status,
					    fs.STATUS status_id,
					    lv.EMPLOYEE_ID employee_id,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    et.EXPENSE_TYPE_NAME leave_type,
						fs.TARGET_EMPLOYEE_ID approval,
						fs.FINAL_APPROVE akuntan,
						fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt,
						fs.UPDATED_BY accepted_by,
                        fs.UPDATED_DT accepted_dt,
						tbrm.REPORTING_MANAGER_ID rm_id
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_system sys,
                        tb_m_expense_type et
				WHERE ";

		
		
		if($data['employeeGroup'] == '2'){
			$sql .= "    	(fs.TARGET_EMPLOYEE_ID = '$data[this_id]' OR fs.FINAL_APPROVE = '$data[this_id]' OR lv.EMPLOYEE_ID = '$data[this_id]' 
			OR (fs.DIR_APPROVE = '$data[this_id]' &&  et.EXPENSE_TYPE_ID ='4')) 
			  AND";	
		}
		

		$sql .= "		lv.CLAIM_ID = fs.FORM_ID  AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
						et.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' AND
						fs.FORM_TYPE_ID = '5'
				    GROUP BY lv.CLAIM_ID
				ORDER BY
				    	fs.STATUS ASC";	
		return fetchArray($sql, 'all');
	}	
	
	function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT 
						lv.CLAIM_ID claim_id,
					    lv.REF_NO no_ref,
                        lv.CLAIM_TYPE_ID type_id,
                        et.CLAIM_CATEGORY category,
                        et.EXPENSE_TYPE_NAME clType,
                        lv.TOTAL total,
					    sys.VALUE status,
						lv.CREATED_DT createdDt,
						lv.TANGGAL_KWITANSI tgl,
					    fs.STATUS status_id,
					    lv.EMPLOYEE_ID employee_id,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    lt.EXPENSE_TYPE_NAME leave_type,
						fs.TARGET_EMPLOYEE_ID approval,
						fs.FINAL_APPROVE akuntan,
						fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt,
						fs.UPDATED_BY accepted_by,
                        fs.UPDATED_DT accepted_dt,
						tbrm.REPORTING_MANAGER_ID rm_id
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys,
                        tb_m_expense_type et
				WHERE 	lv.CLAIM_ID = fs.FORM_ID AND
					    lt.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
						 et.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' AND 						
						fs.FORM_TYPE_ID = '5'";
	if($employeeID != '' && $searchparam['employeeGroup'] == '2'){
			$sql .=	" AND  (fs.TARGET_EMPLOYEE_ID = '$employeeID' OR lv.EMPLOYEE_ID = '$employeeID' OR fs.FINAL_APPROVE='$employeeID' OR (fs.DIR_APPROVE = '$employeeID' && lt.EXPENSE_TYPE_ID ='4')) ";
		}
		
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  lv.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  empl.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['claimtype'] != ''){
			$sql .=	" AND  et.CLAIM_CATEGORY = '$searchparam[claimtype]' ";
		}
				
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['claimstatus'] != '-1'){
			$sql .=	" AND  fs.STATUS = '$searchparam[claimstatus]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(lv.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(lv.CREATED_DT) = '$searchparam[month]' ";
		}

		$sql .=	"ORDER BY
				    	lv.SUBMITTED_DATE ASC ";	
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
	
	function get_admin($admin)
	{
		$sql = " SELECT
						empl.EMPLOYEE_ID id,
						empl.EMPLOYEE_NAME name,
                        ug.USER_GROUP_NAME grup,
                        ug.USER_GROUP_ID idg
				FROM
						tb_m_employee empl,
						tb_m_user usr,
						tb_m_user_group ug 
				WHERE
						empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
						usr.USER_GROUP_ID = ug.USER_GROUP_ID AND
						ug.USER_GROUP_ID = '1' AND
						empl.EMPLOYEE_ID = '$admin'";
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

	function get_claim_type()
	{
		$sql = " SELECT
							lt.SYS_CD id,
							lt.VALUE name
							
							
				FROM
							tb_m_system lt
				WHERE
				lt.SYS_CAT ='10'";
		return fetchArray($sql, 'all');
	}
	
	function get_status_list()
	{
		$sql = " SELECT
							lt.SYS_CD id,
							lt.VALUE name
							
							
				FROM
							tb_m_system lt
				WHERE
				lt.SYS_CAT ='9'";
		return fetchArray($sql, 'all');
	}
	
	function get_chargecodetype_list()
	{
		$sql = " SELECT
							pos.SYS_CD id,
							pos.VALUE name
							
							
				FROM
							tb_m_system pos 
				WHERE
							pos.SYS_CAT = '11' ";
		return fetchArray($sql, 'all');
	}
	
	function get_chargecode_list($chargecodetype_id = '')
	{
		$sql = " SELECT
							pos.CHARGE_CODE id,
							pos.PROJECT_DESCRIPTION name
							
							
				FROM
							tb_m_charge_code pos";

		if($chargecodetype_id !=''){
			$sql .= "WHERE pos.TYPE = '$chargecodetype_id' ";	
		}
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