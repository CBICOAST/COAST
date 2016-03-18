<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS107
* Program Name     : Informasi Permohonan CA
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 28-03-2015 08:36:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS107 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_show_status_PR($employee_id) 
	{
		$sql = "select 
										usr.SHOW_PR_INFORMATION
								from 
										tb_m_user usr
								where
										usr.EMPLOYEE_ID = '$employee_id' ";	
		return fetchArray($sql, 'one');
	}	

	function turn_off_PR_information()
	{
		$ack = '0';
		$user = $this->user['id'];
		$email = $this->user['email'];
		$datenow = date("Y-m-d H:i:s");

		$sql = "UPDATE
						tb_m_user usr
				SET
						usr.SHOW_PR_INFORMATION = '0',
						usr.UPDATED_BY = 'user: $email',
						usr.UPDATED_DT = '$datenow'
				WHERE
						usr.EMPLOYEE_ID = '$user'				 ";	
		
		if($this->db->query($sql))
		{
			$ack = '1';
		}

		return $ack;
	}
}