 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS071
* Program Name     : Form Konfirmasi Purchase Request 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* Changes Approval	 07-09-2015		   Annisa Intan Fadila	
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS071 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//memanggil list purchase
	function get_list_tmppr($form_id)
	{
	$sql = "SELECT 	NO no,
					QTY qty,
					SATUAN satuan,
					NAMA nama,
					HARGA harga,
					TOTAL total,
					KETERANGAN keterangan
			FROM tmp_item_pr 
			where PR_ID = '$form_id'";
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
        pr.REF_NO no_ref,
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
        (select cha.TYPE from tb_m_charge_code cha where cha.CHARGE_CODE = pr.CHARGE_CODE ) typecc,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
		fs.PUR_APPROVE pur_approve,
		fs.GROUP_APPROVE gr_approve,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarksrm,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEGR_DT approvegr_dt,
		fs.APPROVEGR_BY approvegr_by,
		fs.REMARKS_GR remarksgr,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.APPROVEPUR_DT approvepur_dt,
		fs.APPROVEPUR_BY approvepur_by,
		fs.REMARKS_PUR remarkspur,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.APPROVEFIN_DT approvefin_dt,
		fs.APPROVEFIN_BY approvefin_by,
		fs.REMARKS_FINANCE remarksfin,
		fs.REVISE_REMARKS_F2 reviseremarksf2,
		fs.REVISE_APPROVEF2_BY reviseapprovef2_by,
		fs.REVISE_APPROVEF2_DT reviseapprovef2_dt,
		fs.REMARKS_REVISE_APPROVEPUR reviseremarkspur,
		fs.REVISE_APPROVEPUR_BY reviseapprovepur_by,
		fs.REVISE_APPROVEPUR_DT reviseapprovepur_dt,
		fs.STATUS status_id,
		(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '25' AND sys.SYS_CD = fs.STATUS) status_name,
		(SELECT CASE WHEN fs.STATUS_FORM = '8' then 'Rejected' WHEN fs.STATUS_FORM = '3' then 'Approved' WHEN fs.STATUS_FORM = '11' then 'Approved' END) statusform,
		(SELECT CASE WHEN fs.STATUS_FORM_GR = '8' then 'Rejected' WHEN fs.STATUS_FORM_GR = '3' then 'Approved' END) statusgr,
		(SELECT CASE WHEN fs.STATUS_FORM_FIN = '5' then 'Rejected' WHEN fs.STATUS_FORM_FIN = '1' then 'Approved' END) statusfin,
		(SELECT CASE WHEN fs.STATUS_FORM_PUR = '4' then 'Accepted' WHEN fs.STATUS_FORM_PUR = '14' then 'Ask to Revise' WHEN fs.STATUS_FORM_PUR = '7' then 'Rejected' END) statuspur,
		(SELECT CASE WHEN fs.STATUS_FORM_DIR = '2' then 'Approved' WHEN fs.STATUS_FORM_DIR = '6' then 'Rejected' WHEN fs.STATUS_FORM_DIR = '4' then 'Accepted' END) statusdir,
		(SELECT CASE WHEN fs.STATUS_FORM_REVISE = '17' then 'Has Been Revised' END) statusrevise,
		(SELECT CASE WHEN fs.STATUS_FORM_REVISE_APPROVEF2 = '15' then 'Approved' WHEN fs.STATUS_FORM_REVISE_APPROVEF2 = '7' then 'Rejected' END) statusrevisef2,
		(SELECT CASE WHEN fs.STATUS_FORM_REVISE_APPROVEPUR = '15' then 'Approved' WHEN fs.STATUS_FORM_REVISE_APPROVEPUR = '2' then 'Approved' WHEN fs.STATUS_FORM_REVISE_APPROVEPUR = '7' then 'Rejected' WHEN fs.STATUS_FORM_REVISE_APPROVEPUR = '18' then 'Accepted' END) statusrevisepur,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,  
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
		pr.REMARK_P1 r1,
        pr.2ND_PAYMENT k2_pay,
		pr.DATE_2PAYMENT tgl2,
		pr.REMARK_P2 r2,
		(select cost.NOMINAL_PR from tb_m_setting_limit_dir cost  where cost.CURRENCY = pr.CURRENCY)  limit_dir,
        
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
		pr.REMARK_P3 r3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4,
		pr.REMARK_P4 r4
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE
        pr.PR_ID = '$form_id' AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '25' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = pr.PR_ID AND
		fs.FORM_TYPE_ID = '4'
ORDER BY 
         pr.PR_ID desc				
";	
		return fetchArray($sql, 'row');
	}
	
	//memanggil vendor
	function get_vendor($form_id)
	{
	$sql = "SELECT 
                tv.ID_VENDOR v_id,
                tv.COMPANY v_name,
                tv.ATTN v_attn,
                tv.ADDRESS v_address,
                tv.CITY v_city,
                tv.PHONE v_phone,
                tv.ZIP v_zip,
                tv.FAX v_fax
                
			FROM 
                 tb_r_pr pr,
                 tb_r_vendor tv        
            
			where 
                  pr.VENDOR = tv.ID_VENDOR AND
				  pr.PR_ID = '$form_id'";
	return fetchArray($sql, 'row');
	}
	
	//memanggil shipto
	function get_shipto($form_id)
	{
	$sql = "SELECT         
                ts.S_COMPANY sh_name,
                ts.S_ADDRESS sh_address, 
                ts.S_CP sh_cp,
                ts.S_TELP sh_telp,
                ts.S_EMAIL sh_email,
                ts.S_NPWP sh_npwp 
                
			FROM 
                 tb_r_pr pr,
                 tb_r_shipto ts        
            
			where 
                  pr.SHIP_TO = ts.SHIPTO_ID AND
				  pr.PR_ID = '$form_id'";
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
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								 if($this->db->query($sql))
		{
				$ack = 1;
		}
		
		if($ack == 1)
		{
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> " .$status['status_name']."</b> your application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
        $ack = 2;
		}
		
		if($ack == 2){
		if($ack==2 && ((($status['status_id']=='0' || $status['status_id']=='14') && ($status['approvalgr'] != $status['this_id']))   || ($status['PURCHASE'] != $status['this_id']) || ($status['DIR_APPROVE'] != $status['this_id']) || $status['FINAL_APPROVE'] != $status['this_id'] )){
		$sql = "DELETE FROM 
							tb_r_notification
				WHERE
						(ACTIVITY_TYPE_ID = '0' OR ACTIVITY_TYPE_ID = '4') AND
						SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
						FORM_TYPE_ID = '4' AND
						FORM_ID = '$status[FORM_ID]'";
						}
		else{
		$sql = "DELETE FROM
							tb_r_notification
				WHERE
						RECIPIENT_EMPLOYEE_ID = '$status[this_id]' AND
						SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
						FORM_TYPE_ID = '4' AND
						FORM_ID = '$status[FORM_ID]'";
		
				
			
			}
		if($this->db->query($sql))
		
		{
				$ack = 3;
		}
		}
		
		
		if($ack == 3 ){
		//notif diterima oleh rm
		if  ($status['STATUS']=='1' && (($status['status_id']=='0' && $status['this_id'] == $status['approvalgr']) || ($status['status_id']=='0' && $status['this_id'] != $status['approvalgr'] && $status['this_id'] == $status['DIR_APPROVE'] || $status['status_id']=='11')))
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
								 '0',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								
			
								}
		//rm tidak sama dengan group cc
			//rm tidak sama dengan group cc
		if ($status['STATUS']=='1' && $status['status_id']=='0' && $status['this_id'] != $status['approvalgr'] && $status['this_id'] != $status['DIR_APPROVE'])
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
								('$status[approvalgr]',
								 '$status[REQUESTER]',
								 '0',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}
								 
		//notif ke purchase
		if ($status['STATUS']=='1' && $status['status_id']=='3')
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
								('$status[PURCHASE]',
								 '$status[REQUESTER]',
								 '0',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}						 
		//Mengirimkan notifikasi diterima ke dir (approve purchase)
		if ($status['STATUS']=='1' && $status['status_id']=='1') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
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
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			$sql2 = "UPDATE
						tb_r_form_status
					SET 
						STATUS='2',
						STATUS_FORM_DIR='2',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
			$this->db->query($sql);
			
		}	

		
		else
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
								 '0',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
		}
	}		
		//notif diterima ke finance
		if ($status['STATUS']=='1' && $status['status_id']=='2' )
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
			}
			
		//notif diterima requester saat revise
		//notif diterima ke finance
		if ($status['STATUS']=='3' && $status['status_id']=='1' )
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
			}
			
		
		//accept by Purchase
		if ($status['STATUS']=='1' && $status['status_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						STATUS_FORM_PUR='4',
						REMARKS_PUR='$status[REMARKS]',
						APPROVEPUR_BY = '$status[this_name]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
		//revise by purchase
		if ($status['STATUS']=='3' && $status['status_id']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='14',
						STATUS_FORM_PUR='14',
						REVISE_REMARKS_F2='$status[REMARKS]',
						REVISE_APPROVEF2_BY = '$status[this_name]',
						REVISE_APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
		//reject by RM
		if ($status['STATUS']=='2' && $status['status_id']=='0' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='8',
						STATUS_FORM='8',
						REMARKS='$status[REMARKS]',
						PUR_APPROVE='-',
						GROUP_APPROVE='-',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
		//reject by Group
		if ($status['STATUS']=='2' && $status['status_id']=='11' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='8',
						STATUS_FORM_GR='8',
						PUR_APPROVE='-',
						REMARKS_GR='$status[REMARKS]',
						APPROVEGR_BY = '$status[this_name]',
						APPROVEGR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
		//reject by Approval purchase
		if ($status['STATUS']=='2' && $status['status_id']=='1' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='7',
						STATUS_FORM_PUR='7',
						DIR_APPROVE='-',
						REMARKS_PUR='$status[REMARKS]',
						APPROVEPUR_BY = '$status[this_name]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}

		//reject by Dir
		if ($status['STATUS']=='2' && $status['status_id']=='2')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='6',
						STATUS_FORM_DIR='6',
						REMARKS_DIR='$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						FINAL_APPROVE ='-', 
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";		
		}
		
		if ($status['STATUS']=='2' && $status['status_id']=='18')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='6',
						STATUS_FORM_DIR='6',
						REMARKS_DIR='$status[REMARKS]',
						FINAL_APPROVE ='-', 
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";		
		}
		
		//reject by Finance
		if ($status['STATUS']=='2' && $status['status_id']=='3' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='5',
						STATUS_FORM_FIN='5',
						REMARKS_FINANCE='$status[REMARKS]',
						APPROVEFIN_BY = '$status[this_name]',
						APPROVEFIN_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
			if($this->db->query($sql))
			{
			$ack = 4;
			}
		}
		
		if($ack == 4)
		{
		
		//insert into tbl form status
		
		if ($status['STATUS']=='1' && $status['status_id']=='1' && (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES')) {
			//notif to dir 
			
			
			$sql = "UPDATE
						tb_r_form_status
					SET 
						STATUS='2',
						STATUS_FORM_DIR='2',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
			
			
		}
		
		
		//
		//insert to tbl confirm jika status id 2
		if ($status['STATUS']=='1' && $status['status_id']=='3' )
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
		
		//insert to tbl confirm jika status id 2
		if ($status['STATUS']=='2' && $status['status_id']=='3')
		{
			
		$sql = "	UPDATE 
						tb_r_pr 
					SET 
						STATUS='1',
						
						REMARK_DOC = '$status[REMARKS]'
					WHERE 
						PR_ID ='$status[FORM_ID]'";}	
		
		//update status approve RM 
		if ($status['STATUS']=='1' && $status['status_id']=='0' )
		{
		if (($status['this_id'] == $status['approvalgr']) || ($status['this_id'] != $status['approvalgr'] )){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						STATUS_FORM='3',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[FINAL_APPROVE]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";}
		if ($status['this_id'] != $status['approvalgr'] && $status['this_id'] != $status['DIR_APPROVE'] ){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='11',
						STATUS_FORM='11',
						REMARKS='$status[REMARKS]',
						FINAL_APPROVE = '$status[FINAL_APPROVE]',
						GROUP_APPROVE = '$status[approvalgr]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";}
		}
		
		//update status ketika diaccept by Finance
		if ($status['STATUS']=='1' && $status['status_id']=='11' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						STATUS_FORM_GR='3',
						FINAL_APPROVE = '$status[FINAL_APPROVE]',
						PUR_APPROVE = '$status[PURCHASE]',
						REMARKS_GR='$status[REMARKS]',
						APPROVEGR_BY = '$status[this_name]',
						APPROVEGR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
		//update status ketika diaccept by Finance
		if ($status['STATUS']=='1' && $status['status_id']=='3' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						STATUS_FORM_FIN='1',
						REMARKS_FINANCE='$status[REMARKS]',
						FINAL_APPROVE = '$status[FINAL_APPROVE]',
						PUR_APPROVE = '$status[PURCHASE]',
						APPROVEFIN_BY = '$status[this_name]',
						APPROVEFIN_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
		//update status ketika diaccept by Purchase
		if ($status['STATUS']=='1' && $status['status_id']=='1' && $status['status_po']=='0' )
		{
		if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						STATUS_FORM_DIR='2',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
						
			}
			else{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						STATUS_FORM_PUR='4',
						REMARKS_PUR = '$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						APPROVEPUR_BY = '$status[this_name]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		}
		
		if ($status['STATUS']=='1' && $status['status_id']=='1' && $status['status_po']=='1' )
		{
		if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						STATUS_FORM_DIR='2',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						REMARKS_DIR='$status[REMARKS]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
						
			}
			else{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='18',
						STATUS_FORM_PUR='18',
						REMARKS_PUR = '$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						APPROVEPUR_BY = '$status[this_name]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		}
		
		//update status approve dir
		if ($status['STATUS']=='1' && $status['status_id']=='2' && $status['status_po']=='0')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						STATUS_FORM_DIR='4',
						REMARKS_DIR='$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
		if ($status['STATUS']=='1' && $status['status_id']=='2' && $status['status_po']=='1')
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='18',
						STATUS_FORM_DIR='18',
						REMARKS_DIR='$status[REMARKS]',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						APPROVEDIR_BY = '$status[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
		if($this->db->query($sql))
		
			{
				$ack = 5;
			}
		}
		
		
		if($ack == 5){
		//notif diterima oleh rm
		if  ($status['STATUS']=='1' && (($status['status_id']=='0' && $status['this_id'] == $status['approvalgr']) || ($status['status_id']=='0' && $status['this_id'] != $status['approvalgr'] && $status['this_id'] == $status['DIR_APPROVE']) || $status['status_id']=='11'))
		{
		$tujuan = $status['FINAL_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['FINAL_APPROVE_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		
		//rm tidak sama dengan group cc
		if ($status['STATUS']=='1' && $status['status_id']=='0' && $status['this_id'] != $status['approvalgr'] && $status['this_id'] != $status['DIR_APPROVE'])
		{
		$tujuan = $status['approvalgr_email']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['approvalgr_name']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}

	//notif diterima ke finance
		if($status['STATUS']=='1' && $status['status_id']=='3')
		{
		$tujuan = $status['PURCHASE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['PURCHASE_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }				
			}

		
		//Mengirimkan notifikasi diterima ke dir (approve purchase)
		if ($status['STATUS']=='1' && $status['status_id']=='1') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$tujuan = $status['DIR_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			
		}		
		else
			{
			$tujuan = $status['FINAL_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['FINAL_APPROVE_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
	}

	//notif diterima ke finance
		if($status['STATUS']=='1' && $status['status_id']=='2')
		{
		$tujuan = $status['FINAL_APPROVE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['FINAL_APPROVE_NAME']."</b>, <br><br>
                 ".$status['DIR_APPROVE']." <b> Approved </b> ".$status['REQUESTER_NAME']." application  for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }				
			}
				
		}
		if($ack == 5)
		if ($status['status_id']=='3' ){
		$sql = "	UPDATE 
						tb_r_pr 
					SET 
						STATUS='1',
						
						REMARK_DOC = '$status[REMARKS]'
					WHERE 
						PR_ID ='$status[FORM_ID]'";
		
		}
				
		if($this->db->query($sql))
		{
				$ack = 6;
			}
			
		if($ack == 6)
		{
		if($status['STATUS']=='1' && $status['status_id']=='1')
		{
		//notif diterima ke finance
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
										 
			}
			
		if($status['STATUS']=='1' && $status['status_id']=='2')
		{
		$tujuan = $status['PURCHASE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['PURCHASE_EMAIL']."</b>, <br><br>
                 ".$status['DIR_APPROVE']." <b> Approved </b> ".$status['REQUESTER_NAME']." application  for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		
		if($this->db->query($sql))
			{
				$ack = 7;
			}
		
		if($ack == 7)
			{
			
		if ($status['STATUS']=='1' && $status['status_id']=='1')
		{
			
		$sql = "	UPDATE 
						tb_r_pr 
					SET 
						C_TYPE = '$status[C_TYPE]',
						B_STATUS = '$status[B_STATUS]',
						DOWN_PAYMENT = '$status[JML1]',
						DATE_1PAYMENT = '$status[TGL1]',
						REMARK_P1 = '$status[R1]',
						2ND_PAYMENT = '$status[JML2]',
						DATE_2PAYMENT = '$status[TGL2]',
						REMARK_P2 = '$status[R2]',
						3RD_PAYMENT = '$status[JML3]',
						DATE_3PAYMENT = '$status[TGL3]',
						REMARK_P3 = '$status[R3]',
						FINAL_PAYMENT = '$status[JML4]',
						DATE_4PAYMENT = '$status[TGL4]',
						REMARK_P4 = '$status[R4]'
					WHERE 
						PR_ID ='$status[FORM_ID]'";
			
				
			}
		
		
		if($status['STATUS']=='1' && $status['status_id']=='2')
		
		{
		//notif diterima ke finance
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
			}
		if($this->db->query($sql))	
		{
				$ack = 8;
			}
			}
		if($ack == 8 && $status['STATUS']=='1' && $status['status_id']=='1')
		{
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> approved </b> Purchase Request that you have been revised.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		
			{
				$ack = 9;
			}
		}
		
		if($ack == 9){
		if($status['STATUS']=='1' && ($status['status_id']=='1' || $status['status_id']=='17'))
		{
		$sql = "	UPDATE 
						tb_r_shipto
					SET 
						S_COMPANY = '$status[S_COMPANY]',
						S_ADDRESS = '$status[S_ADDRESS]',
						S_CP = '$status[S_CP]',
						S_TELP = '$status[S_TELP]',
						S_EMAIL = '$status[S_EMAIL]',
						S_NPWP = '$status[S_NPWP]'
					WHERE 
						SHIPTO_ID ='$status[FORM_ID]'";
		if($this->db->query($sql))
		
		{
				$ack = 10;
			}
		}
		}		
		if($ack == 10){
		if($status['STATUS']=='1' && ($status['status_id']=='1' || $status['status_id']=='17'))
		{
		$sql = "	UPDATE 
							tb_r_vendor
					SET 
						COMPANY= '$status[COMPANY]',
						ATTN = '$status[ATTN]',
						ADDRESS = '$status[ADDRESS]',
						CITY = '$status[CITY]',
						PHONE = '$status[PHONE]',
						ZIP = '$status[ZIP]',
						FAX = '$status[FAX]'
					WHERE 
						ID_VENDOR ='$status[FORM_ID]'";
		if($this->db->query($sql))
		
		{
				$ack = 11;
			}
		}
		}
		
		
		
		return $ack;
	
	}
	}
	

//ambil idPR
	function getPR_ID($form_id){	
		$sql = "SELECT
					PR_ID					
				FROM
                    tb_r_pr
                WHERE
                     EMPLOYEE_ID = '$form_id'";
		return fetchArray($sql, 'one');
	}

function get_list_doc($form_id)
	{
	$sql = "SELECT 	
					NAMAFILE namafile,
					DOCCUMENT document
			FROM documment
			where PR_ID = '$form_id'";
	return fetchArray($sql, 'all');
	}
	
function save_revise($status)
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
								('$status[PURCHASE]',
								 '$status[REQUESTER]',
								 '4',
						         '$status[FORM_TYPE_ID]',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								 
								 if($this->db->query($sql))
		{
				$ack = 1;
		}
		
		if($ack == 1)
		{
		$tujuan = $status['PURCHASE_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['PURCHASE_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> " .$status['status_name']."</b> application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
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

		
		if($ack == 2){
		if ($status['status_id']=='14')
		{
		//accept by Purchase
		
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='17',
						STATUS_FORM_REVISE='17',
						REMARKS_REVISE ='$status[REMARKS]',
						PUR_APPROVE = '$status[PURCHASE]',
						REVISE_CREATED_BY = '$status[this_name]',
						REVISE_CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		
		}
		
		if($status['status_id'] == '17' && $status['STATUS']=='1' && $status['status_po']=='0' ){
		if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						STATUS_FORM_REVISE_APPROVEPUR='2',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						REMARKS_REVISE_APPROVEPUR='$status[REMARKS]',
						REVISE_APPROVEPUR_BY = '$status[this_name]',
						REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
			}
		else
			{
			
								 
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='15',
						STATUS_FORM_REVISE_APPROVEPUR='15',
						PUR_APPROVE = '$status[PURCHASE]',
						REMARKS_REVISE_APPROVEPUR='$status[REMARKS]',
						REVISE_APPROVEPUR_BY = '$status[this_name]',
						REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
						
			
		}
			
		}
		
		if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='1')
		{
		if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						STATUS_FORM_REVISE_APPROVEPUR='2',
						DIR_APPROVE = '$status[DIR_APPROVE]',
						REMARKS_REVISE_APPROVEPUR='$status[REMARKS]',
						REVISE_APPROVEPUR_BY = '$status[this_name]',
						REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
		}
		
		else
			{
			
								 
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='18',
						STATUS_FORM_REVISE_APPROVEPUR='18',
						PUR_APPROVE = '$status[PURCHASE]',
						REMARKS_REVISE_APPROVEPUR='$status[REMARKS]',
						REVISE_APPROVEPUR_BY = '$status[this_name]',
						REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";
			
			
		}
		}
		
		if ($status['STATUS']=='2' && $status['status_id']=='17')
		{ 
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='7',
						STATUS_FORM_REVISE_APPROVEPUR='7',
						REMARKS_REVISE_APPROVEPUR='$status[REMARKS]',
						REVISE_APPROVEPUR_BY = '$status[this_name]',
						REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						FORM_TYPE_ID = '$status[FORM_TYPE_ID]' AND
						FORM_ID ='$status[FORM_ID]'";	
		}
		
		
			if($this->db->query($sql))
			{
			$ack = 3;
			}
		}
		
		if($ack == 3)
		{
		if ($status['status_id']=='14')
		{
		$sql = "UPDATE 
						tb_r_pr
					SET 
						DIBUAT_PO ='$status[status_po]',
						REMARK ='$status[REMARKS]',
						UPDATED_BY = '$status[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE 
						PR_ID ='$status[FORM_ID]'";	
		}
		if($this->db->query($sql))
		{
		$ack = 4;
		}
		}
		
		if($ack == 4)
		{
		if($status['STATUS']=='1' && $status['status_id']=='17')
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
		}
		
		if($status['STATUS']=='2' && $status['status_id']=='17')
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
								 '1',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";

		}
		
		if($this->db->query($sql))	
		{
				$ack = 5;
			}
		}
		
		if($ack == 5 && $status['STATUS']=='1' && ($status['status_id']=='1' || $status['status_id']=='17'))
		{
		$sql = "	UPDATE 
							tb_r_vendor
					SET 
						COMPANY= '$status[COMPANY]',
						ATTN = '$status[ATTN]',
						ADDRESS = '$status[ADDRESS]',
						CITY = '$status[CITY]',
						PHONE = '$status[PHONE]',
						ZIP = '$status[ZIP]',
						FAX = '$status[FAX]'
					WHERE 
						ID_VENDOR ='$status[FORM_ID]'";
		if($this->db->query($sql))
		
		{
				$ack = 6;
			}
		}	
		if($ack == 6 && $status['STATUS']=='1' && ($status['status_id']=='1' || $status['status_id']=='17'))
		{
		$sql = "	UPDATE 
						tb_r_shipto
					SET 
						S_COMPANY = '$status[S_COMPANY]',
						S_ADDRESS = '$status[S_ADDRESS]',
						S_CP = '$status[S_CP]',
						S_TELP = '$status[S_TELP]',
						S_EMAIL = '$status[S_EMAIL]',
						S_NPWP = '$status[S_NPWP]'
					WHERE 
						SHIPTO_ID ='$status[FORM_ID]'";
		if($this->db->query($sql))
		
		{
				$ack = 7;
			}
		}
		
		if($ack==7){
		if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='0') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$tujuan = $status['DIR_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			
		}		
		else
			{
			$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> approved </b> Purchase Request that you have been revised.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
	}
	
	if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='1') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$tujuan = $status['DIR_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted </b> an application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			
		}		
		else
			{
			$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> Has been approved </b> Purchase Request that you have been revised.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
	}
	
		if ($status['STATUS']=='2' && $status['status_id']=='17') {
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['PURCHASE_NAME']." <b> Has Been Rejected </b> Purchase Request that you have revised.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		
		
		}
		
		
		if($this->db->query($sql))
			{
				$ack = 8;
			}
		}
		if($ack == 8)
			{
			
			if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='0') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$tujuan = $status['DIR_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Sumitted  </b> Application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			
		}	
			
			}
			
		if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='1') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT'] && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
			{
			$tujuan = $status['DIR_EMAIL']; //mengambil email requester
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['DIR_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted  </b> Application for Purchase Request.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Request</a><br><br>
                *Do not reply this email. <br><br>
                </div>";	
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Request \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			
		}	
			
			}
			{
				$ack = 9;
			}
		}
		
		if($ack == 9)
		{
		if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='0') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
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
								 '4',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
			}
			else
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
								 '4',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
		}
			}
			
		if ($status['STATUS']=='1' && $status['status_id']=='17' && $status['status_po']=='1') {
			//notif to dir 
			if (($status['AMOUNT'] >= $status['LIMIT']   && $status['DIVID'] !='SALES' ) || $status['DIVID'] =='SALES' )
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
								 '4',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
			}
			else
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
								 '4',
						         '4',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         '$status[this_name]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
			
		}
			}
		if($this->db->query($sql))
			{
			$ack = 10;
			}
		}
		
		
		return $ack;
		
	}
}











