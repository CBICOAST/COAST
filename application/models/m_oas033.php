<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS033
* Program Name     : Approval Claim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-09-2014 07:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 					 										 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS033 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	

	function get_form_detail($form_id)
	{
		$sql = "SELECT 
						cl.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
					    usr.USER_EMAIL employee_email,
					    cl.CLAIM_ID claim_id,
                        cl.CHARGE_CODE chargecode,
                        cl.KETERANGAN remark_requester,
                        (select pos.VALUE from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_name,
					    (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
					    fs.TARGET_EMPLOYEE_ID aprove,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						cl.TANGGAL_KWITANSI tanggal_kwitansi, 
                        month(cl.TANGGAL_KWITANSI) month,
                        year(cl.TANGGAL_KWITANSI) year,
						cl.TOTAL total,
					    ct.EXPENSE_TYPE_ID id,
					    ct.EXPENSE_TYPE_NAME claim_type,
                        ct.CLAIM_CATEGORY category_id,
                        (select pos.VALUE from tb_m_system pos where pos.SYS_CAT= '10' and pos.SYS_CD = ct.CLAIM_CATEGORY )  category_name,
					    sys.VALUE status,
					    fs.STATUS status_id,
                        ct.YEAR_PERIODE periode,
						ct.LIMIT_REQUEST limitReq,
						cl.CREATED_DT makerDate,
						cl.CREATED_BY makerBy,
						fs.REMARKS remark,
                        fs.CREATED_BY app_by,
                        fs.CREATED_DT app_dt,
                        fs.UPDATED_BY fin_by,
                        fs.UPDATED_DT fin_dt,
						fs.APPROVEPUR_BY f2_by,
						fs.APPROVEPUR_DT f2_dt,
						fs.REMARKS_PUR f2_remark, 
						fs.APPROVEDIR_BY dir_by,
						fs.APPROVEDIR_DT dir_dt,
						fs.REMARKS_DIR dir_remark,
						 (select REMAIN from tb_r_bantuan bnt, tb_r_claim cl 
                      where bnt.EMPLOYEE_ID = cl.EMPLOYEE_ID
                     AND YEAR = YEAR(cl.TANGGAL_KWITANSI) 
                     AND bnt.EXPENSE_TYPE_ID = cl.CLAIM_TYPE_ID AND 
                     CLAIM_ID = '$form_id') saveRemain
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_claim cl,
					    tb_m_user usr,
					    tb_m_expense_type ct,
					    tb_m_system sys

				WHERE
					    cl.CLAIM_ID = '$form_id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cl.CLAIM_TYPE_ID = ct.EXPENSE_TYPE_ID AND
					    sys.SYS_CAT = '9' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CLAIM_ID AND
					    fs.FORM_TYPE_ID = '5' ";	
		return fetchArray($sql, 'row');
	}
	function get_form_remarks($form_id)
	{
		$sql = "SELECT 
						fcl.REMARKS remark_fin,
						fcl.CREATED_BY app_fin
				FROM 
						tb_r_form_confirmation_list fcl
				WHERE
					    fcl.FORM_TYPE_ID = '5' AND
					    fcl.FORM_ID = '$form_id' ";	
		return fetchArray($sql, 'row');
	
	}
	function get_edit_detail($form_id)
	{
		$sql = "SELECT CHARGE_CODE ori_cc,
					RECEIPT_DATE ori_tgl,
					AMOUNT ori_amount,
					REMARKS ori_remark 
				FROM tb_r_edit 
				WHERE form_id = '$form_id' AND
					FORM_TYPE_ID = '5'";	
		return fetchArray($sql, 'row');
	}
	
	function get_chargecode_div($form_id)
	{
	
		$sql = " SELECT 
						cc.CHARGE_CODE 	ch,
						cc.DIVISION_ID div_cc
				    
				FROM 
						tb_m_charge_code cc,
                        tb_r_claim cl

				WHERE
                        cl.CHARGE_CODE = cc.CHARGE_CODE AND
					    cl.CLAIM_ID = '$form_id'";
							
		return fetchArray($sql, 'row');
	}
	function save_confirmation_divisi($status)
	{
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
								 '$status[STATUS_NOTIF]',
						         '5',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			$sql_delete = "DELETE FROM
							  tb_r_notification  WHERE FORM_TYPE_ID = 5 AND FORM_ID ='$status[FORM_ID]' ";	
			

			$this->db->trans_start();
			$this->db->query($sql_delete);
			$this->db->query($sql);
			if($this->db->trans_complete())
			$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> has" .$status['status_name']."</b> your application for Expense Claim.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Expense Claim</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Expense Claim \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			{
				$ack = 1;
			}
		
		if($ack == 1 ){
		if ($status['STATUS']=='1' && ($status['status_id']=='0'|| $status['status_id']=='8') )
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
								('$status[USER]',
								 '$status[REQUESTER]',
								 '0',
						         '5',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
}
if ($status['STATUS']=='3' && ($status['status_id']=='0' || $status['status_id']=='8')){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='7',
						REMARKS='$status[REMARKS]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
						}
						
		if ($status['STATUS']=='2' && ($status['status_id']=='0' || $status['status_id']=='8')){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '-',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
						}
		if ($status['STATUS']=='2' && $status['status_id']=='1'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[USER]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
						}
				if ($status['STATUS']=='1' && $status['status_id']=='1'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[USER]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";}
		
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		

		if($ack == 2)
		{
		if ($status['STATUS']=='1' && ($status['status_id']=='0' ||  $status['status_id']=='8' )){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[USER]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";}
		
			if($this->db->query($sql))
			{
				$ack = 3;
			}
		}
		
		if($ack == 2)
		{
		if ($status['STATUS']=='1' && ($status['status_id']=='0' ||  $status['status_id']=='8' )){
			$tujuan = $status['USER_EMAIL']; //mengambil email requester
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['USER_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> has Submitted </b> an application for Expense Claim.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Expense Claim</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Expense Claim \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
			{
				$ack = 3;
			}
		}
		return $ack;
		}

		
	
	function save_confirmation_individu($status)
	{
		$ack = 1;
		if($ack == 1){
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
								 '$status[STATUS_NOTIF]',
						         '5',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	

			$sql_delete = "DELETE FROM
							  tb_r_notification  WHERE FORM_TYPE_ID = 5 AND FORM_ID ='$status[FORM_ID]' ";	

			$this->db->trans_start();
			$this->db->query($sql_delete);
			$this->db->query($sql);
			if($this->db->trans_complete())
			$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> has" .$status['status_name']."</b> your application for Expense Claim.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Expense Claim</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Expense Claim \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			{
				$ack = 2;
			}
		}

		if($ack == 2)
		{
		if ($status['STATUS']=='1' && $status['category_id']=='1'){
		$sqlFCL="INSERT INTO 
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
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='11',
						FINAL_APPROVE = '$status[USER]',
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
			$this->db->query($sqlFCL);
		} else if ($status['STATUS']=='1' && $status['category_id']=='2' && $status['status_id']=='1'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='11',
						FINAL_APPROVE = '$status[get_f2_id]',
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
			
				// Untuk kasih notif ke Finance 2
			$sql2= "INSERT INTO
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
								('$status[get_f2_id]',
								 '$status[REQUESTER]',
								 '0',
						         '5',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
		$sqlFCL="INSERT INTO 
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
											
			$this->db->query($sql2);$this->db->query($sqlFCL);
		}
		else if ($status['STATUS']=='1' && $status['category_id']=='2' && $status['status_id']=='11'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='9',
						REMARKS_PUR = '$status[REMARKS]',
						DIR_APPROVE = '$status[get_dir_id]',
						APPROVEPUR_BY = '$status[this_name]',
						APPROVEPUR_DT  = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";			
			if($status['claim_type_id']=='4'){
				// Untuk kasih notif ke direktur jika expense marketing
				$sql2= "INSERT INTO
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
								('$status[get_dir_id]',
								 '$status[REQUESTER]',
								 '0',
						         '5',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
				$this->db->query($sql2);
			}
		}
		else if ($status['STATUS']=='1' && $status['category_id']=='2' && $status['status_id']=='9' && $status['claim_type_id']=='4'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='10',
						DIR_APPROVE = '$status[get_dir_id]',
						REMARKS_DIR = '$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5' AND
						FORM_ID ='$status[FORM_ID]'";						
		
		}
		else if ($status['STATUS']=='2' && $status['category_id']=='2' && $status['status_id']=='9' && $status['claim_type_id']=='4'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='12',
						DIR_APPROVE = '$status[get_dir_id]',
						REMARKS_DIR = '$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5' AND
						FORM_ID ='$status[FORM_ID]'";						
		
		}else{
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						FINAL_APPROVE = '$status[USER]',						
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$status[FORM_ID]'";
		}

			if($this->db->query($sql))
			{
				$ack = 3;
			}
		}

		
		
		if($ack == 3 && $status['STATUS']=='1')
		{ 
		if ($status['claim_type_id']<='3'){
			$sql = "UPDATE 
						tb_r_tunjangan
					SET 
						REMAIN_AMOUNT = (REMAIN_AMOUNT - $status[total])
					WHERE 
						EMPLOYEE_ID = '$status[REQUESTER]'AND
						YEAR ='$status[year]' AND
						MONTH ='$status[month]'AND
						EXPENSE_TYPE_ID ='$status[claim_type_id]'";			
				$this->db->trans_start();
					$this->db->query($sql);
				if($this->db->trans_complete()){
					$ack = 4;
				}		
			}
		if (($status['claim_type_id']=='8') || ($status['claim_type_id']=='10') ||
		($status['claim_type_id']=='9001') || ($status['claim_type_id']=='9002') ||($status['claim_type_id']=='9003')) {
			$sql = "UPDATE 
						tb_r_bantuan
					SET 
						REMAIN = ('$status[saveRemain]' - 1),
						UPDATED_BY 		= 'user: $status[this_email]',
						UPDATED_DT 		= '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						EMPLOYEE_ID = '$status[REQUESTER]'AND
						YEAR ='$status[year]' AND
						(EXPENSE_TYPE_ID ='$status[claim_type_id]' OR( EXPENSE_TYPE_ID IN( 
							SELECT EXPENSE_TYPE_ID FROM tb_m_expense_type WHERE EXPENSE_TYPE_PARENT IN 
							(SELECT EXPENSE_TYPE_PARENT FROM( SELECT EXPENSE_TYPE_PARENT FROM tb_m_expense_type WHERE
							EXPENSE_TYPE_ID = '$status[claim_type_id]')as temp))))";
			
			
			$sql2 = "INSERT INTO tb_r_bantuan
						   (EMPLOYEE_ID, 
						   YEAR,
						   EXPENSE_TYPE_ID,
						   AMOUNT,
						   REMAIN,
						   CREATED_BY,
						   CREATED_DT)
					VALUES
						   ('$status[REQUESTER]',
						   ($status[year]+$status[periode]),
						   '$status[claim_type_id]',
						   (Select AMOUNT FROM (Select AMOUNT from  tb_r_bantuan 
							WHERE EMPLOYEE_ID = '$status[REQUESTER]' AND YEAR='$status[year]'
							AND EXPENSE_TYPE_ID = '$status[claim_type_id]')AS tmpt),
						   1,
						   'user: $status[this_email]',
						   '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
				$this->db->trans_start();
				$this->db->query($sql);
				//$this->db->query($sql2);
				
				if($this->db->trans_complete()){
					$ack = 4;
				}		
			}
		if($ack == 4)
		{
		if ($status['periode']>'0'){
			$sql = "INSERT INTO tb_r_bantuan
						   (EMPLOYEE_ID, 
						   YEAR,
						   EXPENSE_TYPE_ID,
						   AMOUNT,
						   REMAIN,
						   CREATED_BY,
						   CREATED_DT)
					VALUES
						   ('$status[REQUESTER]',
						   ($status[year]+$status[periode]),
						   '$status[claim_type_id]',
						   (Select AMOUNT FROM (Select AMOUNT from  tb_r_bantuan 
							WHERE EMPLOYEE_ID = '$status[REQUESTER]' AND YEAR='$status[year]'
							AND EXPENSE_TYPE_ID = '$status[claim_type_id]')AS tmpt),
							(Select AMOUNT FROM (Select AMOUNT from  tb_r_bantuan 
						   1,
						   'user: $status[this_email]',
						   '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
		 
			if($this->db->query($sql))
			{
				$ack = 5;
			}
			}
		}
			return $ack;
		} 
	}
	
	// update februari 2015
	function get_balance_bantuan($form_id,$type)
	{
	
		$sql = " SELECT	
					rbnt.AMOUNT balance
				FROM
					tb_r_bantuan rbnt, tb_r_claim rc 
				WHERE	
					rbnt.EMPLOYEE_ID = rc.EMPLOYEE_ID AND
					rbnt.YEAR = year(rc.TANGGAL_KWITANSI) AND
					rc.CLAIM_ID ='$form_id' AND 
					rbnt.EXPENSE_TYPE_ID ='$type' 
				";
							
		return fetchArray($sql, 'row');
	}
	function get_balance_tunjangan($form_id,$type)
	{
	
		$sql = " SELECT	
					tnj.REMAIN_AMOUNT balance
				FROM
					tb_r_tunjangan tnj, tb_r_claim rc 
				WHERE	
					tnj.EMPLOYEE_ID = rc.EMPLOYEE_ID AND
					tnj.YEAR = year(rc.TANGGAL_KWITANSI) AND
					tnj.MONTH = month(rc.TANGGAL_KWITANSI) AND
					rc.CLAIM_ID ='$form_id' AND 
					tnj.EXPENSE_TYPE_ID ='$type' 
				";
							
		return fetchArray($sql, 'row');
	}
}