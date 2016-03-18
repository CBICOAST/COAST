<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS016
* Program Name     : Master Tanggal Libur
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS016 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
		function get_search_list($searchparam)
	{
		$sql = "SELECT 
						*
				FROM 
						tb_m_tanggal_libur tl
				WHERE
				    	1=1 ";			    
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(tl.TANGGAL) = '$searchparam[year]' ";
		}

		$sql .=	"ORDER BY
				    	tl.TANGGAL DESC ";	
		return fetchArray($sql, 'all');
	}	
	
	function get_list($typeID)
	{
		$sql = "SELECT 
						*
						FROM 
						tb_m_tanggal_libur tl
						ORDER BY
				    	tl.TANGGAL DESC ";
						return fetchArray($sql);
	}
}
?>