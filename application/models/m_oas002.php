<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS002
* Program Name     : Main Frame
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS002 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_menu_list($data)
	{
		$sql = " SELECT
							(SELECT
							PRIVILEGE_CA
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') privi_ca,
							(SELECT
							
							PRIVILEGE_PR
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') privi_pr,
							
							(SELECT
						POSITION_DEPTH_ID
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') posdeph,
							(SELECT
						
                         GROUP_ID
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') group_id,
							(SELECT
                         DIVISION_ID
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') div_id,
							(SELECT
                         USER_GROUP_ID
				FROM
							tb_m_employee empl,
							tb_m_user usr
							
				WHERE
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
							usr.EMPLOYEE_ID = '$data[this_id]') adminid,
							
				(CASE menu.MENU_ID WHEN '3010' THEN 
			              (SELECT count(ts.APPROVED_BY) FROM tb_r_timesheet ts, tb_m_user usr
			              WHERE ts.APPROVED_BY = usr.EMPLOYEE_ID AND 
			              usr.EMPLOYEE_ID = '$data[this_id]' AND ts.STATUS = 2 GROUP BY ts.APPROVED_BY) 
			              ELSE 0 END) ts_approval,
				
				(SELECT 
						mp.EMPLOYEE_ID
				FROM 
						tb_m_employee em,
                        tb_m_user us,
                        tb_m_approval mp
				WHERE
						mp.EMPLOYEE_ID = em.EMPLOYEE_ID AND
                        us.EMPLOYEE_ID = mp.EMPLOYEE_ID AND
						mp.APPROVAL_FOR = '0') superAdmin,
						
				(CASE menu.PRIV_CA WHEN '5' THEN 
              	(SELECT count(ts.APPROVED_BY) FROM tb_r_timesheet ts, tb_m_user usr
              	WHERE ts.APPROVED_BY = usr.EMPLOYEE_ID AND 
              	usr.EMPLOYEE_ID = '$data[this_id]' AND ts.STATUS = 1 GROUP BY ts.APPROVED_BY)
              	ELSE 0 END) count_ts_approval,
              
							menu.*
							
				FROM
							tb_m_menu menu,
							tb_sys_privilege priv
							
				WHERE
							menu.ACTIVE = '1' AND
							menu.MENU_ID = priv.MENU_ID  AND
							priv.USER_GROUP_ID = '$data[this_group]'  AND
							priv.ALLOW = '1'  
							HAVING count_ts_approval IS NOT null
				ORDER BY
							menu.MENU_ORDER, menu.MENU_ID ASC ";
		return fetchArray($sql, 'all');
	}
	
	function get_menu_superAdmin()
	{
		$sql = " select * from tb_m_menu menu
				WHERE menu.MENU_ORDER != '2'
				ORDER BY
							menu.MENU_ORDER ASC ";
		return fetchArray($sql, 'all');
	}
	
}