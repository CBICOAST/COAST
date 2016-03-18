 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS040
* Program Name     : Form Approval CA
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 07:36:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS040 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	//Memanggil detail CA
	function get_form_detail($form_id)
	{
		$sql = "SELECT
						cl.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						(select pl.LEVEL_NAME from tb_m_position_level pl where empl.LEVEL_ID=pl.LEVEL_ID) level_name,
					    usr.USER_EMAIL employee_email,
					    cl.CA_ID ca_id,
                        cl.CHARGE_CODE chargecode,
                        (select pos.VALUE from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_name,
					    (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
					    fs.TARGET_EMPLOYEE_ID aprove,				
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name, 
                         (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_email,     
                        fs.DIR_APPROVE dir_approve,						
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.DIR_APPROVE )  dir_name, 
                         (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.DIR_APPROVE )  dir_email,     
                           fs.FINAL_APPROVE finance_approve,
                           fs.F2_APPROVE f2_approve,						
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.FINAL_APPROVE )  finance_name, 
                         (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.FINAL_APPROVE )  finance_email,         
						cl.CREATED_DT submitted_dt, 
						cl.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						cl.DESTINATION destination,
						cl.CURRENCY currency,
						(select cost.NOMINAL from tb_m_setting_limit_dir cost  where cost.CURRENCY = cl.CURRENCY)  limit_dir,
						(select cost.DESTINATION from tb_m_ca_cost cost  where cost.COST_ID = cl.DESTINATION)  destination_name,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = cl.CURRENCY )  currency_name,
						cl.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = cl.PAYMENT_METHOD )  pay_method_name,
						cl.REMARK remarks,
                        cl.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = cl.STATUS )  form_status_name,
					    sys.VALUE status,
						fs.STATUS status_id,
						DATE_FORMAT(fs.REVISE_APPROVAL_DT,'%d %b %Y %T') revise_approved_dt,
						fs.REVISE_APPROVAL_BY revise_approved_by,
                        fs.REVISE_APPROVAL_REMARKS revise_remarks_approval,
					    DATE_FORMAT(fs.CREATED_DT,'%d %b %Y %T') approved_dt,
						fs.CREATED_BY approved_by,
                        fs.REMARKS remarks_approval,
                        DATE_FORMAT(fs.APPROVEDIR_DT,'%d %b %Y %T') approveddir_dt,
                        fs.APPROVEDIR_BY approveddir_by,
                        fs.REMARKS_DIR remarks_dir,
                        DATE_FORMAT(fs.REVISE_APPROVEF2_DT,'%d %b %Y %T') revise_approvedf2_dt,
                        fs.REVISE_APPROVEF2_BY revise_approvedf2_by,
                        fs.REVISE_REMARKS_F2 revise_remarks_f2,
                        DATE_FORMAT(fs.APPROVEF2_DT,'%d %b %Y %T') approvedf2_dt,
                        fs.APPROVEF2_BY approvedf2_by,
                        fs.REMARKS_F2 remarks_f2,
						fs.REMARKS_GR remarks_finance,
                        DATE_FORMAT(fs.UPDATED_DT,'%d %b %Y %T') accepted_dt,
                        fs.UPDATED_BY accepted_by
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca cl,
					    tb_m_user usr,
					    tb_m_ca_type ct,
					    tb_m_system sys
				    
				WHERE
					    cl.CA_ID = '$form_id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cl.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '18' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CA_ID AND
					    fs.FORM_TYPE_ID = '2' 
						order by cl.CA_ID desc";	
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
						         '2',
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
		
		//untuk mengirim submit email ke requester
		if($ack == 1){
		if ($status['STATUS']!='3'){
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAMA']."</b>, <br><br>
                 ".$status['this_name']." <b> " .$status['status_name']."</b> your application for Cash Advance.</p>
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
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }}
		if ($status['STATUS']=='3' && $status['status_id']=='0'){
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAMA']."</b>, <br><br>
                 ".$status['this_name']." asked you to <b> " .$status['status_name']."</b> your application for Cash Advance.</p>
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
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		if ($status['STATUS']=='3' && $status['status_id']=='16'){
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAMA']."</b>, <br><br>
                 ".$status['this_name']." asked you to <b> " .$status['status_name']."</b> note your application for Cash Advance.</p>
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
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
        $ack = 2;
		}

			if($ack == 2)
		{
		if($ack == 2 && ((($status['status_id'] == '0' || $status['status_id'] == '8') && ($status['GROUP_HEAD'] != $status['this_id'])) || ($status['status_id'] == '1' && ($status['FINAL_APPROVE'] != $status['this_id'])) || (($status['status_id'] == '16' || $status['status_id'] == '19') && ($status['F2_APPROVE'] != $status['this_id']))|| ($status['status_id'] == '2' && ($status['DIR_APPROVE'] != $status['this_id']))))
		{
		//menghapus notifikasi
		$sql = "DELETE FROM tb_r_notification
						WHERE
                         (ACTIVITY_TYPE_ID = '0' OR ACTIVITY_TYPE_ID = '4') AND 
                         SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
                         FORM_TYPE_ID = '2' AND
						FORM_ID ='$status[FORM_ID]'";} 
		else {
					$sql = "DELETE FROM tb_r_notification
						WHERE
                         RECIPIENT_EMPLOYEE_ID = '$status[this_id]' AND 
                         SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
                         FORM_TYPE_ID = '2' AND
						FORM_ID ='$status[FORM_ID]'";		
						}
		if($this->db->query($sql))
		
			{
				$ack = 3;
			}
		}


if($ack == 3 ){
		//approval menerima
		if ($status['STATUS']=='1' && ($status['status_id']=='0' || $status['status_id']=='8' )){
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
								 '$status[REQUESTER]',
								 '0',
						         '2',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			} 
			
		//finance1 menerima
		if ($status['STATUS']=='1' && $status['status_id']=='1' )
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
								('$status[F2_APPROVE]',
								 '$status[REQUESTER]',
								 '0',
						         '2',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			} 
			

		//finance2 menerima
		if (($status['status_id']=='16' || $status['status_id']=='19') && $status['STATUS']!='3')
		{
		if ($status['STATUS']=='1'  && (($status['divid']=='SALES' || ($status['DIR_APPROVE'] != $status['SENDER_EMPLOYEE_ID'] )) || (($status['AMOUNT'] >= $status['LIMIT']  ) && ($status['DIR_APPROVE'] != $status['SENDER_EMPLOYEE_ID'] )))) 
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
								('$status[DIR_APPROVE]',
								 '$status[REQUESTER]',
								 '0',
						         '2',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		}if (($status['STATUS']=='1' || $status['STATUS']=='2' ) && ($status['divid']!='SALES'  && ($status['AMOUNT'] < $status['LIMIT']  ))) {
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
		
		}
		//insert to tbl confirm jika status id 2
		if (($status['STATUS']=='1' || $status['STATUS']=='2' )&& $status['status_id']=='2')
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
		
		//reject by f1
		if ($status['STATUS']=='2' && $status['status_id']=='1' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						REMARKS_GR = '$status[F2_APPROVE]',
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		//reject by f1
		if ($status['STATUS']=='2' && ($status['status_id']=='16'|| $status['status_id']=='19') )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='17',
						REMARKS_F2 = '$status[REMARKS]',
						APPROVEF2_BY = '$status[this_name]',
						APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";	
		}


		//reject by RM
		if ($status['STATUS']=='2' && ($status['status_id']=='0' || $status['status_id']=='8' ) )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='6',
						REMARKS='$status[REMARKS]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		//need to be revise
		if ($status['STATUS']=='3' && $status['status_id']=='0'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='7',
						REVISE_APPROVAL_REMARKS='$status[REMARKS]',
						CREATED_BY = '-',
						REVISE_APPROVAL_BY = '$status[this_name]',
						REVISE_APPROVAL_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";}

			//need to be revise
		if ($status['STATUS']=='3' && $status['status_id']=='16'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='18',
						REVISE_REMARKS_F2='$status[REMARKS]',
						F2_APPROVE = '$status[F2_APPROVE]',
						REVISE_APPROVEF2_BY = '$status[this_name]',
						REVISE_APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";}

						
			if($this->db->query($sql))
		
			{
			$ack = 4;
			}
		}		
		
		if($ack == 4 && $status['CA_TYPE_ID']!='1')
		{
		//konfirmasi di group head status diterima
		if ($status['STATUS']=='1' && ($status['status_id']=='0' || $status['status_id']=='8' ))
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[FINAL_APPROVE]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";
		}

		//konfirmasi di finance status diterima 
		if ($status['STATUS']=='1' && $status['status_id']=='1' ){
		
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='16',
						F2_APPROVE = '$status[F2_APPROVE]',
						REMARKS_GR = '$status[REMARKS]',
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";
		}	
		
		//konfirmasi di finance2 status diterima 
		if ($status['STATUS']=='1' && ($status['status_id']=='16' || $status['status_id']=='19') ){
		//ke direktur
		if($status['divid']=='SALES' || (($status['AMOUNT'] >= $status['LIMIT']  ) && ($status['DIR_APPROVE'] != $status['SENDER_EMPLOYEE_ID'] ))) 
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						REMARKS_F2 = '$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						APPROVEF2_BY = '$status[this_name]',
						APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";
		
		}
		//tidak ke direktur
		else{
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						DIR_APPROVE = '-',
						REMARKS_F2 = '$status[REMARKS]',
						APPROVEF2_BY = '$status[this_name]',
						APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";
		}
		}
		//konfirmasi di direktur status diterima
		if ($status['STATUS']=='1' && $status['status_id']=='2' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";
		}
		//close form ca status ditolak
		if ($status['STATUS']=='2')
		{
			$sql = "UPDATE 
						tb_r_ca 
					SET 
						STATUS='2'
					WHERE 
						
						CA_ID ='$status[FORM_ID]'";}
		if($this->db->query($sql))
		
			{
				$ack = 5;
			}
		}
			


			
			if($ack == 5 && $status['status_id']=='2' && $status['STATUS']=='2')
		{
		if ($status['STATUS']=='2'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='5',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$status[FORM_ID]'";		
		}else{
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
								 '$status[REQUESTER]',
								 '5',
						         '2',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";}
		if($this->db->query($sql))
		
			{
				$ack = 6;
			}
		}


		
		
		if($ack == 6 && (($status['STATUS']=='1' && ($status['status_id']=='16' || $status['status_id']=='19') &&($status['divid']=='SALES' || $status['AMOUNT'] >= $status['LIMIT']  ) )))
		{
		$tujuan = $status['DIR_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_APPROVE_NAMA']."</b>, <br><br>
                 ".$status['REQUESTER_NAMA']." <b> submitted</b> application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
        $ack = 8;
		}
		
		
			if($ack == 8 && $status['STATUS']=='1' && $status['status_id']!='16' && $status['status_id']!='19'){
		//notif jika status 1 dan diterima
		if ($status['STATUS']=='1' && $status['status_id']=='1' )
		{
		$tujuan = $status['F2_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['F2_APPROVE_NAMA']."</b>, <br><br>
                 ".$status['FINAL_APPROVE_NAMA']." <b> accepted ".$status['REQUESTER_NAMA']."'s </b>application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";}
		//notif jika status 1 dan diterima
		if ($status['STATUS']=='1' && $status['status_id']=='2' )
		{
		$tujuan = $status['FINAL_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['FINAL_APPROVE_NAMA']."</b>, <br><br>
                 ".$status['DIR_APPROVE_NAMA']." <b> approved ".$status['REQUESTER_NAMA']."'s </b>application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";}
		//notif jika status 1 dan diterima
		if ($status['STATUS']=='1' && ($status['status_id']=='0' || $status['status_id']=='8' ))
		{
		$tujuan = $status['FINAL_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['FINAL_APPROVE_NAMA']."</b>, <br><br>
                 ".$status['REQUESTER_NAMA']." <b> submitted</b> application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";}
		

		 //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success.";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed.";//jika tidak terkirim
        }
		
			{
			$ack = 7;
			}
		}
		
			

		if($ack == 7 && $status['status_id']=='2' && $status['STATUS']=='1')
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
								 '$status[REQUESTER]',
								 '1',
						         '2',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";}
		if($this->db->query($sql))
		
			{
				$ack = 8;
			}
		
		

		
		
		return $ack;
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
	
	//menampilkan tipe CA
	function get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type";
		return fetchArray($sql, 'all');
	}
	
	//menampilkan daftar chargecode type
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
	
	//menampilkan employee list
	function get_employee_list()
	{
		$sql = " SELECT
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
}
