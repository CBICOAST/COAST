 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS041
* Program Name     : Detail Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 16-11-2014 08:54:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/



if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS041 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//Menampilkan detail CA
	function get_form_detail($form_id)
	{
		$sql = "SELECT
						cl.REF_NO no_ref,
                       (select bt.REF_NO from tb_r_bt bt where cl.BT_ID = bt.BT_ID) no_ref_bt,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						(select pl.LEVEL_NAME from tb_m_position_level pl where empl.LEVEL_ID=pl.LEVEL_ID) level_name,
					    usr.USER_EMAIL employee_email,
					    cl.CA_ID ca_id,
                        cl.CHARGE_CODE chargecode,
                        (select pos.VALUE from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  categorycc_name,
					    (select cc.PROJECT_DESCRIPTION from tb_m_system pos, tb_m_charge_code cc  where pos.SYS_CAT= '11' and cc.CHARGE_CODE = cl.CHARGE_CODE and pos.SYS_CD = cc.TYPE )  cc_name,
					    fs.TARGET_EMPLOYEE_ID aprove,  
						fs.DIR_APPROVE dir_approve,
						fs.F2_APPROVE f2_approve,
						(select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.F2_APPROVE )  f2_name, 
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						cl.CREATED_DT submitted_dt, 
						cl.AMOUNT amount,
					    ct.CA_TYPE_ID type_id,
					    ct.CA_TYPE ca_type,
                        ct.CA_CATEGORY category_id,
						cl.DESTINATION destination,
						(select cost.DESTINATION from tb_m_ca_cost cost  where cost.COST_ID = cl.DESTINATION)  destination_name,
                     
						cl.CURRENCY currency,
						(select cost.NOMINAL from tb_m_setting_limit_dir cost  where cost.CURRENCY = cl.CURRENCY)  limit_dir,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = cl.CURRENCY )  currency_name,
						cl.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = cl.PAYMENT_METHOD )  pay_method_name,
						cl.REMARK remarks,
                        cl.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = cl.STATUS )  form_status_name,
					    sys.VALUE status,
					    fs.STATUS status_id,
						cl.SETTLEMENT_STATUS set_stat,
						(select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '18' and sys.SYS_CD = fs.STATUS )  status_name,
						DATE_FORMAT(fs.REVISE_APPROVAL_DT,'%d %b %Y %T') revise_approved_dt,
						fs.REVISE_APPROVAL_BY revise_approved_by,
                        fs.REVISE_APPROVAL_REMARKS revise_remarks_approval,
					    DATE_FORMAT(fs.CREATED_DT,'%d %b %Y %T') approved_dt,
						fs.CREATED_BY approved_by,
                        fs.REMARKS remarks_approval,
                        DATE_FORMAT(fs.APPROVEDIR_DT,'%d %b %Y %T') approveddir_dt,
                        fs.APPROVEDIR_BY approveddir_by,
                        fs.REMARKS_DIR remarks_dir,
                        DATE_FORMAT(fs.REVISE_APPROVEF2_DT,'%d %b %Y %T') revise_approvedf2_dt,
                        fs.REVISE_APPROVEF2_BY revise_approvedf2_by,
                        fs.REVISE_REMARKS_F2 revise_remarks_f2,
                        DATE_FORMAT(fs.APPROVEF2_DT,'%d %b %Y %T') approvedf2_dt,
                        fs.APPROVEF2_BY approvedf2_by,
                        fs.REMARKS_F2 remarks_f2,
						fs.REMARKS_GR remarks_finance,
                        DATE_FORMAT(fs.UPDATED_DT,'%d %b %Y %T') accepted_dt,
                        fs.UPDATED_BY accepted_by
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_ca cl,
					    tb_m_user usr,
					    tb_m_ca_type ct,
					    tb_m_system sys
				    
				WHERE
					    cl.CA_ID = '$form_id' AND
					    cl.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cl.CA_TYPE_ID = ct.CA_TYPE_ID AND
					    sys.SYS_CAT = '18' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = cl.CA_ID AND
					    fs.FORM_TYPE_ID = '2' ";	
		return fetchArray($sql, 'row');
	}
	function get_settle_detail($form_id)
	{
		$sql = "SELECT
					setl.amount used,
					setl.RECEIPT_DATE tgl_bukti,
					setl.REMAINING sisa,
					setl.AMOUNT_SETTLEMENT balance,
					 ca.AMOUNT diberikan,
					(SELECT sys.VALUE  from tb_r_settlement setl, tb_m_system sys
						WHERE   sys.SYS_CAT = 17 AND sys.SYS_CD = setl.PAYMENT_METHOD 
						and setl.FORM_ID = '$form_id') setl_pay_method,
					DATE_FORMAT(setl.CREATED_DT,'%d %b %Y %T')  tgl_bwt,
					setl.REMARKS remark,
					DATE_FORMAT(setl.ACCEPTED_DT,'%d %b %Y %T') accepted_dt,
					setl.ACCEPTED_BY accepted_by,
					setl.REMARKS_ACCEPTED remarks_accepted,
					(select sys.VALUE from  tb_r_form_status fs, tb_r_settlement setl,tb_m_system sys
					where setl.FORM_ID = fs.FORM_ID AND setl.FORM_ID = '$form_id' AND fs.FORM_TYPE_ID = '2' and sys.SYS_CAT = 18 AND sys.SYS_CD = fs.STATUS) set_status
				FROM 
					tb_r_settlement setl,
					tb_r_ca ca
				WHERE 
					ca.CA_ID = setl.FORM_ID AND
					ca.CA_ID = '$form_id' ";	
		return fetchArray($sql, 'row');
	}
}