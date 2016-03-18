 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS067
* Program Name     : Form Approval  BT (GA)
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati(Transportation) & Winni Oktaviani (Acomodation)
* Version          : 01.00.00
* Creation Date    : 30-11-2014 08:05:00 ICT 2014
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
                           <input type="text" readonly class="form-control pull-left holo" id="submittedbt_dt" value="<?= date('d F Y',strtotime($form_detail['submitted_dt'])); ?>"></input>
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
                            <input type="text" readonly class="form-control" id="bttransport" value="<?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format((($form_detail['dim_amount'])*($form_detail['duration'])),0,',','.') ?>"></input>
                        </div>
                    </div>			
					</div>
					
						<div class="requester-detail form-section-container">
	 	<a><label id="klikhistorygh1" title="klik to detail history"><h4><b> History Form</b></h4></label></a>
            <table class="  no-border-bottom" hidden id="historygh1">
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
				
		
		<div class="requester-detail form-section-container">
		
					<div class="form-group">
					<label class="col-sm-4 control-label">TOTAL</label>
                        <div class="input-group">
                            <label type="text" readonly ><b><?php if ($form_detail['currency_id']=='1'){ echo ': Rp. ' ;}else{echo ': $ ';}?><?php echo number_format(((($form_detail['dim_amount'])*($form_detail['duration']))+ ($form_detail['transport_amount'])),0,',','.'); ?></b></label>
                        </div>
                    </div>	
		</div>	

		
</div><!-- /.row -->
                </div> <!-- /.requester-detail -->
</div><!-- /.row -->
 
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
			$total1 = 0;
			$total2 = 0;
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
					
					<td align="right"><?php if ($form_detail['currency_id']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['price_arrival'],0,',','.'); ?></td>
					<? $total1 += $value['price_arrival'];?>
					
					
					<td align="center">
					
						<a href="#" rel="detail" class="opt delete" title="Delete Accomodation" id ="delete-accomodation" onclick="change_page(this, 'c_oas067/del_transport/<?= $value['transport_id'] ?>/<?= $value['bt_id'] ?>')"></a>
					</td>
					
				</tr>
			<?php }?>
			<tr >
					<td> </td>
					
					<td>
                            <input type="text" id="destinantiontr" class="form-control" placeholder="desti" ></input>
                        </td>
					<td><input type="text" id="nametr" class="form-control"  placeholder="nama" ></input></td>
					
					<td><select  id="classtr">
							<?php foreach ($class as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['class']?>"><?= $type['class'] ?></option>
							<?php } ?>
						</select></td>
					<td><input  type="text" class="form-control" id="berangkat_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_berangkat_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_berangkat_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="sampe_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_sampe_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					
					<td><select  id="menit_sampe_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td align="right"><input type="text" class="form-control" id="priceberangkattr" placeholder="price" ></input></td>
					
					<td align="center"><div>
					<div class="pull-center" id="new-expense-msg"></div>
    	<button class="btn-primary" id="sbmt-new-expense" type="submit">Save</button></div>
    </td>
					
					
				</tr>
				<tr>
				<td align="right" colspan="10"><b>TOTAL</b></td>
				<td align="right"  colspan="1" ><b><?php if ($form_detail['currency_id']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($total1,0,',','.'); ?></b></td>
				<td ></td>
			</tr>
			<tr>
			
				<td align="right" colspan="12"></td>
			</tr><?
			 }else{
			?>
			<tr >
					<td> </td>
					
					<td>
                            <input type="text" id="destinantiontr" class="form-control" placeholder="desti" ></input>
                        </td>
					<td><input type="text" id="nametr" class="form-control"  placeholder="nama" ></input></td>
					
					<td><select  id="classtr">
							<?php foreach ($class as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['class']?>"><?= $type['class'] ?></option>
							<?php } ?>
						</select></td>
					<td><input  type="text" class="form-control" id="berangkat_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_berangkat_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_berangkat_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="sampe_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_sampe_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
						<td><select  id="menit_sampe_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					
					
					<td align="right"><input type="text" class="form-control" id="priceberangkattr" placeholder="price" ></input></td>
					
					<td align="center"><div>
					<div class="pull-left" id="new-expense-msg"></div>
    	<button class="btn-primary" id="sbmt-new-expense" type="submit">Save</button></div>
    </td>
					
					
				</tr>
				<tr>
				<td align="center" colspan="19">..:::..</td>
			</tr>
			<?php } ?>
			
			
		</tbody>
	</table><?}?>
<table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="10%">
			<col width="10%">
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
				
				<th class="text-center">.::.</th>
			</tr>
		</thead>
			
		<tbody>
			<?php $noHotel = 0;
			$totalHotel = 0;
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
					<td align="right"><?php if ($form_detail['currency_id']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['room_rate'],0,',','.'); ?></td>
										
					<? $totalHotel+= $value['room_rate'];?>
					
						<td align="center">
					
						<a href="#" rel="detail" class="opt delete" title="Delete Accomodation" id ="delete-accomodation" onclick="change_page(this, 'c_oas067/del_acc/<?= $value['ac_id'] ?>/<?= $value['bt_id'] ?>')"></a>
					</td>
					
				</tr>
			<?php }?>
				<tr >
					<td> </td>
					<td>
					<select id="bookingNameAc">
							<option value=''>-- Choose One --</option>
							<?php foreach ($employee_list as $key => $employee) {?>
								<option value="<?=$employee['EMPLOYEE_NAME']?>"><?= $employee['EMPLOYEE_NAME'] ?></option>
							<?php } ?>
						</select>
                        </td>
					<td><input type="text" id="hotelNameAc" class="form-control"  placeholder="Hotel Name" ></input></td>
					<td><input type="text" id="hotelAddressAc" class="form-control"  placeholder="Address" ></input></td>
					<td><input type="text" id="checkinDateAc" class="form-control"  ></input></td>
					<td>
					<select  id="checkinHourAc">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td>
					<select  id="checkinMinuteAc">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="checkoutDateAc" placeholder="date" ></input>
					</td>
					<td>
					<select  id="checkoutHourAc">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td>
					<select  id="checkoutMinuteAc">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type="text" id="roomRateAc" class="form-control"  onkeyup="digitsOnly(this)" onblur="digitsOnly(this)" onchange="digitsOnly(this)" ></input></td>
					<td><div>
					<div class="pull-left" id="new-accomodation-msg"></div>
    	<button class="btn-primary" id="sbmt-new-accomodation" type="submit">Save</button></div></td>
 
			<tr>
				<td align="right" colspan="10">TOTAL</td>
				<td align="right"  colspan="1" ><?php if ($form_detail['currency_id']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($totalHotel,0,',','.'); ?></td colspan="1"><td>
			</tr>
			<?
			 }else{
			?>
			<tr >
					<td> </td>
					
					<td>
                          <select id="bookingNameAc">
							<option value=''>-- Choose One --</option>
							<?php foreach ($employee_list as $key => $employee) {?>
								<option value="<?=$employee['EMPLOYEE_NAME']?>"><?= $employee['EMPLOYEE_NAME'] ?></option>
							<?php } ?>
						</select>
                        </td>
					<td><input type="text" id="hotelNameAc" class="form-control"  placeholder="Hotel Name" ></input></td>
					<td><input type="text" id="hotelAddressAc" class="form-control"  placeholder="Address" ></input></td>
					<td><input type="text" id="checkinDateAc" class="form-control"  ></input></td>
					<td>
					<select  id="checkinHourAc">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td>
					<select  id="checkinMinuteAc">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="checkoutDateAc" placeholder="date" ></input>
					</td>
					<td>
					<select  id="checkoutHourAc">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select></td>
					<td>
					<select  id="checkoutMinuteAc">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['VALUE']?>"><?= $type['VALUE'] ?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type="text" id="roomRateAc" class="form-control"  onkeyup="digitsOnly(this)" onblur="digitsOnly(this)" onchange="digitsOnly(this)" ></input></td>
					
					
					
					
					<td><div>
					<div class="pull-left" id="new-accomodation-msg"></div>
    	<button class="btn-primary" id="sbmt-new-accomodation" type="submit">Save</button></div>
    </td>
					
					
				</tr>
				<tr>
				<td align="center" colspan="12">..:::..</td>
			</tr>
			<?php } ?>
			
			
			
		</tbody>
	</table> <div class="row"><div class="col-md-6">
 <!-- keterangan --><?php if($form_detail['status_id']=='10') {?>
  <div class="form-group">
                        <label class="col-sm-3 control-label"><br>Remarks Revise</label>
                       <div class="input-group">
                            <label ><br><code><? echo '"'. $form_detail['remarks_revise'].'"';?></code></label>
                        </div>
                    </div>
 <?}?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Remarks:</label>
                       <div class="input-group">
                            <textarea align="left"  id="remarksga" rows="5" cols="70"   input="textarea"></textarea>
                        </div>
                    </div>
									
               
            <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas045/load_view')">Back...</button>
                <button type="submit" class="pull-right btn btn-primary" id="approvaltbt-submit-btn">Submit</button> 
            </div> </div> <!-- /.approval-input -->

            </div><!-- /.box-body -->	</div>
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

</table>
<script type="text/javascript">
var berangkat_dttr = null;
var sampe_dttr = null;
var GA2 = "<?php echo $detail_ga2['id'];?>";
var aprove			= "<? echo $this_id ;?>";
var status_id 		="<? echo $form_detail['status_id'];?>";
var url		= "<?php echo 'c_oas067/save_transport'; ?>";
var url2		= "<?php echo 'c_oas067/save_konfirmGA'; ?>";
var urlHotel		= "<?php echo 'c_oas067/save_accomodation'; ?>";
var this_id = "<?php echo $form_detail['bt_id'];?>";
var ref_no = "<?php echo $form_detail['no_ref'];?>";
var treveller = "<?php echo $form_detail['employee_id'];?>";
var treveller_email	= "<?= $form_detail['employee_email'] ?>";
var treveller_name	= "<?= $form_detail['employee_name'] ?>";
var ga				= "<?php echo $detail_ga['id'];?>";
var ga_name			= "<?php echo $detail_ga['name'];?>";
var ga_email		= "<?php echo $detail_ga['email'];?>";
var ga2			= "<?php echo $detail_ga2['id'];?>";
var ga2_name	= "<?php echo $detail_ga2['id'];?>";
var ga2_email	= "<?php echo $detail_ga2['id'];?>";
var checkinDateAc = null;
var checkoutDateAc  =null;

function digitsOnly(obj)
{
	obj.value=obj.value.replace(/[^\d]/g,'');
	
}

$('#approvaltbt-submit-btn').on('click', function(){
		var form_data = {
						BT_ID				: this_id,
						ga2			: ga2,
						ga2_name			: ga2_name,
						ga2_email			: ga2_email,
						ref_no				: ref_no,
						treveller        	: treveller,
						treveller_email     : treveller_email,
						treveller_name      : treveller_name,
						status_id			: status_id,
						ga					: ga,
						ga_name				: ga_name,
						ga_email			: ga_email,
						SENDER_EMPLOYEE_ID 	: aprove,
						REMARK				: $('#remarksga').val(),
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
	
	$('#klikhistorygh1').on('click',function(){
	if ($('#historygh1').show()==true){
	$('#historygh1').hide();}
	else {$('#historygh1').show();}
	
	 });
	 
$('#berangkat_dttr').datepick({
		dateFormat: 'dd MM yyyy',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			berangkat_dttr = moment(dates[0]).format('dd MM YYYY');
			console.log('new: '+berangkat_dttr);
		},
	});
$('#sampe_dttr').datepick({
		dateFormat: 'dd MM yyyy',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			sampe_dttr = moment(dates[0]).format('dd MM yyyy');
			console.log('new: '+sampe_dttr);
		},
	});


     
     $('#sbmt-new-expense').on('click', function(){
		var form_data = {
						BT_ID				: this_id,
                        DESTINATION         : $('#destinantiontr').val(),
                        TRANSPORTATION    	: $('#nametr').val(),
                        TRANSPORTATION_CLASS        : $('#classtr').val(),
                        ARRIVAL_DATE_IN_DESTINATION : $('#berangkat_dttr').val(),
						A_HOUR_D 					: $('#jam_berangkat_dttr').val(),
						A_MINUTE_D 					: $('#menit_berangkat_dttr').val(),
						DEPARTURE_FROM_THE_REGION_OF_ORIGIN	: $('#sampe_dttr').val(),
						D_HOUR_D 					: $('#jam_sampe_dttr').val(),
						D_MINUTE_D 			: $('#menit_sampe_dttr').val(),
                        
                        PRICE_ARRIVAL       : $('#priceberangkattr').val(),
						REMARK				: '-',
						ajax				: 1
			
		   
		}; 
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

		$.ajax({
			url: url,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
		 success: function(data) {
                            $("#"+id ).html(" " + data
                                +"<br>");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas045/load_view\")'>Back</button>");
                      
                        }
		});
    });
	
	
	$('#checkinDateAc').datepick({
		dateFormat: 'dd MM yyyy',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			checkinDateAc = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+checkinDateAc);
		},
	});
	$('#checkoutDateAc').datepick({
		dateFormat: 'dd MM yyyy',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			checkoutDateAc = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+checkoutDateAc);
		},
	});
	
	$('#sbmt-new-accomodation').on('click', function(){
		var form_data = {
						BT_ID				: this_id,
                        BOOKING_NAME         : $('#bookingNameAc').val(),
                        HOTEL_NAME    	: $('#hotelNameAc').val(),
                        ADDRESS        : $('#hotelAddressAc').val(),
                        CHECKIN_DATE : checkinDateAc,
						CHECKIN_HOUR : $('#checkinHourAc').val(),
						CHECKIN_MINUTE : $('#checkinMinuteAc').val(),
						CHECKOUT_DATE	: checkoutDateAc,
						CHECKOUT_HOUR : $('#checkoutHourAc').val(),
						CHECKOUT_MINUTE : $('#checkoutMinuteAc').val(),
                        REMARKS   	: $('#remarksAc').val(),
						ROOM_RATE : $('#roomRateAc').val(),
						ajax				: 1
			
		   
		}; 
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);

		$.ajax({
			url: urlHotel,
			type: 'POST',
			async : false,
			data: form_data,
			timeout: 1000, //1000ms
		 success: function(data) {
                            $("#"+id ).html("Your response has been processed. <br>Process status ID: " + data
                                +"<br><button onclick='change_page(this, \"c_oas067/load_form\")'>Back</button>");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas067/load_form\")'>Back</button>");
                      
                        }
		});
    });
	
 });
 </script> 