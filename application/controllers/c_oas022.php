<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS022
* Program Name     : Daftar Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 26-09-2014 13:14:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS022 extends MY_Controller {

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
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas022', 'list_model');
		
	}


	function _get_post_data()
	{
		$search['employeeGroup'] = $this->user['group'];
		$search['employeeid'] = $this->input->get('employeeid');
		$search['employeename'] = $this->input->get('employeename');
		$search['claimtype'] = $this->input->get('claimtype');
		$search['group_id'] = $this->input->get('group');
		$search['division_id'] = $this->input->get('division');
		$search['claimstatus'] = $this->input->get('claimstatus');
		$search['year'] = $this->input->get('year');
		$search['month'] = $this->input->get('month');

		return $search;
	}

	

	function load_view()
	{
		$employeeID = $this->user['id'];
		$param['employeeGroup'] = $this->user['group'];
		
		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_list($param);
		
		$param['detail_admin']	= $this->_get_employee_admin($employeeID);
		$param['detail_f2']	= $this->_get_employee_pur($param['this_id']);
		$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
		$param['list_group'] = $this->list_model->get_group_list();
		
		$param['list_claim_type'] = $this->list_model->get_claim_type();
		$param['list_status_claim'] = $this->list_model->get_status_list();
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();
		$this->load->view('v_oas022', $param);
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
				$out['0'] = '-- DATA NOT FOUND --';
			}
		}
		else
		{
			$out[''] = '-- All --';
		}
		echo(json_encode($out));
	}
	
	function search()
	{
		$search = $this->_get_post_data();

		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_search_list($employeeID, $search);
		$param['list_group'] = $this->list_model->get_group_list();

		$param['detail_admin'] = $this->_get_employee_admin($employeeID);
		if($search['group_id'] != ''){
			$param['list_division'] = $this->list_model->get_division_list($search['group_id']);
		}
		
		$param['list_claim_type'] = $this->list_model->get_claim_type();
		$param['list_status_claim'] = $this->list_model->get_status_list();
		$param['search_param'] = $search;
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();		
		$this->load->view('v_oas022', $param);

	}

	
	function download()
	{
		$filename="Expense Claim List";
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
			$row_array['category'] = $valuerecord['clType'];
			$row_array['total'] = $valuerecord['total'];
			$row_array['tgl'] =  date('d F Y',strtotime($valuerecord['tgl']));
			$row_array['status'] = $valuerecord['status'];
			$row_array['approved_by'] = $valuerecord['approved_by'];
			$row_array['approved_dt'] =  $valuerecord['approved_dt'];
			$row_array['accepted_by'] = $valuerecord['accepted_by'];
			$row_array['accepted_dt'] =  date('d F Y',strtotime($valuerecord['accepted_dt']));
			array_push($recordArray,$row_array);

		} 

		// starting the php excel
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getproperties()->settitle("export")->setDescription("none");

		$objPHPExcel->setActiveSheetIndex(0);

			$header= $this->get_report_header();

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
			$objPHPExcel->getActiveSheet()->getStyle('A5:N5')->applyFromArray($borderArray );
			$objPHPExcel->getActivesheet()->getStyle('A5:Z5')->getFont()->setBold(true);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

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
		$header['B2'] = "Expense Claim List";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeName.')';
		$header['A5'] = "Ref. No";
		$header['B5'] = "NIK";
		$header['C5'] = "Name";
		$header['D5'] = "Email";
		$header['E5'] = "Group";
		$header['F5'] = "Division";
		$header['G5'] = "Claim Type";
		$header['H5'] = "Total";
		$header['I5'] = "Date";
		$header['J5'] = "Status";
		$header['K5'] = "Approved By";
		$header['L5'] = "Approved Date";
		$header['M5'] = "Accepted By";
		$header['N5'] = "Accepted Date";
		
		return $header;
	}	
	
}

/* End of file c_oas022.php */
/* Location: ./application/controllers/c_oas022.php */