<?php 

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : MY_Controller
* Program Name     : Core Controller 
* Description      : Add function for User Authentication Check and add some core function
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			19-10-2014			Winni Oktaviani		add function2 u/ klaim
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


class MY_Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct()
    {
        parent::__construct();
        
        $this->user	= unserialize(base64_decode($this->session->userdata('user')));
        // var_dump($this->user['logged_in']); die();
        if ( ! $this->user['logged_in'])
        { 
            redirect("Login");
        }

        $this->load->model('MY_Model', 'core_model');

        $this->month_list['JAN']['id'] = '1';
        $this->month_list['JAN']['name'] = 'January';

        $this->month_list['FEB']['id'] = '2';
        $this->month_list['FEB']['name'] = 'February';

        $this->month_list['MAR']['id'] = '3';
        $this->month_list['MAR']['name'] = 'March';

        $this->month_list['APR']['id'] = '4';
        $this->month_list['APR']['name'] = 'April';

        $this->month_list['MAY']['id'] = '5';
        $this->month_list['MAY']['name'] = 'May';

        $this->month_list['JUN']['id'] = '6';
        $this->month_list['JUN']['name'] = 'June';

        $this->month_list['JUL']['id'] = '7';
        $this->month_list['JUL']['name'] = 'July';

        $this->month_list['AUG']['id'] = '8';
        $this->month_list['AUG']['name'] = 'August';

        $this->month_list['SEP']['id'] = '9';
        $this->month_list['SEP']['name'] = 'September';

        $this->month_list['OCT']['id'] = '10';
        $this->month_list['OCT']['name'] = 'October';

        $this->month_list['NOV']['id'] = '11';
        $this->month_list['NOV']['name'] = 'November';

        $this->month_list['DEC']['id'] = '12';
        $this->month_list['DEC']['name'] = 'December';
        
    }
	
	function _get_list_employee()
	{
	return $this->core_model->_get_employee_list();
	}
	
	function _get_list_group()
	{
	return $this->core_model->_get_group_list();
	}
	
	function _get_list_catype()
	{
	return $this->core_model->_get_cash_advance_type();
	}
	
	function _get_list_chargecodetype()
	{
	return $this->core_model->_get_chargecodetype_list();
	}

    function _get_employee_rm($employeeID)
    {
    	return $this->core_model->_get_rm($employeeID);
    }
	
	function _get_employee_codediv($groupID)
    {
    	return $this->core_model->_get_codediv($groupID);
    }
	
	function _get_employee_akun($employeeID)
    {
    	return $this->core_model->_get_akun($employeeID);
    }

function _get_employee_akun2($employeeID)
    {
        return $this->core_model->_get_akun2($employeeID);
    }
	
	function _get_employee_ga($employeeID)
    {
    	return $this->core_model->_get_ga($employeeID);
    }
	
	function _get_employee_ga2($employeeID)
    {
    	return $this->core_model->_get_ga2($employeeID);
    }
	
	function _get_employee_dir($employeeID)
    {
    	return $this->core_model->_get_dir($employeeID);
    }
	
	function _get_employee_pur($employeeID)
    {
    	return $this->core_model->_get_pur($employeeID);
    }
	
	function _get_employee_posid($employeeID)
    {
    	return $this->core_model->_get_empl_depth($employeeID);
    }
		
	function _get_employee_approval($groupID)
    {
    	return $this->core_model->_get_empl_approval($groupID);
    }
	
	function _get_employee_admin($employeeID)
    {
    	return $this->core_model->_get_admin($employeeID);
    }
	function _get_employee_superAdmin()
    {
    	return $this->core_model->_get_superAdmin();
    }
	
	// fungsi2 yg ditambahkan pada 15 Des 2014
	//ambil kepala divisi 
	function _get_division_head($divID)
    {
    	return $this->core_model->_get_head_divCsl($divID);
    }
    function _get_employee_group($employeeID)
    {
    	$empl = $this->core_model->_get_empl_depth($employeeID);
    	$pos_depth  = $empl['depth'];
    	$posid = $empl['posid'];

    	//cek pos_depth >= 2
    	// 2 karena group berada pada level 2
    	if(!$pos_depth >= 2)
    	{
    		return '-';
    	}
    	else
    	{
    		$pos = $this->core_model->_get_pos_depth($posid);
    		while($pos['id'] > 2 ){
    			$posid = $pos['manager'];
    			$pos = $this->core_model->_get_pos_depth($posid);
    		}
    		return $posid;
    	}
    }

    function _get_employee_division($employeeID)
    {
    	$empl = $this->core_model->_get_empl_depth($employeeID);
    	$pos_depth  = $empl['depth'];
    	$posid = $empl['posid'];

    	// cek pos_depth >= 3
    	// 3 karena divisi berada pada level 3
    	if(!$pos_depth >= 3)
    	{
    		return '-';
    	}
    	else
    	{
    		$pos = $this->core_model->_get_pos_depth($posid);
    		while($pos['id'] > 3 ){
    			$posid = $pos['manager'];
    			$pos = $this->core_model->_get_pos_depth($posid);
    		}
    		return $posid;
    	}
    }

    function _get_employee_role($employeeID)
    {
    	$pos_level = $this->core_model->_get_empl_role($employeeID);

    	if($pos_level['id'] <= 1 )
    		// if director
    	{
    		return $pos_level['role'];
    	}
    	elseif($pos_level['id'] <= 2 )
    		// if group head
    	{
    		return $pos_level['role'] . " " . $this->_get_employee_group($employeeID);
    	}
    	else
    		// if division
    	{
    		return $pos_level['role'] . " " . $this->_get_employee_division($employeeID);	
    	}
    }

    function _get_employee_level($employeeID)
    {
        $result = $this->core_model->_get_empl_level($employeeID);

        
        return $result;
    }

    function _get_employee_annual_leave_left($employeeID)
    {
        $year = date("Y");
        $response = $this->_recalculate_annual_leave($employeeID);

        $annual_left = $this->core_model->_get_annual_left($employeeID, $year);
        
        return $annual_left;
    }

    function _recalculate_annual_leave($employeeID)
    {
        $year = date("Y");
        $last_year = $year - 1;
        $now_annual = $this->core_model->_get_annual_now($employeeID, $year);
        $joint_total = $this->_get_joint_holiday_total();

        if($now_annual == "0")
        {
            $lastYearLeft = $this->core_model->_get_last_annual($employeeID, $last_year);
            $annuanEntitle = $this->core_model->_get_annual_entitle($employeeID);
            $balanceNow = $annuanEntitle-$joint_total;

            if($lastYearLeft < ($annuanEntitle/2))
            {
                $balanceNow += $lastYearLeft;
            }
            else
            {
                $balanceNow += ($annuanEntitle/2);
            }

            $response = $this->core_model->_set_annual($employeeID, $year, $annuanEntitle, $balanceNow);
        }
    }

    function _get_joint_holiday_total($start_date='')
    {
        $year = date("Y");
        if($start_date == '')
        {
            $start_date = $year."-01-01";
        }
        $response = $this->core_model->_joint_total($start_date);
        return $response;
    }

    function _get_employee_join_date($employeeID)
    {
        $join_dt = $this->core_model->_get_employee_join($employeeID);
        
        return $join_dt;
    }
	
	
	
	function _get_employee_status($employeeID)
    {
    	return $this->core_model->_get_status($employeeID);
    }
	
	function _get_employee_expense_claim_left($employeeID)
	  {
		$month = date("m");
		$year = date("Y");
		$response = $this->_recalculate_expense_claim($employeeID);
     //  $expense_claim_left = $this->core_model->_get_expense_claim_left($employeeID, $year, $month);
      //  return $expense_claim_left;
    }
	
	 function _recalculate_expense_claim($employeeID)
    {
        $year = date("Y");
		$month = date("m");
		$now_expense_claim = $this->core_model->_get_expense_claim_now($employeeID, $year, $month);
		$periodeMedical = $this->core_model->_get_medical_claim_periode($employeeID);
		$medical_left = $this->core_model->_get_medical_claim_left($employeeID, $year, $month);

       if(($now_expense_claim == "0") && ($periodeMedical == '2'))
        {			
			$response = $this->core_model->_set_expense_claim($employeeID,$month, $year, $periodeMedical);
			$response2 = $this->core_model->_set_medical_bulanan($employeeID,$month, $year, $periodeMedical);
        }
		else if(($now_expense_claim == "0") && ($periodeMedical == '1'))
        {
			$response = $this->core_model->_set_expense_claim($employeeID,$month, $year, $periodeMedical);
			$response2 = $this->core_model->_set_medical_tahunan($employeeID,$month, $year, $periodeMedical,$medical_left);
        }
    }
	
	function _get_employee_bantuan_left($employeeID,$level)
	  {
		$month = date("m");
		$year = date("Y");
		$response = $this->_recalculate_bantuan($employeeID,$level);
    }
	function _recalculate_bantuan($employeeID,$level)
    {
        $year = date("Y");
		$now_bantuan= $this->core_model->_get_bantuan_now($employeeID, $year,$level);
		if($now_bantuan == "0")
        {			
			$response = $this->core_model->_set_bantuan($employeeID,$year);
        }
    }
	function _delete_employee_bantuan_left($employeeID)
	{
		$year = date("Y");
		$response = $this->core_model->_delete_bantuan($employeeID,$year);
    }
	function _update_employee_bantuan_left($employeeID)
	{		
		$response = $this->core_model->_update_bantuan($employeeID);
    }
	function _reupdate_bantuan($employeeID)
    {
        $year = date("Y");
		$bantuanNikah= $this->core_model->_count_bntNikah($employeeID, $year);
		$bantuanLahir= $this->core_model->_count_bntLahir($employeeID, $year);
		$bantuanMata= $this->core_model->_count_bntMata($employeeID, $year);
		if($bantuanNikah != "0")
        {			
			$response = $this->core_model->upBntNikah($employeeID,$year);
        }
		if($bantuanLahir != "0")
        {			
			$response = $this->core_model->upBntLahir($employeeID,$year);
        }
		if($bantuanMata != "0")
        {			
			$response = $this->core_model->upBntMata($employeeID,$year);
        }
    }
	
	function _get_employee_pwdstatus($employeeID)
    {
    	return $this->core_model->get_statuspwd($employeeID);
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
