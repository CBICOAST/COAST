<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_RSC_FILL_TIMESHEET extends CI_Model {

	

	function __construct() {

		parent::__construct();

		//$this->user	= unserialize(base64_decode($this->session->userdata('user')));

	}
        function get_employee_list()
	{
		$sql = "SELECT
				EMPLOYEE_ID,
                                EMPLOYEE_NAME			
				FROM
				tb_m_employee
				ORDER BY EMPLOYEE_NAME ASC";
		return fetchArray($sql, 'all');
	}
        
        function get_chargecode_list(){
            
            $sql="SELECT 
                CHARGE_CODE as id,
                PROJECT_DESCRIPTION as text
                FROM 
                tb_m_charge_code
                ORDER BY CHARGE_CODE ASC";
            return json_encode(fetchArray($sql, 'all'));
        }
        
        function get_activity_code(){
            $sql="SELECT 
                act_code as id,
                activity as text
                FROM 
                tb_m_activity
                ORDER BY act_code ASC";
            return json_encode(fetchArray($sql, 'all'));
        }
       function get_max_min($tanggal){
           $sql="SELECT 
               max(tanggal) as max_date,
               min(tanggal) as min_date
               from tb_m_ts where periode_date='$tanggal'";
          return fetchArray($sql, 'all');
       }
       function get_holiday_date($date){
           $sql="SELECT 
               date_format(tanggal,'%Y-%c-%e') holiday_date
               FROM tb_m_ts 
               where periode_date='$date' 
               and holiday='H';";
           return fetchArray($sql, 'all');
       }
       function upload_timesheet($data){
           $this->db->trans_start();    
             $this->db->insert_batch('tb_r_timesheet',$data);
             $this->db->trans_commit();
             if($this->db->trans_status()==FALSE){
                 return 'gagal';
             }
             else{
                 $sql="SELECT * FROM tb_r_timesheet";
                 return fetchArray($sql, 'all');
             }
       }
}
?>
