  <?php
 /************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS068
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS068 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function get_info($id)
	{
		$sql = "SELECT
						bt.REF_NO no_ref,
					    empl.EMPLOYEE_NAME employee_name,
					    empl.EMPLOYEE_ID employee_id,
						empl.GROUP_ID employee_group,
						usr.USER_EMAIL employee_email,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
					    empl.DIVISION_ID employee_division,
					    (select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
					    usr.USER_EMAIL employee_email,
					    bt.BT_ID bt_id,
                        bt.CLIENT_NAME client_name,
                        bt.BUSINESS_PURPOSE bt_purpose, 
						bt.CUSTOMER_LOCATION location,
                        bt.CHARGE_CODE chargecode,
                         bt.DEPARTURE departure, 
						bt.RETURN_DATE return_dt,
                         bt.DURATION duration,
						cc.PROJECT_DESCRIPTION ccdes,
                        cc.TYPE cctype,
                        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
					    cc.PROJECT_DESCRIPTION  cc_name,
					    fs.TARGET_EMPLOYEE_ID approval,  
                        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,            
						fs.DIR_APPROVE dir_approve,
						fs.FINAL_APPROVE finance,
						bt.CREATED_DT submitted_dt,
                         bt.AMOUNTDIM amount_dim,
                        bt.TRANSPORTAMOUNT amount_ca,
                        bt.TOTAL_AMOUNT_TRANSPORTATION amount_transport,
                        bt.TOTAL_AMOUNT_ACOMODATION amount_hotel,
					    bt.TRANSPORTATION_BY type_id,
					    cost.COST_ID ca_type,
                        cost.COST category_id,
						bt.DESTINATION destination,
						bt.CURRENCY currency,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = bt.CURRENCY )  currency_name,
						bt.PAYMENT_METHOD pay_method,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = bt.PAYMENT_METHOD )  pay_method_name,
						bt.REMARK remarks,
                        bt.STATUS form_status,
                        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '15' and sys.SYS_CD = bt.STATUS )  form_status_name,
					    sys.VALUE status,
						fs.TARGET_EMPLOYEE_ID aprove,
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
						tb_r_bt bt,
					    tb_m_ca_cost cost,
                        tb_m_charge_code cc, 
						tb_m_user usr,
					    tb_m_system sys
				WHERE
					    bt.BT_ID = '$id' AND
					    bt.CHARGE_CODE = cc.CHARGE_CODE AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cost.COST_ID = bt.DESTINATION AND
					    sys.SYS_CAT = '21' AND
						usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'";
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
						
						CHARGE_CODE= '$sbmt[CHARGE_CODE]',
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
								 '4',
						         '5',
						         '$sbmt[CLAIM_ID]',
						         'No. Ref: $sbmt[ref_no]',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         'user: $sbmt[this_email]',
					         	 '".date("Y-m-d H:i:s")."')";	

			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		if ($ack == 2)
		{
			$sql = "UPDATE 
						tb_r_form_status 
					SET 
						STATUS='0'
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
						tb_r_bt bt,
						tb_m_employee empl,
						tb_m_user usr,
						tb_m_system sys, 
						tb_m_charge_code cc
				WHERE
						bt.BT_ID = '$id' AND 
						(cc.CHARGE_CODE = bt.CHARGE_CODE OR 
						empl.DIVISION_ID = bt.CHARGE_CODE) AND    
						
						bt.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						bt.EMPLOYEE_ID = usr.EMPLOYEE_ID AND  
						cc.TYPE = sys.SYS_CD AND
						sys.SYS_CAT = 11) AND
							STATUS = '1'
				
				";
							
		return fetchArray($sql, 'all');
	}
	
	function get_tipechargecode($id){
	$sql = " SELECT
						bt.BT_ID bt_id,
						bt.REF_NO ref_no,
						bt.CHARGE_CODE charge_code,
                        cc.TYPE cctype,
						cc.PROJECT_DESCRIPTION descrip,	
						sys.VALUE val_type
				FROM
						tb_r_bt bt,
						tb_m_employee empl,
						tb_m_user usr,
						tb_m_system sys, 
						tb_m_charge_code cc
				WHERE
						bt.BT_ID = '$id' AND 
						(cc.CHARGE_CODE = bt.CHARGE_CODE OR 
						empl.DIVISION_ID = bt.CHARGE_CODE) AND    
						
						bt.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
						bt.EMPLOYEE_ID = usr.EMPLOYEE_ID AND  
						cc.TYPE = sys.SYS_CD AND
						sys.SYS_CAT = 11
				";
							
		return fetchArray($sql, 'row');
	}

	
}