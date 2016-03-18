<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS045
* Program Name     : List Business Travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

 
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS045 extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		$index		= $this->config->item('index_page');
		$host		= $this->config->item('base_url');
		$this->url	= empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));	
		$this->load->model('m_oas045', 'list_reportbt_model');		
	}
	function load_view()
	{
		$employeeID					= $this->user['id'];
		$param['employeeGroup']		= $this->user['group'];
		$param['this_id']			= $this->user['id'];
		$param['submission_list']	= $this->list_reportbt_model->get_list($param);
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_superadmin']		= $this->_get_employee_superadmin($employeeID);
		$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
		$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
		$param['list_group']		= $this->list_reportbt_model->get_group_list();
		$param['list_chargecodetype']		= $this->list_reportbt_model->get_chargecodetype_list();
		$param['month_list']		= $this->month_list;	
		$param['detail_ga'] 		= $this->_get_employee_ga($employeeID);
		$param['detail_ga2'] = $this->_get_employee_ga2($employeeID);
		$param['employee_list']		= $this->list_reportbt_model->get_employee_list();
		
		$param['destination']		= $this->list_reportbt_model->get_bt_destination_list();
		$param['transportation']		= $this->list_reportbt_model->get_bt_transportation_list();		
		
		
		$this->load->view('v_oas045', $param);
	}
	
	public function paid_selected(){

		$update = $this->list_reportbt_model->paid_selected();
  if($update){
			header('location:'.base_url().'#');
		}
	}
	function _get_post_data() 	
	{ 
		$search['employeeid']		= $this->input->get('employeeid');
		$search['employeeGroup']	= $this->user['group']; 		 	
		$search['employeename']		= $this->input->get('employeename'); 	
		$search['destination']			= $this->input->get('BT_destination');  	
		$search['group_id']			= $this->input->get('BT_group'); 	
		$search['division_id']		= $this->input->get('BT_division'); 	
		$search['chargecodetype_id']	= $this->input->get('RBT_cctype'); 	
		$search['chargecode_id']		= $this->input->get('BT_chargecode'); 	
		$search['year']					= $this->input->get('RBT_year'); 	
		$search['month']				= $this->input->get('BT_month');	
		$search['bt_status']					= $this->input->get('RBT_STAT_BT');
		$search['transport_id']			= $this->input->get('BT_transportationby');
		
		
 		return $search; 	
	} 
	
	function search() 
	{
		$search				= $this->_get_post_data(); 
		$employeeID 		= $this->user['id']; 	
		$param['this_id']	= $this->user['id']; 
		$param['submission_list']	= $this->list_reportbt_model->get_search_list($employeeID, $search); 		
		$param['list_group']		= $this->list_reportbt_model->get_group_list();  
		$param['detail_admin']		= $this->_get_employee_admin($employeeID);
		$param['detail_superadmin']		= $this->_get_employee_superadmin($employeeID);
		$param['detail_akun']		= $this->_get_employee_akun($employeeID);
		$param['detail_dir']		= $this->_get_employee_dir($employeeID);
		
		if($search['group_id'] != ''){ 	
			$param['list_division'] 	= $this->list_reportbt_model->get_division_list($search['group_id']); 
		}  		
		$param['list_chargecodetype']	= $this->list_reportbt_model->get_chargecodetype_list(); 
		if($search['chargecodetype_id'] != ''){ 	
			$param['list_chargecode']	= $this->list_reportbt_model->get_chargecode_list($search['chargecodetype_id']); 
		} 		 		
		$param['search_param'] = $search; 		
		$param['month_list'] = $this->month_list;	
 		$param['employee_list'] = $this->list_reportbt_model->get_employee_list();
$param['detail_ga'] 		= $this->_get_employee_ga($employeeID);		
$param['detail_ga2'] = $this->_get_employee_ga2($employeeID);
$param['destination']		= $this->list_reportbt_model->get_bt_destination_list();
		$param['transportation']		= $this->list_reportbt_model->get_bt_transportation_list();	
		$this->load->view('v_oas045', $param);  	
	} 	
	
	function load_division($group_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($group_id != ''){
			$division_list = $this->list_reportbt_model->get_division_list($group_id);
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
			$chargecode_list = $this->list_reportbt_model->get_chargecode_list($chargecodetype_id);
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

		$filename="Business Travel List";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$submission_list = $this->list_reportbt_model->get_search_list($employeeID, $search);

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['ref_no'] = $valuerecord['no_ref'];
			$row_array['id'] = $valuerecord['employee_id1'];
			$row_array['name'] = $valuerecord['employee_name'];
			$row_array['email'] = $valuerecord['employee_email'];
			$row_array['group'] = $valuerecord['employee_group_name'];
			$row_array['division'] = $valuerecord['employee_division_name'];
			$row_array['client_name'] = $valuerecord['client_name'];
			$row_array['bt_purpose'] = $valuerecord['bt_purpose'];
			$row_array['location'] = $valuerecord['location'];
			$row_array['chargecode'] = $valuerecord['chargecode'];
			$row_array['ccdes'] = $valuerecord['ccdes'];
			$row_array['departure'] = date('d F Y',strtotime($valuerecord['departure']));
			$row_array['return_dt'] = date('d F Y',strtotime($valuerecord['return_dt']));
			$row_array['duration'] = $valuerecord['duration'];
			$row_array['approverm_by'] = $valuerecord['approverm_by'];
			$row_array['approverm_dt'] = $valuerecord['approverm_dt'];
			$row_array['approvedir_dy'] = $valuerecord['approvedir_dy'];
			$row_array['approvedir_dt'] = $valuerecord['approvedir_dt'];
			$row_array['accepted_by'] = $valuerecord['accepted_by'];
			$row_array['accepted_dt'] = $valuerecord['accepted_dt'];
			$row_array['amount_dim'] = $valuerecord['amount_dim'];
			$row_array['amount_ca'] = $valuerecord['amount_ca'];
			$row_array['amount_transport'] = $valuerecord['amount_transport'];
			$row_array['amount_hotel'] = $valuerecord['amount_hotel'];
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
			$objPHPExcel->getActiveSheet()->getStyle('A5:Z5')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A5:Z5')->applyFromArray($borderArray );
			$objPHPExcel->getActivesheet()->getStyle('A5:Z5')->getFont()->setBold(true);
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
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(50);
			


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
		$header['B2'] = "Business Travel List";
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
			$header['G5'] = "Client Name";
			$header['H5'] = "Business Purpose";
			$header['I5'] = "Customers Location";
			$header['J5'] = "Charge Code";
			$header['K5'] = "Project Description";
			$header['L5'] = "Date of departure";
			$header['M5'] = "Date of return";
			$header['N5'] = "Duration";
			$header['O5'] = "Approved By";
			$header['P5'] = "Approved Date";
			$header['Q5'] = "Reviewed By";
			$header['R5'] = "Reviewed Date";
			$header['S5'] = "Received By";
			$header['T5'] = "Received Date";
			$header['U5'] = "Amount Dim";
			$header['V5'] = "Amount CA";
			$header['W5'] = "Amount Transport";
			$header['X5'] = "Amount Hotel";
			$header['Y5'] = "Remarks";
			$header['Z5'] = "End Status";
			

		return $header;
	}	

}