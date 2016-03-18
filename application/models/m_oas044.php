<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS044
* Program Name     : Cash Advance List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 12:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
 

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS044 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 //menampilkan list CA
	function get_list($data)
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
						(select rs.REMAINING from tb_r_settlement rs where rs.FORM_ID = ca.CA_ID AND rs.FORM_TYPE_ID ='2') balance,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
						ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name, 

						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						fs.F2_APPROVE finance2,
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
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
						tb_r_ca ca,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE";
				//filter user
				if($data['employeeGroup'] == '2' ){
			$sql .= "    	(fs.TARGET_EMPLOYEE_ID = '$data[this_id]' OR fs.FINAL_APPROVE = '$data[this_id]' OR fs.F2_APPROVE='$data[this_id]' OR fs.DIR_APPROVE='$data[this_id]' OR ca.EMPLOYEE_ID ='$data[this_id]' ) AND";	
					   }
					 
		$sql .= "	
							ca.CHARGE_CODE = cc.CHARGE_CODE AND
					    ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '19' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = ca.CA_ID AND
					    fs.FORM_TYPE_ID = '2'
				ORDER BY (ct.CA_TYPE_ID = '1' AND (fs.STATUS > '9' AND fs.STATUS < '16')) DESC, (ct.CA_TYPE_ID = '1' AND (fs.STATUS <= '0' AND fs.STATUS < '3')) DESC, (fs.STATUS = '9') DESC, (fs.STATUS = '0') DESC, (fs.STATUS = '10') DESC,   sys.NO_URUT asc";	
		return fetchArray($sql, 'all');
	}
	
	//function search
	function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						(select rs.REMAINING from tb_r_settlement rs where rs.FORM_ID = ca.CA_ID AND rs.FORM_TYPE_ID ='2') balance,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						fs.F2_APPROVE finance2,
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
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
						tb_r_ca ca,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
					    ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '19' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = ca.CA_ID AND
					    fs.FORM_TYPE_ID = '2'";
		//untuk filter
		if($employeeID != '' && $searchparam['employeeGroup'] == '2' ){
			$sql .=	" AND  (fs.TARGET_EMPLOYEE_ID = '$employeeID' OR ca.EMPLOYEE_ID = '$employeeID' OR fs.DIR_APPROVE='$employeeID' OR fs.FINAL_APPROVE='$employeeID' OR fs.F2_APPROVE='$employeeID') ";
		}
		
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['ca_type'] != ''){
			$sql .=	" AND  ca.CA_TYPE_ID = '$searchparam[ca_type]' ";
		}
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  ca.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['open'] != ''){
			$sql .=	" AND  ca.STATUS = '$searchparam[open]' ";
		}
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(ca.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(ca.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['CA_currency'] != '-1'){
			$sql .=	" AND   fs.STATUS = '$searchparam[CA_currency]' ";
		}
		$sql .=	"	ORDER BY (ct.CA_TYPE_ID = '1' AND (fs.STATUS > '9' AND fs.STATUS < '16')) ASC, (ct.CA_TYPE_ID = '1' AND (fs.STATUS <= '0' AND fs.STATUS < '3')) ASC, (fs.STATUS = '9') DESC, (fs.STATUS = '0') DESC, (fs.STATUS = '10') DESC,   sys.NO_URUT asc";
		return fetchArray($sql, 'all');
	}	
	
	//mendapatkan tahun
	function get_tahun()
	{
	$sql = "select year(ca.CREATED_DT) year
			from tb_r_ca ca
			group by year(ca.CREATED_DT)";
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

	//ambil daftar tipe CA
	function get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type";
		return fetchArray($sql, 'all');
	}
	
	//mendapatkan list chargecodetype
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