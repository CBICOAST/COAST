<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS005
* Program Name     : Daftar User & Karyawan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 24-08-2014 15:46:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1					 09-11-2014			Metta Kharisma 		 Function Download, Search
* 2					 23-02-2015			Metta Kharisma 		 Menambah field download
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS005 extends MY_Controller {

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
		
		// $this->load->model('mMain');
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas005','user_list_model');

		// $this->load->model('m_oas002', 'main_frame_model');
		
	}

	function index()
	{
	}
	
	function _get_post_data()
	{
		
		
		$search['employeeid'] = $this->input->get('employeeid');
		$search['statusid'] = $this->input->get('statusid');
		

		return $search;
	}


	function load_view()
	{
		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['user_list'] = $this->user_list_model->get_list();
		$param['status_list'] = $this->user_list_model->get_employee_status();
		$param['employee_list'] = $this->user_list_model->get_employee_list();
		$this->load->view('v_oas005', $param);
	}

	function load_view_read_only()
	{
		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['user_list'] = $this->user_list_model->get_list();
		$param['employee_list'] = $this->user_list_model->get_employee_list();
		$param['readonly'] = 1;
		
		// printz($submission_list);
		$this->load->view('v_oas005', $param);
	}

	function search_readonly()
	{
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['user_list'] = $this->user_list_model->get_user($employeeID, $search);
		$param['status_list'] = $this->user_list_model->get_employee_status();
		$param['search_param'] = $search;
		$param['employee_list'] = $this->user_list_model->get_employee_list();
		$param['readonly'] = 1;
		$this->load->view('v_oas005', $param);

		// printz($param);
	}
	
	function search()
	{
	$search = $this->_get_post_data();

		$employeeID = $this->user['id'];
		$param['this_id'] = $this->user['id'];
		$param['user_list'] = $this->user_list_model->get_user($employeeID, $search);
		
		
		$param['status_list'] = $this->user_list_model->get_employee_status();
		$param['search_param'] = $search;
		$param['employee_list'] = $this->user_list_model->get_employee_list();
		$this->load->view('v_oas005', $param);

		// printz($param);
	}
	function download()
	{
		$filename="Employee Report";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$user_list = $this->user_list_model->get_user ($employeeID, $search);
		$recordArray = array();
		foreach ($user_list as $keyidx => $valuerecord) 
		{
			$row_array['id'] = $valuerecord['EMPLOYEE_ID'];
			$row_array['name'] = $valuerecord['EMPLOYEE_NAME'];
			$row_array['gender'] = $valuerecord['GENDER'];
			$row_array['dateofhiered'] = date('d F Y',strtotime($valuerecord['JOIN_DATE']));
			$row_array['dateofbirth'] = date('d F Y',strtotime($valuerecord['BIRTH_DATE']));
			$row_array['nik'] = $valuerecord['ID_CARD_NUMBER'].' ';
			$row_array['stat'] = $valuerecord['STATUSEMP'].' ';
			$row_array['group'] = $valuerecord['GROUP_ID'];
			$row_array['divisi'] = $valuerecord['DIVISION_ID'];
			$row_array['email'] = $valuerecord['USER_EMAIL'];
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
			$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->applyFromArray($borderArray );
			$objPHPExcel->getActivesheet()->getStyle('A5:Z5')->getFont()->setBold(true);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(23);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(43);

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
		$header['B2'] = "Employee Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeName.')';
		$header['A5'] = "EMPLOYEE ID";
		$header['B5'] = "EMPLOYEE NAME";
		$header['C5'] = "GENDER";
		$header['D5'] = "DATE OF HIRED";
		$header['E5'] = "DATE OF BIRTH";
		$header['F5'] = "ID NUMBER";
		$header['G5'] = "STATUS EMPLOYEE";
		$header['H5'] = "GROUP";
		$header['I5'] = "DIVISION";
		$header['J5'] = "EMAIL";
			
			
		
		return $header;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */