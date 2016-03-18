<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : MY_Model
* Program Name     : Core Model
* Description      : Add function for User Authentication Check and add some core function
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 		1.0			19-10-2014			Winni Oktaviani		add function2 u/ klaim
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class MY_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	// Ambil Kode Divisi sbg kode referensi number
	function _get_codediv($groupID)
	{
		$sql = "SELECT 
						pos.KODE
				FROM 
						tb_m_employee emp,
            			tb_m_position pos

				WHERE
						pos.POSITION_ID = emp.DIVISION_ID AND
            			emp.DIVISION_ID = '$groupID' 
						group by pos.KODE ";
		return fetchArray($sql, 'one');
	}
	
	//mendapatkan list group
	function _get_group_list()
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

	

	//ambil daftar tipe CA
	function _get_cash_advance_type()
	{
		$sql = " SELECT
					CA_TYPE_ID id,
					CA_TYPE type
				FROM
					tb_m_ca_type";
		return fetchArray($sql, 'all');
	}
	
		//mendapatkan list chargecodetype
	function _get_chargecodetype_list()
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
	
		
	function _get_employee_list()
	{
		$sql = "SELECT
							empl.EMPLOYEE_ID,
							empl.EMPLOYEE_NAME
							
				FROM
							tb_m_employee empl,
                            tb_m_user us
                WHERE       
                            us.EMPLOYEE_ID = empl.EMPLOYEE_ID
				ORDER BY empl.EMPLOYEE_NAME ASC";
		return fetchArray($sql, 'one');
	}
	
	function _get_rm($employeeID)
	{
		$sql = "SELECT 
						rm.REPORTING_MANAGER_ID id,
			            em.EMPLOYEE_NAME name,
						usr.USER_EMAIL email
				FROM 
						tb_m_employee_reporting_manager rm,
            			tb_m_employee em,
						tb_m_user usr

				WHERE
						usr.EMPLOYEE_ID = em.EMPLOYEE_ID AND
						rm.REPORTING_MANAGER_ID = em.EMPLOYEE_ID AND
            			rm.EMPLOYEE_ID = '$employeeID' ";
		return fetchArray($sql, 'row');
	}
	
	function _get_dir()
	{
		$sql = "SELECT 
						em.EMPLOYEE_ID  id,
			            em.EMPLOYEE_NAME name,
                        us.USER_EMAIL email
				FROM 
						tb_m_employee em,
                     tb_m_user us
                     
                    
				WHERE
						us.EMPLOYEE_ID = em.EMPLOYEE_ID AND
                        POSITION_ID = 'DIR' AND
                        POSITION_DEPTH_ID = '1'";
		return fetchArray($sql, 'row');
	}
	
	function _get_pur()
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
						mp.APPROVAL_FOR = '4'";
		return fetchArray($sql, 'row');
	}
	
	function _get_ga()
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
						mp.APPROVAL_FOR = '3'";
		return fetchArray($sql, 'row');
	}
	
	function _get_ga2()
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
						mp.APPROVAL_FOR = '5'";
		return fetchArray($sql, 'row');
	}
	
	
	
	function _get_akun()
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
						mp.APPROVAL_FOR = '2'";
		return fetchArray($sql, 'row');
	}
function _get_akun2()
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
						mp.APPROVAL_FOR = '4'";
		return fetchArray($sql, 'row');
	}


	function _get_superAdmin()
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
						mp.APPROVAL_FOR = '0'";
		return fetchArray($sql, 'row');
	}
	
	function _get_admin($employeeID)
	{
		$sql = "SELECT 
						rm.EMPLOYEE_ID  id,
			            em.EMPLOYEE_NAME name
				FROM 
						tb_m_user rm,
            			tb_m_employee em,
                        tb_m_user_group ug
				WHERE
						rm.USER_GROUP_ID = ug.USER_GROUP_ID AND
                        rm.EMPLOYEE_ID = em.EMPLOYEE_ID AND
                        rm.USER_GROUP_ID = '1' AND 
						em.EMPLOYEE_ID = '$employeeID'";
		return fetchArray($sql, 'row');
	}

	function _get_empl_depth($employeeID)
	{
		$sql = "SELECT 
						pd.POSITION_DEPTH_ID depth,
						em.POSITION_ID posid
				FROM 
						tb_m_employee em,
            			tb_m_position_depth pd

				WHERE
						em.POSITION_DEPTH_ID = pd.POSITION_DEPTH_ID AND
            			em.EMPLOYEE_ID = '$employeeID'";
		return fetchArray($sql, 'row');
	}
			
	function _get_empl_approval($groupID)
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
						empl.GROUP_ID = '$groupID'";
		return fetchArray($sql, 'row');
	}

	function _get_pos_depth($posID)
	{
		$sql = "SELECT 
						pos.POSITION_DEPTH_ID id,
						pos.MANAGER_ID manager
				FROM 
			            tb_m_position pos

				WHERE
			            pos.POSITION_ID = '$posID' ";
        return fetchArray($sql, 'row');
    }

    function _get_empl_role($emplID)
	{
		$sql = "SELECT 
						empl.POSITION_DEPTH_ID id,
						pd.POSITION_DEPTH_TITLE role
				FROM 
			            tb_m_employee empl,
			            tb_m_position_depth pd

				WHERE
			            empl.EMPLOYEE_ID = '$emplID' AND
			            empl.POSITION_DEPTH_ID = pd.POSITION_DEPTH_ID";
        return fetchArray($sql, 'row');
    }

    function _get_empl_level($emplID)
	{
		$sql = "SELECT 
						pl.LEVEL_ID id,
						pl.LEVEL_NAME name
				FROM 
			            tb_m_employee empl,
			            tb_m_position_level pl

				WHERE
			            empl.EMPLOYEE_ID = '$emplID' AND
			            empl.LEVEL_ID = pl.LEVEL_ID";
        return fetchArray($sql, 'row');
    }

    function _get_annual_leave_max()
	{
		$sql = "SELECT 
						lt.LEAVE_LENGTH_MAX
				FROM 
			            tb_m_leave_type lt

				WHERE
			            lt.LEAVE_TYPE_ID = '1' ";
        return fetchArray($sql, 'one');
    }

    

    function _get_annual_left($employeeID, $year)
    {
    	$sql = "SELECT 
						trx.BALANCE
				FROM 
			            tb_r_annual_leave_trx trx

				WHERE
			            trx.EMPLOYEE_ID = '$employeeID' AND
			            trx.YEAR = '$year' ";
        return fetchArray($sql, 'one');
    }

    function _get_annual_now($employeeID, $year)
    {
    	$sql = "SELECT 
						COUNT(*)
				FROM 
			            tb_r_annual_leave al

				WHERE
			            al.EMPLOYEE_ID = '$employeeID' AND
			            al.YEAR = '$year' ";
        return fetchArray($sql, 'one');
    }

    function _get_last_annual($employeeID, $year)
    {
    	$sql = "SELECT 
						trx.BALANCE
				FROM 
			            tb_r_annual_leave_trx trx

				WHERE
			            trx.EMPLOYEE_ID = '$employeeID' AND
			            trx.YEAR = '$year' ";
        return fetchArray($sql, 'one');
    }

    function _get_annual_entitle($employeeID)
    {
    	$sql = "SELECT 
						empl.ANNUAL_LEAVE_ENTITLEMENT
				FROM 
			            tb_m_employee empl

				WHERE
			            empl.EMPLOYEE_ID = '$employeeID' ";
        return fetchArray($sql, 'one');
    }

    function _set_annual($employeeID, $year, $annuanEntitle, $balanceNow)
    {
    	$ack = 0;
    	$this_email = $this->user['email'];
		$sql = "INSERT INTO
						tb_r_annual_leave (	EMPLOYEE_ID,
											YEAR,
											ANNUAL_BALANCE,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID',
						'$year',
						'$annuanEntitle',
				        'user: $this_email',
				        '".date("Y-m-d H:i:s")."')";
				
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}

		if($ack == 1)
		{
			$sql = "INSERT INTO
							tb_r_annual_leave_trx (	EMPLOYEE_ID,
												YEAR,
												BALANCE,
												CREATED_BY,
												CREATED_DT)
					VALUES
							('$employeeID',
							'$year',
							'$balanceNow',
					        'user: $this_email',
					        '".date("Y-m-d H:i:s")."')";
					
		
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		return $ack;
    }

    function _joint_total($start_date)
    {
    	$year = date("Y");
    	$sql = "SELECT 
						COUNT(*)
				FROM 
			            tb_m_tanggal_libur tl

				WHERE
			            tl.TIPE_TANGGAL_LIBUR = '1' AND 
			    		tl.TANGGAL between '$start_date' and '".$year."-12-31'";
        return fetchArray($sql, 'one');
    }

    function _get_employee_join($employeeID)
    {
    	$sql = "SELECT 
						empl.JOIN_DATE
				FROM 
			            tb_m_employee empl

				WHERE
			            empl.EMPLOYEE_ID = '$employeeID' ";
        return fetchArray($sql, 'one');
	}
		
	// ditambahkan pada 14 Desember 2014
	function _get_head_divCsl($divID)
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
						(empl.POSITION_DEPTH_ID = '3' OR empl.POSITION_DEPTH_ID = '4' )AND
						empl.DIVISION_ID = '$divID'";
		return fetchArray($sql, 'row');
	}
	

	function _get_status($employeeID)
	{
		$sql = "SELECT 
						em.EMPLOYEE_ID id,
			            em.EMPLOYEE_NAME name,
						em.STATUS_ID status
				FROM 						
            			tb_m_employee em
				WHERE
						em.EMPLOYEE_ID = '$employeeID' ";
		return fetchArray($sql, 'row');
	}
	
	// function-function for expense claim
	//1. untuk mengambil sisa tunjangan&bantuan yg dimiliki 
	function _get_expense_claim_left($employeeID, $year, $month)
    {
    	$sql = " SELECT IFNULL ((SELECT `REMAIN_AMOUNT` 
				FROM 
			            tb_r_tunjangan tnj 
				WHERE
			            tnj.EMPLOYEE_ID = '$employeeID' AND
						tnj.AVAILABLE != 0 AND 
						tnj.YEAR = '$year' AND
						tnj.MONTH ='$month'),0) as 'expense claim'";
        return fetchArray($sql, 'one');
    }
	function _get_medical_claim_left($employeeID,$year,$month)
    {
    	$sql = "SELECT 
					REMAIN_AMOUNT
				FROM 
			            tb_r_tunjangan
				WHERE
			            EMPLOYEE_ID = '$employeeID' AND 
						YEAR = '$year' AND 
						MONTH =('$month' - 1)";
        return fetchArray($sql, 'one');
    }

	
	function _get_medical_claim_periode($employeeID)
    {
    	$sql = "SELECT 
					empl.PERIODE_MEDICAL_CLAIM period
				FROM 
			            tb_m_employee empl
				WHERE
			            empl.EMPLOYEE_ID = '$employeeID' ";
        return fetchArray($sql, 'one');
    }
	
	function _get_expense_claim_now($employeeID, $year, $month)
    {
    	$sql = "SELECT 
						COUNT(*) REMAIN_AMOUNT 
				FROM 
			           tb_r_tunjangan tnj

				WHERE
			            tnj.EMPLOYEE_ID = '$employeeID' AND
						tnj.YEAR = '$year' AND
						tnj.MONTH = '$month'";
        return fetchArray($sql, 'one');
    }
	
	 function _set_expense_claim($employeeID,$month,$year)
    {
    	$ack = 0;		
    	$this_email = $this->user['email'];						
		$sql_komunikasi = "INSERT INTO
						tb_r_tunjangan(	EMPLOYEE_ID,
											YEAR,
											MONTH,
											EXPENSE_TYPE_ID,
											AMOUNT,
											REMAIN_AMOUNT,
											AVAILABLE,
											PERIODE,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID',
						'$year',
						'$month',
						'2',
						(Select EXPENSE_CLAIM_TELECOMMUNICATION_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
						(Select EXPENSE_CLAIM_TELECOMMUNICATION_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
				        '1',
						'2',
						'user: $this_email',
						'".date("Y-m-d H:i:s")."')";
						
		$sql_transport = "INSERT INTO
						tb_r_tunjangan(	EMPLOYEE_ID,
											YEAR,
											MONTH,
											EXPENSE_TYPE_ID,
											AMOUNT,
											REMAIN_AMOUNT,
											AVAILABLE,
											PERIODE,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID',
						'$year',
						'$month',
						'3',
						(Select EXPENSE_CLAIM_TRANSPORTATION_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
						(Select EXPENSE_CLAIM_TRANSPORTATION_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
				        '1',
						'2',
						'user: $this_email',
						'".date("Y-m-d H:i:s")."')";
	
		$this->db->trans_start();
		$this->db->query($sql_komunikasi);
		$this->db->query($sql_transport);		
		if($this->db->trans_complete()){
			$ack = 1;
		}		
		
		return $ack;
    }
	
	 function _set_medical_bulanan($employeeID,$month,$year, $periodeMedical)
    {
    	$ack = 0;		
    	$this_email = $this->user['email'];
		$sql_medis = "INSERT INTO
						tb_r_tunjangan(	EMPLOYEE_ID,
											YEAR,
											MONTH,
											EXPENSE_TYPE_ID,
											AMOUNT,
											REMAIN_AMOUNT,
											AVAILABLE,
											PERIODE,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID',
						'$year',
						'$month',
						'1',
						(Select EXPENSE_CLAIM_MEDICAL_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
						(Select EXPENSE_CLAIM_MEDICAL_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
				        '1',
						'$periodeMedical',
						'user: $this_email',
						'".date("Y-m-d H:i:s")."')";
	
		$this->db->trans_start();
		$this->db->query($sql_medis);		
		if($this->db->trans_complete()){
			$ack = 1;
		}		
		
		return $ack;
    }
	
	function _set_medical_tahunan($employeeID,$month,$year, $periodeMedical,$medical_left)
    {
    	$ack = 0;		
    	$this_email = $this->user['email'];
		$sql_medis = "INSERT INTO
						tb_r_tunjangan(	EMPLOYEE_ID,
											YEAR,
											MONTH,
											EXPENSE_TYPE_ID,
											AMOUNT,
											REMAIN_AMOUNT,
											AVAILABLE,
											PERIODE,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID',
						'$year',
						'$month',
						'1',
						(Select EXPENSE_CLAIM_MEDICAL_ENTITLEMENT FROM tb_m_employee
						WHERE EMPLOYEE_ID = '$employeeID'),
						'$medical_left',
				        '1',
						'$periodeMedical',
						'user: $this_email',
						'".date("Y-m-d H:i:s")."')";
	
		$this->db->trans_start();
		$this->db->query($sql_medis);		
		if($this->db->trans_complete()){
			$ack = 1;
		}		
		
		return $ack;
    }
	
	function _get_bantuan_now($employeeID, $year,$level)
    {
    	$sql = "SELECT 
						COUNT(*) 
				FROM 
			           tb_r_bantuan bnt

				WHERE
			            bnt.EMPLOYEE_ID = '$employeeID' AND
						bnt.YEAR = '$year' AND 
						REMAIN = '1'";
        return fetchArray($sql, 'one');
    }
	function _set_bantuan($employeeID,$year)
    {
    	$ack = 0;		
    	$this_email = $this->user['email'];
		$sql1 = " DELETE FROM tb_r_bantuan 
				WHERE EMPLOYEE_ID = '$employeeID'";
		$sql = "INSERT INTO
						tb_r_bantuan(	EMPLOYEE_ID,
											YEAR,
											EXPENSE_TYPE_ID,
											AMOUNT,
											REMAIN,
											CREATED_BY,
											CREATED_DT)
				VALUES
						('$employeeID' ,
						'$year', '8',
						( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
						where emp.LEVEL_ID =bnt.LEVEL_ID AND 
						emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '8'),			        
				         (SELECT IFNULL ((SELECT REMAIN FROM tb_r_bantuan bnt where 
						bnt.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '8'),1) as 'REMAIN'),
						'$this_email',
						'".date("Y-m-d H:i:s")."'),
                        ('$employeeID' ,
						'$year', '9001',
						( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
						where emp.LEVEL_ID =bnt.LEVEL_ID AND 
						emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9001'),			        
				         (SELECT IFNULL ((SELECT REMAIN FROM tb_r_bantuan bnt where 
						bnt.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9001'),1) as 'REMAIN'),
						'$this_email',
						'".date("Y-m-d H:i:s")."'),
						('$employeeID' ,
						'$year', '9002',
						( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
						where emp.LEVEL_ID =bnt.LEVEL_ID AND 
						emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9002'),			        
				         (SELECT IFNULL ((SELECT REMAIN FROM tb_r_bantuan bnt where 
						bnt.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9002'),1) as 'REMAIN'),
						'$this_email',
						'".date("Y-m-d H:i:s")."'),
						('$employeeID' ,
						'$year', '9003',
						( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
						where emp.LEVEL_ID =bnt.LEVEL_ID AND 
						emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9003'),
				        (SELECT IFNULL ((SELECT REMAIN FROM tb_r_bantuan bnt where 
						bnt.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9003'),1) as 'REMAIN'),
						'$this_email',
						'".date("Y-m-d H:i:s")."'),
						('$employeeID' ,
						'$year', '10',
						( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
						where emp.LEVEL_ID =bnt.LEVEL_ID AND 
						emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '10'),
				        ( SELECT IFNULL ((SELECT REMAIN FROM tb_r_bantuan bnt where 
						bnt.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '10'),1) as 'REMAIN'),
						'$this_email',
						'".date("Y-m-d H:i:s")."')";
	
		$this->db->trans_start();
		$this->db->query($sql1);
		$this->db->query($sql);		
		if($this->db->trans_complete()){
			$ack = 1;
		}		
		
		return $ack;
    }
	function _delete_bantuan($employeeID,$year)
    {
    	$ack = 0;
		$sql = " DELETE FROM tb_r_bantuan 
				WHERE EMPLOYEE_ID = '$employeeID' AND
				YEAR = '$year'";
	
		$this->db->trans_start();
		$this->db->query($sql);		
		if($this->db->trans_complete()){
			$ack = 1;
		}		
		
		return $ack;
    }
	
	function _update_bantuan($employeeID)
	{
		$ack = 0;
		$sql8 = " UPDATE tb_r_bantuan SET
					AMOUNT = ( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
					WHERE emp.LEVEL_ID =bnt.LEVEL_ID AND 
					emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '8')
					WHERE EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '8'";
		$sql9001 = "UPDATE tb_r_bantuan SET
					AMOUNT = ( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
					WHERE emp.LEVEL_ID =bnt.LEVEL_ID AND 
					emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9001')
					WHERE EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '9001'";
		$sql9002 = "UPDATE tb_r_bantuan SET
					AMOUNT = ( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
					WHERE emp.LEVEL_ID =bnt.LEVEL_ID AND 
					emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9002')
					WHERE EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '9002'";
		$sql9003 = "UPDATE tb_r_bantuan SET
					AMOUNT = ( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
					WHERE emp.LEVEL_ID =bnt.LEVEL_ID AND 
					emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '9003')
					WHERE EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '9003'";
		$sql10 = "UPDATE tb_r_bantuan SET
					AMOUNT = ( SELECT bnt.AMOUNT FROM tb_m_bantuan bnt, tb_m_employee emp
					WHERE emp.LEVEL_ID =bnt.LEVEL_ID AND 
					emp.EMPLOYEE_ID ='$employeeID' AND bnt.EXPENSE_TYPE_ID = '10')
					WHERE EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '10'";
		$this->db->trans_start();
			$this->db->query($sql8);
			$this->db->query($sql9001);
			$this->db->query($sql9002);
			$this->db->query($sql9003);
			$this->db->query($sql10);
		if ($this->db->trans_complete()){
			$ack = 1;
		}
		return $ack;
	}
	
	
	// Fungsi2 dibawah ini untuk insert data bantuan otomatis di tahun berikutnya 
	function _count_bntLahir($employeeID, $year)
    {
    	$sql = "SELECT 
						COUNT(*)  as kelahiran
				FROM 
			           tb_r_bantuan bnt
				WHERE
					bnt.EMPLOYEE_ID = '$employeeID' AND
					(bnt.YEAR = ('$year'-1)) AND
					(EXPENSE_TYPE_ID = '9003' OR EXPENSE_TYPE_ID = '9002' OR
					EXPENSE_TYPE_ID = '9001')
                    AND  REMAIN != '0'";
        return fetchArray($sql, 'one');
    }
	
	
    function upBntLahir($employeeID,$year)
    {
    	$ack = 0;
    	$this_email = $this->user['email'];
		$sql = "UPDATE
					tb_r_bantuan
				SET YEAR = '$year',
					UPDATED_BY = 'user : $this_email',
					UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE 
					EMPLOYEE_ID = '$employeeID' AND
					(EXPENSE_TYPE_ID = '9001' OR 
					EXPENSE_TYPE_ID = '9002' OR
					EXPENSE_TYPE_ID = '9003') AND 
					REMAIN != '0'";			
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
    }
	function _count_bntNikah($employeeID, $year)
    {
    	$sql = "SELECT 
						COUNT(*)  AS pernikahan
				FROM 
			           tb_r_bantuan bnt
				WHERE
					bnt.EMPLOYEE_ID = '$employeeID' AND
					bnt.YEAR = ('$year'-1) AND
					EXPENSE_TYPE_ID = '8' 
					AND REMAIN != '0'";
        return fetchArray($sql, 'one');
    }
	function upBntNikah($employeeID,$year)
    {
    	$ack = 0;
    	$this_email = $this->user['email'];
		$sql = "UPDATE
					tb_r_bantuan
				SET YEAR = '$year',
					UPDATED_BY = 'user : $this_email',
					UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE 
					EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '8' AND 
					REMAIN != '0'";			
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
    }
	function _count_bntMata($employeeID, $year)
    {
    	$sql = "SELECT 
						COUNT(*)  as kacamata
				FROM 
			           tb_r_bantuan bnt
				WHERE
					bnt.EMPLOYEE_ID = '$employeeID' AND
					bnt.YEAR = ('$year'-1) AND
                     EXPENSE_TYPE_ID = '10' 
                     AND  REMAIN != '0'";
        return fetchArray($sql, 'one');
    }
	function upBntMata($employeeID,$year)
    {
    	$ack = 0;
    	$this_email = $this->user['email'];
		$sql = "UPDATE
					tb_r_bantuan
				SET YEAR = '$year',
					UPDATED_BY = 'user : $this_email',
					UPDATED_DT = '".date("Y-m-d H:i:s")."'
				WHERE 
					EMPLOYEE_ID = '$employeeID' AND
					EXPENSE_TYPE_ID = '10' AND 
					REMAIN != '0'";			
	
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		return $ack;
    }
	function get_statuspwd($employee){
		$sql = "SELECT 
						STATUS_PASSWORD
				FROM
						tb_m_user usr
				WHERE
						usr.EMPLOYEE_ID = '$employee'
						";
		return fetchArray($sql, 'row');
	}
	
}