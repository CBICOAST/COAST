<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS010
* Program Name     : Daftar Tipe Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 19-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS010 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function tampil_leave() 
	{
		$gender = $this->user['gender'];
		$query=$this->db->query("select 
										*
								from 
										tb_m_leave_type lt
								where
										(lt.GENDER_TYPE = '$gender' OR
										lt.GENDER_TYPE = '0')  AND
										lt.STATUS = '1'");		
		return $query->result_array();
	}	
}