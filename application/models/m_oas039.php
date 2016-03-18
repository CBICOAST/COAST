<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS039
* Program Name     : Add/Edit Settlement of Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 13-11-2014 15:26:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS039 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	// cek apakah user mempunyai form yg perlu di settlement
	function cek_count_settle($employeeID){	
		$sql = "SELECT 
					COUNT(EMPLOYEE_ID) jumlah,
                ca.REF_NO ref
				FROM
					tb_r_ca ca, tb_r_form_status fs
				WHERE
					ca.EMPLOYEE_ID ='".$employeeID."' AND			
					ca.SETTLEMENT_STATUS = '0' AND             
					((fs.FORM_TYPE_ID = '2' AND
					fs.STATUS = '9' ) OR (fs.FORM_TYPE_ID = '3' AND
					fs.STATUS = '9')) AND
					fs.FORM_ID = ca.CA_ID ";
		return fetchArray($sql, 'one');
	}
	
	// fungsi untuk mengambil detail dari no ref yang dipilih
	function get_detail_noRef($noRef){	
		$sql = " SELECT
					ca.REF_NO no_ref,
					ca.CA_ID id,
					empl.EMPLOYEE_NAME name,
					ca_type.CA_TYPE type_ca,
					cc.CHARGE_CODE charge_code,
					cc.PROJECT_DESCRIPTION description,
					ca.AMOUNT amount,
					sys.VALUE currency
				FROM 
					tb_r_ca ca,	
					tb_m_employee empl,
					tb_m_charge_code cc,
					tb_m_ca_type ca_type,
					tb_m_system sys
				WHERE
					ca.REF_NO = '".$noRef."' AND
					empl.EMPLOYEE_ID = ca.EMPLOYEE_ID AND
					cc.CHARGE_CODE =ca.CHARGE_CODE AND
					ca_type.CA_TYPE_ID = ca.CA_TYPE_ID AND
					sys.SYS_CAT = '16' AND
					sys.SYS_CD = ca.CURRENCY";
		return fetchArray($sql, 'all');
	}
	
	//untuk mengambil tipe charge no referensi yg dipilih
	function get_type_charge_code($noRef){	
		$sql = " SELECT
					sys.VALUE type_cc
				FROM 
					tb_r_ca ca,	
					tb_m_employee empl,
					tb_m_charge_code cc,
					tb_m_ca_type ca_type,
					tb_m_system sys
				WHERE
					ca.REF_NO = '".$noRef."' AND
					empl.EMPLOYEE_ID = ca.EMPLOYEE_ID AND
					cc.CHARGE_CODE =ca.CHARGE_CODE AND
					ca_type.CA_TYPE_ID = ca.CA_TYPE_ID AND
					sys.SYS_CAT = '11' AND
					sys.SYS_CD = cc.TYPE ";
		return fetchArray($sql, 'all');
	}
	
	//untuk mengambil destination no referensi yg dipilih
	function get_destination($noRef){	
		$sql = " SELECT IFNULL((SELECT co.DESTINATION destination
				FROM 
					tb_r_ca ca,	
					tb_m_employee empl,
					tb_m_ca_type ca_type,
                    tb_m_ca_cost co
				WHERE
					ca.REF_NO = '".$noRef."' AND
					empl.EMPLOYEE_ID = ca.EMPLOYEE_ID AND
					ca_type.CA_TYPE_ID = ca.CA_TYPE_ID AND
                    ca.CA_TYPE_ID = 1 AND
                    ca.CA_TYPE_ID = co.COST_ID),'-') as 'destination';";
		return fetchArray($sql, 'all');
	}
	
	//untuk mengambil ref BT no referensi CA yg dipilih
	function get_ref_bt($noRef){	
		$sql = " SELECT IFNULL((SELECT bt.REF_NO ref_bt
				FROM 
					tb_r_ca ca,	
                    tb_r_bt bt,
					tb_m_ca_type ca_type
				WHERE
					ca.REF_NO = '".$noRef."' AND
					ca_type.CA_TYPE_ID = ca.CA_TYPE_ID AND
                    ca.CA_TYPE_ID = 1 AND
                    ca.BT_ID = bt.BT_ID),'-') as 'ref_bt';";
		return fetchArray($sql, 'all');
	}
	
	
	// mengambil no referensi CA yg dimiliki employee yg login
	function cek_no_ref($employeeID){	
		$sql = "SELECT 
					ca.REF_NO no_ref
				FROM
					tb_r_ca ca,
					tb_r_form_status fs,
					tb_r_form_confirmation_list fcl
				WHERE
					ca.EMPLOYEE_ID ='".$employeeID."' AND
					ca.CA_ID = fs.FORM_ID AND
                	fs.STATUS = '9' AND
					ca.STATUS != 2 AND
					fcl.FORM_ID = ca.CA_ID AND
					fcl.STATUS = '1' AND
					ca.SETTLEMENT_STATUS != 1 AND 
					fcl.FORM_TYPE_ID = '2'";
		return fetchArray($sql, 'all');
	}
	
	function submitSetForm($data)
	{
		$ack = 0;
		
		$sql = "INSERT INTO
							tb_r_settlement 
							(FORM_ID,
							FORM_TYPE_ID,
							RECEIPT_DATE,
							AMOUNT,
							REMARKS,
							REMAINING,
							AMOUNT_SETTLEMENT,
							PAYMENT_METHOD,
							CREATED_BY,
							CREATED_DT)
				VALUES
							 ('$data[CA_ID]',
							 '2',
							 '$data[RECEIPT_DATE]',
							 '$data[AMOUNT]',
					         '$data[REMARKS]',
					         '$data[REMAINING]',
					         '$data[REMAINING]',
					         '$data[PAYMENT_METHOD]',
							 '$data[EMPLOYEE_NAME]',
					          '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
		$sql2 = "UPDATE 
							tb_r_ca
				SET
							SETTLEMENT_STATUS = '1'
				WHERE
							CA_ID = '$data[CA_ID]'";
		
		$sql3 = "UPDATE 
							tb_r_form_status
				SET
							STATUS = '10'
				WHERE
							FORM_ID = '$data[CA_ID]' AND
							FORM_TYPE_ID = '2'";
							
		$sql4 = "INSERT INTO
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
								('$data[FINANCE]',
								 '$data[EMPLOYEE_ID]',
								 '7',
						         '2',
						         '$data[CA_ID]',
						         'No. Ref: $data[NO_REF]',
						         '1',
						          '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[EMPLOYEE_EMAIL]',
					         	  '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
							
		$this->db->trans_start();
			$this->db->query($sql2);
			$this->db->query($sql3);	
			$this->db->query($sql4);
			
		if($this->db->query($sql))
		
		$this->db->trans_complete();
$tujuan = $data['FINANCE_EMAIL']; //mengambil email RM
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['FINANCE_NAMA']."</b>, <br><br>
                ".$data['EMPLOYEE_NAME']."<b> Submited settlement </b> for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Settlement Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
	}
	
	// mengambil finance sbg target employee
	function get_finance(){	
		$sql = " SELECT
					empl.EMPLOYEE_ID id
				FROM 
					tb_m_employee empl,
					tb_m_user_group ug,
					tb_m_user usr
				WHERE
					empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					usr.USER_GROUP_ID = ug.USER_GROUP_ID AND
					ug.USER_GROUP_ID = '3'";
		return fetchArray($sql, 'one');
	}
	function get_form_detail($form_id)
	{
		$sql = "		select ca.REF_NO no_ref,
             empl.EMPLOYEE_NAME employee_name,
             empl.EMPLOYEE_ID employee_id,
			usr.USER_EMAIL employee_email,	
            setl.ID_SETTLEMENT settlement_id,
            empl.EMPLOYEE_NAME employee_name,
            setl.FORM_ID ca_id,
            setl.RECEIPT_DATE rd,
            ca.CURRENCY currency,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
            ca.AMOUNT diberikan,
            setl.AMOUNT terpakai,
            setl.REMAINING sisa,
            ca.CA_TYPE_ID type,
            ct.CA_TYPE ca_type,
			(select bt.REF_NO from  tb_r_bt bt where ca.BT_ID = bt.BT_ID  ) ref_bt,
            (select co.DESTINATION from tb_m_ca_cost co where co.COST_ID = ca.DESTINATION)  destination,
            ca.CHARGE_CODE chargecode,
            (select pos.VALUE from tb_m_system pos, tb_m_charge_code cc  
            where pos.SYS_CAT= '11' and cc.CHARGE_CODE = ca.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_type,
            (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  
            where pos.SYS_CAT= '11' and cc.CHARGE_CODE = ca.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
			setl.PAYMENT_METHOD pay_method,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = setl.PAYMENT_METHOD )  pay_method_name,
            ca.STATUS form_status,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
            setl.REMARKS remarks,
			fs.STATUS status_id,
			setl.REMARKS_REVISE remarks_revise
			
			
		FROM 
            tb_r_ca ca,
			tb_r_settlement setl,
            tb_m_ca_type ct,
            tb_m_user usr,
            tb_m_employee empl,
			tb_r_form_status fs
        
        WHERE 
		fs.FORM_ID = ca.CA_ID AND
		fs.FORM_TYPE_ID = '2' AND
		ca.CA_ID = setl.FORM_ID AND
        empl.EMPLOYEE_ID = ca.EMPLOYEE_ID AND
        ca.CA_TYPE_ID = ct.CA_TYPE_ID and
        empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
        ca.CA_ID = '$form_id'			    
			 ";	
		return fetchArray($sql, 'row');
	}
	
	function updateSettleForm($data){
	
	
	
	 $sql1 = "UPDATE
							tb_r_settlement 
				SET 
							RECEIPT_DATE = '$data[RECEIPT_DATE]',
							AMOUNT = '$data[AMOUNT]',
							REMARKS = '$data[REMARKS]',
							REMAINING = '$data[REMAINING]',
							AMOUNT_SETTLEMENT = '$data[REMAINING]',
							PAYMENT_METHOD = '$data[PAYMENT_METHOD]',
							UPDATED_BY = '$data[EMPLOYEE_NAME]',
							UPDATED_DT =  '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
				WHERE	
							FORM_ID = '$data[CA_ID]' ";
		// Update status settlement di approve apa reject
		$sql2 = "UPDATE
							tb_r_form_status
				SET 
							STATUS = '15'
				WHERE	
							FORM_ID = '$data[CA_ID]' AND
							FORM_TYPE_ID = '2'";
		
		// kasih notif ke employee yang submit settlement
		$sql3="INSERT INTO
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
								('$data[FINANCE]',
								 '$data[EMPLOYEE_ID]',
								 '12',
						         '2',
						         '$data[CA_ID]',
						         'No. Ref: $data[NO_REF]',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         'user: $data[this_email]',
					         	 '".date("Y-m-d H:i:s")."')";	
		
		$this->db->trans_start();
			
			$this->db->query($sql1);
			$this->db->query($sql2);
			$this->db->query($sql3);
		$this->db->trans_complete();
		$tujuan = $data['FINANCE_EMAIL']; //mengambil email RM
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['FINANCE_NAMA']."</b>, <br><br>
                ".$data['EMPLOYEE_NAME']." <b> edited settlement </b>for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Settlement Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
		
		}
	
	
}