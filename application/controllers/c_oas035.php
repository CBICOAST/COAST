<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS035
* Program Name     : List Expense Claim Allowance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS035 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas035', 'list_model');
		
	}

	function index()
	{
		
	}

	function _get_post_data()
	{
		$search['employeeGroup'] = $this->user['group'];

		$search['employeeid'] = $this->input->get('employeeid');
		$search['employeename'] = $this->input->get('employeename');
		$search['claimtype'] = $this->input->get('claimtype');
		$search['claimstatus'] = $this->input->get('claimstatus');
		
		$search['group_id'] = $this->input->get('group');
		$search['division_id'] = $this->input->get('division');
		
		$search['year'] = $this->input->get('year');
		$search['month'] = $this->input->get('month');

		return $search;
	}

	function search()
	{
		$search = $this->_get_post_data();

		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_search_list($employeeID, $search);
		$param['list_group'] = $this->list_model->get_group_list();

		if($search['group_id'] != ''){
			$param['list_division'] = $this->list_model->get_division_list($search['group_id']);
		}
		
		$param['list_claim_type'] = $this->list_model->get_claim_type_list();
		$param['search_param'] = $search;
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();
		$this->load->view('v_oas035', $param);
	}

	function load_view()
	{
		$employeeID = $this->user['id'];
		$param['employeeGroup'] = $this->user['group'];

		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_list($param);
		$param['list_group'] = $this->list_model->get_group_list();
		$param['list_claim_type'] = $this->list_model->get_claim_type_list();
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();
		$this->load->view('v_oas035', $param);
	}

	function load_division($group_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($group_id != ''){
			$division_list = $this->list_model->get_division_list($group_id);
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

	function download()
	{
		$filename="Expense Claim Allowance Report";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		
		$submission_list = $this->list_model->get_search_list($employeeID, $search);
		

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['ref_no'] = $valuerecord['no_ref'];
			$row_array['id'] = $valuerecord['employee_id'];
			$row_array['name'] = $valuerecord['employee_name'];
			$row_array['email'] = $valuerecord['employee_email'];
			$row_array['group'] = $valuerecord['employee_group'];
			$row_array['division'] = $valuerecord['employee_division'];
			$row_array['claim_type'] = $valuerecord['claim_type'];
			$row_array['submitted'] = date('d F Y',strtotime($valuerecord['submitted_dt']));
			$row_array['receipt'] = date('d F Y',strtotime($valuerecord['tgl_kwitansi']));
			$row_array['accepted_dt'] = date('d F Y',strtotime($valuerecord['accepted_dt']));
			$row_array['accepted_by'] = $valuerecord['accepted_by'];
			
			
			$row_array['amount'] =  $valuerecord['total'];
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
			$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
			$objPHPExcel->getActiveSheet()->mergeCells('B2:M2');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:M3');
            $objPHPExcel->getActiveSheet()->getStyle('A5:Z5')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borderArray );
			
			$objPHPExcel->getActivesheet()->getStyle('A1')->getFont()->setBold(true);
			

			
			$objPHPExcel->getActivesheet()->getStyle('A5:M5')->getFont()->setBold(true);
			
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');

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
	$employeeID =$this->user['name'];
		$header = array();
		$header['A1'] = "CYBERTREND OFFICE AUTOMATION SYSTEM";
		$header['A2'] = "Tittle File :";
		$header['B2'] = "Expense Claim Allowance Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeID.')';
			$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";
			$header['E5'] = "Group";
			$header['F5'] = "Division";
			$header['G5'] = "Claim Type";
			$header['H5'] = "Submitted Date";
			$header['I5'] = "Receipt Date";
			$header['J5'] = "Accepted Date";
			$header['K5'] = "Accepted By";
			$header['L5'] = "Amount";
			$header['M5'] = "Status";

		return $header;
	}	
}

/* End of file c_oas035.php */
/* Location: ./application/controllers/c_oas035.php */