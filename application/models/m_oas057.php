 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS057
* Program Name     : Form Approval  BT (RM and Finance)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS057 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//mengambil data 
	function get_form_detail($form_id)
	{
		$sql = "SELECT
						
                       bt.REF_NO no_ref,
                       empl.EMPLOYEE_NAME employee_name,
					   empl.EMPLOYEE_ID employee_id,
					   (SELECT CASE WHEN bt.DESTINATION = '1' then dim.DIM_AMOUNT
                       WHEN bt.DESTINATION = '2' then dim.DIM_AMOUNT_DOMESTIK WHEN bt.DESTINATION = '3' then dim.DIM_AMOUNT_INTERNATIONAL END) dim_amount,
                       ca.CA_ID ca_id,
					   ca.REF_NO no_ref_ca,
                       usr.USER_EMAIL employee_email, 
                       bt.BT_ID bt_id,
                       bt.EMPLOYEE_ID submitter,
                       (select app.EMPLOYEE_NAME from tb_m_employee app where app.EMPLOYEE_ID = bt.EMPLOYEE_ID )  submitter_name, 
                       (select us.USER_EMAIL from tb_m_user us where us.EMPLOYEE_ID = bt.EMPLOYEE_ID )  submitter_email, 
                       bt.CLIENT_NAME client_name,
                       bt.CUSTOMER_LOCATION customer_location,
                       bt.TRANSPORTATION_BY transport_id,
                       (select ref.VALUE from tb_m_system ref  where ref.SYS_CAT= '20' and ref.SYS_CD = bt.TRANSPORTATION_BY)  transport_name,
					   bt.CHARGE_CODE chargecode,
                       (select ref.VALUE from tb_m_system ref where ref.SYS_CAT= '11' and ref.SYS_CD = cc.TYPE ) typecc_name, 
					   cc.PROJECT_DESCRIPTION cc_name,
					   fs.TARGET_EMPLOYEE_ID aprove,  
                       (select app.EMPLOYEE_NAME from tb_m_employee app where app.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
                       bt.BUSINESS_PURPOSE purpose,
                       bt.DESTINATION destination,
                       cost.DESTINATION destination_name,
                       bt.CURRENCY currency_id,
					   (select ref.VALUE from tb_m_system ref  where ref.SYS_CAT= '16' and ref.SYS_CD = bt.CURRENCY )  currency_name,
                       bt.PAYMENT_METHOD pay_method,
                       (select ref.VALUE from tb_m_system ref  where ref.SYS_CAT= '17' and ref.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
                       bt.DEPARTURE departure,
                       bt.RETURN_DATE return_date,
                       bt.DURATION duration,
                       bt.CREATED_DT submitted_dt,
					   bt.REMARK remarks,
                       bt.TRANSPORTAMOUNT transport_amount, 
                       sys.VALUE status,
					   fs.STATUS status_id,
                       fs.CREATED_DT approved_dt,
                       fs.CREATED_BY approved_by,
                       fs.REMARKS remarks_approval,
                       fs.APPROVEDIR_DT approvedga_dt,
                       fs.APPROVEDIR_BY approvedga_by,
					   fs.APPROVEF2_DT approvedhead_dt,
					   fs.APPROVEF2_BY approvedhead_by,
					   fs.REMARKS_F2 remarks_head,
					   fs.APPROVEPUR_DT approvedgahead_dt,
					   fs.APPROVEPUR_BY approvedgahead_by,
					   fs.PUR_APPROVE remarks_gahead,
					   fs.REVISE_APPROVEF2_DT reviseapprovehead_dt,
					   fs.REVISE_APPROVEF2_BY reviseapprovehead_by,
					   fs.REVISE_REMARKS_F2 reviseremarkshead,
					   fs.REVISE_APPROVAL_DT reviseapprovegroup_dt,
					   fs.REVISE_APPROVAL_BY reviseapprovegroup_by,
					   fs.REVISE_APPROVAL_REMARKS reviseremarksgroup,
					   fs.REVISE_APPROVEPUR_DT revisereq_dt,
					   fs.REVISE_APPROVEPUR_BY revisereq_by,
					   fs.REMARKS_REVISE_APPROVEPUR revisereqremark,
                       fs.REMARKS_DIR remarks_ga,
                       fs.UPDATED_DT accepted_dt,
                       fs.UPDATED_BY accepted_by
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_m_position_level dim,
						tb_r_ca ca,
						tb_r_bt bt,
                        tb_m_charge_code cc,
                        tb_m_ca_cost cost,
					    tb_m_user usr,
					    tb_m_system sys
				    
				WHERE
					    bt.BT_ID = '$form_id' AND
					    empl.LEVEL_ID = dim.LEVEL_ID AND
						ca.BT_ID=bt.BT_ID AND
						bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cc.CHARGE_CODE = bt.CHARGE_CODE AND
                        cost.COST_ID = bt.DESTINATION AND                   
					    sys.SYS_CAT = '21' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'";	
		return fetchArray($sql, 'row');
	}

	function save_confirmation($status)
	{
	//notif to requester
		$ack=0;
		if ($status['STATUS']=='3')
		{
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
								('$status[CREATED]',
								 '$status[SENDER_EMPLOYEE_ID]',
								 '$status[ACTIVITY_TYPE_ID]',
						         '3',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		}
			 else {
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
						         '3',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								 }
		if($this->db->query($sql))
		{
				$ack = 1;
		} 
		if($ack == 1 ){
		//notif to GA
		if ($status['STATUS']=='3')
		{
		$tujuan = $status['CREATED_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['CREATED_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> Ask for revise your</b> your application for Bussiness Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Bussiness Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Bussiness Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }	
		}
			 else {
								$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> " .$status['status_name']."</b> your Bussiness Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Bussiness Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Bussiness Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
								 }
		
		{
				$ack = 2;
		}
		}
		
		if($ack == 2 ){
			if($ack==2 &&($status['status_id']=='0' || $status['status_id']=='3')){
		$sql = "DELETE FROM 
							tb_r_notification
				WHERE
						SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
						FORM_TYPE_ID = '3' AND
						FORM_ID = '$status[FORM_ID]'";
						}
		else{
		$sql = "DELETE FROM
							tb_r_notification
				WHERE
						RECIPIENT_EMPLOYEE_ID = '$status[this_id]' AND
						SENDER_EMPLOYEE_ID = '$status[REQUESTER]' AND
						FORM_TYPE_ID = '3' AND
						FORM_ID = '$status[FORM_ID]'";
			
			}
			if($this->db->query($sql))
		
		{
				$ack = 3;
		}
		}
					
			if($ack == 3 ){
		//notif to GA
		if ($status['STATUS']=='1')
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
								('$status[GA]',
								 '$status[REQUESTER]',
								 '0',
						         '3',
						         '$status[FORM_ID]',
						         'No. Ref: $status[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $status[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
}

//reject by RM
if ($status['STATUS']=='2' )
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='6',
						REMARKS='$status[REMARKS]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID ='$status[FORM_ID]'";	
}
//need to be revise
if ($status['STATUS']=='3'){
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='7',
						REVISE_APPROVAL_REMARKS='$status[REMARKS]',
						CREATED_BY = '-',
						REVISE_APPROVAL_BY = '$status[this_name]',
						REVISE_APPROVAL_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID ='$status[FORM_ID]'";
						}
			if($this->db->query($sql))
			{
				$ack = 4;
			}
		}
		
		if($ack == 4 && $status['STATUS'] !='3')
		{
		if ($status['STATUS']=='1'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='1',
						REMARKS='$status[REMARKS]',
						DIR_APPROVE = '$status[GA]',
						FINAL_APPROVE = '$status[GA]',
						CREATED_BY = '$status[this_name]',
						CREATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID ='$status[FORM_ID]'";}
		if ($status['STATUS']=='2'){
		$sql = "UPDATE 
						tb_r_ca 
					SET 
						STATUS='2'
					WHERE 
						
						CA_ID  ='$status[CA_ID]'";}

			if($this->db->query($sql))
			{
				$ack = 5;
			}
		}
		if($ack == 5 && $status['STATUS']=='1' ){
		$tujuan = $status['GA_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['GA_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b>Submitted </b> application for Bussiness Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Bussiness Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Bussiness Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		{
				$ack = 6;
		}
		}
			return $ack;

	} 
	
	function get_list_tr($bt)
	{
		$sql = "SELECT 	bt.BT_ID bt_id,
						bt.TRANSPORTATION_BY tr_by,
						(select sys.value from tb_m_system sys where sys.SYS_CAT = '20' and sys.SYS_CD = bt.TRANSPORTATION_BY) trby_name, 
						tr.DESTINATION destination,
						tr.TRANSPORTATION transport_name,
						tr.TRANSPORTATION_CLASS class,
						tr.ARRIVAL_DATE_IN_DESTINATION tgl_berangkat,
						tr.A_HOUR_D jam_berangkat,
						tr.A_MINUTE_D menit_berangkat,
						tr.DEPARTURE_FROM_THE_REGION_OF_ORIGIN tgl_sampe_des,
						tr.D_HOUR_D jam_sampe_des,
						tr.D_MINUTE_D menit_sampe_des,
						
						tr.PRICE_ARRIVAL price_arrival,
						tr.REMARK remark
				FROM 	tb_r_bt bt,
						tb_r_transportation tr
				WHERE 	bt.BT_ID = tr.BT_ID AND
						bt.BT_ID = '$bt'";	
		return fetchArray($sql, 'all');
	}
	
	function list_class(){
	$sql = "SELECT VALUE class
				FROM 	tb_m_system
            WHERE SYS_CAT='23'";	
		return fetchArray($sql, 'all');
	}
	
	function list_h_m(){
	$sql = "SELECT VALUE, SUBSTRING(VALUE,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24'
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	function list_h_m_h(){
	$sql = "SELECT VALUE, SUBSTRING(VALUE,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24' AND
            VALUE < 25
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	
	function accepted_save($data)
	{
		
	$ack=0;
	if ($data['STATUS']=='3'){	
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
								('$data[GA]',
								 '$data[GA2]',
								 '3',
						         '3',
						         '$data[BT_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";}
else{								 
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
								('$data[REQUESTER]',
								 '$data[SENDER_EMPLOYEE_ID]',
								 '1',
						         '3',
						         '$data[BT_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}
		if($this->db->query($sql))
		{
				$ack = 1;//baru ganti jam setengah 2 activity dari 1 jadi 2
		} 
		if($ack == 1)
		{
		if ($data['STATUS']=='3'){
		$tujuan = $status['GA_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['GA_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> Ask for revise </b> an application for Bussiness Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Bussiness Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Bussiness Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }	
		}
else{								 
		$tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> " .$status['status_name']."</b> your Bussiness Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Detail Bussiness Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Bussiness Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
		}
		{
				$ack = 1;
		} 
		
		}
		
		if($ack == 1)
		{
		//approve RM 
		if ($data['STATUS']=='1'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						
						APPROVEPUR_BY = '$data[this_name]',
						PUR_APPROVE = '$data[REMARK]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID='$data[BT_ID]'";}
		if ($data['STATUS']=='2'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						
						APPROVEPUR_BY = '$data[this_name]',
						PUR_APPROVE = '$data[REMARK]',
						APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID='$data[BT_ID]'";}
		if ($data['STATUS']=='3'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='10',
						REVISE_REMARKS_F2 ='$data[REMARK]',
						REVISE_APPROVEF2_BY = '$data[this_name]',
						REVISE_APPROVEF2_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID='$data[BT_ID]'";}
						
		if($this->db->query($sql))
			{
				$ack =2;
			}
		
		}
		
		if($ack == 2 && $data['STATUS']!='3')
		{
		//approve RM 
		
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
											('$data[BT_ID]',
											 '3',
											 '$data[SENDER_EMPLOYEE_ID]',
											 '$data[STATUS]',
											 '$data[REMARK]',
											 '$data[this_name]',
											 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		
		if($this->db->query($sql))
			{
				$ack = 3;
			}
		
		}
		if($ack == 3 && $data['STATUS']!='3')
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
											('$data[CA_ID]',
											 '2',
											 '$data[SENDER_EMPLOYEE_ID]',
											 '$data[STATUS]',
											 '$data[REMARK]',
											 '$data[this_name]',
											 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
					
		if($this->db->query($sql))
			{
				$ack = 4;
			}
		
		}
		if($ack == 4 && $data['STATUS']!='3')
		{
		//approve RM 
		if ($data['STATUS']=='1'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='3',
						
						UPDATED_BY = '$data[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID='$data[CA_ID]'";}
		if ($data['STATUS']=='2'){
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='4',
						
						UPDATED_BY = '$data[this_name]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID='$data[CA_ID]'";}
		if($this->db->query($sql))
			{
				$ack = 5;
			}}
		if($ack == 5 && $data['STATUS']!='3')
		{
		if ($data['STATUS']=='1'){
		$sql = "UPDATE 
						tb_r_bt 
					SET 
						TOTAL_AMOUNT_TRANSPORTATION='$data[TOTAL_AMOUNT_TRANSPORTATION]',
						TOTAL_AMOUNT_ACOMODATION='$data[TOTAL_AMOUNT_ACOMODATION]',
						TOTAL_AMOUNT_BT = '$data[TOTAL_AMOUNT_BT]'
					WHERE 

						BT_ID ='$data[BT_ID]'";}
		if ($data['STATUS']=='2'){
		$sql = "UPDATE 
						tb_r_ca 
					SET 
						STATUS='2'
					WHERE 
						
						CA_ID  ='$data[CA_ID]'";}				

			if($this->db->query($sql))
			{
				$ack = 6;
			}
		}
			return $ack;
	}
	function get_employee_list()
	{
		$sql = "SELECT
					emp.EMPLOYEE_ID,
					emp.EMPLOYEE_NAME
					
				FROM
					tb_m_employee emp,
					tb_m_user usr
					
				WHERE
				emp.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
               usr.USER_STATUS ='1'
				
				ORDER BY emp.EMPLOYEE_NAME";
		return fetchArray($sql, 'all');
	}
	function get_list_ac($bt)
	{
		$sql = "SELECT 	bt.BT_ID bt_id,
						ac.HOTEL_NAME hotel_name,
                        ac.BOOKING_NAME booking_name,
                        ac.ADDRESS address,
                        ac.CHECKIN_DATE ci_date,
                        ac.CHECKIN_HOUR ci_hour,
                        ac.CHECKIN_MINUTE ci_minute,
                        ac.CHECKOUT_DATE co_date,
                        ac.CHECKOUT_HOUR co_hour,
                        ac.CHECKOUT_MINUTE co_minute,
                        ac.ROOM_RATE room_rate,
                        ac.REMARKS remarks
				FROM 	tb_r_bt bt,
						tb_r_accomodation ac
				WHERE 	bt.BT_ID = ac.BT_ID AND
						bt.BT_ID = '$bt'";	
		return fetchArray($sql, 'all');
	}
	
	
}