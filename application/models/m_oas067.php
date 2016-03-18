  <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS067
* Program Name     : Form Approval  BT (GA)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati(Transportation) & Winni Oktaviani (Acomodation)
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS067 extends CI_Model {
	
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
                       usr.USER_EMAIL employee_email, 
                       bt.BT_ID bt_id,
                       bt.EMPLOYEE_ID submitter,
                       (select app.EMPLOYEE_NAME from tb_m_employee app where app.EMPLOYEE_ID = bt.EMPLOYEE_ID )  submitter_name, 
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
                       fs.REMARKS_DIR remarks_ga,
                       fs.UPDATED_DT accepted_dt,
                       fs.UPDATED_BY accepted_by,
					   fs.REVISE_REMARKS_F2 remarks_revise,
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
						tb_r_bt bt,
						tb_m_position_level dim,
                        tb_m_charge_code cc,
                        tb_m_ca_cost cost,
					    tb_m_user usr,
					    tb_m_system sys
				    
				WHERE
					    bt.BT_ID = '$form_id' AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
						empl.LEVEL_ID = dim.LEVEL_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cc.CHARGE_CODE = bt.CHARGE_CODE AND
                        cost.COST_ID = bt.DESTINATION AND                   
					    sys.SYS_CAT = '21' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'";	
		return fetchArray($sql, 'row');
	}
	
	//mengambil data transport
	
	function get_list_tr($bt)
	{
		$sql = "SELECT 	bt.BT_ID bt_id,
						tr.TRANSPORTATION_ID transport_id,
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
	$sql = "SELECT VALUE, SUBSTRING(SYS_CD,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24'
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	function list_h_m_h(){
	$sql = "SELECT VALUE, SUBSTRING(VALUE,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24' AND
            VALUE < 25 AND VALUE !=0 
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	
	function transport_save($data)
	{
		$this->db->query( "INSERT INTO tb_r_transportation 
								(BT_ID,
                                DESTINATION,
                                TRANSPORTATION,
                                TRANSPORTATION_CLASS,
                                ARRIVAL_DATE_IN_DESTINATION,
                                A_HOUR_D,
								A_MINUTE_D,
								DEPARTURE_FROM_THE_REGION_OF_ORIGIN,
                                D_HOUR_D,
								D_MINUTE_D,
								
								PRICE_ARRIVAL,
                                REMARK)
VALUES ('$data[BT_ID]',
       '$data[DESTINATION]',
       '$data[TRANSPORTATION]',
       '$data[TRANSPORTATION_CLASS]',
       '$data[ARRIVAL_DATE_IN_DESTINATION]',
	   '$data[A_HOUR_D]',
	   '$data[A_MINUTE_D]',
       '$data[DEPARTURE_FROM_THE_REGION_OF_ORIGIN]',
	   '$data[D_HOUR_D]',
	   '$data[D_MINUTE_D]',
     
       '$data[PRICE_ARRIVAL]',
       '$data[REMARK]')");
	}
	
	
	function konfirmGA_save($data)
	{
		
	$ack=0;
	if ( $data['status_id']=='10'){
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
								('$data[GA2]',
								 '$data[GA]',
								 '4',
						         '3',
						         '$data[BT_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}
	else { $sql="INSERT INTO
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
								 '10',
						         '3',
						         '$data[BT_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";}	
		if($this->db->query($sql))
		{
				$ack = 1;
		} 
		if($ack == 1)
		{
		if ( $data['status_id']=='10'){
		$tujuan = $status['GA2_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['GA2_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted</b> application for Bussiness Travel.</p>
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
	else { $tujuan = $status['REQUESTER_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['REQUESTER_NAME']."</b>, <br><br>
                 ".$status['this_name']." <b> Approve </b> your Bussiness Travel.</p>
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
        }}
		{
				$ack = 2;
		}
		
		}
		
		if($ack == 2)
		{
		//approve RM 
		$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='2',
						 REMARKS_DIR='$data[REMARK]',
						FINAL_APPROVE='$data[GA2]',
						APPROVEDIR_BY = '$data[this_name]',
						APPROVEDIR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE 
						FORM_TYPE_ID = '3'AND
						FORM_ID='$data[BT_ID]'";
						
		if($this->db->query($sql))
			{
				$ack =3;
			}
		
		}
		
		if($ack == 3 && $data['status_id']!='10' )
		{
		//approve RM 
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
								('$data[GA2]',
								 '$data[REQUESTER]',
								 '0',
						         '3',
						         '$data[BT_ID]',
						         'No. Ref: $data[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
		if($this->db->query($sql))
			{
				$ack = 4;
			}
		
		}
		if($ack == 4 && $data['status_id']!='10' )
		{
		//approve RM 
		$tujuan = $status['GA2_EMAIL']; //mengambil email requester
        $judul = "Bussiness Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$status['GA2_NAME']."</b>, <br><br>
                 ".$status['REQUESTER_NAME']." <b> Submitted</b> application for Bussiness Travel.</p>
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
			{
				$ack = 5;
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
		$sql = "SELECT 	ac.ACCOMODATION_ID ac_id,
						bt.BT_ID bt_id,
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
	
	function accomodation_save($data)
	{
		$this->db->query( "INSERT INTO tb_r_accomodation 
								(BT_ID,
                                HOTEL_NAME,
                                BOOKING_NAME,
                                ADDRESS,
                                CHECKIN_DATE,
                                CHECKIN_HOUR,
								CHECKIN_MINUTE,
								CHECKOUT_DATE,
                                CHECKOUT_HOUR,
								CHECKOUT_MINUTE,
								ROOM_RATE,
								REMARKS)
VALUES ('$data[BT_ID]',
       '$data[HOTEL_NAME]',
       '$data[BOOKING_NAME]',
       '$data[ADDRESS]',
	   '$data[CHECKIN_DATE]',
	   '$data[CHECKIN_HOUR]',
       '$data[CHECKIN_MINUTE]',
	   '$data[CHECKOUT_DATE]',
	   '$data[CHECKOUT_HOUR]',
       '$data[CHECKOUT_MINUTE]',
	   '$data[ROOM_RATE]',
	   '$data[REMARKS]')");
	}
	
	function delete_accomodation($acid)
	{
		$this->db->query( " DELETE FROM tb_r_accomodation
						WHERE
							ACCOMODATION_ID = '$acid'");
	}
	
	function delete_transportation($trid)
	{
		$this->db->query( " DELETE FROM tb_r_transportation
						WHERE
							TRANSPORTATION_ID = '$trid'");
	}
}