<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS031
* Program Name     : List Document
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 14-9-2015 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS031 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 
 function get_list()
	{
		$sql = "SELECT
						DOCUMENT_ID id,
						DOCUMENT_NAME nama,
						DOCUMENT_LOCATION docloc,
						DOCUMENT_DESCRIPTION deskripsi,
						CREATED_BY oleh
				    
				FROM 
						tb_m_document
				WHERE 
						DOCUMENT_STATUS != 'NEW'";	
		return fetchArray($sql, 'all');
	}
	
	function delete_itemdoc ($id)
	{
	$ack = 0;
		$sql = "DELETE FROM tb_m_document WHERE DOCUMENT_ID = '$id'";
		
			if($this->db->query($sql))
	
		return $ack;
	}
	

function get_search_list($searchparam)
	{
		$sql = "SELECT
						DOCUMENT_ID id,
						DOCUMENT_NAME nama,
						DOCUMENT_LOCATION docloc,
						DOCUMENT_DESCRIPTION deskripsi,
						CREATED_BY oleh
				    
				FROM 
						tb_m_document
				WHERE
						DOCUMENT_ID != '0'";
		
		
		
		if($searchparam['doc_id'] != ''){
			$sql .=	"AND  DOCUMENT_ID = '$searchparam[doc_id]' ";
		}
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(CREATED_DT) = '$searchparam[year]' ";
		}
		return fetchArray($sql, 'all');
	}	

	
	
}