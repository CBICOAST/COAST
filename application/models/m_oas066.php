<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS066
* Program Name     : Paid Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 26-11-2014 10:52:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS066 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	 function get_list()
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
						lv.ID_SETTLEMENT settlement_id,
						lv.FORM_ID ca_id_settle,
						lv.RECEIPT_DATE rd,
						ca.CURRENCY currency,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
						ca.AMOUNT diberikan,
						lv.AMOUNT terpakai,
						lv.REMAINING sisa,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
						lv.AMOUNT terpakai,
						lv.REMAINING sisa,
					    ca.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
						fs.CREATED_DT approverm_dt,
					    fs.CREATED_BY approverm_by,
						fs.APPROVEDIR_DT approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						fs.UPDATED_DT accepted_dt,
						fs.UPDATED_BY accepted_by,
					    fs.STATUS status_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca ca,
						tb_r_settlement lv,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
                      ca.CA_ID = lv.FORM_ID AND
					   ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					   empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					   ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					   sys.SYS_CAT = '18' AND
					   fs.FORM_ID = ca.CA_ID AND
				       usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					   sys.SYS_CD = fs.STATUS AND
					   fs.FORM_ID = ca.CA_ID AND
					   fs.FORM_TYPE_ID = '2'  AND
					   lv.REMAINING !='0' AND
					   fs.STATUS = '11'";	
		return fetchArray($sql, 'all');
	}
function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
						lv.ID_SETTLEMENT settlement_id,
						lv.FORM_ID ca_id_settle,
						lv.RECEIPT_DATE rd,
						ca.CURRENCY currency,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
						ca.AMOUNT diberikan,
						lv.AMOUNT terpakai,
						lv.REMAINING sisa,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
						lv.AMOUNT terpakai,
						lv.REMAINING sisa,
					    ca.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
						fs.CREATED_DT approverm_dt,
					    fs.CREATED_BY approverm_by,
						fs.APPROVEDIR_DT approvedir_dt,
						fs.APPROVEDIR_BY approvedir_dy,
						fs.UPDATED_DT accepted_dt,
						fs.UPDATED_BY accepted_by,
					    fs.STATUS status_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca ca,
						tb_r_settlement lv,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
                      ca.CA_ID = lv.FORM_ID AND
					   ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					   empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					   ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					   sys.SYS_CAT = '18' AND
					   fs.FORM_ID = ca.CA_ID AND
				       usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					   sys.SYS_CD = fs.STATUS AND
					   fs.FORM_ID = ca.CA_ID AND
					   fs.FORM_TYPE_ID = '2'  AND
					   lv.REMAINING !='0' AND
					   fs.STATUS = '11'";
		
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
		if($searchparam['open'] != ''){
			$sql .=	" AND  ca.STATUS = '$searchparam[open]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(ca.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(ca.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['PST_currency'] != ''){
			$sql .=	" AND   ca.CURRENCY = '$searchparam[PST_currency]' ";
		}
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
	$judul = "Settlement Cash Advance";
		for($a=1;$a<=$loop;$a++){
			$checkbox = $this->input->post('checkbox'.$a);
			 $recipient= $this->input->post('PST-emp-id'.$a);
			 $refno= $this->input->post('PST-no-ref'.$a);
			 $email_recipient= $this->input->post('PST-emp-email'.$a);
			 $name_recipient= $this->input->post('PST-emp-name'.$a);
			if(empty($checkbox)){
				
			}else{
	
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='12'
				WHERE
						FORM_TYPE_ID = '2' AND
						FORM_ID ='" . $checkbox . "'";
		$sql_close = " UPDATE 
							tb_r_ca 
						SET 
							STATUS='2',
							UPDATED_BY		= '".$name."',
							UPDATED_DT 		= '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						WHERE
							CA_ID ='" . $checkbox . "'";
		$sql_balance = " UPDATE 
							tb_r_settlement 
						SET 
							REMAINING		= '0'
						WHERE
							FORM_ID ='" . $checkbox . "'";
						
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
						'2',
						'" . $checkbox . "',
						'No. Ref: ".$refno."',
						'1',
						'".date("Y-m-d H:i:s")."',
						'user:".$email."',
						'".date("Y-m-d H:i:s")."')";
								 
								 
								 					
		$this->db->trans_start();
			$this->db->query($sql);
			$this->db->query($sql_close);	
			$this->db->query($sql_balance);
			$this->db->query($sql_notif);	
		$this->db->trans_complete();
		
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$name_recipient."</b>, <br><br>
                <b>".$name." </b> done payment settlement your application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";
        
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
	
		function not_paid_selected($caid)
	{
		$this->db->query( " UPDATE	
						tb_r_form_status
				SET STATUS = '13'
				WHERE
							FORM_ID = '$caid' AND
							FORM_TYPE_ID = '2'");
	}
	 
}