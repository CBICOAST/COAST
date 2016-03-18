 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS080
* Program Name     : Form Detail Purchase Order
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS080 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	function get_list_tmppr($form_id)
	{
	$sql = "SELECT 	            rpr.NO no,
					rpr.QTY qty,
					rpr.SATUAN satuan,
					rpr.NAMA nama,
					rpr.HARGA harga,
					rpr.TOTAL total,
                    po.AMOUNT_PPN ppn,
                    po.AMOUNT_TOTAL subtotal
					
		FROM 	tmp_item_pr rpr,
                 tb_r_po po,
                 tb_r_pr pr, 
                 tb_r_form_status fs,
                 tb_m_employee empl,
                 tb_m_charge_code cc, 
	           	tb_m_user usr,
		        tb_m_system sys
				
		WHERE
		po.PR_ID = '$form_id' AND
        po.PR_ID = pr.PR_ID AND
        pr.PR_ID = rpr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'";
	return fetchArray($sql, 'all');
	}
	
	//Memanggil detail CA
	function get_form_detail($form_id)
	{
		$sql = "SELECT  
        po.REF_NO no_ref,
        po.PO_ID po_id,
		pr.REF_NO no_ref_pr,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        po.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.TYPE cctype,
        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarkspur,
		fs.CREATED_DT approvepur_dt,
		fs.CREATED_BY approvepur_by,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id,
		(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '26' AND sys.SYS_CD = fs.STATUS) status_name,
		po.CREATED_BY createdbypo,
		po.CREATED_DT createddtpo,
		po.REMARK remarkpo,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,
        pr.VENDOR vendor,
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
        pr.2ND_PAYMENT k2_pay,
        pr.DATE_2PAYMENT tgl2,
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE 
        po.PR_ID = '$form_id' AND
        po.PR_ID = pr.PR_ID AND 
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_TYPE_ID = '7'
ORDER BY 
         po.PO_ID desc				
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
function status_po($form_id){
$sql = " SELECT
		fcl.STATUS status_confirm
		
		FROM
		tb_r_form_confirmation_list fcl,
		tb_r_form_status fs,
		tb_r_po po
		
		WHERE
		
		po.PO_ID = '$form_id' AND
		fs.FORM_ID = po.PO_ID AND
		fs.STATUS = 1 AND
		fs.FORM_TYPE_ID = 7 AND
		fcl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
		fcl.FORM_ID = fs.FORM_ID" ;
	return fetchArray($sql, 'all');	
}	
}