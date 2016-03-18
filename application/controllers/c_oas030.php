<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS030
* Program Name     : Pengaturan Approval
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 16-03-2015 10:23:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS030 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_oas030','m30');

	}

	function load_view($id)
	{
		
		$param['approval']	= $this->m30->get_Approval($id);
		$param['division_list'] = $this->m30->get_division_list();
		$param['employees'] = $this->m30->get_all_employee_list();
		
		$this->load->view('v_oas030', $param);
	}
	
	function getEmployee(){	
		$this->load->model('m_oas102');
		$id = $this->input->get('code');
		$showEmployeeList = $this->m30->get_employee_list($id);?>
		<select id="app_name030" onchange="getName()">
		<?if(isset($showEmployeeList)){	?>
			<?foreach($showEmployeeList as $data){?>				
				<option value="<?php echo $data['id']?>"><?php echo $data['nama']; ?></option>
			<?
			}
		}?>			
		</select><?			
	}
	
	function update_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_user']		= $this->user['email'];
			$sbmt['APPROVAL_FOR']  	= $this->input->post('appfor');
			$sbmt['EMPLOYEE_ID']  	= $this->input->post('empid');
            $response = $this->m30->updateApproval($sbmt);
            echo $response;
            $param['division_list'] = $this->m30->get_division_list();
			$this->load->view('v_oas030', $param);
		}
	}

	
}
