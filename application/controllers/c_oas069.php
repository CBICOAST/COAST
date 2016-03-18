<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS069
* Program Name     : List Total Per Charge Code
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma/Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 09-12-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS069 extends MY_Controller {

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
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));

		$this->load->model('m_oas069', 'list_model');
		
	}

	function index()
	{
		// $this->load->view('v_oas069');
	}
	
	function _get_post_data()
	{
		$search['chargecodetype_id'] = $this->input->get('chargecodetype');
		$search['chargecode_id'] = $this->input->get('chargecode');
		
		$search['year'] = $this->input->get('year');
		$search['month'] = $this->input->get('month');

		return $search;
	}

	function search()
	{
		$search = $this->_get_post_data();

		$employeeID = $this->user['id'];
		$param['employeeGroup'] = $this->user['group'];
		$param['this_id'] = $this->user['id'];
		$param['submission_list_ca'] = $this->list_model->get_search_ca($search);
		$param['submission_list_bt'] = $this->list_model->get_search_bt($search);
		$param['submission_list_cl'] = $this->list_model->get_search_cl($search);
		$param['list_chargecodetype'] = $this->list_model->get_chargecodetype_list();
		$param['month_list'] = $this->month_list;	
		
		if($search['chargecodetype_id'] != ''){
			$param['list_chargecode'] = $this->list_model->get_chargecode_list($search['chargecodetype_id']);
		}
		$param['search_param'] = $search;
		$param['month_list'] = $this->month_list;	
		
		$this->load->view('v_oas069', $param);

	}

	function load_view()
	{
		$employeeID = $this->user['id'];
		$param['employeeGroup'] = $this->user['group'];
		$param['this_id'] = $this->user['id'];
		$param['submission_list_ca'] = $this->list_model->get_list_ca();
		$param['submission_list_bt'] = $this->list_model->get_list_bt();
		$param['submission_list_cl'] = $this->list_model->get_list_cl();
		$param['list_chargecodetype'] = $this->list_model->get_chargecodetype_list();
		$param['month_list'] = $this->month_list;	
		
		$this->load->view('v_oas069', $param);
	}
	
	
	function load_chargecode($chargecodetype_id = '')
	{
		$out = array();
		header('Content-Type: application/x-json; charset=utf-8');

		if($chargecodetype_id != ''){
			$chargecode_list = $this->list_model->get_chargecode_list($chargecodetype_id);
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
		$filename="Report Total Per Charge Code";
		$search = $this->_get_post_data();
		$employeeID = $this->user['id'];
		$submission_list = $this->list_model->get_search_list($employeeID, $search);
		

		$recordArray = array();
		foreach ($submission_list as $keyidx => $valuerecord) 
		{
			$row_array['type'] = $valuerecord['chargecodetype_name'];
			$row_array['chargecode'] = $valuerecord['chargecode_id'];
			$row_array['descripsi'] = $valuerecord['chargecode_name'];
			$row_array['amount'] = $valuerecord['total'];
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
			$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
			$objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
            $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($borderArray );
			
			$objPHPExcel->getActivesheet()->getStyle('A1')->getFont()->setBold(true);
			

			
			$objPHPExcel->getActivesheet()->getStyle('A5:S5')->getFont()->setBold(true);
			
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
			$objPHPExcel->getActivesheet()->fromArray($recordArray, Null,'A6');

		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter= IOFactory::createwriter($objPHPExcel,'Excel5');

		
		
		// sending headers to force the user for download file
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'_'.date("Y-m-d H:i:s").'.xls"');
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
		$header['B2'] = "TTotal Per Charge Code Report";
		$header['A3'] = "Date of Access :";
		$header['B3'] = date("d-M-Y H:i:s").' ('.$employeeID.')';
		
			$header['A5'] = "Type";
			$header['B5'] = "Charge Code";
			$header['C5'] = "Descripsi";
			$header['D5'] = "Amount";
		// }

		return $header;
	}
	
	

}