 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS079
* Program Name     : Form Konfirmasi Purchase Order
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS079 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//memanggil list purchase
	function get_list_tmppr($form_id)
	{
	$sql = "SELECT 	rpr.NO no,
					rpr.QTY qty,
					rpr.SATUAN satuan,
					rpr.NAMA nama,
					rpr.HARGA harga,
					rpr.TOTAL total,
                    po.AMOUNT_PPN ppn,
                    po.AMOUNT_TOTAL subtotal
					
		FROM 	tmp_item_pr rpr,
                 tb_r_po po,
                 tb_r_pr pr, 
                 tb_r_form_status fs,
                 tb_m_employee empl,
                 tb_m_charge_code cc, 
	           	tb_m_user usr,
		        tb_m_system sys
				
		WHERE
		po.PR_ID = '$form_id' AND
        po.PR_ID = pr.PR_ID AND
        pr.PR_ID = rpr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'";
	return fetchArray($sql, 'all');
	}
	
	//Memanggil detail PR
	function get_form_detail($form_id)
	{
		$sql = "SELECT  
		pr.DIBUAT_PO status_po,  
        year(pr.DATE_1PAYMENT) y1,
        year(pr.DATE_2PAYMENT) y2,
        year(pr.DATE_3PAYMENT) y3,
        year(pr.DATE_4PAYMENT) y4,
        po.REF_NO no_ref,
        po.PR_ID po_id,
		pr.REF_NO no_ref_pr,
        pr.PR_ID pr_id,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        pr.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.TYPE cctype,
        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
		fs.PUR_APPROVE pur_approve,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarkspur,
		fs.CREATED_DT approvepur_dt,
		fs.CREATED_BY approvepur_by,
		fs.APPROVEGR_DT approvegr_dt,
		fs.APPROVEGR_BY approvegr_by,
		fs.REMARKS_GR remarksgr,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.APPROVEPUR_DT approvepurchase_dt,
		fs.APPROVEPUR_BY approvepurchase_dy,
		fs.REMARKS_PUR remarkspur,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id,
		(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '26' AND sys.SYS_CD = fs.STATUS) status_name,
		po.CREATED_BY createdbypo,
		po.CREATED_DT createddtpo,
		po.REMARK remarkpo,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,  
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
		pr.REMARK_P1 r1,
        pr.2ND_PAYMENT k2_pay,
		pr.DATE_2PAYMENT tgl2,
		pr.REMARK_P2 r2,
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
		pr.REMARK_P3 r3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4,
		pr.REMARK_P4 r4
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE 
        po.PR_ID = '$form_id' AND
		po.PR_ID = pr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'
ORDER BY 
         po.PR_ID desc";	
		return fetchArray($sql, 'row');
	}
		
	function save_confirmation($status)
	{
	//mengirim notifikasi ke Requester
		$ack=0;
		$sql="INSERT INTO
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
								('$status[REQUESTER]',
								 '$status[SENDER_EMPLOYEE_ID]',
								 '$status[ACTIVITY_TYPE_ID]',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								 if($this->db->query($sql))
		{
				$ack = 1;
		} 
		if($ack == 1 ){
		//notif diterima ke finance
		if($status['STATUS']=='1' && $status['status_id']=='0')
		{
			$sql = "INSERT INTO
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
								('$status[REQUESTER]',
								 '$status[SENDER_EMPLOYEE_ID]',
								 '5',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		}
		
		if($status['STATUS']=='1' && $status['status_id']=='1')
		{
			$sql = "INSERT INTO
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
								('$status[REQUESTER]',
								 '$status[PURCHASE]',
								 '5',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		}
		if($status['STATUS']=='2' && $status['status_id']=='0')
		{
			$sql = "INSERT INTO
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
								('$status[REQUESTER]',
								 '$status[PURCHASE]',
								 '5',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		}
					
		if($status['STATUS']=='3' && $status['status_id']=='1')
		{
			$sql = "INSERT INTO
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
								('$status[FINAL_APPROVE]',
								 '$status[PURCHASE]',
								 '13',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		}
		
		if($status['STATUS']=='3' && $status['status_id']=='2')
		{
			$sql = "INSERT INTO
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
								('$status[REQUESTER]',
								 '$status[PURCHASE]',
								 '5',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		}
			if($this->db->query($sql))
		
			{
			$ack = 2;
			}
		
		}
		if($ack == 2 ){
		
		if ($status['STATUS']=='1' && $status['status_id']=='0' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						REMARKS='$status[REMARKS]',

						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
	if ($status['STATUS']=='2'&& $status['status_id']=='0')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						REMARKS='$status[REMARKS]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}		
	if ($status['STATUS']=='3'&& $status['status_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						REMARKS='$status[REMARKS]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
	
			if($this->db->query($sql))
		
			{
			$ack = 3;
			}
		}
		
		if($ack == 3 ){
		//notif diterima ke finance
		if ($status['STATUS']=='1'&& $status['status_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status
					SET 
						STATUS='13'
												
					WHERE 
						FORM_TYPE_ID = '4' AND
						FORM_ID = '$status[PR_ID]'";
		}
		if ($status['STATUS']=='3'&& $status['status_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status
					SET 
						STATUS='16'
												
					WHERE 
						FORM_TYPE_ID = '4' AND
						FORM_ID = '$status[PR_ID]'";
		}
		
			if($this->db->query($sql))
		
			{
			$ack = 4;
			}
		}
		if($ack == 4)
		{
		if ($status['STATUS']=='1' && $status['status_id']=='0' )
		{
			$sql = "INSERT INTO 
						tb_r_form_confirmation_list 
											(	FORM_ID,
												FORM_TYPE_ID,
												USER,
												STATUS,
												REMARKS,
												CREATED_BY,
												CREATED_DT) 	
				VALUES 
											('$status[FORM_ID]',
											 '$status[FORM_TYPE_ID]',
											 '$status[SENDER_EMPLOYEE_ID]',
											 '$status[STATUS]',
											 '$status[REMARKS]',
											 '$status[this_name]',
											 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";		
		}
		
		
		
		if($this->db->query($sql))
		
			{
				$ack = 5;
			}
		}
		
		if($ack == 5)
		{
		//update status approve RM 
		if ($status['STATUS']=='1' && $status['status_id']=='0' )
		{
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Order"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> Accepted</b> an application for Purchase Order.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Order</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Order \r\n";
        $headers .= "cc: ".$status['AKUNTAN_EMAIL']." \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}else {
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Order"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> Rejected</b> an application for Purchase Order.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Order</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Order \r\n";
		$headers .= "cc: ".$status['AKUNTAN_EMAIL']." \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		
		if ($status['STATUS']=='1' && $status['status_id']=='1' )
		{
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Order"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> Has Confirmed That The Vendor</b> Has Accepted The Purchase Order.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Order</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Order \r\n";
        $headers .= "cc: ".$status['AKUNTAN_EMAIL']." \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		
			{
				$ack = 6;
			}
		}
		
		if($ack == 6)
		{
		//insert to tbl confirm jika status id 2
		if ($status['STATUS']=='1' && $status['status_id']=='1' )
		{
		$tujuan = $status['AKUNTAN_EMAIL']; //mengambil email requester
        $judul = "Purchase Order"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['AKUNTAN_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> Has Confirmed That The Vendor</b> Has Accepted The Purchase Order.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Order</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Order \r\n";
        $headers .= "cc: ".$status['AKUNTAN_EMAIL']." \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		{
				$ack = 7;
			}
		}
		return $ack;
	
}
}
