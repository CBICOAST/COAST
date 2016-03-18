<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS018
* Program Name     : Pengaturan User
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 	1.00			16-12-2014			Winni Oktaviani		add fungsi2 untuk show procedure claim,bt,ca
* 	2.00			30-02-2014			Metta Kharisma		add fungsi2 untuk show procedure pr
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>



<div class="box box-success">
    <div class="box-body">

        <div class="requester-detail form-section-container">

            <div class="form-group">
                <label for="requester" class="col-sm-4 control-label">Name</label>
                <div class="input-group">
                    <input type="text" value="<?= $this_name ?>" placeholder="Name" id="requester" class="form-control" readonly="">
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-4 control-label">Email</label>
                <div class="input-group">
                    <input type="email" value="<?= $this_email ?>" placeholder="Enter email" id="exampleInputEmail1" class="form-control" readonly="">
                </div>
            </div>          
        </div> <!-- /.requester-detail -->



        <div class="requester-input form-section-container">
			<div class="form-group">
				 <h4 style="display: inline-block">Show Information Procedures ?</h4><br>
			</div>
            <div class="form-group">
                <label for="old-password" class="col-sm-4 control-label">Leave</label>
                <div class="input-group">
                     <input type="checkbox" id="leave-inform-usr-setting" <?php if($employee_inform['SHOW_LEAVE_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
            <div class="form-group">
                <label  class="col-sm-4 control-label"> Expense Claim </label>
                <div class="input-group">
                     <input type="checkbox" id="expense-inform-usr-setting" <?php if($employee_inform['SHOW_EXPENSE_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
            <div class="form-group">
                <label  class="col-sm-4 control-label">Bussiness Travel </label>
                <div class="input-group">
                     <input type="checkbox" id="bt-inform-usr-setting" <?php if($employee_inform['SHOW_BUSINESS_TRAVEL_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
		    <div class="form-group">
                <label  class="col-sm-4 control-label">Cash Advance </label>
                <div class="input-group">
                     <input type="checkbox" id="ca-inform-usr-setting" <?php if($employee_inform['SHOW_CA_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
            <div class="form-group">
                <label  class="col-sm-4 control-label">Purchase Request </label>
                <div class="input-group">
                     <input type="checkbox" id="pr_inform_usr_setting" <?php if($employee_inform['SHOW_PR_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
        </div> <!-- /.requester-input -->
		<div class="requester-input form-section-container input-section" hidden>
            <div class="form-group">
                <div class="input-group">
                     <input type="checkbox" id="pr-inform-usr-setting" <?php if($employee_inform['SHOW_PR_INFORMATION'] == "1") echo "checked"; ?> > Always Show<br>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
        </div> <!-- /.requester-input -->



        <div class="requester-input form-section-container input-section">
            <h3 style="display: inline-block">Change Password </h3> Optional
            <div class="form-group">
                <label for="old-password" class="col-sm-4 control-label">Current Password </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" id="old-password" class="form-control holo">
                </div><!-- /.input group -->
            </div><!-- /.form group -->


            <div class="form-group">
                <label for="new-password" class="col-sm-4 control-label">New Password</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" class="form-control holo" id="new-password">
                </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
                <label for="re-new-password" class="col-sm-4 control-label">Repeat New Password</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" id="re-new-password" class="form-control holo">
                </div><!-- /.input group -->
            </div><!-- /.form group -->
        </div> <!-- /.requester-input -->

        <div class="requester-input form-section-container input-section">
            <h3 style="display: inline-block">Change Personal Information </h3>
            <div class="form-group">
                <label for="old-password" class="col-sm-4 control-label">Address</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-home"></i>
                    </div>
                    <input type="text" id="alamat" class="form-control holo" value="<?= $employee_inform['ADDRESS'] ?>">
                </div><!-- /.input group -->
            </div><!-- /.form group -->


            <div class="form-group">
                <label for="new-password" class="col-sm-4 control-label">Telephone number</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <input type="text" class="form-control holo" id="nomor_tlpn" value="<?= $employee_inform['PHONE'] ?>">
                </div><!-- /.input group -->
            </div><!-- /.form group -->
        </div> <!-- /.requester-input -->

    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="pull-left" id="chg-pwd-msg"></div>
        <button class="pull-right btn btn-primary" type="submit" id="simpan-pwd">SAVE</button>
    </div>
</div><!-- /.box -->

<script type="text/javascript">
    var employee_id = '<?= $this_id ?>';
    var leave_inform = '<?php if ($employee_inform["SHOW_LEAVE_INFORMATION"] == "1") echo "1"; else echo "";?>';
    var expense_inform = '<?php if ($employee_inform["SHOW_EXPENSE_INFORMATION"] == "1") echo "1"; else echo "";?>';
    var bt_inform = '<?php if ($employee_inform["SHOW_BUSINESS_TRAVEL_INFORMATION"] == "1") echo "1"; else echo "";?>';
    var ca_inform = '<?php if ($employee_inform["SHOW_CA_INFORMATION"] == "1") echo "1"; else echo "";?>';
    var pr_inform = '<?php if ($employee_inform["SHOW_PR_INFORMATION"] == "1") echo "1"; else echo "";?>';
	var currentPwd ="<?= $employee_inform['USER_PASSWORD']?>";
	
	

    var do_update_leave_inform = false;
	var do_update_expense_inform = false;
	var do_update_bt_inform = false;
	var do_update_ca_inform = false;
    var do_update_password = false;
    var do_update_detail = false;
    var do_update_leave_inform = false;
    var do_update_pr_inform = false;

    // remove all error mark
    function clearErr()
    {
        $('.form-group').removeClass("has-error");
        $('#chg-pwd-msg').html("");
    }

    // add error mark to current password field
    function oldPwdErr(){
        var id = $('#old-password').closest('.form-group').addClass("has-error");
    }

    // add error mark to both new password field
    function newPwdErr()
    {
        var id = $('#new-password').closest('.form-group').addClass("has-error");
        var id = $('#re-new-password').closest('.form-group').addClass("has-error");
    }

    $(function() {
        $('#nomor_tlpn').keyup(function(){
            do_update_detail = true;
        });
        $('#alamat').keyup(function(){
            do_update_detail = true;
        });

        $('#simpan-pwd').on('click', function(){
            clearErr();

            // store error message
            var chgpwdmsg = "";
			password18 =$('#new-password').val();
			var panjang=password18.length;

            // check if user want to check password by checking
            // if current password field is filled
            if(($.trim($('#old-password').val()) != ""))
            {
                // check if both new password field is same and not empty
                if( ($.trim($('#new-password').val()) == "" || $.trim($('#re-new-password').val()) == "") ||
                    ($.trim($('#new-password').val()) != $.trim($('#re-new-password').val()))  )
                    // if new password field empty or not same
                {
                    chgpwdmsg += "The new password must not be empty, and the two fields should be the same.";
                    newPwdErr();
                    do_update_password = false;
                }
                else  if(($('#new-password').val() != '') && (panjang<6 || panjang>50)){
                    chgpwdmsg += "Password at least 6 characters and a maximum of 50 characters";
                    newPwdErr();
                    do_update_password = false;						
		}
                else
                // if new password field not empty and same
                {
                    // below is check if password entered is valid for this user
                    var form_data = {
                        employeeId      : employee_id,
                        Pwd             : $.trim($('#old-password').val()),
                        ajax            : '1'
                    };
                    $.ajax({
                        url: "<?php echo site_url('c_oas018/check_pwd'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                        success: function(data) {
                            if(data == "1")
                            // jika password sesuai, tandai update password
                            {
                                console.log("Update password");
                                do_update_password = true;            
                            }
                            else
                            // jika passwordtidak  sesuai, tandai jangan update password
                            {
                                chgpwdmsg += "The password you entered is incorrect.";
                                oldPwdErr();
                                do_update_password = false;
                            }
                        },
                        error: function(){                      
                            // jika tidak dapat berkomunikasi dengan server
                            chgpwdmsg += "There was an error in communicating with the server.";
                            do_update_password = false;
                        }
                    });
                    
                }
            }
			 if(($.trim($('#old-password').val()) == "") && (($.trim($('#new-password').val()) != "") ||($.trim($('#re-new-password').val()) != "")))
            {
				chgpwdmsg += " Please Input Your Current Password";
				oldPwdErr();
				do_update_password = false;
			}

            // Cek jika terjadi perubahan pada checkbox munculkan informasi form
            if($('#leave-inform-usr-setting').is(':checked') != leave_inform )
            {
                console.log("Update status");
                do_update_leave_inform = true;
                if($('#leave-inform-usr-setting').is(':checked'))
                {
                    leave_inform = "1";
                }
                else
                {
                    leave_inform = "0";
                }
            }

			// Cek jika terjadi perubahan pada checkbox munculkan informasi form
            if($('#expense-inform-usr-setting').is(':checked') != expense_inform )
            {
                console.log("Update status");
                do_update_expense_inform = true;
                if($('#expense-inform-usr-setting').is(':checked'))
                {
                    expense_inform = "1";
                }
                else
                {
                    expense_inform = "0";
                }
            }
			
			// Cek jika terjadi perubahan pada checkbox munculkan informasi form
            if($('#bt-inform-usr-setting').is(':checked') != bt_inform )
            {
                console.log("Update status");
                do_update_bt_inform = true;
                if($('#bt-inform-usr-setting').is(':checked'))
                {
                    bt_inform = "1";
                }
                else
                {
                    bt_inform = "0";
                }
            }
			
			// Cek jika terjadi perubahan pada checkbox munculkan informasi form
            if($('#ca-inform-usr-setting').is(':checked') != ca_inform )
            {
                console.log("Update status");
                do_update_ca_inform = true;
                if($('#ca-inform-usr-setting').is(':checked'))
                {
                    ca_inform = "1";
                }
                else
                {
                    ca_inform = "0";
                }
            }
			// Cek jika terjadi perubahan pada checkbox munculkan informasi form
            if($('#pr_inform_usr_setting').is(':checked') != pr_inform )
            {
                console.log("Update status");
                do_update_pr_inform = true;
                if($('#pr_inform_usr_setting').is(':checked'))
                {
                    pr_inform = "1";
                }
                else
                {
                    pr_inform = "0";
                }
            }

            // jika terjadi kesalahan, munculkan error
            if(chgpwdmsg != ""){
                $('#chg-pwd-msg').html(chgpwdmsg);
                do_update_leave_inform = false;
                do_update_expense_inform = false;
                do_update_bt_inform = false;
                do_update_ca_inform = false;
                do_update_password = false;
                do_update_pr_inform = false;
            }

            
            if( chgpwdmsg == "" && 
                (do_update_password || do_update_leave_inform || do_update_expense_inform || do_update_bt_inform ||
					do_update_ca_inform || do_update_detail || do_update_pr_inform)  ){

                console.log("Ajax call terpanggil")
                var newpwd = null;
                var leave_inform_status = null;
                var expense_inform_status = null;
                var bt_inform_status = null;
                var ca_inform_status = null;
                var pr_inform_status = null;
				var pr_inform_status = null;

                if(do_update_password)
                {    newpwd = $.trim($('#new-password').val()); }

                if(do_update_leave_inform)
                {   leave_inform_status = leave_inform; }
				 if(do_update_expense_inform)
                {   expense_inform_status = expense_inform; }
				 if(do_update_bt_inform)
                {   bt_inform_status = bt_inform; }
				 if(do_update_ca_inform)
                {   ca_inform_status = ca_inform; }
				if(do_update_pr_inform)
                {   pr_inform_status = pr_inform; }
				if(do_update_pr_inform)
                {   pr_inform_status = pr_inform; }


                var form_data = {
                    employeeId      : employee_id,
                    newPwd          : newpwd,
                    inform_status   : leave_inform_status,
                    inform_ec_status   : expense_inform_status,
                    inform_ca_status   : ca_inform_status,
                    inform_bt_status   : bt_inform_status,
                    inform_pr_status   : pr_inform_status,
                    nomor_tlpn      : $.trim($('#nomor_tlpn').val()),
                    alamat          : $.trim($('#alamat').val()),
                    ajax            : '1'
                };
                
                console.log(form_data);

                $.ajax({
                    url: "<?php echo site_url('c_oas018/change_pwd'); ?>",
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                    success: function(data) {
                            $('#chg-pwd-msg').html("Data successfully processed.");
                            setTimeout(function(){
                                form_dialog_close();
                            }, 1000);   
                        
                        
                    },
                    error: function(){                      
                        $('#chg-pwd-msg').html("There was an error connecting to server.");
                    }
                });
            }
            else if(chgpwdmsg == "")
            {
               form_dialog_close();
            }
        });
    });
</script>