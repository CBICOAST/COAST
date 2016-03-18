<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS069
* Program Name     : List Total Per Charge Code
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma/Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 09-12-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS069 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 function get_list_bt()
	{
		$sql = "	select 
						bt.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
                        bt.CREATED_DT submited_dt,
                        empl.EMPLOYEE_NAME empl_name,
						bt.CURRENCY currency,
    					bt.TOTAL_AMOUNT_BT amount_bt

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_bt bt,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
       
       
					where   
            
							fc.FORM_ID = bt.BT_ID AND 
                            cc.CHARGE_CODE = bt.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '3' AND
                            bt.TRAVELLER_ID = empl.EMPLOYEE_ID";	
		return fetchArray($sql, 'all');
	}
	
	 function get_list_cl()
	{
		$sql = "	select 
						cl.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
						empl.EMPLOYEE_NAME empl_name,
						cl.SUBMITTED_DATE submited_dt,
						(select sys.VALUE from tb_m_system sys where cc.TYPE = sys.SYS_CD and sys.SYS_CAT = '11') chargecode_type,
    					cl.TOTAL amount_cl

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_claim cl,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
       
       
					where   
            
							fc.FORM_ID = cl.CLAIM_ID AND 
                            cc.CHARGE_CODE = cl.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '5' AND
							cl.EMPLOYEE_ID = empl.EMPLOYEE_ID";	
		return fetchArray($sql, 'all');
	}
	 
	 function get_list_ca()
	{
		$sql = "	                    select 
						ca.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
                        ca.CREATED_DT submited_dt,
                        empl.EMPLOYEE_NAME empl_name,
						ca.CURRENCY currency,
                       (SELECT CASE WHEN  ca.CURRENCY = '1'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_idr,
 					    (SELECT CASE WHEN  ca.CURRENCY = '2'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_usd,
                        (SELECT CASE WHEN  ca.CURRENCY = '3'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_sgd

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_ca ca,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
                         
                     where   
            
							fc.FORM_ID = ca.CA_ID AND 
                            cc.CHARGE_CODE = ca.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '2' AND
                            ca.EMPLOYEE_ID = empl.EMPLOYEE_ID";	
		return fetchArray($sql, 'all');
	}	
function get_search_ca($searchparam)
	{
		$sql = "                    select 
						ca.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
                        ca.CREATED_DT submited_dt,
                        empl.EMPLOYEE_NAME empl_name,
						ca.CURRENCY currency,
                       (SELECT CASE WHEN  ca.CURRENCY = '1'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_idr,
 					    (SELECT CASE WHEN  ca.CURRENCY = '2'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_usd,
                        (SELECT CASE WHEN  ca.CURRENCY = '3'  THEN ca.AMOUNT ELSE 0 END ) amount_ca_sgd

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_ca ca,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
                         
                     where   
            
							fc.FORM_ID = ca.CA_ID AND 
                            cc.CHARGE_CODE = ca.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '2' AND
                            ca.EMPLOYEE_ID = empl.EMPLOYEE_ID
				  
				    ";

		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  ca.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(ca.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(ca.CREATED_DT) = '$searchparam[month]' ";
		}

		$sql .=	"
				ORDER BY
				     cc.CHARGE_CODE DESC";	
		return fetchArray($sql, 'all');
	}
function get_search_cl($searchparam)
	{
		$sql = "select 
						cl.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
						empl.EMPLOYEE_NAME empl_name,
						cl.SUBMITTED_DATE submited_dt,
						(select sys.VALUE from tb_m_system sys where cc.TYPE = sys.SYS_CD and sys.SYS_CAT = '11') chargecode_type,
    					cl.TOTAL amount_cl

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_claim cl,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
       
       
					where   
            
							fc.FORM_ID = cl.CLAIM_ID AND 
                            cc.CHARGE_CODE = cl.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '5' AND
							cl.EMPLOYEE_ID = empl.EMPLOYEE_ID
				  
				    ";

		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  cl.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(cl.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(cl.CREATED_DT) = '$searchparam[month]' ";
		}

		$sql .=	"
				ORDER BY
				     cc.CHARGE_CODE DESC";	
		return fetchArray($sql, 'all');
	}
	function get_search_bt($searchparam)
	{
		$sql = "select 
						bt.CHARGE_CODE chargecode_id,
                        cc.PROJECT_DESCRIPTION chargecode_name,
                        bt.CREATED_DT submited_dt,
                        empl.EMPLOYEE_NAME empl_name,
						bt.CURRENCY currency,
    					bt.TOTAL_AMOUNT_BT amount_bt

       
					from 
							tb_r_form_confirmation_list fc,
                            tb_r_bt bt,
                            tb_m_charge_code cc,
                            tb_m_employee empl
                         
       
       
					where   
            
							fc.FORM_ID = bt.BT_ID AND 
                            cc.CHARGE_CODE = bt.CHARGE_CODE AND
                            fc.FORM_TYPE_ID = '3' AND
                            bt.TRAVELLER_ID = empl.EMPLOYEE_ID
				  
				    ";

		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  bt.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(bt.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(bt.CREATED_DT) = '$searchparam[month]' ";
		}

		$sql .=	"
				ORDER BY
				     cc.CHARGE_CODE DESC";	
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
	
	 }