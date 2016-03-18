 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS054
* Program Name     : Detail Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 18-11-2014 07:36:00 ICT 2014
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
                <h3 class="box-title">CASH ADVANCE DETAIL</h3>
            </div>
            <div class="box-body">

                <!-- .requester-detail -->
				<div class="requester-detail form-section-container">
					<div class="form-group">
                        <label class="col-sm-4 control-label">No. Ref</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['no_ref'].' ('.$form_detail['form_status_name'].')' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email Address</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control"  value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Group / Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $detail_group.' / '. $detail_division ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Level</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php echo $form_detail['level_name'];?>">
                        </div>
                    </div>
				</div> <!-- /.requester-detail -->

                <!-- .CA-detail -->
				<div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" >Submitted Date</label>
                         <div class="input-group">
                           <input type="text" readonly class="form-control"  value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])) ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" >Cash Advance Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['ca_type'] ?>"></input> 
                        </div>
                    </div> 
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label" >Charge Code</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_name'].')';?>"></input>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label" >Description</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['cc_name'] ;?></label>
                        </div>
                    </div>
					
					<!-- .Menampilkan keterangan transportasi CA -->
					<?php if ($form_detail['type_id']=='1'){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Destination</label>
                        <div class="input-group">
							<input type="text" readonly class="form-control" value="<?echo $form_detail['destination_name'] ;?>">
                        </div>
                    </div>
					<?}?>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" >Currency</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control holo"  value="<?= $form_detail['currency_name'] ?>"/>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Amount</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control holo" value="<?php if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($form_detail['amount'],0,',','.'); ?>"/>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Payment Method</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control holo" value="<?= $form_detail['pay_method_name'] ?>"/>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <label><?= '"'.$form_detail['remarks'].'"' ?></label>
                        </div>
                    </div>
					
				</div>
				
				<!-- Menampilkan keterangan apabila sudah di approve -->
				<?php if ($form_detail['status_id'] != '0'){?>
				<div class="requester-detail form-section-container">
					<!-- dt approval RM -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approved by RM</label>
                        <div class="input-group">
						<input type="text" readonly class="form-control" value="<? echo $form_detail['approved_dt'].' by '.$form_detail['approved_by'] ;?>"></input>
                        </div>
                    </div>
					<!-- keterangan RM -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks RM</label>
                        <div class="input-group">
						<label><?= '"'.$form_detail['remarks_approval'].'"' ?></label>
                        </div>
                    </div>
					
					<!-- Menampilkan keterangan approval direktur -->
					<?php if ($form_detail['type_id'] != '1' && $form_detail['status_id'] != '1' && $form_detail['dir_approve'] != '-'){?>
					<!-- dt approval Dir -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approved by Director</label>
                        <div class="input-group">
							<input type="text" readonly class="form-control" value="<? echo $form_detail['approveddir_dt'].' by '. $form_detail['approveddir_by']?>"></input>
                        </div>
                    </div>
					<!-- Keterangan Dir -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Director</label>
                        <div class="input-group">
                            <label><?= '"'.$form_detail['remarks_dir'].'"' ?></label>
                       </div>
                    </div>
					<?}?>
					
					<!-- MEnampilkan keterangan accepted finance -->
					<?php if ($form_detail['status_id'] != '1' && $form_detail['status_id'] != '2' && $form_detail['status_id'] != '5' && $form_detail['status_id'] != '6'){?>
					<!-- dt approval Finance -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Accepted by Finance</label>
                        <div class="input-group">
							<input type="text" readonly class="form-control" value="<? echo $form_detail['accepted_dt'].' by '. $form_detail['accepted_by']?>"></input>
						</div>
                    </div>
				</div>
					<?}}?>
					
				<!-- keterangan status -->
                <div class="form-group">
                    <label class="col-sm-4 control-label">Recent Status</label>
                    <div class="input-group">
                        <code><label><?echo $form_detail['status_name'];?>  <?php if ($form_detail['status_id']=='0'){echo ' / '.$form_detail['approve_name'] ;}if ($form_detail['status_id']=='1'){echo ' / '.$detail_dir['name'] ;}if ($form_detail['status_id']=='2'){echo ' / '.$detail_akun['name'] ;};?></label></code>
                    </div>
                </div>
		
		</div><!-- /.box-body -->
            <div class="box-footer clearfix">
			<?php if ($form_detail['status_id']=='3' && $detail_akun['id'] == $this_id){?>
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas056/load_view')">Back...</button>
               <?}if ($form_detail['status_id']=='11' && $detail_akun['id'] == $this_id){?> <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas066/load_view')">Back...</button><?}?>
               
            </div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->

<table>
<? if($form_detail['set_stat'] != 0){?>
 <div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
		
            <div class="box-header">
                <h3 class="box-title">SETTLEMENT DETAIL</h3>
            </div>
            <div class="box-body">

              
                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Date Of Settlement</label>
                        <div class="input-group">
                            
                            <input type="text" readonly class="form-control " value="<?= $form_settle_detail['tgl_bwt'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					 <div class="form-group">
                        <label class="col-sm-5 control-label">Receipt Date</label>
                        <div class="input-group">
                          
                            <input type="text" readonly class="form-control " value="<?= date('d F Y',strtotime($form_settle_detail['tgl_bukti'])) ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					  <div class="form-group">
                        <label class="col-sm-5 control-label">Cash Advance Amount</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?php if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($form_settle_detail['diberikan'],0,',','.'); ?>"> 
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-5 control-label">Cash Advance Settlement</label>
                        <div class="input-group">
                             <input type="text" readonly class="form-control"  value="<?php if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($form_settle_detail['used'],0,',','.'); ?>"> 
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-5 control-label">Employee's Liability</label>
                        <div class="input-group">
                             
                            <input type="text" readonly class="form-control holo" id="karyawan"  value="<?if ($form_settle_detail['sisa']  > 0){if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($form_settle_detail['sisa'],0,',','.');}else echo '0';?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Company's Liability</label>
                        <div class="input-group">
                           
                            <input type="text" readonly class="form-control holo" id="perusahaan" value="<?if ($form_settle_detail['sisa']  < 0){ if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format((($form_settle_detail['sisa'])* -1),0,',','.');}else echo '0';?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<?if
							($form_settle_detail['sisa'] != '0'){ ?> 
					 <div class="form-group">
                        <label class="col-sm-5 control-label" for="pay_method">Settlement Payment Method</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control holo" value="<?=  $form_settle_detail['setl_pay_method'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<?}?>
					 <div class="form-group">
                        <label class="col-sm-5 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <label><?echo '"'.$form_settle_detail['remark'].'"' ;?></label>
                        </div>
                    </div>
					
					 </div>
					 <div class="requester-detail form-section-container">
					
					<?php if($form_detail['status_id'] =='11' || $form_detail['status_id'] =='12' || $form_detail['status_id'] =='13'){?>
					<div class="form-group">
                        <label class="col-sm-5 control-label">Accepted by Finance</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<? echo $form_settle_detail['accepted_dt'].' by '. $form_settle_detail['accepted_by']?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-5 control-label">Remarks Accepted</label>
                        <div class="input-group">
                            <label ><?= '"'.$form_settle_detail['remarks_accepted'].'"' ?></label>
                        </div>
                    </div>
				<?}?>
                    
            </div><!-- /.box-body -->           
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->
<?}?>
</table>