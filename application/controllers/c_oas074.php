<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS074
* Program Name     : Purchase Request Report
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 16-02-2015 16:01:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 12-03-2015			Metta Kharisma		 +function Download
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

 
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS074 extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$index		= $this->config->item('index_page');
		$host		= $this->config->item('base_url');
		$this->url	= empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));	
		$this->load->model('m_oas074', 'list_pr_model');		
	}
	function load_view()
	{
		$employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['submission_list']	= $this->list_pr_model->get_list($param);
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
		$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
		$param['detail_pur'] 		= $this->_get_employee_pur($employeeID);
		$param['list_group']		= $this->list_pr_model->get_group_list();
		$param['list_chargecodetype']		= $this->list_pr_model->get_chargecodetype_list();
		$param['month_list']		= $this->month_list;	
		$param['employee_list']		= $this->list_pr_model->get_employee_list();
		$this->load->view('v_oas074', $param);
		
	}
	
	function _get_post_data() 	
	{ 
		$search['employeeid']		= $this->input->get('employeeid');	 	
		$search['employeename']		= $this->input->get('employeename'); 
		$search['employeeGroup']	= $this->user['group']; 
		$search['group_id']			= $this->input->get('PR_group'); 		
		$search['division_id']		= $this->input->get('PR_division'); 	
		$search['chargecodetype_id']	= $this->input->get('PR_cctype'); 	
		$search['chargecode_id']		= $this->input->get('PR_chargecode'); 	
		$search['year']					= $this->input->get('PR_year'); 	
		$search['month']				= $this->input->get('PR_month');	
		$search['PR_currency']			= $this->input->get('PR_currency');		
		
		
 		return $search; 	
	} 
	
	function search() 
	{
		$search				= $this->_get_post_data(); 
		$employeeID 		= $this->user['id']; 	
		$param['this_id']	= $this->user['id']; 
		$param['submission_list']	= $this->list_pr_model->get_search_list($employeeID, $search); 		
		$param['list_group']		= $this->list_pr_model->get_group_list();  
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_akun']		= $this->_get_employee_akun($employeeID);
		$param['detail_dir']		= $this->_get_employee_dir($employeeID);
		$param['detail_pur']		= $this->_get_employee_pur($employeeID);
		if($search['group_id'] != ''){ 	
			$param['list_division'] 	= $this->list_pr_model->get_division_list($search['group_id']); 
		}  		
		$param['list_chargecodetype']	= $this->list_pr_model->get_chargecodetype_list(); 
		if($search['chargecodetype_id'] != ''){ 	
			$param['list_chargecode']	= $this->list_pr_model->get_chargecode_list($search['chargecodetype_id']); 
		} 		 		
		$param['search_param'] = $search; 		
		$param['month_list'] = $this->month_list;	
 		$param['employee_list'] = $this->list_pr_model->get_employee_list(); 
		$this->load->view('v_oas074', $param);  	
	} 	
	
	function load_division($group_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($group_id != ''){
			$division_list = $this->list_pr_model->get_division_list($group_id);
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
			$chargecode_list = $this->list_pr_model->get_chargecode_list($chargecodetype_id);
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

		$filename="Purchase Request Report";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$submission_list = $this->list_pr_model->get_search_list($employeeID, $search);

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['ref_no'] = $valuerecord['no_ref'];
			$row_array['id'] = $valuerecord['employee_id'];
			$row_array['name'] = $valuerecord['employee_name'];
			$row_array['email'] = $valuerecord['employee_email'];
			$row_array['group'] = $valuerecord['employee_group_name'];
			$row_array['division'] = $valuerecord['employee_division_name'];
			$row_array['chargecode'] = $valuerecord['chargecode'];
			$row_array['ccdes'] = $valuerecord['ccdes'];
			$row_array['approverm_by'] = $valuerecord['approverm_by'];
			$row_array['approverm_dt'] = $valuerecord['approverm_dt'];
			$row_array['approvedir_dy'] = $valuerecord['approvedir_dy'];
			$row_array['approvedir_dt'] = $valuerecord['approvedir_dt'];
			$row_array['accepted_by'] = $valuerecord['accepted_by'];
			$row_array['accepted_dt'] = $valuerecord['accepted_dt'];
			$row_array['remarks'] = $valuerecord['remarks'];
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
			$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A5:P5')->applyFromArray($borderArray );
			$objPHPExcel->getActivesheet()->getStyle('A5:P5')->getFont()->setBold(true);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			


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
		$header['B2'] = "Purchase Request Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeName.')';
			$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";
			$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";
			$header['E5'] = "Group";
			$header['F5'] = "Division";
			$header['G5'] = "Charge Code";
			$header['H5'] = "Project Description";
			$header['I5'] = "Approved By";
			$header['J5'] = "Approved Date";
			$header['K5'] = "Reviewed By";
			$header['L5'] = "Reviewed Date";
			$header['M5'] = "Received By";
			$header['N5'] = "Received Date";
			$header['O5'] = "Remarks";
			$header['P5'] = "End Status";
			

		return $header;
	}	

}