<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS038
* Program Name     : Cash Advance General GA Form
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 13-11-2014 11:54:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS038 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	// mengambil data pengajuan terakhir

	 function tgl_terakhir_ca($employeeID){	
		$sql = "SELECT 
						CREATED_DT
				FROM 
						tb_r_ca
				WHERE
					EMPLOYEE_ID ='".$employeeID."' AND
					STATUS != 2 order by CREATED_DT  asc";
		return fetchArray($sql, 'one');
	}
	

	// cek apakah user masih mempunyai pengajuan CA yg aktif
	function cek_status_open($employeeID){	
		$sql = "SELECT 
					COUNT(EMPLOYEE_ID) jumlah
				FROM
					tb_r_ca
				WHERE
					EMPLOYEE_ID ='".$employeeID."' AND
					STATUS != 2 ";
		return fetchArray($sql, 'one');
	}
	
	//Mendapatkan kepala group dri requester
	function get_approval_internal($data)
	{
		$sql = "SELECT 
						empl.EMPLOYEE_ID id,
						empl.EMPLOYEE_NAME name,
                        usr.USER_EMAIL email
				FROM 
						tb_m_employee empl,
                        tb_m_user usr
				WHERE 
						empl.EMPLOYEE_ID=usr.EMPLOYEE_ID AND
                        empl.POSITION_DEPTH_ID = '2' AND
						empl.GROUP_ID = '$data'";
		return fetchArray($sql, 'row');
	}
	
	//Mendapatkan kepala group dri consultan (approval training & project)
	function get_approval_pro_tra()
	{
		$sql = "SELECT 
						empl.EMPLOYEE_ID id,
						empl.EMPLOYEE_NAME name,
                        usr.USER_EMAIL email
				FROM 
						tb_m_employee empl,
                        tb_m_user usr
				WHERE 
						empl.EMPLOYEE_ID=usr.EMPLOYEE_ID AND
                        empl.POSITION_DEPTH_ID = '2' AND
						empl.GROUP_ID = 'CONSULTANT'";
		return fetchArray($sql, 'row');
	}
	
	//Mendapatkan kepala group dri BD (approval lisence)
	function get_approval_license()
	{
		$sql = "SELECT 
						empl.EMPLOYEE_ID id,
						empl.EMPLOYEE_NAME name,
                        usr.USER_EMAIL email
				FROM 
						tb_m_employee empl,
                        tb_m_user usr
				WHERE 
						empl.EMPLOYEE_ID=usr.EMPLOYEE_ID AND
                        empl.POSITION_DEPTH_ID = '2' AND
						empl.GROUP_ID = 'BD'";
		return fetchArray($sql, 'row');
	}
	
	//Mendapatkan list ca type
	function get_catype_list()
	{
		$sql = " SELECT
							ct.CA_TYPE_ID id,
							ct.CA_TYPE name
							
							
				FROM
							tb_m_ca_type ct  
				WHERE
							ct.CA_CATEGORY='2'";
		return fetchArray($sql, 'all');
	}
	
	//mendapatkan id chargecode ketika load edit
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
	
	//mendapatkan list chargecode type 
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
	
	//mendapatkan list chargecode berdasarkan typechargecode yang dipilih
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
		
	//mendapatkan detail form
	function get_form_detail($form_id)
	{
		$sql = "SELECT
						cl.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						empl.DIVISION_ID employee_division,
						empl.POSITION_DEPTH_ID posid,
                        empl.LEVEL_ID level_id,
                        (select pl.LEVEL_NAME from tb_m_position_level pl where empl.LEVEL_ID=pl.LEVEL_ID) level_name,
					    usr.USER_EMAIL employee_email,
					    cl.CA_ID ca_id,
                        cl.CHARGE_CODE chargecode,
						cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11'  and pos.SYS_CD = cc.TYPE )  categorycc_name,
					     cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID aprove,  
                        (select pos.USER_EMAIL from tb_m_user pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_email, 
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,						
						cl.CREATED_DT submitted_dt, 
						cl.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						cl.DESTINATION destination,
						(select ccost.COST from tb_m_ca_cost ccost  where cl.DESTINATION=ccost.COST_ID )  destination_name,
                        (select ccost.COST from tb_m_ca_cost ccost  where cl.CURRENCY='1'AND cl.DESTINATION=ccost.COST_ID )  limit_idr,
                        (select ccost.COST_USD from tb_m_ca_cost ccost  where cl.CURRENCY='2'AND cl.DESTINATION=ccost.COST_ID )  limit_usd,
						cl.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = cl.CURRENCY )  currency_name,
						 (select cost.NOMINAL from tb_m_setting_limit_dir cost  where cost.CURRENCY = cl.CURRENCY)  limit_dir,
						cl.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = cl.PAYMENT_METHOD )  pay_method_name,
						cl.REMARK remarks,
                        cl.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = cl.STATUS )  form_status_name,
					    sys.VALUE status,
					    fs.STATUS status_id,
					    fs.REMARKS_REVISE remarks_revise,
					    fs.REVISE_APPROVAL_REMARKS remarks_revise_approval,
					    fs.REVISE_REMARKS_F2 remarks_revise_f2
						
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca cl,
					    tb_m_user usr,
					    tb_m_ca_type ct,
						tb_m_charge_code cc,
					    tb_m_system sys
				    
				WHERE
					    cl.CA_ID = '$form_id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cl.CA_TYPE_ID = ct.CA_TYPE_ID AND
						cc.CHARGE_CODE = cl.CHARGE_CODE AND
					    sys.SYS_CAT = '18' AND
						sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CA_ID AND
					    fs.FORM_TYPE_ID = '2' 
						order by cl.CA_ID desc";	
		return fetchArray($sql, 'row');
	}
	
	//query submit form CA baru
	function submit_form($data)
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
		//insert data ke tabel record CA
	$sql = "INSERT INTO
							tb_r_ca (REF_NO,
										EMPLOYEE_ID,
										CA_TYPE_ID,
										CHARGE_CODE,
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
							 '$data[EMPLOYEE_ID]',
							 '$data[CA_TYPE_ID]',
							  '$data[CHARGE_CODE]',
					         '$data[CURRENCY]',
							'$data[AMOUNT]',
							 '$data[PAYMENT_METHOD]',
							 '$data[REMARK]',
							 '1',
							 '0',
					         '$data[EMPLOYEE_EMAIL]',
					         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
	
		if($this->db->query($sql))
		{
				$ack = 1;
		} 
		if($ack == 1){
			$formID = $this->getFormId($data['EMPLOYEE_ID'], $data['CA_TYPE_ID'],$data['CHARGE_CODE'],$data['AMOUNT']);
			$refno = $this->getRefNo($formID);
			//insert data ke tabel form status CA
			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('2',
								 '$formID',
								 '$data[APPROVAL]',
						         '0')";
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		if($ack == 2){
			//intert data notifikasi untuk approval
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
								 '$data[EMPLOYEE_ID]',
								 '0',
						         '2',
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
		//untuk mengirim submit email ke RM
		if($ack == 3){
		
		$tujuan = $data['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['APPROVAL_NAME']."</b>, <br><br>
                ".$data['EMPLOYEE_NAME']."<b>has  submitted</b> an application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Notification to ".$tujuan." sent successfully<br>";//jika terkirim
        }else{
            echo "<br>Notification to ".$tujuan." send failed<br>";//jika tidak terkirim
        }
        $ack =4;
		}
		return $refno;
		return $ack;

	}
	
	//Query untuk update Form CA
	function updateCaForm($sbmt)
	{
		$ack = 0;
		//mengupdate data di tabel CA
		$sql = " UPDATE
						tb_r_ca 
				SET
						CA_TYPE_ID 		='$sbmt[CA_TYPE_ID]',
						CHARGE_CODE		='$sbmt[CHARGE_CODE]',
						CURRENCY		='$sbmt[CURRENCY]',
						AMOUNT 			='$sbmt[AMOUNT]',
						PAYMENT_METHOD	='$sbmt[PAYMENT_METHOD]',
						REMARK			= '$sbmt[REMARK]',
						UPDATED_DT		= '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						UPDATED_BY		='user: $sbmt[this_email]'
				WHERE
						CA_ID = '$sbmt[CA_ID]' ";

		if($this->db->query($sql))
		{
			$ack = 1;
		}
		if($ack == 1 )
		{ 
			if($sbmt['status_id']=='7'){
			//insert tabel notifikasi edit untuk approval
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
								('$sbmt[APPROVAL]',
								 '$sbmt[this_id]',
								 '$sbmt[ACTIVITY_TYPE_ID]',
						         '2',
						         '$sbmt[CA_ID]',
						         'No. Ref: $sbmt[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $sbmt[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}

			if($sbmt['status_id']=='18'){
			//insert tabel notifikasi edit untuk Finance
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
								('$sbmt[F2_APPROVE]',
								 '$sbmt[this_id]',
								 '$sbmt[ACTIVITY_TYPE_ID]',
						         '2',
						         '$sbmt[CA_ID]',
						         'No. Ref: $sbmt[ref_no]',
						         '1',
						         '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $sbmt[this_email]',
					         	 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	}

			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		
		if($ack == 2 ){
		//untuk mengirim submit email ke RM
		if($sbmt['status_id']=='7'){
		$tujuan = $sbmt['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$sbmt['APPROVAL_NAME']."</b>, <br><br>
                <b>".$sbmt['this_name']." </b> have to revise application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";}
        
        //untuk mengirim submit email ke Finance
        if($sbmt['status_id']=='18'){
		$tujuan = $sbmt['F2_APPROVE_EMAIL']; //mengambil email Finance
        $judul = "Cash Advance"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$sbmt['F2_APPROVE_NAMA']."</b>, <br><br>
                <b>".$sbmt['this_name']." </b> have to revise application for Cash Advance.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST to view the detail of Cash Advance</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Cash Advance \r\n";}
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Notification to ".$tujuan." sent successfully<br>";//jika terkirim
        }else{
            echo "<br>Notification to ".$tujuan." send failed<br>";//jika tidak terkirim
        }{
        $ack = 3;
		}
		}
		if ($ack == 3 )
		{
			if ($sbmt['status_id']=='7')
		{
			//mengupdate r status form CA
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						TARGET_EMPLOYEE_ID ='$sbmt[APPROVAL]',
						STATUS='8'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$sbmt[CA_ID]'";}
						
			if ($sbmt['status_id']=='18')
		{
			//mengupdate r status form CA
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						F2_APPROVE ='$sbmt[F2_APPROVE]',
						STATUS='19'
					WHERE 
						FORM_TYPE_ID = '2'AND
						FORM_ID ='$sbmt[CA_ID]'";}
						
		
			if($this->db->query($sql))
			{
				$ack = 4;
			}
		}
		
		return $ack;
	}
	
	//untuk mendapatkan formID 
	function getFormId( $employeId, $type_ca,$cc, $amount)
	{
		$sql = "SELECT
						ca.CA_ID
				FROM
						tb_r_ca ca
				WHERE
						ca.EMPLOYEE_ID = '$employeId' AND
						ca.CA_TYPE_ID = '$type_ca' AND
						ca.CHARGE_CODE = '$cc'AND
						ca.AMOUNT = '$amount' ";
		return fetchArray($sql, 'one');
	}
	
	//untuk mendapatkan ref no
	function getRefNo( $formid)
	{
		$sql = "SELECT
						ca.REF_NO
				FROM
						tb_r_ca ca
				WHERE
						ca.CA_ID = '$formid'  ";
		return fetchArray($sql, 'one');
	}
	
	//mendapatkan list data CA
	function get_list($data)
	{
		$sql = "SELECT
						ca.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						(select rs.REMAINING from tb_r_settlement rs where rs.FORM_ID = ca.CA_ID AND rs.FORM_TYPE_ID ='2') balance,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    ca.CA_ID ca_id,
                        ca.CHARGE_CODE chargecode,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						ca.CREATED_DT submitted_dt, 
						ca.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						ca.DESTINATION destination,
						ca.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = ca.CURRENCY )  currency_name,
						ca.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = ca.PAYMENT_METHOD )  pay_method_name,
						ca.REMARK remarks,
                        ca.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = ca.STATUS )  form_status_name,
					    sys.VALUE status,
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
						tb_r_ca ca,
					    tb_m_ca_type ct,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
						ca.CHARGE_CODE = cc.CHARGE_CODE AND
					    ca.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    ca.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '18' AND
						ca.STATUS = '1' AND
						ca.EMPLOYEE_ID = '$data[this_id]' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = ca.CA_ID AND
					    fs.FORM_TYPE_ID = '2' 
						order by ca.CA_ID desc";	
		return fetchArray($sql, 'all');
	}
	
	//mendapatkan list group
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
	
	//mendapatkan chargecode list
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
	
	//mendapatkan employee list
	function get_employee_list()
	{
		$sql = " SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl
				ORDER BY empl.EMPLOYEE_NAME ASC ";
		return fetchArray($sql, 'all');
	}
	
	//mendapatkan ca type list
	function get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type";
		return fetchArray($sql, 'all');
	}

}