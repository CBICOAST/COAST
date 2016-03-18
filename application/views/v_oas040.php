 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS040
* Program Name     : Form Approval CA
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 07:36:00 ICT 2014
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
                <h3 class="box-title">CASH ADVANCE DETAIL</h3>
            </div>
            <div class="box-body">
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
                        <input type="email" readonly class="form-control" value="<?= $form_detail['employee_email'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" >Group / Division</label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<?echo $detail_group.' / '. $detail_division ?>">
                    </div>
                </div>
					
				<div class="form-group">
                    <label class="col-sm-4 control-label" >Level</label>
                    <div class="input-group">
                        <input type="text" readonly class="form-control" value="<? echo $form_detail['level_name'];?>">
                    </div>
                </div>
                  
            </div> <!-- /.requester-detail -->
			
			<!-- .Cash Advance - detail -->
            <div class="requester-detail form-section-container">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="submitted_dt">Submitted Date</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])); ?>"></input>
				</div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="ca_type">Cash Advance Type</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="ca_type" placeholder="jenis" value="<?= $form_detail['ca_type'] ?>"></input> 
                </div>
            </div> 
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="chargecode">Charge Code</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="chargecode"  value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_name'].')';?>"></input>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="chargecode_des">Description</label>
                <div class="input-group">
                    <label ><?echo ' '.$form_detail['cc_name'] ;?></label>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="currency">Currency</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="currency" value="<?= $form_detail['currency_name'] ?>"></input>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="amount">Amount</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="amount" value="<?php if ($form_detail['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($form_detail['amount'],0,',','.'); ?>"></input>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label" for="pay_method">Payment Method</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control holo" id="pay_method" value="<?= $form_detail['pay_method_name'] ?>"></input>
                </div>
            </div>
					
			<div class="form-group">
                <label class="col-sm-4 control-label">Remarks Submitted</label>
                <div class="input-group">
                    <label><?= '"'.$form_detail['remarks'].'"' ?></label>
                </div>
            </div>
            </div> <!-- /.Cash Advance-detail -->
				
			
			<?php if ($form_detail['status_id'] != '0' && $form_detail['status_id'] != '7'){?>
			<div class="requester-detail form-section-container">
			<!-- Menampilkan keterangab jika status form telah di approve atasan -->
          
            <!-- dt revise RM -->
            <h5>Hystory Approval</h4>
     <?php if ($form_detail['revise_approved_by'] != '-'){?>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo "Group Head ask to revise ";?> </label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" value ="<? echo $form_detail['revise_approved_dt'].' by '.$form_detail['revise_approved_by'] ;?>"></input>
                </div>
            </div>
            <!-- keterangan RM -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Remarks </label>
                <div class="input-group">
                    <label ><?= '"'.$form_detail['revise_remarks_approval'].'"' ?></label>
                </div>
            </div>
            <?}?>
<?php if ( $form_detail['status_id'] != '8'){?>
            <!-- dt approval RM -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Approved by Group Head</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" value ="<? echo $form_detail['approved_dt'].' by '.$form_detail['approved_by'] ;?>"></input>
                </div>
            </div>
			<!-- keterangan RM -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Remarks Approved</label>
                <div class="input-group">
                    <label ><?= '"'.$form_detail['remarks_approval'].'"' ?></label>
                </div>
            </div>
			 <?}?>
			<!-- Menampilkan keterangan jika sudah di accepted finance -->	
			<?php if ($form_detail['type_id'] != '1' && $form_detail['status_id'] != '1'  && $form_detail['status_id'] != '8'){?>
			<!-- dt approval Finance -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Accepted by Finance Admin</label>
                <div class="input-group">
					<input type="text" readonly class="form-control" value="<? echo $form_detail['accepted_dt'].' by '. $form_detail['accepted_by']?>"></input>
                </div>
            </div>
			
			 <div class="form-group">
                <label class="col-sm-4 control-label">Remarks Finance Admin</label>
                <div class="input-group">
                    <label ><?= '"'.$form_detail['remarks_finance'].'"' ?></label>
                </div>
            </div>
            <!-- jika kena revise finance -->
             <?php if ($form_detail['revise_approvedf2_by'] != '-'  && $form_detail['status_id'] != '16' ){?>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo "Finance Head ask to revise ";?> </label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" value ="<? echo $form_detail['revise_approvedf2_dt'].' by '.$form_detail['revise_approvedf2_by'] ;?>"></input>
                </div>
            </div>
            <!-- keterangan revise finance -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Remarks </label>
                <div class="input-group">
                    <label ><?= '"'.$form_detail['revise_remarks_f2'].'"' ?></label>
                </div>
            </div>
            <?}?>
            <!-- Menampilkan keterangan jika sudah di approve F2 -->      
            <?php if (  $form_detail['status_id'] != '8' &&($form_detail['status_id'] == '2' || $form_detail['status_id'] == '17' || $form_detail['status_id'] == '3' || $form_detail['status_id'] == '4') && $form_detail['dir_approve'] != '-'){?>
            <!-- dt approval Dir -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Approved by Finance Head</label>
                <div class="input-group">
                    <input type="text" readonly class="form-control" value="<? echo $form_detail['approvedf2_dt'].' by '. $form_detail['approvedf2_by']?>"></input>
                </div>
            </div>
            <!-- Keterangan Dir -->
            <div class="form-group">
                <label class="col-sm-4 control-label">Remarks Finance Head</label>
                <div class="input-group">
                    <label ><?= '"'.$form_detail['remarks_f2'].'"' ?></label>
                </div>
            </div>
            <?}?><!-- / tutup keterangan direktur -->   
			
			<!-- Menampilkan keterangan jika sudah di approve direktur -->		
			<?php if ($form_detail['status_id'] != '8' &&($form_detail['status_id'] == '3' || $form_detail['status_id'] == '4') && $form_detail['dir_approve'] != '-'){?>
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
                    <label ><?= '"'.$form_detail['remarks_dir'].'"' ?></label>
                </div>
            </div>
			<?}?><!-- / tutup keterangan direktur -->	
			
			
			
			<?}?>
			</div> 
			<?}?>
			<div class="approval-detail form-section-container">
                <!-- radio-->
                <div class="form-group">
                <label class="col-sm-4 control-label"><?php if ($form_detail['status_id'] != '1') echo'Approval :'; else echo 'Acceptance :';?> </label>
                <div class="input-group">
                    <input type="radio" name="approval" value='1'><?php if ($form_detail['status_id'] != '1') echo'Approved'; else echo 'Accepted';?>
						<td><input type="radio" name="approval" value='2'> <?php if ($form_detail['status_id'] != '1') echo'Reject'; else echo 'Not Accepted';?></td>
						<?php if ($form_detail['status_id']== '0' || $form_detail['status_id']== '16') {?>
						<td><input type="radio" name="approval" value='3' > Revise</td><?}?>
                </div>
            </div>  

            <!-- keterangan -->
           <div class="form-group">
                <label class="col-sm-4 control-label">Remarks:</label>
                <div class="input-group">
                    <textarea  id="remarks" rows="5" cols="40"   input="textarea"></textarea>
                </div>
            </div>
		
			</div> <!-- /.box-body -->
		</div><!-- /.box box-danger -->
        <div class="box-footer clearfix">
            <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas044/load_view')">Back...</button>
            <button type="submit" class="pull-right btn btn-primary" id="approval-submit-btn">Submit</button> 
        </div>
    </div><!-- /.col (left) -->
</div><!-- /.row -->

<script type="text/javascript">
//variabel confirmasi
var activity			= null;
var status			= null;
var fstatus			= null;

var status_name = null;
 $('#approval-submit-btn').hide(); 
var formid			= "<?php echo $form_detail['ca_id'];?>";
var akuntan_id		= "<?php echo $detail_akun['id'];?>";
var akuntan_email	= "<?php echo $detail_akun['email'];?>";
var akuntan_nama	= "<?php echo $detail_akun['name'];?>";
var akuntan2_id      = "<?php echo $detail_akun2['id'];?>";
var akuntan2_email   = "<?php echo $detail_akun2['email'];?>";
var akuntan2_nama    = "<?php echo $detail_akun2['name'];?>";
var dir_id			= "<?php echo $detail_dir['id'];?>";
var dir_email		= "<?php echo $detail_dir['email'];?>";
var dir_nama		= "<?php echo $detail_dir['name'];?>";
var group_head          = "<?php echo $form_detail['aprove'];?>";
var aprove			= "<? echo $this_id ;?>";
var requester_id	= "<?= $form_detail['employee_id'] ?>";
var requester_email	= "<?= $form_detail['employee_email'] ?>";
var requester_nama	= "<?= $form_detail['employee_name'] ?>";
var catype			= "<?php echo $form_detail['type_id'];?>";
var category_id		= "<?php echo $form_detail['category_id'];?>";
var amount			= "<?= $form_detail['amount'] ?>";
var refno			= "<?= $form_detail['no_ref'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var limit			= "<?= $form_detail['limit_dir'] ?>";
var divid			= "<?= $detail_division ?>";
//akhir variabel konfirmasi

$(function() {
//function buat status approve dan activity
     $('input:radio[name=approval]').on('click',function(){
            status=$(this).val();
			
	if (status==1){
		if (status_id==0 || status_id==1 || status_id==19 ||  status_id==16 || status_id==8){
		activity='5';
		status_name ="Approved";
		}
	if ( status_id==2){
		activity='1';
		status_name ="Accepted";
		}
	}
	if ( status==2){
		activity='2';
		status_name ="Rejected";
	}
	if ( status==3){
		activity='3';
		status_name ="Revise";
	}
		$('#approval-submit-btn').show();
    });
	
	//ketika tombol submit di click
	$('#approval-submit-btn').on('click', function(){
                    var form_data = {
						status_id		: status_id,
                        form_id         : formid,
                        form_type_id    : '2',
                        refno			: refno,
						approval        : status, 
                        activity        : activity,
						aprove			: aprove,
                        requesterid     : requester_id,
						requester_email : requester_email,
						requester_nama  : requester_nama,
                        amount        	: amount,
						limit			: limit,
						ref_no          : refno,
                        catype    	 	: catype,
                        remarks         : $('#remarks').val(),
						akuntan			: akuntan_id,
						akuntan_email	: akuntan_email,
						akuntan_nama	: akuntan_nama,
                        akuntan2         : akuntan2_id,
                        akuntan2_email   : akuntan2_email,
                        akuntan2_nama    : akuntan2_nama,
						dir				: dir_id,
						dir_email		: dir_email,
						dir_nama		: dir_nama,
						category_id		: category_id,
						status_name     : status_name,
                        group_head      : group_head,
						divid			: divid,
                        ajax            : 1 
                    };
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
        console.log(form_data);

                    $.ajax({
                        url: "<?php echo site_url('c_oas040/submit_approval'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                         success: function(data) {
						 alert("Confirmation success!");//keterangan sukses submit
                            $("#"+id ).html("<h5><code>No Ref :  " + refno + " successfully confirmed </code></h5>" + data
                                +"");
                        },
                       error: function(){                   
                        alert("Confirmation Failled!");//keterangan gagal submit
                            $("#"+id ).html("</h5><code>No Ref :  " + refno + " failled to confirm </code> </h5>" + data
                                +"");
                        }
                    });
    });
});
</script>