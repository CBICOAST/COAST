<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS056
* Program Name     : Paid  Cash Advance Selected
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 25-11-2014 10:20:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS056 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	//menampilkan list cash advance yang statusnya accept
	 function get_list()
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						DATE_FORMAT(ca.CREATED_DT,'%d %b %Y at %T') submitted_dt, 
						ca.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
						DATE_FORMAT(fs.CREATED_DT,'%d %b %Y %T') approverm_dt,
					    fs.CREATED_BY approverm_by,
						DATE_FORMAT(fs.APPROVEDIR_DT,'%d %b %Y %T') approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						DATE_FORMAT(fs.UPDATED_DT,'%d %b %Y %T') accepted_dt,
						fs.UPDATED_BY accepted_by,
					    fs.STATUS status_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca ca,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
					    ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '18' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = ca.CA_ID AND
					    fs.FORM_TYPE_ID = '2' AND
                        fs.STATUS = '3'";	
		return fetchArray($sql, 'all');
	}
	
	//menampilkan penvcarian
function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						DATE_FORMAT(ca.CREATED_DT,'%d %b %Y at %T') submitted_dt, 
						ca.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
						DATE_FORMAT(fs.CREATED_DT,'%d %b %Y %T') approverm_dt,
					    fs.CREATED_BY approverm_by,
						DATE_FORMAT(fs.APPROVEDIR_DT,'%d %b %Y %T') approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						DATE_FORMAT(fs.UPDATED_DT,'%d %b %Y %T') accepted_dt,
						fs.UPDATED_BY accepted_by,
					    fs.STATUS status_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca ca,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
					    ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '18' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = ca.CA_ID AND
					    fs.FORM_TYPE_ID = '2' AND
                        fs.STATUS = '3'";
		
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  ca.EMPLOYEE_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['ca_type'] != ''){
			$sql .=	" AND  ca.CA_TYPE_ID = '$searchparam[ca_type]' ";
		}
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  ca.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(ca.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(ca.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['PCA_currency'] != ''){
			$sql .=	" AND   ca.CURRENCY = '$searchparam[PCA_currency]' ";
		}
		return fetchArray($sql, 'all');
	}
	//menampilkan list group
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
	//menampilkan list devisi
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
	// ambil daftar tipe CA
	function get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type";
		return fetchArray($sql, 'all');
	}
	//menampilkan list tipe chargecode
	function get_chargecodetype_list()
	{
		$sql = " SELECT
							pos.SYS_CD id,
							pos.VALUE name
							
							
				FROM
							tb_m_system pos 
				WHERE
							pos.SYS_CAT = '11' ";
		return fetchArray($sql, 'all');
	}
	//menampilkan chargecode berdasarkan tipe
	function get_chargecode_list($chargecodetype_id = '')
	{
		$sql = " SELECT
							pos.CHARGE_CODE id,
							pos.PROJECT_DESCRIPTION name
							
							
				FROM
							tb_m_charge_code pos 
				WHERE
							pos.STATUS = '1'";

		if($chargecodetype_id !=''){
			$sql .= "AND pos.TYPE = '$chargecodetype_id' ";	
		}
		return fetchArray($sql, 'all');
	}
	//menampilkan list employee
	function get_employee_list()
	{
		$sql = "SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
				FROM
							tb_m_employee empl,
							tb_m_user us
				WHERE
							us.EMPLOYEE_ID = empl.EMPLOYEE_ID
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	//function buat paid selected
	function paid_selected()
	{
	$loop = $this->input->post('loop');
	$empid    = $this->user['id'];
	$email = $this->user['email'];
	$name = $this->user['name'];
	$judul = "Cash Advance";
		for($a=1;$a<=$loop;$a++){
			$checkbox = $this->input->post('checkbox'.$a);
			 $recipient= $this->input->post('PCA-emp-id'.$a);
			 $refno= $this->input->post('PCA-no-ref'.$a);
			 $name_recipient= $this->input->post('PCA-emp-name'.$a);
			 $email_recipient= $this->input->post('PCA-emp-email'.$a);
			
			if(empty($checkbox)){
				
			}else{
		//update status form jadi 9
		$sql ="UPDATE 
						tb_r_form_status 
					SET 
						STATUS='9',
						UPDATED_BY 		= '".$name."',
						UPDATED_DT 		=  '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE
						FORM_TYPE_ID = '2' AND
						FORM_ID ='" . $checkbox . "'";
		//mengirim notifikasi edit
		$sql_notif="INSERT INTO
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
						        '2',
						        '" . $checkbox . "',
						        'No. Ref: ".$refno."',
						        '1',
						        '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						        'user:".$email."',
					         	'".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
		
		$this->db->trans_start();
			$this->db->query($sql);
			$this->db->query($sql_notif);	
		$this->db->trans_complete();
		
		
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$name_recipient."</b>, <br><br>
                <b>".$name." </b> done payment your application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COASTT for Detail Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COASTT - Cash Advance \r\n";
        
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