<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS014
* Program Name     : Detail Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS014 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_form_detail($form_id)
	{
		$sql = "SELECT 
						lv.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
					    usr.USER_EMAIL employee_email,
					    lt.LEAVE_TYPE_NAME leave_type,
					    lv.DATE_START start_date,
					    lv.DATE_END end_date,
					    lv.DATE_BACK back_date,
					    lv.LEAVE_AMOUNT amount,
					    lv.ADDRESS address,
					    lv.PHONE phone,
					    sys.VALUE status,
					    fs.STATUS status_id
				    
				FROM 
						TB_R_FORM_STATUS fs,
						TB_M_EMPLOYEE empl,
						TB_R_LEAVE lv,
					    TB_M_USER usr,
					    TB_M_LEAVE_TYPE lt,
					    TB_M_SYSTEM sys
				WHERE
					    lv.LEAVE_ID = '$form_id' AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    lv.LEAVE_TYPE_ID = lt.LEAVE_TYPE_ID AND
					    sys.SYS_CAT = '3' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = lv.LEAVE_ID AND
					    fs.FORM_TYPE_ID = '1' ";	
		return fetchArray($sql, 'row');
	}	

	function get_form_remarks($form_id)
	{
		$sql = "SELECT 
						fcl.REMARKS
				FROM 
						TB_R_FORM_CONFIRMATION_LIST fcl
				WHERE
					    fcl.FORM_TYPE_ID = '1' AND
					    fcl.FORM_ID = '$form_id' ";	
		return fetchArray($sql, 'one');
	}

	function save_confirmation($status)
	{
		$sql="INSERT INTO 
						TB_R_FORM_CONFIRMATION_LIST 
											(	'FORM_ID',
												'CONFIRMATION_ID',
												'USER',
												'STATUS') 	
				VALUES 
											((SELECT 
													lv.LEAVE_ID,
													con.FORM_ID 
												FROM 
													TB_R_LEAVE lv,
													TB_R_FORM_CONFIRMATION_LIST 
												WHERE 
													lv.LEAVE_ID=con.FORM_ID
												)
											 '$status[FORM_ID]',
											 '$status[CONFIRMATION_ID]',
											 '$status[USER]'
											 '$status[STATUS]'')";	

	}
}