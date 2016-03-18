<?php 
/************************************************************************************************
  * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS042
* Program Name     : Show Limit Status
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 17-11-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS042 extends CI_Model {
	
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
	
	function get_expense_claim_left($id,$month,$year)
	{
		$sql = "SELECT 
						medical.AMOUNT medis_awal,
						medical.REMAIN_AMOUNT medis,
						trp.AMOUNT transport_awal,
						trp.REMAIN_AMOUNT transport,
						tlk.AMOUNT telkom_awal,
						tlk.REMAIN_AMOUNT telkom,
                        tlk.MONTH bulan,
                        tlk.YEAR tahun
				FROM tb_m_employee empl,
					tb_r_tunjangan tnj inner join
                     (select * from tb_r_tunjangan where EXPENSE_TYPE_ID = '1'
                       and month ='$month' and year = '$year') medical 
					inner join (select * from tb_r_tunjangan
                     where EXPENSE_TYPE_ID = '2' and month ='$month' and year = '$year') trp
					inner join (select * from tb_r_tunjangan 
                    where EXPENSE_TYPE_ID = '3'and month ='$month' and year = '$year') tlk
				WHERE 
					tnj.EMPLOYEE_ID = medical.EMPLOYEE_ID AND
					tnj.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					tnj.EMPLOYEE_ID = trp.EMPLOYEE_ID AND
					tnj.EMPLOYEE_ID = tlk.EMPLOYEE_ID AND 
                empl.EMPLOYEE_ID ='$id'";
			return fetchArray($sql, 'row');
	}
	function get_limit_annual_leave($id)
	{
		$sql = "SELECT 
						ANNUAL_LEAVE_ENTITLEMENT cuti,
						PERIODE_MEDICAL_CLAIM periode
				FROM tb_m_employee empl
				WHERE 
					empl.EMPLOYEE_ID ='$id'";
			return fetchArray($sql, 'row');
	}
	
	
}