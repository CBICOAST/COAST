<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS026
* Program Name     : CHARGE CODE LIST
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS026 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_list($typeID)
	{
		$sql = "SELECT 
						cc.CHARGE_CODE id,
						cc.PROJECT_DESCRIPTION deskripsi,
                     	sys.VALUE TYPE,
						cc.STATUS status					
				FROM 
						tb_m_charge_code cc,
						tb_m_system sys

				WHERE
						
						sys.SYS_CAT= '11' AND
						cc.TYPE = sys.SYS_CD  AND
                         cc.STATUS = '1'
				";
		return fetchArray($sql, 'all');
	}	
	function get_search_list($typeID, $searchparam)
	{
		$sql = "SELECT 
						cc.CHARGE_CODE id,
						cc.PROJECT_DESCRIPTION deskripsi,
                     	sys.VALUE TYPE,
						cc.STATUS status					
				FROM 
						tb_m_charge_code cc,
						tb_m_system sys
				WHERE
						sys.SYS_CAT= '11' AND
						cc.TYPE = sys.SYS_CD ";
										 
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  cc.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		
		if($searchparam['statuschargecode'] != ''){
			$sql .=	" AND  cc.STATUS = '$searchparam[statuschargecode]' ";
		}
		$sql .=  "ORDER BY sys.VALUE ASC";
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
							pos.CATEGORY_CLAIM_ID = '1'";

		if($chargecodetype_id !=''){
			$sql .= "AND pos.TYPE = '$chargecodetype_id' ";	
		}
		return fetchArray($sql, 'all');
	}

	function get_status()
	{
		$sql = " SELECT 
						sys.SYS_CD id,
						sys.VALUE val
				 FROM 
						tb_m_system sys
				WHERE
						sys.SYS_CAT = '8'";
		return fetchArray($sql, 'all');
	}
		
}
?>