 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS081
* Program Name     : Detail BT
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 01-12-2014 16:00:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

$search = false;
if(isset($search_param)){
	$search = true;
}
?>
<div class="row">
    <div class="col-md-6">
	
	
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">BUSINESS TRAVEL DETAIL</h3>
            </div>
			
			<?php 
					if($form_detail['status_id']=='0' || $form_detail['status_id']=='1' || $form_detail['status_id']=='7'){ ?>
					
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
                           <input type="text" readonly class="form-control" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])) ?>"></input>
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
                        <label class="col-sm-4 control-label" for="payment">Payment Methode</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['pay_method_name'] ;?></label>
                        </div>
                    </div>

					<div class="form-group">
                        <label class="col-sm-4 control-label">Remarks Submitted</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value="<?= $form_detail['remarks'] ?>"></input>
                        </div>
                    </div>

                    
					
                </div> <!-- /.requester-detail part 2 -->
				<?php if ($form_detail['status_id'] != '0'){?>
					<div class="requester-detail form-section-container">
					
					
					<!-- dt approval RM -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Approved by RM</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" value ="<? echo date('d F Y',strtotime($form_detail['approved_dt'])).' by '.$form_detail['approved_by'] ;?>"></input>
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
                        <label class="col-sm-4 control-label">Remarks GA</label>
                        <div class="input-group">
                            <label ><?= $form_detail['remarks_ga'] ?></label>
                        </div>
                    </div>
					<?}?>
					<?php if ($form_detail['status_id'] == '3' || $form_detail['status_id'] == '4'){?>
					<!-- dt approval Finance -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Accepted by Finance</label>
                        <div class="input-group">
                            <label ><? echo $form_detail['accepted_dt'].' by '. $form_detail['accepted_by']?></label>
                        </div>
                    </div>
					<?}?>
					
					</div>
<?}?>
					 <div class="approval-detail form-section-container">
					 
                   <!-- Status -->
					<div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['status_name'] ?><?php if ($form_detail['status_id']=='0'){echo ' / '.$form_detail['approve_name'] ;}if ($form_detail['status_id']=='1'){echo ' / '.$detail_ga['name'] ;}if ($form_detail['status_id']=='2'){echo ' / '.$detail_ga2['name'] ;};?></label>
                        </div>
                    </div> 
									
                </div> <!-- /.approval-input -->

            </div>
			
					<!-- .Hostory Form - detail -->
     <div class="requester-detail form-section-container">
	 	<a><label id="klikhistory1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="history1">
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
			
			<?}?>  
			
			<?php
			if($form_detail['status_id']!='0' && $form_detail['status_id']!='1' && $form_detail['status_id']!='7'){ ?>

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
                           <input type="text" readonly class="form-control" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])) ?>"></input>
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
                        <label class="col-sm-4 control-label" for="payment">Payment Methode</label>
                        <div class="input-group">
                            <label ><?echo $form_detail['pay_method_name'] ;?></label>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label" for="payment">Status</label>
                        <div class="input-group">
                            <label ><code><?echo $form_detail['status'] ;?></code></label>
                        </div>
                    </div>
					
                </div> <!-- /.requester-detail part 2 -->
				
		<div class="requester-detail form-section-container">
		<div class="form-group">
                        <label class="col-sm-4 control-label">Transport Amount</label>
                        <div class="input-group">
						<div class="input-group-addon">
                                Rp.
                            </div>
                            <input type="text" readonly class="form-control" id="bttransport" value="<?= number_format($form_detail['transport_amount'],0,',','.'); ?>"></input>
                        </div>
                    </div>
                    
<div class="form-group">
                        <label class="col-sm-4 control-label">DIM</label>
                        <div class="input-group">
						<div class="input-group-addon">
                                Rp.
                            </div>
                            <input type="text" readonly class="form-control" id="bttransport" value="<?echo number_format((($form_detail['dim_amount'])*($form_detail['duration'])),0,',','.'); ?>"></input>
                        </div>
                    </div>
					<div class="form-group">
					<label class="col-sm-4 control-label">TOTAL</label>
                        <div class="input-group">
						<div class="input-group-addon">
                                Rp. 
                            </div>
                            <label type="text" readonly ><b><?echo number_format( ' '.((($form_detail['dim_amount'])*($form_detail['duration']))+ ($form_detail['transport_amount'])),0,',','.');?></b></label>
                        </div>
                    </div>	 
					</div>			

<!-- .Hostory Form - detail -->
     <div class="requester-detail form-section-container">
	 	<a><label id="klikhistory1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="history1">
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
			<tr>
			<td class="text-left">GA Head</td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_by'] ?></td>
				<td class="text-left"><?= $form_detail['reviseapprovehead_dt']; ?></td>
				<td class="text-left"><?= $form_detail['reviseremarkshead'] ?></td>
			</tr>			
			<tr>
				
				<td class="text-left">Requester</td>
				<td class="text-left"><?= $form_detail['revisereq_by'] ?></td>
				<td class="text-left"><?= $form_detail['employee_name']; ?></td>
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
</div><!-- /.row -->
                </div> <!-- /.requester-detail -->
</div><!-- /.row -->

<table>
 <div class="row">
    <div class="col-md-12">

        <div class="box box-danger">
		
           
                <h3 class="box-title">FORM CONFIRMATION GA</h3>
           
              <?php if($form_detail['transport_id']!='3'){?>
                <table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="8" align="center">TRANSPORTATION</td>
			</tr>
			<tr>
			<th></th>
				<td colspan="3" align="center"><b>Detail</td>
				<td colspan="4" align="center"><b>Date Arrival</td>
				
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Destination</th>
				<th class="text-center">Name</th>
				<th class="text-center">Class</th>
				<th class="text-center">Arival</th>
				<th class="text-center">Hour : Minutes</th>
				<th class="text-center">Departure</th>
				<th class="text-center">Hour : Minutes</th>
				
				
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			$total1 = 0;
			$total2 = 0;
			if(isset($form_detail_transport)){
				$no++;?>
				<tr >
					<td><?= $no ?></td>
					
					<td><?= $form_detail_transport['destination']?></td>
					<td><?= $form_detail_transport['transport_name'] ?></td>
					
					<td><?echo $form_detail_transport['class']; ?></td>
					<td align="center"><?= $form_detail_transport['tgl_berangkat'] ?></td>
					<td align="center"><?= $form_detail_transport['jam_berangkat'] ?> : <?= $form_detail_transport['menit_berangkat'] ?></td>
					<td align="center"><?= $form_detail_transport['tgl_sampe_des'] ?></td>
					<td align="center"><?= $form_detail_transport['jam_sampe_des'] ?> : <?= $form_detail_transport['menit_sampe_des'] ?> </td>
			
				</tr>
			<?php }?>
			
			</tbody>
			</table><?}?>
			
			<table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="10%">
			<col width="8%">
			<col width="13%">
			<col width="10%">
			<col width="8%">
			<col width="10%">
			<col width="8%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="8" align="center">ACOMODATION</td>
			</tr>
			<tr>
				<td colspan="4" align="center"><b>Detail</td>
				<td colspan="2" align="center"><b>Check In</td>
				<td colspan="2" align="center"><b>Check Out</td>
				
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th>Booking Name</th>
				<th>Hotel Name</th>
				<th class="text-center">Address</th>
				<th class="text-center">Date</th>
				<th class="text-center">Hour: Minutes</th>
				<th class="text-center">Date</th>
				<th class="text-center">Hour : Minutes</th>
				
			</tr>
		</thead>
			
		<tbody>
			<?php $noHotel = 0;
			$totalHotel = 0;
			if(isset($form_detail_ac)){
				$noHotel++;?>
				<tr >
					<td><?= $noHotel ?></td>
					
					<td><?= $form_detail_ac['booking_name']?></td>
					<td><?= $form_detail_ac['hotel_name'] ?></td>
					
					<td><?echo $form_detail_ac['address']; ?></td>
					<td align="center"><?= date('d F Y',strtotime( $form_detail_ac['ci_date'])) ?></td>
					<td align="center"><?= $form_detail_ac['ci_hour'] ?> : <?= $form_detail_ac['ci_minute'] ?></td>
					<td align="center"><?= date('d F Y',strtotime( $form_detail_ac['co_date'])) ?></td>
					<td align="center"><?= $form_detail_ac['co_hour'] ?> : <?= $form_detail_ac['co_minute'] ?></td>
					
				</tr>

				<?php ?>
			<?php } ?>
			<?
			
			 }else{
			?>
				
			<?php } ?>
			
			
		</tbody>
	</table>
			 
					<!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas060/load_view')">Back...</button>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

<script type="text/javascript">

$(function() {
	
	$('#klikhistory1').on('click',function(){
	if ($('#history1').show()==true){
	$('#history1').hide();}
	else {$('#history1').show();}
	
	 });
	
});
	
	


	
	
	
	
	
	
</script>

