<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS053
* Program Name     : Edit Cost BT Related CA
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 15-11-2014 23:20:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
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
    <div class="box-body">
        
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Destination</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" readonly maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $cost_info['DESTINATION'] ?>" id="destination" class="form-control holo">
                </div>
            </div>
			<?php if(!$readonly){ ?>
			<div class="form-group">
                <label for="cost_idr" class="col-sm-4 control-label">Cost (IDR)</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10" onkeyup="formatAngka(this, '.')" style="text-align: left; width: 75px" 
                             <?php if($edit){ ?> value="<?= number_format( $cost_info['COST'],0,',','.'); ?>"<?}?>" placeholder="00" id="cost_idr" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="cost_usd" class="col-sm-4 control-label">Cost (USD)</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10" onkeyup="formatAngka(this, '.')" style="text-align: left; width: 75px" 
                             <?php if($edit){ ?> value="<?= number_format( $cost_info['COST_USD'],0,',','.'); ?>"<?}?>" placeholder="00" id="cost_usd" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="cost_usd" class="col-sm-4 control-label">Cost (SGD)</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10" onkeyup="formatAngka(this, '.')" style="text-align: left; width: 75px" 
                             <?php if($edit){ ?> value="<?= number_format( $cost_info['COST_SGD'],0,',','.'); ?>"<?}?>" placeholder="00" id="cost_sgd" class="form-control holo">
                </div>
            </div>
			
            <?php } ?>
        </div><!-- /.input-section -->
    </div><!-- /.box-body -->
</div><!-- /.box-success -->
    <?php if(!$readonly){ ?>
    <div class="box-footer clearfix">
        <div class="pull-left" id="chg-pwd-msg"></div>
        <button class="pull-right btn btn-primary 
            <?php if(!$edit) echo'disabled';?>" type="submit" id="simpan-data">SAVE</button>
    </div>
    <?php }?>
	
</div><!-- /.box -->



<script type="text/javascript">
    // variabel untuk disubmit
    var url = "<?php echo site_url('c_oas053/submit_new_employee'); ?>";
    var user_status = 1;
    var edit = 0;
    var success_status = '5';
	var cost_id = "<?= $cost_info['COST_ID'] ?>";

    // akhir dari variabel untuk disubmit
      <?php if($edit) { ?>
    edit = 1;
    url = "<?php echo site_url('c_oas053/update_employee'); ?>";
    success_status = '1';
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

    function clearErr()
    {
        $('.form-group').removeClass("has-error");
        $('#chg-pwd-msg').html("");
    }

   
    $(function() {
        <?php if($readonly){ ?>
        $('.new-employee-form').find('input, textarea, select').attr('disabled', true);
        <?php } ?>
		
        $('#simpan-data').on('click', function(){
            clearErr();
            var chgpwdmsg = "";
            var dosubmit = true;

            // jika terjadi kesalahan, munculkan error
            if(chgpwdmsg != ""){
                $('#chg-pwd-msg').html(chgpwdmsg);
                dosubmit = false;
            }
           
          
            if(dosubmit){
                console.log("Ajax call terpanggil")

				var cost_idr = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('cost_idr').value)))); 
				var cost_usd = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('cost_usd').value)))); 
				var cost_sgd = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('cost_sgd').value)))); 
				
                var form_data = {
                    destination	: $('#destination').val(),
					cost_idr	: cost_idr,
					cost_usd	: cost_usd,
					cost_sgd	: cost_sgd,
					cost_id		: cost_id,
                    ajax        : '1'
                };
                
                console.log(form_data);

                $.ajax({
                    url: url,
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                    success: function(data) {
                        if(data == success_status)
                        {
                            $('#chg-pwd-msg').html("Data berhasil diolah. <br>Status: " + data);
                            setTimeout(function(){
                                form_dialog_close();
                            }, 1000);     
                        }
                        else
                        {
                            $('#chg-pwd-msg').html("Terjadi kesalahan dalam pengolahan data. <br>Status: " + data);
                            console.log(data);
                        }
                        
                    },
                    error: function(){                      
                        $('#chg-pwd-msg').html("Terjadi kesalahan dalam menghubungi server.");
                    }
                });
            }
        });



    });
</script>