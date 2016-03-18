<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS075
* Program Name     : Form Purchase Order
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 16-02-2015 21:45:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS075 extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas075','po_list_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		
		$this->url = empty($index) ? $host : $host . $index . '/';

	}
	
	function index()
	{
		
		$this->load->view('v_oas075');
	}

	function load_view ()
	{
			$param['this_id']	 		= $this->user['id'];
			$param['this_name'] 		= $this->user['name'];
			$param['this_email']		= $this->user['email'];
			$param['this_group'] 		= $this->_get_employee_group($param['this_id']);
			$param['this_division'] 	= $this->_get_employee_division($param['this_id']);
			$param['code'] 				= $this->_get_employee_codediv($param['this_division']);
			$param['this_rm']			= $this->_get_employee_rm($param['this_id']);
			$param['detail_dir'] 		= $this->_get_employee_dir($param['this_id']);		
			$param['detail_posid'] 		= $this->_get_employee_posid($param['this_id']);		
			$param['this_role']			= $this->_get_employee_role($param['this_id']);
			$param['this_join']			= $this->_get_employee_join_date($param['this_id']);	
			$param['detail_posid'] 		= $this->_get_employee_posid($param['this_id']);		
			$param['detail_level'] 		= $this->_get_employee_level($param['this_id']);			
			$param['refpr'] 			= $this->po_list_model->cek_no_ref();
			
			$param['detail_pur'] = $this->_get_employee_pur($param['this_id']);
			$param['KODE'] 		= $this->_get_employee_codediv($param['this_division']);
		
		$this->load->view('v_oas075', $param);
	}

	function get_vendor($form_id){
	$param['form_data'] 		= $this->po_list_model->getFormID($form_id);
	}

	function get_noref(){
	$id 	= $this->input->get('code');
	$tampil	= $this->po_list_model->get_form_detail($id);
	$curs 	= $this->po_list_model->get_form_detail($id);
	$vendor = $this->po_list_model->getFormID($id);
	$rm 	= $this->po_list_model->get_form_RM();
	$ship   = $this->po_list_model->get_ship_to($id);
	$cuptotal = $this->po_list_model->get_form_detail($id);
	$no = 0;
	$po_amount = 0;
	
	?>
	<select  hidden id="select_cuptotal"><?
			foreach($cuptotal as $data)
			{?>			
				
				<option value="<?php echo $data['cupcup']?>"><?php echo $data['cupcup']; ?></option><?
			}?>
		</select>
	<select hidden id="select_curs"><?
			foreach($curs as $data)
			{?>			
				
				<option value="<?php echo $data['curs']?>"><?php echo $data['curs']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_amount"><?
			foreach($curs as $data)
			{?>			
				
				<option value="<?php echo $data['total']?>"><?php echo $data['total']; ?></option><?
			}?>
		</select>
	
	
		<select hidden id="select_prid"><?
			foreach($curs as $data)
			{?>			
				
				<option value="<?php echo $data['id']?>"><?php echo $data['id']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vcomp"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['company']?>"><?php echo $data['company']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vattn"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['attn']?>"><?php echo $data['attn']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vadd"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['address']?>"><?php echo $data['address']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vcity"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['city']?>"><?php echo $data['city']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vphone"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['phone']?>"><?php echo $data['phone']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vzip"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['zip']?>"><?php echo $data['zip']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_vfax"><?
			foreach($vendor as $data)
			{?>			
				
				<option value="<?php echo $data['fax']?>"><?php echo $data['fax']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_stcomp"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['scompany']?>"><?php echo $data['scompany']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_stadd"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['saddress']?>"><?php echo $data['saddress']; ?></option><?
			}?>
		</select>

		<select hidden id="select_stcp"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['scp']?>"><?php echo $data['scp']; ?></option><?
			}?>
		</select>	
		
		<select hidden id="select_sttelp"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['stelp']?>"><?php echo $data['stelp']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_stemail"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['semail']?>"><?php echo $data['semail']; ?></option><?
			}?>
		</select>
		
		<select hidden id="select_stnpwp"><?
			foreach($ship as $data)
			{?>			
				
				<option value="<?php echo $data['snpwp']?>"><?php echo $data['snpwp']; ?></option><?
			}?>
		</select>
		
	<table class=" table-striped table-bordered table-hover table-heading no-border-bottom"  id="hidetable" color = "#4682B4">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="5%">
			<col width="15%">
			<col width="5%">
			<col width="5%">
			
			
		</colgroup>
		<thead>
			<tr>
				<td colspan="6" align="center"><b>PURCHASE ORDER</b></td>
			</tr>
			<tr>
				<th class="text-center">No.</th>
				<th class="text-center">Qty</th>
				<th class="text-center">Item</th>
				<th class="text-center">Description</th>
				<th class="text-center">Price</th>
				<th class="text-center">Total</th>
			</tr>
			
		</thead>	
		<tbody>
			<?php $no = 0;
			$po_amount = 0;
			
			if(isset($tampil)){
			foreach ($tampil as $key => $value) { 
				$no++;?>
				<tr >
					<td align="center"><?= $no ?></td>
					<td align="center"><?= $value['jumlah'] ?></td>
					<td align="center"><?= $value['unit'] ?></td>
					<td align="center"><?= $value['keterangan'] ?></td>
					<td align="center"><?echo number_format($value['price'],0,',','.'); ?></td>
					<td align="center"><?echo number_format($value['total'],0,',','.'); ?></td>
					<? $po_amount += $value['total'];?>

					</td>
					
				</tr>
			<?php }?>
			
			<tr>
				<td align="right" colspan="5"><b>Total</b></td>
				<td align="center"><?echo number_format($po_amount,0,',','.'); ?></td>
			
			</tr>
			
			<?php }?>
			</tbody>
	</table>
<?
	}
	
	function submit_form()
	{
		if($this->input->post('ajax') == '1')
		{
		$sbmt['this_email']	 = $this->user['email'];
		$sbmt['this_name']	 = $this->user['name'];
		$sbmt['EMPLOYEE_ID']     = $this->user['id'];
		$sbmt['this_division']  =  $this->_get_employee_division($sbmt['EMPLOYEE_ID']);
		$sbmt['PR_ID'] 	     = $this->input->post('prid');
		$sbmt['V_COMPANY'] 	 = $this->input->post('vcompany');
		$sbmt['V_ATTN'] 	 = $this->input->post('vattn');
		$sbmt['V_ADDRESS'] 	 = $this->input->post('vaddress');
		$sbmt['V_CITY'] 	 = $this->input->post('vcity');
		$sbmt['V_PHONE'] 	 = $this->input->post('vphone');
		$sbmt['V_ZIP'] 	 	 = $this->input->post('vzip');
		$sbmt['V_FAX'] 	 	 = $this->input->post('vfax');
		$sbmt['ST_COMPANY']  = $this->input->post('stcompany');
		$sbmt['ST_CP'] 		 = $this->input->post('stcp');
		$sbmt['ST_ADDRESS']  = $this->input->post('staddress');
		$sbmt['ST_MPHONE'] 	 = $this->input->post('stmphone');
		$sbmt['ST_EMAIL'] 	 = $this->input->post('stemail');
		$sbmt['ST_NPWP'] 	 = $this->input->post('stnpwp');
		$sbmt['REMARK'] 	 = $this->input->post('po_remarks');
		$sbmt['EMPLOYEE_RM_ID']	 = $this->input->post('pur_id');
		
		$sbmt['PURCHASE_EMAIL']	 = $this->input->post('pur_email');
		
		$sbmt['PURCHASE_NAME']	 = $this->input->post('pur_name');
		$sbmt['AMOUNT_ITEM'] = $this->input->post('amount');
		$sbmt['AMOUNT_PPN'] = $this->input->post('ppn');
		$sbmt['AMOUNT_TOTAL'] = $this->input->post('amounttotal');
		$sbmt['KODE'] 		= $this->_get_employee_codediv($sbmt['this_division']);

		$response = $this->po_list_model->submitPOform($sbmt);

            echo $response;
		}
	}
	}
/* End of file c_oas075.php */
/* Location: ./application/controllers/c_oas075.php */