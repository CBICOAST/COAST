<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS001
* Program Name     : Login Screen
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

class M_OAS001 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function check_user($email, $password){
		$this->query = $this->db->select('COUNT(*) user_num')->from('TB_M_USER')->where(array('USER_EMAIL'=>$email,'USER_PASSWORD'=>$password,'USER_STATUS'=>'1'))->limit(1)->get();
		return $this->query->row_array();
	}

	function save_temp_password($employee)
	{
		$ack = 0;
		$sql_reset = "UPDATE
						tb_m_user
					SET		
						TEMPORARY_PASSWORD  =md5('$employee[newReset]')
					WHERE
						USER_EMAIL = '$employee[emailReset]'";
		if($this->db->query($sql_reset))
		{
			$ack = 1;
		}
		//untuk mengirim Password baru ke email
		if($ack == 1){
		
		$tujuan = $employee['emailReset']; //mengambil email RM
        $judul = "Reset Your COAST Password"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
                <p>Dear <b>".$employee['emailReset']."</b>,<br>
                 Someone asked to reset your password recently.<br>
				You Can login using this password 
                <b>".$employee['newReset']." </b> .<br>
                Visit 
                <a href='http://intranet.cybertrend-intra.com/'>COAST</a>
                for Login with Your New Password And Please change your password after login<br>
                If you do not request a new password , please ignore this email<br>
               
                *Do not reply this email. <br><br></p>
                
                </div>";
                
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>".$isi;//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
        $ack ==2;
		}
		return $ack;
	}
	
	function get_user($email, $password){
		$sql = "SELECT 
						*
				FROM
						tb_m_user usr,
						tb_m_employee empl
				WHERE
						usr.USER_EMAIL='$email' AND 
						(usr.USER_PASSWORD= '$password' OR 
						usr.TEMPORARY_PASSWORD = '$password' )AND
						empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
						usr.USER_STATUS = '1'
						";
		return fetchArray($sql, 'row');
	}
}