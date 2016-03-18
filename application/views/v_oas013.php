<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS012
* Program Name     : Pembatalan Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : M Fadhel K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 13:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">DETAIL LEAVE APPLICATION FORM</h3>
            </div>
            <div class="box-body">

                <div class="requester-detail form-section-container">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="ref">No. Ref</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="ref" placeholder="Ref. No" value="<?= $form_detail['no_ref'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requester" placeholder="Nama" value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="exampleInputEmail1">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterGroup" placeholder="Group" value="<?= $detail_group ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterDivision">Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterDivision" placeholder="Divisi" value="<?= $detail_division ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterRM">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="requesterRM" placeholder="Atasan" value="<?= $detail_rm['name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveType">Leave Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="leaveType" placeholder="jenis" value="<?= $form_detail['leave_type'] ?>">
                        </div>
                    </div>

                    
                </div> <!-- /.requester-detail -->

                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveRange">Date Of Leave:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" readonly class="form-control pull-left holo" id="leaveRange" value="<?= date('d F Y',strtotime($form_detail['start_date']))  ?> - <?= date('d F Y',strtotime($form_detail['end_date'])) ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="comeBack">Back To Office:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" id="comeBack" readonly class="form-control holo" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($form_detail['back_date'])) ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveTotal">Leave Amount:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveTotal" value="<?= $form_detail['amount'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <?php if($form_detail['id'] == '1') { ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveTotal">Remaining Leave:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveTotal" value="<?= $detail_leave_left ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <?php } ?>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveTotal">Address During Leave:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-home"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveTotal" value="<?= $form_detail['address'] ?>" />
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveTotal">Telepon number:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" data-inputmask="'mask': ['999-999-999-999', '+99 99 99 9999[99s9]']" data-mask value="<?= $form_detail['phone'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div> <!-- /.requester-detail part 2 -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default"  onclick="change_page(this, 'c_oas015/load_view')">back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="approval-submit-leave-btn" value="3">Cancel Leave</button> 
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
var status = null;
var formid = "<?php echo $form_detail['leave_id'];?>";
var leavetype = "<?php echo $form_detail['id'];?>";
var employeerm = "<?php echo $detail_rm['id'];?>";
var amount = "<?php echo $form_detail['amount'];?>";
var requester = "<?php echo $form_detail['employee_id'];?>";
var namaRM = "<?php echo $form_detail['rmname'] ;?>";
var emailRM = "<?php echo $form_detail['rmemail'] ;?>";

function doReject(elm)
{
    status=$(elm).val();
    var form_data = {
        form_id         : formid,
        form_type_id    : '1',
        Approval        : status,
        amount          : amount,
        requesterid     : requester,
        employeerm      : employeerm,
        leavetypeid     : leavetype,
		namarm          : namaRM,
        emailrm         : emailRM,
        ajax            : '1'
    };

    var id = $( elm ).closest( "div.tab-pane" ).attr("id");
    console.log(form_data);

    $.ajax({
        url: "<?php echo site_url('c_oas013/submit_approval'); ?>",
        type: 'POST',
        async : false,
        data: form_data,
        timeout: 10000, //1000ms
        success: function(data) {
            $("#"+id ).html("Your leave request has been canceled. " + data
                                +"<br><button onclick='change_page(this, \"c_oas015/load_view\")'>Back</button>");
        },
        error: function(){                      
            $("#"+id ).html("There was an error connecting to server."
                                +"<br><button onclick='change_page(this,\"c_oas015/load_view\")'>Back</button>");
        }
    });
}

 $(function() {
     $('#approval-submit-leave-btn').on('click', function(){
		confirmation_dialog('', 'Are you sure want to cancel leave?', 'question', doReject, this);
    });
 });
 </script>