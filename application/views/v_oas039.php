<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS039
* Program Name     : Add/Edit Settlement of Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 12-11-2014 9:19:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
	//no ref select	
	$("#SETTLE_noRef").change(function(){
		var code = $("#SETTLE_noRef").val();
		$.ajax({
			url: "c_oas039/get_noref",
			data: "code="+code,
			cache: false,
			success: function(msg)
				{
				$("#settle").html(msg);
				var select_type_ca = $("#select_type_ca").val();
				var select_ref_bt = $("#select_ref_bt").val();
				var received_money_save = $("#select_amount_save").val();
				var received_money = $("#select_amount").val();
				var select_description = $("#select_description").val();
				var select_charge_code = $("#select_charge_code").val();
				var select_currency = $("#select_currency").val();
				var select_typecc = $("#select_typecc").val();
				var select_destination = $("#select_destination").val();
				var select_id_ca = $("#select_id_ca").val();
				var isi_catype = document.getElementById("ca_type");			
				var isi_refbt = document.getElementById("ref_bt");			
				var isi_received_save = document.getElementById("received_save");	
				var isi_received = document.getElementById("received");	
				var isi_description = document.getElementById("projectdescription");
				var isi_cc = document.getElementById("chargecode");		
				var isi_currency = document.getElementById("currency");	
				var isi_cctype = document.getElementById("chargecodetype");
				var isi_destination = document.getElementById("destination");
				var isi_id_ca = document.getElementById("id_ca");
				
				isi_catype.value		= select_type_ca;
				isi_refbt.value		= select_ref_bt;
				isi_received_save.value		= received_money_save;
				isi_received.value		= received_money;
				isi_description.value	= select_description;
				isi_cc.value			= select_charge_code;
				isi_currency.value		= select_currency;
				isi_cctype.value		= select_typecc;
				isi_destination.value	= select_destination;
				isi_id_ca.value			= select_id_ca;
				
				$('#hidedestination').show();
				$('#hideref_bt').show();
				$('#hidecatype').show();
				$('#hidechargecodetype').show();
				$('#hideprojectdescription').show();
				$('#hidechargecode').show();
				$('#hidecurrency').show();
				$('#hidereceived').show();
				$('#hideused').show();
				$('#hideremaining').show();
				$('#hiderefbt').show();
				
				if (select_destination == '-'){
					$('#hidedestination').hide();
					$('#hideref_bt').hide();
				}
				else{
					$('#hidedestination').show();
					$('#hideref_bt').show();
				}
				
				}
			});
	});
	
	$("#select_charge_code").change(function(){
		var charge_code = $("#cc").val();
		var elem = document.getElementById("chargecodetype");
		elem.value =charge_code;
	});
});
</script>

<?
$edit = false;

if(isset($edit_param)){
	$edit = true;
}
if ($status_edit=='1'){
	$edit = true;
}?>
<div class="row">
    <div class="col-md-11">
		<div class="box box-solid box-danger">
			<div class="box-header">
                <h3 class="box-title"> Settlement of Cash Advance </h3>
            </div>
            <div class="box-body"><?
		if ($status_edit=='1'|| $count_settle != 0 ){
		?>
                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php echo $this_name?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control"  value="<?php echo $this_email?>">
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="col-sm-3 control-label" >Group / Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $this_group.'/'. $this_division?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Level</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $this_level['name'] ?>">
                        </div>
                    </div>                                
                </div> <!-- /.requester-detail -->

            <div class="requester-input form-section-container input-section">
			  
				<? if ($edit){?>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="ref_nom" >Reference Number:</label>
					<div class="input-group">
						<label readonly id="refnom"><?= $form_detail['no_ref'] ?></label>
					</div>
				</div>
				<?}
				else{?>
				<div class="form-group">
					<label class="col-sm-3 control-label">Reference Number</label>
					<div class="input-group">
						<select  id="SETTLE_noRef">
							<?php foreach ($no_ref as $key => $type) { ?>
							<option style="display: none;" value=""> --- choose one --- </option>
							<option value="<?=$type['no_ref']?>"><?= $type['no_ref'] ?></option>
							<?php } ?>
						</select> 
					</div>  
				</div>
				<?}?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="receipt_date">Receipt Date:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input  type="text" class="form-control holo" id="receipt_date"<?php if ($edit){?> value="<?php echo date('d F Y',strtotime($form_detail['rd']));}?>">
					</div>
				</div>
				
				<div id="settle" hidden></div>	
				<div hidden>
					<input type="text"  class="form-control holo" id="id_ca"
					<?php if ($edit){?> value="<?echo $form_detail['ca_id'];}?>">
				</div>
																	
				<div class="form-group"id="hidecatype">
					<label class="col-sm-3 control-label" >Cash Advance Type</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="ca_type"<?php if ($edit){?> value="<?echo $form_detail['ca_type'];}?>" >
					</div> 
				</div>
				
				<div class="form-group"id="hideref_bt">
					<label class="col-sm-3 control-label" >Ref. BT</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="ref_bt"<?php if ($edit){?> value="<?echo $form_detail['ref_bt'];}?>" >
					</div> 
				</div>
				
				<div class="form-group" id="hidedestination">
					<label class="col-sm-3 control-label">Destination:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="destination" <?php if ($edit){?> value="<?echo $form_detail['destination'];}?>">
					</div>
				</div>
				
				<div class="form-group" id="hidechargecodetype">
					<label class="col-sm-3 control-label">Charge Code Type</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="chargecodetype" <?php if ($edit){?> value="<?echo $form_detail['categorycc_type'];}?>">
					</div>
				</div>
				
				<div class="form-group" id="hideprojectdescription" width="80px">
					<label for="group" class="col-sm-3 control-label">Project Description</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input readonly type="text" class="form-control holo" id="projectdescription"<?php if ($edit){?> value="<?echo $form_detail['cc_name'];}?>"> 
					</div>
				</div>
				
				<div class="form-group" id="hidechargecode">
					<label class="col-sm-3 control-label">Charge Code</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="chargecode" <?php if ($edit){?> value="<?echo $form_detail['chargecode'];}?>">
					</div>         
				</div>
				
				<div class="form-group"id="hidecurrency">
					<label class="col-sm-3 control-label" > Currency:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="currency"<?php if ($edit){?> value="<?echo $form_detail['currency_name'];}?>">					
					</div>
				</div>
				
				<div class="form-group"id="hidereceived">
					<label class="col-sm-3 control-label" >Cash Advance Amount</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input readonly type="text"  class="form-control holo" id="received"<?php if ($edit){?> value="<? echo $form_detail['diberikan'];}
						else {echo '0';}?>">
					</div>       
				</div><div class="form-group" hidden>
					
						
						<input readonly type="text"  class="form-control holo" id="received_save"<?php if ($edit){?> value="<? echo $form_detail['diberikan'];}
						else {echo '0';}?>">
					 
				</div>
				
				<div class="form-group"id="hideused">
					<label class="col-sm-3 control-label" >Used Amount</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input type="text" style="text-align: left;" onkeyup="formatAngka(this, '.')"  class="form-control holo" id="used" <?php if ($edit){?> value="<? echo $form_detail['terpakai'];}?>">
					</div>       
				</div>
				
				<div class="form-group"id="hideremaining">
					<label class="col-sm-3 control-label" >Balance</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input readonly type="text"  class="form-control holo" id="remaining"<?php if ($edit){?> value="<? echo $form_detail['sisa'];}?>">
					</div>      
				</div>
				
				<div class="form-group"  id="div_pay_set" >
					<label class="col-sm-3 control-label" for="payment">Settlement Payment Method:</label>
					<div class="input-group">
						<input type="radio" name="set-payment-method" value="1"<?php if($edit && $form_detail['pay_method'] == '1') echo 'checked' ?>>Cash
						&nbsp;&nbsp;
						<input type="radio" name="set-payment-method" value="2"<?php if($edit && $form_detail['pay_method'] == '2') echo 'checked' ?>>Transfer
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Remarks:</label>
					<div class="input-group">
						<textarea class="form-control" rows="5" cols="100" id="settle_remarks" rows="3"  input="textarea"><?php if ($edit){ echo $form_detail['remarks'];}?> </textarea>
					</div>
				</div>
			</div> <!-- /.requester-input -->
		</div><!-- /.box-body -->
		
		<div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<button type="submit" class="pull-right btn btn-primary" id="set-form-submit-btn"> Submit </button>
		</div>
		<? 
}
else
{					
	echo "<font color='red' size='+2'>You don't Have Anything to Settle</font>";
} ?>
	</div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->


<!-- InputMask -->
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo js_url();?>plugins/daterangepicker/daterangepickernew.js" type="text/javascript"></script>
<!-- Page script -->
<script type="text/javascript">
var url = null;
var hasil = null;
var akuntan_id		= "<?php echo $detail_akun['id'];?>";
var akuntan_email	= "<?php echo $detail_akun['email'];?>";
var akuntan_nama	= "<?php echo $detail_akun['name'];?>";
var tgl_kwi 	= null;
var no_ref = null;
// sembunyikan dulu sebelum pilih no referensi
<?php if(!$edit) { ?>

$('#hideref_bt').hide();
$('#hidedestination').hide();
$('#hidecatype').hide();
$('#hidechargecodetype').hide();
$('#hideprojectdescription').hide();
$('#hidechargecode').hide();
$('#hidecurrency').hide();
$('#hidereceived').hide();
$('#hideused').hide();
$('#hideremaining').hide();
$('#set-form-submit-btn').hide();
$('#div_pay_set').hide();
no_ref = $('#SETTLE_noRef').val();
<?php } ?>
var payment = null;
var type_ca = null;
showButton();
<?php if($edit) { ?>
	$('#set-form-submit-btn').show();
	$('#hideref_bt').show();
	$('#hidedestination').show();
	$('#hidecatype').show();
	$('#hidechargecodetype').show();
	$('#hideprojectdescription').show();
	$('#hidechargecode').show();
	$('#hidecurrency').show();
	$('#hidereceived').show();
	$('#hideused').show();
	$('#hideremaining').show();
	$('#set-form-submit-btn').show();
	no_ref = "<?php echo $form_detail['no_ref'];?>";

	type_ca = "<?= $form_detail['type_id'] ?>";
	tgl_kwi = "<?= $form_detail['rd'] ?>";
	if (type_ca !='1'){
		$('#hideref_bt').hide();
	$('#hidedestination').hide();
	}
    payment = "<?= $form_detail['pay_method'] ?>";
	if (payment ='0'){
		$('#div_pay_set').hide();
	}
	<?php } ?>

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
  
hitung();
	
	
	}
	

//function membersihkan tanda titik di field amount
function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}

	function hitung(){
	
	// untuk menampilkan pesan jika input amount melebihi limit
	<?php if($edit) { ?>
	
	var limit	= $('#received_save').val();<?php }else ?>
	var limit	= "<?= $form_detail['diberikan']?>";
	var amount	= bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($('#used').val()))));
	var total	= amount;
	hasil		= limit - total;
	
	var sisa 	= document.getElementById("remaining");
	sisa.value	= hasil;
	if (hasil <= 0){
		$('#div_pay_set').hide();
		payment = '0';
		$('#set-form-submit-btn').show();
	}
	if (hasil > 0 ){
		$('#div_pay_set').show();
		showButton();
	}
//	showButton();
}

function showButton(){
  <?php if(!$edit) { ?>
	if (((payment == '1') || (payment == '2')) && ($('#receipt_date').val() != '') &&($('#used').val() != '') ) {
		$('#set-form-submit-btn').show();	
	}
	else {
		$('#set-form-submit-btn').hide();
	}
    <?php } ?>
	<?php if($edit) { ?>
	$('#set-form-submit-btn').show();
	<?php } ?>
}

$(function() {
	var tgl_kwitansi = '';
	$('#receipt_date').datepick({
		dateFormat: 'yyyy-mm-dd',
		maxDate: "+0D" ,
		minDate:"-2M",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl_kwitansi = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl_kwitansi);	
			tgl_kwi = $('#receipt_date').val();
			showButton();
					
		},
	});

	
	// ambil value radio button yang dipilih
	$('input:radio[name=set-payment-method]').on('click',function(){
            payment = $(this).val();
			showButton();
     });
	 
	// submit button
	$('#set-form-submit-btn').on('click', function(){
	<? if ($edit) {?>
		var  url =  "<?php echo site_url('c_oas039/update_settle')?>";
	<?} else if(!$edit) {?>
		var url			="<?php echo site_url('c_oas039/submit_form') ?>";
		<?}?>
		
		var form_data = {
			ca_id				: $('#id_ca').val(),
			tanggalKwitansi		: tgl_kwi,
			amount				: bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($('#used').val())))),
			remaining			: $('#remaining').val(),
			remarks				: $('#settle_remarks').val(),
			noRef				: no_ref,
			noRef1				: $('#SETTLE_noRef').val(),
			paymentMethod		: payment,
			submittedDate   	: moment().format('YYYY-MM-DD'),
			akuntan			: akuntan_id,
			akuntan_email	: akuntan_email,
			akuntan_nama	: akuntan_nama,
			ajax				: 1			
		   
		}; 
		 var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);
		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) { <?php if($edit){?>
                        			 $( "#"+id ).html("Update Settlement Success!" + data
                                +"<br><button onclick='closeTab(this)'>Close</button>");
                        <?}else?>
                        			 $( "#"+id ).html("Submites Success!" + data
                                +"<br><button onclick='closeTab(this)'>Close</button>");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas044/load_form\")'>Back</button>");
                      
                        }
		});
    });
});
</script>