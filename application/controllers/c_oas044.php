<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS044
* Program Name     : Cash Advance List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 12:45:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
 
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS044 extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$index		= $this->config->item('index_page');
		$host		= $this->config->item('base_url');
		$this->url	= empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));	
		$this->load->model('m_oas044', 'list_ca_model');		
	}

	function load_view()
	{
		$employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['month_list']		= $this->month_list;	
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
		$param['detail_akun2'] 		= $this->_get_employee_akun2($employeeID);
		$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);

		$param['list_group']		= $this->list_ca_model->get_group_list();
		$param['list_chargecodetype']		= $this->list_ca_model->get_chargecodetype_list();
		$param['list_cash_advance_type'] 	= $this->list_ca_model->get_cash_advance_type();
		$param['employee_list']		= $this->list_ca_model->get_employee_list();
		$param['submission_list']	= $this->list_ca_model->get_list($param);
		
		$this->load->view('v_oas044', $param);
	}
	
	function _get_post_data() 	
	{ 
		$search['employeeid']		= $this->input->get('employeeid');
		$search['employeeGroup']	= $this->user['group']; 		 	
		$search['employeename']		= $this->input->get('employeename'); 	
		$search['ca_type']			= $this->input->get('ca_type');  	
		$search['group_id']			= $this->input->get('CA_group'); 	
		$search['division_id']		= $this->input->get('CA_division'); 	
		$search['chargecodetype_id']= $this->input->get('CA_cctype'); 	
		$search['chargecode_id']	= $this->input->get('CA_chargecode'); 	
		$search['year']				= $this->input->get('CA_year'); 	
		$search['month']			= $this->input->get('CA_month');	
		$search['open']				= $this->input->get('CA_STAT_OPEN');
		$search['CA_currency']		= $this->input->get('CA_currency');
		
 		return $search; 	
	} 
	
	function search() 
	{
		$search				= $this->_get_post_data(); 
		$employeeID 		= $this->user['id']; 	
		$param['this_id']	= $this->user['id'];  		
		$param['month_list'] 	= $this->month_list;	
 		$param['employee_list'] = $this->list_ca_model->get_employee_list(); 
		$param['submission_list']	= $this->list_ca_model->get_search_list($employeeID, $search); 		
		$param['list_group']	= $this->list_ca_model->get_group_list();  
		$param['detail_admin']	= $this->_get_employee_admin($employeeID);
		$param['detail_akun']	= $this->_get_employee_akun($employeeID);
		$param['detail_akun2']	= $this->_get_employee_akun2($employeeID);
		$param['detail_dir']	= $this->_get_employee_dir($employeeID);
		$param['list_cash_advance_type']	= $this->list_ca_model->get_cash_advance_type();

		if($search['group_id'] != ''){ 	
			$param['list_division'] 	= $this->list_ca_model->get_division_list($search['group_id']); 
		}  		
		$param['list_chargecodetype']	= $this->list_ca_model->get_chargecodetype_list(); 

		if($search['chargecodetype_id'] != ''){ 	
			$param['list_chargecode']	= $this->list_ca_model->get_chargecode_list($search['chargecodetype_id']); 
		} 

		$param['search_param'] 	= $search;
		
		$this->load->view('v_oas044', $param);  	
	} 	
	
	function load_division($group_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($group_id != ''){
			$division_list = $this->list_ca_model->get_division_list($group_id);
			if(isset($division_list)){
				$out[''] = '-- All --';
				foreach ($division_list as $division) {
					$out[$division['id']] = $division['name'];
				}
			}else{
				$out['0'] = '-- Data Not Found --';
			}
		}
		else
		{
			$out[''] = '-- All --';
		}
		echo(json_encode($out));
	}
	
	
	function load_chargecode($chargecodetype_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($chargecodetype_id != ''){
			$chargecode_list = $this->list_ca_model->get_chargecode_list($chargecodetype_id);
			if(isset($chargecode_list)){
				$out[''] = '-- All --';
				foreach ($chargecode_list as $chargecode) {
					$out[$chargecode['id']] = $chargecode['name'];
				}
			}else{
				$out['0'] = '-- Data Not Found --';
			}
		}
		else
		{
			$out[''] = '-- All --';
		}
		echo(json_encode($out));
	}
	
	function download()
	{

		$filename="Cash Advance List";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$submission_list = $this->list_ca_model->get_search_list($employeeID, $search);

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['ref_no'] = $valuerecord['no_ref'];
			$row_array['id'] = $valuerecord['employee_id'];
			$row_array['name'] = $valuerecord['employee_name'];
			$row_array['email'] = $valuerecord['employee_email'];
			$row_array['group'] = $valuerecord['employee_group_name'];
			$row_array['division'] = $valuerecord['employee_division_name'];
			$row_array['ca_type'] = $valuerecord['ca_type'];
			$row_array['categorycc_name'] = $valuerecord['categorycc_name'];
			$row_array['chargecode'] = $valuerecord['chargecode'];
			$row_array['ccdes'] = $valuerecord['ccdes'];
			$row_array['submitted'] = date('d F Y',strtotime($valuerecord['submitted_dt']));
			$row_array['amount'] = number_format($valuerecord['amount'],0,",",".");
			$row_array['currency_name'] = $valuerecord['currency_name'];
			$row_array['pay_method_name'] = $valuerecord['pay_method_name'];
			$row_array['approved_by'] = $valuerecord['approverm_by'];
			$row_array['approved_dt'] = $valuerecord['approverm_dt'];
			$row_array['reviewed_by'] = $valuerecord['approvedir_dy'];
			$row_array['reviewed_dt'] = $valuerecord['approvedir_dt'];
			$row_array['accepted_by'] = $valuerecord['accepted_by'];
			$row_array['accepted_dt'] = $valuerecord['accepted_dt'];
			$row_array['status'] = $valuerecord['status'];
			
			array_push($recordArray,$row_array);

		} 

		// starting the php excel
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getproperties()->settitle("export")->setDescription("none");

		$objPHPExcel->setActiveSheetIndex(0);

			$header= $this->get_report_header();
			// var_dump($header);

			foreach ($header as $key => $value) {
				$objPHPExcel->getActivesheet()->setCellValue($key,$value);
			}
			
			//style alignment
			$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			);
			
			// border
			$borderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			),
			// memberi warna
			'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'E1E0F7')),
			);
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
			$objPHPExcel->getActiveSheet()->getStyle('A5:U5')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A5:U5')->applyFromArray($borderArray );
			$objPHPExcel->getActivesheet()->getStyle('A5:U5')->getFont()->setBold(true);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(50);


		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter= IOFactory::createwriter($objPHPExcel,'Excel5');

		
		
		// sending headers to force the user for download file
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
	}	

	private function get_report_header()
	{
		$employeeName =$this->user['name'];
		$header = array();
		$header['A1'] = "CYBERTREND OFFICE AUTOMATION SYSTEM";
		$header['A2'] = "Tittle File :";
		$header['B2'] = "Cash Advance Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeName.')';
			$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";
			$header['E5'] = "Group";
			$header['F5'] = "Division";
			$header['G5'] = "Cash Advance Type";
			$header['H5'] = "Charge Code Type";
			$header['I5'] = "Charge Code";
			$header['J5'] = "Project Description";
			$header['K5'] = "Submitted Date";
			$header['L5'] = "Amount";
			$header['M5'] = "Currency";
			$header['N5'] = "Payment Method";
			$header['O5'] = "Approved By";
			$header['P5'] = "Approved Date";
			$header['Q5'] = "Reviewed By";
			$header['R5'] = "Reviewed Date";
			$header['S5'] = "Received By";
			$header['T5'] = "Received Date";
			$header['U5'] = "Settlement Status";

		return $header;
	}	


}