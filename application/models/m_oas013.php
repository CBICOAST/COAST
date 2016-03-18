<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS012
* Program Name     : Pembatalan Cuti Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : M Fadhel K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 13:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS013 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_form_detail($form_id)
	{
		$sql = "SELECT 
						lv.REF_NO no_ref,
						 fs.TARGET_EMPLOYEE_ID rmid,
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  rmname,
                        (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  rmemail,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
					    usr.USER_EMAIL employee_email,
					    lt.LEAVE_TYPE_ID id,
					    lt.LEAVE_TYPE_NAME leave_type,
						lt.LEAVE_LENGTH_MAX length,
						lt.LEAVE_SUBMISSION_MIN minimum_day,
					    lv.DATE_START start_date,
					    lv.DATE_END end_date,
					    lv.DATE_BACK back_date,
					    lv.LEAVE_AMOUNT amount,
					    lv.ADDRESS address,
					    lv.PHONE phone,
					    sys.VALUE status,
					    fs.STATUS status_id,
					    lv.LEAVE_ID leave_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_leave lv,
					    tb_m_user usr,
					    tb_m_leave_type lt,
					    tb_m_system sys
				WHERE
					    lv.LEAVE_ID = '$form_id' AND
					    lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    lv.LEAVE_TYPE_ID = lt.LEAVE_TYPE_ID AND
					    sys.SYS_CAT = '3' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = lv.LEAVE_ID AND
					    fs.FORM_TYPE_ID = '1' ";	
		return fetchArray($sql, 'row');
	}
	function save_confirmation($status)
	{
			
		$ack = 0;
		$sql = "UPDATE 
					tb_r_form_status 
				SET 
					STATUS='$status[STATUS]'
				WHERE 
					FORM_TYPE_ID = '1'AND
					FORM_ID ='$status[FORM_ID]'";

		if($this->db->query($sql))
		{
			$ack = 1;
		}

		if($ack == 1)
		{
			$sql = "UPDATE 
						tb_r_notification
					SET 
						ACTIVITY_TYPE_ID = '$status[STATUS]',
						NOTIFICATION_STATUS_ID = '1',
						NOTIFICATION_TIME = '".date("Y-m-d H:i:s")."',
						UPDATED_BY = 'user: $status[this_email]',
						UPDATED_DT = '".date("Y-m-d H:i:s")."'
					WHERE 
						FORM_TYPE_ID = '1' AND
						FORM_ID = '$status[FORM_ID]' AND
						SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
						RECIPIENT_EMPLOYEE_ID = '$status[USER]' AND
						ACTIVITY_TYPE_ID = '0' ";

			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		
		if($ack == 2)
		{
		$tujuan = $status['RM_EMAIL']; //mengambil email RM
        $judul = "Leave Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['RM_NAME']."</b>, <br><br>
                <b>".$status['EMPLOYEE_NAME']." </b> has cenceled an application for Leave Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Leave Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAS - Leave Request \r\n";
        $headers .= "Cc: aditya.kurniawan@cybertrend-intra.com \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Notification to ".$tujuan." sent successfully<br>";//jika terkirim
        }else{
            echo "<br>Notification to ".$tujuan." send failed<br>";//jika tidak terkirim
        }
			
				$ack = 3;
			}
		

		if($ack == 3 && $status['leave_type_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_annual_leave_trx
					SET 
						BALANCE = (BALANCE + $status[AMOUNT])
					WHERE 
						EMPLOYEE_ID = '$status[REQUESTER]'AND
						YEAR ='$status[this_year]' ";

			if($this->db->query($sql))
			{
				$ack = 4;
			}
		}
		
	} 
}