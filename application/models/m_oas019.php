<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS019
* Program Name     : Add/Edit Jenis Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS019 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function leave_new_type($new_type)
	{	
		$ack = 0;
		$sql = "INSERT INTO
						tb_m_leave_type (LEAVE_TYPE_NAME,
						LEAVE_LENGTH_MAX,
						LEAVE_TYPE_DESCRIPTION,
						LEAVE_SUBMISSION_MIN,
						GENDER_TYPE,
						STATUS,
						CREATED_BY,
						CREATED_DT)
				VALUES
						('$new_type[LEAVE_TYPE_NAME]',
						'$new_type[LEAVE_LENGTH]',
						'$new_type[LEAVE_TYPE_DESCRIPTION]',
						'$new_type[LEAVE_SUBMISSION_MIN]',
						'$new_type[GENDER_TYPE]',
						'$new_type[STATUS]',
				        'user: $new_type[this_email]',
				        '".date("Y-m-d H:i:s")."')";
				
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}

	function update_leave_type($sbmt)
	{
		$ack = 0;

		$sql = "UPDATE
						tb_m_leave_type lt
				SET
						lt.LEAVE_TYPE_NAME = '$sbmt[LEAVE_TYPE_NAME]',
						lt.LEAVE_LENGTH_MAX = '$sbmt[LEAVE_LENGTH]',
						lt.LEAVE_TYPE_DESCRIPTION = '$sbmt[LEAVE_TYPE_DESCRIPTION]',
						lt.LEAVE_SUBMISSION_MIN = '$sbmt[LEAVE_SUBMISSION_MIN]',
						lt.GENDER_TYPE = '$sbmt[GENDER_TYPE]',
						lt.STATUS = '$sbmt[STATUS]',
						lt.UPDATED_BY = 'user: $sbmt[this_email]',
						lt.UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE
						lt.LEAVE_TYPE_ID = '$sbmt[this_id]' ";

		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}

	function leave_get_type($typeid)
	{
		$sql = " SELECT
							lt.LEAVE_TYPE_ID id,
							lt.LEAVE_TYPE_NAME name,
							lt.LEAVE_TYPE_DESCRIPTION description,
							lt.LEAVE_LENGTH_MAX length_max,
							lt.LEAVE_SUBMISSION_MIN min,
							lt.GENDER_TYPE gender,
							lt.STATUS status
							
				FROM
							tb_m_leave_type lt
				WHERE
							lt.LEAVE_TYPE_ID = '$typeid' ";
		return fetchArray($sql, 'row');
	}
}
								
?>								