 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS071
* Program Name     : Form Konfirmasi Purchase Request 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS071 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas071', 'pr_form_model');
		$this->load->model('m_oas072', 'listpr_form_model');
		$this->load->model('m_oas038', 'ca_model');	
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas071');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['form_detail'] = $this->pr_form_model->get_form_detail($form_id);
		$param['detail_vendor'] = $this->pr_form_model->get_vendor($form_id);
		$param['detail_shipto'] = $this->pr_form_model->get_shipto($form_id);
		$param['list_pr'] = $this->pr_form_model->get_list_tmppr($form_id);	
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		$param['detail_dir'] = $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_pur'] = $this->_get_employee_pur($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		$param['this_group'] = $this->_get_employee_group($param['this_id']);
		$param['approval_internal'] = $this->ca_model->get_approval_internal($param['this_group']);
		$param['idPR'] = $this->pr_form_model->getPR_ID($param['this_id']);
		$param['list_doc'] = $this->pr_form_model->get_list_doc($form_id);	
		$param['approval_pro_tra'] = $this->ca_model->get_approval_pro_tra();
		$param['approval_license'] = $this->ca_model->get_approval_license();
		
        
		$this->load->view('v_oas071', $param);
	}
	
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['ACTIVITY_TYPE_ID']  	  = $this->input->post('activity');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			
			$sbmt['FINAL_APPROVE'] 	 		  = $this->input->post('akuntan');
			$sbmt['FINAL_APPROVE_EMAIL'] 	  = $this->input->post('akuntan_email');
			$sbmt['FINAL_APPROVE_NAME']		  = $this->input->post('akuntan_name');
			
			$sbmt['DIR_APPROVE'] 	 		  = $this->input->post('dir');
			$sbmt['DIR_EMAIL'] 	 		  = $this->input->post('dir_email');
			$sbmt['DIR_NAME'] 	 		  = $this->input->post('dir_name');
			
			$sbmt['PURCHASE'] 	 		  = $this->input->post('pur');
			$sbmt['PURCHASE_EMAIL'] 	  = $this->input->post('pur_email');
			$sbmt['PURCHASE_NAME'] 		  = $this->input->post('pur_name');
			
			$sbmt['STATUS']  	 	  = $this->input->post('approval');
			$sbmt['C_TYPE']		  = $this->input->post('c_type');
			$sbmt['B_STATUS']		  = $this->input->post('b_status');
			$sbmt['VENDOR']		  = $this->input->post('vendor');
			$sbmt['QUOT_NO']		  = $this->input->post('quot_no');
			$sbmt['REMARKS']		  = $this->input->post('remarks');
			$sbmt['TGL1']		  = $this->input->post('tgl_1');
			$sbmt['JML1']		  = $this->input->post('jml_1');
			$sbmt['R1']		  = $this->input->post('r1');
			$sbmt['R2']		  = $this->input->post('r2');
			$sbmt['R3']		  = $this->input->post('r3');
			$sbmt['R4']		  = $this->input->post('r4');
			$sbmt['TGL2']		  = $this->input->post('tgl_2');
			$sbmt['JML2']		  = $this->input->post('jml_2');
			$sbmt['TGL3']		  = $this->input->post('tgl_3');
			$sbmt['JML3']		  = $this->input->post('jml_3');
			$sbmt['TGL4']		  = $this->input->post('tgl_4');
			$sbmt['JML4']		  = $this->input->post('jml_4');
			
			$sbmt['S_COMPANY']		  = $this->input->post('v_comp');
			$sbmt['S_ADDRESS']		  = $this->input->post('v_add');
			$sbmt['S_CP']		  = $this->input->post('v_cp');
			$sbmt['S_TELP']		  = $this->input->post('v_phone');
			$sbmt['S_EMAIL']		  = $this->input->post('v_email');
			$sbmt['S_NPWP']		  = $this->input->post('v_npwp');
			
			$sbmt['COMPANY']		  = $this->input->post('s_name');
			$sbmt['ATTN']		  = $this->input->post('s_attn');
			$sbmt['ADDRESS']		  = $this->input->post('s_add');
			$sbmt['CITY']		  = $this->input->post('s_city');
			$sbmt['PHONE']		  = $this->input->post('s_phone');
			$sbmt['ZIP']		  = $this->input->post('s_zip');
			$sbmt['FAX']		  = $this->input->post('s_fax');
			
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['REQUESTER_EMAIL']  = $this->input->post('requesterid_email');
			$sbmt['REQUESTER_NAME']	  = $this->input->post('requesterid_name');
			
			$sbmt['SENDER_EMPLOYEE_ID']	= $this->input->post('aprove');
			
			$sbmt['rm']		  = $this->input->post('rm');
			
			$sbmt['approvalgr']		  = $this->input->post('approvalgr');
			$sbmt['approvalgr_email'] = $this->input->post('approvalgr_email');
			$sbmt['approvalgr_name']  = $this->input->post('approvalgr_name');
			
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['status_po']		  = $this->input->post('status_po');
			$sbmt['AMOUNT']			  = $this->input->post('amount');
			$sbmt['LIMIT']			  = $this->input->post('limit');
			$sbmt['DIVID']			  = $this->input->post('divid');
			$sbmt['ref_no']			  = $this->input->post('refno');
			$sbmt['status_name']			  = $this->input->post('status_name');
			$sbmt['this_email'] 	  = $this->user['email'];
			$response = $this->pr_form_model->save_confirmation($sbmt);
			
			$employeeID					= $this->user['id'];
			$param['employeeGroup']		= $this->user['group'];
			$param['this_id']			= $this->user['id'];
			$param['submission_list']	= $this->listpr_form_model->get_list($param);
			$param['detail_admin']		= $this->_get_employee_admin($employeeID);
			$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
			$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
			$param['detail_pur'] 		= $this->_get_employee_pur($employeeID);
			$param['list_group']		= $this->listpr_form_model->get_group_list();
			$param['list_chargecodetype']		= $this->listpr_form_model->get_chargecodetype_list();
			$param['month_list']		= $this->month_list;	
			$param['employee_list']		= $this->listpr_form_model->get_employee_list();
		
			$this->load->view('v_oas072', $param);
		}
	}
	
	
	function revise_pr()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['ACTIVITY_TYPE_ID']  	  = $this->input->post('activity');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			
			$sbmt['STATUS']  	 	  = $this->input->post('approval');
			
			$sbmt['PURCHASE'] 	 		  = $this->input->post('pur');
			$sbmt['PURCHASE_EMAIL'] 	  = $this->input->post('pur_email');
			$sbmt['PURCHASE_NAME'] 		  = $this->input->post('pur_name');
			
			$sbmt['DIR_APPROVE'] 	 		  = $this->input->post('dir');
			$sbmt['DIR_EMAIL'] 	 		  = $this->input->post('dir_email');
			$sbmt['DIR_NAME'] 	 		  = $this->input->post('dir_name');
			
			$sbmt['AMOUNT']			  = $this->input->post('amount');
			$sbmt['LIMIT']			  = $this->input->post('limit');
			$sbmt['DIVID']			  = $this->input->post('divid');
			
			$sbmt['S_COMPANY']		  = $this->input->post('v_comp');
			$sbmt['S_ADDRESS']		  = $this->input->post('v_add');
			$sbmt['S_CP']		  = $this->input->post('v_cp');
			$sbmt['S_TELP']		  = $this->input->post('v_phone');
			$sbmt['S_EMAIL']		  = $this->input->post('v_email');
			$sbmt['S_NPWP']		  = $this->input->post('v_npwp');
			
			$sbmt['COMPANY']		  = $this->input->post('s_name');
			$sbmt['ATTN']		  = $this->input->post('s_attn');
			$sbmt['ADDRESS']		  = $this->input->post('s_add');
			$sbmt['CITY']		  = $this->input->post('s_city');
			$sbmt['PHONE']		  = $this->input->post('s_phone');
			$sbmt['ZIP']		  = $this->input->post('s_zip');
			$sbmt['FAX']		  = $this->input->post('s_fax');
			
			$sbmt['REMARKS']		  = $this->input->post('remarks');
			
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['REQUESTER_EMAIL']  = $this->input->post('requesterid_email');
			$sbmt['REQUESTER_NAME']	  = $this->input->post('requesterid_name');
			
			$sbmt['SENDER_EMPLOYEE_ID']	= $this->input->post('aprove');
			$sbmt['ref_no']			  = $this->input->post('refno');
			
			$sbmt['status_po']		  = $this->input->post('status_po');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['status_name']			  = $this->input->post('status_name');
			$sbmt['this_email'] 	  = $this->user['email'];
			
			$response = $this->pr_form_model->save_revise($sbmt);
			
			$employeeID					= $this->user['id'];
			$param['employeeGroup']		= $this->user['group'];
			$param['this_id']			= $this->user['id'];
			$param['submission_list']	= $this->listpr_form_model->get_list($param);
			$param['detail_admin']		= $this->_get_employee_admin($employeeID);
			$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
			$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
			$param['detail_pur'] 		= $this->_get_employee_pur($employeeID);
			$param['list_group']		= $this->listpr_form_model->get_group_list();
			$param['list_chargecodetype']		= $this->listpr_form_model->get_chargecodetype_list();
			$param['month_list']		= $this->month_list;	
			$param['employee_list']		= $this->listpr_form_model->get_employee_list();
			$this->load->view('v_oas072', $param);
		}
	}
	
function do_upload(){
	
	if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
{
	############ Edit settings ##############
	$UploadDirectory	= './assets/upload/'; //specify upload directory ends with / (slash)
	##########################################
	
	/*
	Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
	Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
	and set them adequately, also check "post_max_size".
	*/
	
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	
	//Is file size is less than allowed size.
	if ($_FILES["FileInput"]["size"] > 5242880) {
		die("File size is too big!");
	}
	
	//allowed file type Server side check
	switch(strtolower($_FILES['FileInput']['type']))
		{
			//allowed file types
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': //html file
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
				break;
			default:
				die('Unsupported File!'); //output error
	}
	
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $Random_Number.$File_Ext; //new file name
	
	$idPR=$_POST['prid'];
	
	if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
	   {
	   $filedok ="/OAS/assets/upload/".$NewFileName;
	   $this->db->query("INSERT INTO
							  documment(DOCCUMENT,
										NAMAFILE, PR_ID)
					VALUES
								('$filedok','$NewFileName','$idPR')");
		die('Success! File Uploaded.');
		
	}else{
		die('error uploading File!');
	}
	
}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}
}

}