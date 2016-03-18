<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS033
* Program Name     : Approval Claim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-09-2014 07:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<div class="row">
    <div class="col-md-8">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">EXPENSE CLAIM DETAIL</h3>
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
                        <label class="col-sm-4 control-label">Email Address</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control"  value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Group / Division</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"value="<?echo $detail_group.' / '. $detail_division ?>">
                        </div>
                    </div>                    
                </div> <!-- /.requester-detail -->

                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Receipt Date</label>
                        <div class="input-group">
                           
                            <input type="text" readonly class="form-control"
							data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($form_detail['tanggal_kwitansi'] )) ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					 <div class="form-group"id="edited_date_cl">
                        <label class="col-sm-4 control-label"style="color:red;">Receipt Date Before Revised</label>
                        <div class="input-group">
                            <input type="text"  class="form-control" readonly data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= date('d F Y',strtotime($form_edit_detail['ori_tgl'] )) ?>">
                        </div>
                    </div>
					
					  <div class="form-group">
                        <label class="col-sm-4 control-label">Claim Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['claim_type'] ?>"> 
                        </div>
                    </div>
					
				<?php if ($form_detail['category_id']=='2'){
							?>
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code</label>
                        <div class="input-group">
                            <input type="text" id="cc_confirm_claim"readonly class="form-control" value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_name'].')';?>">
                        </div>
                    </div>
					
					 <div class="form-group" id="edited_cc_cl">
                        <label class="col-sm-4 control-label"style="color:red;">Charge Code Before Revised</label>
                        <div class="input-group">
						 <label class="col-sm-4 control-label"style="color:red;"><?echo $form_edit_detail['ori_cc']  ?>
							</label>
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
                        <label class="col-sm-4 control-label">Amount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                Rp.
                            </div>
                            <input type="text" readonly class="form-control" 
							value="<?= number_format($form_detail['total'],0,",",".") ?>"/>
							<input type="hidden" readonly class="form-control" id="confirm_amount_claim" value="<?= $form_detail['total'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					 <div class="form-group" id="edited_amount_cl">
                        <label class="col-sm-4 control-label" style="color:red;">Amount before Revised</label>
                        <div class="input-group">
                           <label class="col-sm-4 control-label" style="color:red;"><?echo number_format($form_edit_detail['ori_amount'],0,",",".")  ?></label> </div>
                    </div>

                    <?php if($form_detail['category_id'] == '1') { ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Balance</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                Rp. 
                            </div>
							   <?php 
							    if($form_detail['id'] <= '3') { ?>
							   <input type="text" readonly class="form-control" value="<?= number_format($this_balance_tnj['balance'],0,",",".")  ?>"/>
								<input type="hidden" readonly class="form-control" id="confirm_limit_claim" value="<?= $this_balance_tnj['balance'] ?>"/>
						   <?php }
						  else { ?>								
								<input type="text" readonly class="form-control" value="<?= number_format($this_balance['balance'],0,",",".")?>"/>
								<input type="hidden" readonly class="form-control" id="confirm_limit_claim" value="<?= $this_balance['balance'] ?>"/>
							   <?php } 
							    ?>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <?php } ?>
					
						 
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks by Requester:</label>
                        <div class="input-group">
                             <textarea  id="rbr" class="form-control" rows="2" cols="40" readonly placeholder="-"><?echo $form_detail['remark_requester']?></textarea>
                        </div>
                    </div>
					<div class="form-group" id="edited_remarks_cl" >
                        <label class="col-sm-4 control-label" style="color:red;">Remarks by Requester before Revised:</label>
                        <div class="input-group">
						
						<span style="color:red;text-align:center">
                             <textarea  rows="2" cols="40" readonly placeholder="-"><?echo $form_edit_detail['ori_remark']?></textarea>
                        </div>
                    </div>
					
                </div> <!-- /.requester-detail part 2 -->

					 <div class="approval-detail form-section-container">
                    <!-- radio-->
					<? if ((($detail_akun['id'] == $this_id) ||($detail_admin['id']==$this_id) )&& ($form_detail['category_id'] == '1')){ ?>
					
					 <div class="form-group" id="must_reject" hidden >
                        <label class="col-sm-4 control-label">Approval : </label>
                                  <div class="input-group">
										<input type="radio" name="approval" value='2'> Reject</td>
                        </div><!--/.input-group -->
                    </div><!--/.form group -->  
					
                    <div class="form-group" id="accept_claim">
                        <label class="col-sm-4 control-label">Acceptance : </label>
							<div class="input-group">
                                        <input type="radio" name="approval" value='1'>Accept <td>
										<input type="radio" name="approval" value='2'> Not Accept</td>
							</div><!--/.input-group -->
                    </div><!--/.form group -->  
					<?} else if ((($detail_akun['id'] == $this_id) ||($detail_admin['id']==$this_id)) && ($form_detail['category_id'] == '2')
					&& ($form_detail['status_id']== '1')){ ?>
										
                    <div class="form-group" id="accept_claim">
                        <label class="col-sm-4 control-label">Acceptance : </label>
							<div class="input-group">
                                        <input type="radio" name="approval" value='1'>Accept <td>
										<input type="radio" name="approval" value='2'> Not Accept</td>
							</div><!--/.input-group -->
                    </div><!--/.form group -->  
					<?}	 else if ((($get_f2['id'] == $this_id) ||($detail_admin['id']==$this_id)) && ($form_detail['category_id'] == '2')
					&& ($form_detail['status_id']== '11')){ ?>
										
                    <div class="form-group" id="checked_claim">
                        <label class="col-sm-4 control-label">Checked : </label>
							<div class="input-group">
                                        <input type="radio" name="approval" value='1'>Checked <td>
							</div><!--/.input-group -->
                    </div><!--/.form group -->  
					<?}else { ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approval : </label>
                                  <div class="input-group">
                                        <input type="radio" name="approval" value='1'>Approve <td>
										<input type="radio" name="approval" value='2'> Reject</td>
										<?php if (($form_detail['category_id']== '2') && ($form_detail['status_id']!= '9')){?>
										<td><input type="radio" name="approval" value='3' > Revise</td><?}?>
                        </div><!--/.input-group -->
                    </div><!--/.form group -->  
					<?}?>
                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea  id="confirm_remarks_claim" rows="5" cols="40"   input="textarea"></textarea>
                        </div>
                    </div>
					
									
                </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default"  onclick="change_page(this, 'c_oas022/load_view')">Back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="approval-edit-claim-btn">Submit</button> 
            </div>
        </div><!-- /.box -->
		
    </div><!-- /.col (left) -->
	<div class="box-header">
		<h3 class="box-title">History</h3>
    </div>
	<div class="box-body">
		<label>Submitted Date : </label>
			<?echo  date('d F Y',strtotime($form_detail['makerDate'])) ;?>	<br>
		<label>Remarks by Requester:</label><?if ($form_detail['remark_requester'] != ''){
			 echo $form_detail['remark_requester'];}
			else{echo " - ";}?>
		<!-- Kalau belum di approve tdk muncul -->
		<?if ($form_detail['app_by'] != ''){?>
			<br><br><label> Approve By :  </label><?= " ".$form_detail['app_by']?><br>
			<label> Approve Date :</label><?=  " ".date('d F Y',strtotime($form_detail['app_dt'])) ?><br>
			<label>Remarks by Approval:</label>
			<?if ($form_detail['remark'] != ''){
			echo $form_detail['remark'];}
			else{echo " - ";}?>
		<?}?>
		
		<!-- Kalau belum di accept Finance tdk muncul -->
		<?if ($form_remarks['app_fin'] != ''){?>
			<br><br><label>Acceptance By:</label><?=" ". $form_remarks['app_fin'] ?><br>
			<label> Date :</label>
			<?= " ". date('d F Y',strtotime($form_detail['fin_dt']))?><br>
			<label>Remarks by Finance 1:</label>
			<?if ($form_remarks['remark_fin'] != ''){
			 echo $form_remarks['remark_fin'];}
			else{echo " - ";}?>
		<?}?>
		
		<!-- Kalau belum di check Finance 2 tdk muncul -->
		<?if ($form_detail['f2_by'] != ''){?>
			<br><br><label>Checked By:</label>
			<?= " ".$form_detail['f2_by'] ?><br>
			<label> Date :</label>
				<?=  date('d F Y',strtotime($form_detail['f2_dt']))?><br>
			<label>Remarks by Finance 2:</label>
			<?if ($form_detail['f2_remark'] != ''){?>
			<div class="input-group"><?php  echo $form_detail['f2_remark'];?></div><?}
			else{echo " - ";}?>
		<?}?>
		
		<!-- Kalau belum di approve Direktur tdk muncul -->
		<?if ($form_detail['dir_by'] != ''){?>
		<br><br>	<label>Approve By Director :</label><?= $form_detail['dir_by'] ?><br>
			<label> Date :</label><?=  date('d F Y',strtotime($form_detail['dir_dt']))?><br>
			<label>Remarks by Director:</label><?if ($form_detail['dir_remark'] != ''){ echo $form_detail['dir_remark'];
			}
			else{echo " - ";}?>
		<?}?>
		
	</div>
</div><!-- /.row -->
<!-- InputMask -->
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo js_url();?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo js_url();?>plugins/daterangepicker/daterangepickernew.js" type="text/javascript"></script>
<!-- Page script -->
<script type="text/javascript">
var status			= null;
var status_notif = null;
var status_name			= status_name;
 $('#approval-edit-claim-btn').hide(); 
 var balance		= null;
var formid			= "<?php echo $form_detail['claim_id'];?>";
var category_id		="<?= $form_detail['category_id'];?>";
var akuntan			= "<?php echo $detail_akun['id'];?>";
var akuntan_email	= "<?php echo $detail_akun['email'];?>";
var akuntan_name	= "<?php echo $detail_akun['name'];?>";
var f2_id	= "<?php echo $get_f2['id'];?>";
var f2_name	= "<?php echo $get_f2['name'];?>";
var f2_email	= "<?php echo $get_f2['email'];?>";
var dir_id	= "<?php echo $get_dir['id'];?>";
var dir_name	= "<?php echo $get_dir['name'];?>";
var dir_email	= "<?php echo $get_dir['email'];?>";
var aprove			= "<? echo $this_id ;?>";
var requester_id	= "<?= $form_detail['employee_id'] ?>";
var requester_name	= "<?= $form_detail['employee_name'] ?>";
var requester_email	= "<?= $form_detail['employee_email'] ?>";
var claimtype		= "<?php echo $form_detail['id'];?>";
var total			= "<?= $form_detail['total'] ?>";
var refno			= "<?= $form_detail['no_ref'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var tanggal_kwitansi = "<?= $form_detail['tanggal_kwitansi'] ?>";
var month			= "<?= $form_detail['month'] ?>";
var year			= "<?= $form_detail['year'] ?>";
var periode		="<?= $form_detail['periode'] ?>";
var limitReq		="<?= $form_detail['limitReq'] ?>";
var saveRemain		="<?= $form_detail['saveRemain'] ?>";
var remark_requester = $('#rbr').val();
var ccnow		="<?= $form_detail['chargecode'] ?>";

var oriamount		= "<?=$form_edit_detail['ori_amount']?>";
var orichargecode		= "<?=$form_edit_detail['ori_cc']?>";
var oriremarks	= "<?=$form_edit_detail['ori_remark']?>";
var oritgl		= "<?= $form_edit_detail['ori_tgl']?>";


$('#edited_date_cl').hide();
$('#edited_amount_cl').hide(); 
$('#edited_cc_cl').hide(); 
$('#edited_remarks_cl').hide(); 
 $(function() {
     $('input:radio[name=approval]').on('click',function(){
            status=$(this).val();
	if (status==1){
		if ((status_id == "0") || (status_id == "8") || (status_id == "9") ){		
			status_name ="Approved";
			status_notif = "5";
			
		}
		else if (status_id == "1"){		
			status_name ="Accepted";
			status_notif = "1";
		}
		else if (status_id == "11"){		
			status_name ="Checked";
			status_notif = "13";
		}
		else{		
			status_name ="Accepted";
		}
	}
	else if (status==2){
		if ((status_id == "0") || (status_id == "8") || (status_id == "9")){		
			status_name ="Rejected";
			status_notif = "2";
		}
		else{		
			status_name ="Not Accepted";
			status_notif = "15";
		}
	}
	else if (status==3){
		status_notif = "3";
		status_name ="Revise";
	}
	$('#approval-edit-claim-btn').show();
			
     });
	 if ((aprove != akuntan)&& (status_id == '8')){
		 if ((oritgl != tanggal_kwitansi) && (oritgl != '')){
			$('#edited_date_cl').show();
		 
		 } 
		 if	 ((total != oriamount) && (oriamount != '')){
			$('#edited_amount_cl').show(); 
		 }
		if ((remark_requester != oriremarks) && (oriremarks!='' )){	
			$('#edited_remarks_cl').show(); 
		}
		if((ccnow != orichargecode)&& (orichargecode != '')){		 
			$('#edited_cc_cl').show(); 		
		}
	}
	if (aprove == akuntan){
		$('#edited_date_cl').hide();
		$('#edited_amount_cl').hide(); 
		$('#edited_remarks_cl').hide(); 
		$('#edited_cc_cl').hide(); 	
	}
	 var confirm = (($('#confirm_limit_claim').val()) - ($('#confirm_amount_claim').val()));
	if (confirm < 0) {
		$('#accept_claim').hide();
		$('#must_reject').show();
	 }
	 else{
	 
		$('#accept_claim').show();
		$('#must_reject').hide();
		}
     $('#approval-edit-claim-btn').on('click', function(){
                    var form_data = {
                        form_id         : formid,
                        form_type_id    : '5',
                        Approval        : status, //1 = ya 2=tidak
						status_notif 	:status_notif,
						aprove			 : aprove,
                        requesterid     : requester_id,
						requestername   : requester_name,
						requesteremail  : requester_email,
                        total        	: total,
						tanggal_kwitansi: tanggal_kwitansi,
						month 			: month,
						year			: year,
						periode			:periode,
						limitReq		:limitReq,
						saveRemain		: saveRemain,
                        ref_no          : refno,
                        claimtypeid     : claimtype,
                        Remarks         : $('#confirm_remarks_claim').val(),
						chargecode		:$('#cc_confirm_claim').val(),
						status_name		:status_name,
						akuntan			: akuntan,
						akuntan_name	: akuntan_name,
						akuntan_email	: akuntan_email,
						category_id		: category_id,
						status_id		: status_id,						
						f2_id			: f2_id,
						f2_email		: f2_email,
						f2_name			: f2_name,					
						dir_id			: dir_id,
						dir_email		: dir_email,
						dir_name		: dir_name,
                        ajax            : status_id //jika 1 berrti ke akuntan jika masi 0 berrti ke approveal dulu
                    };
					//alert("tunggu");
                    var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

                    $.ajax({
                        url: "<?php echo site_url('c_oas033/submit_approval'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                         success: function(data) {
                            alert("Submit Success!");
							location.reload(); 

                        },
                        error: function(){                      
							console.log('eror');
                        }
                    });
    });
 });
 </script>