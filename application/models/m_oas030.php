<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS030
* Program Name     : Pengaturan Approval
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 16-03-2015 10:23:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS030 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_division_list()
	{
		$sql = "SELECT DIVISION_ID  div_id
				FROM tb_m_employee GROUP BY DIVISION_ID";
		return fetchArray($sql,'all');
	}	

	function get_employee_list($div)
	{
		$sql = " SELECT
					empl.EMPLOYEE_ID id,
					empl.EMPLOYEE_NAME nama							
				FROM
					tb_m_employee empl
				WHERE 
					DIVISION_ID = '$div' AND
					STATUS = '1'
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_all_employee_list()
	{
		$sql = " SELECT
					empl.EMPLOYEE_ID id,
					empl.EMPLOYEE_NAME nama							
				FROM
					tb_m_employee empl
				WHERE 
					STATUS = '1'
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	function updateApproval($data)
	{
		$ack = 0;		
		$sql = "UPDATE
						tb_m_approval
				SET
							EMPLOYEE_ID = '$data[EMPLOYEE_ID]',
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						APPROVAL_FOR = '$data[APPROVAL_FOR]'";        
		
						
		$this->db->trans_start();
			$this->db->query($sql);			
		if($this->db->trans_complete())
		{
			$ack = 1;
		}
	}
	
	function get_Approval($id){
	$sql = " SELECT 
				emp.EMPLOYEE_ID nik,
				emp.EMPLOYEE_NAME nama,
				emp.DIVISION_ID divid,
				apr.APPROVAL_FOR untuk,
				apr.VALUE value
			FROM tb_m_approval apr,
				tb_m_employee emp
			WHERE emp.EMPLOYEE_ID = apr.EMPLOYEE_ID AND
				apr.APPROVAL_FOR = '$id'";
							
		return fetchArray($sql, 'row');
	}
	
}