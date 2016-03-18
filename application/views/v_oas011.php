<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS011
* Program Name     : Create/Edit Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 21:21:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0                04 Nov 2014       Metta Kharisma H      Merubah tampilan view
* 2.0				 26 Feb 2015	   Dwi Irawati     		 Menambah variabel nama dan email RM
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

$form_id = $form_data['id'];
$edit = false;
if(isset($edit_stat))
{
    $edit = true;
}

?>


<!-- daterange picker -->
<link href="<?php echo css_url();?>daterangepicker/daterangepicker-bs3new.css" rel="stylesheet" type="text/css" />



<div class="row">
    <div class="col-md-7">

        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">LEAVE APPLICATION FORM</h3>
            </div>
            <div class="box-body">

                <div class="requester-detail form-section-container">

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?php if(!$edit) echo $this_name; else echo $form_data['employee_name']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php if(!$edit) echo $this_email; else echo $form_data['employee_email']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?= $this_group ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="requesterDivision">Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterDivision" placeholder="Divisi" value="<?= $this_division ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="requesterRM">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterRM" placeholder="RM" value="<?= $this_rm['name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveType">Leave Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="leaveType" placeholder="Type" value="<?= $form_data['leave_name'] ?>">
                        </div>
                    </div>

                    
                    <?php if($form_id == '1' || $form_data['length'] != '0'){ ?>
                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="requesterLeave">
                              <?php if($form_id == '1') 
                                    echo 'Current Year Leave Balance '; 
                                else
                                    echo 'Maximal Leave';?>
                        </label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterLeave" placeholder="residue" value="<?= $form_data['length'] ?>">
                        </div>
                    </div>
                    <?php } ?>
                </div> <!-- /.requester-detail -->

                <div class="requester-input form-section-container input-section">
                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveRange">Date Of Leave:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input readonly type="text" class="form-control holo" id="leaveRange" value="<?php if($edit) echo $form_data['start_dt'].' - '.$form_data['end_dt']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->


                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="comeBack">Back To Office:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" readonly id="comeBack" class="form-control holo" value="<?php if($edit) echo $form_data['comeback']; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveTotal">Leave to be Taken:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveTotal" value="<?php if($edit) echo $form_data['amount']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <?php if($form_id == '1') { ?>
                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveLeft">Leave Balance:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveLeft" value="<?php if($edit) echo $form_data['length']-$form_data['amount']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <?php } ?>

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveAddress">Address during leave :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-home"></i>
                            </div>
                            <input type="text" class="form-control holo" id="leaveAddress" value="<?php if($edit) echo $form_data['address']; ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="leaveCall">Telp No:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" id="leaveCall" class="form-control holo" value="<?php if($edit) echo $form_data['phone']; ?>" data-inputmask="'mask': ['999-999-999-9[99]', '+99 99 99 9999[999]']" data-mask/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div> <!-- /.requester-input -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <?php if(!$edit) { ?>
                <button type="button" class="pull-left btn btn-default"  onclick="change_page(this, 'c_oas010/load_view')">Back...</button>
                <?php }else{ ?>
                <button type="button" class="pull-left btn btn-default"  onclick="change_page(this, 'c_oas015/load_view')">Back...</button>
                <?php } ?>
                <button type="submit" class="pull-right btn btn-primary 
                            <?php if(!$edit) echo'disabled';?>" id="leave-form-submit-btn">
                <div class="pull-right" id="leave-sbmt-msg"></div>
                     <?php if(!$edit) echo 'Submit'; else echo 'Update';?>
                </button>
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
    var leaveTotal = 0;
    var comeBackDate = null;
    var leaveLeft = $('#requesterLeave').val();
    var leaveMin = <?= $form_data['minimum_day'] ?>;
    // var bDayHolidayTotal = 0;
    
    var employeeid = null;
    var leavetypeid = null;
    var employeeRM = null;
    var formId = null;
    var url = null;

    // thsisasbmtfrm
    <?php if(!$edit) { ?>
    employeeid = '<?= $this_id ?>';
    leavetypeid = "<?= $form_data['id'] ?>";
    employeeRM = "<?= $this_rm['id'] ?>";
    namaRM = "<?= $this_rm['name'] ?>";
    emailRM = "<?= $this_rm['email'] ?>";
    url = "<?php echo site_url('c_oas011/submit_form'); ?>"
    <?php } ?>

    <?php if($edit) { ?>
    formId = "<?= $form_data['leave_id'] ?>";
    url = "<?php echo site_url('c_oas011/submit_update_form'); ?>";
    startDate = new Date("<?= $form_data['start_dt'] ?>");
    endDate = new Date("<?= $form_data['end_dt'] ?>");
    comeBackDate = new Date("<?= $form_data['comeback'] ?>");
    leaveTotal = "<?= $form_data['amount'] ?>";
    namaRM = "<?= $form_data['rmname'] ?>";
    emailRM = "<?= $form_data['rmemail'] ?>";
    <?php } ?>
    
    function server_error()
    {
        $('#leaveTotal').val("Problem contacting server...");
        $('#comeBack').val("Problem contacting server...");
        $('#leaveLeft').val("Problem contacting server...");
        throw new Error("Error contacting server.");
    }

    function doCalculate(){
        leaveTotal += calcBusinessDays(startDate, endDate);
        console.log("Total cuti: " + leaveTotal);
        $('#leaveTotal').val(leaveTotal);
        $('#leaveLeft').val(leaveLeft-leaveTotal);

        if((leaveLeft-leaveTotal) < 0 )
        {
            $('#leave-form-submit-btn').addClass("disabled");
            $('#comeBack').parents('.form-group').addClass('has-error');
            $('#comeBack').val('Jumlah cuti melebihi hak cuti anda!');
        }
        else
        {
            $('#comeBack').parents('.form-group').removeClass('has-error');
            comeBackDate = getWorkDay(endDate);
            console.log("Kembali kerja: " +moment(comeBackDate).format('DD/MM/YYYY'));
            $('#comeBack').val(moment(comeBackDate).format('DD MMMM YYYY'));
            $('#leave-form-submit-btn').removeClass("disabled");
        }

        
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
            url: "<?php echo site_url('c_oas011/isHoliday'); ?>",
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
                $('#leaveRange').daterangepicker({
                    format: 'DD MMMM YYYY',
                    <?php if($form_data['minimum_day'] != '0') { ?>
                    startDate: moment().add(leaveMin, 'days'),
                    endDate: moment().add(leaveMin+1, 'days'),
                    minDate: moment().add(leaveMin, 'days'),
                    <?php } ?>
                    opens: 'right',
                    locale: 'id'
                }
                );

                //Date range picker event
                $('#leaveRange').on('apply.daterangepicker', function(ev, picker) {
                    leaveTotal = 0;
                    $('#leaveTotal').val("Calcualting...");
                    $('#comeBack').val("Calcualting...");
                    $('#leaveLeft').val("Calcualting...");

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
                            leaveTotal -= data;
                            doCalculate();
                        },
                        error: function(){                      
                            server_error();
                        }
                    });
                });


                // Submit button event
                $('#leave-form-submit-btn').on('click', function(){
                    var form_data = {
                        employeeId      : employeeid,
                        formid          : formId,
                        leaveTypeId     : leavetypeid,
                        leaveAmount     : leaveTotal,
                        address         : $('#leaveAddress').val(),
                        phone           : $('#leaveCall').val(),
                        submittedDate   : moment().format('YYYY-MM-DD'),
                        start_date      : moment(startDate).format('YYYY-MM-DD'),
                        end_date        : moment(endDate).format('YYYY-MM-DD'),
                        back_date       : moment(comeBackDate).format('YYYY-MM-DD'),
                        employeerm      : employeeRM,

                        namarm         : namaRM,
                        emailrm         : emailRM,
                        ajax            : '1'
                    };

                    var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    $( "#"+id ).empty();
                    $( "#"+id ).html("Memproses form...");
                    
                    console.log(form_data);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                        success: function(data) {
                            $( "#"+id ).html("Form submitted successfully ." + data
                                +"<br><button onclick='closeTab(this)'>Close</button>");
                        },
                        error: function(){                      
                            $( "#leave-sbmt-msg" ).html("There was an error connecting to server.");
                        }
                    });
                })


    });
</script>
