<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS037
* Program Name     : Form Pengajuan Business Travel
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 26-11-2014 9:19:00 ICT 2014
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
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
	$("#btr_destination").change(function(){
		var btr_destination = $('#btr_destination').val();

		$.ajax({
			url: "c_oas037/get_cost",
			data: "btr_destination="+btr_destination,
			cache: false,
			success: function(msg)
				{
				$("#hiddencost").html(msg);
				var cost = $("#cost").val();
				var amountid = $("#amountid").val();
				var amountid1 = $("#amountid1").val();
				var amountid2 = $("#amountid2").val();
				var duration =  $("#btDuration").val();
				var costTransportation = document.getElementById("btr_limit");
				var travellerAmountDim = document.getElementById("btr_amount_dim");
				costTransportation.value =cost;
	<?php if(!$edit) { ?>
 showButton();
    
    <?php } ?>
				}
			});
	});
	
	$("#bt_traveller_name").change(function(){
		var bt_traveller_name = $('#bt_traveller_name').val();
		$.ajax({
			url: "c_oas037/get_traveller",
			data: "bt_traveller_name="+bt_traveller_name,
			cache: false,
			success: function(msg)
				{
				$("#hiddengroup").html(msg);
				var groupid = $("#groupid").val();
				var posid = $("#posid").val();
				var approval =  $("#approval").val();
				var approval_email = "<?php echo $form_data['approval_email']; ?>";
				var approval_name = "<?php echo $form_data['approval_name']; ?>";
				var employee_name = "<?php echo $form_data['name']; ?>";
				var groupTraveller = document.getElementById("btr_group");
				var travellerApproval = document.getElementById("btr_approval");
				var postTraveller = document.getElementById("btr_approve");
				groupTraveller.value =groupid;
				postTraveller.value =posid;
				travellerApproval.value =approval;			
	 <?php if(!$edit) { ?>
 showButton();
    
    <?php } ?>}
			});
	});
		
	$("#btr-cctype").change(function(){
		var code	= $("#btr-cctype").val();
		var tipecc	= document.getElementById("btr-cctype");
		
		activity='4';
		
		$.ajax({			
			url: "c_oas037/get_pd",
			data: "code="+code,
			cache: false,
			success: function(msg)
			{
				$("#btr").html(msg);		
				$('#btr-cchidden').show();					
			}
		});
	});
	$("#btr").change(function(){
		var charge_code = $("#cc").val();
		var elem = document.getElementById("btr-chargecode");
		elem.value =charge_code;
		 <?php if(!$edit) { ?>
 showButton();
    
    <?php } ?>
	});
});
</script>
<!-- daterange picker -->
<link href="<?php echo css_url();?>daterangepicker/daterangepicker-bs3new.css" rel="stylesheet" type="text/css" /> 


<div class="row">
    <div class="col-md-11">
		<div class="box box-solid box-danger">
			<div class="box-header">
                <h3 class="box-title"> Bussiness Travel Related Request </h3>
            </div>
            <div class="box-body">
                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?=$this_name?> <?php if($edit) echo $form_data['idemp'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?=$this_email?> <?php if($edit) echo $form_data['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?=$this_group?> <?php if($edit) echo $form_data['groupid'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterDivision">Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterDivision" placeholder="Divisi" value="<?=$this_division?> <?php if($edit) echo $form_data['divid'] ?>">
                        </div>
                    </div>			


                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="requesterRM">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterRM" placeholder="Atasan" value="<?= $this_rm['name'] ?>">
                        </div>
                    </div> 
                   
                </div> <!-- /.requester-detail -->
				
				
				<div class="requester-input form-section-container input-section">
				
				<div class="form-group">
                        <label class="col-sm-3 control-label" for="btRange">Traveller Date :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input readonly type="text" class="form-control holo" id="btRange" value="<?php if($edit) echo $form_data['start_dt'].' - '.$form_data['end_dt']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Duration:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="btDuration" value="<?php if($edit) echo $form_data['duration']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
				<div class="form-group">
					<label class="col-sm-3 control-label">Traveller Name:</label>
					<div class="input-group">
						<select  id="bt_traveller_name" onChange="approve">
							<option style="display: none;" >--choose one---</option>
							<?php foreach ($name_list as $key => $type) { ?>
							<option value="<?=$type['id'] ?>"  <?php if($edit && $form_data['employee_id'] == $type['id']) echo 'selected' ?>><?= $type['name'] ?></option>
							<?php } ?>
						</select> 
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div id="hiddengroup" hidden></div>
				<div class="form-group" hidden >
					<label class="col-sm-3 control-label">Group:</label>
					<div class="input-group">
						<input type="text" class="form-control holo" id="btr_group">
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group" hidden >
					<label class="col-sm-3 control-label">Pos ID:</label>
					<div class="input-group">
						<input type="text" class="form-control holo" id="btr_approve" value="<?php if($edit) echo $form_data['posid'] ?>"/>
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group" hidden >
					<label class="col-sm-3 control-label">Approval:</label>
					<div class="input-group">
						<input type="text" class="form-control holo" id="btr_approval" value="<?php if($edit) echo $form_data['approval'] ?>"/>
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Destination:</label>
					<div class="input-group">
						<select  id="btr_destination">
							<option style="display: none;" >--choose one---</option>
							<?php foreach ($destination as $key => $type) { ?>
							<option value="<?=$type['id']?>" <?php if ($edit && $form_data['destination'] == $type['id']) echo 'selected' ?>><?= $type['destination'] ?></option>
							<?php } ?>
						</select> 
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group" >
					<label class="col-sm-3 control-label">Total Dim:</label>
					<div class="input-group">
						<input type="text" class="form-control holo" onkeyup="formatAngka(this, '.')" id="btr_amount_dim"  onchange="approve()" <?php if($edit){ ?> value="<?= number_format( $form_data['totaldim'],0,',','.'); ?>"<?}?>>
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group" hidden>
					<label class="col-sm-3 control-label">Currency:</label>
					<div class="input-group">
					
						<select  id="btr_currency">
							<?php foreach ($currency as $key => $type) { ?>
							<option value="<?=$type['id']?>"><?= $type['name'] ?></option>
							<?php } ?>
						</select> 
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div id="hiddencost" hidden>	</div>
				<div class="form-group" hidden>
					<label class="col-sm-3 control-label">CA Transport:</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-money"></i>
						</div>
						<input type="text" class="form-control holo" id="btr_limit" value="<?php if($edit) echo $form_data['transportca'] ?>">
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Client:</label>
					<div class="input-group">		
						<input type="text" class="form-control holo" id="btr_client"  value="<?php if($edit) echo $form_data['client'] ?>">
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Business Purpose:</label>
					<div class="input-group">						
						<input type="text" class="form-control holo" id="btr_bp" value="<?php if($edit) echo $form_data['bp'] ?>">
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Customer Location:</label>
					<div class="input-group">	
						<input type="text" class="form-control holo" id="btr_cust" value="<?php if($edit) echo $form_data['custloc'] ?>">
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Transportation BY:</label>
					<div class="input-group">
						<select  id="btr_transportation">
							<option style="display: none;" >--choose one---</option>
							<?php foreach ($transportation as $key => $type) { ?>
							<option value="<?=$type['id']?>" <?php if ($edit && $form_data['transport'] == $type['id']) echo 'selected' ?>><?= $type['transportation'] ?></option>
							<?php } ?>
						</select> 
					</div><!-- /.input group -->
				</div><!-- /.form group -->
				
				<div class="form-group" id="typecc">
					<label class="col-sm-3 control-label">Charge Code Type</label>
					<div class="input-group">
						<select  id="btr-cctype">
							<option style="display: none;" value="">--choose one---</option>
							<?php foreach ($list_cctype as $key => $type) { ?>
							<option value="<?=$type['id']?>"<?php if ($edit && $cctypeid == $type['id']) echo 'selected' ?>><?= $type['name'] ?></option>
							<?php } ?>
						</select> 
					</div>
				</div>
				<?php if (!$edit){?>
				
				<div class="form-group" id="btr-cchidden" >
					<label for="group" class="col-sm-3 control-label">Project Description</label>
					<div class="input-group">
						<div id="btr">
						<input type="text" class="form-control holo" id="btr-cchidden" value="<?php if($edit) echo $form_data['projectdecsript'] ?>">
						</div>
					</div>
				</div> <?}if ($edit){?> <div class="form-group" >
                <label for="chargecode" class="col-sm-3 control-label">Project Description</label>
                <div class="input-group">
						<div id="btr2" onchange="ccode()"><select id="CA_chargecode" >
						
						<?php if($edit){
                        foreach ($list_chargecode as $key => $cc) { ?>
                        <option value="<?= $cc['id'] ?>"
						<?php if($edit &&  $chargecodeid == $cc['id']) echo 'selected'?>><?= $cc['name'] ?></option>
                        <?php }
                        } ?>				
                    	</select></div>
					</div>
				</div> <?}?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Charge Code</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
						<input readonly type="text" class="form-control holo" id="btr-chargecode" value="<?php if($edit) echo $form_data['cc'] ?>">
					</div><!-- /.input group -->          
				</div>
				
				<div class="form-group"  id="btr_payment" >
                <label class="col-sm-3 control-label" for="sisa">Payment Method:</label>
                <div class="input-group">
                    <input type="radio" name="btr_payment_method" value='1' 
						<?php if($edit && $form_data['pm'] == '1') echo 'checked' ?>>Cash <td>
					<input type="radio" name="btr_payment_method" value='2'
						<?php if($edit && $form_data['pm'] == '2') echo 'checked' ?>>Transfer </td>
                </div>
            </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Remarks:</label>
					<div class="input-group">
					<div class="input-group-addon">
							<i class="fa fa-file"></i>
						</div>
					<?php if(!$edit){?>
					<textarea class="form-control holo" rows="5" cols="100" id="btr_remarks"></textarea><?}?>
					<?php if($edit){?>
					<input maxlength="200" type="text" class="form-control holo" id="btr_remarks" value="<?php if($edit) echo $form_data['remark'] ?>"></input><?}?>
					</div>
				</div>
			</div> <!-- /.requester-input -->
		</div><!-- /.box-body -->
		
		<div class="box-footer clearfix">
			<div class="pull-left" id="submit-btr-msg"></div>
			<?php if(!$edit){?>
			<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas007/load_view')">Back...</button>
			<?}?>
			<?php if($edit){?>
			<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas045/load_view')">Back...</button>
			<?}?>
			<button type="submit" class="pull-right btn btn-primary" id="btr-form-submit-btn"> Submit </button>
		</div>
	</div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

<!-- InputMask -->
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo js_url();?>plugins/daterangepicker/daterangepickernew.js" type="text/javascript"></script>
<!-- Page script -->
<script type="text/javascript">
 var startDate = null;
    var endDate = null;
    var btDuration = 0;
// sembunyikan dulu sebelum yang harus diisi nya keisi semua
$('#btr-form-submit-btn').hide();
var edit = 0;
$('#result').hide();
employeeid 	= '<?= $this_id ?>';
var btr_payment_method = null;
var formId = null;
var approval = null;

var approval_name = null;
var employee_name = null;
var approval_email = null;
var cc = null;
var costTransportation = null;
$('#btr-cchidden').hide();

 <?php if(!$edit) { ?>
 
    employeeid = '<?= $this_id ?>';
    url = "<?php echo site_url('c_oas037/submit_form'); ?>"
    <?php } ?>

	<?php if($edit) { ?>
    formId = "<?= $form_data['bt_id'] ?>";
    url = "<?php echo site_url('c_oas037/submit_update_form'); ?>";
	
	
	angka = "<?= $form_data['totaldim'] ?>";
	employeeid = "<?= $form_data['employee_id'] ?>";	
	approval = "<?= $form_data['approval'] ?>";	
	approval_name = "<?= $form_data['approval_name'] ?>";
	employee_name = "<?= $form_data['employee_name'] ?>";
	approval_email = "<?= $form_data['approval_email'] ?>";
    startDate = new Date("<?= $form_data['start_dt'] ?>");
    endDate = new Date("<?= $form_data['end_dt'] ?>");
    duration = "<?= $form_data['btDuration'] ?>";
	btr_payment_method ="<?= $form_data['pm'] ?>";
	cc = "<?= $form_data['cc'] ?>";
	$('#btr-form-submit-btn').show();
	
    <?php } ?>
// tampilin button submit kalau fieldnya dah keisi semua

function showButton(){
	
	if (((btr_payment_method == '1') || (btr_payment_method == '2')) && ($('#btr_amount').val() != '')  && ($('#btr_limit').val() != '0') && ($('#btr_client').val() != '') && ($('#btr_bp').val() != '') && ($('#btr_cust').val() != '') && ($('#btr-chargecode').val() != '')) {
		$('#btr-form-submit-btn').show();	
	}
	else {
		$('#btr-form-submit-btn').hide();
	}
}

function ccode()
{
	var charge_code = $("#CA_chargecode").val();
	var elem = document.getElementById("btr-chargecode");
	elem.value =charge_code;
	cc = $('#btr-chargecode').val() ;
}

function transport()
{
	var cost =  $("#cost").val();
	var elem = document.getElementById("btr_limit");
	elem.value =cost;
	costTransportation = $('#btr_limit').val() ;
	
}

$("#btr_destination").change(function(){
		var btr_destination = document.getElementById("btr_destination");
		if (btr_destination.value == '1'){
				var travellerAmountDim = document.getElementById("btr_amount_dim");
				var amountid = $("#amountid").val();
				travellerAmountDim.value =amountid*btDuration;
		}
		if (btr_destination.value == '2'){
				var travellerAmountDim = document.getElementById("btr_amount_dim");
				var amountid1 = $("#amountid1").val();
				travellerAmountDim.value =amountid1*btDuration;
		}
		if (btr_destination.value == '3'){
				var travellerAmountDim = document.getElementById("btr_amount_dim");
				var amountid2 = $("#amountid2").val();
				travellerAmountDim.value =amountid2*btDuration;
		}
	});
	
//untuk format angka nominal amount
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


// Mengambil limit cost berdasarkan mata uang yang dipilih
	$("#btr_currency").change(function(){
		var currency = document.getElementById("btr_currency");
		if (currency.value == '1'){
				var costTransportation = document.getElementById("btr_limit");
				var cost = $("#cost").val();
				costTransportation.value =cost;
		}
		if (currency.value == '2'){
				var costTransportation = document.getElementById("btr_limit");
				var cost = $("#costUsd").val();
				costTransportation.value =cost;
		}
	});
	
	
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
            iDateDiff = (iWeeks * 7) + (iWeekday2 - iWeekday1)
        } else {
            iDateDiff = ((iWeeks + 1) * 7) - (iWeekday1 - iWeekday2)
        }

        iDateDiff -= iAdjust // take into account both days on weekend

        return (iDateDiff + 1); // add 1 because dates are inclusive
    }



$(function() {
		
		
<? if ($edit){?>
$('#btr-cctype').change(function(){
        
        $("#CA_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#CA_chargecode").addClass('hide');
        var sub_unsur_id = $('#btr-cctype').val();
        $.ajax({
            type: "POST",
            url: "c_oas037/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#CA_chargecode').append(opt);
					 ccode();
                });
                $(".wait").addClass('hide');
                $("#CA_chargecode").removeClass('hide');
            }
        });  
    }	
	);
	
	<?}?>

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
					minDate: moment().add(0, 'days'),
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
		                url: "<?php echo site_url('c_oas037/get_calculate'); ?>",
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


				
	// ambil value radio button yang dipilih
	$('input:radio[name=btr_payment_method]').on('click',function(){
            btr_payment_method = $(this).val();
			 <?php if(!$edit) { ?>
 showButton();    
    <?php } ?>
     });
	 
	// submit button
	$('#btr-form-submit-btn').on('click', function(){
	var posid = (document.getElementById("btr_approve").value);
	if (posid > 2){
		approval = (document.getElementById("btr_approval").value);}
		if (posid == 2){
		approval = '<?php echo $detail_dir['id'];?>';}
		if (posid < 2){
		approval = '<?php echo $detail_ga2['id'];?>';}
		
		 <?php if($edit) { ?>
	if (posid > 2){
		approval = "<?= $form_data['approval'] ?>";	}
		if (posid == 2){
		approval = '<?php echo $detail_dir['id'];?>';}
		if (posid < 2){
		approval = '<?php echo $detail_ga2['id'];?>';}
    
    <?php } ?>
		
	//input ke dalam angka tanpa titik
            var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('btr_amount_dim').value)))); 
			var costTransportation = (document.getElementById("btr_limit").value);
		var form_data = {

			employeeId      	: employeeid,
			formid          	: formId,			
			client				: $('#btr_client').val(),
			bp				    : $('#btr_bp').val(),
			cust				: $('#btr_cust').val(),
			transportby			: $('#btr_transportation').val(),
			chargeCode			: $('#btr-chargecode').val(),
			tujuan				: $('#btr_destination').val(),
			traveller			: $('#bt_traveller_name').val(),
			duration			: $('#btDuration').val(),
			amountdim			: angka,
			amounttransport		: costTransportation,
			paymentMethod		: btr_payment_method,
			start_date          : moment(startDate).format('YYYY-MM-DD'),
            end_date            : moment(endDate).format('YYYY-MM-DD'),
			remark				: $('#btr_remarks').val(),
			employee_name		: employee_name,
			approval			: approval,
			approval_email		: approval_email,
			approval_name		: approval_name,
			submittedDate   	: moment().format('YYYY-MM-DD'),
			ajax				: 1
		}; 
		 
		 var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

		$.ajax({
			url			: url, 
			type		: 'POST',
			async		: false,
			data		: form_data,
			timeout		: 1000, //1000ms
			 success: function(data) { <?php if($edit){?>
						alert("Success!");	
                            location.reload();<?}else{?>
								alert("Form submitted successfully!");			location.reload();
                        <?}?>
                        },
			error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas044/load_form\")'>Back</button>");
                      
                        }
		});
    });
});
</script>