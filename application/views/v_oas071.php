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

?>

<script type="text/javascript" src="assets/js/jquery-ui-1.10.3.min"></script>
<script type="text/javascript" src="assets/js/jquery.form.min.js"></script>

<script type="text/javascript">
var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false;
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false;
        }
		
		//Allowed file size is less than 5 MB (1048576)
		if(fsize>5242880) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
			return false;
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>
<!-- Kolom 1 -->
<div class="row">
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">PURCHASE REQUEST DETAIL</h3>
            </div>
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
			
		</div> 
			
			<!-- .List Purchase - detail -->
            <div class="requester-detail form-section-container">
			<div class="form-group">
                <label class="col-sm-4 control-label" for="createpo">Create PO</label>
					<div class="input-group">
						<input type="text" readonly class="form-control holo" id="createpo" value="<?php if ($form_detail['status_po']== '1') { echo 'YES'; } else{echo 'NO';}?>"></input>
					</div>
            </div>
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
				<td align="right"  colspan="1" ><b><input hidden readonly id="totalsemuaitem" value="<?php echo number_format($total1,0,',','.'); ?>"></b><?php echo number_format($total1,0,',','.'); ?></td>
			</tr>
		
		</tbody>
	</table>
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
	</table></div>
	</div>
<!-- .Isian untuk Approval - detail -->
<div class="approval-detail form-section-container">
		
	<div class="form-group" id="pr-btn">
        <label class="col-sm-4 control-label"><?php if ($form_detail['status_id'] == '0' || $form_detail['status_id'] == '11' || $form_detail['status_id'] == '2') echo'Approval :'; elseif ($form_detail['status_id'] == '1' || $form_detail['status_id'] == '17') echo 'Acceptance :'; else echo 'Documents complete?'; ?> </label>
            <div class="input-group">
                <input type="radio" name="approval" value='1'><?php if ($form_detail['status_id'] == '0' || $form_detail['status_id'] == '11' || $form_detail['status_id'] == '2') echo'Approved'; elseif ($form_detail['status_id'] == '1' || $form_detail['status_id'] == '17') echo 'Accepted';  else echo 'Yes';?>
				<td><input type="radio" name="approval" value='2'> <?php if ($form_detail['status_id'] == '0' || $form_detail['status_id'] == '11' || $form_detail['status_id'] == '2') echo'Reject'; elseif ($form_detail['status_id'] == '1' || $form_detail['status_id'] == '17') echo 'Not Accepted'; else echo 'Not yet';?></td>
				<?php if ($form_detail['status_id'] == '1'){ ?>
				<td><input type="radio" name="approval" value='3'> <?php echo'Revise'; ?></td><?}?>
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
    <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas072/load_view')">Back...</button>
    <button type="submit" class="pull-left btn btn-primary" id="approval-submit-btn">Submit</button> 
</div>
	</div> 
</div>
</div><!-- /Kolom 1 -->
	
<!-- Kolom 2 -->	
<div class="row">
    <div class="col-md-6">
<!-- untuk pr yang dibikin po -->		

<div class="box box-danger">
            
            <div class="box-body">
			
<!-- .Isian untuk status (approval)0,(Group)1,(director)3 - detail -->
<?php if ($form_detail['status_id'] == '0' || $form_detail['status_id'] == '11' || $form_detail['status_id'] == '2'||  $form_detail['status_id'] == '3') {?>
<div class="requester-detail form-section-container">
<a><label id="klikdetail2" title="klik to detail"><h4><b> Filled by Finance Departement</b></h4></label></a>
	<table hidden id="detail2" class=" no-border-bottom">
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
		<th class="text-left"> 1. Cost Type</th>
		<th class="text-center">:</th>
		<td class="text-left" colspan="3"><?php if ($form_detail['c_type'] == '1'){ echo 'Billed'; }else { echo 'Unbilled' ;}?></td>
		<th class="text-center"></th>
	</tr>
	<tr>
		<th class="text-center"></th>
		<th class="text-left"> 2. Payment Method </th>
		<th class="text-center">:</th>
		<td class="text-left" colspan="3"><?php if ($form_detail['b_status'] == '1') echo 'Cash'; else echo 'Transfer' ;?></td>
		<th class="text-center"></th>
	</tr>
	<?php if ($form_detail['status_po']== '1') {?>
	<tr>
		<th class="text-center"></th>
		<th class="text-left"> Ship To</th>
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
			<td class="text-left"><b>Vendor</b></td>
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
		</tr><?}?><!-- ./pr po -->
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
		<td class="text-center"><?php if ($form_detail['y1'] != '0') echo date('d F Y',strtotime($form_detail['tgl1'])); else echo '*belum ditentukan'; ?></td>
		<td class="text-right"><?= number_format(($form_detail['k1_pay']),0,',','.') ?></td>
		<td class="text-right"><?= $form_detail['r1'] ?></td>
		<th class="text-center"></th>
	</tr>
	<?php if ($form_detail['k2_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">2nd Instalament</td>
		<td class="text-center">:</td>
		<td class="text-center"><?php if ($form_detail['y2'] != '0') echo date('d F Y',strtotime($form_detail['tgl2'])); else echo '-'; ?></td>
		<td class="text-right"><?= number_format(($form_detail['k2_pay']),0,',','.') ?> </td>
		<td class="text-right"><?= $form_detail['r2'] ?></td>
		<th class="text-center"></th>
	</tr><?}?>
	<?php if ($form_detail['k3_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">3rd Instalament</td>
		<td class="text-center">:</td>
		<td class="text-center"> <?php if ($form_detail['y3'] != '0') echo date('d F Y',strtotime($form_detail['tgl3'])); else echo '-'; ?></td>
		<td class="text-right"><?= number_format(($form_detail['k3_pay']),0,',','.') ?></td>
		<td class="text-right"><?= $form_detail['r3'] ?></td>
		<th class="text-center"></th>
	</tr><?}?>
	<?php if ($form_detail['k4_pay'] != '0') {?>
	<tr>
		<th class="text-center"></th>
		<td class="text-left">Final Payment</td>
		<td class="text-center">:</td>
		<td class="text-center"><?php if ($form_detail['y4'] != '0') echo date('d F Y',strtotime($form_detail['tgl4'])); else echo '-'; ?></td>
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

<?}?><!-- ./Isian untuk status 0,1,3 - detail -->

	<!-- .Isian untuk Purchase status 2 - input -->		
	<?php if ($form_detail['status_id']== '1' || $form_detail['status_id']== '17') {?>
	<div class="requester-detail form-section-container input-section">
	<h4><b> Filled by Finance Departement</b></h4>
	<table class=" no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
			<col width="2%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="2%">
		</colgroup>
	<tbody>
		<tr> <th ></th>
			<td class="text-left"><b>1. Cost Type </b></td>
			<th class="text-center">:</th>
			<td  class="text-left" ><input readonly type="radio" name="c_type" value='1' <?php if($form_detail['c_type'] == '1') echo 'checked' ?> > BILLED  </td>
			<td  class="text-left"> <input type="radio" name="c_type" value='2' <?php if($form_detail['c_type'] == '2') echo 'checked' ?> > UNBILLED</td>
			<td colspan="2"></td>
		</tr>
		<tr> <th ></th>
			<td class="text-left"><b>2. Payment Method </b></td>
			<th class="text-center">:</th>
			<td  class="text-left"><input type="radio" name="b_status" value='1' <?php if($form_detail['b_status'] == '1') echo 'checked' ?>> Cash</td>
			<td  class="text-left"> <input type="radio" name="b_status" value='2' <?php if($form_detail['b_status'] == '2') echo 'checked' ?>> Transfer</td>
			<td colspan="2"></td>
		</tr>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<?php if ($form_detail['status_po']== '1') {?>
		<tr> <th ></th>
			<td class="text-left"><b>3. Ship To</b></td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_name" class="form-control holo"  value="<?php echo $detail_vendor['v_name']; ?>" ></th>
			<th></th>
		</tr>
			
		<tr> <th ></th>
			<td class="text-left">- Attention</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_attn" class="form-control holo"  value="<?php echo $detail_vendor['v_attn']; ?>" ></th>
		<th></th>
		</tr>	
			
			<tr> <th ></th>
			<td class="text-left">- Address</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_add" class="form-control holo"  value="<?php echo $detail_vendor['v_address']; ?>" ></th>
		<th></th>
		</tr>	

			<tr> <th ></th>
			<td class="text-left">- City</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_city" class="form-control holo"  value="<?php echo $detail_vendor['v_city']; ?>" ></th>
		<th></th>
		</tr>
		
			<tr> <th ></th>
			<td class="text-left">- Phone</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_phone" class="form-control holo"  value="<?php echo $detail_vendor['v_phone']; ?>" ></th>
			<th></th>
		</tr>
			
			<tr> <th ></th>
			<td class="text-left">- Zip</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_zip" class="form-control holo"  value="<?php echo $detail_vendor['v_zip']; ?>" ></th>
			<th></th>
		</tr>
			
			<tr> <th ></th>
			<td class="text-left">- Fax</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="s_fax" class="form-control holo"  value="<?php echo $detail_vendor['v_fax']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Quotation No </td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="quot_no" class="form-control holo"value="<?php echo $form_detail['q_no']; ?>" ></th>
			<th ></th>
		</tr>
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<tr> <th ></th>
			<td class="text-left"><b>4. Vendor</b></td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_comp" class="form-control holo"  value="<?php echo $detail_shipto['sh_name']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Address</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_add" class="form-control holo"  value="<?php echo $detail_shipto['sh_address']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - CP</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_cp" class="form-control holo"  value="<?php echo $detail_shipto['sh_cp']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Phone</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_phone" class="form-control holo"  value="<?php echo $detail_shipto['sh_telp']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - Email</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_email" class="form-control holo"  value="<?php echo $detail_shipto['sh_email']; ?>" ></th>
			<th ></th>
		</tr>
		<tr> <th ></th>
			<td class="text-left"> - NPWP</td>
			<th class="text-center">:</th>
			<th colspan="3" class="text-left"><input type="text"  id="v_npwp" class="form-control holo"  value="<?php echo $detail_shipto['sh_npwp']; ?>" ></th>
			<th ></th>
		</tr><?}?><!-- ./pr po -->
		<tr><td width='1'>
				&nbsp;
			</td>
		</tr>
		<tr> <th ></th>
			<td class="text-left"><b>5. Term of Payment </b></td>
			<th class="text-center"></th>
			<th class="text-center">Date</th>
			<th class="text-right">Amount</th>
			<th class="text-right">Keterangan</th>
			<th ></th>
		</tr>
		<tr id="pembayaran1"><th ></th>
			<td class="text-left"><b>Down Payment</b></td>
			<td class="text-center">:</td>
			<td class="text-center"><input type="text" id="tgl1" class="form-control holo" value="<?php if ($form_detail['y1'] != '0') echo date('d F Y',strtotime($form_detail['tgl1'])); else echo ''; ?>" ></input></td>
			<td class="text-right"><input  type="text" id="jmlp1" class="form-control holo" onkeyup="formatAngka(this, '.')" value="<?php if($form_detail['k1_pay']==0) echo ''; else  echo number_format(($form_detail['k1_pay']),0,',','.') ;?>"  ></input></td>
			<th class="text-right"><input  type="text" id="r1" class="form-control holo" value="<?php echo $form_detail['r1'];?>"></input></th>
			<td ></th>
		</tr>
		<tr id="pembayaran2"><th ></th>
			<td class="text-left"><b>2nd Instalament</b></td>
			<th class="text-center">:</th>
			<th class="text-center"><input type="text" id="tgl2" class="form-control holo" value="<?php if ($form_detail['y2'] != '0') echo date('d F Y',strtotime($form_detail['tgl2'])); else echo ''; ?>" ></input></th>
			<th class="text-right"><input type="text" id="jmlp2" class="form-control holo" onkeyup="formatAngka(this, '.')"  value="<?php if($form_detail['k2_pay']==0) echo ''; else  echo number_format(($form_detail['k2_pay']),0,',','.') ;?>"  ></input></th>
			<th class="text-right"><input  type="text" id="r2" class="form-control holo" value="<?php echo $form_detail['r2'];?>"></input></th>
			<th ></th>
		</tr>
			<tr id="pembayaran3">
			<th ></th>
			<td class="text-left"><b>3rd Instalament</b></td>
			<th class="text-center">:</th>
			<th align="center"><input type="text" id="tgl3" class="form-control holo" value="<?php if ($form_detail['y3'] != '0') echo date('d F Y',strtotime($form_detail['tgl3'])); else echo ''; ?>"></input></th>
			<th class="text-right"><input type="text" id="jmlp3" class="form-control holo" onkeyup="formatAngka(this, '.')"  value="<?php if($form_detail['k3_pay']==0) echo ''; else  echo number_format(($form_detail['k3_pay']),0,',','.') ;?>"></input></th>
			<th class="text-right"><input  type="text" id="r3" class="form-control holo" value="<?php echo $form_detail['r3'];?>"></input></th>
			<th ></th>
		</tr>
		<tr id="pembayaran4"><th ></th>
			<td class="text-left"><b>Final Payment</b></td>
			<th class="text-center">:</th>
			<th class="text-center"><input type="text" id="tgl4" class="form-control holo" value="<?php if ($form_detail['y4'] != '0') echo date('d F Y',strtotime($form_detail['tgl4'])); else echo ''; ?>"></input></th>
			<th class="text-right"><input  type="text" id="jmlp4" class="form-control holo" onkeyup="formatAngka(this, '.')"  value="<?php if($form_detail['k4_pay']==0) echo ''; else  echo number_format(($form_detail['k4_pay']),0,',','.') ;?>"></input></th>
			<th class="text-right"><input  type="text" id="r4" class="form-control holo" value="<?php echo $form_detail['r4'];?>"></input></th>
			<th ></th>
		</tr>
		<tr><th ></th>
			<td colspan="3" align="left"><b>Total</b></td>
			<td align="left"><input type="text" class="form-control holo" value="<?= number_format(($form_detail['amount']),0,',','.') ?>" onkeyup="formatAngka(this, '.')" id="total" ></input>
			<center>
					<span id="samainhasil"  style="color:red;text-align:center"><br />
					</span></center>
			</td>
			<th ></th>
		</tr>
	</tbody>
</table>
</div>
<?}?><!-- ./Isian untuk finance - Input -->
		<!-- .Hostory Form - detail -->
     <div class="requester-detail form-section-container">
	 	<a><label id="klikdetail1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="detail1">
		<colgroup>
			<col width="23%">
			<col width="23%">
			<col width="20%">
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

	<!-- Tabel upload !-->
	<?php if ($form_detail['status_id']== '14') {?>
	<div class="form-group">
                <label for="b_status" class="col-sm-3 control-label">Supporting Document*  </label>
                <div class="input-group">
                    <div>
				<form action='c_oas071/do_upload' method="post" enctype="multipart/form-data" id="MyUploadForm">
<input name="FileInput" id="FileInput" type="file" />

<input type="hidden"  name="prid" value="<?=$idPR?>" />
<input type="submit"  id="submit-btn" value="Upload" />
<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>

</form>
<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
<div id="output"></div>
				</div>
                </div>
				
            </div>
			   <table class=" table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="15%">
		</colgroup>
		
		
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
	</table><?}?>
	
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">

 
$('#showhistory').hide();
$('#pembayaran2').hide();
$('#pembayaran3').hide();
$('#pembayaran4').hide();


//function detailhistory(){
//$('#showhistory').show();
//}
//variabel confirmasi
var activity = null;
var status_name = null;
var status			= null;
var c_type			= null;
var b_status		= null;
var tgl1			= null;
var tgl2			= null;
var tgl3			= null;
var tgl4			= null;
var approvalgr 		= null;
var approvalgr_email= null;
var approvalgr_name	= null;
var jmlp1 = 0;
var jmlp2 = 0;
var jmlp3 = 0;
var jmlp4 = 0;

//akhir variabel konfirmasi

var akuntan			= "<?php echo $detail_akun['id'];?>";
var akuntan_name	= "<?php echo $detail_akun['name'];?>";
var akuntan_email	= "<?php echo $detail_akun['email'];?>";
var dir				= "<?php echo $detail_dir['id'];?>";
var dir_name		= "<?php echo $detail_dir['name'];?>";
var dir_email		= "<?php echo $detail_dir['email'];?>";
var pur				= "<?php echo $detail_pur['id'];?>";
var pur_name		= "<?php echo $detail_pur['name'];?>";
var pur_email		= "<?php echo $detail_pur['email'];?>";
var aprove			= "<?php echo $this_id ;?>";
var requester_id	= "<?= $form_detail['employee_id'] ?>";
var requester_name	= "<?= $form_detail['employee_name'] ?>";
var requester_email	= "<?= $form_detail['employee_email'] ?>";
var rm				= "<?= $form_detail['approval'] ?>";
var amount			= "<?= $form_detail['amount'] ?>";
var refno			= "<?php echo $form_detail['no_ref']; ?>";
var formid			= "<?= $form_detail['pr_id'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var typecc			= "<?= $form_detail['typecc'] ?>";
var divid			= "<?= $detail_division ?>";
var limit			= "<?= $form_detail['limit_dir'] ?>";
var status_po 		= "<?php echo $form_detail['status_po'];?>";

if (status_id == 1){
tgl1 = "<?= $form_detail['tgl1'] ?>";
tgl2 = "<?= $form_detail['tgl2'] ?>";
tgl3 = "<?= $form_detail['tgl3'] ?>";
tgl4 = "<?= $form_detail['tgl4'] ?>";
limit			= "<?= $form_detail['limit_dir'] ?>";
typecc			= "<?= $form_detail['typecc'] ?>";
}


btnpr();
function btnpr(){
if (status_id == '14'){
$('#pr-btn').hide();

$('#approval-submit-btn').show();
}
else{
$('#pr-btn').show();
$('#approval-submit-btn').hide();

}
}
var url = null;
if (status_id == '14' || status_id == '17'){
	url = "<?php echo site_url('c_oas071/revise_pr'); ?>"
}
else{
	url = "<?php echo site_url('c_oas071/submit_approval'); ?>";
}

function samakanaku(){
var totalpayment = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('totalsemuaitem').value)))));

hasil = (totalpayment -  (document.getElementById('total').value));
if ((document.getElementById('total').value) > totalpayment){
					document.getElementById('samainhasil').innerHTML = "sorry nominal you enter is not valid, please try again";
					$('#samainhasil').show();
					$('#approval-submit-btn').hide();	
				}
				else{document.getElementById('samainhasil').innerHTML = "r";
				$('#samainhasil').hide();
				}
}

function hitung(){
	totalall  =jmlp1+jmlp2+jmlp3;
	document.getElementById('total').value= totalall;
	samakanaku();	
}

//penjumlahan payment of term
$( "#jmlp1" ).keyup(function() {
	jmlp1 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp1').value)))));		
	hitung();
});


$( "#jmlp2" ).keyup(function() {
	jmlp2 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp2').value)))));
	hitung();

});

$( "#jmlp3" ).keyup(function() {
	jmlp3 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp3').value))))); 
	hitung();
});
$( "#jmlp4" ).keyup(function() {
	jmlp4 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp4').value)))));
	hitung();
});

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

//function untuk approval group cc
function get_approval(){
		var cctype = "<?php echo $form_detail['cctype'];?>";
		if (cctype == '1'){
		approvalgr = '<?= $approval_internal['id'] ?>';
		approvalgr_email = "<?= $approval_internal['email']?>";
		approvalgr_name = "<?= $approval_internal['name']?>";}
		
		if (cctype == '2' || cctype == '3'){
		approvalgr_name = "<?= $approval_pro_tra['name'] ?>";
		approvalgr_email = "<?= $approval_pro_tra['email'] ?>";
		approvalgr = '<?= $approval_pro_tra['id'] ?>';}
		
		if (cctype == '4'){
		approvalgr_email = "<?= $approval_license['email'] ?>";
		approvalgr_name = "<?= $approval_license['name'] ?>";
		approvalgr = '<?= $approval_license['id'] ?>';}	
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
	
	if (status_id==1 || status_id==17){
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
		get_approval();
		activity='5';
		status_name ="Approved";
		}
	if ( status_id==11 || status_id==2  || status_id==3){
		activity='1';
		status_name ="Accepted";
		}
	if (status_id ==1 || status_id==17){
		activity ='1';
		samakanaku();
	}
	if (status_id==14){
		activity ='4';
	}
	
	
		
	}
	if ( status==2){
		if (status_id==3){
		activity='13';
		status_name ="Documents completed";
		} 
		else {
		activity='2';
		status_name ="Rejected";}
	}
	
	if ( status==3){
		if (status_id==1 || status_id==17 ){
		activity='3';
		status_name ="Ask to Revise";}
	}
	
		$('#approval-submit-btn').show();
    });
	
	$('#klikdetail2').on('click',function(){
	if ($('#detail2').show()==true){
	$('#detail2').hide();}
	else {$('#detail2').show();}
	
	 });
	
	$('#klikdetail1').on('click',function(){
	if ($('#detail1').show()==true){
	$('#detail1').hide();}
	else {$('#detail1').show();}
	
	 });
	
		
	//ketika tombol submit di click
	$('#approval-submit-btn').on('click', function(){
	var dosubmit = true;
	if (status_id==1 || status_id==17){
	var jmlp1 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp1').value))))); 
	var jmlp2 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp2').value))))); 
	var jmlp3 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp3').value))))); 
	var jmlp4 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp4').value)))));
	}
	
	
	  if(dosubmit){
                    var form_data = {
						status_id		: status_id,
						status_po		: status_po,
                        form_id         : formid,
                        form_type_id    : '4',
						rm				: rm,
                        refno			: refno,
						approval        : status, 
                        activity        : activity,
						
						approvalgr		: approvalgr,
						approvalgr_name : approvalgr_name,
						approvalgr_email: approvalgr_email,
						
						aprove			: aprove,
						
                        requesterid     : requester_id,
                        requesterid_name: requester_name,
                       requesterid_email: requester_email,
					   
                        amount        	: amount,
						c_type			: c_type,
						b_status		: b_status,
                        remarks         : $('#remarks').val(),
						
						s_name         	: $('#s_name').val(),
						s_attn         	: $('#s_attn').val(),
						s_add         	: $('#s_add').val(),
						s_city        	: $('#s_city').val(),
						s_phone        	: $('#s_phone').val(),
						s_zip        	: $('#s_zip').val(),
						s_fax        	: $('#s_fax').val(),
						
						v_comp         	: $('#v_comp').val(),
						v_add         	: $('#v_add').val(),
						v_cp         	: $('#v_cp').val(),
						v_phone        	: $('#v_phone').val(),
						v_email        	: $('#v_email').val(),
						v_npwp        	: $('#v_npwp').val(),
						
						quot_no         : $('#quot_no').val(),
						tgl_1         	: tgl1,
						jml_1         	: jmlp1,
						limit			: limit,
						typecc			: typecc,
						divid			: divid,
						r1         		: $('#r1').val(),
						tgl_2         	: tgl2,
						jml_2         	: jmlp2,
						r2         		: $('#r2').val(),
						tgl_3         	: tgl3,
						jml_3         	: jmlp3,
						r3         		: $('#r3').val(),
						tgl_4         	: tgl4,
						jml_4         	: jmlp4,
						r4         		: $('#r4').val(),
						
						akuntan			: akuntan,
						akuntan_email	: akuntan_email,
						akuntan_name	: akuntan_name,
						
						dir				: dir,
						dir_email		: dir_email,
						dir_name		: dir_name,
						
						pur				: pur,
						pur_email		: pur_email,
						pur_name		: pur_name,
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
                        }
                    });
					}
    });
});
</script>