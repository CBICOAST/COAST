<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS020
* Program Name     : Show Calendar
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 28-08-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS020 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_leave_list_feed()
	{
		$sql = "SELECT 
						lv.LEAVE_ID leave_id,
					    lv.REF_NO no_ref,
					    lv.DATE_START start_dt,
					    (lv.DATE_END + INTERVAL 1 DAY) end_dt,
					    fs.STATUS status_id,
					    lv.EMPLOYEE_ID employee_id,
					    empl.EMPLOYEE_NAME employee_name,
					    usr.USER_EMAIL employee_email,
					    lt.LEAVE_TYPE_NAME leave_type
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_leave lv,
					    tb_m_user usr,
					    tb_m_leave_type lt
				WHERE
						fs.FORM_TYPE_ID = '1' AND
						
					    lv.LEAVE_ID = fs.FORM_ID AND
					    lt.LEAVE_TYPE_ID = lv.LEAVE_TYPE_ID AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    fs.STATUS  = '1'
				    
				ORDER BY
				    	lv.REF_NO DESC ";	
		return fetchArray($sql, 'all');
	}	
}