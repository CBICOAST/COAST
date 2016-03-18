<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS091
* Program Name     : Add/Edit Menu Item PR
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 23-02-2015 10:39:00 ICT 2015
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

<div class="box box-success">
    <!-- <div class="box-header">
        <h3 class="box-title">GANTI PASSWORD</h3>
    </div> -->
    <div class="box-body">


        <h3 style="display: inline-block">Item Information</h3>
        <div class="requester-input form-section-container input-section new-employee-form">
			<div class="form-group">
                <label for="nik" class="col-sm-4 control-label">Description</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" onkeyup="showButton()" maxlength="50" style="text-align: left; width: 175px" 
                            value="<?php if($edit) echo $employee_info['DESCRIPTION']?>" placeholder="description" id="descript" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Satuan</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" onkeyup="showButton()" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['SATUAN'] ?>"placeholder="satuan..." id="satuan" class="form-control holo">
                </div>
            </div>
            
    </div><!-- /.box-body -->
    <?php if(!$readonly){ ?>
    <div class="box-footer clearfix">
        <div class="pull-left" id="chg-pwd-msg"></div>
        <button class="pull-right btn btn-primary 
            <?php if(!$edit) echo'enable';?>" type="submit" id="simpan-data">SAVE</button>
    </div>
    <?php }?>
</div><!-- /.box -->



<script type="text/javascript">
    // variabel untuk disubmit
    var url = "<?php echo site_url('c_oas091/submit_new_item'); ?>";
    var edit = 0;
    var success_status = '1';
		$('#simpan-data').hide();
 
    <?php if($edit) { ?>
    edit = 1;
    url = "<?php echo site_url('c_oas091/update_item'); ?>";
    success_status = '3';
    <?php } ?>
	
	function showButton(){
	
	if (($('#descript').val() != '')  && ($('#satuan').val() != '')) {
		$('#simpan-data').show();	
	}
	else {
		$('#simpan-data').hide();
	}
}
    
    $(function() {

     
        $('#simpan-data').on('click', function(){
            // store error message
            var chgpwdmsg = "";
            var dosubmit_item = true;

            
            // jika terjadi kesalahan, munculkan error
            if(chgpwdmsg != ""){
                $('#chg-pwd-msg').html(chgpwdmsg);
                dosubmit_item = false;
            }

			 
            if(dosubmit_item){
                console.log("Ajax call terpanggil")

                var form_data = { 
                    no_item      : $('#no_item').val(),
					descript            : $('#descript').val(),
                    satuan            : $('#satuan').val(),
                    ajax            : '1'
                };
                
                console.log(form_data);

                $.ajax({
                    url: url,
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                    success: function(data) {
                       
                            $('#chg-pwd-msg').html("Data successfully processed. <br>Status: " + data);
                            setTimeout(function(){
                                form_dialog_close();
                            }, 1000);     
                        
                        
                    },
                    error: function(){                      
                        $('#chg-pwd-msg').html("There was an error connecting to server.");
                    }
                });
            }
        });



    });
</script>