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
* Creation Date    : 12-02-2015 08:05:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.number.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui-1.10.3.min"></script>
<script type="text/javascript" src="assets/js/jquery.form.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	//no ref select	
	
	
	$("#PO_noRef").change(function(){
		var code = $("#PO_noRef").val();
		
		munculkan_aku();
		ambil_curs();
		ambil_rm();
		ambil_shipto();
		ambil_vendor();
		
			$.ajax({
			url: "c_oas075/get_noref",
			data: "code="+code,
			cache: false,
			success: function(msg)
			
				{
				$("#po").html(msg);
				$('#po').show();
				document.getElementById("currs").value = $('#select_curs').val();
				document.getElementById("pr_id").value = $('#select_prid').val();
				document.getElementById("rm").value = $('#select_rm').val();
				document.getElementById("employ").value = $('#select_employ').val();
				document.getElementById("amount").value = $('#select_amount').val();
				document.getElementById("company").value = $('#select_stcomp').val();
				document.getElementById("cp").value = $('#select_stcp').val();
				document.getElementById("add").value = $('#select_stadd').val();
				document.getElementById("phone").value = $('#select_sttelp').val();
				document.getElementById("email").value = $('#select_stemail').val();
				document.getElementById("npwp").value = $('#select_stnpwp').val();
				document.getElementById("companyvendor").value = $('#select_vcomp').val();
				document.getElementById("attnvendor").value = $('#select_vattn').val();
				document.getElementById("addressvendor").value = $('#select_vadd').val();
				document.getElementById("cityvendor").value = $('#select_vcity').val();
				document.getElementById("phonevendor").value = $('#select_vphone').val();
				document.getElementById("zipvendor").value = $('#select_vzip').val();
				document.getElementById("faxvendor").value = $('#select_vfax').val();
				}
			});
	});
	});
	

$('#po-form-submit-btn').hide();
$('#hidetable').hide();
$('#hidecurs').hide();
$('#hideremark').hide();
$('#hideppn').hide();
$('#hidetotalppn').hide();
show_submit_po();		

//sembunyikan sebelum pilih no_ref

var url = "<?php echo site_url('c_oas075/submit_form')?>";


var employid='<?= $this_id ?>';


function munculkan_aku(){
$('#hidecurs').show();
$('#hidetable').show();
$('#hideremark').show();
$('#hideppn').show();
$('#hidetotalppn').show();
}

function ambil_curs(){
var select_curs = $("#select_curs").val();
var select_prid = $("#select_prid").val();
var select_amount = $("#select_amount").val();
var isi_curs = document.getElementById("hidecurs");
var isi_prid = document.getElementById("hideprid");
var isi_amount = document.getElementById("hideamount");
isi_prid.value = select_prid;
isi_curs.value = select_curs;
isi_amount.value = select_amount;

}

function ambil_shipto(){
var select_comp = $("#select_stcomp").val();
var select_address = $("#select_stadd").val();
var select_cp = $("#select_stcp").val();
var select_telp = $("#select_sttelp").val();
var select_email = $("#select_stemail").val();
var select_npwp = $("#select_stnpwp").val();

var isi_comp = document.getElementById("company");
var isi_add = document.getElementById("add");
var isi_cp = document.getElementById("cp");
var isi_telp = document.getElementById("phone");
var isi_email = document.getElementById("email");
var isi_npwp = document.getElementById("npwp");

isi_comp.value = select_comp;
isi_add.value = select_address;
isi_cp.value = select_cp;
isi_telp.value = select_telp;
isi_email.value = select_email;
isi_npwp.value = select_npwp;
}

function ambil_vendor(){
var select_vcomp = $("#select_vcomp").val();
var select_vattn = $("#select_vattn").val();
var select_vadd = $("#select_vadd").val();
var select_vcity = $("#select_vcity").val();
var select_vphone = $("#select_vphone").val();
var select_vzip = $("#select_vzip").val();
var select_vfax = $("#select_vfax").val();

var isi_vcomp = document.getElementById("companyvendor");
var isi_vattn = document.getElementById("attnvendor");
var isi_vadd = document.getElementById("addressvendor");
var isi_vcity = document.getElementById("cityvendor");
var isi_vphone = document.getElementById("phonevendor");
var isi_vzip = document.getElementById("zipvendor");
var isi_vfax = document.getElementById("faxvendor");

isi_vcomp.value = select_vcomp;
isi_vattn.value = select_vattn;
isi_vadd.value = select_vadd;
isi_vcity.value = select_vcity;
isi_vphone.value = select_vphone;
isi_vzip.value = select_vzip;
isi_vfax.value = select_vfax;
}	

function ambil_rm(){
var select_rm = $("#select_rm").val();
var select_employ = $("#select_employ").val();
var isi_rm = document.getElementById("hiderm");
var isi_employ = document.getElementById("hideemploy");
isi_rm.value = select_rm;
isi_employ.value = select_employ;
}

//function membersihkan tanda titik di field amount
function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}


//sini
function ppn(){
			var subtotal = $("#select_cuptotal").val();
			total_ppn = ((10*subtotal)/100);
		document.getElementById("totalppn").value = total_ppn;
		nilai_total = parseInt(subtotal) + parseInt(total_ppn);
		document.getElementById("nilaitotal").value = nilai_total;
		$("#totalppn").number(true, 2);
		$("#nilaitotal").number(true, 2);
		

}

$(function() {
$("input:radio[id=pajak]").on('click', function(){
            pajak = $(this).val();
			if (pajak==1){
			
			ppn();
			
			//change
		
				}
		else{
		document.getElementById('totalppn').value = 0;
		document.getElementById('nilaitotal').value = $("#select_cuptotal").val();
		$("#nilaitotal").number(true, 2);
		}
        });

     $('#po-form-submit-btn').on('click', function(){
	 var totalppn = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('totalppn').value))))); 
	var nilaitotal = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('nilaitotal').value))))); 
	
	 var form_data = {
		
			amount				: $('#amount').val(),			
			prid				: $('#pr_id').val(),
			pur_id				: "<?= $detail_pur['id']?>",
			pur_name			: "<?= $detail_pur['name']?>",
			pur_email			: "<?= $detail_pur['email']?>",
			employeeid			: employid,
			vcompany    		: $('#companyvendor').val(),
			vattn				: $('#attnvendor').val(),
			vaddress 		    : $('#addressvendor').val(),
			vcity   			: $('#cityvendor').val(),
			vphone    			: $('#phonevendor').val(),
			vzip    			: $('#zipvendor').val(),
			vfax				: $('#faxvendor').val(),
			stcompany 		    : $('#company').val(),
			stcp   				: $('#cp').val(),
			staddress    		: $('#add').val(),
			stmphone    		: $('#phone').val(),
			stemail				: $('#email').val(),
			stnpwp				: $('#npwp').val(),
			po_remarks			: $('#po_remarks').val(),
			ppn					: $('#totalppn').val(),
			amounttotal			: $('#nilaitotal').val(),
			ajax				: 1  
		}; 
		
		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				alert("Form submitted successfully");
				location.reload();
				
			},
			error: function(){                      
				$( "#new-expense-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
		
		
    });
 });
	// tampilin button submit kalau fieldnya dah keisi semua	
	function show_submit_po(){
		if ( ($('#company').val() != '') && ($('#cp').val() != '')
			&& ($('#phone').val() != '')) {
				$('#po-form-submit-btn').show();	
		}
		else{
			$('#po-form-submit-btn').hide();
		}
	}
	
	$(function(){
		
	});
	
</script>

<div class="box box-solid box-danger">
			
<div class="box-header">
<h3 class="box-title">Purchase Order Form</h3>
</div>
</div>

<div class="form-group">
					<label class="col-sm-2 control-label">Reference Number	:</label>
					<div class="input-group">
						<select  id="PO_noRef">
							<?php foreach ($refpr as $key => $type) { ?>
							<option style="display: none;" value=""> --- choose one --- </option>
							<option value="<?=$type['id']?>"><?= $type['no_ref'] ?></option>
							<?php } ?>
						</select> 
						</div>
					</div>  
				</div>
				
<div class="form-group" id = "hidecurs">
					<label class="col-sm-2 control-label" for="currency" align = "right" >Currency	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="currs" >
					</div>
				</div>				

				<div class="form-group" hidden id = "hiderm">
					<label class="col-sm-2 control-label" for="currency" align = "right" >RM	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="rm" >
					</div>
				</div>	
				
				<div class="form-group" hidden id = "hideemploy">
					<label class="col-sm-2 control-label" for="currency" align = "right" >Employee	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="employ" >
					</div>
				</div>	

<div class="form-group" hidden id = "hiderefno">
					<label class="col-sm-2 control-label" for="currency" align = "right" >Ref No	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="refno" >
					</div>
				</div>

<div class="form-group" hidden id = "hideamount">
					<label class="col-sm-2 control-label" for="currency" align = "right" >Amount	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="amount" >
					</div>
				</div>
				
				<div class="form-group" hidden id = "hideprid">
					<label class="col-sm-2 control-label" for="currency" align = "right" >PR ID	:</label>
					<div class="input-group">
						<input readonly type="text" class="form-control holo" id="pr_id" >
					</div>
				</div>
				
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
                <h4 class="box-title">Vendor</h4>
            </div>
			<div class="box-body">
			<div class="requester-detail form-section-container">
			
			
<div class="form-group"  id = "hidestcomp">
                <label class="col-sm-4 control-label" for="company">Company</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" name="comp" style="text-align: left;"  id="company" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>
			
<div class="form-group"  id = "hidestcp" >
                <label class="col-sm-4 control-label" for="cp">Contact Person</label>
                <div class="input-group">
				
                    <input type="text" readonly class="form-control holo" name="cp" style="text-align: left;"  id="cp"  onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>	

<div class="form-group"  id = "hidestadd">
                <label class="col-sm-4 control-label" for="add">Address</label>
                <div class="input-group">
				
                    <input type="text" readonly class="form-control holo" name="add" style="text-align: left;"  id="add" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>	

<div class="form-group"  id = "hidesttelp">
                <label class="col-sm-4 control-label" for="phone">Phone</label>
                <div class="input-group">
				
                    <input type="text" readonly class="form-control holo" name="phone" style="text-align: left;"  id="phone"  onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>			
			
<div class="form-group"  id = "hidestemail">
                <label class="col-sm-4 control-label" for="email">Email</label>
                <div class="input-group">
				
                    <input type="text" readonly class="form-control holo" name="email" style="text-align: left;"  id="email" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>
			
<div class="form-group"  id = "hidestnpwp" >
                <label class="col-sm-4 control-label" for="email">NPWP</label>
                <div class="input-group">
				
                    <input type="text" readonly class="form-control holo" name="npwp" style="text-align: left;"  id="npwp" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>			
		</div>
        </div>
		</div>
		</div>
		
<?//form ship to?>	
<table>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
			<div class="form-group" >
                <label class="col-sm-4 control-label" for="company"><h4 class="box-title">Ship To</h4></label>
            </div>
			</div>
            <div class="box-body">
                <div class="requester-detail form-section-container">


<?//form vendor?>

<div class="form-group" >
                <label class="col-sm-4 control-label" for="companyship">Company : </label>
                <div class="input-group">	
				<input type="text" readonly class="form-control" name = "vcomp" id="companyvendor"  onkeyup="show_submit_po()" onchange = "show_submit_po()">
                 </div>
            </div>			
				
<div class="form-group" >
                <label class="col-sm-4 control-label" for="att">Attention : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name="vattn" id="attnvendor"  onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>

<div class="form-group" >
                <label class="col-sm-4 control-label" for="addr">Address : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name="vadd" id="addressvendor" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>

<div class="form-group" >
                <label class="col-sm-4 control-label" for="citypo">City   : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name="vcity" id="cityvendor" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>			
			
			<div class="form-group" >
                <label class="col-sm-4 control-label" for="phone">Phone   : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name = "vphone" id="phonevendor" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>
			
<div class="form-group" >
                <label class="col-sm-4 control-label" for="zippo">ZIP : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name="vzip" id="zipvendor" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>			
			
<div class="form-group" >
                <label class="col-sm-4 control-label" for="faxpo">Fax : </label>
                <div class="input-group">
				<input type="text" readonly class="form-control" name="vfax" id="faxvendor" onkeyup="show_submit_po()" onchange = "show_submit_po()">
                </div>
            </div>				</div>	
				</div>
				</div>
				</div>
				</div>
				</div>
				</table>
				<Span id="po"></span>
				<table >
			   <colgroup>
				<col width="2%">
				<col width="5%">
				<col width="5%">
				<col width="10%">
				<col width="5%">
				<col width="10%">
				</colgroup>
			   <tbody hidden id = "hidetotalppn">
			   <tr>
				<td align="right" colspan="3.8" ><b>PPN 10%</b></td>
				<td align="right"><input type="text" class="form-control" id="totalppn" placeholder="totalperitem" ></input></td>
			  </tr>
			  <tr>
				<td align="right" colspan="3.8" ><b>Sub Total</b></td>
				<td align="right"><input type="text" class="form-control" id="nilaitotal" placeholder="totalperitem"></input></td>
			  </tr>
			  </tbody>
			  </table>
				<br>
				</br>
<div class="approval-detail form-section-container">
	<div class="form-group" hidden id = "hideppn">
        <label class="col-sm-4 control-label">Gunakan Pajak</label>
            <div class="input-group" >
                <input type="radio" id="pajak" onkeyup="show_submit_po()" onchange = "show_submit_po()" name = "ppn" value='1' >Yes
				<td><input type="radio" id="pajak" onkeyup="show_submit_po()" onchange = "show_submit_po()" name = "ppn" value='0'>No</td>
						</div>
    </div>
	
	<div class="form-group" id="hideremark">
					<label class="col-sm-3 control-label">Remarks:</label>
					<div class="input-group">
						<textarea class="form-control" rows="5" cols="100" id="po_remarks" input="textarea" onkeyup="show_submit_po()" onchange = "show_submit_po()"> </textarea>
					</div>
				</div>	
	<div class="box-footer clearfix"></div>
                <button type="button" class="pull-left btn btn-default"  align = "right" onclick="change_page(this, 'c_oas072/load_view')">Back...</button>
				<button type="submit" class="pull-right btn btn-primary" id="po-form-submit-btn" align = "left"> Submit
                   </button> <div class="pull-right" id="po-sbmt-msg"></div>
<div class="form-group">



