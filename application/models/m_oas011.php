<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS011
* Program Name     : Create/Edit Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 001				 26-02-2015		   Dwi Irawati			 Penambahan function notifikasi email
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS011 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//function untuk submit 
	function submitLeaveForm($data)
	{
		$ack = 0;

		$year = date("Y");
		$monthly = DATE("m");
		$formID = null;
		$refno = null;

		$month['01'] = 'I';
		$month['02'] = 'II';
		$month['03'] = 'III';
		$month['04'] = 'IV';
		$month['05'] = 'V';
		$month['06'] = 'VI';
		$month['07'] = 'VII';
		$month['08'] = 'VIII';
		$month['09'] = 'IX';
		$month['10'] = 'X';
		$month['11'] = 'XI';
		$month['12'] = 'XII';

		$sql = "INSERT INTO
					tb_r_leave 
					(REF_NO,
					EMPLOYEE_ID,
					LEAVE_TYPE_ID,
					LEAVE_AMOUNT,
					ADDRESS,
					PHONE,
					SUBMITTED_DATE,
					DATE_START,
					DATE_END,
					DATE_BACK,
					CREATED_BY,
					CREATED_DT)
				
				VALUES
					(CONCAT(
					RIGHT(1000+(SELECT COUNT(*) FROM tb_r_leave lv WHERE YEAR(lv.SUBMITTED_DATE) = '$year') +1,3),'/HR-CT/','$month[$monthly]/','$year'),
					'$data[EMPLOYEE_ID]',
					'$data[LEAVE_TYPE_ID]',
					'$data[LEAVE_AMOUNT]',
					'$data[ADDRESS]',
					'$data[PHONE]',
					'$data[SUBMITTED_DATE]',
					'$data[DATE_START]',
					'$data[DATE_END]',
					'$data[DATE_BACK]',
					'user: $data[EMPLOYEE_EMAIL]',
					'".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}

		if($ack == 1){
		//mengambil Form Id
		$formID = $this->getFormId($data['EMPLOYEE_ID'], $data['LEAVE_TYPE_ID'], $data['DATE_START'], $data['DATE_END']);
		$refno = $this->getRefNo($formID);
		
		//Memasukan data ke tabel Form Status
		$sql = "INSERT INTO tb_r_form_status 
					(FORM_TYPE_ID,
					FORM_ID,
					TARGET_EMPLOYEE_ID,
					STATUS,
					CREATED_BY,
					CREATED_DT)
				VALUES
					('1',
					'$formID',
					'$data[EMPLOYEE_RM_ID]',
					'0',
					'user: $data[EMPLOYEE_EMAIL]',
					'".date("Y-m-d H:i:s")."')";
		if($this->db->query($sql))
		{
			$ack = 2;
		}
	}

		if($ack == 2){
		$sql = "INSERT INTO tb_r_notification 
					(RECIPIENT_EMPLOYEE_ID,
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
					('$data[EMPLOYEE_RM_ID]',
					'$data[EMPLOYEE_ID]',
					'0',
					'1',
					'$formID',
					'No. Ref: $refno',
					'1',
					'".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
					'user: $data[EMPLOYEE_EMAIL]',
					'".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
			if($this->db->query($sql))
			{
				$ack = 3;
			}	
		}
		
		//untuk mengirim submit email ke RM
		if($ack == 3){
		
		$tujuan = $data['RM_EMAIL']; //mengambil email RM
        $judul = "Leave Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['RM_NAME']."</b>, <br><br>
                <b>".$data['EMPLOYEE_NAME']." </b> has submitted application for Leave Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Leave Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAS - Leave Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Notification to ".$tujuan." sent successfully<br>";//jika terkirim
        }else{
            echo "<br>Notification to ".$tujuan." send failed<br>";//jika tidak terkirim
        }
        $ack ==4;
		}
		
	}

	function updateLeaveForm($data)
	{
		$ack = 0;

		$sql = "UPDATE
						tb_r_leave lv
				SET
						lv.LEAVE_AMOUNT		= '$data[LEAVE_AMOUNT]',
						lv.ADDRESS 			= '$data[ADDRESS]',
						lv.PHONE 			= '$data[PHONE]',
						lv.SUBMITTED_DATE 	= '$data[SUBMITTED_DATE]',
						lv.DATE_START 		= '$data[DATE_START]',
						lv.DATE_END 		= '$data[DATE_END]',
						lv.DATE_BACK 		= '$data[DATE_BACK]',
						lv.UPDATED_BY 		= 'user: $data[this_email]',
						lv.UPDATED_DT 		= '".date("Y-m-d H:i:s")."'
				WHERE
						lv.LEAVE_ID = '$data[LEAVE_ID]' ";

		// return $sql;
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		//untuk mengirim submit email ke RM
		if($ack == 1){
		
		$tujuan = $data['RM_EMAIL']; //mengambil email RM
        $judul = "Leave Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
                <p>Dear <b>".$data['RM_NAME']."</b>, <br><br>
                <b>".$data['EMPLOYEE_NAME']." </b> have to revise application for Leave Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Leave Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAS - Leave Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Notification to ".$tujuan." sent successfully<br>";//jika terkirim
        }else{
            echo "<br>Notification to ".$tujuan." send failed<br>";//jika tidak terkirim
        }
        $ack ==2;
		}
	}
	
	//function mengambil Form Id
	function getFormId( $employeId, $leaveType, $start, $end)
	{
		$sql = "SELECT
						lv.LEAVE_ID
				FROM
						tb_r_leave lv
				WHERE
						lv.EMPLOYEE_ID = '$employeId' AND
						lv.LEAVE_TYPE_ID = '$leaveType' AND
						lv.DATE_START = '$start' AND
						lv.DATE_END = '$end'  ";
		return fetchArray($sql, 'one');
	}
	
	//function mengambil no ref dari form id
	function getRefNo( $formid)
	{
		$sql = "SELECT
						lv.REF_NO
				FROM
						tb_r_leave lv
				WHERE
						lv.LEAVE_ID = '$formid'  ";
		return fetchArray($sql, 'one');
	}
	
	//function mendapatkan tipe form
	function getFormType($formTypeId)
	{
		$sql = "SELECT 
						lt.LEAVE_TYPE_ID id,
						lt.LEAVE_TYPE_NAME leave_name,
						lt.LEAVE_LENGTH_MAX length,
						lt.LEAVE_SUBMISSION_MIN minimum_day
				FROM 
						tb_m_leave_type lt
				WHERE
						lt.LEAVE_TYPE_ID = '$formTypeId' ";
		return fetchArray($sql, 'row');
	}
	
	//mengambil hari libur antara tgl mulai dan tgl akhir cuti
	function get_holiday_list($dt_start, $dt_end){
		$sql = "SELECT 
						tl.TANGGAL,
						tl.KETERANGAN
				FROM 
						tb_m_tanggal_libur tl
				WHERE 
						tl.TANGGAL between '$dt_start' and '$dt_end'
						";
		return fetchArray($sql, 'all');
	}
	
	//cek libur 
	function checkHoliday($day, $month, $year)
	{
		$sql = "SELECT 
						tl.TANGGAL,
						tl.KETERANGAN
				FROM 
						tb_m_tanggal_libur tl
				WHERE 
						MONTH(tl.TANGGAL) = '$month' AND
  						DAY(tl.TANGGAL) = '$day' AND
  						YEAR(tl.TANGGAL) = '$year'
						";
		return fetchArray($sql, 'all', 'num_total');
	}
	
	//mendapatkan detail info cuti
	function getFormInfo($formId)
	{
		$sql = "SELECT
						lv.LEAVE_ID leave_id,
						lv.REF_NO ref_no,
						lv.EMPLOYEE_ID employee_id,
                        fs.TARGET_EMPLOYEE_ID rmid,
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  rmname,
                        (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  rmemail,
						empl.EMPLOYEE_NAME employee_name,
						usr.USER_EMAIL employee_email,
						lv.LEAVE_TYPE_ID leave_type,
						lv.LEAVE_AMOUNT amount,
						lv.ADDRESS address,
						lv.PHONE phone,
						lv.DATE_START start_dt,
						lv.DATE_END end_dt,
						lv.DATE_BACK comeback,
						lt.LEAVE_TYPE_ID id,
						lt.LEAVE_TYPE_NAME leave_name,
						lt.LEAVE_LENGTH_MAX length,
						lt.LEAVE_SUBMISSION_MIN minimum_day

				FROM
						tb_r_leave lv,
                        tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_leave_type lt,
						tb_m_user usr
				WHERE
						lv.LEAVE_ID = '$formId' AND 
						lv.LEAVE_ID  = FORM_ID AND
						lv.EMPLOYEE_ID = empl.EMPLOYEE_ID AND 
						lt.LEAVE_TYPE_ID = lv.LEAVE_TYPE_ID AND
						lv.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
                        fs.FORM_TYPE_ID = '1'";
		return fetchArray($sql, 'row');
	}
}