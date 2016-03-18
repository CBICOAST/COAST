<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : RESOURCE_TIMESHEET
* Program Name     : List Timesheet
* Description      : Daftar Timesheet yang belum terisi oleh resource
* Environment      : PHP 5.4.4
* Author           : Abi Sa'ad Dimyati
* Version          : 01.00.00
* Creation Date    : 07-03-2016 11:10:00
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_RESOURCE_TIMESHEET extends CI_Model {

	

	function __construct() {

		parent::__construct();

		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

	}
        
        function list_unfill_timesheet($employee_id){
            
            $sql = "select distinct 
DATE_FORMAT(periode_date,'%b %Y ') char_period,
periode_date as date_period 
from tb_m_ts order by periode_date desc";	

		return fetchArray($sql, 'all');
        }
        function get_employee_list($employee_id)
	{
		$sql = "SELECT
				EMPLOYEE_ID as id,
                                EMPLOYEE_NAME as text			
				FROM
				tb_m_employee where EMPLOYEE_ID<>'$employee_id'
				ORDER BY EMPLOYEE_NAME ASC";
		return fetchArray($sql, 'all');
	}
        function get_employee($employee_id)
	{
		$sql = "SELECT
				EMPLOYEE_ID,
                                EMPLOYEE_NAME			
				FROM
				tb_m_employee
				where EMPLOYEE_ID='$employee_id'";
		return fetchArray($sql, 'all');
	}
        
        function get_chargecode_list(){
            
            $sql="SELECT 
                CHARGE_CODE as id,
                PROJECT_DESCRIPTION as text
                FROM 
                tb_m_charge_code
                ORDER BY CHARGE_CODE ASC";
            return fetchArray($sql, 'all');
        }
        
        function get_activity_code(){
            $sql="SELECT 
                act_code as id,
                activity as text
                FROM 
                tb_m_activity
                ORDER BY act_code ASC";
            return fetchArray($sql, 'all');
        }
       function get_max_min($tanggal){
           $sql="SELECT max(tgl.Fulldate) max_date,min(tgl.Fulldate) min_date FROM (SELECT '$tanggal' + INTERVAL a + b DAY Fulldate, Dayname('$tanggal' + INTERVAL a + b DAY) Dayname,
CASE
WHEN (Dayname('$tanggal' + INTERVAL a + b DAY) IN ('Sunday','Saturday')) 
OR 
(SELECT KETERANGAN FROM tb_m_tanggal_libur libur WHERE libur.TANGGAL = '$tanggal' + INTERVAL a + b DAY) is not null THEN 1
ELSE 0
END as Status 
FROM
 (SELECT 0 a UNION SELECT 1 a UNION SELECT 2 UNION SELECT 3
    UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
    UNION SELECT 8 UNION SELECT 9 ) d,
 (SELECT 0 b UNION SELECT 10 UNION SELECT 20 
    UNION SELECT 30 UNION SELECT 40) m
WHERE '$tanggal' + INTERVAL a + b DAY  <  Date_add('$tanggal',INTERVAL 1 MONTH)
ORDER BY a + b) as tgl";
          return fetchArray($sql, 'all');
       }
       function get_holiday_date($date){
           $sql="SELECT date_format(tgl.Fulldate,'%Y-%c-%e') holiday_date FROM (SELECT '$date' + INTERVAL a + b DAY Fulldate, Dayname('$date' + INTERVAL a + b DAY) Dayname,
CASE
WHEN (Dayname('$date' + INTERVAL a + b DAY) IN ('Sunday','Saturday')) 
OR 
(SELECT KETERANGAN FROM tb_m_tanggal_libur libur WHERE libur.TANGGAL = '$date' + INTERVAL a + b DAY) is not null THEN 1
ELSE 0
END as Status 
FROM
 (SELECT 0 a UNION SELECT 1 a UNION SELECT 2 UNION SELECT 3
    UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
    UNION SELECT 8 UNION SELECT 9 ) d,
 (SELECT 0 b UNION SELECT 10 UNION SELECT 20 
    UNION SELECT 30 UNION SELECT 40) m
WHERE '$date' + INTERVAL a + b DAY  <  Date_add('$date',INTERVAL 1 MONTH)
ORDER BY a + b) as tgl where tgl.Status=1";
           return fetchArray($sql, 'all');
       }
       function set_holiday_date($periode,$date){
           $sql="SELECT tgl.Status as Holiday_Status FROM (SELECT '$periode' + INTERVAL a + b DAY Fulldate, Dayname('$periode' + INTERVAL a + b DAY) Dayname,
CASE
WHEN (Dayname('$periode' + INTERVAL a + b DAY) IN ('Sunday','Saturday')) 
OR 
(SELECT KETERANGAN FROM tb_m_tanggal_libur libur WHERE libur.TANGGAL = '$periode' + INTERVAL a + b DAY) is not null THEN 'Yes'
ELSE 'No'
END as Status 
FROM
 (SELECT 0 a UNION SELECT 1 a UNION SELECT 2 UNION SELECT 3
    UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
    UNION SELECT 8 UNION SELECT 9 ) d,
 (SELECT 0 b UNION SELECT 10 UNION SELECT 20 
    UNION SELECT 30 UNION SELECT 40) m
WHERE '$periode' + INTERVAL a + b DAY  <  Date_add('$periode',INTERVAL 1 MONTH)
ORDER BY a + b) as tgl where tgl.Fulldate='$date'";
           return fetchArray($sql, 'all');
       }
       function upload_timesheet($data,$periode,$employee_id){
           $this->db->trans_start();    
             $this->db->insert_batch('tb_r_timesheet',$data);
             $this->db->trans_commit();
             if($this->db->trans_status()==FALSE){
                 return 'gagal';
             }
             else{
                 $sql="SELECT 
   a.employee_id,
	a.periode_date,
	a.approved_by,
	a.date_ts,
	a.work_desc,
	a.holiday,
	a.hours,
	a.charge_code,
	a.act_code,
	c.activity,
	b.PROJECT_DESCRIPTION project_desc,
	a.status
 FROM tb_r_timesheet as a 
 left join tb_m_charge_code as b on a.charge_code=b.CHARGE_CODE 
 left join tb_m_activity as c on a.act_code=c.act_code  where periode_date='$periode' and employee_id='$employee_id' order by date_ts asc";
                 return fetchArray($sql, 'all');
             }
       }
       function count_sheet_perperiode($id_employee,$periode){
           $sql="SELECT COUNT(*) jml_data_sheet FROM tb_r_timesheet where employee_id='$id_employee' and periode_date='$periode'";
           return fetchArray($sql, 'all');
       }
       function get_timesheet_data($id_employee,$periode){
           $sql="SELECT 
   a.employee_id,
	a.periode_date,
	a.approved_by,
	a.date_ts,
	a.work_desc,
	a.holiday,
	a.hours,
	a.charge_code,
	a.act_code,
	c.activity,
	b.PROJECT_DESCRIPTION project_desc,
	a.status
 FROM tb_r_timesheet as a 
 left join tb_m_charge_code as b on a.charge_code=b.CHARGE_CODE 
 left join tb_m_activity as c on a.act_code=c.act_code where a.employee_id='$id_employee' and a.periode_date='$periode' order by date_ts";
           return fetchArray($sql, 'all');
       }
       function get_timesheet_edit_data($id_employee,$periode,$date,$chargecode,$act_code){
           $sql="SELECT * FROM tb_r_timesheet where employee_id='$id_employee' and periode_date='$periode' and date_ts='$date' and charge_code='$chargecode' and act_code='$act_code'";
           return fetchArray($sql, 'all');
       }
       function edit_timesheet($data){
           $ack=0;
           $sql="UPDATE tb_r_timesheet SET work_desc='$data[work_desc]',date_ts='$data[date_ts]',approved_by='$data[approved_by]',holiday='$data[holiday]',hours='$data[hours]',charge_code='$data[charge_code]',act_code='$data[act_code]'   
WHERE employee_id='$data[employee_id]' 
AND periode_date='$data[periode_date]'  
AND date_ts='$data[date_ts2]'
AND charge_code='$data[charge_code2]' 
AND act_code='$data[act_code2]'";
           if($this->db->query($sql)){
               $ack=1;
           }
           if($ack==1){
               $sql="SELECT 
   a.employee_id,
	a.periode_date,
	a.approved_by,
	a.date_ts,
	a.work_desc,
	a.holiday,
	a.hours,
	a.charge_code,
	a.act_code,
	c.activity,
	b.PROJECT_DESCRIPTION project_desc,
	a.status
 FROM tb_r_timesheet as a 
 left join tb_m_charge_code as b on a.charge_code=b.CHARGE_CODE 
 left join tb_m_activity as c on a.act_code=c.act_code  where periode_date='$data[periode_date]' and employee_id='$data[employee_id]' order by date_ts asc";
               return fetchArray($sql, 'all');
           }
       }
       function delete_timesheet($data){
           $ack=0;
           $sql="DELETE FROM tb_r_timesheet WHERE  employee_id='$data[employee_id]' AND date_ts='$data[date_ts]' AND charge_code='$data[charge_code]' AND act_code='$data[act_code]'";
           
           if($this->db->query($sql)){
               $ack=1;
           }
           if($ack==1){
               $sql="SELECT 
   a.employee_id,
	a.periode_date,
	a.approved_by,
	a.date_ts,
	a.work_desc,
	a.holiday,
	a.hours,
	a.charge_code,
	a.act_code,
	c.activity,
	b.PROJECT_DESCRIPTION project_desc,
	a.status
 FROM tb_r_timesheet as a 
 left join tb_m_charge_code as b on a.charge_code=b.CHARGE_CODE 
 left join tb_m_activity as c on a.act_code=c.act_code  where periode_date='$data[periode_date]' and employee_id='$data[employee_id]' order by date_ts asc";
               return fetchArray($sql, 'all');
           }
       }
       function generate_new_timesheet($data){
           $this->db->trans_start();    
             $this->db->insert_batch('tb_m_ts',$data);
             $this->db->trans_commit();
             if($this->db->trans_status()==FALSE){
                 return 'gagal';
             }
             else{
                 $sql="select distinct 
DATE_FORMAT(periode_date,'%b %Y ') char_period,
periode_date as date_period 
from tb_m_ts order by periode_date desc";	

		return fetchArray($sql, 'all');
             }
       }
}
?>