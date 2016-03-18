<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS094
* Program Name     : Add/Edit List ShipTo
* contactpersonion      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 03-03-2015 14:39:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      contactpersonion
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
                <label for="companyname" class="col-sm-4 control-label">Company Name</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" onkeyup="showButton()" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['S_COMPANY'] ?>"           placeholder="company name..." id="companyname" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="contactperson" class="col-sm-4 control-label">Contact Person</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" onkeyup="showButton()" style="text-align: left; width: 175px" 
                            value="<?php if($edit) echo $employee_info['S_CP']?>" placeholder="contactpersonion" id="contactperson" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="alamat" class="col-sm-4 control-label">Address</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" maxlength="50" onkeyup="showButton()" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['S_ADDRESS'] ?>"placeholder="address..." id="alamat" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="telpon" class="col-sm-4 control-label">Mobile Phone</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" maxlength="15" onkeyup="showButton()" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['S_telpon'] ?>"placeholder="phone..." id="telpon" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="email" class="col-sm-4 control-label">Email</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="email" maxlength="50" onkeyup="showButton()" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['S_EMAIL'] ?>"placeholder="email..." id="email" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="npwp" class="col-sm-4 control-label">NPWP</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" maxlength="20" onkeyup="showButton()" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['S_NPWP'] ?>"placeholder="npwp..." id="npwp" class="form-control holo">
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
	
	<div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas098/load_view')">Back...</button>
            </div></div>
</div><!-- /.box -->



<script type="text/javascript">
    // variabel untuk disubmit
    var url = "<?php echo site_url('c_oas094/submit_new_item'); ?>";
    var edit = 0;
    var success_status = '1';
	$('#simpan-data').hide();
 
    <?php if($edit) { ?>
    edit = 1;
    url = "<?php echo site_url('c_oas094/update_item'); ?>";
    success_status = '3';
    <?php } ?>
	
	
	function showButton(){
	if (($('#companyname').val() != '') &&($('#contactperson').val() != '')&&($('#alamat').val() != '')&&($('#telpon').val() != '')&&($('#email').val() != '')) {
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
                    companyname      : $('#companyname').val(),
					contactperson            : $('#contactperson').val(),
                    alamat            : $('#alamat').val(),
					telpon      : $('#telpon').val(),
					email            : $('#email').val(),
                    npwp            : $('#npwp').val(),
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