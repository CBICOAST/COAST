<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS030
* Program Name     : Pengaturan Approval
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 16-03-2015 10:23:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

?>


<div class="box-content no-padding">
	<div class="box box-success">
    <div class="box-body">  
			<div class="form-group">
				<label class="col-sm-4 control-label">Approval For</label>
				<div class="input-group">
					<?php echo $approval['value']?>
				</div>
			</div>
			
			
			<div class="form-group" id="showname030">
				<label class="col-sm-4 control-label">Employee Name</label>
				<div class="input-group">
					<select id="nama030"onchange="getNamenoDiv()">
							<?php foreach ($employees as $key => $employee) { ?>
							<option value="<?= $employee['id'] ?>"<?php if($approval['nik']==$employee['id']) echo 'selected'?>
							><?= $employee['nama']?></option>
							<?php } ?>
					</select>  
				</div>
			</div>
			<button id="showdiv030" class="pull-left btn btn-danger btn-flat btn-slim">Sort Employee by Division</button>
			<div class="form-group" id="divdiv030">
				<label class="col-sm-4 control-label">Division</label>
				<div class="input-group">
					<select id="division030">
					<option style="display: none;" value=""> --choose one---</option>
							<?php foreach ($division_list as $key => $division) { ?>
							<option value="<?= $division['div_id'] ?>"
							><?= $division['div_id']?></option>
							<?php } ?>
					</select>                   
				</div>
			</div>
			<div class="form-group" id="hidename030">
				<label class="col-sm-4 control-label">Employee Name</label>
				<div class="input-group">
					 
                   <Span id="cb_approval030">	</Span>
				</div>
			</div>
        </div><!-- /.input-section -->
    </div><!-- /.box-body -->
	 <div class="box-footer clearfix">
		<div class="pull-left" id="msg030"></div>
        <button class="pull-right btn btn-primary" type="submit" id="btn_simpan030">SAVE</button>
    </div>
</div>
<script>
sembunyikankami();
var appfor = "<?=$approval['untuk']?>";
var empid = $('#nama030').val();
function sembunyikankami(){
	$('#hidename030').hide();
	$('#divcc030').hide();
	$('#divdiv030').hide();
	
}
function getNamenoDiv(){
	empid = $('#nama030').val();
}
function getName(){
	empid = $('#app_name030').val();
}
$(document).ready(function(){
	$('#showdiv030').on('click',function(){
		$('#divdiv030').show();
		$('#showdiv030').hide();
		$('#showname030').hide();
		$('#btn_simpan030').hide();
	
	 });
	
	$("#division030").change(function(){
		var code = $("#division030").val();
		$.ajax({
			url: "c_oas030/getEmployee",
			data: {"code":code},
			cache: false,
			success: function(msg)
				{	
					$('#hidename030').show();
					$('#btn_simpan030').show();
					$("#cb_approval030").html(msg);
					$('#cb_approval030').show();
				}					
			});
		});
		
		 $('#btn_simpan030').on('click', function(){
			var form_data = {
				appfor	: appfor,
				empid	: empid,
				ajax	: '1'
			}; 
		
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
        console.log(form_data);
			$.ajax({
				url: "c_oas030/update_approval",
				type: 'POST',
				async : false,
				data: form_data,
				timeout: 1000, //1000ms
				success: function(data) {
				   $('#msg030').html("<code><h5>Approval Update !</h5></code>");
                           setTimeout(function(){
                                form_dialog_close();
                            }, 1000); 
				},
				error: function(){                      
					alert("Failled");
					$('#msg030').html("<p><code><h5>Approval Failled Update ! </h5></code></p>");
				}
			});
		});

});
</script>
