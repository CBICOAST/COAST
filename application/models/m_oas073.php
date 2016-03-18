<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS048
* Program Name     : Daftar Setting Permission Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 19-11-2014 21:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS073 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_user($employee_id = '') 
	{
		$sql = "SELECT
							empl.*,
							usr.*,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '5' AND usr.USER_STATUS = sys.SYS_CD) STATUS,
							ug.USER_GROUP_NAME,
							pl.LEVEL_NAME,
							pd.POSITION_DEPTH_TITLE,
							(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '4' AND empl.GENDER_ID = sys.SYS_CD) GENDER,
                         (select pos.POSITION_NAME from tb_m_position pos where empl.POSITION_ID = pos.POSITION_ID) divisi_name
							
				FROM
							tb_m_user usr,
							tb_m_employee empl,
							tb_m_user_group ug,
							tb_m_position_level pl,
							tb_m_position_depth pd
				WHERE
							usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							usr.USER_GROUP_ID = ug.USER_GROUP_ID AND
							empl.LEVEL_ID = pl.LEVEL_ID AND
							empl.POSITION_DEPTH_ID = pd.POSITION_DEPTH_ID   ";
		if($employee_id != ''){
			$sql .= " AND empl.EMPLOYEE_ID = '$employee_id' ";
			
		}
		$sql .= " ORDER BY empl.PRIVILEGE_PR DESC ";
		return fetchArray($sql, 'all');
	}

	function get_employee_list_po()
	{
		$sql = "SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl,
                            tb_m_user us
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID
							
				ORDER BY    empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	function deladd_priv_po($id,$st)
	{
		$this->db->query( " UPDATE 
								tb_m_employee
							SET
								PRIVILEGE_PR ='$st'
							WHERE 
								EMPLOYEE_ID = '$id'");
	}

}