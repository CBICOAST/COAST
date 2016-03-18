  <?php
 /************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS023
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00				4 Maret 2015	Winni Oktaviani
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS023 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_info($id)
	{
		$sql = "SELECT 
						cl.REF_NO ref_no,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
					    usr.USER_EMAIL employee_email,
					    cl.CLAIM_ID claim_id,
                        cl.CLAIM_TYPE_ID claim_type,
						cl.CHARGE_CODE charge_code,
                        (select pos.SYS_CD from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_name,
					    (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
					    fs.TARGET_EMPLOYEE_ID aprove,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name, 
						(select us.USER_EMAIL from tb_m_employee pos, tb_m_user us where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID AND fs.TARGET_EMPLOYEE_ID = us.EMPLOYEE_ID)  approve_email,
						cl.TANGGAL_KWITANSI tanggal_kwitansi, 
                        month(cl.TANGGAL_KWITANSI) month,
                        year(cl.TANGGAL_KWITANSI) year,
						cl.TOTAL total,
                        cl.KETERANGAN keterangan,
					    ct.EXPENSE_TYPE_ID id,
					    ct.EXPENSE_TYPE_NAME claim_name,
                        ct.CLAIM_CATEGORY category_id,
                        (select pos.VALUE from tb_m_system pos where pos.SYS_CAT= '10' and pos.SYS_CD = ct.CLAIM_CATEGORY )  category_name,
					    sys.VALUE status,
					    fs.STATUS status_id
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_claim cl,
					    tb_m_user usr,
					    tb_m_expense_type ct,
					    tb_m_system sys
				WHERE
					    cl.CLAIM_ID = '$id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cl.CLAIM_TYPE_ID = ct.EXPENSE_TYPE_ID AND
					    sys.SYS_CAT = '9' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CLAIM_ID AND
					    fs.FORM_TYPE_ID = '5'";
					
			return fetchArray($sql, 'row');
	}
	
	function get_approval_name($id)
	{
		$sql = " SELECT
						fs.TARGET_EMPLOYEE_ID employee_id,
						empl.EMPLOYEE_NAME employee_name                    

				FROM
						tb_r_claim cl,
						tb_m_employee empl,
                        tb_r_form_status fs
				WHERE
						cl.CLAIM_ID = '$id' AND
						cl.CLAIM_ID = fs.FORM_ID AND
						fs.TARGET_EMPLOYEE_ID  = empl.EMPLOYEE_ID 
				";
							
		return fetchArray($sql, 'row');
	}
	
	
	function claim_update($sbmt)
	{
		$ack = 0;

		$sql = " UPDATE
						tb_r_claim 
				SET
						
						CHARGE_CODE = '$sbmt[CHARGE_CODE]',
						TANGGAL_KWITANSI= '$sbmt[TANGGAL_KWITANSI]',
						TOTAL 			= '$sbmt[TOTAL]',
						KETERANGAN		= '$sbmt[KETERANGAN]'
						
				WHERE
						CLAIM_ID = '$sbmt[CLAIM_ID]' ";

		// return $sql;
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		if($ack == 1) 
		{
		if (($sbmt['KATEGORI']=='2' ) && ($sbmt['status_id']=='7' )){
			$sql_delete_notif = "DELETE FROM
							  tb_r_notification  WHERE FORM_TYPE_ID = 5 AND FORM_ID ='$sbmt[CLAIM_ID]' AND
							RECIPIENT_EMPLOYEE_ID = '$sbmt[this_id]' ";
		
								
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
								  '$sbmt[statRevise]',
						         '5',
						         '$sbmt[CLAIM_ID]',
						         'No. Ref: $sbmt[ref_no]',
						         '1',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."',
						         'user: $sbmt[this_email]',
								 '".gmdate("Y-m-d H:i:s", time()+60*60*7)."')";	
								 
			$sql_delete = "DELETE FROM tb_r_edit 
							 WHERE FORM_TYPE_ID = '5' AND FORM_ID = 
								 '$sbmt[CLAIM_ID]'";	
			$sql_edit = "INSERT INTO
							  tb_r_edit (FORM_TYPE_ID,
							  					FORM_ID,
							  					CHARGE_CODE,
							  					RECEIPT_DATE,
												AMOUNT,
												REMARKS)
					VALUES
								('5',
								 '$sbmt[CLAIM_ID]',
								  '$sbmt[ORI_CHARGE_CODE]',
						         '$sbmt[ORI_DATE]',
						        '$sbmt[ORI_AMOUNT]',
						         '$sbmt[ORI_REMARKS]')";	
			
			$this->db->trans_start();
				$this->db->query($sql_delete_notif);
				$this->db->query($sql_delete);
				$this->db->query($sql_edit);
				$this->db->query($sql);
			if($this->db->trans_complete())
		$tujuan = $sbmt['APPROVAL_EMAIL']; //mengambil email RM
        $judul = "Expense Claim"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$sbmt['APPROVAL_NAME']."</b>, <br><br>
                <b>".$sbmt['this_name']." </b> have to revise application for Expense Claim.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAS for Approve Expense Claim</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
		//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAS - Expense Claim \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success<br>";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed<br>";//jika tidak terkirim
        }
				{
					$ack = 2;
				}
			}
			
		}
		if ($ack == 2)
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='8'
					WHERE 
						FORM_TYPE_ID = '5'AND
						FORM_ID ='$sbmt[CLAIM_ID]'";
						
		
			if($this->db->query($sql))
			{
				$ack = 3;
			}
		}
		return $ack;
		}
		
	function get_charge_code($id)
	{
		
		$sql = " SELECT
							cc.CHARGE_CODE_ID id,
							cc.CHARGE_CODE ccname,
							cc.PROJECT_DESCRIPTION name								
				FROM
							tb_m_charge_code cc 
				WHERE
							TYPE IN (SELECT
                        cc.TYPE cctype
				FROM
						tb_r_claim cl,
						tb_m_employee empl,
						tb_m_user usr,
						tb_m_system sys, 
						tb_m_charge_code cc
				WHERE
						cl.CLAIM_ID = '$id' AND 
						(cc.CHARGE_CODE = cl.CHARGE_CODE OR 
						empl.DIVISION_ID = cl.CHARGE_CODE) AND    
						
						cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						cl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND  
						cc.TYPE = sys.SYS_CD AND
						sys.SYS_CAT = 11) AND
							STATUS = '1'";
							
		return fetchArray($sql, 'all');
	}
	
	function get_tipechargecode($id){
	$sql = " SELECT
							cc.CHARGE_CODE_ID id,
							cc.CHARGE_CODE ccname,
							cc.PROJECT_DESCRIPTION name,
                            cc.DIVISION_ID,
							cc.TYPE val_type
				FROM
							tb_m_charge_code cc 
				WHERE
							TYPE IN (SELECT
                        cc.TYPE cctype
				FROM
						tb_r_claim cl,
						tb_m_employee empl,
						tb_m_user usr,
						tb_m_system sys, 
						tb_m_charge_code cc
				WHERE
						cl.CLAIM_ID = '".$id."' AND 
						(cc.CHARGE_CODE = cl.CHARGE_CODE OR 
						empl.DIVISION_ID = cl.CHARGE_CODE) AND    
						
						cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						cl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND  
						cc.TYPE = sys.SYS_CD AND
						sys.SYS_CAT = 11) AND
						STATUS = '1'";
							
		return fetchArray($sql, 'row');
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
					sys.SYS_CD = cc.TYPE   GROUP BY cc.TYPE ";
		return fetchArray($sql, 'all');
	}
	
	function get_thisCC($id){
		$sql = "SELECT
                       cl.CHARGE_CODE ch
				FROM
						tb_r_claim cl,
                     tb_m_charge_code cc
				WHERE
						cl.CLAIM_ID = '".$id."' AND
                     cc.CHARGE_CODE = cl.CHARGE_CODE";
		return fetchArray($sql,'row');
	}
	
	function get_approval_pro()
	{
		$sql = "SELECT 
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
	
	function get_ccByTipe($id){
			$sql = "SELECT
							CHARGE_CODE,
							PROJECT_DESCRIPTION,
							TYPE,
							DIVISION_ID
							
				FROM
							tb_m_charge_code 
				WHERE
							TYPE = '".$id."' AND
							STATUS = '1'";
		return fetchArray($sql, 'all');
		}
		function get_ccByCC($id){
			$sql = "SELECT
							cc.CHARGE_CODE cccode,
							cc.PROJECT_DESCRIPTION descrip,
							cc.TYPE tipe,
							cc.DIVISION_ID div_id,
							empl.DIVISION_ID id,
							empl.EMPLOYEE_ID empid,
							empl.EMPLOYEE_NAME approval
							
				FROM
							tb_m_charge_code cc,
							tb_m_employee empl,tb_m_position_depth pos
				WHERE
							((pos.POSITION_DEPTH_ID = '3' AND empl.POSITION_DEPTH_ID = '3')  or pos.POSITION_DEPTH_ID = '2') and
							empl.POSITION_DEPTH_ID = pos.POSITION_DEPTH_ID AND
							cc.CHARGE_CODE = '".$id."' AND
							cc.STATUS = '1' AND 
							cc.DIVISION_ID = empl.DIVISION_ID";
			return fetchArray($sql, 'all');
		}
		
		// update Feb-Maret 2015
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
					tnj.EXPENSE_TYPE_ID ='$type'";							
		return fetchArray($sql, 'row');
	}
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
					rbnt.EXPENSE_TYPE_ID ='$type' ";
		return fetchArray($sql, 'row');
	}
	
	// ambil sisa tunjangan berdasarkan perubahan tanggal kwitansi
	function get_tunjangan($employeeID, $expense, $year, $month)
	{
		$sql = "SELECT IFNULL ((SELECT
							tnj.REMAIN_AMOUNT amount							
				FROM
							tb_m_employee empl,
                            tb_m_user us,
							tb_r_tunjangan tnj
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
                            tnj.EXPENSE_TYPE_ID = '$expense' AND 
							empl.EMPLOYEE_ID = '$employeeID' AND
							tnj.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
							tnj.AVAILABLE = '1' AND 
							tnj.YEAR = '$year'  AND
							tnj.MONTH = '$month'
				ORDER BY empl.EMPLOYEE_NAME ASC),0) as amount ";
		return fetchArray($sql, 'all');
	}
		
		
	
}