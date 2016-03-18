<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS062
* Program Name     : Form Approval BT
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 01-12-2014 16:00:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS062 extends CI_Model {
	
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
                       usr.USER_EMAIL employee_email, 
                       bt.BT_ID bt_id,
                       bt.EMPLOYEE_ID submitter,
                       (select app.EMPLOYEE_NAME from tb_m_employee app where app.EMPLOYEE_ID = bt.EMPLOYEE_ID )  submitter_name, 
					   (SELECT CASE WHEN bt.DESTINATION = '1' then dim.DIM_AMOUNT
                       WHEN bt.DESTINATION = '2' then dim.DIM_AMOUNT_DOMESTIK WHEN bt.DESTINATION = '3' then dim.DIM_AMOUNT_INTERNATIONAL END) dim_amount,
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
					   (select sIs.VALUE from tb_m_system sIs where sIs.SYS_CAT= '21' and sIs.SYS_CD = fs.STATUS and fs.FORM_TYPE_ID ='3' )  status_name,
                       fs.CREATED_DT approved_dt,
                       fs.CREATED_BY approved_by,
                       fs.REMARKS remarks_approval,
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
	
	
	function get_form_detail_transport($form_id)
	{
		$sql = "SELECT 	bt.BT_ID bt_id,
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
						bt.BT_ID = '$form_id'";	
		return fetchArray($sql, 'row');
	}
	
	function get_form_detail_ac($form_id)
	{
		$sql = "SELECT 	bt.BT_ID bt_id,
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
						bt.BT_ID = '$form_id'";	
		return fetchArray($sql, 'row');
	}

	}