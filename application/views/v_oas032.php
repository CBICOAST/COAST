<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS032
* Program Name     : Paid 1
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 01-24-2014 11:03:00 ICT 2014
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
                <h3 class="box-title">EXPENSE CLAIM DETAIL</h3>
            </div>
            <div class="box-body">

               
		<div class="form-group">
			<label for="no" class="col-sm-4 control-label">No. Ref</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-pencil"></i>
				</div>
				<input type="text" maxlength="100" readonly style="text-align: left; width: 175px" value="<?echo $form_detail['no_ref'] ?>"name="no" id="no" class="form-control holo">
			</div>
		</div>
        <h4 >Detail Employee</h4>
        <div class="requester-detail form-section-container">

           
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Employee Name</label>
                <div class="input-group">
                    <div class="input-group-addon">
                       <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="100" readonly style="text-align: left; width: 175px" value="<? echo $form_detail['employee_name'] ?>" id="name" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-4 control-label">Email</label>
                <div class="input-group">
                    <div class="input-group-addon">
                       <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="100" readonly style="text-align: left; width: 175px" value="<?= $form_detail['employee_email'] ?>" id="join-date" class="form-control holo">
                </div>
            </div>
            
            <div class="form-group">
                <label for="group" class="col-sm-4 control-label">Group</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" value="<?= $detail_group ?>" id="group" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="rm" class="col-sm-4 control-label">Reporting Manager</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" id="bcal"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" value="<?= $detail_rm['name'] ?>"id="rm" class="form-control holo">
                </div>
            </div>
            
        </div><!-- /.input-section -->


        <h4> Claim Detail </h4>
        <div class="requester-detail form-section-container">

		
		<div class="form-group">
                <label for="claim_type" class="col-sm-4 control-label">Claim Type</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" id="bcal"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px"  value="<?= $form_detail['claim_type'] ?>" id="claim_type" class="form-control holo">
                </div>
            </div>
			<?php if ($form_detail['categori']==2){ ?>
			<div class="form-group">
                <label for="chargecode" class="col-sm-4 control-label">Charge Code</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                           value="<?= $form_detail['chargecode'] ?>" id="chargecode" class="form-control holo">
                </div>
            </div><? } ?>
			<div class="form-group">
                <label for="amount" class="col-sm-4 control-label">Amount</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                           value="<?= $form_detail['total'] ?>" id="amount" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="submitdt" class="col-sm-4 control-label">Submitted Date</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                           value="<?= $form_detail['submitted_dt'] ?>" id="submitdt" class="form-control holo">
                </div>
            </div>
            <div class="form-group">
                <label for="receiptdt" class="col-sm-4 control-label">Receipt Date</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                           value="<?= $form_detail['tgl_kwitansi'] ?>" id="receiptdt" class="form-control holo">
                </div>
            </div>
			<div class="form-group">
                <label for="approvedt" class="col-sm-4 control-label">Approve Date</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                           value="<?= $form_detail['approve_dt'] ?>" id="approvedt" class="form-control holo">
                </div>
            </div>
            
            <div class="form-group">
                <label for="status" class="col-sm-4 control-label">Approve Status</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <input type="text" maxlength="50" readonly style="text-align: left; width: 175px" 
                          value=" <?= $form_detail['status'] ?>" id="status" class="form-control holo">
                </div>
            </div><!-- /.form group -->
           
            <div class="form-group">
                <label for="remark" class="col-sm-4 control-label">Remarks</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i>
                    </div>
					 <textarea class="form-control-holo" rows="3" readonly placeholder="..." id="remark"><?= $form_remarks ?></textarea>
                </div>
            </div>
            
        </div><!-- /.input-section -->

   

    </div><!-- /.box-body -->
   
    <div class="box-footer clearfix">
        <div class="pull-center" id="chg-pwd-msg"></div>
		<button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas034/load_view')">Back...</button>
		<?php if ($form_detail['status_id']==2){ ?>
         <button type="submit" class="pull-right btn btn-primary" id="approval-paid-btn">Paid</button> <? } ?>
    </div>
    
</div><!-- /.box -->
 </div><!-- /.col (left) -->
</div><!-- /.row -->
<script type="text/javascript">
var formid = "<?php echo $form_detail['claim_id'];?>";
 $(function() {
    
     $('#approval-paid-btn').on('click', function(){
                    var form_data = {
                        form_id         : formid,
                       
                        ajax            : 1 
                    };
 var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

                    $.ajax({
                        url: "<?php echo site_url('c_oas032/submit_paid'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                        success: function(data) {
                            $("#"+id ).html("Your response has been processed. <br>Process status ID: " + data
                                +"<br><button onclick='change_page(this, \"c_oas034/load_view\")'>Back</button>");
                        },
                        error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas034/load_view\")'>Back</button>");
                        }
                    });
    });
	

 });
 </script> 
