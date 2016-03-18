<?php
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS009
* Program Name     : Informasi Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 19-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<h1>Prosedur Permohonan Cuti</h1>
<img src="<?php echo img_url(); ?>prosedur.png" style="max-height:300px">
<p>
   <p>
        <font face="Trebuchet MS" align="justify">Keterangan :</font>
	</p>
	<p>
		<p align="justify"> 1.) User mengisi Form Permohonan Cuti.</p>
	</p>
	<p>
		<p align="justify"> 2.) User dapat mengedit Permohonan Cuti yang sudah di submit selama form tersebut belum disetujui/ditolak atasan.</p>
	</p>
	<p>
		<p align="justify"> 3.) Atasan menerima Form Permohonan Cuti dan menyetujui/menolak form.</p>
	</p>
	<p>
		<p align="justify"> 4.) User dapat melihat status Form Permohonan Cutinya, apakah sudah mendapatkan approval dari atasan.</p>
	</p>
	<p>
		<p align="justify"> 5.) User dapat membatalkan Form Permohonan Cuti paling lambat pada hari pertama cutinya seperti yang tertera dalam form.</p>
	</p>

</p>
<div>
	<input type="checkbox" id="leave-inform-setting"> Dont show this information again<br>
	<button onclick="inform_setting(); change_page(this, 'c_oas010/load_view')" style="margin:1px 0;padding:3px;text-align:center">List of Leave Type</button>
</div>

<script type="text/javascript">
	function inform_setting () {
		if($('#leave-inform-setting').is(':checked')){
			var form_data = {
                ajax : '1'
            };
            
            console.log(form_data);

            $.ajax({
                url: "<?php echo site_url('c_oas009/dont_show_again'); ?>",
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