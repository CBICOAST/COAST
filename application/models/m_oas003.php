<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS003
* Program Name     : Change Password before Use COAST
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni OKtaviani
* Version          : 01.00.00
* Creation Date    : 23-03-2015 23:41:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS003 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function save_new_password($employee)
	{
		$ack = 0;
		$sql_pwd = "UPDATE
						tb_m_user
				SET							
							USER_PASSWORD  ='$employee[password]',
							STATUS_PASSWORD = 'NEW',
							UPDATED_BY = 'user: $employee[this_user]',
							UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						EMPLOYEE_ID = '$employee[EMPLOYEE_ID]'";
					
			
		if($this->db->query($sql_pwd))
		{
			$ack = 1;
		}
		return $ack;
	}
	
}