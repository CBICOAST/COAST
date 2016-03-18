<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS096
* Program Name     : Daftar Setting Limit Nominal Notif to Director
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma 
* Version          : 01.00.00
* Creation Date    : 16-03-2015 19:00:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS096 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_user($currency_id = '') 
	{
		$sql = " SELECT
							arm.ID_LIMIT_DIR ccid,
							arm.CURRENCY cc,
                            arm.NOMINAL_PR nominal,
							sys.VALUE val
							
				FROM
							tb_m_system sys,
                            tb_m_setting_limit_dir arm
				WHERE
							
                            arm.CURRENCY = sys.SYS_CD AND
                            sys.SYS_CAT = 16
                     ";
		if($currency_id != ''){
			$sql .= " AND arm.CURRENCY = '$currency_id' ";
			$sql .= " ORDER BY arm.CURRENCY ASC ";
			return fetchArray($sql, 'all');
		}
		$sql .= " ORDER BY arm.CURRENCY ASC ";
		return fetchArray($sql, 'all');
	}

	function get_currency_list()
	{
		$sql = " SELECT
							po.ID_LIMIT_DIR id,
							po.CURRENCY cc,
							sys.VALUE val
							
				FROM
							tb_m_setting_limit_dir po,
							tb_m_system sys
				WHERE
							
                            po.CURRENCY = sys.SYS_CD AND
                            sys.SYS_CAT = 16
							
				ORDER BY po.CURRENCY ASC ";
		return fetchArray($sql, 'all');
	}

}