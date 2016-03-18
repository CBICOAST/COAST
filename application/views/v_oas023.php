<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS023
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
*	 1.00				4 Maret 2015	Winni Oktaviani	
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

$edit = false;
if(isset($edit_mode)){
	$edit = true;
}
?>
<script type="text/javascript" src="jquery.js"></script><script type="text/javascript">
var htmlobjek;

var approval_email = null;
var approval_name = null;

$(document).ready(function(){
	$("#edit_alltype").change(function(){
		var code = $("#edit_alltype").val();
		$.ajax({
			url: "c_oas023/ambilkode2",
			data: "code="+code,
			cache: false,
			success: function(msg)
				{
				$('#edit_chargecode_claim').hide();				
				$("#div_edit_cc").html(msg);
				show_hidden_button();
					if ($("#edit_alltype").val() == '1'){
						if ((('<?echo $this_group?>' != 'CONSULTANT') && ('<?echo $depth['depth']?>' > '2'))
						|| (('<?echo $this_group?>' == 'CONSULTANT') && (('<?echo $depth['depth']?>' == '3')|| ('<?echo $depth['depth']?>' == '4')))){
							document.getElementById("nameapp").value  = "<?= $head_group['name']?>";
							document.getElementById("nameapphd").value  = "<?= $head_group['id']?>";
							approval_email = "<?= $detail_akun['email']?>";
						}
						else if (('<?echo $this_group?>' == 'CONSULTANT')&&
							('<?echo $this_division?>' == 'RD')){
							document.getElementById("nameapp").value  = "<?= $head_group['name']?>";
							document.getElementById("nameapphd").value  = "<?= $head_group['id']?>";
							approval_email = "<?= $detail_akun['email']?>";
						}
						else if (('<?echo $this_group?>' == 'CONSULTANT')&&
							('<?echo $this_division?>' == 'CONSULTANT')){
							document.getElementById("nameapp").value  = "<?= $director['name']?>";
							document.getElementById("nameapphd").value  = "<?= $director['id']?>";
							approval_email = "<?= $director['email']?>";
						}
						else if (('<?echo $depth['depth']?>' == '2')&&
							(('<?echo $this_group?>' == 'OPERATION') || ('<?echo $this_group?>' == 'BD'))){
							document.getElementById("nameapp").value  = "<?= $director['name']?>";
							document.getElementById("nameapphd").value  = "<?= $director['id']?>";
							approval_email = "<?= $director['email']?>";
						}
						else if ('<?echo $this_division['depth']?>' == '1'){
							document.getElementById("nameapp").value  = "<?= $director['name']?>";
							document.getElementById("nameapphd").value  = "<?= $director['id']?>";
							approval_email = "<?= $director['email']?>";
							
						}
						else {
							document.getElementById("nameapp").value  = "<?= $head_div['name']?>";
							document.getElementById("nameapphd").value  = "<?= $head_div['id']?>";
							approval_email = "<?= $head_div['email']?>";
						}	
					}
					else if ($("#edit_alltype").val() == '2'){
						document.getElementById("nameapp").value  = "<?= $app_project['name']?>";
						document.getElementById("nameapphd").value  = "<?= $app_project['id']?>";
						approval_email = "<?= $app_project['email']?>";
					}
				}
			});
		});
		$("#div_edit_cc").change(function(){
		var code =  $("#edit_cc_claim").val();
		$.ajax({
			url: "c_oas023/ambilapproval",
			data: "code="+code,
			cache: false,
			success: function(msg)
				{		
					//$("#div_approval_cc_claim").html(msg);
				}
			});
		});
		
		$("#div_edit_cc_2").change(function(){
		var select_id_cc_edit = $("#edit_chargecode_claim").val();
		var isi_cc_edit		= document.getElementById("hidden-edit-cc");
		isi_cc_edit.value	= select_id_cc_edit;
		var code =  $("#edit_chargecode_claim").val();
		$.ajax({
			url: "c_oas023/ambilapproval",
			data: "code="+code,
			cache: false,
			success: function(msg)
				{		
					//$("#div_approval_cc_claim").html(msg);
				}
			});
			
			
	});
});
</script>

<?php if($edit) {?>
<div class="box box-solid box-danger">
	<div class="box-header">
                <h3 class="box-title">Edit Expense Claim Form</h3>
            </div>
    <div class="box-body">
        <div class="requester-detail form-section-container">
			<div class="form-group">
				<label class="col-sm-4 control-label">Reference Number</label>
				<div class="input-group">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php echo $info['ref_no']?>"  class="form-control holo">
				</div><!-- /.input group -->
			</div><!-- /.form group -->
			
			<div class="form-group">
				<label class="col-sm-4 control-label">Claim Type</label>
				<div class="input-group">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php echo $info['claim_name']?>" class="form-control holo"> <div hidden>
					<input hidden type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php echo $info['claim_type'] ?>" 
					id="edit_claim_type_id" class="form-control holo"></div>
				</div><!-- /.input group -->
			</div><!-- /.form group -->
			
			
			<div class="form-group">
                <label class="col-sm-4 control-label">Approval</label>
                <div class="input-group"id="div_approval_cc_claim">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" 
									id="nameapp"	value="<?php echo $info['approve_name']?>" class="form-control holo">
										
				
                </div>
            </div>
			
			<!-- ambil approval id untuk save ke database -->
			<div class="form-group" hidden>
                <div class="input-group"id="div_approval_cc_claim">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" 
						id="nameapphd"	value="<?php echo $info['aprove']?>" class="form-control holo">
                </div>
            </div>
			
			<?php if ($info['category_id']==2){ ?>
			 <div class="form-group">
                <label class="col-sm-4 control-label">Charge Code Type</label>
                <div class="input-group">
                    <select id="edit_alltype" class="col-sm-16 control-label">
                        <?php foreach ($alltypechargecode as $key => $cc) { ?>
                        <option value="<?= $cc['id'] ?>"
                            <?php if($tipechargecode['val_type']==$cc['id']) echo 'selected'?>><?= $cc['value'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>		
		
			<div class="form-group">
                
                <div class="input-group" >
					<input id="hidden-edit-cc"readonly  type="hidden" maxlength="50" style="text-align: left; width: 175px" 
										value="<?php echo $info['charge_code']?>" class="form-control holo">
                </div>
            </div>
			 <div class="form-group">
                <label class="col-sm-4 control-label">Charge Code</label>
				<div class = "input-group" id="div_edit_cc"></div>
                <div class="input-group" id="div_edit_cc_2">
                    
                    <select id="edit_chargecode_claim" class="col-sm-16 control-label">
						<option style="display: none;" value=""> --choose one---</option>
                        <?php foreach ($allcc as $key => $cc) { ?>
                        <option value="<?= $cc['ccname'] ?>"
                            <?php if($this_CC['ch']==$cc['ccname']) echo 'selected'?>><?= $cc['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>				
			<? } ?>
			
			<div class="requester-input form-section-container input-section">
				<br>
				<div class="form-group">
					<div class="form-group">
						<label for="join-date" class="col-sm-4 control-label">Receipt Date</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input  type="text" maxlength="50" style="text-align: left; width: 175px"  id="edit_cl_receipt_date" class="form-control holo" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($info['tanggal_kwitansi'])) ?>">
						</div><!-- /.input group -->
					</div><!-- /.form group -->
							
					<div class="form-group">
						<label class="col-sm-4 control-label">Amount</label>
						<div class="input-group">
							<div class="input-group-addon">
								Rp. 
							</div>
							<input type="text" id="edit_amount_claimRp" style="text-align: left; width: 175px"onkeyup="digitsOnly(this, '.')"  onchange="digitsOnly(this, '.')" class="form-control holo" value="<?php  echo number_format($info['total'],0,',','.') ?>">						
						</div>
						<span id="edit_claim_result"  style="color:red;text-align:center">
						</span><!-- /.input group -->
					</div><!-- /.form group -->
					<div class="form-group" hidden>
						<div class="input-group" >
							<input type="text" id="edit_amount_claim" style="text-align: left; width: 175px"class="form-control holo" value="<?php  echo $info['total'] ?>">
							<span id="edit_claim_result"  style="color:red;text-align:center"><br />
							</span>
						</div><!-- /.input group -->
					</div><!-- /.form group -->
					<div class="form-group"  id="div_show_limit_edit" >
						<label class="col-sm-4 control-label">Limit:</label>
                        <div class="input-group">
							<div class="input-group-addon">
                               Rp.
                            </div>
							<input type="text" id="limit_show_edit" readonly class="form-control holo">
						</div><!-- /.input group -->
                    </div>
					
					<div class="form-group" hidden >
						<label class="col-sm-4 control-label">Limit:</label>
                        <div class="input-group">
							<input type="text" id="edit_sisa_claim" readonly class="form-control holo">
						</div><!-- /.input group -->
                    </div>
					<Span id="span_limit_edit">	</Span>
					<div class="form-group">
						<label class="col-sm-4 control-label">Remarks</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-pencil"></i>
							</div>
							<textarea class="form-control" id="edit_remarks" rows="3" placeholder="remarks..." input="textarea" ><?php  echo $info['keterangan']; ?></textarea>
						</div><!-- /.input group -->
					</div><!-- /.form group -->
					<input type="hidden" id="editmonthReceipt" readonly class="form-control holo" >
					<input type="hidden" id="edityearReceipt" readonly class="form-control holo" >
											
			</div><!-- /.form group -->
		</div><!-- /.form group -->
	</div><!-- /.form group -->
</div><!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="pull-left" id="update-claim-msg"></div>
		<button type="button" class="pull-left btn btn-default"  onclick="change_page(this, 'c_oas022/load_view')">Back...</button>
                
        <button class="pull-right btn btn-primary" id="sbmt-update-claim" type="submit">Update</button>
    </div>
	
</div><!-- /.box -->
	<?}?>
<script type="text/javascript">

<?php if($edit) { ?>
var edit_claim_receipt_date = "<?= $info['tanggal_kwitansi'] ?>";
var ori_amount	= "<?= $info['total'] ?>";;
var remarks		= null;
var chargecode	= null;
var ori_chargecode = "<?= $info['charge_code'] ?>";
var aprove		= null;
var refno		= "<?= $info['ref_no'] ?>";
var statRevise = null;
var ori_date = "<?= $info['tanggal_kwitansi'] ?>";
var ori_remarks	= "<?= $info['keterangan'] ?>";
var categoryclaim = "<?= $info['category_id'] ?>";
var claim_id		= "<?= $info['claim_id'] ?>";
if ($('#edit_claim_type_id').val()  <= 3) 
   {
edit_sisa_claim.value = "<?= $this_balance_tnj['balance']  ?>";
limit_show_edit.value = "<?= number_format($this_balance_tnj['balance'],0,",",".")?>";
}
else {showhidesisa();}

var refno= "<?= $info['ref_no'] ?>";
url = "c_oas023/submit_edit_form";
function limit_rupiah(){
    var nominal= document.getElementById("edit_sisa_claim").value;
    var rupiah = convertToRupiah(nominal);
    document.getElementById("limit_show_edit").value = rupiah;
}

function showhidesisa() {
   var elem = document.getElementById("edit_claim_type_id");  
   var elemTotal = document.getElementById("edit_amount_claim");   
   if ((elem.value  <= 3)) 
   {
	    $('#div_show_limit_edit').show();
		$('#edit_claim_result').hide();
		var code = $('#edit_claim_type_id').val();
		var month_kw =  $('#editmonthReceipt').val();
		var year_kw =  $('#edityearReceipt').val();
		$.ajax({
			url: "c_oas023/getTunjangan",
			data: {"code":code,"month_kw":month_kw,"year_kw":year_kw},
			cache: false,
			success: function(msg)
			{
				$("#span_limit_edit").html(msg);
				$('#span_limit_edit').show();
				document.getElementById("edit_sisa_claim").value = $('#hd_edit_tunjangan').val();
				limit_rupiah();
			}	
		});
	}	
	 else if ((elem.value  > 3) && (elem.value < 8 )) {
	  edit_sisa_claim.value = "-";
	   $('#sbmt-update-claim').show();
	   $('#div_show_limit_edit').hide();
	 }
	else if ((elem.value  >= 8)) 
	{
	    $('#div_show_limit_edit').show();
		$('#edit_claim_result').hide();
		edit_sisa_claim.value = "<?= $this_balance['balance']  ?>";
		limit_show_edit.value = "<?= number_format($this_balance['balance'],0,",",".")  ?>";
	}	 
  }
  
function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');	
}
function rupiah(){
    var nominal= document.getElementById("edit_amount_claimRp").value;
    var rupiah = convertToRupiah(nominal);
    document.getElementById("edit_amount_claimRp").value = rupiah;	
}

//function membersihkan tanda titik di field amount
function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}

function digitsOnly(objek,separator)
	{	
		a = objek.value;
		b = a.replace(/[^\d]/g,"");
		c = "";
		panjang = b.length;
		j = 0;
		for (i = panjang; i > 0; i--)
		{
			j = j + 1;
			if (((j % 3) == 1) && (j != 1)) {
				c = b.substr(i-1,1) + separator + c;
			} else {
				c = b.substr(i-1,1) + c;
			}
		}
		objek.value = c;
		var tipe = document.getElementById("edit_claim_type_id");
		document.getElementById("edit_amount_claim").value = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($('#edit_amount_claimRp').val()))));
		cek_limit();
	}
	
	function cek_limit()
	{
		var edit_sisa_claim = $('#edit_sisa_claim').val();
		var total = $('#edit_amount_claim').val();
		hasil = edit_sisa_claim - total;
		show_hidden_button();
		if (hasil < 0 ){
			$('#edit_claim_result').show();
			document.getElementById('edit_claim_result').innerHTML = "Sorry You Exceed Your Limit";
			$('#sbmt-update-claim').hide();	 
		 }
		 else {
			document.getElementById('edit_claim_result').innerHTML = "";
			$('#edit_claim_result').hide();
			show_hidden_button();	 
		 }
	}
	function show_hidden_button(){
		if (($('#edit_cc_claim').val() == '') || ($('#edit_cl_receipt_date').val() =='') || ($('#edit_amount_claim').val() == '')){
				 $('#sbmt-update-claim').hide();
		}
		else{
		 $('#sbmt-update-claim').show();};
	}
	
 $(function() {
	
	
	$("#div_edit_cc").change(function(){
		var select_id_cc_edit = $("#edit_cc_claim").val();
		var isi_cc_edit = document.getElementById("hidden-edit-cc");
		isi_cc_edit.value		= select_id_cc_edit;
		show_hidden_button();
	});
	
	$('#edit_cl_receipt_date').datepick({
		dateFormat: 'dd MMMM yyyy',
		maxDate: "+0D" ,
		minDate:"-2M",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			edit_claim_receipt_date = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+edit_claim_receipt_date);
			ambilbulan = moment(dates[0]).format('MM');
			ambiltahun = moment(dates[0]).format('YYYY');
			editmonthReceipt.value = ambilbulan;
			edityearReceipt.value = ambiltahun;
			edit_sisa_claim.value = "";			
			showhidesisa();
			show_hidden_button();cek_limit();
		},
	});
	   moment.locale('id', {
                    months : [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                    "Agustus", "September", "Oktober", "November", "Desember"
                    ]
                });
	
	
     $('#sbmt-update-claim').on('click', function(){
		if( categoryclaim == 1 ){
			aprove		= "<?= $info['aprove'] ?>";
			aprove_email= "<?= $info['approve_email'] ?>";
			aprove_name	= "<?= $info['approve_name'] ?>";
			chargecode	= "<?= $info['charge_code'] ?>";
			status_id	= "<?= $info['status_id'] ?>";
			statRevise ='0';
		}
		else if( categoryclaim == 2 ){
			aprove		= $('#nameapphd').val();
			aprove_name		= $('#nameapp').val();
			chargecode		= $('#hidden-edit-cc').val();
			status_id	= "<?= $info['status_id'] ?>";
			
			if ($('#nameapphd').val() == "<?= $info['aprove'] ?>"){
				statRevise ='14';
			}
			else{statRevise ='0';}
		}
		
		var form_data = {
			claim_id 		: claim_id,
			receipt_date    : edit_claim_receipt_date,
			amount			: $('#edit_amount_claim').val(),
			remarks	    	: $('#edit_remarks').val(),	
			ori_chargecode	: ori_chargecode,
			ori_amount		: ori_amount,
			ori_date		: ori_date,
			ori_remarks		: ori_remarks,
			chargecode		: chargecode,
			aprove			: aprove,
			aprove_email	: approval_email,
			aprove_name		: $('#nameapp').val(),
			categoryclaim	: categoryclaim,
			ref_no          : refno,
			status_id		:status_id,
			statRevise		: statRevise,
			ajax			: 1
		}; 
		console.log(form_data);

		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				alert("Submit Success!");
				location.reload();
			},
			error: function(){                      
				$( "#update-claim-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
    });
});

<?}?>
 </script>