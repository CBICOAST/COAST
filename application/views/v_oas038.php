<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS038
* Program Name     : Cash Advance General GA Form
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 13-11-2014 11:54:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/



$edit = false;
$readonly = false;
if(isset($status_edit))
{
    $edit = true;
}
if(isset($status_read_only))
{
    $readonly = true;
}
?>

<div class="row"> 
    <div class="col-md-11">

        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">Cash Advance Request Form</h3>
            </div>
            <div class="box-body">
				<?php if ($status_open != 1){?>
                <div class="requester-detail form-section-container"><!-- .requester-input -->

                    <div class="form-group" >
                        <label class="col-sm-3 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php if ($edit){ echo $form_detail['employee_name'];}else{ echo $this_name;}?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" value="<?php if ($edit){ echo $form_detail['employee_email'];}else{ echo $this_email;}?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterGroup">Group/Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php if ($edit){ echo $form_detail['employee_group'].' / '.$form_detail['employee_division'];}else{ echo $this_group.' / '.$this_division ;}?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterGroup">Level</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php if ($edit){ echo $form_detail['level_name'];}else{ echo $detail_level['name'];}?>">
                        </div>
                    </div>
                </div> <!-- /.requester-detail -->
			
		
		<div class="requester-input form-section-container input-section new-ca-form"><!-- .CA-input -->
			<!-- /.Membuat field 'Cash Advance Type' -->
		<div class="form-group" >
                <label for="catype" class="col-sm-3 control-label">Cash Advance Type</label>
                <div class="input-group">
                   <select id="catype" <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?> >
                        <option style="display: none;" value="">--choose one--</option>
                        <?php foreach ($list_catype as $key => $catype) { ?>
                        <option value="<?= $catype['id'] ?>"
						<?php if($edit && $form_detail['type_id'] == $catype['id']) echo 'selected' ?>><?= $catype['name'] ?></option>
						<?php } ?>
                    </select> 
                </div>
			</div>
			<!-- /.Membuat field 'Charge Code Type' -->
			<div class="form-group" >
                <label for="cctype" class="col-sm-3 control-label">Charge Code Type</label>
                <div class="input-group">
                    <div id="disable-cctype" class="<?php if($edit && $form_detail['type_id']!='1') echo 'hide';?>">-</div>
					<select id="input-cctype"  <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?> class="<?php if($edit && $form_detail['type_id']=='1') echo 'hide'; elseif(!$edit) echo 'hide';?>">
						<?php foreach ($list_cctype as $key => $cctype) { ?>
                        <option value="<?= $cctype['id'] ?>"
						<?php if($edit && $form_detail['type_id']!='1' && $cctypeid==$cctype['id']) echo 'selected'?>><?= $cctype['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
			<!-- /.Membuat field 'Charge Code Deskripsi' -->
			<div class="form-group" >
                <label for="chargecode" class="col-sm-3 control-label">Project Description</label>
                <div class="input-group">
                    <div id="disable-cc" class="<?php if($edit && $form_detail['type_id']!='1') echo 'hide';?>">-</div>
                    <div class="wait hide"><img style="max-height: 16px; max-width: 16px;" src="<?php echo img_url(); ?>loader.gif">List Project. . .</div>
                    <div id="disable-chargecode" class="hide">-</div>
                    <select id="chargecode" <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?>  onchange="ccode()" class="<?php if($edit && $form_detail['type_id']=='1') echo 'hide'; elseif(!$edit) echo 'hide';?>">
                        <?php if($edit){
                        foreach ($list_chargecode as $key => $cc) { ?>
                        <option value="<?= $cc['id'] ?>"
						<?php if($edit && $form_detail['type_id']!='1' && $chargecodeid == $cc['id']) echo 'selected'?>><?= $cc['name'] ?></option>
                        <?php }
                        } ?>
                    </select> 
                </div>
            </div>
			<!-- /.Membuat field 'Charge Code' (otomatis) -->
			<div class="form-group" >
                <label class="col-sm-3 control-label">Charge Code</label>
				<div class="input-group">
                    <input  type="text" class="form-control holo" readonly id="chargecodeid"  <?php if ($edit){?> value="<?echo $form_detail['chargecode'];?>"<?}?> >
                </div>
            </div>
			<!-- /.Membuat field 'Currency'(combobox) -->
			<div class="form-group" >
				<label class="col-sm-3 control-label" for="total">Currency</label>
                <div class="input-group">
					<select  id="currency" <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?> >
						<option  value="1" <?php if(!$edit) echo 'selected' ?>
							<?php if($edit && $form_detail['currency'] == '1') echo 'selected' ?>>IDR
						</option>
						<option  value="2" 
							<?php if($edit && $form_detail['currency'] == '2') echo 'selected' ?>>USD
						</option>
<option  value="3" 
							<?php if($edit && $form_detail['currency'] == '3') echo 'selected' ?>>SGD
						</option>

					</select> 
                </div>
            </div>
			<!-- /.Membuat field 'Amount'(input angka) -->		
			<div class="form-group" >
                <label class="col-sm-3 control-label" for="total">Amount</label>
                <div class="input-group">
				
                    <input type="text" <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?>  class="form-control holo" name="angka" style="text-align: left;" onkeyup="formatAngka(this, '.')" id="total" <?php if ($edit){ ?> value="<?= number_format(($form_detail['amount']),0,',','.');?>"<?}?>>
                </div>
            </div>
			<!-- /.Membuat field 'Payment Method'(combobox) -->		
			<div class="form-group"  id="divsisa" >
                <label class="col-sm-3 control-label" for="sisa">Payment Method</label>
                <div class="input-group">
                    <input type="radio" name="payment" value='1' <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?> 
						<?php if($edit && $form_detail['pay_method'] == '1') echo 'checked' ?>>Cash <td>
					<input type="radio" name="payment" value='2' <?php if($edit && $form_detail['status_id'] == "18")  echo 'disabled="true"' ; ?> 
						<?php if($edit && $form_detail['pay_method'] == '2') echo 'checked' ?>>Transfer </td>
                </div>
            </div>
	
			<?php if($edit && $form_detail['status_id']=='7'){?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Remarks Revise:</label>
					<div class="input-group">
						<label><code><?php echo '"'.$form_detail['remarks_revise_approval'].'"';?> </code></label>
					</div>
				</div><?}?>
				
			

            <?php if($edit && $form_detail['status_id']=='18'){?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Remarks Revise Finance:</label>
					<div class="input-group">
						<label><code><?php echo '"'.$form_detail['remarks_revise_f2'].'"';?> </code></label>
					</div>
				</div><?}?>
				
			<!-- /.Membuat field 'Payment Method'(combobox) -->		
			<div class="form-group">
                <label class="col-sm-3 control-label">Remarks</label>
                    <div class="input-group">
                    <textarea class="form-control" id="remarks" rows="5" cols="100" placeholder="Tolong diberikan detail perhitungan nilai Cash Advance dan keterangan serta No Rekening, Nama, Bank penerima jika tipe pembayaran transfer..." input="textarea"><?php if ($edit) echo $form_detail['remarks']?></textarea>
                    </div>
            </div>
			<!-- /.keterangan status akhir di detail -->
			<?php if ($readonly){?>
			<div class="form-group">
                <label class="col-sm-3 control-label">End Status:</label>
                    <div class="input-group">
                       <code><label><?echo $form_detail['status'];?>  <?php if ($form_detail['status_id']=='0'){echo ' / '.$form_detail['approve_name'] ;}if ($form_detail['status_id']=='1'){echo ' / '.$detail_dir['name'] ;}if ($form_detail['status_id']=='2'){echo ' / '.$detail_akun['name'] ;};?></label></code>
                    </div>
            </div>
			<?}?>
		</div> <!-- /.CA-input -->
<? 
}
else
{ ?>
<!-- .Keterangan yang muncul Status CA Form Masih Open -->
<?php $no = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
<?php if ($value['status_id']=='0' || $value['status_id']=='1' || $value['status_id']=='2' || $value['status_id']=='7' || $value['status_id']=='3'){?>
	<h4><code>Sorry you cannot submit new request, your previous Open Cash Advance Form still haven't been responded.<br>
Please wait until your previously submitted form being responded.</code></h4><br><?}?>
<?php if ($value['status_id']=='9'){?>
	<h4><code>you must submit cash advance settlement form first.</code></h4><br><?}?>
	<?php if ($value['status_id']>='10' ){?>
	<h4><code>Your settlement form is still being processed.<br>Please wait before submitting another cash advance form.
</code></h4><br><?}?>
	
	<div class="requester-detail form-section-container">
	
				<div class="requester-detail form-section-container">
				<div class="form-group">
                <label class="col-sm-2 control-label">NO </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.$no ;?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">ID CA</label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.$value['ca_id'];?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">Ref No </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.$value['no_ref'];?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">Submitted Date </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.date('d F Y',strtotime($value['submitted_dt']));?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">CA Type </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.$value['ca_type'];?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">Charge Code </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?echo ': '.$value['ccdes'];?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">Amount </label>
                    <div class="input-group">
                        <input  type="text" class="form-control holo" readonly value="<?php if ($value['currency']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format($value['amount'],0,',','.') ?>">
                    </div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label">Status </label>
				 <div class="input-group">
                    <label ><code><?echo ':'.$value['status'];?></code> </label>
					</div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label"> </label>
				 <div class="input-group">
                    <?php if ($value['status_id']=='9'){?><a href="#"  title="Detail" onclick="change_page(this, 'c_oas039/load_view')" class="btn btn-warning btn-xs">Settle Now . . .</a><?}else{?><a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $value['ca_id'] ?>/6')" class="btn btn-warning btn-xs">View   detail . . .</a><?}?>
					</div>
				</div>
				</div>
				<?}}?>
				
			<?php } ?>
            </div><!-- /.box-body -->
				<div class="box-footer clearfix">
					<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas044/load_view')">Back...</button><?php if(!$readonly && $status_open != 1){ ?>
					<button type="submit" class="pull-right btn btn-primary" id="ca-form-submit-btn">
						<div class="pull-right" id="ca-sbmt-msg"></div>
							<?php if(!$edit) echo 'Submit'; else echo 'Update';?>
					</button> <?php }?>
				</div>
            </div>
			
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

<script type="text/javascript">

	// variabel untuk disubmit
	var url = "<?php echo site_url('c_oas038/submit_form'); ?>"
	$('#ca-form-submit-btn').hide();
	var payment = null;
	var type_cc = null;
	var type_ca = null ;
	var ca_id = null;
	var cc = null;
	var amount = null;
	var status_id = null;
	var edit = 0;
	var remarks = null;
	var currency = null;
	var no_ref = null;
	var posid = "<? echo $detail_posid['depth']; ?>";
	var nameapproval = null;
	var approval = null;
	var emailapproval = null;
	var namef2 = null;
	var f2 = null;
	var emailf2 = null;
	var reqname = null;
	// akhir dari variabel untuk disubmit
	
	// variabel untuk diedit
	<?php if($edit) { ?>
    type_ca = "<?= $form_detail['type_id'] ?>";
	type_cc = "<?= $form_detail['cctype'] ?>";
	ca_id = "<?= $form_detail['ca_id'] ?>";
    payment = "<?= $form_detail['pay_method'] ?>";
	no_ref = "<?= $form_detail['no_ref'] ?>";
    cc = "<?= $form_detail['chargecode'] ?>";
	reqname = "<?= $form_detail['employee_name'] ?>";
	f2 = "<?php echo $detail_akun2['id'];?>";
	emailf2 = "<?php echo $detail_akun2['email'];?>";
	namef2 = "<?php echo $detail_akun2['name'];?>";
	approval = "<?= $form_detail['aprove'] ?>";
	emailapproval = "<?= $form_detail['approve_email'] ?>";
	nameapproval = "<?= $form_detail['approve_name'] ?>";
	status_id = "<?= $form_detail['status_id'] ?>";
	
    edit = 1;
	$('#ca-form-submit-btn').show();
    amount = "<?= $form_detail['amount'] ?>";
    currency = "<?= $form_detail['currency'] ?>";
	var activity = 4;
	url = "<?php echo site_url('c_oas038/update_ca'); ?>";
	 if( status_id == '18' ){
	 	$('#input-cctype').attr('disabled', true);}
	 	else{
	 if( type_ca == '2' || type_ca == '3')
		{
            $('#input-cctype').val('1');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",false);
            $("#input-cctype option[value='2']").attr("disabled",true);
			$("#input-cctype option[value='3']").attr("disabled",true);
            $("#input-cctype option[value='4']").attr("disabled",true);
			 
        }
         if( type_ca == '4')
		{
            $('#input-cctype').val('1');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",true);
            $("#input-cctype option[value='2']").attr("disabled",true);
			$("#input-cctype option[value='3']").attr("disabled",true);
            $("#input-cctype option[value='4']").attr("disabled",true);
			 
        }
		 if( type_ca == '5')
		{
            $('#input-cctype').val('2');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",true);
            $("#input-cctype option[value='2']").attr("disabled",false);
			$("#input-cctype option[value='3']").attr("disabled",false);
            $("#input-cctype option[value='4']").attr("disabled",false);
			
        }}
	<?php } 
	?>
	// akhir dari variabel untuk diedit

	
//untuk format angka nominal amount
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

//function untuk membersihkan field yang eror	
function clearErr()
{
    $('.form-group').removeClass("has-error");
    $('#ca-pwd-msg').html("");
}

//function untuk validasi input angka(amount)
function digitsOnly(obj)
{
	obj.value=obj.value.replace(/[^\d]/g,'');showButton();
}

// tampilin button submit kalau fieldnya dah keisi semua
function showButton(){
	if (((payment == '1') || (payment == '2')) && ($('#total').val() != '')  && ($('#chargecodeid').val() != '0') && ($('#chargecode').val() != '')&& ($('#input-cctype').val() != '')&& ($('#catype').val() != '')) {
		$('#ca-form-submit-btn').show();	
	}
	else {
		$('#ca-form-submit-btn').hide();
	}
}

//function untuk memunculkan chargecode
function ccode()
{
	var charge_code = $("#chargecode").val();
	var elem = document.getElementById("chargecodeid");
	elem.value =charge_code;
	cc = $('#chargecodeid').val() ;
}
function get_approval(){
		var cctype = $("#input-cctype").val();
		if (cctype == '1'){
		if (posid > 2){
		approval = "<?= $approval_internal['id']?>";
		emailapproval = "<?= $approval_internal['email']?>";
		nameapproval = "<?= $approval_internal['name']?>";}
		if (posid < 3){
		approval = "<?php echo $detail_dir['id'];?>";}}
		if (cctype == '2' || cctype == '3'){
		nameapproval = "<?= $approval_pro_tra['name'] ?>";
		emailapproval = "<?= $approval_pro_tra['email'] ?>";
		approval = '<?= $approval_pro_tra['id'] ?>';}
		if (cctype == '4'){
		emailapproval = "<?= $approval_license['email'] ?>";
		nameapproval = "<?= $approval_license['name'] ?>";
		approval = "<?= $approval_license['id'] ?>";}
		
}

//function untuk mengarahkan approval
$(function() {
		
		activity='4';
		
        <?php if($readonly){ ?>
        $('.new-ca-form').find('input, textarea, select').attr('disabled', true);
        <?php } ?>

//ketika type ca di ganti
$('#catype').change(function()
{
	showButton();
    $("#ca-form-submit-btn").removeClass('disabled');
        if( $(this).val() == '2' || $(this).val() == '3')
		{
            $('#input-cctype').val('1');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",false);
            $("#input-cctype option[value='2']").attr("disabled",true);
			$("#input-cctype option[value='3']").attr("disabled",true);
            $("#input-cctype option[value='4']").attr("disabled",true);
			ccode();
			 get_approval();
            //enable chargecode
            $("#disable-cc").addClass('hide');
            $("#chargecode").removeClass('hide');
            //enable cctype
            $("#disable-cctype").addClass('hide');
            $("#input-cctype").removeClass('hide');
			
			//refresh chargecode box
            $("#chargecode > option").remove();
                $(".wait").removeClass('hide');
                $("#chargecode").addClass('hide');
                var sub_unsur_id = $('#input-cctype').val();
                $.ajax(
				{
                    type: "POST",
                    url: "c_oas038/load_chargecode/"+sub_unsur_id,
                    success: function(cities)
                    {
                        $.each(cities,function(id,city)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(city);
                            $('#chargecode').append(opt);
							ccode();
							 get_approval();
                        });
                        $(".wait").addClass('hide');
                        $("#chargecode").removeClass('hide');
                    }
                }); 
        }

         if( $(this).val() == '4')
		{
            $('#input-cctype').val('1');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",false);
            $("#input-cctype option[value='2']").attr("disabled",false);
			$("#input-cctype option[value='3']").attr("disabled",false);
            $("#input-cctype option[value='4']").attr("disabled",false);
			ccode();
			 get_approval();
            //enable chargecode
            $("#disable-cc").addClass('hide');
            $("#chargecode").removeClass('hide');
            //enable cctype
            $("#disable-cctype").addClass('hide');
            $("#input-cctype").removeClass('hide');
			
			//refresh chargecode box
            $("#chargecode > option").remove();
                $(".wait").removeClass('hide');
                $("#chargecode").addClass('hide');
                var sub_unsur_id = $('#input-cctype').val();
                $.ajax(
				{
                    type: "POST",
                    url: "c_oas038/load_chargecode/"+sub_unsur_id,
                    success: function(cities)
                    {
                        $.each(cities,function(id,city)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(city);
                            $('#chargecode').append(opt);
							ccode();
							 get_approval();
                        });
                        $(".wait").addClass('hide');
                        $("#chargecode").removeClass('hide');
                    }
                }); 
        }
		 if( $(this).val() == '5')
		{
            $('#input-cctype').val('2');
            $('#input-cctype').attr('disabled', false);
            $("#input-cctype option[value='1']").attr("disabled",true);
            $("#input-cctype option[value='2']").attr("disabled",false);
			$("#input-cctype option[value='3']").attr("disabled",false);
            $("#input-cctype option[value='4']").attr("disabled",false);
			ccode();
			 get_approval();
			
				//refresh chargecode box
				$("#chargecode > option").remove();
                $(".wait").removeClass('hide');
                $("#chargecode").addClass('hide');
                var sub_unsur_id = $('#input-cctype').val();
                $.ajax(
				{
                    type: "POST",
                    url: "c_oas038/load_chargecode/"+sub_unsur_id,
                    success: function(cities)
                    {
                        $.each(cities,function(id,city)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(city);
                            $('#chargecode').append(opt);
							ccode();
							 get_approval();
                        });
                        $(".wait").addClass('hide');
                        $("#chargecode").removeClass('hide');
                    }
                });
                //enable chargecode
                $("#disable-cc").addClass('hide');
                $("#chargecode").removeClass('hide');
				//enable cctype
                $("#disable-cctype").addClass('hide');
                $("#input-cctype").removeClass('hide');
        }
});

//ketika chargecode berubah	
$('#input-cctype').change(function(){
	$("#chargecode > option").remove();
    $(".wait").removeClass('hide');
    $("#chargecode").addClass('hide');
    var sub_unsur_id = $('#input-cctype').val();
    $.ajax(
	{
    type: "POST",
    url: "c_oas038/load_chargecode/"+sub_unsur_id,
	success: function(cities)
        {
            $.each(cities,function(id,city)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(city);
                            $('#chargecode').append(opt);
							ccode();
							 get_approval();
                        });
                        $(".wait").addClass('hide');
                        $("#chargecode").removeClass('hide');
                    }

                });
            
        });
		
		$('input:radio[name=payment]').on('click',function(){
            payment=$(this).val();
			showButton();
		});
		
		$('#ca-form-submit-btn').on('click', function(){
            clearErr();

            // store error message
            var chgpwdmsg = "";
            var dosubmit = true;

         
            // jika terjadi kesalahan, munculkan error
            if(chgpwdmsg != ""){
                $('#ca-pwd-msg').html(chgpwdmsg);
                dosubmit = false;
            }

            //input ke dalam angka tanpa titik
            var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('total').value)))); 
			 get_approval();
            if(dosubmit){
                console.log("Ajax call terpanggil")

                var form_data = { 
                    no_ref			: no_ref,
                        type_ca			: $('#catype').val(),
						payment			: payment,
						cc				: cc,
						ca_id 			: ca_id,
						approval		: approval,
						activity		: activity,
						amount			: angka,
						reqname			: reqname,
						emailapproval	: emailapproval,
						nameapproval	: nameapproval,
						 akuntan2         : f2,
                        akuntan2_email   : emailf2,
                        akuntan2_nama    : namef2,
						status_id		: status_id,
						remarks			: $('#remarks').val(),
						currency		: $('#currency').val(),
                        ajax            : '1' 
                };
                var id = $( this ).closest( "div.tab-pane" ).attr("id");
		console.log(form_data);
                $.ajax({
                    url: url,
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                        success: function(data) { <?php if($edit){?>
						alert("Success!");	
                            $("#"+id ).html("<code><h5>No Ref : " + no_ref +" has been updated</h5></code>" + data
                                +"");<?}else{?>
								alert("Form submitted successfully!");			location.reload();
                        <?}?>
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas044/load_form\")'>Back</button>");
                      
                        }
                });
            }
        });

});

$('#form')
    .submit(function(e) {

        e.preventDefault();

        $.ajaxFileUpload({
            url:'/c_oas038/upload',
            secureuri:false,
            fileElementId:'image',
            dataType: 'json',
            data    : {
                'title' : $('#title').val()
            },
            success: function (data, status){

                if( data.error != '' ){

                   console.log(data.error);

                }else{

                    console.log(data.msg);
                    // Refresh image list

                }

            },
            error: function (data, status, e){

                console.log(e);

            }
        });
    });
</script>