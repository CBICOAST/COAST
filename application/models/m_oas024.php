<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS024
* Program Name     : Create Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS024 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_claim_type_list()
	{
		$sql = " SELECT
					et.EXPENSE_TYPE_ID id,
					et.EXPENSE_TYPE_NAME name,
					et.CLAIM_CATEGORY cat
				FROM
					tb_m_expense_type et 
				WHERE
					et.EXPENSE_TYPE_PARENT is NULL AND
					et.STATUS = '1' ";
		return fetchArray($sql, 'all');
	}
	
	function get_medis_type_list($id)
	{
		$sql = " SELECT
					et.EXPENSE_TYPE_ID id,
					et.EXPENSE_TYPE_NAME name,
					et.CLAIM_CATEGORY cat					
				FROM
					tb_m_expense_type et 
				WHERE
					et.EXPENSE_TYPE_PARENT = '".$id."' AND
					et.STATUS = '1'";
							
		return fetchArray($sql, 'all');
	}
	
	function get_category_claim($id)
	{
		$sql = " SELECT
					et.EXPENSE_TYPE_ID id,
					et.EXPENSE_TYPE_NAME name,
					et.CLAIM_CATEGORY cat					
				FROM
					tb_m_expense_type et 
				WHERE
					et.EXPENSE_TYPE_ID = '".$id."'";
							
		return fetchArray($sql, 'all');
	}
	
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
					sys.SYS_CD = cc.TYPE  
				GROUP BY cc.TYPE";
		return fetchArray($sql, 'all');
	}
	
	function get_approval_pro()
	{
		$sql = " SELECT 
						mp.EMPLOYEE_ID  id,
			            em.EMPLOYEE_NAME name,
                        us.USER_EMAIL email
				FROM 
						tb_m_employee em,
                        tb_m_user us,
                        tb_m_approval mp
				WHERE
						mp.EMPLOYEE_ID = em.EMPLOYEE_ID AND
                        us.EMPLOYEE_ID = mp.EMPLOYEE_ID AND
						mp.APPROVAL_FOR = '1'";
		return fetchArray($sql, 'row');
	}
	

	
	function getCc_CL($id){
		$sql = "SELECT
					CHARGE_CODE charge_code,
					PROJECT_DESCRIPTION description,
					TYPE type,
					DIVISION_ID divisi
				FROM
					tb_m_charge_code 
				WHERE
					TYPE = '".$id."' AND
					STATUS = '1'";
		return fetchArray($sql, 'all');
		}
		
		function getCc_Div($id){
		$sql = "SELECT
					CHARGE_CODE charge_code,					
					DIVISION_ID divisi
				FROM
					tb_m_charge_code 
				WHERE
					CHARGE_CODE = '".$id."'";
		return fetchArray($sql, 'all');
		}
			
	
	function submitClaimForm_individu($data)
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
							tb_r_claim (REF_NO,
										EMPLOYEE_ID,
										CLAIM_TYPE_ID,
										CHARGE_CODE,
										TANGGAL_KWITANSI,
										TOTAL,
										KETERANGAN,
										SUBMITTED_DATE,
										CREATED_BY,
										CREATED_DT)
				VALUES
							(CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_claim cl WHERE YEAR(cl.SUBMITTED_DATE) = '$year') +1,3),
				                    '/$data[KODE]-EC/',
				                    '$month[$monthly]/',
				                    '$year'),
							 '$data[EMPLOYEE_ID]',
							 '$data[CLAIM_TYPE_ID]',
							 '$data[CHARGE_CODE]',
					         '$data[TANGGAL_KWITANSI]',
					         '$data[TOTAL]',
							 '$data[KETERANGAN]',
					         '$data[SUBMITTED_DATE]',
					         '$data[EMPLOYEE_EMAIL]',
							 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		if($ack == 1){
			$formID = $this->getFormId($data['EMPLOYEE_ID'], $data['CLAIM_TYPE_ID'],$data['TANGGAL_KWITANSI'],$data['TOTAL']);
			$refno = $this->getRefNo($formID);

			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('5',
								 '$formID',
								 '$data[APPROVAL]',
						         '1')";
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
								 '$data[EMPLOYEE_ID]',
								 '0',
						         '5',
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
			$tujuan = $data['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['APPROVAL_NAME']."</b>, <br><br>
                <b>".$data['EMPLOYEE_NAME']." </b> Submitted application for Expense Claim.</p>
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
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
			{
				$ack = 4;
			}	
		}
		
		return $refno;
		return $ack;

	}
	
	function submitClaimForm_divisi($data)
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
							tb_r_claim (REF_NO,
										EMPLOYEE_ID,
										CLAIM_TYPE_ID,
										CHARGE_CODE,
										TANGGAL_KWITANSI,
										TOTAL,
										KETERANGAN,
										SUBMITTED_DATE,
										CREATED_BY,
										CREATED_DT)
				VALUES
							(CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_claim cl WHERE YEAR(cl.SUBMITTED_DATE) = '$year') +1,3),
				                    '/$data[KODE]-EC/',
				                    '$month[$monthly]/',
				                    '$year'),
							 '$data[EMPLOYEE_ID]',
							 '$data[CLAIM_TYPE_ID]',
							 '$data[CHARGE_CODE]',
					         '$data[TANGGAL_KWITANSI]',
					         '$data[TOTAL]',
							 '$data[KETERANGAN]',
					         '$data[SUBMITTED_DATE]',
					         '$data[EMPLOYEE_EMAIL]',
							 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		if($ack == 1){
			$formID = $this->getFormId($data['EMPLOYEE_ID'], $data['CLAIM_TYPE_ID'],$data['TANGGAL_KWITANSI'],$data['TOTAL']);
			$refno = $this->getRefNo($formID);

			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS)
					VALUES
								('5',
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
								 '$data[EMPLOYEE_ID]',
								 '0',
						         '5',
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
		$tujuan = $data['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['APPROVAL_NAME']."</b>, <br><br>
                <b>".$data['EMPLOYEE_NAME']." </b> Submitted application for Expense Claim.</p>
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
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
			{
				$ack = 4;
			}	
		}
		
		return $refno;
		return $ack;

	}
	function getFormId( $employeId, $claimType,$tgl, $total)
	{
		$sql = "SELECT
						cl.CLAIM_ID
				FROM
						tb_r_claim cl
				WHERE
						cl.EMPLOYEE_ID = '$employeId' AND
						cl.CLAIM_TYPE_ID = '$claimType' AND
						cl.TANGGAL_KWITANSI = '$tgl'AND
						cl.TOTAL = '$total' ";
		return fetchArray($sql, 'one');
	}
	
	function getRefNo( $formid)
	{
		$sql = "SELECT
						cl.REF_NO
				FROM
						tb_r_claim cl
				WHERE
						cl.CLAIM_ID = '$formid'  ";
		return fetchArray($sql, 'one');
	}
	
	
	// UPDATE FEB 2015 //
	function get_bantuan($employeeID, $expense, $child,$year)
	{
		$sql = "SELECT IFNULL ((SELECT
							bnt.AMOUNT amount							
				FROM
							tb_m_employee empl,
                            tb_m_user us,
                            tb_m_bantuan bnt,
							tb_r_bantuan rbnt
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
                            empl.LEVEL_ID = bnt.LEVEL_ID AND
							empl.STATUS_ID = '1' AND
                            ( bnt.EXPENSE_TYPE_ID = '$expense' or 
							bnt.EXPENSE_TYPE_ID = '$child')
							AND 
							empl.EMPLOYEE_ID = '$employeeID' AND
							rbnt.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							rbnt.EXPENSE_TYPE_ID = bnt.EXPENSE_TYPE_ID AND
							rbnt.REMAIN != '0' AND 
							rbnt.YEAR = '$year'                           
				ORDER BY empl.EMPLOYEE_NAME ASC),0) as amount ";
		return fetchArray($sql, 'all');
	}
	
	function get_tunjangan($employeeID, $expense, $child,$year, $month)
	{
		$sql = "SELECT IFNULL ((SELECT
							tnj.REMAIN_AMOUNT amount							
				FROM
							tb_m_employee empl,
                            tb_m_user us,
							tb_r_tunjangan tnj
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
                            ( tnj.EXPENSE_TYPE_ID = '$expense' or 
							tnj.EXPENSE_TYPE_ID = '$child')
							AND 
							empl.EMPLOYEE_ID = '$employeeID' AND
							tnj.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							tnj.AVAILABLE = '1' AND 
							tnj.YEAR = '$year'  AND
							tnj.MONTH = '$month'
				ORDER BY empl.EMPLOYEE_NAME ASC),0) as amount ";
		return fetchArray($sql, 'all');
	}
	
	// Mengambil Approval untuk Expense Internal Divisi Direktur
	function _get_approval_dir()
	{
		$sql = "SELECT 
						empl.EMPLOYEE_ID id,
						empl.EMPLOYEE_NAME name,
						us.USER_EMAIL email
				FROM 
						tb_m_employee empl,
                        tb_m_user us
				WHERE 
						empl.EMPLOYEE_ID = us.EMPLOYEE_ID AND
						empl.POSITION_DEPTH_ID = '2' AND
						empl.DIVISION_ID = 'OPERATION'";
		return fetchArray($sql, 'row');
	}
	
	
}