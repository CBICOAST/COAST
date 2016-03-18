<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS032
* Program Name     : Paid 1
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 01-24-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS032 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	

	function get_form_detail($form_id)
	{
		$sql = "SELECT 
						cl.REF_NO no_ref,
						fs.FORM_ID formid,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
					    usr.USER_EMAIL employee_email,
						cl.SUBMITTED_DATE submitted_dt,
						cl.TANGGAL_KWITANSI tgl_kwitansi,
						fcl.CREATED_DT approve_dt,
					    ct.EXPENSE_TYPE_ID id,
						ct.CLAIM_CATEGORY categori,
					    ct.EXPENSE_TYPE_NAME claim_type,
						cl.TANGGAL_KWITANSI tanggal_kwitansi,
						cl.CHARGE_CODE chargecode,
						cl.TOTAL total,
					    sys.VALUE status,
					    fs.STATUS status_id,
					    cl.CLAIM_ID claim_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_claim cl,
					    tb_m_user usr,
					    tb_m_expense_type ct,
					    tb_m_system sys,
						tb_r_form_confirmation_list fcl
				WHERE
					    cl.CLAIM_ID = '$form_id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
						fcl.FORM_ID = cl.CLAIM_ID AND
					    cl.CLAIM_TYPE_ID = ct.EXPENSE_TYPE_ID AND
					    sys.SYS_CAT = '9' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CLAIM_ID AND
					    fs.FORM_TYPE_ID = '5'";	
		return fetchArray($sql, 'row');
	}	

	
	function get_form_remarks($form_id)
	{
		$sql = "SELECT 
						fcl.REMARKS
				FROM 
						tb_r_form_confirmation_list fcl
				WHERE
					    fcl.FORM_TYPE_ID = '5' AND
					    fcl.FORM_ID = '$form_id' ";	
		return fetchArray($sql, 'one');
	
	}
	function save_paid($status)
	{
		$ack=0;
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='6'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";	
		if($this->db->query($sql))
		{
				$ack = 1;
		} 

			return $ack;

	}

	
}