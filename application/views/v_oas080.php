 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS080
* Program Name     : Form Detail Purchase Order 
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:09:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">PURCHASE ORDER DETAIL</h3>
            </div>
            <div class="box-body">
            
			 <div class="requester-detail form-section-container">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Employee Name</label>
                    <div class="input-group">
						<input type="text" readonly class="form-control" value="<?= $form_detail['employee_name'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">NIK</label>
                    <div class="input-group">
                        <input type="email" readonly class="form-control" value="<?= $form_detail['employee_id'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" >Group / Division</label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<?echo $detail_group.' / '. $detail_division ?>">
                    </div>
                </div>
				
				<div class="form-group">
                <label class="col-sm-4 control-label" for="currency"><b>Status</b></label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="currency" value="<?= $form_detail['status_name'] ?>"></input>
                </div>
            </div>  
					
			</div> <!-- /.requester-detail -->
			
			<!-- .Cash Advance - detail -->
            <div class="requester-detail form-section-container">
            <table class=" table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="15%">
			<col width="20%">
			<col width="10%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="6" align="center">LIST PURCHASE ORDER</td>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">QTY</th>
				<th class="text-center">Item</th>
				<th class="text-center">Description</th>
				<th class="text-center">Price</th>
				<th class="text-center">Total</th>
			</tr>
		</thead>
		
				<tbody>
			<?php $no = 0; $total1 =0; $ppn=0; $subtotal=0;
			
			if(isset($list_pr)){
			foreach ($list_pr as $key => $value) { 
				$no++;?>
				<tr >
					<td align="center"><?= $no ?></td>
					<td align="center"><?= $value['qty']?></td>
					<td align="center"><?= $value['satuan'] ?></td>					
					<td align="center"><?echo $value['nama']; ?></td>
					<td align="right"><?echo number_format($value['harga'],0,',','.'); ?></td>
					<td align="right"><? echo number_format($value['total'],0,',','.'); ?></td>
					
					<? $total1 += $value['total'];?>
					<? $ppn = $value['ppn'];?>
					<? $subtotal = $value['subtotal'];?>
				</tr>
				
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="6">NOT FOUND!</td>
			</tr>
			<?php } ?>
			<tr>
				<td align="right" colspan="5"><b>TOTAL</b></td>
				<td align="right"  colspan="1" ><b><?php echo number_format($total1,0,',','.'); ?></b></td>
			</tr>
			<tr>
				<td align="right" colspan="5"><b>PPN 10%</b></td>
				<td align="right"  colspan="1" ><b><?php echo number_format($ppn,0,',','.'); ?></b></td>
			</tr>
			<tr>
				<td align="right" colspan="5"><b>Sub Total</b></td>
				<td align="right"  colspan="1" ><b><?php echo number_format($subtotal,0,',','.'); ?></b></td>
			</tr>
		
		</tbody>
	</table>
					
			</div>
		
			<!-- .Cash Advance - detail -->
            <div class="requester-detail form-section-container">
            <table class="  no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="20%">
			<col width="15%">
			<col width="20%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="5" align="left">History Form</td>
			</tr>
			<tr>
				<th colspan="2" class="text-left">Description</th>
				<th class="text-left">By</th>
				<th class="text-left">Date Time</th>
				<th class="text-left">Remarks</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				 <td >1.</td>
				<td class="text-left">Requested</td>
				<td class="text-left"><?= $form_detail['employee_name'] ?></td>
				<td class="text-left"><?= $form_detail['submitted_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks'] ?></td>
			</tr><?php if ($form_detail['remarks']!= '') {?>
			<tr>
				 <td >2.</td>
				<td class="text-left">Created</td>
				<td class="text-left"><?= $form_detail['createdbypo'] ?></td>
				<td class="text-left"><?= $form_detail['createddtpo']; ?></td>
				<td class="text-left"><?= $form_detail['remarkpo'] ?></td>
			</tr><?php if ($form_detail['remarkpo']!= '') {?>
			<tr>
				 <td >3.</td>
				<td class="text-left">Accepted</td>
				<td class="text-left"><?= $form_detail['approvepur_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvepur_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarkspur'] ?></td>
			</tr><?}}?>
		</tbody>
	</table>
					
			</div>
				
					
				
			 
			</div> <!-- /.box-body -->
		</div><!-- /.box box-danger -->
      
    </div><!-- /.col (left) -->
	
<div class="row">
    <div class="col-md-6">

            <div class="box-body">
<div class="requester-detail form-section-container">
				
                <div class="form-group">
                    <label class="col-sm-4 control-label">No. Ref PO :</label>
                    <div class="input-group">
						<input type="text" readonly class="form-control" value="<?= $form_detail['no_ref'] ?>">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-4 control-label">No. Ref PR :</label>
                    <div class="input-group">
						<input type="text" readonly class="form-control" value="<?= $form_detail['no_ref_pr'] ?>">
                </div>
                </div>
				<div class="form-group">
                <label class="col-sm-4 control-label" for="submitted_dt">Submitted Date</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])); ?>"></input>
				</div>
            </div>
			</div>
              
                <div class="requester-detail form-section-container">
                    <div class="form-group">
                <label class="col-sm-4 control-label" for="chargecode">Charge Code</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="chargecode"  value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_name'].')';?>"></input>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="chargecode_des">Description</label>
                <div class="input-group">
                    <label ><?echo ' '.$form_detail['ccdes'] ;?></label>
                </div>
            </div>
                <div class="form-group">
                <label class="col-sm-4 control-label" for="currency">Currency</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="currency" value="<?= $form_detail['currency_name'] ?>"></input>
                </div>
            </div>    
            </div><!-- /.box-body -->   
			
	
<div class="requester-detail form-section-container">
<a><label id="klikdetail1" title="klik to detail"><h4><b> Filled by Finance Departement</b></h4></label></a>
<table hidden id="detail1" class=" no-border-bottom">			
			
		<colgroup>
			<col width="2%">
			<col width="25%">
			<col width="15%">
			<col width="25%">
			<col width="15%">
			<col width="2%">
		</colgroup>
		
		
		<tbody>
		<tr>
				<th class="text-center"></th>
				<th class="text-left"> 1. Cost Type</th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php if ($form_detail['c_type'] == '1'){ echo 'BILLED'; }else { echo 'UNBILLED' ;}?></td>
				<th class="text-center"></th>
			</tr>
		<tr>
				<th class="text-center"></th>
				<th class="text-left"> 2. Budget Status </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php if ($form_detail['b_status'] == '1') echo 'BUDGET'; else echo 'UNBUDGET' ;?></td>
				<th class="text-center"></th>
			</tr>
		<tr>
				<th class="text-center"></th>
				<th class="text-left"> Vendor </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="2"><?php echo $detail_vendor['v_name'] ;?></td>
				<th class="text-center"></th>
			</tr>
		<tr>
				<th class="text-center"></th>
				<th class="text-left"> Quotation No </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="2"><?php echo $form_detail['q_no'] ;?></td>
				<th class="text-center"></th>
			</tr>
			
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<tr> <th ></th>
			<td class="text-left"><b>Ship To</b></td>
			<th class="text-center">:</th>
			<td colspan="5" class="text-left"><?php echo $detail_shipto['sh_name']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Address</td>
			<th class="text-center">:</th>
			<td colspan="5" class="text-left"><?php echo $detail_shipto['sh_address']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - CP</td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_cp']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - No Telp</td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_telp']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Email</td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_email']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - NPWP</td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_npwp']; ?></td>
			<th ></th>
		</tr>
		<tr><td>
				&nbsp;
			</td>
		</tr>
		<tr>
				<th class="text-center"></th>
				<th class="text-left"> Term of Payment </th>
				<th class="text-center"></th>
				<th class="text-center">Date</th>
				<th class="text-right">Amount</th>
				<th class="text-center"></th>
			</tr>
			</tr>
				<tr>
				 <th class="text-center"></th>
				<td class="text-left">Down Payment</td>
				<td class="text-center">:</td>
				<td class="text-center">
                   <?php echo $form_detail['tgl1'] ;?> 
				   </td>
				<td class="text-right">
                   <?= number_format(($form_detail['k1_pay']),0,',','.') ?>
				   </td>
				<th class="text-center"></th>
			</tr>
			<tr>
			 <th class="text-center"></th>
				<td class="text-left">2nd Instalament</td>
				<td class="text-center">:</td>
				<td class="text-center"> <?php echo $form_detail['tgl2'] ;?> 
				   </td>
				<td class="text-right">
                  <?= number_format(($form_detail['k2_pay']),0,',','.') ?> 
				   </td>
				   <th class="text-center"></th>
			</tr>
			<tr>
			 <th class="text-center"></th>
				<td class="text-left">3rd Instalament</td>
				<td class="text-center">:</td>
				<td class="text-center"> <?php echo $form_detail['tgl3'] ;?> 
				   </td>
				<td class="text-right">
                  <?= number_format(($form_detail['k3_pay']),0,',','.') ?>
				   </td>
				   <th class="text-center"></th>
			</tr>
			<tr>
			 <th class="text-center"></th>
				<td class="text-left">Final Payment</td>
				<td class="text-center">:</td>
				<td class="text-center"> <?php echo $form_detail['tgl4'] ;?> 
				   </td>
				<td class="text-right">
                   <?= number_format(($form_detail['k4_pay']),0,',','.') ?> 
				   </td>
				   <th class="text-center"></th>
			</tr>
			<tr>
			 <th ></th>
				<th colspan="3" align="left">Total</th>
				<th class="text-right"><?= number_format(($form_detail['amount']),0,',','.') ?></th>
				<th ></th>
			</tr>
		
		</tbody>
	</table>
			
		
	</div></div><!-- /.form group -->
	
				 <div class="form-group">
                <label class="col-sm-4 control-label">Remarks:</label>
                <div class="input-group">
                   <?php echo $form_detail['remarkspur'] ;?>
                </div>
            </div>
				
        </div><!-- /.box --> 
    </div><!-- /.col (left) -->

						
	<div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas078/load_view')">Back...</button>
		</div>
</div><!-- /.row -->
</div>
</div><!-- /.row -->

<script type="text/javascript">
$(function() {
$('#klikdetail1').on('click',function(){
	if ($('#detail1').show()==true){
	$('#detail1').hide();}
	else {$('#detail1').show();}
	
	 });
	 });
</script>