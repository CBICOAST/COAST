<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS0106
* Program Name     : Setting Ship To List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 23-02-215 10:40:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS106 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_item_list()
	{
		$sql = " SELECT
					SHIPTO_ID id,
					S_COMPANY destination,
                    S_CP satuan
				FROM
					tb_r_shipto
				ORDER BY id ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_search_list($destination = '')
	{
		$sql = " SELECT
					SHIPTO_ID id,
					S_COMPANY destination,
                    S_CP satuan
				FROM
					tb_r_shipto
				";
		
		if($destination != ''){
			$sql .= " WHERE SHIPTO_ID = '$destination' ";			
		}
			$sql .= "ORDER BY SHIPTO_ID ASC ";
		return fetchArray($sql, 'all');
	}
	
	function delete_itempr ($id)
	{
	$ack = 0;
		$sql = "DELETE FROM tb_r_shipto WHERE SHIPTO_ID = '$id'";
		
			if($this->db->query($sql))
	
		return $ack;
	}
	
}