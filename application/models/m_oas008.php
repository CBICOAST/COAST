<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS008
* Program Name     : Leave Type List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS008 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_list($typeID)
	{
		$sql = "SELECT 
						lt.*,
						sys.VALUE STATUS
				FROM 
						tb_m_leave_type lt,
						tb_m_system sys

				WHERE
						sys.SYS_CAT= '8' AND
						sys.SYS_CD = lt.STATUS
										 ";
						return fetchArray($sql);
	}
}
?>