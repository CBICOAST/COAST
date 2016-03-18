<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS027
* Program Name     : Add/Edit Jenis charge code
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 22-08-2014 32:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
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
    			<label class="col-sm-4 control-label">Charge Code</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text" id="charge_code27" onkeyup="show_button()" class="form-control holo" value="<?php if($edit) echo $type_data['id']; ?>" >
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Project Description</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input  type="text"  onkeyup="show_button()" id="description_project" class="form-control holo" value="<?php if($edit) echo $type_data['description']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->
   
					<div class="form-group">
    			<label  class="col-sm-4 control-label">Type Project</label>
    			<div class="input-group">
    				<select name="descript_type" id="descript_type">
    					<option value="1" <?php if($edit && $type_data['descript_type']=='1') echo 'selected'; ?> >INTERNAL</option>
    					<option value="2" <?php if($edit && $type_data['descript_type']=='2') echo 'selected'; ?> >PROJECT</option>
    					<option value="4" <?php if($edit && $type_data['descript_type']=='4') echo 'selected'; ?> >LISENCE</option>
						<option value="3" <?php if($edit && $type_data['descript_type']=='3') echo 'selected'; ?> >TRAINING</option>
    				</select>
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->
					
			<div class="form-group">
                <label for="cc_division" class="col-sm-4 control-label">Division</label>
                <div class="input-group">
                     <select id="cc_division">
                        <?php foreach ($list_division as $key => $marital) { ?>
                        <option value="<?= $marital['id'] ?>"
						<?php if($edit && $type_data['divid'] == $marital['id']) echo 'selected' ?>><?= $marital['id']?></option>
                        <?php } ?>
                    </select>
					</div><!-- /.input group -->
				</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Status</label>
    			<div class="input-group">
    				<input type="radio" name="status"
    				<?php if ($edit && $type_data['status']=="1") echo "checked";?>
    				value="1">Aktif
    				<input type="radio" name="status"
    				<?php if ($edit && $type_data['status']=="2") echo "checked";?>
    				value="2">Tidak Aktif
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    	</div><!-- /.form group -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
    	<div class="pull-left" id="new-chargecode-msg"></div>
    	<button class="pull-right btn btn-primary" id="sbmt-new-chargecode" type="submit">Save</button>
    </div>

</div><!-- /.box -->
<script type="text/javascript">
var status	= null;
var url		= "<?php if($edit)
							echo 'c_oas027/update_form';
						else
							echo 'c_oas027/submit_form'; ?>";
var this_id = null;
<?php if($edit){ ?>
this_id		= "<?= $type_data['cc_id'] ?>";
status		= "<?= $type_data['status'] ?>";
<?php } ?>
show_button();
function show_button(){
		if ( ($('#charge_code27').val() != '') && ($('#description_project').val() != '') && ((status == '1') || (status == '2'))){
				$('#sbmt-new-chargecode').show();
		}
		else{
			$('#sbmt-new-chargecode').hide();
		}
}

$(function() {
     $('input:radio[name=status]').on('click',function(){
            status=$(this).val();
			show_button();
	});
     $('#sbmt-new-chargecode').on('click', function(){
		var form_data = {
			id 		    : $('#charge_code27').val(),
			descript_project    : $('#description_project').val(),
			description_type    : $('#descript_type').val(),
			cc_division    		: $('#cc_division').val(),
			status				: status,
			cc_id			: this_id,
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
				$( "#new-chargecode-msg" ).html(data);
                
				console.log(data);
			},
			error: function(){                      
				$( "#new-chargecode-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
    });
 });
 </script> 