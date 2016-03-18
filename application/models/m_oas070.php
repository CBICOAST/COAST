<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS037
* Program Name     : Form Pengajuan Purchase request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 13-02-2015 9:19:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS070 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
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
	
	function list_item(){
	$sql = "SELECT DESCRIPTION AS descript,
					SATUAN satuan
				FROM 	tb_m_item_list
           ORDER BY descript ASC";	
		return fetchArray($sql, 'all');
	}
	
	function list_vendor(){
	$sql = "SELECT 
				ID_VENDOR AS idvendor,
				COMPANY AS descript,
				ATTN satuan,
                ADDRESS alamat,
                CITY kota,
                PHONE telp,
                ZIP zip,
                FAX fax
				FROM 	tb_r_vendor
           ORDER BY descript ASC";	
		return fetchArray($sql, 'all');
	}
	
	function list_shipto(){
	$sql = "SELECT SHIPTO_ID AS idshipto,
					S_COMPANY AS descript,
					S_CP cp,
                    S_ADDRESS alamat,
					S_TELP telp,
					S_NPWP npwp
				FROM 	tb_r_shipto
           ORDER BY descript ASC";	
		return fetchArray($sql, 'all');
	}
		
	// Ambil satuan item
	function get_satuan($satuan){	
		$sql = "SELECT
					ITEM_ID id,
					DESCRIPTION description,
                    SATUAN satuan
				FROM
                    tb_m_item_list
                WHERE
                     DESCRIPTION = '".$satuan."'";
		return fetchArray($sql, 'all');
	}
	
	// SAVE VENDOR
	function save_vendor($data)
	{
		$ack = 0;
		$sql = "INSERT INTO tb_r_shipto 
									(SHIPTO_ID, 
									S_COMPANY, 
									S_ADDRESS,  
									S_CP, 
									S_TELP,  
									S_EMAIL,  
									S_NPWP)
						VALUES    ('$data[PR_ID]',
								   '$data[COMPVENDOR]',
								   '$data[ADDVENDOR]',
								   '$data[CP]',
								   '$data[PHONEVENDOR]',
								   '$data[EMAILVENDOR]',
									'$data[NPWP]')";
						
		if($this->db->query($sql))
		{ $ack = 1; }		
		return $ack;
	}
	
	// SAVE SHIP TO
	function save_shipto($data){
		$ack = 0 ;
		$sql = "INSERT INTO tb_r_vendor 
									(ID_VENDOR,
									COMPANY,
									ATTN,
									ADDRESS, 
									CITY,
									PHONE, 
									ZIP,
									FAX)
					VALUES			('$data[PR_ID]',
									'$data[COMPSHIP]',
									'$data[ATTNSHIP]',
									'$data[ADDSHIP]',
									'$data[CITYSHIP]',
									'$data[PHONESHIP]',
									'$data[ZIP]',
									'$data[FAX]')";	
		if($this->db->query($sql))
		{ $ack = 1; }		
		return $ack;
	}
	
	function insertPR_ID($data)
	{
	$ack = 0;
	$year = date("Y");
	$month = DATE("m");
	$sql = "INSERT INTO
				tb_r_pr (EMPLOYEE_ID,STATUS_FORM,CREATED_DT)
				
			VALUES
				('$data[this_id]',
				'NEW',
				'".date("Y-m-d H:i:s")."')";
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
	}
	// Ambil PR ID
	function getPR_ID($data){	
		$sql = "SELECT
					PR_ID					
				FROM
                    tb_r_pr
                WHERE
                     EMPLOYEE_ID = '$data'
					 AND STATUS_FORM = 'NEW'";
		return fetchArray($sql, 'one');
	}
	// Hapus PR yg ga jadi disubmit
	function delPR_ID($data){	
	$sql = "DELETE 					
				FROM
                    tmp_item_pr
                WHERE
                     PR_ID =(SELECT
					PR_ID					
				FROM
                    tb_r_pr
                WHERE
                     EMPLOYEE_ID = '$data'
					 AND STATUS_FORM = 'NEW')";
		$sql2 = "DELETE 					
				FROM
                    tb_r_pr
                WHERE
                     EMPLOYEE_ID = '$data'
					 AND STATUS_FORM = 'NEW'";
		
		$this->db->query($sql);
		$this->db->query($sql2);
	}
	
	// Tampilkan daftar dokumen yang diupload
	function get_list_doc($form_id)
	{
	$sql = "SELECT 	
					NAMAFILE namafile,
					DOCCUMENT document
			FROM documment
			where PR_ID = '$form_id'";
	return fetchArray($sql, 'all');
	}
	

	 function getRef($data)
    {
    	$year = date("Y");
		$monthly = DATE("m");
    	$sql = "SELECT CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_pr pr WHERE YEAR(pr.CREATED_DT) = '$year'),3),
				                    '/$data[code]-PR/',
				                    '$month[$monthly]/',
				                    '$year')";
        return fetchArray($sql, 'one');
    }
	
	function submitPRForm($data)
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
		
		// Update berdasarkan PR ID
		$sql = "UPDATE tb_r_pr SET  REF_NO ='$data[ref]',
									EMPLOYEE_ID = '$data[EMPLOYEE_ID]',
									B_STATUS = '$data[B_STATUS]',
									REMARK = '$data[REMARKS]',
									DIBUAT_PO = '$data[USER_STATUS]',
									Q_NO = '$data[QUOT_NO]',
									DOWN_PAYMENT = '$data[JML1]',
									DATE_1PAYMENT = '$data[TGL1]',
									REMARK_P1 = '$data[REMARKP1]',
									2ND_PAYMENT = '$data[JML2]',
									DATE_2PAYMENT = '$data[TGL2]',
									REMARK_P2 = '$data[REMARKP2]',
									3RD_PAYMENT = '$data[JML3]',
									DATE_3PAYMENT = '$data[TGL3]',
									REMARK_P3 = '$data[REMARKP3]',
									FINAL_PAYMENT = '$data[JML4]',
									DATE_4PAYMENT = '$data[TGL4]',
									REMARK_P4 = '$data[REMARKP4]',
									VENDOR = '$data[PR_ID]',
									SHIP_TO = '$data[PR_ID]',
									CHARGE_CODE = '$data[CHARGE_CODE]',
									CURRENCY = '$data[CURRENCY]',
									AMOUNT_ITEM = '$data[AMOUNT_ITEM]',
									DOCUMENTSUPPORT  = '$data[DOCUMENT]',
									STATUS_FORM = 'OLD',
									CREATED_BY = '$data[EMPLOYEE_EMAIL]',
									CREATED_DT = '".date("Y-m-d H:i:s")."'
					WHERE PR_ID = '$data[PR_ID]'";	
					
		
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		
		else{$ack = 0;}
		
		if($ack == 1){
			$formID = $this->getFormId($data['EMPLOYEE_ID'],$data['CHARGE_CODE'],$data['AMOUNT_ITEM']);
			$refno = $this->getRefNo($formID);
			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('4',
								 '$formID',
								 '$data[EMPLOYEE_RM_ID]',
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
								('$data[EMPLOYEE_RM_ID]',
								 '$data[EMPLOYEE_ID]',
								 '0',
						         '4',
						         '$formID',
						         'No. Ref: $refno',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         'user: $data[EMPLOYEE_EMAIL]',
					         	 '".date("Y-m-d H:i:s")."')";
			if($this->db->query($sql))
			{
				$ack = 3;
			}	
		}
		
		if($ack == 3){
			$tujuan = $data['EMPLOYEE_RM_EMAIL']; //mengambil email RM
        $judul = "Purchase Request"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['EMPLOYEE_RM_NAME']."</b>, <br><br>
                <b>".$data['EMPLOYEE_NAME']." </b> submitted application for Purchase Request.</p>
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
            echo  "<br>Sending notification to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notification to ".$tujuan." failed<br>";//jika tidak terkirim
        }
			{
				$ack = 4;
			}	
		}		
		return $ack;
	}
		
	function getFormId( $employeId, $cc, $create)
	{
		$sql = "SELECT
						pr.PR_ID
				FROM
						tb_r_pr pr
				WHERE
						pr.EMPLOYEE_ID = '$employeId' AND
						pr.AMOUNT_ITEM = '$create' AND
						pr.CHARGE_CODE = '$cc' ";
		return fetchArray($sql, 'one');
	}
	
	function getRefNo( $formid)
	{
		$sql = "SELECT
						pr.REF_NO
				FROM
						tb_r_pr pr
				WHERE
						pr.PR_ID = '$formid'  ";
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
	
	function get_list_tmppr($data)
	{
	$sql = "SELECT 	NO no,
					QTY qty,
					SATUAN satuan,
					NAMA nama,
					HARGA harga,
					TOTAL total,
					KETERANGAN keterangan
			FROM tmp_item_pr 
			where 
			PR_ID = '$data'";
	return fetchArray($sql, 'all');
	}
	
	function pr_save($data)
	{
	$ack = 0;
		$sql = "INSERT INTO tmp_item_pr 
								(QTY,
                                SATUAN,
                                NAMA,
                                HARGA,
                                TOTAL,
								KETERANGAN,
								PR_ID)
								
							VALUES ('$data[QTY]',
									'$data[SATUAN]',
									'$data[NAMA]',
									'$data[HARGA]',
									'$data[TOTAL]',
									'$data[KETERANGAN]',
									'$data[PR_ID]')
							";
			if($this->db->query($sql))
	
		return $ack;
	}
	
	function delete_itempr ($id)
	{
	$ack = 0;
		$sql = "DELETE FROM tmp_item_pr WHERE NO = '$id'";
		
			if($this->db->query($sql))
	
		return $ack;
	}
}