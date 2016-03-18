<?php
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS009
* Program Name     : Informasi Permohonan bisnis travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 16-12-2014 09:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<h1>Prosedur Permohonan Business Travel/Perjalanan Bisnis</h1>
<img src="<?php echo img_url(); ?>BT.png" style="max-height:500px">

<div>
	<input type="checkbox" id="bt-inform-setting"> Jangan munculkan lagi informasi ini.<br>
	<button onclick="inform_setting(); change_page(this, 'c_oas037/load_view')" style="margin:1px 0;padding:3px;text-align:center">Submit BT</button>
</div>

<script type="text/javascript">
	function inform_setting () {
		if($('#bt-inform-setting').is(':checked')){
			var form_data = {
                ajax : '1'
            };
            
            console.log(form_data);

            $.ajax({
                url: "<?php echo site_url('c_oas007/dont_show_again'); ?>",
                type: 'POST',
                async : false,
                data: form_data,
                timeout: 10000, //1000ms
                success: function(data) {
                	console.log("Success switched to don't show again. Status: "+data);
                },
                error: function(){                      
                    console.log("Error happen when ajax calling.");
                }
            });
		}
		return true;
	}
</script>