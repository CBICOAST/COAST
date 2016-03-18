<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS025
* Program Name     : Detail Form Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 01-10-2014 23:46:00 ICT 2014
*
* Update history     Re-fix date       Person in charge    Description
* 			
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
               <h3 class="box-title">CLAIM REQUEST DETAIL</h3>
            </div>
            <div class="box-body">

                <div class="requester-detail form-section-container">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">No. Ref</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['no_ref'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Group / Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $detail_group ?> / <?echo $detail_division?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Reporting Manager</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $detail_rm['name'] ?>">
                        </div>
                    </div>                   

                </div> <!-- /.requester-detail -->

                <div class="requester-detail form-section-container">
					<div class="form-group">
                        <label class="col-sm-4 control-label">Submitted Date</label>
                        <div class="input-group">
							<input type="text" readonly class="form-control" 
							data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($form_detail['makerDate'] ))?>"/>
							 
                       
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" for="leaveType">Claim Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['claim_type'] ?>">
                        </div>
                    </div>
					
					<?php if ($form_detail['category_id']=='2'){
							?>
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_name'].')';?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code Division</label>
                        <div class="input-group">
                             <label> <?= $div_cc['div_cc'] ?></label>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Description</label>
                        <div class="input-group">
                            <label><?echo $form_detail['cc_name'] ;?></label>
                        </div>
                    </div>
					<?}?>                 
					
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Receipt Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" readonly class="form-control" 
							data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($form_detail['tanggal_kwitansi'] ))?>"/>
							 
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->


                   <div class="form-group">
                        <label class="col-sm-4 control-label" >Amount :</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                Rp.
                            </div>
                            <input type="text" readonly class="form-control"value="<?= number_format($form_detail['total'],0,",",".")  ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->

                   
                </div> <!-- /.requester-detail part 2 -->

                <div class="approval-detail form-section-container">
                    <big>History Approval</big>
                    
                  
					<?if ($form_detail['status_id'] == '0'){?>
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Status:</label>
                        <?= $form_detail['status'].' by '.$form_detail['approve_name'] ?>
                    </div><!--/.form group -->  
					<?}else{?>
						 <div class="form-group">
                        <label class="col-sm-4 control-label">Status:</label>
                        <?= $form_detail['status'] ?>
                    </div><!--/.form group -->  
					<?}?>

                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Requester:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2" readonly placeholder="-"><?php  echo $form_detail['remark_requester'];?></textarea>
                        </div>
                    </div>
					
					<!-- Kalau belum di approve tdk muncul -->
					<?if ($form_detail['app_by'] != ''){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Approval By :</label>
                        <div class="input-group">
                             <?= $form_detail['app_by'] ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Date :</label>
                        <div class="input-group">
                             <?=  date('d F Y',strtotime($form_detail['app_dt'])) ?>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Approval:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2" readonly placeholder="-"><?php  echo $form_detail['remark'];?></textarea>
                        </div>
                    </div>
					<?}?>
					
					<!-- Kalau belum di accept Finance tdk muncul -->
					<?if ($form_remarks['app_fin'] != ''){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Acceptance By:</label>
                        <div class="input-group">						
                             <?= $form_remarks['app_fin'] ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Date :</label>
                        <div class="input-group">
                             <?=  date('d F Y',strtotime($form_detail['fin_dt']))?>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Finance 1:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2" readonly placeholder="-"><?php  echo $form_remarks['remark_fin'];?></textarea>
                        </div>
                    </div>
					<?}?>
					
					<!-- Kalau belum di check Finance 2 tdk muncul -->
					<?if ($form_detail['f2_by'] != ''){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Checked By:</label>
                        <div class="input-group">						
                             <?= $form_detail['f2_by'] ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Date :</label>
                        <div class="input-group">
                             <?=  date('d F Y',strtotime($form_detail['f2_dt']))?>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Finance 2:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2" readonly placeholder="-"><?php  echo $form_detail['f2_remark'];?></textarea>
                        </div>
                    </div>
					<?}?>
					<!-- Kalau belum di approve Direktur tdk muncul -->
					<?if ($form_detail['dir_by'] != ''){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Approve By Director :</label>
                        <div class="input-group">						
                             <?= $form_detail['dir_by'] ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Date :</label>
                        <div class="input-group">
                             <?=  date('d F Y',strtotime($form_detail['dir_dt']))?>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Director:</label>
                        <div class="input-group">
                            <textarea class="form-control" rows="2" readonly placeholder="-"><?php  echo $form_detail['dir_remark'];?></textarea>
                        </div>
                    </div>
					<?}?>
					
                </div> 

            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
			<?if ($tipe_detail == 'paid'){?>
				<button type="button" class="pull-left btn btn-default" onclick="change_page(this, 'c_oas034/load_view')"> Back...</button>
			<?}
			else if ($tipe_detail == 'reportAllowance'){?>
				<button type="button" class="pull-left btn btn-default" onclick="change_page(this, 'c_oas035/load_view')"> Back...</button>
			<?}
			else if ($tipe_detail == 'reportDivision'){?>
				<button type="button" class="pull-left btn btn-default" onclick="change_page(this, 'c_oas036/load_view')"> Back...</button>
			<?}
			else{?>
				<button type="button" class="pull-left btn btn-default" onclick="change_page(this, 'c_oas022/load_view')"> Back...</button>
			<?}?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->