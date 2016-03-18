<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS015
* Program Name     : Leave Request List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS015 extends MY_Controller {

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

		$this->load->model('m_oas015', 'list_model');
		
	}

	function index()
	{
		// $this->load->view('v_oas015');
	}

	function _get_post_data()
	{
		$search['employeeGroup'] = $this->user['group'];

		$search['employeeid'] = $this->input->get('employeeid');
		$search['employeename'] = $this->input->get('employeename');
		$search['leavetype'] = $this->input->get('leavetype');
		$search['group_id'] = $this->input->get('group');
		$search['division_id'] = $this->input->get('division');
		$search['leavestatus'] = $this->input->get('leavestatus');
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
		$param['detail_admin'] = $this->_get_employee_admin($employeeID);

		if($search['group_id'] != ''){
			$param['list_division'] = $this->list_model->get_division_list($search['group_id']);
		}
		
		$param['list_leave_type'] = $this->list_model->get_leave_type_list();
		$param['search_param'] = $search;
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();
		$this->load->view('v_oas015', $param);
	}

	function load_view()
	{
		$employeeID = $this->user['id'];
		$param['employeeGroup'] = $this->user['group'];
		$param['year'] = date("Y");

		$param['this_id'] = $this->user['id'];
		$param['submission_list'] = $this->list_model->get_list($param);
		$param['list_group'] = $this->list_model->get_group_list();
		$param['detail_admin'] = $this->_get_employee_admin($employeeID);
		$param['list_leave_type'] = $this->list_model->get_leave_type_list();
		$param['month_list'] = $this->month_list;	
		$param['employee_list'] = $this->list_model->get_employee_list();
		$this->load->view('v_oas015', $param);
	}

	function load_division($group_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($group_id != ''){
			$division_list = $this->list_model->get_division_list($group_id);
			if(isset($division_list)){
				$out[''] = '-- SEMUA --';
				foreach ($division_list as $division) {
					$out[$division['id']] = $division['name'];
				}
			}else{
				$out['0'] = '-- TIDAK ADA DATA --';
			}
		}
		else
		{
			$out[''] = '-- SEMUA --';
		}
		echo(json_encode($out));
	}

	function download()
	{
		$filename="Leave_report";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$submission_list = $this->list_model->get_search_list($employeeID, $search);
		// var_dump($submission_list);

		/*download process

		$data["file"]= file_get_contents("excel");
		$name = $this->uri->segment(3);

		force_download($name,$data);*/

		// if($type== "laporan_cuti")
		// { 
			
			// var_dump($record);

		// }else
			// {
				// echo "eror : laporan tidak bisa di download";
			// }

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['ref_no'] = $valuerecord['no_ref'];
			$row_array['id'] = $valuerecord['employee_id'];
			$row_array['name'] = $valuerecord['employee_name'];
			$row_array['email'] = $valuerecord['employee_email'];
			$row_array['group'] = $valuerecord['employee_group'];
			$row_array['division'] = $valuerecord['employee_division'];
			$row_array['leave_type'] = $valuerecord['leave_type'];
			$row_array['submitted'] = $valuerecord['submitted_dt'];
			$row_array['start'] = $valuerecord['start_dt'];
			$row_array['end'] = $valuerecord['end_dt'];
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
			$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
			$objPHPExcel->getActiveSheet()->mergeCells('B2:K2');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:K3');
            $objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($borderArray );
			
			$objPHPExcel->getActivesheet()->getStyle('A1')->getFont()->setBold(true);
			

			$objPHPExcel->getActivesheet()->getStyle('A5:K5')->getFont()->setBold(true);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
			
			
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
		// if($type=="laporan_cuti")
		// {
		$header['A1'] = "CYBERTREND OFFICE AUTOMATION SYSTEM";
		$header['A2'] = "Tittle File :";
		$header['B2'] = "Leave Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeID.')';
		
			$header['A5'] = "Ref. No";
			$header['B5'] = "NIK";
			$header['C5'] = "Name";
			$header['D5'] = "Email";
			$header['E5'] = "Group";
			$header['F5'] = "Division";
			$header['G5'] = "Leave Type";
			$header['H5'] = "Submitted Date";
			$header['I5'] = "Start";
			$header['J5'] = "End";
			$header['K5'] = "Status";
		// }

		return $header;
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/C_OAS004.php */