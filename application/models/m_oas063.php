<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS063
* Program Name     : Setting Dim Per Level
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 08:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS063 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_destination_list()
	{
		$sql = " SELECT
					LEVEL_ID id,
					LEVEL_NAME destination
				FROM
					tb_m_position_level
				ORDER BY LEVEL_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_search_list($destination = '')
	{
		$sql = " SELECT
					LEVEL_ID id,
					LEVEL_NAME destination,
					DIM_AMOUNT cost,
                    DIM_AMOUNT_DOMESTIK costdom,
                    DIM_AMOUNT_INTERNATIONAL costint
				FROM
					tb_m_position_level
				";
		
		if($destination != ''){
			$sql .= " WHERE LEVEL_ID = '$destination' ";			
		}
			$sql .= "ORDER BY LEVEL_ID ASC ";
		return fetchArray($sql, 'all');
	}
}