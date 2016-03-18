<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS074
* Program Name     : Purchase Request Report
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 16-02-2015 16:01:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
 

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS074 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 //menampilkan list PR
	function get_list($data)
	{
		$sql = "SELECT  
        pr.REF_NO no_ref,
        pr.PR_ID pr_id,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        pr.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
		fs.PUR_APPROVE pur_approve,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE	
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '25' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = pr.PR_ID AND
		fs.FORM_TYPE_ID = '4'AND
        (((fs.STATUS='13' OR fs.STATUS='12') AND pr.DIBUAT_PO='1') OR 
        ((fs.STATUS = '4' OR fs.STATUS='12') AND pr.DIBUAT_PO='0'))
		
		ORDER BY pr.PR_ID desc						";	
		return fetchArray($sql, 'all');
	}
	
	//function search
	function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT  
        pr.REF_NO no_ref,
        pr.PR_ID pr_id,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        pr.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
		fs.PUR_APPROVE pur_approve,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE	
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '25' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = pr.PR_ID AND
		fs.FORM_TYPE_ID = '4'AND
        (((fs.STATUS='13' OR fs.STATUS='12') AND pr.DIBUAT_PO='1') OR 
        ((fs.STATUS = '4' OR fs.STATUS='12')  AND pr.DIBUAT_PO='0'))
		";
		//untuk filter
		if($searchparam['employeeGroup'] == '2' ){
			$sql .=	" AND  (fs.TARGET_EMPLOYEE_ID = '$employeeID' OR pr.EMPLOYEE_ID = '$employeeID' OR fs.GROUP_APPROVE ='$employeeID' OR fs.DIR_APPROVE='$employeeID' OR fs.FINAL_APPROVE='$employeeID' OR fs.PUR_APPROVE='$employeeID') ";
		}
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  pr.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  pr.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  pr.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(pr.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(pr.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['PR_currency'] != '-1'){
			$sql .=	" AND   fs.STATUS = '$searchparam[PR_currency]' ";
		}
		$sql .=	"ORDER BY pr.PR_ID desc	";
		return fetchArray($sql, 'all');
	}	
	
	//mendapatkan tahun
	function get_tahun()
	{
	$sql = "select year(pr.CREATED_DT) year
			from tb_r_pr pr
			group by year(pr.CREATED_DT)";
		return fetchArray($sql, 'all');
	}
	
	//mendapatkan list group
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

	//mendapatkan list divisi berdasarkan group
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

	//mendapatkan list chargecodetype
	function get_chargecodetype_list()
	{
		$sql = " SELECT
							sys.SYS_CD id,
							sys.VALUE name
				FROM
							tb_m_system sys,
                            tb_m_charge_code cc 
				WHERE
							sys.SYS_CAT = '11' AND
                            sys.SYS_CD = cc.TYPE 
                GROUP BY    sys.SYS_CD  ";
		return fetchArray($sql, 'all');
	}
	
	//menampilkan list chargecode berdasar chargecode type
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
	
	//mendapatkan employee list
	function get_employee_list()
	{
		$sql = "SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl,
                            tb_m_user us
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
}