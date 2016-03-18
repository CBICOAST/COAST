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

class M_OAS017 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function leave_new_holiday($new_holiday)
	{	
		$ack = 0;
		$sql = "INSERT INTO
						tb_m_tanggal_libur (
						TANGGAL,
						TIPE_TANGGAL_LIBUR,
						KETERANGAN)
				VALUES
						(
						'$new_holiday[TANGGAL]',
						'$new_holiday[TIPE_TANGGAL_LIBUR]',
						'$new_holiday[KETERANGAN]' )";
				
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}

	function get_info($id)
	{
		$sql = "	SELECT
							tl.ID id,
							tl.TANGGAL tgl,
							tl.TIPE_TANGGAL_LIBUR tipe,
							tl.KETERANGAN keterangan
					FROM
							tb_m_tanggal_libur tl
					WHERE
							tl.ID = '$id'
							";
		return fetchArray($sql, 'row');
	}

	function leave_update_holiday($sbmt)
	{
		$ack = 0;
		$sql = "UPDATE
						tb_m_tanggal_libur 
				SET
						TANGGAL = '$sbmt[TANGGAL]',
						TIPE_TANGGAL_LIBUR = '$sbmt[TIPE_TANGGAL_LIBUR]',
						KETERANGAN = '$sbmt[KETERANGAN]'
				WHERE
						ID = '$sbmt[ID]'	";
				
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
	}
}
								
?>								