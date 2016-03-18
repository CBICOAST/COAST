
<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS094
* Program Name     : Add/Edit List ShipTo
* contactpersonion      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 03-03-2015 14:39:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      contactpersonion
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS094 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function submitMenuList($data)
	{
		$ack = 0;

		// [1] Insert data into employee table
		$sql = "INSERT INTO
						tb_r_shipto (S_COMPANY,
										S_CP,
										S_ADDRESS,
										S_TELP,
										S_EMAIL,
										S_NPWP)
				VALUES (
							 '$data[S_COMPANY]',
							 '$data[S_CP]',
							 '$data[S_ADDRESS]',
							 '$data[S_telpon]',
							 '$data[S_EMAIL]',
							 '$data[S_NPWP]'
							 )";
		
		if($this->db->query($sql))
		{ $ack = 1; }
		
		return $ack;
	}

		function get_list_info($companyname)
	{
		$sql = " SELECT
							empl.*
							
				FROM
							tb_r_shipto empl
				WHERE
							empl.SHIPTO_ID = '$companyname' ";
		return fetchArray($sql, 'row');
	}

	function get_list()
	{
		$sql = " SELECT
							empl.SHIPTO_ID id,
							empl.S_COMPANY name			
				FROM
							tb_r_shipto empl 
				ORDER BY
							empl.SHIPTO_ID ASC";
		return fetchArray($sql, 'all');
	}

	


}