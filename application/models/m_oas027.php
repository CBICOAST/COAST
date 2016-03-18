<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS027
* Program Name     : Add/Edit Jenis Charge Code
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 04-10-2014 32:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS027 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function cek_chargecode($new_type)
    {
    	$sql = "SELECT 
						COUNT(*)
				FROM 
			            tb_m_charge_code
				WHERE
					CHARGE_CODE ='".$new_type['CHARGE_CODE']."'";
        return fetchArray($sql, 'one');
    }

	function charge_code_new_type($new_type)
	{	
		$ack = 0;
		$sql = "INSERT INTO
						tb_m_charge_code (CHARGE_CODE,
						PROJECT_DESCRIPTION,
						TYPE,
						DIVISION_ID,
						STATUS,
						CATEGORY_CLAIM_ID,
						CREATED_BY,
						CREATED_DT)
				VALUES
						('$new_type[CHARGE_CODE]',
						'$new_type[PROJECT_DESCRIPTION]',
						'$new_type[TYPE]',
						'$new_type[DIVISION_ID]',
						'$new_type[STATUS]',
						'1',
				        'user: $new_type[this_email]',
				        '".date("Y-m-d H:i:s")."')";
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}

	function update_charge_code_type($sbmt)
	{
		$ack = 0;

		$sql = "UPDATE
						tb_m_charge_code cc
				SET
						cc.CHARGE_CODE = '$sbmt[CHARGE_CODE]',
						cc.PROJECT_DESCRIPTION = '$sbmt[PROJECT_DESCRIPTION]',
						cc.TYPE = '$sbmt[TYPE]',
						cc.STATUS= '$sbmt[STATUS]',
						cc.DIVISION_ID = '$sbmt[DIVISION_ID]',
						cc.UPDATED_BY = 'user: $sbmt[this_email]',
						cc.UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						cc.CHARGE_CODE_ID = '$sbmt[this_id]' ";

		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}
	
	function charge_code_get_type($typeid)
	{
		$sql = " SELECT
							CHARGE_CODE_ID cc_id,
							CHARGE_CODE id,
							PROJECT_DESCRIPTION description,
							TYPE descript_type,
							DIVISION_ID divid,
							STATUS status
				FROM
							tb_m_charge_code 
							
				WHERE
							CHARGE_CODE = '$typeid' ";
		return fetchArray($sql, 'row');
	}
	
	function get_division_list()
	{
		$sql = " SELECT
							pos.POSITION_ID id	
				FROM
							tb_m_position pos ";

		return fetchArray($sql, 'all');
	}
	
}
								
?>								