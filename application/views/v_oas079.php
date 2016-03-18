 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS079
* Program Name     : Form Konfirmasi Purchase Order 
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
<!-- Kolom 1 -->
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
                    <label class="col-sm-4 control-label" >No. Ref PR :</label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<?echo $form_detail['no_ref_pr']?>">
                    </div>
                </div>
				
				<div class="form-group">
                <label class="col-sm-4 control-label" for="currency"><b>Status</b></label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="currency" value="<?= $form_detail['status_name'] ?>"></input>
                </div>
            </div>  
				
			</div> <!-- /.requester-detail -->
			
			<!-- .List Purchase - detail -->
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
		<!-- .Hostory Form - detail -->
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
	</div> 
</div>
</div><!-- /Kolom 1 -->
	
<!-- Kolom 2 -->	
<div class="row">
    <div class="col-md-6">
	<div class="box-body">
	
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
		</div>   
	<!-- .Isian untuk finance - input -->		
	<div class="requester-detail form-section-container">
<h4><b> Filled by Finance Departement</b></h4>
<table class="  no-border-bottom">
	<colgroup>
		<col width="2%">
		<col width="10%">
		<col width="2%">
		<col width="8%">
		<col width="8%">
		<col width="8%">
		<col width="2%">
	</colgroup>
<tbody>
	<tr>
		<th class="text-center"></th>
		<th class="text-left"> 1. Payment Method</th>
		<th class="text-center">:</th>
		<td class="text-left" colspan="3"><?php if ($form_detail['c_type'] == '1'){ echo 'Cash'; }else { echo 'Transfer' ;}?></td>
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
		<td class="text-left" colspan="3"><?php echo $detail_vendor['v_name'] ;?></td>
		<th class="text-center"></th>
	</tr>
	<tr>
		<th class="text-center"></th>
		<td class="text-left"> Quotation No </td>
		<th class="text-center">:</th>
		<td class="text-left" colspan="3"><?php echo $form_detail['q_no'] ;?></td>
		<th class="text-center"></th>
	</tr>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<tr> <th ></th>
			<td class="text-left"><b>Ship To</b></td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_name']; ?></td>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Address</td>
			<th class="text-center">:</th>
			<td colspan="3" class="text-left"><?php echo $detail_shipto['sh_address']; ?></td>
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
		<th class="text-right">Keterangan</th>
		<th class="text-center"></th>
	</tr>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">Down Payment</td>
		<td class="text-center">:</td>
		<td class="text-center"><?php echo date('d F Y',strtotime($form_detail['tgl1'])) ;?></td>
		<td class="text-right"><?= number_format(($form_detail['k1_pay']),0,',','.') ?></td>
		<td class="text-right"><?= $form_detail['r1'] ?></td>
		<th class="text-center"></th>
	</tr>
	<?php if ($form_detail['k2_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">2nd Instalament</td>
		<td class="text-center">:</td>
		<td class="text-center"> <?php echo date('d F Y',strtotime($form_detail['tgl2'])) ;?></td>
		<td class="text-right"><?= number_format(($form_detail['k2_pay']),0,',','.') ?> </td>
		<td class="text-right"><?= $form_detail['r2'] ?></td>
		<th class="text-center"></th>
	</tr><?}?>
	<?php if ($form_detail['k3_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">3rd Instalament</td>
		<td class="text-center">:</td>
		<td class="text-center"> <?php echo date('d F Y',strtotime($form_detail['tgl3'])) ;?></td>
		<td class="text-right"><?= number_format(($form_detail['k3_pay']),0,',','.') ?></td>
		<td class="text-right"><?= $form_detail['r3'] ?></td>
		<th class="text-center"></th>
	</tr><?}?>
	<?php if ($form_detail['k4_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">Final Payment</td>
		<td class="text-center">:</td>
		<td class="text-center"> <?php echo date('d F Y',strtotime($form_detail['tgl4'])) ;?></td>
		<td class="text-right"><?= number_format(($form_detail['k4_pay']),0,',','.') ?></td>
		<td class="text-right"><?= $form_detail['r4'] ?></td>
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
</div>
</div>

<!-- .Isian untuk Approval - detail -->
<div class="approval-detail form-section-container">
<div class="form-group" id="po-btn">
	<div class="form-group">
        <label class="col-sm-4 control-label"></label>
            <div class="input-group">
				<?php if ($form_detail['status_id'] == '0'){ ?>
                <input type="radio" name="approval" value='1'><?php echo'Approved by Purchase'; ;?>
				<td><input type="radio" name="approval" value='2'><?php if ($form_detail['status_id'] == '0' || $form_detail['status_id'] == '1') echo'Reject'; ?></td><?}?>
				<?php if ($form_detail['status_id'] == '1'){ ?>
				<td><input type="radio" name="approval" value='3'> <?php echo'Approved by Vendor'; ?></td><?}?>
			</div>
    </div>
	</div>

	<div class="form-group">
        <label class="col-sm-4 control-label">Remarks:</label>
            <div class="input-group">
				<textarea  id="remarks" rows="3" cols="40"   input="textarea"></textarea>
            </div>
    </div>
</div>
<div class="box-footer clearfix">
    <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas078/load_view')">Back...</button>
    <button type="submit" class="pull-left btn btn-primary" id="approval-submit-btn">Submit</button> 
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">

$('#approval-submit-btn').hide(); 

//variabel confirmasi
var activity = null;
var status			= null;
var c_type			= null;
var b_status		= null;
var tgl1			= null;
var tgl2			= null;
var tgl3			= null;
var tgl4			= null;

//akhir variabel konfirmasi
var akuntan			= "<?php echo $detail_akun['id'];?>";
var akuntan_name	= "<?php echo $detail_akun['name'];?>";
var akuntan_email	= "<?php echo $detail_akun['email'];?>";
var dir				= "<?php echo $detail_dir['id'];?>";
var pur				= "<?php echo $detail_pur['id'];?>";
var aprove			= "<? echo $this_id ;?>";
var requester_id	= "<?= $form_detail['employee_id'] ?>";
var requester_email	= "<?= $form_detail['employee_email'] ?>";
var requester_name	= "<?= $form_detail['employee_name'] ?>";
var amount			= "<?= $form_detail['amount'] ?>";
var refno			= "<?php echo $form_detail['no_ref']; ?>";
var formid			= "<?= $form_detail['po_id'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var pr_id			= "<?= $form_detail['pr_id'] ?>";




var url = null;
if (status_id == '6'){
	url = "<?php echo site_url('c_oas079/submit_approval_vendor'); ?>"
}
else{
	url = "<?php echo site_url('c_oas079/submit_approval'); ?>";
}

//untuk format amountdim nominal amount
function formatAngka(objek, separator) {
	a = objek.value;
	b = a.replace(/[^\d]/g,"");
  c = "";
  panjang = b.length;
  j = 0;

  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (((j % 3) == 1) && (j != 1)) {
      c = b.substr(i-1,1) + separator + c;
    } else {
      c = b.substr(i-1,1) + c;
    }
	}
	objek.value = c;
}

//function membersihkan tanda titik di field amount
function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}


$(function() {
	$('#tgl1').datepick({
		dateFormat: 'dd MM yyyy',
		maxDate: "+2M" ,
		minDate:"+0D",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl1 = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl1);	
		},
	});
	
	$('#tgl2').datepick({
		dateFormat: 'dd MM yyyy',
		maxDate: "+2M" ,
		minDate:"+0D",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl2 = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl2);
		},
	});
	
	$('#tgl3').datepick({
		dateFormat: 'dd MM yyyy',
		maxDate: "+2M" ,
		minDate:"+0D",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl3 = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl3);
		},
	});
	$('#tgl4').datepick({
		dateFormat: 'dd MM yyyy',
		maxDate: "+2M" ,
		minDate:"+0D",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl4 = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl4);
		},
	});
	
	if (status_id==1){
		$('input:radio[name=c_type]').on('click',function(){
            c_type=$(this).val();
			});
		$('input:radio[name=b_status]').on('click',function(){
            b_status=$(this).val();
			});
			 //input ke dalam angka tanpa titik
    }
	
	$('input:radio[name=approval]').on('click',function(){
            status=$(this).val();
	if (status==1){
		if (status_id==0){
		activity='5';
		}
	if (status_id==1){
		activity='1';
		}
	}
	
	if (status==2){
		if (status_id==0){
		activity='2';
		}
	}
	
	if (status==3){
		if (status_id==1){
		activity='13';
		}
	}
	
		$('#approval-submit-btn').show();
    });
	
	
		
	//ketika tombol submit di click
	$('#approval-submit-btn').on('click', function(){
	var dosubmit = true;
	
	if (status_id==1 || status_id==3){
		}
	
	  if(dosubmit){
                    var form_data = {
						status_id		: status_id,
                        form_id         : formid,
                        form_type_id    : '7',
						pr_id			: pr_id,
                        refno			: refno,
						approval        : status, 
                        activity        : activity,
						aprove			: aprove,
                        requesterid     : requester_id,
                       requester_email	: requester_email,
					   requester_name	: requester_name,
						akuntan			: akuntan,
						akuntan_name	: akuntan_name,
						akuntan_email	: akuntan_email,
						dir				: dir,
						pur				: pur,
						remarks			: $('#remarks').val(),
                        ajax            : 1 
                    };
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
        console.log(form_data);
		
                    $.ajax({
                        url: url,
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                         success: function(data) {
						 alert("Confirmation success!");//keterangan sukses submit
                            $("#"+id ).html("<label><code><h5>No Ref :  " + refno + " successfully confirmed </h5></code></label>" + data
                                +"");
                        },
                       error: function(){                   
                        alert("Confirmation Failled!");//keterangan gagal submit
                            $("#"+id ).html("<label><code><h5>No Ref :  " + refno + " failled to confirm </h5> </code></label>" + data
                                +"");
								location.reload();
                        }
                    });
					}
    });
});
</script>