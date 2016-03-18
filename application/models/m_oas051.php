<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS051
* Program Name     : Add/Edit Setting Limit Nominal Notif to Director
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma 
* Version          : 01.00.00
* Creation Date    : 23-11-2014 10:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS051 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function update_limit_nominal_new_type($sbmt)
	{
		$ack = 0;
		$sql = "UPDATE
						tb_m_setting_limit_dir ca
				SET
						ca.CURRENCY = '$sbmt[CURRENCY]',
						ca.NOMINAL = '$sbmt[NOMINAL]'
				WHERE
						ca.CURRENCY = '$sbmt[CURRENCY]' ";


		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}
	
	function get_type_list()
	{
		$sql = " SELECT
							arm.ID_LIMIT_DIR ln_id,
							arm.CURRENCY,
							sys.VALUE val
							
				FROM
							
                            tb_m_system sys,
                            tb_m_setting_limit_dir arm
				WHERE
							
                            arm.CURRENCY = sys.SYS_CD AND
							sys.SYS_CAT = 16
							";
		return fetchArray($sql, 'all');
		}

	
function getFormInfo($typeid)
	{
		$sql = " SELECT
						apr.ID_LIMIT_DIR ln_id,
						apr.CURRENCY,
						apr.NOMINAL,
						sys.VALUE val
				FROM 
						tb_m_setting_limit_dir apr,
						tb_m_system sys
				WHERE		
						    apr.CURRENCY = sys.SYS_CD AND
                            sys.SYS_CAT = 16 AND
						apr.CURRENCY = '$typeid'
						";
		return fetchArray($sql, 'row');
	}
}
								
?>								