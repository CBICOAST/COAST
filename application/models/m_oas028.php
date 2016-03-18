 <?php
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS028
* Program Name     : Informasi Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 16-12-2014 13:40:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS028 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_show_status($employee_id) 
	{
		$sql = "select 
										usr.SHOW_SETTLE_INFORMATION
								from 
										tb_m_user usr
								where
										usr.EMPLOYEE_ID = '$employee_id' ";	
		return fetchArray($sql, 'one');
	}	

	function turn_off_settle_information()
	{
		$ack = '0';
		$user = $this->user['id'];
		$email = $this->user['email'];
		$datenow = date("Y-m-d H:i:s");

		$sql = "UPDATE
						tb_m_user usr
				SET
						usr.SHOW_SETTLE_INFORMATION = '0',
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