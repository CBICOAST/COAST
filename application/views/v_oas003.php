<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS003
* Program Name     : Welcome Page
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 18-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
*1					17-11-2014			Metta Kharisma		 Merubah Tampilan
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>


<br></br><br></br><br></br><br></br>
<center><img src="<?php echo img_url(); ?>welcome_page_logo.png" max-width="1000"></center>

<?if ($this_pwdStat['STATUS_PASSWORD'] =='OLD'){?>

 <div>
	  <label style="color:red">Please Change Your Password before Access the System</label>
	<br></br>
 </div>
 <div class="form-group">
                <label for="new-password" class="col-sm-4 control-label">New Password</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" class="form-control holo" id="new-password03" onkeyup="pwdRequired()">
                </div><!-- /.input group -->
				
				<span id="spanNewPwd03"style="color:red;"></span>
            </div><!-- /.form group -->

            <div class="form-group">
                <label for="re-new-password" class="col-sm-4 control-label">Repeat New Password</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input type="password" id="re-new-password03" class="form-control holo" onkeyup="repwdRequired()">
                </div><!-- /.input group -->
				
				<span id="spanreNewPwd03"style="color:red;"></span>
            </div><!-- /.form group -->
        </div> <!-- /.requester-input -->
		 <div class="box-footer clearfix">
		 <center>
        <button type="submit" id="save_new_pwd03">Change Password</button> </center>
    </div>
<?}?>
<h1 style ="text-align:center">Cybertrend Office Automation System</h1>
<h2 style ="text-align:center">PT. Cybertrend  Intrabuana</h2>

<br></br>

<script type="text/javascript">
var password = null;
	ajax = '0';
	function pwdRequired(){
		if ($('#new-password03').val() == ''){
			document.getElementById('spanNewPwd03').innerHTML = "Password is Required";
		}
		else{			
			document.getElementById('spanNewPwd03').innerHTML = "";
			password =$('#new-password03').val();           
		}
	}
	function checkLength(){
	password =$('#new-password03').val();
	var panjang=password.length;
		if(($('#new-password03').val() != '') && (panjang<6 || panjang>50)){
			document.getElementById('spanNewPwd03').innerHTML ="Password at least 6 characters and a maximum of 50 characters";
		}
		else{			
			document.getElementById('spanNewPwd03').innerHTML = "";
		}
	}

	
	function repwdRequired(){
		if ($('#re-new-password03').val() == ''){
			document.getElementById('spanreNewPwd03').innerHTML = "Please re-Type Your Password ";
		}
		else{			
			document.getElementById('spanreNewPwd03').innerHTML = "";
		}
	}
	function checkMatch(){
		if (($('#re-new-password03').val() != '') && ($('#re-new-password03').val() != $('#new-password03').val())){
			document.getElementById('spanreNewPwd03').innerHTML = "Password not match";
		}
		else if (($('#re-new-password03').val() != '') && ($('#re-new-password03').val() == $('#new-password03').val()) &&(
		document.getElementById('spanNewPwd03').innerHTML == '')){
			ajax = '1';
		}
		else{			
			document.getElementById('spanreNewPwd03').innerHTML = "";
			repwdRequired();
		}
	}

$(function() {
	 $('#save_new_pwd03').on('click', function(){
	 pwdRequired();
	 checkLength();
	 checkMatch();
	 if (ajax =='1'){
	 var form_data = {
			password	: password,
			ajax		: ajax		
		   
		}; 
		console.log(form_data);

		$.ajax({
			url: "c_oas003/change_password",
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				alert("Password Berhasil diubah");
				location.reload();
			},
			error: function(){                      
				$( "#claim-sbmt-msg" ).html("Terjadi kesalahan dalam menghubungi server.");
				console.log('eror');
			}
		});
		}
	 });
});
</script>



