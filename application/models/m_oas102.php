<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS102
* Program Name     : Edit Bantuan Per Level
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 13-02-2015 12:35:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS102 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	
	function get_cost_info($levelId)
	{
		$sql = " SELECT
							lvl.*
				FROM
							tb_m_position_level lvl  
				WHERE
							lvl.LEVEL_ID = '$levelId' ";
		return fetchArray($sql, 'row');
	}

	// fungsi untuk mengambil daftar bantuan
	function get_list_bantuan() 
	{
		$sql = " SELECT *
				 FROM 
					tb_m_expense_type
				 WHERE 
					TYPE_INDIVIDU = '2' AND
					EXPENSE_TYPE_PARENT IS NULL  ";
		return fetchArray($sql, 'all');
	}
	
	function get_category_claim($id, $child, $lvl)
	{
		$sql = " SELECT
					lvl.LEVEL_ID id,
					lvl.LEVEL_NAME level,
					et.EXPENSE_TYPE_NAME nama,
					bnt.AMOUNT amount            
                
				FROM
					tb_m_position_level lvl,
                 tb_m_bantuan bnt,
                tb_m_expense_type et
                where lvl.LEVEL_ID = bnt.LEVEL_ID AND
                et.EXPENSE_TYPE_ID = bnt.EXPENSE_TYPE_ID AND
                (et.EXPENSE_TYPE_ID ='". $id."' OR
				et.EXPENSE_TYPE_ID = '".$child."') AND
				lvl.LEVEL_ID = '". $lvl."'
			ORDER BY LEVEL_NAME ASC";
							
		return fetchArray($sql, 'all');
	}
	
	function get_kelahiran_list($id)
	{
		$sql = " SELECT
					et.EXPENSE_TYPE_ID id,
					et.EXPENSE_TYPE_NAME name,
					et.CLAIM_CATEGORY cat					
				FROM
					tb_m_expense_type et 
				WHERE
					et.EXPENSE_TYPE_PARENT = '".$id."' AND
					et.STATUS = '1'";
							
		return fetchArray($sql, 'all');
	}
	
	//fungsi untuk update amount bantuan per level
	function updateBantuan($data)
	{
		$ack = 0;		
		$sql = "UPDATE
						tb_m_bantuan
				SET
							AMOUNT = '$data[AMOUNT]',
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						LEVEL_ID = '$data[LEVEL_ID]' AND
						EXPENSE_TYPE_ID = '$data[TYPE_ID]'";        
		// Update amount per Karyawan berdasarkan Level dan Status Permanen
		$sql2 = "UPDATE  tb_r_bantuan
				SET
					AMOUNT = '$data[AMOUNT]',
							UPDATED_BY = 'user: $data[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
					EXPENSE_TYPE_ID = '$data[TYPE_ID]' AND 
					REMAIN != '0' AND
					EMPLOYEE_ID IN (select EMPLOYEE_ID  FROM (SELECT bnt.EMPLOYEE_ID FROM tb_r_bantuan bnt, tb_m_position_level lvl,tb_m_employee emp
									WHERE emp.EMPLOYEE_ID = bnt.EMPLOYEE_ID AND emp.LEVEL_ID = lvl.LEVEL_ID AND bnt.EXPENSE_TYPE_ID = '$data[TYPE_ID]' and  emp.STATUS_ID = '1' AND lvl.LEVEL_ID = '$data[LEVEL_ID]') as tmptable) ";      
						
						
		$this->db->trans_start();
			$this->db->query($sql);
			$this->db->query($sql2);
			
		if($this->db->trans_complete())
		{
			$ack = 1;
		}
		
		
		return $ack;
	}
	
}