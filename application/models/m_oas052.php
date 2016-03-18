 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS052
* Program Name     : Form Approval Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 18-11-2014 07:36:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS052 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_form_detail($form_id)
	{
		$sql = "SELECT 
			rc.REF_NO no_ref,
			empl.EMPLOYEE_NAME employee_name,
			empl.EMPLOYEE_ID employee_id,
			usr.USER_EMAIL employee_email,	
            lv.ID_SETTLEMENT settlement_id,
            empl.EMPLOYEE_NAME employee_name,
            lv.FORM_ID ca_id,
            DATE_FORMAT(lv.RECEIPT_DATE,'%d %b %Y') rd,
            DATE_FORMAT(lv.CREATED_DT,'%d %b %Y %T') submitted_dettle_dt,
			rc.CURRENCY currency,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = rc.CURRENCY )  currency_name,
            rc.AMOUNT diberikan,
            lv.AMOUNT terpakai,
            lv.REMAINING sisa,
            rc.CA_TYPE_ID type,
            ct.CA_TYPE ca_type,
            rc.CHARGE_CODE chargecode,
            (select pos.VALUE from tb_m_system pos, tb_m_charge_code cc  
            where pos.SYS_CAT= '11' and cc.CHARGE_CODE = rc.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_type,
            (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  
            where pos.SYS_CAT= '11' and cc.CHARGE_CODE = rc.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
			lv.PAYMENT_METHOD pay_method,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = lv.PAYMENT_METHOD )  pay_method_name,
            rc.STATUS form_status,
            (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = rc.STATUS )  form_status_name,
            lv.REMARKS remarks,
			(SELECT IFNULL((select co.DESTINATION from tb_r_ca ca,tb_m_ca_cost co
				where ca.CA_ID = '$form_id' AND ca.DESTINATION = co.COST_ID),'-') AS destination)  destination
			
		FROM 
            tb_r_ca rc,
			tb_r_settlement lv,
            tb_m_ca_type ct,
            tb_m_user usr,
            tb_m_employee empl        
        WHERE
			rc.CA_ID = lv.FORM_ID AND
			empl.EMPLOYEE_ID = rc.EMPLOYEE_ID AND
			rc.CA_TYPE_ID = ct.CA_TYPE_ID AND
			empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
			rc.CA_ID = '$form_id'";	
		return fetchArray($sql, 'row');
	}
	
	
	function save_confirmation($data)
	{
	if($data['STATUS']=='11'){
		// Update status settlement di approve apa reject
		$sql1 = "UPDATE
							tb_r_settlement
				SET 
							STATUS = '$data[STATUS]',
							REMARKS_ACCEPTED = '$data[REMARKS]',
							ACCEPTED_BY = '$data[this_name]',
							ACCEPTED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
				WHERE	
							FORM_ID = '$data[FORM_ID]' AND
							FORM_TYPE_ID = '2'";
		// Update status settlement di approve apa reject
		$sql2 = "UPDATE
							tb_r_form_status
				SET 
							STATUS = '$data[STATUS]',
							UPDATED_BY = '$data[this_name]'
				WHERE	
							FORM_ID = '$data[FORM_ID]' AND
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
								('$data[REQUESTER]',
								 '$data[SENDER_ID]',
								 ('8'),
						         '2',
						         '$data[FORM_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         'user: $data[this_email]',
					         	 '".date("Y-m-d H:i:s")."')";	
		
		
		// Setelah dikonfirmasi, formnya close
		$sql4 = "UPDATE
							tb_r_ca
				SET 
							STATUS = '$data[openclose]'
				WHERE	
							CA_ID = '$data[FORM_ID]'";
											 
		$this->db->trans_start();
			$this->db->query($sql1);
			$this->db->query($sql2);
			$this->db->query($sql3);
			$this->db->query($sql4);
		$tujuan = $data['REQ_EMAIL']; 
		$judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['REQ_NAME']."</b>, <br><br>
                 ".$data['this_name']." <b> " .$data['status_name']."</b> your application for Settlement of Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Cash Advance</a><br><br>
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
        }$this->db->trans_complete();}else{
		// Update status settlement di approve apa reject
		$sql2 = "UPDATE
							tb_r_form_status
				SET 
							STATUS = '$data[STATUS]',
							UPDATED_BY = '$data[this_name]'
				WHERE	
							FORM_ID = '$data[FORM_ID]' AND
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
								('$data[REQUESTER]',
								 '$data[SENDER_ID]',
								 '11',
						         '2',
						         '$data[FORM_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         'user: $data[this_email]',
					         	 '".date("Y-m-d H:i:s")."')";	
		
		$this->db->trans_start();
			
			$this->db->query($sql2);
			$this->db->query($sql3);
			$tujuan = $data['REQ_EMAIL']; 
		$judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['REQ_NAME']."</b>, <br><br>
                 ".$data['this_name']." <b> " .$data['status_name']."</b> your application for Settlement of Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Cash Advance</a><br><br>
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
		$this->db->trans_complete();}
			} 
}
