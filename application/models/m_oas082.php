 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS077
* Program Name     : Detail Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 24-02-2015 16:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS082 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
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
	
	function get_list_doc($form_id)
	{
	$sql = "SELECT 	
					NAMAFILE namafile,
					DOCCUMENT document
			FROM documment 
			where PR_ID = '$form_id'";
	return fetchArray($sql, 'all');
	}
	
	//Memanggil detail CA
	function get_form_detail($form_id)
	{
		$sql = "SELECT  
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
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,		
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = pr.B_STATUS )  pay_method_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarksrm,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEGR_DT approvegr_dt,
		fs.APPROVEGR_BY approvegr_by,
		fs.REMARKS_GR remarksgr,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEPUR_DT approvepur_dt,
		fs.APPROVEPUR_BY approvepur_by,
		fs.REMARKS_PUR remarkspur,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
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
		pr.DIBUAT_PO buat_po,
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
        pr.DOCUMENTSUPPORT supdoc,
        (select vn.COMPANY from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendor,
		(select vn.ATTN from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendorattn,
		(select vn.ADDRESS from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendoradd,
		(select vn.CITY from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendorcity,
		(select vn.PHONE from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendorphone,
		(select vn.ZIP from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendorzip,
		(select vn.FAX from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendorfax,
        (select st.S_COMPANY from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  companyst,
        (select st.S_CP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  cpst,
        (select st.S_ADDRESS from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  alamatst,
        (select st.S_TELP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  telpst,
        (select st.S_EMAIL from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  emailst,
        (select st.S_NPWP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  npwpst, 
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '28' and sys.SYS_CD = pr.DIBUAT_PO )  dibuat_po,
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
		pr.REMARK_P1 rp1,
		pr.REMARK_P2 rp2,
		pr.REMARK_P3 rp3,
		pr.REMARK_P4 rp4,		
        pr.2ND_PAYMENT k2_pay,
        pr.DATE_2PAYMENT tgl2,
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4
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
								('$status[FINAL_APPROVE]',
								 '$status[REQUESTER]',
								 '14',
						         '4',
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
		
		if($ack == 1)
		{
		//menghapus notifikasi
		$sql = "DELETE FROM tb_r_notification
						WHERE
                         ACTIVITY_TYPE_ID = '13' AND 
						FORM_ID ='$status[FORM_ID]'";}
		if($this->db->query($sql))
		
			{
				$ack = 2;
			}
						
		return $ack;
	} 
}
