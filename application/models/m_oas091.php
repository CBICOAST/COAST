
<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS091
* Program Name     : Add/Edit Menu Item PR
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 23-02-2015 10:39:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS091 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function submitMenuList($data)
	{
		$ack = 0;

		// [1] Insert data into employee table
		$sql = "INSERT INTO
						tb_m_item_list (DESCRIPTION,
										SATUAN)
				VALUES (	 '$data[DESCRIPTION]',
							 '$data[SATUAN]')";
		
		if($this->db->query($sql))
		{ $ack = 1; }
		
		return $ack;
	}

		function get_list_info($no_item)
	{
		$sql = " SELECT
							empl.*
							
				FROM
							tb_m_item_list empl
				WHERE
							empl.ITEM_ID = '$no_item' ";
		return fetchArray($sql, 'row');
	}

	function get_list()
	{
		$sql = " SELECT
							empl.ITEM_ID id,
							empl.DESCRIPTION name			
				FROM
							tb_m_item_list empl 
				ORDER BY
							empl.ITEM_ID ASC";
		return fetchArray($sql, 'all');
	}

	


}