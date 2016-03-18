<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS035
* Program Name     : List Expense Claim Allowance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS035 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	 function get_list($data)
	{
		$sql = "SELECT 
						lv.CLAIM_ID claim_id,
					    lv.REF_NO no_ref,
					    lv.TOTAL total,
					    sys.VALUE status,
						lv.SUBMITTED_DATE submitted_dt,
						lv.TANGGAL_KWITANSI tgl_kwitansi,
						cl.CREATED_DT accepted_dt,
                        cl.CREATED_BY accepted_by,
						cl.REMARKS remarks,
					    fs.STATUS status_id,
						lv.EMPLOYEE_ID employee_id,
						lv.CHARGE_CODE charge_code,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    lt.EXPENSE_TYPE_NAME claim_type,
						fs.TARGET_EMPLOYEE_ID approval,
						fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt
FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_form_confirmation_list cl,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys						
 WHERE
                        fs.FORM_TYPE_ID = '5' AND
                        (fs.STATUS ='11' OR fs.STATUS ='6')  AND
					    lv.CLAIM_ID = fs.FORM_ID AND
						cl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						cl.FORM_ID = lv.CLAIM_ID AND
					    lt.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						empl.DIVISION_ID = lv.CHARGE_CODE AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' AND
                        lt.CLAIM_CATEGORY = '1'
				    
				ORDER BY
				    	lv.TANGGAL_KWITANSI DESC";	
		return fetchArray($sql, 'all');
	}	
function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT 
						lv.CLAIM_ID claim_id,
					    lv.REF_NO no_ref,
					    lv.TOTAL total,
					    sys.VALUE status,
						lv.SUBMITTED_DATE submitted_dt,
						lv.TANGGAL_KWITANSI tgl_kwitansi,
						cl.CREATED_DT accepted_dt,
                        cl.CREATED_BY accepted_by,
						cl.REMARKS remarks,
					    fs.STATUS status_id,
						lv.EMPLOYEE_ID employee_id,
						lv.CHARGE_CODE charge_code,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    lt.EXPENSE_TYPE_NAME claim_type,
						fs.TARGET_EMPLOYEE_ID approval,
						fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt
FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_form_confirmation_list cl,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys						
 WHERE
                        fs.FORM_TYPE_ID = '5' AND
                        (fs.STATUS ='11' OR fs.STATUS ='6')  AND
					    lv.CLAIM_ID = fs.FORM_ID AND
						cl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						cl.FORM_ID = lv.CLAIM_ID AND
					    lt.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						empl.DIVISION_ID = lv.CHARGE_CODE AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' AND
                        lt.CLAIM_CATEGORY = '1'";
			
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  lv.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  empl.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['claimtype'] != ''){
			$sql .=	" AND  lv.CLAIM_TYPE_ID = '$searchparam[claimtype]' ";
		}
		if($searchparam['claimstatus'] != '-1'){
			$sql .=	" AND  fs.STATUS = '$searchparam[claimstatus]' ";
		}		
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(lv.TANGGAL_KWITANSI) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND  MONTH(lv.TANGGAL_KWITANSI) = '$searchparam[month]'  ";
		}

		$sql .=	"ORDER BY
				    	 lv.TANGGAL_KWITANSI DESC ";	
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

	
	function get_claim_type_list()
	{
		$sql = " SELECT
							et.EXPENSE_TYPE_ID id,
							et.EXPENSE_TYPE_NAME name
							
							
				FROM
							tb_m_expense_type et
				WHERE
							et.CLAIM_CATEGORY = '1' AND
							et.EXPENSE_TYPE_ID != '1' AND
					et.STATUS = '1'";
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