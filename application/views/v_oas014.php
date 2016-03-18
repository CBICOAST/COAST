<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS014
* Program Name     : Detail Form Permohonan Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 19-08-2014 09:34:00 ICT 2014
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
                        <label class="col-sm-4 control-label" for="leaveTotal">Amount Of Leave:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" id="leaveTotal" value="<?= $form_detail['amount'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                    

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
                        <label class="col-sm-4 control-label" for="leaveTotal">Telepon Number:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" readonly class="form-control holo" data-inputmask="'mask': ['999-999-999-999', '+99 99 99 9999[999]']" data-mask value="<?= $form_detail['phone'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div> <!-- /.requester-detail part 2 -->

                <div class="approval-detail form-section-container">
                    <big>Approval</big>
                    <!-- radio-->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status:</label>
                        <?= $form_detail['status'] ?>
                    </div><!--/.form group -->  

                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="3" readonly placeholder="..."><?= $form_remarks ?></textarea>
                        </div>
                    </div>
                </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas015/load_view')">Back...</button>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->