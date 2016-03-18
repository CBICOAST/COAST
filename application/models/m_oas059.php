<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
*Program Id    	   : OAS059
* Program Name     : Daftar Sisa Cuti Tahunan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 18-12-2014 13:14:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description* 
* 1					16/02/2015 		   Dwi Irawati			Edit Annual Leave
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS059 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_employee_list($year)
	{
		$sql = " SELECT
					empl.EMPLOYEE_ID employee_id,
					empl.EMPLOYEE_NAME employee_name,
					lv_trx.BALANCE annual_leave	,
					lv_trx.YEAR year						
				FROM
					tb_m_employee empl,
					tb_r_annual_leave_trx lv_trx
				WHERE
					empl.EMPLOYEE_ID = lv_trx.EMPLOYEE_ID AND
					YEAR = '$year'
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_form_detail($year, $id_empl)
	{
		$sql = "SELECT
					empl.EMPLOYEE_ID employee_id,
					empl.EMPLOYEE_NAME employee_name,
					lv_trx.BALANCE annual_leave,
					lv_trx.YEAR year					
				FROM
					tb_m_employee empl,
					tb_r_annual_leave_trx lv_trx
				WHERE
					empl.EMPLOYEE_ID = lv_trx.EMPLOYEE_ID AND
                empl.EMPLOYEE_ID = '$id_empl' AND
					YEAR = '$year'
				ORDER BY empl.EMPLOYEE_NAME ASC";	
		return fetchArray($sql, 'row');
	}
	
	function updateannualleave ($sbmt)
	{
		$ack = 0;
		//mengupdate data di tabel CA
		$sql = " UPDATE
						tb_r_annual_leave_trx 
				SET
						BALANCE 		='$sbmt[BALANCE]',
					    UPDATED_DT		='".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						UPDATED_BY		='user: $sbmt[this_email]'
				WHERE
						EMPLOYEE_ID = '$sbmt[EMPLOYEE_ID]' AND
                        YEAR = '$sbmt[YEAR]' ";

		if($this->db->query($sql))
		
		
		return $ack;
	}
	
	
}