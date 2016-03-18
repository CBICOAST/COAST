<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS019
* Program Name     : Add/Edit Jenis Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04-nov-2014	   Metta Kharisma H		  Merubah view jadi b.inggris
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
$edit = false;
if(isset($edit_mode)){
	$edit = true;
}
?>

<div class="box box-success">
    <!-- <div class="box-header">
        <h3 class="box-title">CHANGE PASSWORD</h3>
    </div> -->
    <div class="box-body">

        <div class="requester-detail form-section-container">
			<div class="requester-input form-section-container input-section">
					<div class="form-group">
						<div class="form-group">
							<label for="join-date" class="col-sm-4 control-label">Holiday Date</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $info['tgl'] ?>" 
										placeholder="" id="tanggal_libur" class="form-control holo">
								</div><!-- /.input group -->
						</div><!-- /.form group -->
							
					<div class="form-group">
								<label class="col-sm-4 control-label">Information Holiday</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-pencil"></i>
								</div>
								<input type="text" id="keterangan_libur" class="form-control holo" value="<?php if($edit) echo $info['keterangan'] ?>">
							</div><!-- /.input group -->
					</div><!-- /.form group -->
					
							<div class="form-group">
								<label class="col-sm-4 control-label">Reduce Annual Leave?</label>
								<div class="input-group">
									<input type="radio" name="status" <input type="radio" name="status" <?php if($edit && $info['tipe']=='1') echo 'checked'  ?>
									value="1">Yes
									<input type="radio" name="status" <?php if($edit && $info['tipe']=='0') echo 'checked'  ?>
									value="0">No
								</div><!-- /.input group -->
							</div> <!-- /.requester-input -->
			</div><!-- /.form group -->
		</div><!-- /.form group -->
	</div><!-- /.form group -->
</div><!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="pull-left" id="new-holiday-msg"></div>
        <button class="pull-right btn btn-primary" id="sbmt-new-leave" type="submit">SAVE</button>
    </div>
	
</div><!-- /.box -->
<script type="text/javascript">
var new_holiday = null;	
var status = null;	
var id_holiday = null;
var url = "c_oas017/submit_form";

<?php if($edit) { ?>
new_holiday = "<?= $info['tgl'] ?>";	
status = "<?= $info['tipe'] ?>";
id_holiday = "<?= $info['id'] ?>";
url = "c_oas017/submit_edit_form";
<?php } ?>

// sembunyikan dulu sebelum yang harus diisi nya keisi semua
$('#sbmt-new-leave').hide();
function showButton(){
	
	if (((status == '1') || (status == '0')) && ($('#keterangan_libur').val() != '') ) {
		$('#sbmt-new-leave').show();	
	}
	else {
		$('#sbmt-new-leave').hide();
	}
}

 $(function() {
     $('input:radio[name=status]').on('click',function(){
            status=$(this).val();
showButton();
	});
	
	$('#tanggal_libur').datepick({
		dateFormat: 'dd MMMM yyyy',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			new_holiday = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+new_holiday);
		},
	});
	
     $('#sbmt-new-leave').on('click', function(){
		var form_data = {
			id 					: id_holiday,
			new_date 		    : new_holiday,
			holiday_remarks	    : $('#keterangan_libur').val(),
			status				: status,
			ajax				: 1
			
		   
		}; 
		console.log(form_data);

		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				$( "#new-holiday-msg" ).html("Form submitted successfully . <br>Remarks: " + data);
				setTimeout(function(){
                    form_dialog_close();
                }, 1000);  
				console.log(data);
			},
			error: function(){                      
				$( "#new-holiday-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
    });
});
 </script> 