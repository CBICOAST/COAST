  <?php 
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS067 extends CI_Model {
	
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
					   (select dim.DIM_AMOUNT from tb_m_position_level dim where dim.LEVEL_ID = empl.LEVEL_ID )  dim_amount, 
                       
                       usr.USER_EMAIL employee_email, 
                       bt.BT_ID bt_id,
                       bt.EMPLOYEE_ID submitter,
                       (select app.EMPLOYEE_NAME from tb_m_employee app where app.EMPLOYEE_ID = bt.EMPLOYEE_ID )  submitter_name, 
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
                       fs.CREATED_DT approved_dt,
                       fs.CREATED_BY approved_by,
                       fs.REMARKS remarks_approval,
                       fs.APPROVEDIR_DT approvedga_dt,
                       fs.APPROVEDIR_BY approvedga_by,
                       fs.REMARKS_DIR remarks_ga,
                       fs.UPDATED_DT accepted_dt,
                       fs.UPDATED_BY accepted_by
				    
				FROM 
						tb_r_form_status fs,
						tb_m_employee empl,
						tb_r_bt bt,
                        tb_m_charge_code cc,
                        tb_m_ca_cost cost,
					    tb_m_user usr,
					    tb_m_system sys
				    
				WHERE
					    bt.BT_ID = '$form_id' AND
					    bt.TRAVELLER_ID = empl.EMPLOYEE_ID AND
					    empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
					    cc.CHARGE_CODE = bt.CHARGE_CODE AND
                        cost.COST_ID = bt.DESTINATION AND                   
					    sys.SYS_CAT = '21' AND
					    sys.SYS_CD = fs.STATUS AND
					    fs.FORM_ID = bt.BT_ID AND
					    fs.FORM_TYPE_ID = '3'";	
		return fetchArray($sql, 'row');
	}
	
	//mengambil data transport
	
	function get_list_tr($bt)
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
						tr.ARRIVAL_DATE_IN_REGION_OF_ORIGIN tgl_pulang,
						tr.A_HOUR_R jam_pulang,
						tr.A_MINUTE_R menit_pulang,
						tr.DEPARTURE_FROM_THE_DESTINATION tgl_sampe_kembali,
						tr.D_HOUR_R jam_sampe_kembali,
						tr.D_MINUTE_R menit_sampe_kembali,
						tr.PRICE_ARRIVAL price_arrival,
						tr.PRICE_DEPARTURE price_departure,
						tr.REMARK remark
				FROM 	tb_r_bt bt,
						tb_r_transportation tr
				WHERE 	bt.BT_ID = tr.BT_ID AND
						bt.BT_ID = '$bt'";	
		return fetchArray($sql, 'all');
	}
	
	function list_class(){
	$sql = "SELECT VALUE class
				FROM 	tb_m_system
            WHERE SYS_CAT='23'";	
		return fetchArray($sql, 'all');
	}
	
	function list_h_m(){
	$sql = "SELECT VALUE, SUBSTRING(VALUE,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24'
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	function list_h_m_h(){
	$sql = "SELECT VALUE, SUBSTRING(VALUE,1,2) * 1 AS urut
				FROM 	tb_m_system
            WHERE SYS_CAT='24' AND
            VALUE < 25
           ORDER BY urut ASC";	
		return fetchArray($sql, 'all');
	}
	
	function transport_save($data)
	{
		$this->db->query( "INSERT INTO tb_r_transportation 
								(BT_ID,
                                DESTINATION,
                                TRANSPORTATION,
                                TRANSPORTATION_CLASS,
                                ARRIVAL_DATE_IN_DESTINATION,
                                A_HOUR_D,
								A_MINUTE_D,
								DEPARTURE_FROM_THE_REGION_OF_ORIGIN,
                                D_HOUR_D,
								D_MINUTE_D,
								ARRIVAL_DATE_IN_REGION_OF_ORIGIN,
                                A_HOUR_R,
								A_MINUTE_R,
								DEPARTURE_FROM_THE_DESTINATION,
                                D_HOUR_R,
								D_MINUTE_R,
								PRICE_ARRIVAL,
                                PRICE_DEPARTURE,
                                REMARK)
VALUES ('$data[BT_ID]',
       '$data[DESTINATION]',
       '$data[TRANSPORTATION]',
       '$data[TRANSPORTATION_CLASS]',
       '$data[ARRIVAL_DATE_IN_DESTINATION]',
	   '$data[A_HOUR_D]',
	   '$data[A_MINUTE_D]',
       '$data[DEPARTURE_FROM_THE_REGION_OF_ORIGIN]',
	   '$data[D_HOUR_D]',
	   '$data[D_MINUTE_D]',
       '$data[ARRIVAL_DATE_IN_REGION_OF_ORIGIN]',
	   '$data[A_HOUR_R]',
	   '$data[A_MINUTE_R]',
       '$data[DEPARTURE_FROM_THE_DESTINATION]',
	   '$data[D_HOUR_R]',
	   '$data[D_MINUTE_R]',
       '$data[PRICE_ARRIVAL]',
       '$data[PRICE_DEPARTURE]',
       '$data[REMARK]')");
	}
}