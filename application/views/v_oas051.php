<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS051
* Program Name     : Add/Edit Setting Limit Nominal Notif to Director
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma 
* Version          : 01.00.00
* Creation Date    : 23-11-2014 10:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
$edit = false;
if(isset($type_data))
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


    	<div class="requester-input form-section-container input-section">
		
		<div class="form-group">
				
                <label for="cc" class="col-sm-4 control-label">CURRENCY</label>
                <div class="input-group" >
				<select id="cc" >
                        <?php foreach ($list_type as $key => $level) { ?>
                        <option readonly value="<?= $level['CURRENCY'] ?>"
                            <?php if($edit && $type_data['CURRENCY'] == $level['CURRENCY']) echo 'selected' ?>><?= $level['val'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
			
           <div class="form-group">
                <label for="limit-nominal" class="col-sm-4 control-label">Nominal</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10" onkeyup="formatAngka(this, '.')" style="text-align: left; width: 75px" 
                            <?php if($edit){ ?> value="<?= number_format( $type_data['NOMINAL'],0,',','.'); ?>"<?}?>" placeholder="00" id="limit-nominal" class="form-control holo">
                </div>
            </div>
    		



    	</div><!-- /.form group -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
    	<div class="pull-left" id="new-limitnominal-msg"></div>
    	<button class="pull-right btn btn-primary" id="sbmt-new-expense" type="submit">SAVE</button>
    </div>

</div><!-- /.box -->
<script type="text/javascript">
var status 		 = null;
var url 		 = "<?php if($edit)
							echo 'c_oas051/update_form';
						else
							echo 'c_oas051/submit_form'; ?>";
var this_id = null;
<?php if($edit){ ?>
this_id = "<?= $type_data['ln_id'] ?>";
cc.disabled = true;
<?php } ?>

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



 $(function() {
     $('#sbmt-new-expense').on('click', function(){
	 
	 var nominal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('limit-nominal').value)))); 
	 
		var form_data = {
			currencyid 	: $('#cc').val(),
			limit_nominal : nominal,
			cc			: this_id,
			ajax			: 1
		}; 
		console.log(form_data);

		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				$( "#new-limitnominal-msg" ).html("Form submitted successfully. <br>Status: " + data);
                setTimeout(function(){
                    form_dialog_close();
                }, 1000);  
				console.log(data);
			},
			error: function(){                      
				$( "#new-limitnominal-msg" ).html("There was an error connecting to server.");
				console.log('eror');
			}
		});
    });
 });
 </script> 