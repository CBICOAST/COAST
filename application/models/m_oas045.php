<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS045
* Program Name     : List Business Travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS045 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	 
 function get_list($data)
	{
		$sql = "SELECT
						bt.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id1,
						empl.GROUP_ID employee_group,
						(select pos.EMPLOYEE_ID from tb_m_employee pos where pos.EMPLOYEE_ID = bt.EMPLOYEE_ID ) employee_id,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    bt.BT_ID bt_id,
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = bt.EMPLOYEE_ID) created,
                        bt.CLIENT_NAME client_name,
                        bt.BUSINESS_PURPOSE bt_purpose, 
						bt.CUSTOMER_LOCATION location,
                        bt.CHARGE_CODE chargecode,
                         bt.DEPARTURE departure, 
						bt.RETURN_DATE return_dt,
                        bt.CHARGE_CODE chargecode,
                         bt.DURATION duration,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						bt.CREATED_DT submitted_dt,
                         bt.AMOUNTDIM amount_dim,
                        bt.TRANSPORTAMOUNT amount_ca,
                        bt.TOTAL_AMOUNT_TRANSPORTATION amount_transport,
                        bt.TOTAL_AMOUNT_ACOMODATION amount_hotel,
					    bt.TRANSPORTATION_BY type_id,
					    cost.COST_ID ca_type,
                        cost.COST category_id,
						bt.DESTINATION destination,
						bt.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
						bt.REMARK remarks,
					    sys.VALUE status,
						fs.TARGET_EMPLOYEE_ID aprove,
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
						tb_r_bt bt,
					    tb_m_ca_cost cost,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE";
		if($data['employeeGroup'] >= '2'){
			$sql .= "   (fs.TARGET_EMPLOYEE_ID = '$data[this_id]' OR fs.DIR_APPROVE = '$data[this_id]' OR fs.FINAL_APPROVE = '$data[this_id]' OR bt.TRAVELLER_ID ='$data[this_id]' OR bt.EMPLOYEE_ID ='$data[this_id]' ) AND";	
					   }
		
		$sql .= "
						bt.CHARGE_CODE = cc.CHARGE_CODE AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cost.COST_ID = bt.DESTINATION AND
					    sys.SYS_CAT = '21' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'
						
						order by bt.BT_ID DESC";	
		return fetchArray($sql, 'all');
	}

function get_search_list($employeeID, $searchparam)
	{
		$sql = "SELECT
						bt.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id1,
						empl.GROUP_ID employee_group,
						(select pos.EMPLOYEE_ID from tb_m_employee pos where pos.EMPLOYEE_ID = bt.EMPLOYEE_ID ) employee_id,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    bt.BT_ID bt_id,
                        bt.CLIENT_NAME client_name,
                        bt.BUSINESS_PURPOSE bt_purpose, 
						bt.CUSTOMER_LOCATION location,
                        bt.CHARGE_CODE chargecode,
                         bt.DEPARTURE departure,
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = bt.EMPLOYEE_ID) created,
						bt.RETURN_DATE return_dt,
                        bt.CHARGE_CODE chargecode,
                         bt.DURATION duration,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						bt.CREATED_DT submitted_dt,
                         bt.AMOUNTDIM amount_dim,
                        bt.TRANSPORTAMOUNT amount_ca,
                        bt.TOTAL_AMOUNT_TRANSPORTATION amount_transport,
                        bt.TOTAL_AMOUNT_ACOMODATION amount_hotel, 
						bt.TOTAL_AMOUNT_BT amount,
					    bt.TRANSPORTATION_BY transport_id,
					    cost.COST_ID ca_type,
                        cost.COST category_id,
						bt.DESTINATION destination,
						bt.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
						bt.REMARK remarks,
					    sys.VALUE status,
						fs.TARGET_EMPLOYEE_ID aprove,
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
						tb_r_bt bt,
					    tb_m_ca_cost cost,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						bt.CHARGE_CODE = cc.CHARGE_CODE AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cost.COST_ID = bt.DESTINATION AND
					    sys.SYS_CAT = '21' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'";
		
		
		if($employeeID != '' && $searchparam['employeeGroup'] >= '2'){
			$sql .= " AND  (fs.TARGET_EMPLOYEE_ID = '$employeeID' OR fs.DIR_APPROVE = '$employeeID' OR fs.FINAL_APPROVE = '$employeeID' OR bt.TRAVELLER_ID ='$employeeID' OR bt.EMPLOYEE_ID ='$employeeID' ) ";	
					   }
					   
		if($searchparam['employeeid'] != ''){
			$sql .=	" AND  bt.TRAVELLER_ID = '$searchparam[employeeid]' ";
		}
		if($searchparam['employeename'] != ''){
			$sql .=	" AND  bt.TRAVELLER_ID = '$searchparam[employeename]' ";
		}
		if($searchparam['destination'] != ''){
			$sql .=	" AND  bt.DESTINATION = '$searchparam[destination]' ";
		}
		if($searchparam['chargecodetype_id'] != ''){
			$sql .=	" AND  cc.TYPE = '$searchparam[chargecodetype_id]' ";
		}
		if($searchparam['chargecode_id'] != ''){
			$sql .=	" AND  bt.CHARGE_CODE = '$searchparam[chargecode_id]' ";
		}
		if($searchparam['group_id'] != ''){
			$sql .=	" AND  empl.GROUP_ID = '$searchparam[group_id]' ";
		}
		if($searchparam['division_id'] != ''){
			$sql .=	" AND  empl.DIVISION_ID = '$searchparam[division_id]' ";
		}
		if($searchparam['bt_status'] != '-1'){
			$sql .=	" AND  fs.STATUS = '$searchparam[bt_status]' ";
		}
		
		if($searchparam['year'] != ''){
			$sql .=	" AND  YEAR(bt.CREATED_DT) = '$searchparam[year]' ";
		}
		if($searchparam['month'] != ''){
			$sql .=	" AND   MONTH(bt.CREATED_DT) = '$searchparam[month]' ";
		}
		if($searchparam['transport_id'] != ''){
			$sql .=	" AND   bt.TRANSPORTATION_BY = '$searchparam[transport_id]' ";
		}
		return fetchArray($sql, 'all');
	}	

	
	function get_search_settle_list()
	{
		$sql = " SELECT
					ca.REF_NO ref,
                    setl.amount used,
					setl.RECEIPT_DATE tgl_bukti,
					setl.REMAINING sisa,
					(SELECT sys.VALUE  from tb_r_settlement setl, tb_m_system sys
						WHERE   sys.SYS_CAT = 17 AND sys.SYS_CD = setl.PAYMENT_METHOD 
						and setl.CA_ID = '$form_id') setl_pay_method,
					setl.CREATED_DT tgl_bwt,
					setl.REMARKS remark,
					(select fs.REMARKS from  tb_r_form_status fs, tb_r_settlement setl
					where setl.CA_ID = fs.FORM_ID AND fs.FORM_TYPE_ID = '6') remarks_accept,
					(select sys.VALUE from  tb_r_form_status fs, tb_r_settlement setl,tb_m_system sys
					where setl.CA_ID = fs.FORM_ID AND fs.FORM_TYPE_ID = '6' and sys.SYS_CAT = 18 AND sys.SYS_CD = fs.STATUS) set_status
				FROM 
					tb_r_settlement setl,
					tb_r_ca ca
				WHERE 
					ca.CA_ID = setl.CA_ID ";
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
	function get_bt_destination_list(){	
		$sql = "SELECT
					COST_ID id,
					DESTINATION destination,
					COST cost
				FROM
					tb_m_ca_cost";
		return fetchArray($sql, 'all');
	}
	
	function get_bt_transportation_list(){	
		$sql = "SELECT
					SYS_CD id,
					VALUE transportation
				FROM
					tb_m_system
				where SYS_CAT = 20 ";
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
							tb_m_employee empl,
							tb_m_user usr
				WHERE 
							empl.EMPLOYEE_ID = usr.EMPLOYEE_ID
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	
	function paid_selected()
	{
	$loop = $this->input->post('loop');

	$empid    = $this->user['id'];
	$email = $this->user['email'];
	$name = $this->user['name'];
	$judul = "Business Travel";
		for($a=1;$a<=$loop;$a++){
			$checkbox = $this->input->post('checkbox'.$a);
			 $recipient= $this->input->post('PBT-emp-id'.$a);
			 $refno= $this->input->post('PBT-no-ref'.$a);
			 $email_recipient= $this->input->post('PBT-emp-email'.$a);
			 $name_recipient= $this->input->post('PBT-emp-name'.$a);
			 $akun    = $this->input->post('akun'.$a);
			
			if(empty($checkbox)){
				
			}else{
	
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='9',
						UPDATED_DT 		= '".date("Y-m-d H:i:s")."'
				WHERE
						FORM_TYPE_ID = '3' AND
						FORM_ID ='" . $checkbox . "'";
		$sqlca ="UPDATE 
						tb_r_ca ca,
						tb_r_bt bt,
						tb_r_form_status fs
					SET 
						fs.FINAL_APPROVE ='".$akun."',
						fs.STATUS='9',
						fs.UPDATED_DT 		= '".date("Y-m-d H:i:s")."'
				WHERE
						bt.BT_ID =ca.BT_ID AND						
						fs.FORM_TYPE_ID = '2' AND
						ca.CA_ID = fs.FORM_ID AND
						fs.STATUS='3' AND
						ca.BT_ID ='" . $checkbox . "'";
						
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
						'3',
						'" . $checkbox . "',
						'No. Ref: ".$refno."',
						'1',
						'".date("Y-m-d H:i:s")."',
						'user:".$email."',
						'".date("Y-m-d H:i:s")."')";
						$this->db->trans_start();
			$this->db->query($sql);
			$this->db->query($sqlca);
			$this->db->query($sql_notif);	
		$this->db->trans_complete();
		
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$name_recipient."</b>, <br><br>
                <b>".$name." </b> done payment settlement your application for Business Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAS for Detail Business Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAS - Business Travel \r\n";
        
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