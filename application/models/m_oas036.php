<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS036
* Program Name     : List Expense Claim Divisi
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

class M_OAS036 extends CI_Model {
	
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
					    fs.STATUS status_id,
						lv.SUBMITTED_DATE submitted_dt,
                        lv.TANGGAL_KWITANSI tgl_kwitansi,
						cl.CREATED_DT accepted_dt,
                        cl.CREATED_BY accepted_by,
						cl.REMARKS remarks,
						cc.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
						cc.TYPE chargecodetype_id,
						( select pos.VALUE from tb_m_system pos where pos.SYS_CAT = '11' and pos.SYS_CD = cc.TYPE )  chargecodetype_name,
					    lv.EMPLOYEE_ID employee_id,
						lv.TOTAL total,
						lv.TANGGAL_KWITANSI kwitansi_date,
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
                        tb_r_form_confirmation_list cl,
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys,
						tb_m_charge_code cc
                  WHERE	
                         ((fs.STATUS ='10' && lv.CLAIM_TYPE_ID ='4') OR (fs.STATUS = '9' && lv.CLAIM_TYPE_ID !='4')
						OR fs.STATUS ='6') AND
                        fs.FORM_TYPE_ID = '5' AND
					    lv.CLAIM_ID = fs.FORM_ID AND
					    lt.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
                        cl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						cl.FORM_ID = lv.CLAIM_ID AND
						cc.CHARGE_CODE = lv.CHARGE_CODE AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9'
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
					    fs.STATUS status_id,
						lv.SUBMITTED_DATE submitted_dt,
                        lv.TANGGAL_KWITANSI tgl_kwitansi,
						cl.CREATED_DT accepted_dt,
                        cl.CREATED_BY accepted_by,
						cl.REMARKS remarks,
						cc.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
						cc.TYPE chargecodetype_id,
						( select pos.VALUE from tb_m_system pos where pos.SYS_CAT = '11' and pos.SYS_CD = cc.TYPE )  chargecodetype_name,
					    lv.EMPLOYEE_ID employee_id,
						lv.TOTAL total,
						lv.TANGGAL_KWITANSI kwitansi_date,
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
                        tb_r_form_confirmation_list cl,
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_claim lv,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys,
						tb_m_charge_code cc
                  WHERE	
                        ((fs.STATUS ='10' && lv.CLAIM_TYPE_ID ='4') OR (fs.STATUS = '9' && lv.CLAIM_TYPE_ID !='4')
						OR fs.STATUS ='6') AND
                        fs.FORM_TYPE_ID = '5' AND
					    lv.CLAIM_ID = fs.FORM_ID AND
					    lt.EXPENSE_TYPE_ID = lv.CLAIM_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
                        cl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						cl.FORM_ID = lv.CLAIM_ID AND
						cc.CHARGE_CODE = lv.CHARGE_CODE AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = lv.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9'
				  
				    ";

		
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
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  lv.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(cl.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(cl.CREATED_DT) = '$searchparam[month]' ";
		}

		$sql .=	"
				ORDER BY
				     lv.TANGGAL_KWITANSI DESC";	
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

	function get_claim_type_divisi()
	{
		$sql = " SELECT
							lt.EXPENSE_TYPE_ID id,
							lt.EXPENSE_TYPE_NAME name
							
							
				FROM
							tb_m_expense_type lt
				WHERE
				lt.CATEGORY_CLAIM_ID = '1' AND EXPENSE_TYPE_PARENT is null";
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
							tb_m_charge_code pos 
				WHERE
							pos.STATUS = '1'";

		if($chargecodetype_id !=''){
			$sql .= "AND pos.TYPE = '$chargecodetype_id' ";	
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