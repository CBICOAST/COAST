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
if(isset($type_data))
{
	$edit = true;
}
?>



<div class="box box-success">
    <div class="box-body">


    	<div class="requester-input form-section-container input-section">
    		<div class="form-group">
    			<label class="col-sm-4 control-label">Leave Name</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text" id="leave_name" class="form-control holo" value="<?php if($edit) echo $type_data['name']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Description Leave</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text"  id="description_leave" class="form-control holo" value="<?php if($edit) echo $type_data['description']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Maximum Leave</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text" id="maximal_leave" class="form-control holo"  value="<?php if($edit) echo $type_data['length_max']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->


    		<div class="form-group">
    			<label class="col-sm-4 control-label">Minimum submission date</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text" id="minimal_submission_leave" class="form-control holo" value="<?php if($edit) echo $type_data['min']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label  class="col-sm-4 control-label">Gender</label>
    			<div class="input-group">
    				<select name="gender" id="gender-id">
    					<option value="0" <?php if($edit && $type_data['gender']=='0') echo 'selected'; ?> >-- All --</option>
    					<option value="1" <?php if($edit && $type_data['gender']=='1') echo 'selected'; ?> >Male</option>
    					<option value="2" <?php if($edit && $type_data['gender']=='2') echo 'selected'; ?> >Female</option>
    				</select>
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Status</label>
    			<div class="input-group">
    				<input type="radio" name="status" <input type="radio" name="status"
    				<?php if ($edit && $type_data['status']=="1") echo "checked";?>
    				value="1">Aktif
    				<input type="radio" name="status"
    				<?php if ($edit && $type_data['status']=="0") echo "checked";?>
    				value="2">Not Aktif
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->




    	</div><!-- /.form group -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
    	<div class="pull-left" id="new-leave-msg"></div>
    	<button class="pull-right btn btn-primary" id="sbmt-new-leave" type="submit">Save</button>
    </div>

</div><!-- /.box -->
<script type="text/javascript">
var status 		 = null;
var url 		 = "<?php if($edit)
							echo 'c_oas019/update_form';
						else
							echo 'c_oas019/submit_form'; ?>";
var this_id = null;
<?php if($edit){ ?>
this_id = "<?= $type_data['id'] ?>";
status = "<?= $type_data['status'] ?>";
<?php } ?>


 $(function() {
     $('input:radio[name=status]').on('click',function(){
            status=$(this).val();
     });
     $('#sbmt-new-leave').on('click', function(){
		var form_data = {
			name_leave 		    : $('#leave_name').val(),
			length_leave	    : $('#maximal_leave').val(),
			submission_leave	: $('#minimal_submission_leave').val(),
			description_type    : $('#description_leave').val(),
			type_gender		    : $('#gender-id').val(),
			status				: status,
			leave_id			: this_id,
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
				$( "#new-leave-msg" ).html("Form submitted successfully . <br>Remarks: " + data);
                setTimeout(function(){
                    form_dialog_close();
                }, 1000);  
				console.log(data);
			},
			error: function(){                      
				$( "#new-leave-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
    });
 });
 </script> 