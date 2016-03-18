 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS062
* Program Name     : Form Approval BT
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 01-12-2014 16:00:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS062 extends MY_Controller {

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

		$this->load->model('m_oas062', 'bt_model');		
	}


	function index()
	{		
		$this->load->view('v_oas062');
	}
	
	//Mengambil data untuk ditampilkan
	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		
		$param['form_detail'] = $this->bt_model->get_form_detail($form_id);
		$param['form_detail_transport'] = $this->bt_model->get_form_detail_transport($form_id);
		$param['form_detail_ac'] = $this->bt_model->get_form_detail_ac($form_id);
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_level'] = $this->_get_employee_level($param['form_detail']['employee_id']);	
		$param['detail_ga'] = $this->_get_employee_ga($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		
		// printz($param);
		$this->load->view('v_oas062', $param);
	}
	
	//untuk mengambil data submit
	
}
