<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS034
* Program Name     : Paid Selected
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 31-10-2014 10:20:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS034 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	 function get_list($data)
	{
		$sql = "SELECT 
						cl.REF_NO no_ref,
						cl.CLAIM_ID claim_id,
					    cl.TOTAL total,
						cl.CLAIM_TYPE_ID type_id,
					    sys.VALUE status,
						cl.SUBMITTED_DATE submitted_dt,
						cl.TANGGAL_KWITANSI tgl_kwitansi,
						fcl.CREATED_DT accepted_dt,
                        fcl.CREATED_BY accepted_by,
					    fs.STATUS status_id,
						cl.EMPLOYEE_ID employee_id,
					    cl.TANGGAL_KWITANSI kwitansi_date,
						cl.CHARGE_CODE charge_code,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    lt.EXPENSE_TYPE_NAME claim_type,
						lt.CLAIM_CATEGORY category,
						fs.TARGET_EMPLOYEE_ID approval,
                        fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_form_confirmation_list fcl,
						tb_r_claim cl,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys	
				WHERE
                        fs.FORM_TYPE_ID = '5' AND
                       ((fs.STATUS = '11' && lt.CLAIM_CATEGORY ='1') OR (fs.STATUS = '9' && cl.CLAIM_TYPE_ID !='4') or (fs.STATUS ='10' && cl.CLAIM_TYPE_ID ='4')) AND
					    cl.CLAIM_ID = fs.FORM_ID AND
						fcl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						fcl.FORM_ID = cl.CLAIM_ID AND
					    lt.EXPENSE_TYPE_ID = cl.CLAIM_TYPE_ID AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = cl.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' 
				    
				ORDER BY
				    	fs.STATUS asc";	
		return fetchArray($sql, 'all');
	}	
function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT 
						cl.CLAIM_ID claim_id,
					    cl.REF_NO no_ref,
					    cl.TOTAL total,
						cl.CLAIM_TYPE_ID type_id,
					    sys.VALUE status,
						cl.SUBMITTED_DATE submitted_dt,
						cl.TANGGAL_KWITANSI tgl_kwitansi,
						fcl.CREATED_DT accepted_dt,
                        fcl.CREATED_BY accepted_by,
					    fs.STATUS status_id,
						cl.EMPLOYEE_ID employee_id,
					    cl.TANGGAL_KWITANSI kwitansi_date,
						cl.CHARGE_CODE charge_code,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    lt.EXPENSE_TYPE_NAME claim_type,
						lt.CLAIM_CATEGORY category,
						fs.TARGET_EMPLOYEE_ID approval,
                        fs.CREATED_BY approved_by,
                        fs.CREATED_DT approved_dt
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_employee_reporting_manager tbrm,
						tb_r_form_confirmation_list fcl,
						tb_r_claim cl,
					    tb_m_user usr,
					    tb_m_expense_type lt,
					    tb_m_system sys	
				WHERE
                        fs.FORM_TYPE_ID = '5' AND
                        ((fs.STATUS = '11' && lt.CLAIM_CATEGORY ='1') OR(fs.STATUS = '9' && cl.CLAIM_TYPE_ID !='4') or (fs.STATUS ='10' && cl.CLAIM_TYPE_ID ='4')) AND
					    cl.CLAIM_ID = fs.FORM_ID AND
						fcl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
						fcl.FORM_ID = cl.CLAIM_ID AND
					    lt.EXPENSE_TYPE_ID = cl.CLAIM_TYPE_ID AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						tbrm.EMPLOYEE_ID = cl.EMPLOYEE_ID AND
					    fs.STATUS = sys.SYS_CD AND
					    sys.SYS_CAT = '9' 
				  ";
			
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  lv.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  empl.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['claimtype'] != ''){
			$sql .=	" AND  lt.CLAIM_CATEGORY  = '$searchparam[claimtype]' ";
		}
				
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(lv.SUBMITTED_DATE) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND  MONTH(lv.TANGGAL_KWITANSI) = '$searchparam[month]'  ";
		}

		$sql .=	"  
				ORDER BY
				    	fs.STATUS asc ";
		return fetchArray($sql, 'all');
	}

	function get_group_list()
	{
		$sql = " SELECT
							pos.POSITION_ID id,
							pos.POSITION_NAME name
							
							
				FROM
							tb_m_position pos 
				WHERE
							pos.POSITION_DEPTH_ID = '2' ";
		return fetchArray($sql, 'all');
	}

	function get_division_list($group_id = '')
	{
		$sql = " SELECT
							pos.POSITION_ID id,
							pos.POSITION_NAME name
							
							
				FROM
							tb_m_position pos 
				WHERE
							pos.POSITION_DEPTH_ID = '3' ";

		if($group_id !=''){
			$sql .= "AND pos.MANAGER_ID = '$group_id' ";	
		}
		return fetchArray($sql, 'all');
	}

	
	function get_claim_type_list()
	{
		$sql = "  SELECT
							SYS_CD id,
							VALUE name
							
							
				FROM
							tb_m_system
				WHERE
				SYS_CAT = '10' ";
		return fetchArray($sql, 'all');
	}

	function get_employee_list()
	{
		$sql = " SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}

	function paid_selected()
	{
	$loop = $this->input->post('loop');
	$empid    = $this->user['id'];
	$email = $this->user['email'];
	$name = $this->user['name'];
	$judul = "Expense Claim";
		for($a=1;$a<=$loop;$a++){
			$checkbox = $this->input->post('checkbox'.$a);
			$recipient = $this->input->post('PCL-emp-id'.$a);
			$refno = $this->input->post('PCL-no-ref'.$a);
			 $email_recipient= $this->input->post('PCL-emp-email'.$a);
			 $name_recipient= $this->input->post('PCL-no-name'.$a);
			if(empty($checkbox)){
				
			}else{
				$sql = ("UPDATE tb_r_form_status 
						SET STATUS='6',
							UPDATED_DT 		= '".date("Y-m-d H:i:s")."'
						WHERE
							FORM_TYPE_ID = '5' AND
							FORM_ID ='" . $checkbox . "'");
				
				$sql_notif = "INSERT INTO
						tb_r_notification (RECIPIENT_EMPLOYEE_ID,
									SENDER_EMPLOYEE_ID,
									ACTIVITY_TYPE_ID,
									FORM_TYPE_ID,
									FORM_ID,
									NOTIFICATION_INFORMATION,
									NOTIFICATION_STATUS_ID,
									NOTIFICATION_TIME,
									CREATED_BY,
									CREATED_DT)
				VALUES
						('".$recipient."',
						'".$empid."',
						'6',
						'5',
						'" . $checkbox . "',
						'No. Ref: ".$refno."',
						'1',
						'".date("Y-m-d H:i:s")."',
						'user:".$email."',
						'".date("Y-m-d H:i:s")."')";
				$this->db->trans_start();
					$this->db->query($sql);
					$this->db->query($sql_notif);	
				$this->db->trans_complete();
				$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$name_recipient."</b>, <br><br>
                <b>".$name." </b> paid your application for Expense Claim.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Expense Claim</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Expense Claim \r\n";
        
        //send email
        if(mail($email_recipient,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$email_recipient." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$email_recipient." failed<br>";//jika tidak terkirim
        }
			}
								 
		}	
		return true;
	}
	 
}