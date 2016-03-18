<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS006
* Program Name     : Add/Edit User or Employee Information
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili & Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 & 16-10-2014 10:52:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04 Nov 2014	   Metta Kharisma H		 Merubah View menambahkan field 
* 2.0				 04 Nov 2014	   Metta Kharisma H		 Merubah dateFormat datepicker
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


        <h3 style="display: inline-block">Employee Information</h3>
        <div class="requester-input form-section-container input-section new-employee-form">
            <div class="form-group">
                <label for="employee-id" class="col-sm-4 control-label">Employee Id</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['EMPLOYEE_ID'] ?>" 
                            placeholder="Input Employee Id..." id="employee-id" class="form-control holo" onkeyup="idRequired()">
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
			<div class="form-group">
                <label for="nik" class="col-sm-4 control-label">ID Card Number</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" 
                            value="<?php if($edit) echo $employee_info['ID_CARD_NUMBER']?>" placeholder="Input ID Card Number" id="nik" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Employee Name</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['EMPLOYEE_NAME'] ?>" 
                           placeholder="Input Name..." onkeyup="nameRequired()"id="name" class="form-control holo">
                </div>
				<span id="spanName"style="color:red;"></span>
            </div>
            <div class="form-group">
                <label for="join-date" class="col-sm-4 control-label">Join Date</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo date('d F Y',strtotime( $employee_info['JOIN_DATE']));?>" 
                            placeholder="" onkeyup="joinRequired()" id="join-date" class="form-control holo">
                </div>
				<span id="spanJoin"style="color:red;"></span>
            </div>
				<div class="form-group">
                <label for="marital" class="col-sm-4 control-label">Marital Status</label>
                <div class="input-group">
                     <select id="marital">
                        <?php foreach ($list_marital as $key => $marital) { ?>
                        <option value="<?= $marital['id'] ?>"
                            <?php if($edit && $employee_info['MARITAL_STATUS'] == $marital['id']) echo 'selected' ?>><?= $marital['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
			<div class="form-group">
                <label for="dependant" class="col-sm-4 control-label">Dependant</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" 
                            value="<?php if($edit) echo $employee_info['DEPENDANT']?>" placeholder="Input Dependant" id="dependant" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="col-sm-4 control-label">Gender</label>
                <div class="input-group">
                     <select id="gender">
                        <?php foreach ($list_gender as $key => $gender) { ?>
                        <option value="<?= $gender['id'] ?>"
                            <?php if($edit && $employee_info['GENDER_ID'] == $gender['id']) echo 'selected' ?>><?= $gender['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="birth" class="col-sm-4 control-label">Date of Birth</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar" id="bcal"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit && !$readonly) echo date('d F Y',strtotime( $employee_info['BIRTH_DATE'])); elseif ($readonly) echo date('d F',strtotime($employee_info['BIRTH_DATE']));?>" 
                            placeholder="" id="birth" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-sm-4 control-label">Address</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-home" id="bcal"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['ADDRESS']?>" 
                            placeholder="" id="address" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-4 control-label">Phone Number</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-phone" id="bcal"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $employee_info['PHONE']?>" 
                            placeholder="" id="phone" class="form-control holo">
                </div>
            </div>
			
			<div class="form-group">
                <label for="status-karyawan" class="col-sm-4 control-label">Employee Status</label>
                <div class="input-group">
                    <input type="radio" name="status-karyawan" value="1" <?php if(!$edit) echo 'checked' ?>
                    <?php if($edit && $employee_info['STATUS_ID'] == '1') echo 'checked' ?>>Permanent 
        &nbsp;&nbsp;<input type="radio" name="status-karyawan" value="2"
                    <?php if($edit && $employee_info['STATUS_ID'] == '2') echo 'checked' ?>>Contract
					<input type="radio" name="status-karyawan" value="3"
                    <?php if($edit && $employee_info['STATUS_ID'] == '3') echo 'checked' ?>>Probation
                </div>
            </div>
			
			<div class="form-group">
                <label for="employee-privillege" class="col-sm-4 control-label">Employee Privillege CA</label>
                <div class="input-group">
                    <input type="radio" name="employee-privillege" value="1" <?php if(!$edit) echo 'checked' ?>
                    <?php if($edit && $employee_info['PRIVILEGE_CA'] == '1') echo 'checked' ?>>Aktif 
        &nbsp;&nbsp;<input type="radio" name="employee-privillege" value="0"
                    <?php if($edit && $employee_info['PRIVILEGE_CA'] == '0') echo 'checked' ?>>Not Aktif
                </div>
            </div>
			
        <h3 style="display: inline-block">Account</h3>
        <div class="requester-input form-section-container input-section new-employee-form">
            <div class="form-group">
                <label for="email" class="col-sm-4 control-label">Email</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i>
                    </div>
                    <input type="text" maxlength="50" style="text-align: left; width: 175px" 
                            value="<?php if($edit) echo $employee_info['USER_EMAIL'] ?>" placeholder="Input Email..." id="email" class="form-control holo" onkeyup="emailRequired()">
                </div><span id="spanEmail"style="color:red;"></span>
            </div>
            <?php if(!$readonly){ ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Password</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" maxlength="50" style="text-align: left; width: 175px" 
                            class="form-control holo" id="input-password06"
                            value="<?php if($edit) echo $employee_info['USER_PASSWORD'] ?>" onkeyup="passwordRequired()">
                </div><!-- /.input group -->
				<span id="spanPassword"style="color:red;"></span>
            </div><!-- /.form group -->
            <?php }?>
            <div class="form-group">
                <label for="user-group" class="col-sm-4 control-label">User Type</label>
                <div class="input-group">
                    <select id="user-group">
                        <?php foreach ($list_user_group as $key => $ug) { ?>
                        <option value="<?= $ug['id'] ?>" <?php if($edit && $employee_info['USER_GROUP_ID'] == $ug['id']) echo 'selected' ?>><?= $ug['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="user-status" class="col-sm-4 control-label">Status</label>
                <div class="input-group">
                    <input type="radio" name="user-status" value="1" <?php if(!$edit) echo 'checked' ?>
                    <?php if($edit && $employee_info['USER_STATUS'] == '1') echo 'checked' ?>>Aktif 
        &nbsp;&nbsp;<input type="radio" name="user-status" value="0"
                    <?php if($edit && $employee_info['USER_STATUS'] == '0') echo 'checked' ?>>Not Aktif
                </div>
				
				<span id="span_cekapproval06"style="color:red;"></span>
            </div>
        </div><!-- /.input-section -->


        <h3 style="display: inline-block">Information</h3>
        <div class="requester-input form-section-container input-section new-employee-form">
            <div class="form-group">
                <label for="title" class="col-sm-4 control-label">Position</label>
                <div class="input-group">
                   <select id="title">
                        <option style="display: none;" value="">Select...</option>
                        <?php foreach ($list_position_depth as $key => $title) { ?>
                        <option value="<?= $title['id'] ?>"
                            <?php if($edit && $employee_info['POSITION_DEPTH_ID'] == $title['id']) echo 'selected' ?>><?= $title['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="Level" class="col-sm-4 control-label">Level</label>
                <div class="input-group">
                    <select id="level" <?php if(!$edit) echo 'disabled="disabled"' ?>>
                        <option style="display: none;" value="">...</option>
                        <?php foreach ($list_position_level as $key => $level) { ?>
                        <option value="<?= $level['id'] ?>"
                            <?php if($edit && $employee_info['LEVEL_ID'] == $level['id']) echo 'selected' ?>><?= $level['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="group" class="col-sm-4 control-label">Group</label>
                <div class="input-group">
                    <div id="disable-group" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']!='1') echo 'hide';?>">-</div>
                    <select id="input-group" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']=='1') echo 'hide'; elseif(!$edit) echo 'hide';?>">
                        <?php foreach ($list_group as $key => $group) { ?>
                        <option value="<?= $group['id'] ?>"
                            <?php if($edit && $employee_info['POSITION_DEPTH_ID']!='1' && $groupid==$group['id']) echo 'selected'?>><?= $group['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="division" class="col-sm-4 control-label">Division</label>
                <div class="input-group">
                    <div id="disable-div" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']>2) echo 'hide';?>">-</div>
                    <div class="wait hide"><img style="max-height: 16px; max-width: 16px;" src="<?php echo img_url(); ?>loader.gif">Lists divisions...</div>
                    <div id="disable-division" class="hide">-</div>
                    <select id="division" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']<3) echo 'hide'; elseif(!$edit) echo 'hide';?>">
                        <?php if($edit){
                        foreach ($list_division as $key => $div) { ?>
                        <option value="<?= $div['id'] ?>"
                            <?php if($edit && $employee_info['POSITION_DEPTH_ID']>2 && $divisionid==$div['id']) echo 'selected'?>><?= $div['name'] ?></option>
                        <?php }
                        } ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="rm" class="col-sm-4 control-label">Reporting Manager</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-group"></i>
                    </div>
                    <div id="disable-rm" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']!='1') echo 'hide';?>">-</div>
                    <select id="rm" class="<?php if($edit && $employee_info['POSITION_DEPTH_ID']=='1') echo 'hide'; elseif(!$edit) echo 'hide';?>">
                        <?php foreach ($list_employee as $key => $employee) { ?>
                        <option value="<?= $employee['id'] ?>"
                            <?php if($edit && $employee_info['REPORTING_MANAGER_ID']==$employee['id']) echo 'selected'?>><?= $employee['id'].': '.$employee['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
            <?php if(!$readonly){ ?>
            <div class="form-group">
                <label for="annual-leave" class="col-sm-4 control-label">Limit Annual Leave</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar-o"></i>
                    </div>
                    <input type="text" maxlength="3" style="text-align: left; width: 25px" 
                            value="<?php if($edit) echo $employee_info['ANNUAL_LEAVE_ENTITLEMENT']?>" placeholder="00" id="annual-leave" class="form-control holo">
                </div>
            </div>
			<div class="form-group" id="div_medis06">
                <label for="annual-medical" class="col-sm-4 control-label">Limit Medical Claim</label>
                <div class="input-group">
                    <div class="input-group-addon">
                       Rp.
                    </div>
                    <input type="text" maxlength="7" style="text-align: left; width: 75px" onkeyup="formatAngka(this, '.')"  
					<?php if ($edit){ ?> value="<?= number_format(($employee_info['EXPENSE_CLAIM_MEDICAL_ENTITLEMENT']),0,',','.');?>"<?}?> placeholder="00" id="annual-medical" class="form-control holo"> / 
							<select id="medical_periode06">
								<option value="2"> Bulan</option>
								<option value="1"> Tahun</option>
							</select> 
                </div>
            </div>
			<div class="form-group" id="div_transprt06">
                <label for="annual-transport" class="col-sm-4 control-label">Limit Transportation Claim</label>
                <div class="input-group">
                    <div class="input-group-addon">
                       Rp.
                    </div>
                    <input type="text" maxlength="8" style="text-align: left; width: 75px"  onkeyup="formatAngka(this, '.')" 
                            <?php if ($edit){ ?> value="<?= number_format(($employee_info['EXPENSE_CLAIM_TRANSPORTATION_ENTITLEMENT']),0,',','.');?>"<?}?> placeholder="00" id="annual-transport" class="form-control holo">
                </div>
            </div>
			<div class="form-group" id="div_telkom06">
                <label for="annual-komunikasi" class="col-sm-4 control-label">Limit Telecommunication Claim</label>
                <div class="input-group">
                    <div class="input-group-addon">
                       Rp.
                    </div>
                    <input type="text" maxlength="7" style="text-align: left; width: 75px"  onkeyup="formatAngka(this, '.')" 
                            <?php if ($edit){ ?> value="<?= number_format(($employee_info['EXPENSE_CLAIM_TELECOMMUNICATION_ENTITLEMENT']),0,',','.');?>"<?}?> placeholder="00" id="annual-komunikasi" class="form-control holo">
                </div>
            </div>
            <?php } ?>
        </div><!-- /.input-section -->

            

    </div><!-- /.box-body -->
    <?php if(!$readonly){ ?>
    <div class="box-footer clearfix">
        <div class="pull-left" id="chg-pwd-msg"></div>
        <button class="pull-right btn btn-primary 
            <?php if(!$edit) echo'disabled';?>" type="submit" id="simpan-data06">SAVE</button>
    </div>
    <?php }?>
</div><!-- /.box -->



<script type="text/javascript">
    // variabel untuk disubmit
    var url = "<?php echo site_url('c_oas006/submit_new_employee'); ?>";	
	var getLevel =null;
	var cekPwd = null;
    var user_status = 1;
	var employee_status = 2;
	var employee_status = 1;
	var employee_privillege = 0;
    var edit = 0;
    var success_status = '7';
    var birth_date = null;
    var join_date = null;
	var periode =null;
    var pos_id = null;
    var pos_set = 1;// Nilai pos_set:
                    // 1 = pos_id <- DIR
                    // 2 = pos_id <- DEPEND ON GROUP INPUT
                    // 3 = pos_id <- DEPEND ON DIVISION INPUT

    // akhir dari variabel untuk disubmit
    
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
}

//function membersihkan tanda titik di field amount
function bersihPemisah(ini){
	a = ini.toString().replace(".","");
	//a = a.replace(".","");
	return a;
}
    <?php if($edit) { ?>
    join_date = "<?= $employee_info['JOIN_DATE'] ?>";
    birth_date = "<?= $employee_info['BIRTH_DATE'] ?>";
    user_status = "<?= $employee_info['USER_STATUS'] ?>";
	employee_status = "<?= $employee_info['STATUS_ID'] ?>";
	employee_privillege = "<?= $employee_info['PRIVILEGE_CA'] ?>";
    edit = 1;
    pos_set = <?= $employee_info['POSITION_DEPTH_ID'] ?>;
    url = "<?php echo site_url('c_oas006/update_employee'); ?>";
	getLevel ="<?=$employee_info['LEVEL_ID']?>";
	cekPwd ="<?=$employee_info['USER_PASSWORD']?>";
    success_status = '3';
	var eleman = document.getElementById('employee-id');
    eleman.setAttribute("disabled", true);
	$('#div_medis06').hide();
	$('#div_telkom06').hide();
	$('#div_transprt06').hide();
	
    <?php } ?>
    
    function clearErr()
    {
        $('.form-group').removeClass("has-error");
        $('#chg-pwd-msg').html("");
    }

    // add error mark to current password field
    function oldPwdErr(){
        var id = $('#old-password').closest('.form-group').addClass("has-error");
    }
	
	function idRequired(){
		if ($('#employee-id').val() == ''){
			$('#simpan-data06').hide();
			document.getElementById('spanId').innerHTML = "Employee ID is Required";
		}
		else{			
			document.getElementById('spanId').innerHTML = "";
			$('#simpan-data06').show();
		}
	} 
	
	function nameRequired(){
		if ($('#name').val() == ''){
			$('#simpan-data06').hide();
			document.getElementById('spanName').innerHTML = "Employee Name is Required";
		}
		else{			
			document.getElementById('spanName').innerHTML = "";
			$('#simpan-data06').show();
		}
	}
	function joinRequired(){
		if ($('#join-date').val() == ''){
			$('#simpan-data06').hide();
			document.getElementById('spanJoin').innerHTML = "Join Date is Required";
		}
		else{			
			document.getElementById('spanJoin').innerHTML = "";
			$('#simpan-data06').show();
		}
	}
	function emailRequired(){
		if ($('#email').val() == ''){
			$('#simpan-data06').hide();
			document.getElementById('spanEmail').innerHTML = "Employee Email is Required";
		}
		else{			
			document.getElementById('spanEmail').innerHTML = "";
			$('#simpan-data06').show();
		}
	}
	function passwordRequired(){
		if ($('#input-password06').val() == ''){
			$('#simpan-data06').hide();
			document.getElementById('spanPassword').innerHTML = "Password is Required";
		}
		else{			
			document.getElementById('spanPassword').innerHTML = "";
			$('#simpan-data06').show();
		}
	}
	
	// Jangan tampilkan tombol submit jika data yang perlu diisi masih kosong
	function dontshow(){
		nameRequired();
		joinRequired();
		emailRequired();
		idRequired();
		passwordRequired();
	}
	function cobacekapproval(){
		if(user_status == '0'){
			var code = $('#employee-id').val();
			$.ajax({
				url: "c_oas006/cekapproval06",
				data: {"code":code},
				cache: false,
				success: function(msg)
					{
						$("#span_cekapproval06").html(msg);
						$('#span_cekapproval06').show();
					}						
				});
		}
		else{
			$('#span_cekapproval06').hide();
			dontshow();
		}
	}
   
    $(function() {

        <?php if($readonly){ ?>
        $('.new-employee-form').find('input, textarea, select').attr('disabled', true);
        <?php } ?>

        $("input:radio[name=user-status]").on('click', function(){
            user_status = $(this).val();
            console.log("Status "+user_status+" selected.");
			cobacekapproval();
        });
		
		$("input:radio[name=status-karyawan]").on('click', function(){
            employee_status = $(this).val();
            console.log("Status "+employee_status+" selected.");
        });
		
		
		$("input:radio[name=employee-privillege]").on('click', function(){
            employee_privillege = $(this).val();
            console.log("Employeepriv "+employee_privillege+" selected.");
        });

        
        $('#birth').datepick({
            dateFormat: 'dd MMMM yyyy',
            useMouseWheel: false,
            yearRange: 'c-60:c-0',
            maxDate: 0,
            onClose: function(dates) { 
                birth_date = moment(dates[0]).format('YYYY-MM-DD')
                console.log('Birth: '+birth_date);
            },
        });

        $('#join-date').datepick({
            dateFormat: 'dd MMMM yyyy',
            useMouseWheel: false,
            yearRange: 'c-20:c-0',
            maxDate: 0,
            onClose: function(dates) { 
                join_date = moment(dates[0]).format('YYYY-MM-DD');
                console.log('Join: '+join_date);
				joinRequired();
            },
        });

        $('#title').change(function(){
            $("#simpan-data06").removeClass('disabled');
            if($(this).val() == '1'){
                $('#level').val('1');
                $('#level').attr('disabled', true);
                $("#level option[value='1']").attr("disabled",false);
                $("#level option[value='2']").attr("disabled",false);
                $('#rm').val('');
                pos_id = "DIR";
                pos_set = 1;

                //disable division
                $("#disable-div").removeClass('hide');
                $("#division").addClass('hide');

                //disable group
                $("#disable-group").removeClass('hide');
                $("#input-group").addClass('hide');

                //disable rm
                $("#disable-rm").removeClass('hide');
                $("#rm").addClass('hide');
            }else


            if($(this).val() == '2'){
                $('#level').val('2');
                $('#level').attr('disabled', true);
                $("#level option[value='1']").attr("disabled",false);
                $("#level option[value='2']").attr("disabled",false);
                pos_id = "";
                pos_set = 2;

                //disable division
                $("#disable-div").removeClass('hide');
                $("#division").addClass('hide');

                //enable group
                $("#disable-group").addClass('hide');
                $("#input-group").removeClass('hide');

                //enable rm
                $("#disable-rm").addClass('hide');
                $("#rm").removeClass('hide');
            }else
                // if not 1 or 2
            {
                $('#level').val('3');
                $('#level').attr('disabled', false);
                $("#level option[value='1']").attr("disabled",true);
                $("#level option[value='2']").attr("disabled",true);

                //refresh division box
                if(pos_set!=3){
                    $("#division > option").remove();
                    $(".wait").removeClass('hide');
                    $("#division").addClass('hide');
                    var sub_unsur_id = $('#input-group').val();
                    $.ajax({
                        type: "POST",
                        url: "c_oas006/load_division/"+sub_unsur_id,

                        success: function(cities)
                        {
                            $.each(cities,function(id,city)
                            {
                                var opt = $('<option />');
                                opt.val(id);
                                opt.text(city);
                                $('#division').append(opt);
                            });
                            $(".wait").addClass('hide');
                            $("#division").removeClass('hide');
                        }

                    });
                }
                pos_id = "";
                pos_set = 3;

                //enable division
                $("#disable-div").addClass('hide');
                $("#division").removeClass('hide');

                //enable group
                $("#disable-group").addClass('hide');
                $("#input-group").removeClass('hide');

                //enable rm
                $("#disable-rm").addClass('hide');
                $("#rm").removeClass('hide');
            }
        });

        
        $('#input-group').change(function(){
            if(pos_set == 3){
                $("#division > option").remove();
                $(".wait").removeClass('hide');
                $("#division").addClass('hide');
                var sub_unsur_id = $('#input-group').val();
                $.ajax({
                    type: "POST",
                    url: "c_oas006/load_division/"+sub_unsur_id,

                    success: function(cities)
                    {
                        $.each(cities,function(id,city)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(city);
                            $('#division').append(opt);
                        });
                        $(".wait").addClass('hide');
                        $("#division").removeClass('hide');
                    }

                });
            }

        });
        $('#simpan-data06').on('click', function(){
            clearErr();
			dontshow();

            // store error message
            var chgpwdmsg = "";
            var dosubmit = true;


            // Cek apakah email dan nik sudah digunakan
            if(edit==0){
                var form_data = {
                    employeeId      : $('#employee-id').val(),
                    email           : $('#email').val(),
                    ajax            : '1'
                };
                $.ajax({
                    url: "<?php echo site_url('c_oas006/check_data'); ?>",
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                    success: function(data) {
                        if(data == "1")
                        {
                            $('#chg-pwd-msg').html("Employye Id is already in use, please replace. <br>Status: " + data);
                            dosubmit = false;
                        }
                        else if(data == "2")
                        {
                            $('#chg-pwd-msg').html("Email is already in use, please replace. <br>Status: " + data);
                            dosubmit = false;
                        }
                        else if(data == "3")
                        {
                            $('#chg-pwd-msg').html("Employee Id dan Email is already in use, please replace. <br>Status: " + data);
                            dosubmit = false;
                        }
                        
                    },
                    error: function(){                      
                        $('#chg-pwd-msg').html("There was an error connecting to server.");
                        dosubmit = false;
                    }
                });
            }


            if(pos_set==1){
                pos_id = "DIR";
            }
            else if(pos_set==2){
                pos_id = $('#input-group').val();
            }
            else{
                pos_id = $('#division').val();
                if($('#division').val() == '0'){
                    pos_id = $('#input-group').val();
                }
            }
            
            // jika terjadi kesalahan, munculkan error
            if(chgpwdmsg != ""){
                $('#chg-pwd-msg').html(chgpwdmsg);
                dosubmit = false;
            }
			
			// Memberi batas maksimum dan minimum input password
			password =$('#input-password06').val();
			var panjang=password.length;
			if(($('#input-password06').val() != '') && (panjang<6 || panjang>50)){
				document.getElementById('spanPassword').innerHTML ="Password at least 6 characters and a maximum of 50 characters";
				dosubmit = false;				
			}
			//untuk simpan angka dalam format rupiah, 
			var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('annual-medical').value)))); 
			var transport = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('annual-transport').value)))); 
			var komunikasi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('annual-komunikasi').value)))); 
			periode = $('#medical_periode06').val();
			 
            if(dosubmit){
                console.log("Ajax call terpanggil")

                var form_data = { 
                    employeeId      : $('#employee-id').val(),
					nik            : $('#nik').val(),
                    name            : $('#name').val(),
                    join_dt         : moment(join_date).format('YYYY-MM-DD'),
                    marital          : $('#marital').val(),
					dependant          : $('#dependant').val(),
                    gender          : $('#gender').val(),
                    address         : $('#address').val(),
                    phone           : $('#phone').val(),
					statusem          : employee_status,
					employeepriv          : employee_privillege,
                    birth           : moment(birth_date).format('YYYY-MM-DD'),
                    email           : $('#email').val(),
                    password        : $('#input-password06').val(),
					cekPwd			: cekPwd,
                    user_group      : $('#user-group').val(),
                    status          : user_status,
					statuskar          : employee_status,
                    title           : $('#title').val(),
                    level           : $('#level').val(),
					getLevel		: getLevel,
                    position        : pos_id,
                    group_id        : $('#input-group').val(),
                    division_id     : $('#division').val(),
                    rm              : $('#rm').val(),
                    annual_leave    : $('#annual-leave').val(),
					annual_medical    : angka,
					periode			: periode,
					annual_transport    : transport,
					annual_komunikasi   : komunikasi,
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