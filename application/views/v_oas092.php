 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS092
* Program Name     : Detail Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 24-02-2015 16:09:00 ICT 2014
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
                <h3 class="box-title">PURCHASE REQUEST DETAIL</h3>
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
				
		
<div class="requester-detail form-section-container">
				
                <div class="form-group">
                    <label class="col-sm-4 control-label">No. Ref</label>
                    <div class="input-group">
						<input type="text" readonly class="form-control" value="<?= $form_detail['no_ref'] ?>">
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

			<div class="form-group">
                <label class="col-sm-4 control-label" for="currency"><b>Status</b></label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="currency" value="<?= $form_detail['status_name'] ?>"></input>
                </div>
            </div>  
			
			</div><!-- /.box-body -->   
					
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
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="7" align="center">LIST PURCHASE</td>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">QTY</th>
				<th class="text-center">Item</th>
				<th class="text-center">Description</th>
				<th class="text-center">Price</th>
				<th class="text-center">Total</th>
				<th class="text-center">Remarks</th>
			</tr>
		</thead>
		
		<tbody>
			<?php $no = 0; $total1 =0;
			
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
					<td align="center"><?= $value['keterangan']?></td>
					
					<? $total1 += $value['total'];?>
									
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
		
		</tbody>
	</table>
					
			</div>
			<br></br>
			<!-- .Supporting Doccument - detail -->
            <div class="requester-detail form-section-container">
            <table class=" table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="15%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="7" align="center">LIST DOCUMENT</td>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Document Name</th>
				<th class="text-center">.::.</th>
			</tr>
		</thead>
		
		<tbody>
			<?php $no = 0; 			
			if(isset($list_doc)){
			foreach ($list_doc as $key => $value) { 
				$no++;?>
				<tr >
					<td align="center"><?= $no ?></td>
					<td align="center"><?= $value['namafile']?></td>
					<td><a href="<?=$value['document'];?>">Download</a></td>
									
				</tr>
				
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="6">NOT FOUND!</td>
			</tr>
			<?php } ?>
		
		</tbody>
	</table>
					
			</div>
		
			<!-- .History Form - detail -->
            <div class="requester-detail form-section-container">
            <table class="  no-border-bottom" hidden id="hidehistory">
			<label hidden id="history"><h4><b> History Form</b></h4></label>
		<colgroup>
			<col width="23%">
			<col width="23%">
			<col width="15%">
			<col width="23%">
		</colgroup>
		<thead>
			
			<tr>
				
				<th class="text-left">User</th>
				<th class="text-left">Name of User</th>
				<th class="text-left">Time</th>
				<th class="text-left">Status</th>
				<th class="text-left">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['employee_name'] ?></td>
				<td class="text-left"><?= $form_detail['submitted_dt']; ?></td>
				<td class="text-left">Requested</td>
				<td class="text-left"><?= $form_detail['remarks'] ?></td>
			</tr><?php if ($form_detail['status_id']!= '0') {?>
			<tr>
				
				<td class="text-left">RM</td>
				<td class="text-left"><?= $form_detail['approverm_by'] ?></td>
				<td class="text-left"><?= $form_detail['approverm_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusform']; ?></td>
				<td class="text-left"><?= $form_detail['remarksrm'] ?></td>
			</tr><?php if ($form_detail['status_id']!= '11' && $form_detail['approvegr_by'] != '') {?>
			<tr>
				
				<td class="text-left">Group Head</td>
				<td class="text-left"><?= $form_detail['approvegr_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvegr_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusgr']; ?></td>
				<td class="text-left"><?= $form_detail['remarksgr'] ?></td>
			</tr><?}?><?php if ($form_detail['status_id']!= '3') {?>
			<tr>
				
				<td class="text-left">Admin Finance</td>
				<td class="text-left"><?= $form_detail['approvefin_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvefin_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusfin']; ?></td>
				<td class="text-left"><?= $form_detail['remarksfin'] ?></td>
			</tr><?php if ($form_detail['approvepur_by']!= '' ){?>
			<tr>
			
				<td class="text-left">Finance Head</td>
				<td class="text-left"><?= $form_detail['approvepur_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvepur_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statuspur']; ?></td>
				<td class="text-left"><?= $form_detail['remarkspur'] ?></td>
			</tr><?php } else {?>
			
			<td class="text-left">Finance Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovef2_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovef2_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statuspur']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarksf2'] ?></td>
			</tr><?}?><?php if ($form_detail['statusrevise'] != '') {?>
			
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['employee_name'] ?></td>
				<td class="text-left"><?= $form_detail['submitted_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusrevise'] ?></td>
				<td class="text-left"><?= $form_detail['remarksfinance'] ?></td>
			</tr><?}?><?php if ($form_detail['statusrevisepur'] != '') {?>
			
			<tr>
				
				<td class="text-left">Finance Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovepur_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovepur_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusrevisepur'] ?></td>
				<td class="text-left"><?= $form_detail['reviseremarkspur'] ?></td>
			</tr><?}?><?php if ($form_detail['approvedir_dy'] != '') {?>
			
			<tr>
				
				<td class="text-left">Director</td>
				<td class="text-left"><?= $form_detail['approvedir_dy'] ?></td>
				<td class="text-left"><?= $form_detail['approvedir_dt']; ?></td>
				<td class="text-left"><?= $form_detail['statusdir']; ?></td>
				<td class="text-left"><?= $form_detail['remarksdir'] ?></td>
			</tr>
			
			<?}}}?>
		</tbody>
	</table>					
			</div>
			
			 <div class="form-group">
                    <label class="col-sm-4 control-label">Create PO ?</label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<?= $form_detail['dibuat_po'] ?>">
                    </div>
             </div>			 
	
			  <div class="form-group">
                    <label class="col-sm-4 control-label">Payment Methode </label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<?php if ($form_detail['b_status'] == '1') echo 'Cash'; else echo 'Transfer' ;?>">
                    </div>
             </div>
			 <div>
			 <?php if ($form_detail['status_id']== '3') {?>
			<button type="button" class="btn-primary" id="remind">Remaind Finance that the document are completed...</button>
			<?}?>
			 </div>
			 <div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<button type="button" class="btn-primary" id="detailbanyak">View Detail...</button>
			<button type="button" class="btn-primary" id="hiddedetail">Hide Detail...</button>
			<a href="<?php echo base_url(); ?>./c_oas092/cetak/<?= $form_detail['pr_id'] ?>">
			<button id = "print-btn" class="btn btn-small btn-info">
						<i class="icon-download-alt icon-on-right bigger-110"></i>
							<i class="fa fa-download"></i>
							.pdf
						</button>
			</a>
		</div>
				
			 
			</div> <!-- /.box-body -->
		</div><!-- /.box box-danger -->
      
    </div><!-- /.col (left) -->
	
<div class="row">
    <div class="col-md-6">

            <div class="box-body">
			
	
	
	
<div class="requester-detail form-section-container" hidden id="sembunyiinfinance">
		
		<table class="  no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
			<col width="2%">
			<col width="15%">
			<col width="15%">
			<col width="2%">
		</colgroup>
		
		
		<tbody>
		<?php if ($form_detail['buat_po'] == '1') {?>
		<tr><h4><b> Filled by Finance Departement</b></h4>
		</tr>
			<tr>
				<th></th>
				<th class="text-left" colspan="3"> 1. Ship To </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['vendor'] ;?></td>
				<th class="text-center"></th>
		</tr>
		
		<tr> <th ></th>
			<td class="text-left" colspan="3"> - Attn</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendorattn'] ;?></td>
				<th class="text-center"></th>
		<th></th>
		</tr>	
			
			<tr> <th ></th>
			<td class="text-left" colspan="3"> - Address</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendoradd'] ;?></td>
				<th class="text-center"></th>
		<th></th>
		</tr>	

			<tr> <th ></th>
			<td class="text-left" colspan="3"> - City</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendorcity'] ;?></td>
				<th class="text-center"></th>
		<th></th>
		</tr>
		
			<tr> <th ></th>
			<td class="text-left" colspan="3"> - Phone</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendorphone'] ;?></td>
				<th class="text-center"></th>
		</tr>
			
			<tr> <th ></th>
			<td class="text-left" colspan="3"> - Zip</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendorzip'] ;?></td>
				<th class="text-center"></th>
			<th></th>
		</tr>
			
			<tr> <th ></th>
			<td class="text-left" colspan="3"> - Fax</td>
			<th class="text-center">:</th>
			<td class="text-left" colspan="3"><?php echo $form_detail['vendorfax'] ;?></td>
				<th class="text-center"></th>
		</tr>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<tr>
				<th class="text-center"></th>
				<th class="text-left" colspan="3"> 2. Quotation No </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['q_no'] ;?></td>
				<th class="text-center"></th>
		</tr>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
			<tr> <th ></th>
				<th class="text-left" colspan="3"> 3. Vendor </th>
				<th class="text-center" >:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['companyst'] ;?></td>
				<th class="text-center"></th>
			</tr>
			<tr> <th ></th>
				<th class="text-left" colspan="3"> - Contact Person </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['cpst'] ;?></td>
				<th class="text-center"></th>
			</tr>
			<tr>
				<th class="text-center"></th>
				<th class="text-left" colspan="3"> - Address </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['alamatst'] ;?></td>
				<th class="text-center"></th>
			</tr>
			<tr>
				<th class="text-center"></th>
				<th class="text-left" colspan="3"> - Phone </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['telpst'] ;?></td>
				<th class="text-center"></th>
			</tr>
			<tr>
				<th class="text-center"></th>
				<th class="text-left" colspan="3"> - Email </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['emailst'] ;?></td>
				<th class="text-center"></th>
			</tr>
			<tr>
			
				<th class="text-center"></th>
				<th class="text-left" colspan="3"> - NPWP </th>
				<th class="text-center">:</th>
				<td class="text-left" colspan="3"><?php echo $form_detail['npwpst'] ;?></td>
				<th class="text-center"></th>
			</tr>
				<?}?>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		
		<tr>
				<th class="text-center"></th>
				<th class="text-left" > Term of Payment </th>
				<th class="text-center"></th>
				<th class="text-center">Date</th>
				<th class="text-right">Amount</th>
				<th class="text-center"></th>
				<th class="text-center">Remarks</th>
			</tr>
			</tr>
				<tr>
				 <th class="text-center"></th>
				<td class="text-left" >Down Payment</td>
				<td class="text-center">:</td>
				<td class="text-center">
                   <?php echo $form_detail['tgl1'] ;?> 
				   </td>
				<td class="text-right">
                   <?= number_format(($form_detail['k1_pay']),0,',','.') ?>
				   </td>
				<th class="text-center"></th>
				   <td class="text-center">
                   <?php echo $form_detail['rp1'] ;?> 
				   </td>
				   <th class="text-center"></th>
			</tr>
			<?php if ($form_detail['k2_pay'] != '0') {?>
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
				   <td class="text-center">
                   <?php echo $form_detail['rp2'] ;?> 
				   </td>
				   <th class="text-center"></th>
			</tr><?}?>
			<?php if ($form_detail['k3_pay'] != '0') {?>
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
				   <td class="text-center">
                   <?php echo $form_detail['rp3'] ;?> 
				   </td>
				   <th class="text-center"></th>
			</tr><?}?>
			<?php if ($form_detail['k4_pay'] != '0') {?>
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
				   <td class="text-center">
                   <?php echo $form_detail['rp4'] ;?> 
				   </td>
				   <th class="text-center"></th>
			</tr><?}?>
			<tr>
			 <th ></th>
				<th colspan="3" align="left">Total</th>
				<th class="text-right"><?= number_format(($form_detail['amount']),0,',','.') ?></th>
				<th ></th>
			</tr>
		
		</tbody>
	</table>
			
	</div></div><!-- /.form group -->

				
        </div><!-- /.box --> 
    </div><!-- /.col (left) -->
	<div>
		
		</div>
	
	<div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas072/load_view')">Back...</button>
		</div>
</div><!-- /.row -->
</div>
</div><!-- /.row -->


<script src="<?php echo js_url();?>plugins/daterangepicker/daterangepickernew.js" type="text/javascript"></script>
<!-- Page script -->
<script type="text/javascript">

	$('#hiddedetail').attr('disabled', true);

//akhir variabel konfirmasi

var akuntan			= "<?php echo $detail_akun['id'];?>";
var dir				= "<?php echo $detail_dir['id'];?>";
var pur				= "<?php echo $detail_pur['id'];?>";
var aprove			= "<?php echo $this_id ;?>";
var requester_id	= "<?= $form_detail['employee_id'] ?>";
var rm				= "<?= $form_detail['approval'] ?>";
var amount			= "<?= $form_detail['amount'] ?>";
var refno			= "<?php echo $form_detail['no_ref']; ?>";
var formid			= "<?= $form_detail['pr_id'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var divid			= "<?= $detail_division ?>";
// view detail button
	$('#detailbanyak').on('click', function(){
	$('#sembunyiinfinance').show();
	$('#hidehistory').show();
	$('#history').show();
	$('#detailbanyak').attr('disabled', true);	
	$('#hiddedetail').attr('disabled', false);
    });
	
// view detail button
	$('#hiddedetail').on('click', function(){
	$('#sembunyiinfinance').hide();
	$('#hidehistory').hide();
	$('#history').hide();
	$('#detailbanyak').attr('disabled', false);
	$('#hiddedetail').attr('disabled', true);
    });
	
$('#remind').on('click', function(){
	var dosubmit = true;
		  if(dosubmit){
                    var form_data = {
						status_id		: status_id,
                        form_id         : formid,
                        form_type_id    : '4',
						rm				: rm,
                        refno			: refno,
						aprove			: aprove,
                        requesterid     : requester_id,
						akuntan			: akuntan,
						dir				: dir,
						pur				: pur,
                        ajax            : 1 
                    };
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
        console.log(form_data);

                    $.ajax({
                        url: "<?php echo site_url('c_oas092/submit_approval'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                         success: function(data) {
						 alert("notification send to finance!");//keterangan sukses submit
                            $("#"+id ).html("<label><code><h5>No Ref :  " + refno + " notification send to finance </h5></code></label>" + data
                                +"");
                        },
                       error: function(){                   
                        alert("failled to send notification!");//keterangan gagal submit
                            $("#"+id ).html("<label><code><h5>No Ref :  " + refno + " failled to send notification </h5> </code></label>" + data
                                +"");
                        }
                    });
					}
    });

</script>