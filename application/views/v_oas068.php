<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS068
* Program Name     : Edit Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 19-08-2014 11:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

$edit = false;
if(isset($edit_mode)){
	$edit = true;
}
?>
<?php if($edit) {?>
<link href="<?php echo css_url();?>daterangepicker/daterangepicker-bs3new.css" rel="stylesheet" type="text/css" /> 
<div class="box box-success">
    <div class="box-body">
        <div class="requester-detail form-section-container">
		
		<div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?=$this_name?> <?php if($edit) echo $info['employee_name'] ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?=$this_email?> <?php if($edit) echo $info['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?=$this_group?> <?php if($edit) echo $info['groupid'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterDivision">Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterDivision" placeholder="Divisi" value="<?=$this_division?> <?php if($edit) echo $info['divid'] ?>">
                        </div>
                    </div>			


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterRM">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterRM" placeholder="Atasan" value="<?= $this_rm['name'] ?>">
                        </div>
                    </div> 
                   
			<div class="form-group">
				<label for="no_id" class="col-sm-4 control-label">ID</label>
				<div class="input-group">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" value="<?php echo $info['bt_id'].'/'.$info['no_ref']?>" placeholder="" id="no_id" class="form-control holo">
				</div><!-- /.input group -->
			</div><!-- /.form group -->
			
			<div class="form-group">
                <label for="chargecodetype" class="col-sm-4 control-label">Charge Code Type</label>
                <div class="input-group">
					<input readonly type="text" maxlength="50" style="text-align: left; width: 175px" 
										value="<?php echo $tipechargecode['val_type']?>" placeholder="" id="chargecodetype" class="form-control holo">
                </div>
            </div>
		
			 <div class="form-group">
                <label for="chargecode" class="col-sm-4 control-label">Charge Code</label>
                <div class="input-group">
                    
                    <select id="chargecode" class="col-sm-16 control-label">
                        <?php foreach ($allcc as $key => $cc) { ?>
                        <option value="<?= $cc['ccname'] ?>"
                            <?php if($tipechargecode['charge_code']==$cc['ccname']) echo 'selected'?>><?= $cc['name'] ?></option>
                        <?php } ?>
                    </select> 
                </div>
            </div>
			
			
			
			
			
			<div class="requester-input form-section-container input-section">
				<h3>Detail BT</br></h3>
				<div class="form-group">
                        <label class="col-sm-4 control-label" for="btRange">Traveller Date :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input readonly type="text" class="form-control holo" id="btRange" value="<?php if($edit) echo $info['start_dt'].' - '.$info['end_dt']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Duration:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="btDuration" value="<?php if($edit) echo $info['duration']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
							
					<div class="form-group">
						<label class="col-sm-4 control-label">Amount</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-money"></i>
							</div>
							<input type="text" id="amount" onkeyup="digitsOnly(this)" onblur="digitsOnly(this)" onchange="digitsOnly(this)" class="form-control holo" value="<?php  echo $info['total'] ?>">
							<span id="result"  style="color:red;text-align:center"><br />
							</span>
						</div><!-- /.input group -->
					</div><!-- /.form group -->
					
					<div class="form-group"  id="divsisa" >
						<label class="col-sm-4 control-label" for="sisa">Limit:</label>
                        <div class="input-group">
							<div class="input-group-addon">
                                <i class="fa   fa-money"></i>
                            </div>
							<input type="text" id="sisa" readonly class="form-control holo">
						</div><!-- /.input group -->
                    </div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">Remarks</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-pencil"></i>
							</div>
							<textarea class="form-control" id="remarks" rows="3" placeholder="remarks..." input="textarea" ><?php  echo $info['keterangan']; ?></textarea>
						</div><!-- /.input group -->
					</div><!-- /.form group -->
				
					<div class="form-group" hidden>
                        <label class="col-sm-4 control-label" for="bulan">TES BULAN:</label>
                        <div class="input-group">
                           <input type="text" id="bulan" readonly class="form-control holo" >
                        </div><!-- /.input group -->
                    </div>
					
					<div class="form-group" hidden>
                        <label class="col-sm-4 control-label" for="bulanSekarang">TES BULAN 2:</label>
                        <div class="input-group">
                           <input type="text" id="bulanSekarang" readonly class="form-control holo" >
                        </div><!-- /.input group -->
                    </div>
							
			</div><!-- /.form group -->
		</div><!-- /.form group -->
	</div><!-- /.form group -->
</div><!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="pull-left" id="update-claim-msg"></div>
        <button class="pull-right btn btn-primary" id="sbmt-update-claim" type="submit">Update</button>
    </div>
	
</div><!-- /.box -->
	<?}?>
<script type="text/javascript">
 var startDate = null;
    var endDate = null;
    var btDuration = 0;
var receipt_date = null;
var amount = null;
var remarks = null;
var chargecode = null;
var aprove = "<?= $info['aprove'] ?>";

var refno			= "<?= $info['ref_no'] ?>";
<?php if($edit) { ?>
bt_id = "<?= $info['bt_id'] ?>";
receipt_date = "<?= $info['tanggal_kwitansi'] ?>";
amount = "<?= $info['total'] ?>";
remarks = "<?= $info['keterangan'] ?>";
var aprove = "<?= $info['aprove'] ?>";
<?php $bulan = date('m')?>;

var refno			= "<?= $info['ref_no'] ?>";
url = "c_oas068/submit_edit_form";
  
function digitsOnly(obj)
	{
	   $('#result').show();
	   var tipe = document.getElementById("claim_type_id");
	   obj.value=obj.value.replace(/[^\d]/g,'');
	   var sisa = $('#sisa').val();
	   var elem2 = document.getElementById("amount");
	   var total =elem2.value;
	   hasil = sisa - total;
	  
	  if (hasil < 0 ){
	  document.getElementById('result').innerHTML = "Maaf Anda melebihi limit";
	 $('#sbmt-update-claim').hide();
	 
	  }
	  else {
	  document.getElementById('result').innerHTML = "";
	 $('#result').hide();
	 $('#sbmt-update-claim').show();
	 
	  }
	}
	
	  function doCalculate(){
        btDuration += calcBusinessDays(startDate, endDate);
        console.log("Duration: " + btDuration);
        $('#btDuration').val(btDuration);  
		
    }

    function getWorkDay(initDate){
        var dt = initDate;
        dt = moment(dt).add(1, 'days').toDate();

        while(!isWorkDay(dt)
            || isHoliday(moment(dt).format('YYYY-MM-DD')) == '1'){
                dt = moment(dt).add(1, 'days').toDate();
        }
        return dt;
    }

    function isWorkDay(inputDate){
        return (inputDate.getDay() != 0 && inputDate.getDay() != 6 )
    }

    function isHoliday(inputDate){
    	var ret = null;
        inputDate = inputDate.split("-");
    	$.ajax({
	        url: "<?php echo site_url('c_oas037/isHoliday'); ?>",
	        type: 'POST',
	        async : false,
	        data: { month: inputDate[1],
                    day: inputDate[2],
                    year: inputDate[0],
                    ajax: '1' },
	        success: function(data) {
	        	ret = data;
	        },
	        error: function(){                      
	            ret = -1;
                server_error();
	        }
	    });
	    return ret;
    }

    function calcBusinessDays(dDate1, dDate2) { // input given as Date object
        var iWeeks, iDateDiff, iAdjust = 0;

        // Validate input date
        if (dDate2 < dDate1) 
            return -1; // error code if dates transposed

        var iWeekday1 = dDate1.getDay(); // day of week
        var iWeekday2 = dDate2.getDay();
        iWeekday1 = (iWeekday1 == 0) ? 7 : iWeekday1; // change Sunday from 0 to 7
        iWeekday2 = (iWeekday2 == 0) ? 7 : iWeekday2;
        if ((iWeekday1 > 5) && (iWeekday2 > 5)) iAdjust = 1; // adjustment if both days on weekend
        iWeekday1 = (iWeekday1 > 5) ? 5 : iWeekday1; // only count weekdays
        iWeekday2 = (iWeekday2 > 5) ? 5 : iWeekday2;

        // calculate differnece in weeks (1000mS * 60sec * 60min * 24hrs * 7 days = 604800000)
        iWeeks = Math.floor((dDate2.getTime() - dDate1.getTime()) / 604800000)

        if (iWeekday1 <= iWeekday2) {
            iDateDiff = (iWeeks * 5) + (iWeekday2 - iWeekday1)
        } else {
            iDateDiff = ((iWeeks + 1) * 5) - (iWeekday1 - iWeekday2)
        }

        iDateDiff -= iAdjust // take into account both days on weekend

        return (iDateDiff + 1); // add 1 because dates are inclusive
    }

	
 $(function() {
	
 //Money Euro
                // $("[data-mask]").inputmask();

                moment.locale('id', {
                    months : [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                    "Agustus", "September", "Oktober", "November", "Desember"
                    ]
                });


	  //Date range picker
                $('#btRange').daterangepicker({
                    format: 'DD MMMM YYYY',
                   
                    startDate: moment().add(+7, 'days'),
                    endDate: moment().add(8, 'days'),
                    opens: 'right',
                    locale: 'id'
                }
                );

                //Date range picker event
                $('#btRange').on('apply.daterangepicker', function(ev, picker) {
                	btDuration = 0;
            		$('#btDuration').val("Calcualting...");
					

            		startDate = new Date(picker.startDate.format('YYYY-MM-DD'));
                  	endDate = new Date(picker.endDate.format('YYYY-MM-DD'));

            		var form_data = {
		                start_date : picker.startDate.format('YYYY-MM-DD'),
		                end_date : picker.endDate.format('YYYY-MM-DD'),
		                ajax : '1'
		            };
		            $.ajax({
		                url: "<?php echo site_url('c_oas011/ajax_get_total_holiday'); ?>",
		                type: 'POST',
		                async : false,
		                data: form_data,
		                success: function(data) {
		                    btDuration -= data;
		                    doCalculate();
		                },
		                error: function(){                      
		                    server_error();
		                }
		            });
                });


	
     $('#sbmt-update-claim').on('click', function(){
		var info = {
			bt_id 				: bt_id,
			receipt_date 		    : receipt_date,
			amount					: $('#amount').val(),
			remarks	    			: $('#remarks').val(),	
			chargecode				: $('#chargecode').val(),
			aprove		: aprove,
			ref_no          : refno,
			ajax					: 1
		}; 
		console.log(info);

		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: info,
			timeout: 1000, //1000ms
			success: function(data) {
				$( "#update-claim-msg" ).html("Form berhasil di-submit. <br>Keterangan: " + data);
				setTimeout(function(){
                    form_dialog_close();
                }, 1000);  
				console.log(data);
			},
			error: function(){                      
				$( "#update-claim-msg" ).html("Terjadi kesalahan dalam menghubungi server.");
				console.log('eror');
			}
		});
    });
});
<?php } ?>
 </script>