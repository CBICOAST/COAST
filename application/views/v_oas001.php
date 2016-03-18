<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS001
* Program Name     : Login Screen
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Log in | CBI-OAS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo css_url();?>bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo css_url();?>font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo css_url();?>AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
		
			<div class="form-group" id="hideLogin01">
            <div class="header">Log In</div>
            <form action="<?php echo base_url();?>" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control email" placeholder="E-mail"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control password" placeholder="Password"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" id="submit" class="btn bg-olive btn-block">
                        <div class="login-text">Log me in</div>
                        <div class="login-progress hide">Please wait...</div>
                    </button>
                </div>
				<a href="#" id="forgotPwd">Forgot Password</a>
				
					
            </form>
			</div>
			<div class="form-group" id="hideReset01">
			<div class="header">Forgot Password</div>
            
                <div class="body bg-gray">
                   <div class="form-group">
						<input type="text" id="email4reset" class="form-control email" placeholder="Input Your E-mail"/>
                    </div> 					
               </div>
			   <div class="footer"> 
				<input type="submit" class="btn bg-olive" id="sendReset" value="submit">
				<input type="submit"id="backLogin" class="btn bg-olive" value="Cancel">
				</div>
	 
		 </div>

            <div class="margin text-center">
                <div style="background-color: #DDDDDD;
                               width: 80%;
                               border-radius: 5px 20px 5px;
                               margin-left: auto;
                               margin-right: auto;
                               margin-bottom: 0px">
                    <img src="<?php echo img_url();?>logo.png">
                </div>
                PT Cybertrend Intrabuana
                <br/>
                Office Automation System
            </div>
            <div id="message" class="margin text-center"
              style="margin-top: 50px;
                     margin-left: auto;
                     margin-right: auto;">
            </div>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="<?php echo js_url();?>jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo js_url();?>bootstrap.min.js" type="text/javascript"></script>        

    </body>
    <script type="application/javascript">
    var host = "<?php echo main_url();?>";
	$('#hideReset01').hide();
    $(document).ready(function() {
	
        $('#forgotPwd').click(function() {
			$('#hideReset01').show();
			$('#hideLogin01').hide();
        });
		$('#backLogin').click(function() {
			$('#hideReset01').hide();
			$('#hideLogin01').show();
        });
		$('#sendReset').click(function() {
			var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
			var string_length = 8;
			var randomstring = '';
			for (var i=0; i<string_length; i++) {
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
			}
			var emailReset =$('#email4reset').val();
			var newReset = randomstring;
			var form_data = {
                emailReset : emailReset,
				newReset : newReset,
                ajax : '1'
            };
			
            $.ajax({
                url: "c_oas001/resetPassword",
                type: 'POST',
                async : false,
                data: form_data,
                success: function(data) {
					alert("please check your email");					
                },
                error: function(){                      
                    $('#message').html("Kesalahan! Tidak dapat berkomunikasi dengan server.");
                }
            });
        });
		
        $('#submit').click(function() {
            $('#submit > div').removeClass("hide");
            $('.login-text').addClass("hide");
            $('#submit').addClass("disabled");
            $('.form-group').removeClass("has-error");
            var form_data = {
                email : $('.email').val(),
                password : $('.password').val(),
                ajax : '1'
            };
            $.ajax({
                url: "<?php echo site_url('Login/do_the_login'); ?>",
                type: 'POST',
                async : false,
                data: form_data,
                success: function(data) {
                    var stat = $.parseJSON(data);
                    // alert(stat['message']);
                    if(stat['email_field'] == "1"){
                        $('.email').parent().addClass("has-error");
                    }
                    if(stat['password_field'] == "1"){
                        $('.password').parent().addClass("has-error");
                    }
                    $('#message').html(stat['message']);
                },
                error: function(){                      
                    $('#message').html("Kesalahan! Tidak dapat berkomunikasi dengan server.");
                }
            });
            $('#submit > div').removeClass("hide");
            $('.login-progress').addClass("hide");
            $('#submit').removeClass("disabled");
            return false;
        });
    });
    </script>
</html>