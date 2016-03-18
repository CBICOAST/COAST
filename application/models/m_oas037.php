<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS037
* Program Name     : Form Pengajuan Business Travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 9:19:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS037 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	// cek apakah user masih mempunyai pengajuan BT yg aktif
	function cek_status_open($employeeID){	
		$sql = "SELECT 
					COUNT(EMPLOYEE_ID) jumlah
				FROM
					tb_r_ca ca,
                    tb_r_form_status fs
				WHERE
				 	ca.STATUS = 1 AND
                    ca.SETTLEMENT_STATUS = '0' AND
                    fs.FORM_TYPE_ID = '3' AND
                    fs.FORM_ID = ca.CA_ID AND
                    fs.STATUS = '0' AND
					ca.EMPLOYEE_ID ='".$employeeID."'
					";
		return fetchArray($sql, 'one');
	}
	
	function get_approval($data)
	{
		$sql = "SELECT 
						empl.EMPLOYEE_ID id
				FROM 
						tb_m_employee empl
				WHERE 
						empl.POSITION_DEPTH_ID = '2' AND
						empl.GROUP_ID = '$data'";
		return fetchArray($sql, 'one');
	}
	
	function get_ccode_list($cctype_id = '')
	{
		$sql = "SELECT
							pos.CHARGE_CODE id,
							pos.PROJECT_DESCRIPTION name
							
							
				FROM
							tb_m_charge_code pos 
				WHERE
							pos.STATUS = '1'";

		if($cctype_id !=''){
			$sql .= "AND pos.TYPE = '$cctype_id' ";	
		}
		return fetchArray($sql, 'all');
	}
	
	function get_cctype($divid)
	{
		$sql = "SELECT 
						sys.SYS_CD
				FROM 
					    tb_m_ca_type ct,
                        tb_m_charge_code cc,
                        tb_m_system sys
				WHERE 
                        cc.CHARGE_CODE = '$divid' AND
                        cc.TYPE = sys.SYS_CD AND
                        sys.SYS_CAT = '11' AND
						ct.CA_CATEGORY='2'
                GROUP BY 
                        sys.SYS_CD ";
		return fetchArray($sql, 'one');
		}
	function get_cctype_list()
	{
		$sql = " SELECT
							sys.SYS_CD id,
							sys.VALUE name
							
							
				FROM
							tb_m_system sys,
                            tb_m_charge_code cc 
				WHERE
							sys.SYS_CAT = '11' AND
                            sys.SYS_CD = cc.TYPE 
                GROUP BY    sys.SYS_CD ";
		return fetchArray($sql, 'all');
	}
	// Ambil tipe Cash Advance
	function get_ca_list(){	
		$sql = "SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type
                WHERE 	
					CA_CATEGORY = '1'";
		return fetchArray($sql, 'all');
	}
	
	// Ambil nama karyawan
	function get_name_list(){	
		$sql = "SELECT
					emp.EMPLOYEE_ID id,
					emp.EMPLOYEE_NAME name
					
				FROM
					tb_m_employee emp,
					tb_m_user usr
					
				WHERE
				emp.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
               usr.USER_STATUS ='1'
				
				ORDER BY emp.EMPLOYEE_NAME
                ";
		return fetchArray($sql, 'all');
	}
	
	// Ambil tujuan perjalanan dinas
	function get_bt_destination_list(){	
		$sql = "SELECT
					COST_ID id,
					DESTINATION destination,
					COST cost
				FROM
					tb_m_ca_cost";
		return fetchArray($sql, 'all');
	}
	
	// Ambil transportation perjalanan dinas
	function get_bt_transportation_list(){	
		$sql = "SELECT
					SYS_CD id,
					VALUE transportation
				FROM
					tb_m_system
				where SYS_CAT = 20 ";
		return fetchArray($sql, 'all');
	}

	// Ambil biaya transportasi perjalanan dinas
	function get_cost_destination($destination){	
		$sql = "SELECT
					COST_ID id,
					DESTINATION destination,
                    pl.DIM_AMOUNT amountid,
					pl.DIM_AMOUNT_DOMESTIK amountid1,
					pl.DIM_AMOUNT_INTERNATIONAL amountid2,
					COST cost,
					COST_USD usd
				FROM
					tb_m_ca_cost,
                    tb_m_position_level pl 
                WHERE
                     COST_ID = '".$destination."'";
		return fetchArray($sql, 'all');
	}
	
	function get_traveller_group($traveller){	
		$sql = "SELECT
					emp.EMPLOYEE_ID id,
					emp.EMPLOYEE_NAME name,
                    emp.GROUP_ID groupid,
					emp.DIVISION_ID divisionid,
					emp.POSITION_DEPTH_ID posid,
                    pl.DIM_AMOUNT amountid,
					pl.DIM_AMOUNT_DOMESTIK amountid1,
					pl.DIM_AMOUNT_INTERNATIONAL amountid2,
					(select em.EMPLOYEE_ID from tb_m_employee em 
						where em.POSITION_DEPTH_ID <= '2' and em.GROUP_ID = emp.GROUP_ID) approval,
                     (select em.EMPLOYEE_NAME from tb_m_employee em 
						where em.POSITION_DEPTH_ID <= '2' and em.GROUP_ID = emp.GROUP_ID) approval_name,
                     (select us.USER_EMAIL from tb_m_employee em, tb_m_user us 
						where em.POSITION_DEPTH_ID <= '2' and em.GROUP_ID = emp.GROUP_ID and us.EMPLOYEE_ID = em.EMPLOYEE_ID) approval_email
				FROM
                    tb_m_employee emp,
                    tb_m_position_level pl    
                WHERE
                     emp.LEVEL_ID = pl.LEVEL_ID AND
                     emp.EMPLOYEE_ID = '".$traveller."'";
		return fetchArray($sql, 'all');
	}
	
	
	
	// Ambil tipe charge code 
	function get_charge_code_type()
	{
		$sql = " SELECT  
					sys.SYS_CD id,
					sys.VALUE value
				FROM
					tb_m_system sys,
					tb_m_charge_code cc
				WHERE
					sys.SYS_CAT = '11' AND
					cc.TYPE = sys.SYS_CD
                Group by sys.SYS_CD
					";
		return fetchArray($sql, 'all');
	}
	
	// Ambil charge code deskripsi berdasarkan tipe
	function get_project_description($id){	
		$sql = "SELECT
					CHARGE_CODE,
					PROJECT_DESCRIPTION,
					TYPE
				FROM
					tb_m_charge_code 
				WHERE
					TYPE = '".$id."' AND 					
					STATUS = '1'";
		return fetchArray($sql, 'all');
	}
	
	// Ambil daftar mata uang
	function get_currency_list(){	
		$sql = "SELECT
					SYS_CD id,
					VALUE name
				FROM
					tb_m_system
                WHERE 
					SYS_CAT = '16'";
		return fetchArray($sql, 'all');
	}
	
	function submitCaForm($data)
	{
		$ack = 0;
		$year = date("Y");
		$monthly = DATE("m");
		$formID = null;
		$refno = null;

		$month['01'] = 'I';
		$month['02'] = 'II';
		$month['03'] = 'III';
		$month['04'] = 'IV';
		$month['05'] = 'V';
		$month['06'] = 'VI';
		$month['07'] = 'VII';
		$month['08'] = 'VIII';
		$month['09'] = 'IX';
		$month['10'] = 'X';
		$month['11'] = 'XI';
		$month['12'] = 'XII';

		
		$sql = "INSERT INTO
							tb_r_bt (REF_NO,
										EMPLOYEE_ID,
										TRAVELLER_ID,
										CLIENT_NAME,
										BUSINESS_PURPOSE,
										CUSTOMER_LOCATION,
										TRANSPORTATION_BY,
										CHARGE_CODE,
										DESTINATION,
										DEPARTURE,
										RETURN_DATE,
										DURATION,
										AMOUNTDIM,
										PAYMENT_METHOD,
										REMARK,
										APPROVAL,
										CREATED_BY,
										CREATED_DT,
										TRANSPORTAMOUNT)
				VALUES
							(CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_bt bt WHERE YEAR(bt.CREATED_DT) = '$year') +1,3),
				                    '/$data[code]-BT/',
				                    '$month[$monthly]/',
				                    '$year'),
							 '$data[EMPLOYEE_ID]',
							 '$data[TRAVELLER]',
							 '$data[CLIENT_NAME]',
							 '$data[BUSINESS_PURPOSE]',
							 '$data[CUSTOMER_LOCATION]',
							 '$data[TRANSPORTATION_BY]',
							 '$data[CHARGE_CODE]',
					         '$data[DESTINATION]',
							 '$data[DEPARTURE]',
					         '$data[RETURN_DATE]',
					         '$data[DURATION]',
							 '$data[AMOUNTDIM]',
					         '$data[PAYMENT_METHOD]',
					         '$data[REMARKS]',
							 '$data[APPROVAL]',
							 'user: $data[EMPLOYEE_EMAIL]',
					         '$data[SUBMITTED_DATE]',
					         '$data[TRANSPORT]')";
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		
		if($ack == 1){
			$formID = $this->getFormId($data['EMPLOYEE_ID'], $data['DEPARTURE'],$data['CHARGE_CODE'],$data['TRANSPORT']);
			$refno = $this->getRefNo($formID);
			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('3',
								 '$formID',
								 '$data[APPROVAL]',
						         '0')";
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		if($ack == 2){
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
								('$data[APPROVAL]',
								 '$data[TRAVELLER]',
								 '0',
						         '3',
						         '$formID',
						         'No. Ref: $refno',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $data[EMPLOYEE_EMAIL]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
			if($this->db->query($sql))
			{
				$ack = 3;
			}	
		}
		
		if($ack == 3){
			$sql = "INSERT INTO
							tb_r_ca (REF_NO,
										BT_ID,
										EMPLOYEE_ID,
										CA_TYPE_ID,
										CHARGE_CODE,
										DESTINATION,
										CURRENCY,
										AMOUNT,
										PAYMENT_METHOD,
										REMARK,
										STATUS,
										SETTLEMENT_STATUS,
										CREATED_BY,
										CREATED_DT)
					VALUES
								(CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_ca cl WHERE YEAR(cl.CREATED_DT) = '$year') +1,3),
				                    '/$data[code]-CA/',
				                    '$month[$monthly]/',
				                    '$year'),
								'$formID',
								'$data[TRAVELLER]',
								'1',
								'$data[CHARGE_CODE]',
								'$data[DESTINATION]',
								'1',
								'$data[TRANSPORT]',
								'$data[PAYMENT_METHOD]',
								'$data[REMARKS]',
								 '1',
								 '0',
								 '$data[EMPLOYEE_EMAIL]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
			if($this->db->query($sql))
			{
				$ack = 4;
			}	
		}
		if($ack == 4){
		$formIDca = $this->getFormIdca($data['TRAVELLER'], $data['CHARGE_CODE'],$data['TRANSPORT']);
			$refnoca = $this->getRefNoca($formIDca);
			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('2',
								 '$formIDca',
								 '$data[APPROVAL]',
						         '0')";
			if($this->db->query($sql))
			{
				$ack = 5;
			}	
		}
		
		//untuk mengirim submit email ke RM
		if($ack == 5){
		
		$tujuan = $data['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Business Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['APPROVAL_NAME']."</b>, <br><br>
                <b>".$data['TRAVELLER_NAME']." </b> submited application for Business Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Business Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Business Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
        $ack ==6;
		}
		

		return $ack;
	}
	
	
	function updateBtForm($data)
	{
		$ack = 0;

		$sql = "UPDATE
						tb_r_bt bt
				SET
						bt.EMPLOYEE_ID		= '$data[EMPLOYEE_ID]',
						bt.TRAVELLER_ID 	= '$data[TRAVELLER]',
						bt.CLIENT_NAME 			= '$data[CLIENT_NAME]',
						bt.BUSINESS_PURPOSE 	= '$data[BUSINESS_PURPOSE]',
						bt.CUSTOMER_LOCATION	= '$data[CUSTOMER_LOCATION]',
						bt.TRANSPORTATION_BY = '$data[TRANSPORTATION_BY]',
						bt.CHARGE_CODE= '$data[CHARGE_CODE]',
						bt.DESTINATION= '$data[DESTINATION]',
						bt.DEPARTURE= '$data[DEPARTURE]',
						bt.RETURN_DATE= '$data[RETURN_DATE]',
						bt.DURATION= '$data[DURATION]',
						bt.AMOUNTDIM= '$data[AMOUNTDIM]',
						bt.PAYMENT_METHOD= '$data[PAYMENT_METHOD]',
						bt.REMARK_REVISE= '$data[REMARKS]',
						bt.APPROVAL= '$data[APPROVAL]',
						bt.TRANSPORTAMOUNT= '$data[TRANSPORT]',
						bt.UPDATED_BY 		= 'user: $data[this_email]',
						bt.UPDATED_DT 		= '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
				WHERE
						bt.BT_ID = '$data[BT_ID]' ";

		// return $sql;
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		
		if($ack == 1){
			$sql = "UPDATE
						tb_r_form_status fs
					SET 
						fs.TARGET_EMPLOYEE_ID = '$data[APPROVAL]',
						fs.STATUS = '8',
						fs.REVISE_APPROVEPUR_BY ='$data[TRAVELLER]',
						fs.REMARKS_REVISE_APPROVEPUR ='$data[REMARKS]',
						fs.REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
						
					WHERE fs.FORM_TYPE_ID = '3' AND
							fs.FORM_ID = '$data[BT_ID]'	";
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		if($ack == 2){
			$sql = "UPDATE
							  tb_r_notification 
					SET		  
						RECIPIENT_EMPLOYEE_ID = '$data[APPROVAL]' ,
						SENDER_EMPLOYEE_ID = '$data[TRAVELLER]',
						ACTIVITY_TYPE_ID = '4',				
						NOTIFICATION_STATUS_ID = '1',
						NOTIFICATION_TIME = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						UPDATED_BY = 'user: $data[EMPLOYEE_EMAIL]',
						UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE FORM_TYPE_ID = '3' AND
						FORM_ID = '$data[BT_ID]'
					         	 ";
			if($this->db->query($sql))
			{
				$ack = 3;
			}	
		}
		
		if($ack == 3){
			$sql = "UPDATE
					tb_r_ca 
					SET		
							EMPLOYEE_ID = '$data[TRAVELLER]',
							CA_TYPE_ID ='1',
							CHARGE_CODE = '$data[CHARGE_CODE]',
							DESTINATION = '$data[DESTINATION]',
							AMOUNT = '$data[TRANSPORT]',
							PAYMENT_METHOD= '$data[PAYMENT_METHOD]',
							REMARK = '$data[REMARKS]',
							STATUS='1',
							SETTLEMENT_STATUS='0',
							UPDATED_BY = '$data[EMPLOYEE_EMAIL]',
							UPDATED_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."'
					WHERE
							BT_ID = '$data[BT_ID]' 
							";
			if($this->db->query($sql))
			{
				$ack = 4;
			}	
		}
		if($ack == 4){
			$sql = "UPDATE
							  tb_r_form_status fs
					SET
							   fs.TARGET_EMPLOYEE_ID = '$data[APPROVAL]',
							   fs.STATUS = '8',
							   fs.REVISE_APPROVEPUR_DT = '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						fs.REVISE_APPROVEPUR_BY ='$data[TRAVELLER]',
						fs.REMARKS_REVISE_APPROVEPUR ='$data[REMARKS]'
					WHERE
								fs.FORM_TYPE_ID = '2' AND
								fs.FORM_ID = '$data[BT_ID]'
												";
			if($this->db->query($sql))
			{
				$ack = 5;
			}	
		}
		//untuk mengirim submit email ke RM
		if($ack == 5){
		
		$tujuan = $data['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Business Travel"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['APPROVAL_NAME']."</b>, <br><br>
                <b>".$data['TRAVELLER_NAME']." </b> editted application for Business Travel.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Business Travel</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Business Travel \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
        $ack ==6;
		}
		return $ack;
	}
	
	
	function getFormId( $employeId, $type_ca,$cc, $amount)
	{
		$sql = "SELECT
						ca.BT_ID
				FROM
						tb_r_bt ca
				WHERE
						ca.EMPLOYEE_ID = '$employeId' AND
						ca.DEPARTURE = '$type_ca' AND
						ca.CHARGE_CODE = '$cc'AND
						ca.TRANSPORTAMOUNT = '$amount' ";
		return fetchArray($sql, 'one');
	}
	
	function getRefNo( $formid)
	{
		$sql = "SELECT
						ca.REF_NO
				FROM
						tb_r_bt ca
				WHERE
						ca.BT_ID = '$formid'  ";
		return fetchArray($sql, 'one');
	}
	
		function getFormIdca( $treveller, $cc, $amount)
	{
		$sql = "SELECT
						ca.CA_ID
				FROM
						tb_r_ca ca
				WHERE
						ca.EMPLOYEE_ID = '$treveller' AND
						ca.CA_TYPE_ID = '1' AND
						ca.CHARGE_CODE = '$cc'AND
						ca.AMOUNT = '$amount' ";
		return fetchArray($sql, 'one');
	}
	
	function getRefNoca( $formidca)
	{
		$sql = "SELECT
						ca.REF_NO
				FROM
						tb_r_ca ca
				WHERE
						ca.CA_ID = '$formidca'  ";
		return fetchArray($sql, 'one');
	}
	
	function getFormInfo($formId)
	{
		$sql = "SELECT
						bt.BT_ID bt_id,
						bt.REF_NO ref_no,
						(select ar.EMPLOYEE_NAME from tb_m_employee ar where bt.EMPLOYEE_ID = ar.EMPLOYEE_ID) idemp,
						bt.TRAVELLER_ID employee_id,
						empl.EMPLOYEE_NAME employee_name,
						empl.GROUP_ID groupid,
						cc.PROJECT_DESCRIPTION projectdescript,
						empl.DIVISION_ID divisionid,
						bt.DEPARTURE start_dt,
						bt.RETURN_DATE end_dt,
						bt.DURATION duration,
						bt.TRAVELLER_ID travid,
						bt.AMOUNTDIM totaldim,
						bt.TRANSPORTAMOUNT transportca,
						bt.CLIENT_NAME client,
						bt.BUSINESS_PURPOSE bp,
						bt.CUSTOMER_LOCATION custloc,
						bt.TRANSPORTATION_BY transport,
						bt.APPROVAL approval,
                        (select ar.EMPLOYEE_NAME from tb_m_employee ar where bt.APPROVAL = ar.EMPLOYEE_ID) approval_name,
                        (select ur.USER_EMAIL from tb_m_employee ar, tb_m_user ur where bt.APPROVAL = ar.EMPLOYEE_ID and bt.APPROVAL = ur.EMPLOYEE_ID) approval_name,
						bt.DESTINATION destination,
						bt.CHARGE_CODE cc,
						cc.TYPE cctype,
						bt.PAYMENT_METHOD pm,
						bt.REMARK remark,
                        usr.USER_EMAIL employee_email,
						fs.STATUS status_id,
						pl.DIM_AMOUNT amountid,
						pl.DIM_AMOUNT_DOMESTIK amountid1,
						pl.DIM_AMOUNT_INTERNATIONAL amountid2,
						empl.POSITION_DEPTH_ID posid						
						
				FROM
						tb_r_bt bt,
						tb_m_employee empl,
						tb_m_charge_code cc,
						tb_m_user usr,
						tb_r_form_status fs,
						tb_m_position_level pl
				WHERE
				empl.LEVEL_ID = pl.LEVEL_ID AND
						bt.BT_ID = '$formId' AND 
						bt.CHARGE_CODE = cc.CHARGE_CODE AND
						bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND 
						bt.TRAVELLER_ID = usr.EMPLOYEE_ID AND
						fs.FORM_ID =bt.BT_ID AND
							fs.FORM_TYPE_ID='3'";
		return fetchArray($sql, 'row');
	}
	
	
}