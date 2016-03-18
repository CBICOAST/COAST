<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History : 
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS070
* Program Name     : Form Pengajuan Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 11-02-2014 13:00:00 ICT 2014
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
<!-- daterange picker -->
<link href="<?php echo css_url();?>daterangepicker/daterangepicker-bs3new.css" rel="stylesheet" type="text/css" /> 



<div class="row">
    <div class="col-md-11">
		<div class="box box-solid box-danger">
			<div class="box-header">
                <h3 class="box-title"> Purchase Request </h3>
            </div>
            <div class="box-body">
                <div class="requester-detail form-section-container">
				
				<div class="form-group" hidden>
                        <label class="col-sm-3 control-label">PR ID</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="PR_ID"value="<?=$idPR?>" >
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?=$this_name?> <?php if($edit) echo $form_data['idemp'] ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label" for="exampleNIK">NIK</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleNIK" value="<?=$this_id?> <?php if($edit) echo $form_data['employee_id'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?=$this_email?> <?php if($edit) echo $form_data['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?=$this_group?> <?php if($edit) echo $form_data['groupid'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterDivision">Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterDivision" placeholder="Divisi" value="<?=$this_division?> <?php if($edit) echo $form_data['divid'] ?>">
                        </div>
                    </div>			


                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterRM">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterRM" placeholder="Atasan" value="<?= $this_rm['name'] ?>">
                        </div>
                    </div> 
                   
                </div> <!-- /.requester-detail -->
				 <div class="requester-detail form-section-container">
				<table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="5%">
			<col width="10%">
			<col width="15%">
			<col width="10%">
			<col width="15%">
			<col width="15%">
			<col width="25%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="8" align="center">LIST PURCHASE</td>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Description*</th>
				<th class="text-center">Product Name</th>
				<th class="text-center">QTY*</th>
				<th class="text-center">unit of material(UOM)*</th>
				<th class="text-center">Unit Price*</th>
				<th class="text-center">Total*</th>
				
				<th class="text-center">.::.
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			$total1 = 0;
			$total2 = 0;
			if(isset($list_pr)){
			foreach ($list_pr as $key => $value) { 
				$no++;?>
				<tr >
					<td align="center"><?= $no ?></td>				
					<td align="center"><?echo $value['nama']; ?></td>
					<td align="right"><? echo $value['keterangan']; ?></td>
					<td align="center"><?= $value['qty']?></td>
					<td align="center"><?= $value['satuan'] ?></td>	
					<td align="right"><?echo number_format($value['harga'],0,',','.'); ?></td>
					<td align="right"><? echo number_format($value['total'],0,',','.'); ?></td>
					
					
					<? $total1 += $value['total'];?>
					
					
					<td align="center">	
						<a href="#" rel="detail" class="opt delete" title="Delete Item" id ="delete-item" onclick="change_page(this, 'c_oas070/del_item/<?= $value['no'] ?>')"></a>
					</td>					
				</tr>
			<?php }?>
			<tr >
					<td> </td>
					<td><select  id="description" onchange="satuan()">
							<?php foreach ($item as $key => $type) { ?>
							<option style="display: none;" >--choose one---</option>
							<option value="<?=$type['descript']?>"><?= $type['descript'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="keterangan" placeholder="product name" ></input></td>
					<td><input type="text" id="qty" class="form-control" onkeyup="formatAngka(this, '.')" placeholder="00" ></input></td>
					<td><input type="text" id="item" class="form-control" readonly placeholder="item" ></input></td>
					<td align="right"><input type="text" class="form-control" onkeyup="formatAngka(this, '.')" id="price" placeholder="price" ></input></td>
					<td align="right"><input type="text" class="form-control" id="totalit" placeholder="totalperitem" readonly></input></td>
					
					
					<td align="center"><div>
					<div class="pull-center" id="new-pr-msg"></div>
    	<button class="btn-primary" id="sbmt-new-pritem" type="submit">ADD</button></div>
    </td>	
				</tr>
				<tr>
				<td align="right" colspan="5"><b>TOTAL</b></td>
				<td align="right"  colspan="1"><b><input hidden readonly id="totalsemuaitem" value="<?php echo number_format($total1,0,',','.'); ?>"></b><?php echo number_format($total1,0,',','.'); ?></td>
				<td ></td>
				<td ></td>
			</tr>
			<tr>
					<td align="right" colspan="6"></td>
			</tr><?
			 }else{
			?>
			<tr >
					<td> </td>
					<td><select  id="description" onchange="satuan()">
							<?php foreach ($item as $key => $type) { ?>
							<option style="display: none;" >--choose one---</option>
							<option value="<?=$type['descript']?>"><?= $type['descript'] ?></option>
							<?php } ?>
						</select></td>
					<td align="right"><input type="text" class="form-control" id="keterangan" placeholder="product name" ></input></td>
					<td><input type="text" id="qty" class="form-control" onkeyup="formatAngka(this, '.')" placeholder="00" ></input></td>
					<td><input type="text" readonly id="item" class="form-control"  placeholder="item" ></input></td>
					<td align="right"><input type="text" class="form-control" onkeyup="formatAngka(this, '.')" id="price" placeholder="price" ></input></td>
					<td align="right"><input readonly type="text" class="form-control" onkeyup="formatAngka(this, '.')" id="totalit" placeholder="totalperitem" ></input></td>
					
					
					<td align="center"><div>
					<div class="pull-left" id="new-pr-msg"></div>
    	<button class="btn-primary" id="sbmt-new-pritem" type="submit">ADD</button></div>
    </td>	
				</tr>
			<?php } ?>			
		</tbody>
	</table>
				</div>
				<div class="requester-input form-section-container input-section">
				
				<div class="form-group" >
					<label class="col-sm-3 control-label">Currency:</label>
					<div class="input-group">
					
						<select  id="btr_currency">
							<?php foreach ($currency as $key => $type) { ?>
							<option value="<?=$type['id']?>"><?= $type['name'] ?></option>
							<?php } ?>
						</select> 
					</div><!-- /.input group -->
				</div><!-- /.form group -->
								
				<div class="form-group" id="typecc">
					<label class="col-sm-3 control-label">Charge Code Type*</label>
					<div class="input-group">
						<select  id="btr-cctype">
							<option style="display: none;" value="">--choose one---</option>
							<?php foreach ($list_cctype as $key => $type) { ?>
							<option value="<?=$type['id']?>"<?php if ($edit && $cctypeid == $type['id']) echo 'selected' ?>><?= $type['name'] ?></option>
							<?php } ?>
						</select> 
					</div>
				</div>
				<?php if (!$edit){?>
				
				<div class="form-group" id="btr-cchidden" >
					<label for="group" class="col-sm-3 control-label">Project Description*</label>
					<div class="input-group">
						<div id="btr">
						<input type="text" class="form-control holo" id="btr-cchidden" value="<?php if($edit) echo $form_data['projectdecsript'] ?>">
						</div>
					</div>
				</div> <?}if ($edit){?> <div class="form-group" >
                <label for="chargecode" class="col-sm-3 control-label">Project Description*</label>
                <div class="input-group">
						<div id="btr2" onchange="ccode()"><select id="CA_chargecode" >
						
						<?php if($edit){
                        foreach ($list_chargecode as $key => $cc) { ?>
                        <option value="<?= $cc['id'] ?>"
						<?php if($edit &&  $chargecodeid == $cc['id']) echo 'selected'?>><?= $cc['name'] ?></option>
                        <?php }
                        } ?>				
                    	</select></div>
					</div>
				</div> <?}?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Charge Code*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input readonly type="text" class="form-control holo" id="btr-chargecode" value="<?php if($edit) echo $form_data['cc'] ?>">
					</div><!-- /.input group -->          
				</div>
								
	<table class=" no-border-bottom" >
		<colgroup>
			<col width="2%">
			<col width="15%">
			<col width="8%">
			<col width="15%">
			<col width="25%">
			<col width="15%">
		</colgroup>
	<tbody>
			<tr> <th ></th>
			<td class="text-left"><b>Term of Payment*</b></td>
			<th class="text-center"></th>
			<th class="text-center">Date*</th>
			<th class="text-center">Amount*</th>
			<th class="text-center">Remark</th>
			<th ></th>
		</tr>
		<tr id="pembayaran1"><th ></th>
			<td class="text-left"><b>Down Payment</b></td>
			<td class="text-center"></td>
			<td class="text-center"><input type="text" id="tgl1" class="form-control holo"  ></input></td>
			<td class="text-right"><input  type="text" id="jmlp1" class="form-control holo" onkeyup="formatAngka(this, '.')"   ></input></td>
			<td colspan="3"  class="text-center"><input type="text" id="remarkp1" class="form-control holo"  ></input></td>
		</tr>
		<tr  id="pembayaran2"><th ></th>
			<td class="text-left"><b>2nd Instalament</b></td>
			<th class="text-center"></th>
			<th class="text-center"><input type="text" id="tgl2" class="form-control holo"  ></input></th>
			<th class="text-right"><input type="text" id="jmlp2" class="form-control holo" onkeyup="formatAngka(this, '.')"    ></input></th>
			<td colspan="3" class="text-center"><input type="text" id="remarkp2" class="form-control holo"  ></input></td>
		</tr>
			<tr  id="pembayaran3">
			<th ></th>
			<td class="text-left"><b>3rd Instalament</b></td>
			<th class="text-center"></th>
			<th align="center"><input type="text" id="tgl3" class="form-control holo" ></input></th>
			<th class="text-right"><input type="text" id="jmlp3" class="form-control holo" onkeyup="formatAngka(this, '.')"  ></input></th>
			<td colspan="3"  class="text-center"><input type="text" id="remarkp3" class="form-control holo"  ></input></td>
		</tr>
		<tr id="pembayaran4"><th ></th>
			<td class="text-left"><b>Final Payment</b></td>
			<th class="text-center"></th>
			<th class="text-center"><input type="text" id="tgl4" class="form-control holo" ></input></th>
			<th class="text-right"><input  type="text" id="jmlp4" class="form-control holo" onkeyup="formatAngka(this, '.')"  ></input></th>
			<td colspan="3"  class="text-center"><input type="text" id="remarkp4" class="form-control holo"  ></input></td>
		</tr>
		<tr><th ></th>
			<td colspan="3" align="left"><b>Total</b></td>
			<td align="left"><input type="text" readonly class="form-control holo" value="<?= number_format(($form_detail['amount']),0,',','.') ?>" onkeyup="formatAngka(this, '.')" id="total" ></input>
			<center>
					<span id="samainhasil"  style="color:red;text-align:center"><br />
					</span></center>
			</td>
			<th ></th>
		</tr>
		</tbody>
		</table>
		<div class="form-group">
                <label for="b_status" class="col-sm-3 control-label">Supporting Document*  </label>
                <div class="input-group">
                    <div>
				<form action='c_oas070/do_upload' method="post" enctype="multipart/form-data" id="MyUploadForm">
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
			   					
		<div class="form-group">
                <label for="b_status" class="col-sm-3 control-label">Payment Methode* </label>
                <div class="input-group">
                    <input type="radio" name="b_status" value='1'>Cash
        &nbsp;&nbsp;<input type="radio" name="b_status" value='2'>Transfer
                </div>
        </div>
			
		<div class="form-group">
                <label for="user_status" class="col-sm-3 control-label">Need To be Created PO*</label>
                <div class="input-group">
                    <input type="radio" onclick="munculkan_aku()" name="user_status" value='1'>Yes
        &nbsp;&nbsp;<input type="radio" onclick="sembunyikan_aku()" name="user_status" value='0'>No
		
		<br></br>
                </div>
				
        </div>			
	
			
	
		<!-- .Isian untuk finance - input -->		
	<div class="requester-detail form-section-container" id="hidefinance">
	<h4><b><u> Detail Information To Finance Departement</u></b></h4>
	<table class=" no-border-bottom">
		<colgroup>
			<col width="10%">
			<col width="15%">
			<col width="8%">
			<col width="15%">
			<col width="25%">
			<col width="15%">
		</colgroup>
	<tbody>
	<span id="tes"></span>
		<tr>
			<td class="text-left"><h4><b>Ship To</b></h4></td>
			<td class="text-right">Company :</td>
			<th colspan="2" class="text-left"><input type="text"  id="comp_ship" class="form-control holo" onkeyup="showButton()"></th>
			
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Attention :</td>
		<th colspan="2" class="text-left"><input type="text"  id="attn_ship" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Address :</td>
		<th colspan="2" class="text-left"><input type="text"  id="add_ship" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">City :</td>
		<th colspan="2" class="text-left"><input type="text"  id="city_ship" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Phone :</td>
		<th colspan="2" class="text-left"><input type="text" onkeyup="digitsOnly(this)" pattern="[a-zA-Z-0-9-+]+" id="phone_ship" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">ZIP :</td>
		<th colspan="2" class="text-left"><input type="text" onkeyup="digitsOnly(this)" id="zip" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Fax :</td>
		<th colspan="2" class="text-left"><input type="text" onkeyup="digitsOnly(this)" pattern="[a-zA-Z-0-9-+]+" id="fax" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		
		
		
		<tr> <th ></th>
		<span id="shipcomp"></span>
		<tr>
			<td class="text-left"><h4><b>Vendor</b></h4></td>
			<td class="text-right">Company :</td>
			<th colspan="2" class="text-left"><input type="text"  id="comp_vendor" class="form-control holo" onkeyup="showButton()"></th>
			<span id="tes"></span>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Address :</td>
		<th colspan="2" class="text-left"><input type="text"  id="add_vendor" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">CP :</td>
		<th colspan="2" class="text-left"><input type="text"  id="cp" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Phone :</td>
		<th colspan="2" class="text-left"><input type="text" onkeyup="digitsOnly(this)" id="phone_vendor" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">Email :</td>
		<th colspan="2" class="text-left"><input type="text"  id="email_vendor" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
		
		<tr>
		<td></td>
		<td class="text-right">NPWP :</td>
		<th colspan="2" class="text-left"><input type="text"  id="npwp" class="form-control holo" onkeyup="showButton()"></th>
		</tr>
			<th ></th>
		</tr>
		
		
		<tr>
			<td class="text-left"><b>Quotation No :</b></td>
			
			<th colspan="2" class="text-left"><input type="text"  id="quot_no" class="form-control holo" onkeyup="showButton()"></th>
			<th ></th>
			
		</tr>
		
		

		<tr><td>
				&nbsp;
			</td>
		</tr>
	</tbody>
</table>
</div>
<!-- ./Isian untuk finance - Input -->
	
	

	<div class="form-group">
					<label class="col-sm-3 control-label">Remarks:</label>
					<div class="input-group">
						<textarea class="form-control" rows="5" cols="100" id="btr_remarks" rows="3"  input="textarea" value="<?php if($edit) echo $form_data['remark'] ?>"></textarea>
					</div>
	<label class="col-sm-3 control-label">Note:</label>
	<code><label class="col-sm-3 control-label">    </label></code>
	</div>
	<div>
	<code><label class="col-sm-3 control-label">Fill the required fields,especially field with * sign</label></code>
	</div>
			</div> <!-- /.requester-input -->	
		</div><!-- /.box-body -->
		
		<div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas070/load_view')">Back...</button>
			<button type="submit" class="pull-right btn btn-primary" id="form-submit-btn-pr"> Submit </button>
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

// sembunyikan dulu sebelum yang harus diisi nya keisi semua
$('#form-submit-btn-pr').hide();
$('#sbmt-new-pritem').hide();
$('#pembayaran2').hide();
$('#pembayaran3').hide();
$('#pembayaran4').hide();
var edit = 0;
var employeeid = null;
var formId = null;
var total_1 = "<?php echo $total1; ?>";;
var employeeRM = null;
var employeeRM_email = "<?= $this_rm['email'] ?>";
var employeeRM_name = "<?= $this_rm['name'] ?>";
var cc = null;
var b_status		= null;
var user_status = null;
var tgl1			= null;
var tgl2			= null;
var tgl3			= null;
var tgl4			= null;
var this_id = "<?php echo $form_detail['pr_id'];?>";
$('#btr-cchidden').hide();
$('#hidefinance').hide();
var jmlp1 = 0;
var jmlp2 = 0;
var jmlp3 = 0;
var jmlp4 = 0;
url 	= "<?php echo site_url('c_oas070/submit_form'); ?>"
urlPR	= "<?php echo 'c_oas070/save_pr'; ?>";	
employeeRM = "<?= $this_rm['id'] ?>";
employeeRM_email = "<?= $this_rm['email'] ?>";
employeeRM_name = "<?= $this_rm['name'] ?>";	

 <?php if(!$edit) { ?> 
    employeeid = '<?= $this_id ?>';
 <?php } ?>

<?php if($edit) { ?>
    formId = "<?= $form_data['pr_id'] ?>";
	cc = "<?= $form_data['cc'] ?>";
	$('#form-submit-btn-pr').show();
 <?php } ?>
 
// Jika tanpa PO
function munculkan_aku(){
$('#hidefinance').show();
showButton();
}

// Jika dengan PO
function sembunyikan_aku(){
$('#hidefinance').hide();
showButton();
}
 
 //angka aja
  function digitsOnly(obj){
      obj.value=obj.value.replace(/[^\d]/g,''); 
    }
 
 
// tampilin button submit kalau fieldnya dah keisi semua
function showButton(){
var totalpayment = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('totalsemuaitem').value)))));
	// jika dengan PO
	if (($('#btr-chargecode').val() != '') &&(user_status =='1') && (($('#jmlp1').val() != '') ||($('#jmlp2').val() != '')||($('#jmlp3').val() != '')||($('#jmlp4').val() != ''))&&((document.getElementById('total').value) == totalpayment)&&((b_status=='1')||(b_status=='2'))
	&&($('#quot_no').val() != '')&&($('#vendor').val() != '0')&&($('#shipto').val() != '0')) {
		$('#form-submit-btn-pr').show();
	}
	// Jika tanpa PO
	else if (($('#btr-chargecode').val() != '') &&(user_status =='0') && (($('#jmlp1').val() != '') ||($('#jmlp2').val() != '')||($('#jmlp3').val() != '')||($('#jmlp4').val() != ''))&&((document.getElementById('total').value) == totalpayment)&&((b_status=='1')||(b_status=='2'))
	) {
		$('#form-submit-btn-pr').show();	
	}
	else{
		$('#form-submit-btn-pr').hide();
	}
}


// Untuk perhitungan input TOP sama dengan total pembayaran Item
function samakanaku(){
var totalpayment = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('totalsemuaitem').value)))));

hasil = (totalpayment -  (document.getElementById('total').value));
if ((document.getElementById('total').value) > totalpayment){
					document.getElementById('samainhasil').innerHTML = "sorry nominal you enter is not valid, please try again";
					$('#samainhasil').show();
					$('#form-submit-btn-pr').hide();	
				}
				else{document.getElementById('samainhasil').innerHTML = "r";
				$('#samainhasil').hide();
				}
}

function hitung(){
	totalall  =jmlp1+jmlp2+jmlp3+jmlp4;
	document.getElementById('total').value= totalall;
	samakanaku();	
}

function showButtonAdd(){
	
	if ((($('#description').val() != '')  && ($('#item').val() != '')) && (($('#price').val() != '') && ($('#qty').val() != ''))) {
		$('#sbmt-new-pritem').show();	
	}
	else {
		$('#sbmt-new-pritem').hide();
	}
}

function ccode()
{
	var charge_code = $("#CA_chargecode").val();
	var elem = document.getElementById("btr-chargecode");
	elem.value =charge_code;
	cc = $('#btr-chargecode').val() ;
}
	
	function satuan(){
		var description = $('#description').val();

		$.ajax({
			url: "c_oas070/get_satuan",
			data: "description="+description,
			cache: false,
			success: function(msg)
				{
				$("#item").html(msg);
				<?php if(!$edit) { ?>
				
				var item = document.getElementById("item");
				var satuan = $("#satuan").val();
				item.value =satuan;
				showButtonAdd();
				   <?php } ?>
			
				}
			});
	}
	
	
	
	
	
$( "#price" ).keyup(function() {

		var price = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('price').value))));
		var qty = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('qty').value))));
		totalit.value =price*qty;
	<?php if(!$edit) { ?>
 showButtonAdd();
    
    <?php } ?>
});

$( "#docsup" ).keyup(function() {

	<?php if(!$edit) { ?>
 showButton();
    
    <?php } ?>
});


function sembunyikanBerikutnya(){
if (($('#tgl1').val() != '')  && ($('#jmlp1').val() != '')) {
		$('#pembayaran2').show();	
	}
	else {
		$('#pembayaran2').hide();
	}

if (($('#tgl2').val() != '')  && ($('#jmlp2').val() != '')) {
		$('#pembayaran3').show();	
	}
	else {
		$('#pembayaran3').hide();
	}

if (($('#tgl3').val() != '')  && ($('#jmlp3').val() != '')) {
		$('#pembayaran4').show();	
	}
	else {
		$('#pembayaran4').hide();
	}
}
//penjumlahan payment of term
$( "#jmlp1" ).keyup(function() {
	jmlp1 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp1').value)))));		
	hitung();
	sembunyikanBerikutnya();
	showButton();
});


$( "#jmlp2" ).keyup(function() {
	jmlp2 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp2').value)))));
	hitung();
	sembunyikanBerikutnya();
	showButton();

});

$( "#jmlp3" ).keyup(function() {
	jmlp3 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp3').value))))); 
	hitung();
	sembunyikanBerikutnya();
	showButton();
});
$( "#jmlp4" ).keyup(function() {
	jmlp4 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp4').value)))));
	hitung();
	showButton();
});

$( "#qty" ).keyup(function() {

		var price = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('price').value))));
		var qty = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('qty').value))));
		totalit.value =price*qty;
	<?php if(!$edit) { ?>
 showButtonAdd();
    
    <?php } ?>
});

	$("#btr-cctype").change(function(){
		var code	= $("#btr-cctype").val();
		var tipecc	= document.getElementById("btr-cctype");
		
		activity='4';
		
		$.ajax({			
			url: "c_oas070/get_pd",
			data: "code="+code,
			cache: false,
			success: function(msg)
			{
				$("#btr").html(msg);		
				$('#btr-cchidden').show();					
			}
		});
	});
	$("#btr").change(function(){
		var charge_code = $("#cc").val();
		var elem = document.getElementById("btr-chargecode");
		elem.value =charge_code;
		 <?php if(!$edit) { ?>
 showButton();   
    <?php } ?>
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


$(function() {

$('input:radio[name=b_status]').on('click',function(){
            b_status=$(this).val();
			<?php if(!$edit) { ?>
 showButton();
        <?php } ?>
			});
			
 $("input:radio[name=user_status]").on('click', function(){
            user_status = $(this).val();
            console.log("Status "+user_status+" selected.");
			
			 <?php if(!$edit) { ?>
 showButton();   
    <?php } ?>
        });

		
$('#tgl1').datepick({
		dateFormat: 'dd MM yyyy',
		maxDate: "+2M" ,
		minDate:"+0D",
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			tgl1 = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+tgl1);	
			sembunyikanBerikutnya();
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
			sembunyikanBerikutnya();
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
			sembunyikanBerikutnya();
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
			sembunyikanBerikutnya();
		},
	});
	
		
		
<? if ($edit){?>
$('#btr-cctype').change(function(){
        
        $("#CA_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#CA_chargecode").addClass('hide');
        var sub_unsur_id = $('#btr-cctype').val();
        $.ajax({
            type: "POST",
            url: "c_oas070/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#CA_chargecode').append(opt);
					 ccode();
                });
                $(".wait").addClass('hide');
                $("#CA_chargecode").removeClass('hide');
            }
        });  
    }	
	);
	
	<?}?>

	// submit button
	$('#form-submit-btn-pr').on('click', function(){
	var jmlp1 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp1').value))))); 
	var jmlp2 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp2').value))))); 
	var jmlp3 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp3').value))))); 
	var jmlp4 = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('jmlp4').value)))));

		var form_data = {

					employeeId      	: employeeid,
					formid          	: formId,
					PR_ID				: $('#PR_ID').val(),			
					chargeCode			: $('#btr-chargecode').val(),
					mata_uang			: $('#btr_currency').val(),
					amount				: total_1,
					remark				: $('#btr_remarks').val(),
					employeerm          : employeeRM,
					employeerm_name     : "<?= $this_rm['name'] ?>",
					employeerm_email    : "<?= $this_rm['email'] ?>",
					submittedDate   	: moment().format('YYYY-MM-DD'),
					b_status			: b_status,
					user_status			: user_status,
					quot_no         	: $('#quot_no').val(),
					tgl_1         		: tgl1,
					jml_1         		: jmlp1,
					remarkp1        	: $('#remarkp1').val(),
					tgl_2         		: tgl2,
					jml_2         		: jmlp2,
					remarkp2        	: $('#remarkp2').val(),
					tgl_3         		: tgl3,
					jml_3         		: jmlp3,
					remarkp3        	: $('#remarkp3').val(),
					tgl_4         		: tgl4,
					jml_4         		: jmlp4,
					remarkp4        	: $('#remarkp4').val(),
					docsup        		: $('#docsup').val(),
					compship        			: $('#comp_ship').val(),
					attnship        			: $('#attn_ship').val(),
					addship        			: $('#add_ship').val(),
					cityship        			: $('#city_ship').val(),
					phoneship        			: $('#phone_ship').val(),
					zip        			: $('#zip').val(),
					fax        			: $('#fax').val(),
					compvendor        			: $('#comp_vendor').val(),
					addvendor        			: $('#add_vendor').val(),
					cp        			: $('#cp').val(),
					phonevendor        			: $('#phone_vendor').val(),
					emailvendor        			: $('#email_vendor').val(),
					npwp        			: $('#npwp').val(),
					PR_ID			: $('#PR_ID').val(),
					ajax				: '1'
		}; 
		
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
		console.log(form_data);

		$.ajax({
			url			: url, 
			type		: 'POST',
			async		: false,
			data		: form_data,
			timeout		: 1000, //1000ms
			success: function(data) {
                            $( "#"+id ).html("Form submitted successfully.<br>Process status ID: " + data
                                +"<br><button onclick='change_page(this, \"c_oas070/load_view\")'>Back</button>");
						
                    },
                      error: function(){                      
                            $( "#leave-sbmt-msg" ).html("There was an error connecting to server.");
                        }
		});
    });
	
	
	$('#sbmt-new-pritem').on('click', function(){
	var price = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('price').value)))); 
	var qty = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('qty').value)))); 
	var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('totalit').value)))); 
	
		var form_data = {
						
                        QTY         : qty,
                        ITEM    	: $('#item').val(),
                        DESCRIPTION : $('#description').val(),
                        PRICE 		: price,
						TOTAL 		: total,
						KETERANGAN 		: $('#keterangan').val(),
						PR_ID		: $('#PR_ID').val(),
						ajax				: 1
			
		   
		}; 
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);
		$.ajax({
			url: urlPR,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
		  success: function(data) { 
                            $("#"+id ).html("" + data
                                +"");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas070/load_view\")'>Back</button>");
                      
                        }
		});
    });
	
});
</script>