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

class C_OAS070 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
				
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas070', 'pr_model');
		
	}
	
function load_chargecode($group_id)
	{
	
		$out = array();
		$chargecode_list = $this->pr_model->get_ccode_list($group_id);
		header('Content-Type: application/x-json; charset=utf-8');
		if(isset($chargecode_list)){
			foreach ($chargecode_list as $chargecode) {
				$out[$chargecode['id']] = $chargecode['name'];
			}
		}else{
			$out['0'] = '-- DATA NOT FOUND --';
		}
		echo(json_encode($out));
	}


	// mendapatkan daftar project description berdasarkan tipe charge code
	function get_pd(){
	$this_id = $this->user['id'];
	$id 	= $this->input->get('code');	
	$tampil	= $this->pr_model->get_project_description($id);?>
	
	<select id="cc"><?
			foreach($tampil as $data)
			{?>				
				<option style="display: none;" value="-">--choose one---</option>
				<option value="<?php echo $data['CHARGE_CODE']?>"><?php echo $data['PROJECT_DESCRIPTION']; ?></option><?
			}?>
		</select><?
	}		
			
function get_satuan(){
	$satuan 		= $this->input->get('description');
	$show_destination	= $this->pr_model->get_satuan($satuan);?>
		<select id="satuan"><?
			foreach($show_destination as $data)
			{?>
				<option value="<?php echo $data['satuan']?>"></option><?
			}?>
		</select><?
	}

	function load_view()
	{
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['code'] = $this->_get_employee_codediv($param['this_division']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['detail_dir'] = $this->_get_employee_dir($param['this_id']);		
			
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['this_role']			= $this->_get_employee_role($param['this_id']);
		$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);	

		$param['item'] = $this->pr_model->list_item();	
		$param['vendor'] = $this->pr_model->list_vendor();	
		$param['shipto'] = $this->pr_model->list_shipto();	
		
		$param['list_cctype'] = $this->pr_model->get_cctype_list();		
		$param['charge_code_type']	= $this->pr_model->get_charge_code_type();	
		$param['currency'] 			= $this->pr_model->get_currency_list();
		$DelRef= $this->pr_model->delPR_ID($param['this_id']);
		echo $DelRef;
		$response = $this->pr_model->insertPR_ID($param);
		$param['idPR'] = $this->pr_model->getPR_ID($param['this_id']);
         echo $response;
		$param['list_pr'] = $this->pr_model->get_list_tmppr($param['idPR']);
		$param['list_doc'] = $this->pr_model->get_list_doc($param['idPR']);
		$this->load->view('v_oas070', $param);
	}

	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{	
			$sbmt['EMPLOYEE_ID']     = $this->user['id'];
			$sbmt['EMPLOYEE_EMAIL']  = $this->user['email'];
			$sbmt['EMPLOYEE_NAME']  = $this->user['name'];
			
			$sbmt['this_division'] = $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
			$sbmt['code'] = $this->_get_employee_codediv($sbmt['this_division']);
			$sbmt['CHARGE_CODE']  	 = $this->input->post('chargeCode');
			$sbmt['CURRENCY'] 		 = $this->input->post('mata_uang');
			$sbmt['AMOUNT_ITEM'] 		 = $this->input->post('amount');
            $sbmt['REMARKS']	 	 = $this->input->post('remark');	
			
            $sbmt['EMPLOYEE_RM_ID']	 = $this->input->post('employeerm');	
            $sbmt['EMPLOYEE_RM_NAME']	 = $this->input->post('employeerm_name');
            $sbmt['EMPLOYEE_RM_EMAIL']	 = $this->input->post('employeerm_email');
			
            $sbmt['REMARKS']	 	 = $this->input->post('remark');	

			$sbmt['B_STATUS']		  = $this->input->post('b_status');
			$sbmt['USER_STATUS']		  = $this->input->post('user_status');
			$sbmt['VENDOR']		  = $this->input->post('vendor');
			$sbmt['QUOT_NO']		  = $this->input->post('quot_no');
			$sbmt['TGL1']		  = $this->input->post('tgl_1');
			$sbmt['JML1']		  = $this->input->post('jml_1');
			$sbmt['REMARKP1']		  = $this->input->post('remarkp1');
			$sbmt['TGL2']		  = $this->input->post('tgl_2');
			$sbmt['JML2']		  = $this->input->post('jml_2');
			$sbmt['REMARKP2']		  = $this->input->post('remarkp2');
			$sbmt['TGL3']		  = $this->input->post('tgl_3');
			$sbmt['JML3']		  = $this->input->post('jml_3');
			$sbmt['REMARKP3']		  = $this->input->post('remarkp3');
			$sbmt['TGL4']		  = $this->input->post('tgl_4');
			$sbmt['JML4']		  = $this->input->post('jml_4');		
			$sbmt['REMARKP4']		  = $this->input->post('remarkp4');	
			$sbmt['DOCUMENT']		  = $this->input->post('docsup');		
			$sbmt['PR_ID']  	  = $this->input->post('PR_ID');
            $sbmt['ref'] = $this->pr_model->getRef($sbmt);
			
			$sbmt['COMPSHIP']		  = $this->input->post('compship');
			$sbmt['ATTNSHIP']		  = $this->input->post('attnship');	
			$sbmt['ADDSHIP']		  = $this->input->post('addship');
			$sbmt['CITYSHIP']		  = $this->input->post('cityship');	
			$sbmt['PHONESHIP']		  = $this->input->post('phoneship');
			$sbmt['ZIP']		  = $this->input->post('zip');
			$sbmt['FAX']		  = $this->input->post('fax');
			
			$sbmt['COMPVENDOR']		  = $this->input->post('compvendor');	
			$sbmt['ADDVENDOR']		  = $this->input->post('addvendor');
			$sbmt['CP']		  = $this->input->post('cp');	
			$sbmt['PHONEVENDOR']		  = $this->input->post('phonevendor');
			$sbmt['EMAILVENDOR']		  = $this->input->post('emailvendor');		
			$sbmt['NPWP']		  = $this->input->post('npwp');	
			$save_vendor = $this->pr_model->save_vendor($sbmt);
			$save_shipto = $this->pr_model->save_shipto($sbmt);
			
            $response = $this->pr_model->submitPRForm($sbmt);

            echo $response;
			
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
	   $filedok ="/assets/upload/".$NewFileName;
	   $this->db->query("INSERT INTO
							  documment(DOCCUMENT,
										NAMAFILE, PR_ID)
					VALUES
								('$filedok','$NewFileName','$idPR')");
		die('Success! File Uploaded.'.$File_Name );
		
	}else{
		die('error uploading File!');
	}
	
}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}
}


	function save_pr()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbt['QTY']  	  = $this->input->post('QTY');
		$sbt['SATUAN']  	  = $this->input->post('ITEM');
		$sbt['NAMA']  	  = $this->input->post('DESCRIPTION');
		$sbt['HARGA']  	  = $this->input->post('PRICE');
		$sbt['TOTAL']  	  = $this->input->post('TOTAL');
		$sbt['KETERANGAN']  	  = $this->input->post('KETERANGAN');
		$sbt['PR_ID']  	  = $this->input->post('PR_ID');
		
		$param['pr_save'] = $this->pr_model->pr_save($sbt);
       
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['code'] = $this->_get_employee_codediv($param['this_division']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['detail_dir'] = $this->_get_employee_dir($param['this_id']);		
			
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['this_role']			= $this->_get_employee_role($param['this_id']);
		$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);	
		
		$param['idPR']  	  = $this->input->post('PR_ID');

		$param['list_doc'] = $this->pr_model->get_list_doc($param['idPR']);
		$param['list_pr'] = $this->pr_model->get_list_tmppr($sbt['PR_ID']);
		$param['item'] = $this->pr_model->list_item();		
		$param['vendor'] = $this->pr_model->list_vendor();	
		$param['shipto'] = $this->pr_model->list_shipto();
		
		$param['list_cctype'] = $this->pr_model->get_cctype_list();		
		$param['charge_code_type']	= $this->pr_model->get_charge_code_type();	
		$param['currency'] 			= $this->pr_model->get_currency_list();

		$this->load->view('v_oas070', $param);
			
		}
	}
	function del_item($id)
	{
	
		$param['del_item'] = $this->pr_model->delete_itempr($id);
		
		$param['this_id']	 		= $this->user['id'];
		$param['this_name'] 		= $this->user['name'];
		$param['this_email']		= $this->user['email'];				
		$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
		$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
		$param['code'] = $this->_get_employee_codediv($param['this_division']);
		$param['this_rm']			= $this->_get_employee_rm($param['this_id']);	
		$param['detail_dir'] = $this->_get_employee_dir($param['this_id']);		
			
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['this_role']			= $this->_get_employee_role($param['this_id']);
		$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
		$param['detail_posid'] = $this->_get_employee_posid($param['this_id']);		
		$param['detail_level'] = $this->_get_employee_level($param['this_id']);	
		$param['idPR'] = $this->pr_model->getPR_ID($param['this_id']);
        $param['list_pr'] = $this->pr_model->get_list_tmppr($param['idPR']);		
		$param['item'] = $this->pr_model->list_item();
		$param['vendor'] = $this->pr_model->list_vendor();	
		$param['shipto'] = $this->pr_model->list_shipto();	
		
		$param['list_cctype'] = $this->pr_model->get_cctype_list();		
		$param['charge_code_type']	= $this->pr_model->get_charge_code_type();	
		$param['currency'] 			= $this->pr_model->get_currency_list();

		$this->load->view('v_oas070', $param);
	}
	
}

