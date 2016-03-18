 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS052
* Program Name     : Form ApprovalSettlement  CA
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
                <h3 class="box-title">SETTLEMENT DETAIL</h3>
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
                        <label class="col-sm-4 control-label" >Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" >Email Address</label>
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
                            <input type="text" readonly class="form-control" value="<?echo $detail_level['name'] ?>">
                        </div>
                    </div>

                  
                </div> <!-- /.requester-detail -->

                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" >Submitted Date</label>
                        <div class="input-group">
                            
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['submitted_dettle_dt'] ?>"></input>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Receipt Date</label>
                        <div class="input-group">
                            
                            <input type="text" readonly class="form-control" value="<?= date('d F Y',strtotime($form_detail['rd'])) ?>"></input>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					  <div class="form-group">
                        <label class="col-sm-4 control-label" >Cash Advance Type</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control"  value="<?= $form_detail['ca_type'] ?>"> </input>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['categorycc_type'].')';?>"></input>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Description</label>
                        <div class="input-group">
                            <label><?echo $form_detail['cc_name'] ;?></label>
                        </div>
                    </div>
					<?php if ($form_detail['type']=='1'){?>
					<div class="form-group">
                        <label class="col-sm-4 control-label" >Destination</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $form_detail['destination'] ;?>"></input>
                        </div>
                    </div>
					<?}?>
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label" >Currency</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['currency_name'] ?>"></input>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label" >Cash Advance Amount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                               <?if ($form_detail['currency_name'] == 'IDR') { ECHO 'Rp.';}
								ELSE {echo '$';}?>
                            </div>
                            <input type="text" readonly class="form-control holo" id="amount" value="<?= number_format($form_detail['diberikan'],0,',','.') ?>"></input>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" for="amount">Amount Used</label>
                        <div class="input-group">
                           <div class="input-group-addon">
                               <?if ($form_detail['currency_name'] == 'IDR') { ECHO 'Rp.';}
								ELSE {echo '$';}?>
                            </div>
                            <input type="text" readonly class="form-control holo" id="amount" value="<?= number_format($form_detail['terpakai'],0,',','.') ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Employee Liability</label>
                        <div class="input-group">
                             <div class="input-group-addon">
                               <?if ($form_detail['currency_name'] == 'IDR') { ECHO 'Rp.';}
								ELSE {echo '$';}?>
                            </div>
                            <input type="text" readonly class="form-control holo" id="karyawan"  value="<?if ($form_detail['sisa']  > 0)echo number_format($form_detail['sisa'],0,',','.');else echo '0';?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Company Liability</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                               <?if ($form_detail['currency_name'] == 'IDR') { ECHO 'Rp.';}
								ELSE {echo '$';}?>
                            </div>
                            <input type="text" readonly class="form-control holo" id="perusahaan" value="<?if ($form_detail['sisa']  < 0)echo number_format((($form_detail['sisa'])* -1),0,',','.');else echo '0';?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					
					<?if ($form_detail['pay_method'] != 0){?>
					 <div class="form-group">
                        <label class="col-sm-4 control-label" for="pay_method">Payment Method</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control holo" id="pay_method" value="<?= $form_detail['pay_method_name'] ?>"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<?}?>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <label ><?= '"'.$form_detail['remarks'].'"' ?></label>
                        </div>
                    </div>

                    
					
                </div> <!-- /.requester-detail part 2 -->

					 <div class="approval-detail form-section-container">
                    <!-- radio-->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Acceptance : </label>
                                  <div class="input-group">
                                        <input type="radio" name="approval" value='11'>Accepted <td>
										<input type="radio" name="approval" value='14'>Revise <td>
                        </div><!--/.input-group -->
                    </div><!--/.form group -->  

                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea  id="remarks" rows="5" cols="40"   input="textarea"></textarea>
                        </div>
                    </div>
									
                </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas044/load_view')">Back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="approval-set-ca-submit-btn">Submit</button> 
            </div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

<script type="text/javascript">
var status			= null;
$('#approval-set-ca-submit-btn').hide(); 
var status_name = null;
var requester_id	= "<?= $form_detail['employee_id'] ?>";

var requester_name	= "<?= $form_detail['employee_name'] ?>";

var requester_email	= "<?= $form_detail['employee_email'] ?>";
var refno			= "<?= $form_detail['no_ref'] ?>";
var st_open 		= null;

 $(function() {
     $('input:radio[name=approval]').on('click',function(){
            status=$(this).val();			
			$('#approval-set-ca-submit-btn').show();
			if(status == '11'){
			status_name = "Approve";
				var tg_karyawan = $("#karyawan").val();
				var tg_perusahaan = $("#perusahaan").val();
				if (tg_karyawan <= '0' )
				{
					st_open = '2';
				
				}
				else
				{
					st_open = '1';
				}
			}
			else
			{
				status_name = "Ask To Revise";
				st_open = '1';
			}
     });
	 
     $('#approval-set-ca-submit-btn').on('click', function(){
                    var form_data = {
                        form_id         : "<?php echo $form_detail['ca_id'];?>",
                        status	        : status, //3 = ya 4=tidak
						requesterid     : requester_id,
						sender			: "<? echo $this_id ;?>",
						ref_no          : refno,
						openclose       : st_open,
                        remarks         : $('#remarks').val(),
						submittedDate  	: moment().format('YYYY-MM-DD'),
						requester_name 	: requester_name,
						requester_email : requester_email,
						status_name     : status_name,
						
                        ajax            : 1 
                    };

                   var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);
					
                    $.ajax({
                        url: "<?php echo site_url('c_oas052/submit_approval'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                        success: function(data) {
                            alert("Form submitted successfully!");
							 $( "#"+id ).html("Form submitted successfully!" + data
                                +"<br><button onclick='closeTab(this)'>Close</button>");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas044/load_form\")'>Back</button>");
                        }
                    });
    });
 });
 </script>