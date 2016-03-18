<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS004
* Program Name     : Notification Page and Service
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			19-10-2014			winni oktaviani 	add function get_claim_left_count
* 	2.00			19-10-2014			winni oktaviani 	add function get_claim_left_count_min1
* 	2.00			19-10-2014			winni oktaviani 	add function get_claim_left_count_min2
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS004 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_leave_left_count($data)
	{
		$sql = " SELECT
							BALANCE
				FROM
							tb_r_annual_leave_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}

	function get_notif_count($data)
	{
		$sql = " SELECT
							COUNT(*)
				FROM
							tb_r_notification notif
							
				WHERE
							notif.RECIPIENT_EMPLOYEE_ID = '$data[this_id]'  AND
							notif.NOTIFICATION_STATUS_ID = '1' ";
		return fetchArray($sql, 'one');
	}

	function get_notif_list($data)
	{
		$sql = " SELECT
							notif.ID id,

							notif.RECIPIENT_EMPLOYEE_ID target_id,

							notif.SENDER_EMPLOYEE_ID from_id,
							empl.EMPLOYEE_NAME from_name,

							notif.ACTIVITY_TYPE_ID activity_id,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '6' AND sys.SYS_CD = notif.ACTIVITY_TYPE_ID) activity_name,

							notif.FORM_TYPE_ID type_id,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '7' AND sys.SYS_CD = notif.FORM_TYPE_ID) type_name,

							notif.FORM_ID form_id,
							
							notif.CREATED_BY create_name,

							notif.NOTIFICATION_INFORMATION info,

							notif.NOTIFICATION_STATUS_ID status,
							cl.STATUS status_id,

							notif.NOTIFICATION_TIME time,
							cl.FORM_ID formid

				FROM
							tb_r_notification notif,
							tb_m_employee empl,
							tb_r_form_status cl
							
				WHERE
							notif.RECIPIENT_EMPLOYEE_ID = '$data[this_id]'  AND
							notif.FORM_TYPE_ID = cl.FORM_TYPE_ID AND
							notif.NOTIFICATION_STATUS_ID = '1' AND
							cl.FORM_ID = notif.FORM_ID AND
							empl.EMPLOYEE_ID = notif.SENDER_EMPLOYEE_ID
			
				ORDER BY
							notif.NOTIFICATION_TIME DESC
							
							";
		return fetchArray($sql, 'all');
	}

	function mark_as_read($data)
	{
		$sql = " UPDATE
							tb_r_notification

				SET
							NOTIFICATION_STATUS_ID = '0'
							
				WHERE
							RECIPIENT_EMPLOYEE_ID = '$data[this_id]'
							
							";
		$this->db->query($sql);
	}
	
	function get_claim_left_count($data)
	{
		$sql = " SELECT
							BALANCE_MEDICAL bm
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_transport_left_count($data)
	{
		$sql = " SELECT
							BALANCE_TRANSPORT bt
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_transport_left_count_min1($data)
	{
		$sql = " SELECT
							BALANCE_TRANSPORT bt
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 1 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_transport_left_count_min2($data)
	{
		$sql = " SELECT
							BALANCE_TRANSPORT bt
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 2 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_left_count_min1($data)
	{
		$sql = " SELECT
							BALANCE_MEDICAL bm
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 1 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_left_count_min2($data)
	{
		$sql = " SELECT
							BALANCE_MEDICAL bm,
							BALANCE_TRANSPORT bt,
							BALANCE_KOMUNIKASI bk
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 2 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_komunikasi_left_count($data)
	{
		$sql = " SELECT
							BALANCE_KOMUNIKASI bk
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_komunikasi_left_count_min1($data)
	{
		$sql = " SELECT
							BALANCE_KOMUNIKASI bk
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 1 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	function get_claim_komunikasi_left_count_min2($data)
	{
		$sql = " SELECT
							BALANCE_KOMUNIKASI bk
				FROM
							tb_r_annual_claim_trx
							
				WHERE
							EMPLOYEE_ID = '$data[this_id]'  AND
							MONTH = (".DATE("m").") - 2 AND
							YEAR = '".DATE("Y")."' ";
		return fetchArray($sql, 'one');
	}
	
}

