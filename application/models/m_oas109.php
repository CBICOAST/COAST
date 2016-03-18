<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS021
* Program Name     : Informasi Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:35:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0		     28-03-2015	       Metta Kharisma	     Add Function to show status expense
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS109 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_show_status_expense($employee_id) 
	{
		$sql = "select 
										usr.SHOW_PO_INFORMATION
								from 
										tb_m_user usr
								where
										usr.EMPLOYEE_ID = '$employee_id' ";	
		return fetchArray($sql, 'one');
	}	

	function turn_off_expense_information()
	{
		$ack = '0';
		$user = $this->user['id'];
		$email = $this->user['email'];
		$datenow = date("Y-m-d H:i:s");

		$sql = "UPDATE
						tb_m_user usr
				SET
						usr.SHOW_PO_INFORMATION = '0',
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