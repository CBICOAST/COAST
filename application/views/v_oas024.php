<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS024
* Program Name     : Create Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			09-12-2014		Winni Oktaviani			Finishing
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/



$form_id = $form_data['id'];
$edit = false;
if(isset($edit_stat))
{
    $edit = true;
}

?>
<script type="text/javascript">
var htmlobjek;
var chargecode_val =null;
var tipesubmit = null;
var claimTypeId = null;
var approval_email = null;
var approval_name = null;

$(document).ready(function(){
	$("#list_cl_type").change(function(){
		$('#claim-submit-btn').hide();
		$('#cl-result').hide();
		var code = $("#list_cl_type").val();
		var child = $('#medical_list').val();
		var month_kw = $('#monthReceipt').val();
		var year_kw = $('#yearReceipt').val();	
		$.ajax({
			url: "c_oas024/getMedical",
			data: {"code":code,"year_kw":year_kw},
			cache: false,
			success: function(msg)
				{			
		
				$("#claim1").html(msg);
				$('#claim1').show();
				getSisa();
				document.getElementById("cl-amount").value = "";
				if (($('#medical_list').val() == null)&& ($('#catCL').val() != null)){				
					
					$('#medical_list').hide();
					if ($('#catCL').val() == '1'){
						$('#div_limitCL').show();
						chargecode_val = '<?= $this_division ?>';
						tipesubmit = '1';
						$('#div_cc_div').hide();
						document.getElementById("div_app").value  = "<?= $detail_akun['name']?>";
						document.getElementById("div_app_hd").value  = "<?= $detail_akun['id']?>";
						approval_email = "<?= $detail_akun['email']?>";
						claimTypeId = $("#list_cl_type").val();
						$('#div_typecc_cl').hide();
						$('#div_cc_cl').hide();
						if (($('#list_cl_type').val() == '8')  || ($('#list_cl_type').val() == '10')){
												
							if('<?echo $this_status['status']?>'== '1'){
								$.ajax({
									url: "c_oas024/getAmount",
									data: {"code":code,"child":0,"year_kw":year_kw},
									cache: false,
									success: function(msg)
									{	
										document.getElementById("cl-limitRp").value ="<?= $bantu['amount']?>";
											$("#claim1s").html(msg);
											$('#claim1s').show();
											document.getElementById("cl-limit").value = $('#bantuan').val();
											limit_rupiah();
									}	
								});

							}
							else if  ('<?echo $this_status['status']?>'== '2'){
								document.getElementById("cl-limitRp").value = "0";
							}
						}
						else if ($('#list_cl_type').val() == '9') {
												
							if('<?echo $this_status['status']?>'== '1'){
								$.ajax({
									url: "c_oas024/getAmount",
									data: {"code":code,"child":child,"year_kw":year_kw},
									cache: false,
									success: function(msg)
									{	
										document.getElementById("cl-limitRp").value ="<?= $bantu['amount']?>";
											$("#claim1s").html(msg);
											$('#claim1s').show();
											document.getElementById("cl-limit").value = $('#bantuan').val();
											limit_rupiah();
									}	
								});

							}
							else if  ('<?echo $this_status['status']?>'== '2'){
								document.getElementById("cl-limitRp").value = "0";
							}
						}
						else if (($('#list_cl_type').val() == '1') || ($('#list_cl_type').val() == '2') || ($('#list_cl_type').val() == '3')){
							$.ajax({
								url: "c_oas024/getTunjangan",
								data: {"code":code,"child":child,"month_kw":month_kw,"year_kw":year_kw},
								cache: false,
								success: function(msg)
								{
									document.getElementById("cl-limitRp").value ="<?= $tnj['amount']?>";
									$("#claim1s").html(msg);
									$('#claim1s').show();
									document.getElementById("cl-limit").value = $('#hd_tunjangan').val();
									limit_rupiah();
								}	
							});
						}
						
						
					}
					else if ($('#catCL').val() == '2'){	 				
						$('#div_typecc_cl').show();
						$('#div_limitCL').hide();			
						document.getElementById("div_app").value  = "-";
						document.getElementById("div_app_hd").value  = "-";
						claimTypeId = $("#list_cl_type").val();
					
					}					
				}
				else{ $('#medical_list').show;
						$('#div_typecc_cl').hide();
						$('#div_cc_cl').hide();
						
						$('#div_cc_div').hide();
						document.getElementById("div_app").value  = "<?= $detail_akun['name']?>";
						document.getElementById("div_app_hd").value  = "<?= $detail_akun['id']?>";
						approval_email = "<?= $detail_akun['email']?>";
						claimTypeId = $("#medical_list").val();
						tipesubmit = '1';chargecode_val = '<?= $this_division ?>';
						$('#div_typecc_cl').hide();
						
					}
				}
			});
		});
		
		$("#cl-cctype").change(function(){
		var code = $("#cl-cctype").val();
		$.ajax({
			url: "c_oas024/getCC",
			data: "code="+code,
			cache: false,
			success: function(msg)
				{
				$("#ccCL_list").html(msg);
				$('#div_cc_cl').show();
				
					if ($('#cl-cctype').val() == '1'){	 
						if ((('<?echo $this_group?>' != 'CONSULTANT') && ('<?echo $depth['depth']?>' > '2'))
						|| (('<?echo $this_group?>' == 'CONSULTANT') && (('<?echo $depth['depth']?>' == '3') || ('<?echo $depth['depth']?>' == '4')))){
							document.getElementById("div_app").value  = "<?= $head_group['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $head_group['id']?>";
							approval_email = "<?= $head_group['email']?>";
						}
						else if (('<?echo $this_group?>' == 'CONSULTANT')&&
							('<?echo $this_division?>' == 'RD')){
							document.getElementById("div_app").value  = "<?= $head_group['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $head_group['id']?>";
							approval_email = "<?= $head_group['email']?>";
						}
						else if (('<?echo $this_group?>' == 'CONSULTANT')&&
							('<?echo $this_division?>' == 'CONSULTANT')){
							document.getElementById("div_app").value  = "<?= $director['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $director['id']?>";
							approval_email = "<?= $director['email']?>";
						}
						else if (('<?echo $depth['depth']?>' == '2')&&
							(('<?echo $this_group?>' == 'OPERATION') || ('<?echo $this_group?>' == 'BD'))){
							document.getElementById("div_app").value  = "<?= $director['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $director['id']?>";
							approval_email = "<?= $director['email']?>";
						}
						else if ('<?echo $depth['depth']?>' == '1'){
							document.getElementById("div_app").value  = "<?= $approval_dir['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $approval_dir['id']?>";
							approval_email = "<?= $approval_dir['email']?>";
						}
						else {
							document.getElementById("div_app").value  = "<?= $head_div['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $head_div['id']?>";
							approval_email = "<?= $head_div['email']?>";
						}	
					}
					else if ($('#cl-cctype').val() == '2'){	
						
							document.getElementById("div_app").value  = "<?= $app_project['name']?>";
							document.getElementById("div_app_hd").value  = "<?= $app_project['id']?>";
							approval_email = "<?= $app_project['email']?>";
						
					}
					else{
							document.getElementById("div_app").value  = "-";
							document.getElementById("div_app_hd").value  = "-";
							approval_email = "-";}
							
				}
			});
		});
		$("#div_cc_cl").change(function(){
			var code = $("#cl-cc").val();
			$.ajax({
				url: "c_oas024/getDivCC",
				data: "code="+code,
				cache: false,
				success: function(msg)
				{
					$('#div_cc_div').show();
					show_submit_claim();
					$("#div_cc").html(msg);
					chargecode_val = $('#cl-cc').val() ;
					tipesubmit = '2';
					
					if (($('#cl-amount').val() != '') && ($('#receipt_date_claim_form').val() != '')){
						$('#claim-submit-btn').show();
					}
					else{
						show_submit_claim();
					}
					
					
				}
			});		
		});
		
});
</script>

<!-- daterange picker -->
<link href="<?php echo css_url();?>daterangepicker/daterangepicker-bs3new.css" rel="stylesheet" type="text/css" /> 


<div class="row">
    <div class="col-md-11">
		<div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">Claim Request Form</h3>
            </div>
            <div class="box-body">
                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?php echo $this_name?>">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $this_email?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Group / Division </label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?= $this_group ?>/<?echo $this_division?>">
                        </div>
                    </div>
                   
                </div> <!-- /.requester-detail -->

              <div class="requester-input form-section-container input-section">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Receipt Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input style="text-align: left; width: 175px" type="text" class="form-control holo" id="receipt_date_claim_form">
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->		
					<div class="form-group">
                        <label class="col-sm-3 control-label">Claim Type</label>
						<select id="list_cl_type">
							<option style="display: none;" value=""> --choose one---</option>
							 <?php foreach ($list_claim_type as $key => $type) { ?>
							 <option value="<?=$type['id']?>"><?= $type['name'] ?></option>
							
                        <?php } ?> 
						</select>      
						<Span id="claim1">	</Span>
						<Span id="claim1s">	</Span>
                    </div>
					 <div class="form-group" id="div_typecc_cl">
						<label class="col-sm-3 control-label">Charge Code Type</label>
						<div class="input-group">
							<select  id="cl-cctype">
								<option style="display: none;" value=""> --choose one---</option>
							<?php foreach ($charge_code_type as $key => $type) { ?>
								<option value="<?=$type['id']?>"><?= $type['value'] ?></option>
							<?php } ?>
							</select> 
						</div>
					</div>
					 <div class="form-group" id="div_cc_cl">
						<label class="col-sm-3 control-label">Charge Code </label>
						<div class="input-group">
							<span id="ccCL_list"></span>
						</div>
					</div>
					<div class="form-group" id="div_cc_div">
						<label class="col-sm-3 control-label">Division Charge Code </label>
						<div class="input-group">
							<span id="div_cc"></span>
						</div>
					</div>
					
					<div class="form-group" hidden>
                        <label class="col-sm-3 control-label">Approval Name :</label>
                        <div class="input-group" >
							<input type="text" readonly id="div_app"class="form-control holo" >
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					<div class="form-group" hidden>
                        <label class="col-sm-3 control-label">Approval:</label>
                        <div class="input-group" >
							<input type="text" readonly id="div_app_hd">
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					<!-- nilai amount untuk di save ke database -->
					<div class="form-group" hidden>
                        <div class="input-group">
                            <input type="text" style="text-align: left; width: 175px" class="form-control holo" id="cl-amountSave" >
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					<div class="form-group">
                        <label class="col-sm-3 control-label">Amount:</label>
                        <div class="input-group">
							<div class="input-group-addon">
								Rp. 
							</div>
                            <input type="text" style="text-align: left; width: 175px" onkeyup="digitsOnly(this, '.')"  onchange="digitsOnly(this, '.')"class="form-control holo" id="cl-amount" >
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<center>
					<span id="cl-result"  style="color:red;text-align:center"><br />
					</span></center>
					
					<div class="form-group"  hidden>				
                        <div class="input-group">   
                           <input type="text"style="text-align: left; width: 175px" id="cl-limit" readonly class="form-control holo" >
                        </div><!-- /.input group -->
                    </div>
					<div class="form-group" id="div_limitCL" >
                        <label class="col-sm-3 control-label">Limit Claim:</label>					
                        <div class="input-group">
							<div class="input-group-addon">
								Rp. 
							</div>                            
                           <input type="text"style="text-align: left; width: 175px" id="cl-limitRp" readonly class="form-control holo" >
                        </div><!-- /.input group -->
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="5" cols="100" id="remarks_claim" rows="3"  input="textarea" ></textarea>
                        </div>
                    </div>
					
					<div class="form-group">
                        <div class="input-group">
							<input type="hidden" id="monthReceipt" readonly class="form-control holo" >
							
                        
                           <input type="hidden" id="thisMonth" readonly class="form-control holo" >
						   <input  type="hidden"id="yearReceipt" readonly class="form-control holo" >
                        </div><!-- /.input group -->
                    </div>					
                </div> <!-- /.requester-input -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <?php if(!$edit) { ?>
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas021/load_view')">Back...</button>
                <?php }else{ ?>
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas022/load_view')">Back...</button>
                <?php } ?>
                <button type="submit" class="pull-right btn btn-primary" id="claim-submit-btn">
                     Submit
                </button>
            </div>
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
var receiptDateCL = null;	
var getMonthReceiptCL = null;
var hasil = null;
<?php $bulan = date('m')?>;
var nik ='<?= $this_id ?>';

$('#claim1').hide();
$('#div_typecc_cl').hide();
$('#div_cc_cl').hide();
$('#div_cc_div').hide();
$('#claim-submit-btn').hide();
$('#div_limitCL').hide();
$('#cl-result').hide();

function convertToRupiah(angka){
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return rupiah.split('',rupiah.length-1).reverse().join('');
}
function rupiah(){
    var nominal= document.getElementById("cl-amount").value;
    var rupiah = convertToRupiah(nominal);
    document.getElementById("cl-amount").value = rupiah;
}


function limit_rupiah(){
    var nominal= document.getElementById("cl-limit").value;
    var rupiah = convertToRupiah(nominal);
    document.getElementById("cl-limitRp").value = rupiah;
	$('#cl-result').hide();
}

// tampilin button submit kalau fieldnya dah keisi semua	
	function show_submit_claim(){
		if ( ($('#receipt_date_claim_form').val() != '') && ($('#cl-amount').val() != '')
			&& ((($('#catCL').val() == '2') && ($('#cl-cc').val() != '')) || ($('#catCL').val() == '1')) ) {
				$('#claim-submit-btn').show();
			
			
		}
		else{
			$('#claim-submit-btn').hide();
		}
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

		 document.getElementById("cl-amountSave").value = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($('#cl-amount').val()))));
		hasil = (($('#cl-limit').val()) - (document.getElementById("cl-amountSave").value));
		show_submit_claim();
		if($('#catCL').val() == 1){
			
			if ($('#receipt_date_claim_form').val() == '') {
				document.getElementById('cl-result').innerHTML = "please input receipt date";
				$('#cl-result').show();
				$('#claim-submit-btn').hide();
			}
			else if ($('#receipt_date_claim_form').val() != '') {
				if (hasil < 0 ){
					document.getElementById('cl-result').innerHTML = "sorry you exceed your limit";
					$('#cl-result').show();
					$('#claim-submit-btn').hide();
				}
				else {
					document.getElementById('cl-result').innerHTML = "";
					$('#cl-result').hide();
				}
			}
		}
		else{
			document.getElementById('cl-result').innerHTML = "";
			$('#cl-result').hide();
		}
		
	}
	
	function getSisa(){
	
	if ($('#receipt_date_claim_form').val() != '') {
		
		if ((($('#list_cl_type').val() == 9))&& ($('#medical_list').val != '')){
			document.getElementById("cl-amount").value = "";
			$('#div_limitCL').show();
			var code = $("#list_cl_type").val();
			var child = $('#medical_list').val();
			var year_kw = $('#yearReceipt').val();
			$.ajax({
				url: "c_oas024/getAmount",
				data: {"code":code,"child":child,"year_kw":year_kw},
				cache: false,
				success: function(msg)
				{	
					document.getElementById("cl-limitRp").value ="<?= $bantu['amount']?>";
					$("#claim1s").html(msg);
					$('#claim1s').show();
					document.getElementById("cl-limit").value = $('#bantuan').val();
					limit_rupiah();	
					claimTypeId = $("#medical_list").val();					
				}	
			});		
		}
		else if (($('#list_cl_type').val() == '1') || ($('#list_cl_type').val() == '2') || ($('#list_cl_type').val() == '3')){
		
			var code = $("#list_cl_type").val();
			var child = $('#medical_list').val();
			var month_kw = $('#monthReceipt').val();
			var year_kw = $('#yearReceipt').val();
							$.ajax({
								url: "c_oas024/getTunjangan",
								data: {"code":code,"child":child,"month_kw":month_kw,"year_kw":year_kw},
								cache: false,
								success: function(msg)
								{
									document.getElementById("cl-limitRp").value ="<?= $tnj['amount']?>";
									$("#claim1s").html(msg);
									$('#claim1s').show();
									document.getElementById("cl-limit").value = $('#hd_tunjangan').val();
									limit_rupiah();
								}	
							});
		}
		else {
		document.getElementById("cl-limit").value = "";}
	}
	else{
		$('#div_limitCL').hide();
	}
}
	
 $(function() {
	
	$('#receipt_date_claim_form').datepick({
		
		dateFormat: 'dd MMMM yyyy',
		maxDate: "+0D" ,
		minDate:"-2M",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			receiptDateCL = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+receiptDateCL);
			getMonthReceiptCL = moment(dates[0]).format('MM');
			ambilbulan = moment(dates[0]).format('MM');
			ambilTahun = moment(dates[0]).format('YYYY');
			thisMonth.value = "<?=$bulan?>";
			monthReceipt.value = ambilbulan;
			yearReceipt.value = ambilTahun;
			document.getElementById('cl-result').innerHTML = "";
			$('#cl-result').hide();
			document.getElementById("cl-amount").value = "";
			getSisa();
			show_submit_claim()
		},
	});  
	// submit button
	$('#claim-submit-btn').on('click', function(){
		var form_data = {
			employeeId      	: nik,
			tanggalKwitansi		: receiptDateCL,
			claimTypeId			: claimTypeId ,
			chargeCode			: chargecode_val,
			total				: $('#cl-amountSave').val(),
			keterangan			: $('#remarks_claim').val(),
			submittedDate   	: moment().format('YYYY-MM-DD'),
			approval			: $('#div_app_hd').val(),
			approval_name		: $('#div_app').val(),
			approval_email		: approval_email,
			ajax				: tipesubmit
			
		   
		}; 
		console.log(form_data);

		$.ajax({
			url: "c_oas024/submit_form",
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				alert("Submit Success");
				location.reload();
			},
			error: function(){                      
				$( "#claim-sbmt-msg" ).html("Terjadi kesalahan dalam menghubungi server.");
				console.log('eror');
			}
		});
    });

});
 </script> 

