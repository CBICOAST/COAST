<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS078
* Program Name     : List Purchase Order 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:01:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
 

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS078 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 //menampilkan list PR
	function get_list($data)
	{
		$sql = "SELECT  
        po.REF_NO no_ref,
        po.PO_ID po_id,
		po.PR_ID pr_id,
		pr.REF_NO no_ref_pr,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        po.CREATED_DT submitted_dt, 
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
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE
		po.PR_ID = pr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'
ORDER BY 
         fs.STATUS ASC		";	
		return fetchArray($sql, 'all');
	}
	
	//function search
	function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT  
        po.REF_NO no_ref,
        po.PO_ID po_id,
		po.PR_ID pr_id,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        po.CREATED_DT submitted_dt, 
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
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE
		po.PR_ID = pr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'";
		//untuk filter
		if($employeeID != '' && $searchparam['employeeGroup'] == '2' ){
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
		if($searchparam['PO_status'] != '-1'){
			$sql .=	" AND   fs.STATUS = '$searchparam[PO_status]' ";
		}
		$sql .=	"ORDER BY pr.PR_ID desc	";
		return fetchArray($sql, 'all');
	}	
	
		function get_form_detail($form_id)
	{
		$sql = "SELECT  
        po.REF_NO no_ref,
        po.PO_ID po_id,
		pr.REF_NO no_ref_pr,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        po.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.TYPE cctype,
        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarksrm,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,
        pr.VENDOR vendor,
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
        pr.2ND_PAYMENT k2_pay,
        pr.DATE_2PAYMENT tgl2,
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE 
        po.PR_ID = '$form_id' AND
        po.PR_ID = pr.PR_ID AND 
        po.PR_ID = rpr.PR_ID AND
        po.PO_ID = fs.FORM_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_TYPE_ID = '7'
ORDER BY 
         po.PO_ID desc				
";	
		return fetchArray($sql, 'row');
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