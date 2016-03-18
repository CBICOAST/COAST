 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS057
* Program Name     : Form Approval  BT (RM and Finance)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
$total1 = 0;
			$total2 = 0;
$totalHotel = 0;
?>
<?php if  ($form_detail['status_id'] != '2'){?>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">BUSINESS TRAVEL DETAIL</h3>
            </div>
            <div class="box-body">

                <div class="requester-detail form-section-container">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="ref">No. Ref</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['no_ref'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="exampleInputEmail1">Email Address</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Group / Division / Level</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $detail_group.' / '. $detail_division.'/'.$detail_level['name']; ?>">
                        </div>
                    </div>

                  
                </div> <!-- /.requester-detail -->

                <div class="requester-detail form-section-container">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Submitted Date</label>
                        <div class="input-group">
                           <input type="date" readonly class="form-control pull-left holo" id="submittedbt_dt" value="<?= $form_detail['submitted_dt'] ?>"></input>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<div class="form-group">
                        <label class="col-sm-4 control-label">Client Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="clientbt" value="<?= $form_detail['client_name'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Customer Location</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="locationbt" value="<?= $form_detail['customer_location'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Purpose</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="purpose" value="<?= $form_detail['purpose'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Date</label>
                        <div class="input-group">
                             <input type="text" readonly class="form-control" id="datebt" value="<?= date('d F Y',strtotime($form_detail['departure']))  ?> - <?= date('d F Y',strtotime($form_detail['return_date'])) ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Destination</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="destinationbt" value="<?echo $form_detail['destination_name'].' transportation by: ' .$form_detail['transport_name'];?>"></input>
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="chargecodebt"  value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['typecc_name'].')';?>"></input>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label" for="chargecode_desbt">Description</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['cc_name'] ;?></label>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <label><?= $form_detail['remarks'] ?></label>
                        </div>
                    </div>

                    
					
                </div> <!-- /.requester-detail part 2 -->
		<div class="requester-detail form-section-container">
	 	<a><label id="klikhistoryga1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="historyga1">
		<colgroup>
			<col width="23%">
			<col width="23%">
			<col width="20%">
			<col width="23%">
		</colgroup>
		<thead>
		
			<tr>
				<th class="text-left">User</th>
				<th class="text-left">Name of User</th>
				<th class="text-left">Time</th>
				<th class="text-left">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['employee_name'] ?></td>
				<td class="text-left"><?= $form_detail['submitted_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks'] ?></td>
			</tr><?php if ($form_detail['status_id']!= '0') {?>
			<tr>
				
				<td class="text-left">Group Head</td>
				<td class="text-left"><?= $form_detail['approved_by'] ?></td>
				<td class="text-left"><?= $form_detail['approved_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_approval'] ?></td>
			</tr>
			<tr>
				
				<td class="text-left">Admin GA</td>
				<td class="text-left"><?= $form_detail['approvedga_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvedga_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_ga'] ?></td>
			</tr>	
			<tr>				
				<td class="text-left">GA Head</td>
				<td class="text-left"><?= $form_detail['approvedgahead_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvedgahead_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_gahead'] ?></td>
			</tr>			
			<tr>
			<td class="text-left" colspan="3"><h4>History Revised</h4></td>
			</tr>			
			<td class="text-left">GA Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_dt']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarkshead'] ?></td>
			</tr>			
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['revisereq_by'] ?></td>
				<td class="text-left"><?= $form_detail['revisereq_dt']; ?></td>
				<td class="text-left"><?= $form_detail['revisereqremark'] ?></td>
			</tr>
			<tr>				
				<td class="text-left">Group Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovegroup_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovegroup_dt']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarksgroup'] ?></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	</div>	
<?php if  ($form_detail['status_id'] != '2'){?>
					 <div class="approval-detail form-section-container">
                    <!-- radio-->
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php if ($form_detail['status_id'] != '2') echo'Approval :'; else echo 'Acceptance :';?> </label>
                                  <div class="input-group">
                                        <input type="radio" name="approvalbt" value='1'><?php if ($form_detail['status_id'] != '2') echo'Approved'; else echo 'Accepted';?><td>
										<input type="radio" name="approvalbt" value='2'> <?php if ($form_detail['status_id'] != '2') echo'Reject'; else echo 'Not Accepted';?></td>
										
												<?php if ($form_detail['status_id']== '0') {?>
										<td><input type="radio" name="approvalbt" value='3' > Revise</td><?}?>
                        </div><!--/.input-group -->
                        </div><!--/.input-group -->
                    </div><!--/.form group -->  

                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea  id="remarksbt" rows="5" cols="40"   input="textarea"></textarea>
                        </div>
                    </div>
						<?}?>			
                </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->
			<?php if  ($form_detail['status_id'] != '2'){?>

            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas037/load_view')">Back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="approvalbt-submit-btn">Submit</button> 
            </div><?}?>	
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
<?}?>
<?php if  ($form_detail['status_id'] == '2'){?>

<table>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
		
            <div class="box-header">
                <h3 class="box-title">BUSINESS TRAVEL DETAIL</h3>
				
            </div>
            <div class="box-body">

              
                <div class="requester-detail form-section-container">
                     <div class="form-group">
                        <label class="col-sm-4 control-label" for="ref">No. Ref</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['no_ref'] ?>">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Submitted Date</label>
                        <div class="input-group">
                           <input type="text" readonly class="form-control pull-left holo" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt']))  ?> "></input>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
					<div class="form-group">
                        <label class="col-sm-4 control-label">Client Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="clientbt" value="<?= $form_detail['client_name'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Customer Location</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="locationbt" value="<?= $form_detail['customer_location'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Purpose</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="purpose" value="<?= $form_detail['purpose'] ?>"></input>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-4 control-label">Charge Code</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="chargecodebt"  value="<?= $form_detail['chargecode']  ?><?echo ' ('.$form_detail['typecc_name'].')';?>"></input>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label" for="chargecode_desbt">Description</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['cc_name'] ;?></label>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['remarks'] ?>"></input>
                        </div>
                    </div>

                    
					
                </div> <!-- /.requester-detail part 2 -->
				<div class="requester-detail form-section-container">
					<div class="form-group">
                        <label class="col-sm-4 control-label">Transport Amount</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="bttransport" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format($form_detail['transport_amount'],0,',','.') ?>"></input>
                        </div>
                    </div>
                    
<div class="form-group">
                        <label class="col-sm-4 control-label">DIM</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="bttransport" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?echo number_format((($form_detail['dim_amount'])*($form_detail['duration'])),0,',','.'); ?>"></input>
                        </div>
                    </div>			
					</div>
					
					<div class="requester-detail form-section-container">
	 	<a><label id="klikhistoryga1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="historyga1">
		<colgroup>
			<col width="23%">
			<col width="23%">
			<col width="20%">
			<col width="23%">
		</colgroup>
		<thead>
		
			<tr>
				<th class="text-left">User</th>
				<th class="text-left">Name of User</th>
				<th class="text-left">Time</th>
				<th class="text-left">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['employee_name'] ?></td>
				<td class="text-left"><?= $form_detail['submitted_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks'] ?></td>
			</tr><?php if ($form_detail['status_id']!= '0') {?>
			<tr>
				
				<td class="text-left">Group Head</td>
				<td class="text-left"><?= $form_detail['approved_by'] ?></td>
				<td class="text-left"><?= $form_detail['approved_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_approval'] ?></td>
			</tr>
			<tr>
				
				<td class="text-left">Admin GA</td>
				<td class="text-left"><?= $form_detail['approvedga_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvedga_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_ga'] ?></td>
			</tr>	
			<tr>				
				<td class="text-left">GA Head</td>
				<td class="text-left"><?= $form_detail['approvedgahead_by'] ?></td>
				<td class="text-left"><?= $form_detail['approvedgahead_dt']; ?></td>
				<td class="text-left"><?= $form_detail['remarks_gahead'] ?></td>
			</tr>			
			<tr>
			<td class="text-left" colspan="3"><h4>History Revised</h4></td>
			</tr>			
			<td class="text-left">GA Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_dt']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarkshead'] ?></td>
			</tr>			
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['revisereq_by'] ?></td>
				<td class="text-left"><?= $form_detail['revisereq_dt']; ?></td>
				<td class="text-left"><?= $form_detail['revisereqremark'] ?></td>
			</tr>
			<tr>				
				<td class="text-left">Group Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovegroup_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovegroup_dt']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarksgroup'] ?></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	</div>	
    </div><!-- /.col (left) -->
</div><!-- /.row -->
</div><!-- /.row -->

<table>
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">EMPLOYEE DETAIL</h3>
            </div>
            <div class="box-body">

                <div class="requester-detail form-section-container">

                   

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requester">Name</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['employee_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="exampleInputEmail1">Email Address</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" value="<?= $form_detail['employee_email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Group</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $detail_group; ?>">
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Divisionl</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $detail_division; ?>">
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-4 control-label" for="requesterGroup">Level</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $detail_level['name']; ?>">
                        </div>
                    </div>
					

                  
                </div> <!-- /.requester-detail -->
				<?php if ($form_detail['status_id'] != '0'){?>
				<div class="requester-detail form-section-container">
					<h4>History Approval</h4>
					
				
					
					<!-- dt approval RM -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approved by RM</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value ="<? echo $form_detail['approved_dt'].' by '.$form_detail['approved_by'] ;?>"></input>
                        </div>
                    </div>
					
                    <!-- keterangan RM -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks RM</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['remarks_approval'] ?>"></input>
                        </div>
                    </div>
					
					<?php if ($form_detail['status_id'] != '1'){?>
					<!-- dt approval Dir -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approved by GA</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<? echo $form_detail['approvedga_dt'].' by '. $form_detail['approvedga_by']?>"></input>
                        </div>
                    </div>
					
					<!-- Keterangan Dir -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks GA1</label>
                        <div class="input-group">
                            <label ><?= $form_detail['remarks_ga'] ?></label>
                        </div>
                    </div>
					<?}?>
					<?php if ($form_detail['status_id'] == '3' || $form_detail['status_id'] == '4'){?>
					<!-- dt approval Finance -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Accepted by GA2</label>
                        <div class="input-group">
                            <label ><? echo $form_detail['accepted_dt'].' by '. $form_detail['accepted_by']?></label>
                        </div>
                    </div>
					<?}?>
					
					</div>
<?}?>
		<div class="requester-detail form-section-container">
		
				<!--	<div class="form-group">
					<label class="col-sm-4 control-label">TOTAL</label>
                        <div class="input-group">
                            <label type="text" readonly ><b><?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format((($form_detail['dim_amount']) + ($form_detail['transport_amount'])),0,',','.') ?></b></label>
                        </div>
                    </div>	 </div>		-->			
</div><!-- /.row -->
                </div> <!-- /.requester-detail -->

 
</table>


<table>
 <div class="row">
    <div class="col-md-12">

        <div class="box box-danger">
		
           
                <h3 class="box-title">FORM CONFIRMATION GA</h3>
           
              <div class="requester-detail form-section-container">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ref">Destination</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['destination_name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Date</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= date('d F Y',strtotime($form_detail['departure']))  ?> - <?= date('d F Y',strtotime($form_detail['return_date'])) ?>"></input>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Duration</label>
                        <div class="input-group">
                            <input type="email" readonly class="form-control" value="<?= $form_detail['duration'].' day(s)' ?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-2 control-label">Transportation By</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?echo $form_detail['transport_name'];?>"></input>
                        </div>
                    </div>
					</div>
					<?php if($form_detail['transport_id']!='3'){?>
                <table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="14%">
			<col width="15%">
			<col width="3%">
			<col width="10%">
			<col width="2%">
			<col width="2%">
			<col width="10%">
			<col width="2%">
			<col width="2%">
			<col width="8%">
			<col width="2%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="12" align="center">TRANSPORTATION</td>
			</tr>
			
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Destination</th>
				<th class="text-center">Transport Name</th>
				<th class="text-center">Class</th>
				<th class="text-center">Date Departure</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Date Arrived</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Price</th>
				
				
				<th class="text-center">.::.
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr >
					<td><?= $no ?></td>
					
					<td><?= $value['destination']?></td>
					<td><?= $value['transport_name'] ?></td>
					
					<td align="center"><?echo $value['class']; ?></td>
					<td align="center"><?= $value['tgl_berangkat'] ?></td>
					<td align="center"><?= $value['jam_berangkat'] ?></td>
					<td align="center"><?= $value['menit_berangkat'] ?></td>
					<td align="center"><?= $value['tgl_sampe_des'] ?></td>
					<td align="center"><?= $value['jam_sampe_des'] ?></td>
					<td align="center"><?= $value['menit_sampe_des'] ?></td>
					
					<td align="right"><?php if ($form_detail['currency_id']=='1'){ echo ' Rp. ' ;}else{echo ' $ ';}?><?php echo number_format($value['price_arrival'],0,',','.') ?></td>
					<? $total1 += $value['price_arrival'];?>
					<td align="center">
					
					</td>
					
				</tr>
			<?php }?>
			<tr>
				<td align="right" colspan="10"><b>TOTAL</b></td>
				<td align="right"  colspan="1" ><b><?php if ($form_detail['currency_id']=='1'){ echo ' Rp. ' ;}else{echo ' $ ';}?><?php echo number_format($total1,0,',','.') ?></b></td>
				<td ></td>
			</tr>
			<tr>
				<td align="right" colspan="12"></td>
			</tr><?php }?>
			</tbody>
	</table>
	<?php } ?>
	<table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="10%">
			<col width="8%">
			<col width="13%">
			<col width="9%">
			<col width="3%">
			<col width="3%">
			<col width="9%">
			<col width="3%">
			<col width="3%">
			<col width="8%">
			<col width="2%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="12" align="center">ACOMODATION</td>
			</tr>
			<tr>
			<th></th>
				<td colspan="3" align="center"><b>Detail</td>
				<td colspan="3" align="center"><b>Check In</td>
				<td colspan="3" align="center"><b>Check Out</td>
				<td></td>
				<th></th>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th>Booking Name</th>
				<th>Hotel Name</th>
				<th class="text-center">Address</th>
				<th class="text-center">Date</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Date</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Room Rate</th>
				
				<th class="text-center">.::.
			</tr>
		</thead>
			
		<tbody>
			<?php $noHotel = 0;
			
			if(isset($submission_acc_list)){
			foreach ($submission_acc_list as $key => $value) { 
				$noHotel++;?>
				<tr >
					<td><?= $noHotel ?></td>
					
					<td><?= $value['booking_name']?></td>
					<td><?= $value['hotel_name'] ?></td>
					
					<td><?echo $value['address']; ?></td>
					<td align="center"><?= date('d F Y',strtotime($value['ci_date'])) ?></td>
					<td align="center"><?= $value['ci_hour'] ?></td>
					<td align="center"><?= $value['ci_minute'] ?></td>
					<td align="center"><?= date('d F Y',strtotime($value['co_date'])) ?></td>
					<td align="center"><?= $value['co_hour'] ?></td>
					<td align="center"><?= $value['co_minute'] ?></td>
					<td align="right"><?php if ($form_detail['currency_id']=='1'){ echo ' Rp. ' ;}else{echo ' $ ';}?><?php echo number_format($value['room_rate'],0,',','.') ?></td>
										
					<? $totalHotel+= $value['room_rate'];?>
					
					<td>
					
						
					</td>
					
				</tr>
			<?php }?>
			<tr>
				<td align="right" colspan="10">TOTAL</td>
				<td align="right"  colspan="1" ><?php if ($form_detail['currency_id']=='1'){ echo ' Rp. ' ;}else{echo ' $ ';}?><?php echo number_format($totalHotel,0,',','.') ?></td><td></td
			</tr><?php }?>
			</tbody>
	</table><br>
	<div class="row"><div class="col-md-6">
 <!-- keterangan -->
 <div class="requester-detail form-section-container">
                   <h4>Calculate BT Amount</h4>
				   <div class="form-group">
                        <label class="col-sm-4 control-label"> CA Transportation  </label>
                                  <div class="input-group">
                                       <input type="text" readonly class="form-control" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format($form_detail['transport_amount'],0,',','.') ?>"></input>	
                        </div><!--/.input-group -->
						</div><!--/.input-group -->
						<div class="form-group">
					<label class="col-sm-4 control-label">DIM Amount</label>
                        <div class="input-group">
						 <input type="text" readonly class="form-control" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?echo number_format((($form_detail['dim_amount'])*($form_detail['duration'])),0,',','.'); ?>"></input>	
                           
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label"> Ticket Transportation  </label>
                                  <div class="input-group">
                                       <input type="text" readonly class="form-control" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format($total1,0,',','.') ?>"></input>	
                        </div><!--/.input-group -->
						</div><!--/.input-group -->
						<div class="form-group">
                        <label class="col-sm-4 control-label"> Hotel  </label>
                                  <div class="input-group">
                                       <input type="text" readonly class="form-control" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format($totalHotel,0,',','.') ?>"></input>	
                        </div><!--/.input-group -->
						</div><!--/.input-group -->
						</div>
						 <div class="requester-detail form-section-container">
						<div class="form-group">
					<label class="col-sm-4 control-label">TOTAL AMOUNT</label>
                        <div class="input-group">
						
                            <label type="text" readonly ><b><?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format(((($form_detail['dim_amount'])*($form_detail['duration']))+ ($form_detail['transport_amount'])+($totalHotel)+($total1)),0,',','.') ?></b></label>
							<input type="text" id="totalamountbt" hidden value="<?echo ((($form_detail['dim_amount'])*($form_detail['duration']))+ ($form_detail['transport_amount'])+($totalHotel)+($total1));?>"></input>
                        </div>
                    </div>
                        </div><!--/.input-group -->
                    
                    <div class="approval-detail form-section-container">
                    <!-- radio-->
                    <div class="form-group">
                        <label class="col-sm-4 control-label"> Acceptance : </label>
                                  <div class="input-group">
                                        <input type="radio" name="acceptedfbt" value='1'>Accepted<td>
										<input type="radio" name="acceptedfbt" value='2'>Not Accepted</td>
										<input type="radio" name="acceptedfbt" value='3'>Revise</td>
												
                        </div><!--/.input-group -->
                        </div><!--/.input-group -->
                    </div><!--/.form group -->  

                    <!-- keterangan -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Remarks:</label>
                        <div class="input-group">
                            <textarea  id="remarksfbt" rows="5" cols="40"   input="textarea"></textarea>
                        </div>
                    </div>
									
               
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas045/load_view')">Back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="acceptedtbt-submit-btn">Submit</button> 
            </div> </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->
			</div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

</table>
<?}?>
<script type="text/javascript">

var activity			= null;
var status			= null;

var status_name			= null;

 $('#approvalbt-submit-btn').hide(); 
var formid			= "<?php echo $form_detail['bt_id'];?>";
var formid_ca			= "<?php echo $form_detail['ca_id'];?>";
var ga2			= "<?php echo $detail_ga2['id'];?>";
var ga2_name	= "<?php echo $detail_ga2['id'];?>";
var ga2_email	= "<?php echo $detail_ga2['id'];?>";
var ga				= "<?php echo $detail_ga['id'];?>";
var ga_name			= "<?php echo $detail_ga['name'];?>";
var ga_email		= "<?php echo $detail_ga['email'];?>";
var aprove			= "<? echo $this_id ;?>";

var requester	= "<?= $form_detail['submitter'] ?>";
var requester_name	= "<?= $form_detail['submitter_name'] ?>";
var requester_email	= "<?= $form_detail['submitter_email'] ?>";

var refno			= "<?= $form_detail['no_ref'] ?>";
var status_id		= "<?= $form_detail['status_id'] ?>";
var url2			= "<?php echo 'c_oas057/save_accepted'; ?>";
var this_id 		= "<?php echo $form_detail['bt_id'];?>";
var ref_no_ca			= "<?php echo $form_detail['no_ref_ca'];?>";
var ref_no 			= "<?php echo $form_detail['no_ref'];?>";
$('#acceptedtbt-submit-btn').hide();
var total_transport ="<?php echo $total1; ?>";
var total_hotel ="<?php echo $totalHotel; ?>";

var treveller = "<?php echo $form_detail['employee_id'];?>";
var treveller_email	= "<?= $form_detail['employee_email'] ?>";
var treveller_name	= "<?= $form_detail['employee_name'] ?>";
 $('input:radio[name=acceptedfbt]').on('click',function(){
            status=$(this).val();
			
			if (status==1){
			if (status_id==0 || status_id==1){
	  activity='5';
	 status_name = 'Approved';
	 }
	 if ( status_id==2){
	 activity='1';
	 status_name = 'Accepted';
	 }}
	 if ( status==2){
	 activity='2';
	 status_name = 'Rejected';
	 }
	  if ( status==3){
	 activity='3';
	 }
	 
			$('#acceptedtbt-submit-btn').show();
     });
$('#acceptedtbt-submit-btn').on('click', function(){

		var form_data = {
						BT_ID				: this_id,
						CA_ID				: formid_ca,
                        ga2				: ga2,
						GA2_NAME			: ga2_name,
						GA2_EMAIL			: ga2_email,
					    ref_no_ca			: ref_no_ca,
					    ref_no				: ref_no,
						status_name			: status_name,
						treveller        	: treveller,
						treveller_email     : treveller_email,
						treveller_name      : treveller_name,
						
						SENDER_EMPLOYEE_ID 	: aprove,
						REMARK				: $('#remarksfbt').val(),
						STATUS				: status,
						ga					: ga,
						ga_name				: ga_name,
						ga_email			: ga_email,
						activity    	    : activity, 
						total_transport     : total_transport,
						total_hotel			: total_hotel,
						total_amounta_bt	: $('#totalamountbt').val(),
						ajax				: 1
			
		   
		}; 
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

		$.ajax({
			url: url2,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
			success: function(data) {
				alert("Form berhasil di-submit!");
				location.reload();
			},
			error: function(){                      
				$( "#claim-sbmt-msg" ).html("Terjadi kesalahan dalam menghubungi server.");
				console.log('eror');
			}
		
		});
    });
	
 $(function() {
	 
	 $('#klikhistoryga1').on('click',function(){
	if ($('#historyga1').show()==true){
	$('#historyga1').hide();}
	else {$('#historyga1').show();}
	
	 });
	 
	 
     $('input:radio[name=approvalbt]').on('click',function(){
            status=$(this).val();
			
			if (status==1){
			if (status_id==0 || status_id==1){
	 activity='5';
	 status_name = 'Approved';
	 }
	 if ( status_id==2){
	 activity='1';
	 status_name = 'Accepted';
	 }}
	 if ( status==2){
	 activity='2';
	 status_name = 'Rejected';
	 }
	  if ( status==3){
	 activity='3';
	 }
	 
			$('#approvalbt-submit-btn').show();
     });
	 
	  
	
     $('#approvalbt-submit-btn').on('click', function(){
                    var form_data = {
						status_id		: status_id,
                        form_id         : formid,
                        form_type_id    : '3',
						ref_no_ca		: ref_no_ca,
						CA_ID			: formid_ca,
                        approval        : status, //0 = ya 1=tidak
                        activity        : activity, 
						aprove			: aprove,
						status_name			: status_name,
                        treveller     : treveller,
                        treveller_name     : treveller_name,
                        treveller_email     : treveller_email,
						
						ref_no          : refno,
						
						created 		: requester,
						created_email 		: requester_email,
						created_name 		: requester_name,
						
                        remarks         : $('#remarksbt').val(),
						ga2			: ga2,
						ga2_name			: ga2_name,
						ga2_email			: ga2_email,
						ga					: ga,
						ga_name				: ga_name,
						ga_email			: ga_email,
                        ajax            : 1 
                    };

                    var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

                    $.ajax({
                        url: "<?php echo site_url('c_oas057/submit_approval'); ?>",
                        type: 'POST',
                        async : false,
                        data: form_data,
                        timeout: 10000, //1000ms
                        success: function(data) {
                            $("#"+id ).html("Your response has been processed. <br>Process status ID: " + data
                                +"<br><button onclick='change_page(this, \"c_oas045/load_view\")'>Back</button>");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas045/load_view\")'>Back</button>");
                      
                        }
                    });
    });
 });
 </script>