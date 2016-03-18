<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS070
* Program Name     : Form Pengajuan Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 12-02-2014 13:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_OAS099 extends MY_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';	
	}
 function index(){
		$this->load->view('v_oas099', array('error' => ' ' ));
	}
 
	function upload(){
	$config['upload_path'] = './assets/upload/'; //lokasi folder yang akan digunakan untuk menyimpan file
	 $config['allowed_types'] = 'gif|jpg|png|JPEG|pdf'; //extension yang diperbolehkan untuk diupload
	 $config['file_name'] = url_title($this->input->post('file_upload'));
	 $this->load->library('upload',$config);
	 
	 
	$this->upload->initialize($config); //meng set config yang sudah di atur
	 if( !$this->upload->do_upload('dokumen'))
	 {
		$error = array('error' => $this->upload->display_errors());
 
			$this->load->view('v_oas099', $error);
	 }
	 else{
	 $data = array('upload_data' => $this->upload->data());
	 $dok =$this->upload->data();
			$data['upload_data'] = $dok;
			if ($dok['file_name']){
			$filedok ="/OAS/assets/upload/".$dok['file_name'];
			$namadok =$dok['file_name'];
			}
			
			$this->db->query("INSERT INTO
							  documment(DOCCUMENT, NAMAFILE,
												PR_ID)
					VALUES
								('$filedok','$namadok',
						         (SELECT MAX(PR_ID) From tb_r_pr))");
			$this->load->view('uploadsukses',$data); 
		}
}
}
?>