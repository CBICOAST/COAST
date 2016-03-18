<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS064
* Program Name     : Add/Edit Dim Per Level
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 07:20:00 ICT 2014
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
                <label for="name" class="col-sm-4 control-label">Management Level</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <input type="text" readonly maxlength="50" style="text-align: left; width: 175px" value="<?php if($edit) echo $cost_info['LEVEL_NAME'] ?>" id="destination" class="form-control holo">
                </div>
            </div>
			<?php if(!$readonly){ ?>
			<div class="form-group">
                <label for="amount_dim" class="col-sm-4 control-label">Bandung Area</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10"  onkeyup="formatAngka(this, '.')"  style="text-align: left; width: 75px" 
                            <?php if($edit){ ?> value="<?= number_format( $cost_info['DIM_AMOUNT'],0,',','.'); ?>"<?}?>" placeholder="00" id="amount_dim" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="amount_dim_dom" class="col-sm-4 control-label">Domestic Area</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10"  onkeyup="formatAngka(this, '.')"  style="text-align: left; width: 75px" 
                           <?php if($edit){ ?> value="<?= number_format( $cost_info['DIM_AMOUNT_DOMESTIK'],0,',','.'); ?>"<?}?>" placeholder="00" id="amount_dim_dom" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="amount_dim_int" class="col-sm-4 control-label">International Area</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="10"  onkeyup="formatAngka(this, '.')"  style="text-align: left; width: 75px" 
					<?php if($edit){ ?> value="<?= number_format( $cost_info['DIM_AMOUNT_INTERNATIONAL'],0,',','.'); ?>"<?}?>" placeholder="00" id="amount_dim_int" class="form-control holo">
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
    var url = "<?php echo site_url('c_oas064/submit_new_employee'); ?>";
    var user_status = 1;
    var edit = 0;
    var success_status = '5';
	var cost_id = "<?= $cost_info['LEVEL_ID'] ?>";

    // akhir dari variabel untuk disubmit
      <?php if($edit) { ?>
    edit = 1;
    url = "<?php echo site_url('c_oas064/update_employee'); ?>";
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
				var amount_dim = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('amount_dim').value)))); 
				var amount_dim_dom = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('amount_dim_dom').value))));
				var amount_dim_int = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('amount_dim_int').value))));

                var form_data = {
                    destination   : $('#destination').val(),
					amount_dim    : amount_dim,
					amount_dim_dom    : amount_dim_dom,
					amount_dim_int    : amount_dim_int,
					cost_id : cost_id,
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