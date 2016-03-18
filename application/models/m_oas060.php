<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS060
* Program Name     : List Report Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS060 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 
 function get_list()
	{
		$sql = "SELECT
						bt.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    bt.BT_ID bt_id,
                        bt.CLIENT_NAME client_name,
                        bt.BUSINESS_PURPOSE bt_purpose, 
						bt.CUSTOMER_LOCATION location,
                        bt.CHARGE_CODE chargecode,
                         bt.DEPARTURE departure, 
						bt.RETURN_DATE return_dt,
                        bt.CHARGE_CODE chargecode,
                         bt.DURATION duration,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						bt.CREATED_DT submitted_dt,
                         bt.AMOUNTDIM amount_dim,
                        bt.TRANSPORTAMOUNT amount_ca,
                        bt.TOTAL_AMOUNT_TRANSPORTATION amount_transport,
                        bt.TOTAL_AMOUNT_ACOMODATION amount_hotel, 
						bt.TOTAL_AMOUNT_BT amount,
					    bt.TRANSPORTATION_BY type_id,
					    cost.COST_ID ca_type,
                        cost.COST category_id,
						bt.DESTINATION destination,
						bt.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = bt.CURRENCY )  currency_name,
						bt.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
						bt.REMARK remarks,
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
						tb_r_bt bt,
					    tb_m_ca_cost cost,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						bt.CHARGE_CODE = cc.CHARGE_CODE AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cost.COST_ID = bt.DESTINATION AND
					    sys.SYS_CAT = '21' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    (fs.FORM_TYPE_ID = '3') AND
                        (fs.STATUS = '9' OR fs.status = '3' OR fs.status = '4')";	
		return fetchArray($sql, 'all');
	}

function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT
						bt.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    bt.BT_ID bt_id,
                        bt.CLIENT_NAME client_name,
                        bt.BUSINESS_PURPOSE bt_purpose, 
						bt.CUSTOMER_LOCATION location,
                        bt.CHARGE_CODE chargecode,
                         bt.DEPARTURE departure, 
						bt.RETURN_DATE return_dt,
                        bt.CHARGE_CODE chargecode,
                         bt.DURATION duration,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						bt.CREATED_DT submitted_dt,
                         bt.AMOUNTDIM amount_dim,
                        bt.TRANSPORTAMOUNT amount_ca,
                        bt.TOTAL_AMOUNT_TRANSPORTATION amount_transport,
                        bt.TOTAL_AMOUNT_ACOMODATION amount_hotel, 
						bt.TOTAL_AMOUNT_BT amount,
					    bt.TRANSPORTATION_BY transport_id,
					    cost.COST_ID ca_type,
                        cost.COST category_id,
						bt.DESTINATION destination,
						bt.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = bt.CURRENCY )  currency_name,
						bt.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
						bt.REMARK remarks,
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
						tb_r_bt bt,
					    tb_m_ca_cost cost,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						bt.CHARGE_CODE = cc.CHARGE_CODE AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cost.COST_ID = bt.DESTINATION AND
					    sys.SYS_CAT = '21' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    (fs.FORM_TYPE_ID = '3') AND
                        (fs.STATUS = '9' OR fs.status = '3' OR fs.status = '4')";
		
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  bt.TRAVELLER_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  bt.TRAVELLER_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['destination'] != ''){
			$sql .=	" AND  bt.DESTINATION = '$searchparam[destination]' ";
		}
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  bt.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['bt_status'] != '-1'){
			$sql .=	" AND  fs.STATUS = '$searchparam[bt_status]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(bt.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(bt.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['transport_id'] != ''){
			$sql .=	" AND   bt.TRANSPORTATION_BY = '$searchparam[transport_id]' ";
		}
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

	// ambil daftar tipe CA
	function get_bt_destination_list(){	
		$sql = "SELECT
					COST_ID id,
					DESTINATION destination,
					COST cost
				FROM
					tb_m_ca_cost";
		return fetchArray($sql, 'all');
	}
	
	function get_bt_transportation_list(){	
		$sql = "SELECT
					SYS_CD id,
					VALUE transportation
				FROM
					tb_m_system
				where SYS_CAT = 20 ";
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