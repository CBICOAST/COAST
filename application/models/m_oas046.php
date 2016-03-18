<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS046
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

class M_OAS046 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 
	 function get_list()
	{	
		$sql = "SELECT 	ca.REF_NO no_ref,
						ca.CA_ID ca_id,
						ca.CHARGE_CODE chargecode,	
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD ) pay_method_name,
						ca.REMARK remarks,
						ca.STATUS form_status,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,

						cc.PROJECT_DESCRIPTION ccdes,
						cc.TYPE cctype,
						(select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
						cc.PROJECT_DESCRIPTION  cc_name,
						
						ct.CA_TYPE_ID type_id,
						ct.CA_TYPE ca_type,
						ct.CA_CATEGORY category_id,sys.VALUE status,
						empl.EMPLOYEE_NAME employee_name,
						empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
						empl.DIVISION_ID employee_division,
						(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
						usr.USER_EMAIL employee_email,
						usr.USER_EMAIL employee_email,
						
						fs.TARGET_EMPLOYEE_ID approval, 
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name, 
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						fs.CREATED_DT approverm_dt,
						fs.CREATED_BY approverm_by,
						fs.APPROVEDIR_DT approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						fs.UPDATED_DT accepted_dt,
						fs.UPDATED_BY accepted_by,
						fs.STATUS status_id,
						setl.RECEIPT_DATE tgl_kwitansi,
						setl.CREATED_DT setl_maker,
						(SELECT  CASE SETTLEMENT_STATUS  WHEN '0' THEN 'Has Not Done Settlement Yet' WHEN '1' THEN 'Settlement Submitted'  ELSE SETTLEMENT_STATUS END) set_stat,
						(SELECT CASE WHEN  REMAINING < 0 THEN (REMAINING * -1)
							ELSE '0' END ) liability_setl_amount,
						(SELECT CASE WHEN  REMAINING > 0 THEN (REMAINING)
							ELSE 0 END) liability_setl_amount_employee,
						(SELECT CASE WHEN  (AMOUNT_SETTLEMENT < 0 And REMAINING = 0) THEN (AMOUNT_SETTLEMENT * -1)
							ELSE '0' END AS setl_amount ) setl_amount,
						(SELECT CASE WHEN  (AMOUNT_SETTLEMENT > 0  AND REMAINING = 0 )THEN (AMOUNT_SETTLEMENT)
							ELSE 0 END ) setl_amount_employee,
						(SELECT CASE WHEN  ca.CURRENCY = '1'  THEN setl_amount ELSE 0 END ) setl_amount_IDR,
						(SELECT  CASE WHEN  ca.CURRENCY = '1'  THEN setl_amount_employee ELSE 0 END ) setl_amount_IDR_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN setl_amount ELSE 0 END ) setl_amount_USD,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN setl_amount_employee ELSE 0 END ) setl_amount_USD_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '3'  THEN setl_amount ELSE 0 END ) setl_amount_SGD,
						(SELECT CASE WHEN ca.CURRENCY = '3' THEN setl_amount_employee ELSE 0 END  ) setl_amount_SGD_employee,	
						
						(SELECT CASE WHEN  ca.CURRENCY = '1'  THEN liability_setl_amount ELSE 0 END) liability_IDR,
						(SELECT  CASE WHEN  ca.CURRENCY = '1'  THEN liability_setl_amount_employee ELSE 0 END) liability_IDR_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN liability_setl_amount ELSE 0 END AS setl_amount) liability_USD,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN liability_setl_amount_employee ELSE 0 END) liability_USD_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '3'  THEN liability_setl_amount ELSE 0 END AS setl_amount) liability_SGD,
						(SELECT CASE WHEN ca.CURRENCY = '3' THEN liability_setl_amount_employee ELSE 0 END  ) liability_SGD_employee,					
						setl.REMARKS setl_remarks,
						
						setl.ACCEPTED_DT setl_accept_dt,
						setl.ACCEPTED_BY setl_accept_by,
						setl.REMARKS_ACCEPTED setl_remarks_accept
				FROM tb_r_form_status fs INNER JOIN tb_m_system sys ON	sys.SYS_CAT = '19' AND  sys.SYS_CD = fs.STATUS
										INNER join tb_r_ca ca ON fs.FORM_TYPE_ID = '2' AND fs.FORM_ID = ca.CA_ID  AND
											((fs.STATUS >= '9' AND fs.STATUS < '16')  OR fs.status = '3' OR fs.status = '4' AND 
											ca.SETTLEMENT_STATUS = '0')
										INNER JOIN tb_m_ca_type ct ON ca.CA_TYPE_ID = ct.CA_TYPE_ID 
										INNER JOIN tb_m_charge_code cc ON  ca.CHARGE_CODE = cc.CHARGE_CODE   
										INNER JOIN tb_m_employee empl ON ca.EMPLOYEE_ID = empl.EMPLOYEE_ID 
										INNER JOIN tb_m_user usr ON usr.EMPLOYEE_ID = empl.EMPLOYEE_ID
										LEFT OUTER JOIN tb_r_settlement setl ON  setl.FORM_ID = ca.CA_ID ORDER BY sys.NO_URUT asc";	
		return fetchArray($sql, 'all');
	}

function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT 	ca.REF_NO no_ref,
						ca.CA_ID ca_id,
						ca.CHARGE_CODE chargecode,	
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD ) pay_method_name,
						ca.REMARK remarks,
						ca.STATUS form_status,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,

						cc.PROJECT_DESCRIPTION ccdes,
						cc.TYPE cctype,
						(select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
						cc.PROJECT_DESCRIPTION  cc_name,
						
						ct.CA_TYPE_ID type_id,
						ct.CA_TYPE ca_type,
						ct.CA_CATEGORY category_id,sys.VALUE status,
						empl.EMPLOYEE_NAME employee_name,
						empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
						empl.DIVISION_ID employee_division,
						(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
						usr.USER_EMAIL employee_email,
						usr.USER_EMAIL employee_email,
						
						fs.TARGET_EMPLOYEE_ID approval, 
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name, 
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						fs.CREATED_DT approverm_dt,
						fs.CREATED_BY approverm_by,
						fs.APPROVEDIR_DT approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						fs.UPDATED_DT accepted_dt,
						fs.UPDATED_BY accepted_by,
						fs.STATUS status_id,
						setl.RECEIPT_DATE tgl_kwitansi,
						setl.CREATED_DT setl_maker,
						(SELECT  CASE SETTLEMENT_STATUS  WHEN '0' THEN 'Has Not Done Settlement Yet' WHEN '1' THEN 'Settlement Submitted'  ELSE SETTLEMENT_STATUS END) set_stat,
						(SELECT CASE WHEN  REMAINING < 0 THEN (REMAINING * -1)
							ELSE '0' END ) liability_setl_amount,
						(SELECT CASE WHEN  REMAINING > 0 THEN (REMAINING)
							ELSE 0 END) liability_setl_amount_employee,
						(SELECT CASE WHEN  (AMOUNT_SETTLEMENT < 0 And REMAINING = 0) THEN (AMOUNT_SETTLEMENT * -1)
							ELSE '0' END AS setl_amount ) setl_amount,
						(SELECT CASE WHEN  (AMOUNT_SETTLEMENT > 0  AND REMAINING = 0 )THEN (AMOUNT_SETTLEMENT)
							ELSE 0 END ) setl_amount_employee,
						(SELECT CASE WHEN  ca.CURRENCY = '1'  THEN setl_amount ELSE 0 END ) setl_amount_IDR,
						(SELECT  CASE WHEN  ca.CURRENCY = '1'  THEN setl_amount_employee ELSE 0 END ) setl_amount_IDR_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN setl_amount ELSE 0 END ) setl_amount_USD,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN setl_amount_employee ELSE 0 END ) setl_amount_USD_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '3'  THEN setl_amount ELSE 0 END ) setl_amount_SGD,
						(SELECT CASE WHEN ca.CURRENCY = '3' THEN setl_amount_employee ELSE 0 END  ) setl_amount_SGD_employee,	
						
						(SELECT CASE WHEN  ca.CURRENCY = '1'  THEN liability_setl_amount ELSE 0 END) liability_IDR,
						(SELECT  CASE WHEN  ca.CURRENCY = '1'  THEN liability_setl_amount_employee ELSE 0 END) liability_IDR_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN liability_setl_amount ELSE 0 END AS setl_amount) liability_USD,
						(SELECT  CASE WHEN  ca.CURRENCY = '2'  THEN liability_setl_amount_employee ELSE 0 END) liability_USD_employee,
						(SELECT  CASE WHEN  ca.CURRENCY = '3'  THEN liability_setl_amount ELSE 0 END AS setl_amount) liability_SGD,
						(SELECT CASE WHEN ca.CURRENCY = '3' THEN liability_setl_amount_employee ELSE 0 END  ) liability_SGD_employee,					
						setl.REMARKS setl_remarks,
						
						setl.ACCEPTED_DT setl_accept_dt,
						setl.ACCEPTED_BY setl_accept_by,
						setl.REMARKS_ACCEPTED setl_remarks_accept
				FROM tb_r_form_status fs INNER JOIN tb_m_system sys ON	sys.SYS_CAT = '19' AND  sys.SYS_CD = fs.STATUS
										INNER join tb_r_ca ca ON fs.FORM_TYPE_ID = '2' AND fs.FORM_ID = ca.CA_ID  AND
											((fs.STATUS >= '9' AND fs.STATUS < '16') OR fs.status = '3' OR fs.status = '4' AND 
											ca.SETTLEMENT_STATUS = '0')";
				if($searchparam['employeeid'] != ''){
						$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeeid]' ";
				}
				if($searchparam['employeename'] != ''){
					$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeename]' ";
				}
				if($searchparam['ca_type'] != ''){
					$sql .=	" AND  ca.CA_TYPE_ID = '$searchparam[ca_type]' ";
				}
				if($searchparam['chargecode_id'] != ''){
					$sql .=	" AND  ca.CHARGE_CODE = '$searchparam[chargecode_id]' ";
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
				if($searchparam['RCA_currency'] != ''){
					$sql .=	" AND   ca.CURRENCY = '$searchparam[RCA_currency]' ";
				}

				$sql .= " INNER JOIN tb_m_ca_type ct ON ca.CA_TYPE_ID = ct.CA_TYPE_ID 
							INNER JOIN tb_m_charge_code cc ON  ca.CHARGE_CODE = cc.CHARGE_CODE  ";
				if($searchparam['chargecodetype_id'] != ''){
					$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
				}							
				
				$sql .=" INNER JOIN tb_m_employee empl ON ca.EMPLOYEE_ID = empl.EMPLOYEE_ID  ";
				if($searchparam['group_id'] != ''){
					$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
				}
				if($searchparam['division_id'] != ''){
					$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
				}
				$sql .= "	INNER JOIN tb_m_user usr ON usr.EMPLOYEE_ID = empl.EMPLOYEE_ID
							LEFT OUTER JOIN tb_r_settlement setl ON  setl.FORM_ID = ca.CA_ID ORDER BY sys.NO_URUT asc ";	
		return fetchArray($sql, 'all');
	}	

	
	function get_search_settle_list()
	{
		$sql = " SELECT
					ca.REF_NO ref,
                    setl.amount used,
					setl.RECEIPT_DATE tgl_bukti,
					setl.REMAINING sisa,
					(SELECT sys.VALUE  from tb_r_settlement setl, tb_m_system sys
						WHERE   sys.SYS_CAT = 17 AND sys.SYS_CD = setl.PAYMENT_METHOD 
						and setl.CA_ID = '$form_id') setl_pay_method,
					setl.CREATED_DT tgl_bwt,
					setl.REMARKS remark,
					(select fs.REMARKS from  tb_r_form_status fs, tb_r_settlement setl
					where setl.CA_ID = fs.FORM_ID AND fs.FORM_TYPE_ID = '6') remarks_accept,
					(select sys.VALUE from  tb_r_form_status fs, tb_r_settlement setl,tb_m_system sys
					where setl.CA_ID = fs.FORM_ID AND fs.FORM_TYPE_ID = '6' and sys.SYS_CAT = 18 AND sys.SYS_CD = fs.STATUS) set_status
				FROM 
					tb_r_settlement setl,
					tb_r_ca ca
				WHERE 
					ca.CA_ID = setl.CA_ID ";
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
	function get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type
				WHERE	
					TYPE IS NULL";
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