 <?php
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS028
* Program Name     : Informasi Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 16-12-2014 13:40:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/


?>

<h1>Prosedur Settlement</h1><br>
<img src="<?php echo img_url(); ?>settle.png" style="max-height:300px">
<p>
   <p>
        <font face="Castellar" align="justify">Keterangan :</font>
	</p>
	<p>
		<p align="justify"> 1.) Sebagai catatan form settlement hanya bisa dibuka apabila user memiliki kewajiban settlement,</p>
			<ul> - User yang memiliki tanggungan permohonan dana / Cash Advance yang telah dibayarkan oleh finance</ul>
			<ul> - User yang telah selesai melakukan perjalanan bisnis harus melakukan settlement cash advance Transportasi </ul>
	</p>
	<p align="justify"> 2.) Untuk melakukan Settlement, user mengisi form settlement berdasarkan no referensi dari pengajuan dana nya yang telah di diterima</p>
		<p align="justify"> 3.) User dapat mengedit data settlement yang sudah di submit selama pengajuan dana belum dikonfirmasi finance.</p>
	<p align="justify"> 4.) User dapat melihat status settlement, apakah diterima/ditolak oleh finance</p>
	
		<p align="justify"> 5.) Finance mendapatkan pemberitahuan pengajuan settlement dan menerima/menolaknya  </p>
		<p align="justify"> 5.) Finance melakukan konfirmasi pembayaran untuk settlement yang tidak balance  </p>
		<p align="justify"> 6.) Setelah melakukan Settlement, User dapat melakukan kembali pengajuan dana</p>
	</p>
	</p>
	

</p>
<div>
	<input type="checkbox" id="settle-inform-setting"> Dont show this information again<br>
	<button onclick="inform_setting(); change_page(this, 'c_oas039/load_view')" style="margin:1px 0;padding:3px;text-align:center">Settlement Form</button>
</div>

<script type="text/javascript">
	function inform_setting () {
		if($('#settle-inform-setting').is(':checked')){
			var form_data = {
                ajax : '1'
            };
            
            console.log(form_data);

            $.ajax({
                url: "<?php echo site_url('c_oas028/dont_show_again'); ?>",
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
