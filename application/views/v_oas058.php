
<div class="row">
    <div class="col-md-6">

        <div class="box box-danger">
		
            <div class="box-header">
                <h3 class="box-title">BUSINESS TRAVEL DETAIL</h3>
            </div>
            <div class="box-body">

              
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
                            <input type="text" readonly class="form-control" id="datebt" value="<?echo $form_detail['departure'].' - '.$form_detail['return_date'] ?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Destination</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="destinationbt" value="<?echo $form_detail['destination_name'];?>"></input>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-sm-4 control-label">Transportation By</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="destinationbybt" value="<?echo $form_detail['transport_name'];?>"></input>
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
					
        </div><!-- /.box -->
		<div class="requester-detail form-section-container">
		<div class="form-group">
                        <label class="col-sm-4 control-label">Transport Amount</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="bttransport" value="<?= $form_detail['transport_amount'] ?>"></input>
                        </div>
                    </div>
                    
<div class="form-group">
                        <label class="col-sm-4 control-label">DIM</label>
                        <div class="input-group">
                            <input type="text" readonly class="form-control" id="bttransport" value="<?echo (($form_detail['dim_amount'])*($form_detail['duration'])) ?>"></input>
                        </div>
                    </div>
					<div class="form-group">
					<label class="col-sm-4 control-label">TOTAL</label>
                        <div class="input-group">
                            <label type="text" readonly ><b><?echo ': '.((($form_detail['dim_amount'])*($form_detail['duration']))+ ($form_detail['transport_amount'])) ;?></b></label>
                        </div>
                    </div>	 </div>					
</div><!-- /.row -->
                </div> <!-- /.requester-detail -->
</div><!-- /.row -->
 
</table>


<table>
 <div class="row">
    <div class="col-md-12">

        <div class="box box-danger">
		
           
                <h3 class="box-title">FORM CONFIRMATION GA</h3>
           
              
                <table class=" table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="6%">
			<col width="3%">
			<col width="3%">
			<col width="6%">
			<col width="3%">
			<col width="3%">
			<col width="6%">
			<col width="3%">
			<col width="3%">
			<col width="6%">
			<col width="3%">
			<col width="3%">
			<col width="5%">
			<col width="5%">
			<col width="2%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="19" align="center">TRANSPORTATION</td>
			</tr>
			<tr>
			<th></th>
				<td colspan="3" align="center"><b>Detail</td>
				<td colspan="6" align="center"><b>Date Arrival</td>
				<td colspan="6" align="center"><b>Date Departure</td>
				<td colspan="2" align="center"><b>Prince</b></td>
				<th></th>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Destination</th>
				<th class="text-center">Name</th>
				<th class="text-center">Class</th>
				<th class="text-center">Arival</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Departure</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Arival</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Departure</th>
				<th class="text-center">H</th>
				<th class="text-center">M</th>
				<th class="text-center">Arival</th>
				<th class="text-center">Departure</th>
				
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
					
					<td><?echo $value['class']; ?></td>
					<td align="center"><?= $value['tgl_berangkat'] ?></td>
					<td align="center"><?= $value['jam_berangkat'] ?></td>
					<td align="center"><?= $value['menit_berangkat'] ?></td>
					<td align="center"><?= $value['tgl_sampe_des'] ?></td>
					<td align="center"><?= $value['jam_sampe_des'] ?></td>
					<td align="center"><?= $value['menit_sampe_des'] ?></td>
					<td align="center"><?= $value['tgl_pulang'] ?></td>
					<td align="center"><?= $value['jam_pulang'] ?></td>
					<td align="center"><?= $value['menit_pulang'] ?></td>
					<td align="center"><?= $value['tgl_sampe_kembali'] ?></td>
					<td align="center"><?= $value['jam_sampe_kembali'] ?></td>
					<td align="center"><?= $value['menit_sampe_kembali'] ?></td>
					<td align="right"><?= $value['price_arrival'] ?></td>
					<td align="right"><?= $value['price_departure'] ?></td>
					<? $total1 += $value['price_arrival'];?>
					<? $total2 += $value['price_departure'];?>
					
					<td>
					
						
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
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_berangkat_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="sampe_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_sampe_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_sampe_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="pulang_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_pulang_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_pulang_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="saampermh_drtr" placeholder="date" ></input></td>
					<td><select  id="jam_saampermh_drtr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_saampermh_drtr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td align="right"><input type="text" class="form-control" id="priceberangkattr" placeholder="price" ></input></td>
					<td align="right"><input type="text"  class="form-control" id="pricepulangtr" placeholder="price" ></input></td>
					
					<td><div>
					<div class="pull-left" id="new-expense-msg"></div>
    	<button class="btn-primary" id="sbmt-new-expense" type="submit">Save</button></div>
    </td>
					
					
				</tr>
				<tr>
				<td align="right" colspan="16">TOTAL</td>
				<td align="right"  colspan="1" ><?echo $total1;?></td>
				<td align="right"  colspan="1" ><?echo $total2;?></td>
				<td ></td>
			</tr>
			<tr>
				<td align="right" colspan="19"></td>
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
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_berangkat_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="sampe_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_sampe_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_sampe_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="pulang_dttr" placeholder="date" ></input></td>
					<td><select  id="jam_pulang_dttr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_pulang_dttr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><input type="text" class="form-control" id="saampermh_drtr" placeholder="date" ></input></td>
					<td><select  id="jam_saampermh_drtr">
							<?php foreach ($h_m_h as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td><select  id="menit_saampermh_drtr">
							<?php foreach ($h_m as $key => $type) { ?>
							<option style="display: none;" value=""> .. </option>
							<option value="<?=$type['urut']?>"><?= $type['urut'] ?></option>
							<?php } ?>
						</select></td>
					<td align="right"><input type="text" class="form-control" id="priceberangkattr" placeholder="price" ></input></td>
					<td align="right"><input type="text"  class="form-control" id="pricepulangtr" placeholder="price" ></input></td>
					
					<td><div>
					<div class="pull-left" id="new-expense-msg"></div>
    	<button class="btn-primary" id="sbmt-new-expense" type="submit">Save</button></div>
    </td>
					
					
				</tr>
				<tr>
				<td align="right" colspan="19"></td>
			</tr>
			<?php } ?>
			
			
		</tbody>
	</table>
<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="4%">
			<col width="5%">
			<col width="5%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="5%">
			<col width="5%">
			<col width="2%">
		</colgroup>
		<thead>
			<tr>
				<td colspan="12" align="center">ACOMODATION</td>
			</tr>
			<tr>
				<th height="5px">No</th>
				<th>Hotel Type</th>
				<th>Hotel Name</th>
				<th>Class</th>
				<th>Tgl Pergi</th>
				<th>Tgl Sampe</th>
				<th>Tgl Pulang</th>
				<th>Tgl Sampe</th>
				<th>Price Arival</th>
				<th>Price Departure</th>
				
				<th>Remarks</th>
				<th class="text-center">..:::..
			</tr>
		</thead>
		<tbody>
			
				<tr >
					
					
				</tr>
			
			<tr>
				<td align="right" colspan="9">TOTAL</td>
				<td align="center" colspan="2" >-</td>
			</tr>
			
			
			
		</tbody>
	</table>	
        </div><!-- /.box -->
    </div><!-- /.col (left) -->
</div><!-- /.row -->

</table>
<script type="text/javascript">
var berangkat_dttr = null;
var sampe_dttr = null;
var pulang_dttr = null;
var saampermh_drtr = null;
	
var url		= "<?php echo 'c_oas067/save_transport'; ?>";
var this_id = "<?php echo $form_detail['bt_id'];?>";

$(function() {
$('#berangkat_dttr').datepick({
		dateFormat: 'yyyy-mm-dd',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			berangkat_dttr = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+berangkat_dttr);
		},
	});
$('#sampe_dttr').datepick({
		dateFormat: 'yyyy-mm-dd',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			sampe_dttr = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+sampe_dttr);
		},
	});
$('#pulang_dttr').datepick({
		dateFormat: 'yyyy-mm-ddD',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			pulang_dttr = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+pulang_dttr);
		},
	});
$('#saampermh_drtr').datepick({
		dateFormat: 'yyyy-mm-dd',
		useMouseWheel: false,
		yearRange: 'c-20:c+20',
		onClose: function(dates) { 
			saampermh_drtr = moment(dates[0]).format('YYYY-MM-DD');
			console.log('new: '+saampermh_drtr);
		},
	});		

     
     $('#sbmt-new-expense').on('click', function(){
		var form_data = {
						BT_ID				: this_id,
                        DESTINATION         : $('#destinantiontr').val(),
                        TRANSPORTATION    	: $('#nametr').val(),
                        TRANSPORTATION_CLASS        : $('#classtr').val(),
                        ARRIVAL_DATE_IN_DESTINATION : berangkat_dttr,
						A_HOUR_D : $('#jam_berangkat_dttr').val(),
						A_MINUTE_D : $('#menit_berangkat_dttr').val(),
						DEPARTURE_FROM_THE_REGION_OF_ORIGIN	: sampe_dttr,
						D_HOUR_D : $('#jam_sampe_dttr').val(),
						D_MINUTE_D : $('#menit_sampe_dttr').val(),
                        ARRIVAL_DATE_IN_REGION_OF_ORIGIN   	: pulang_dttr,
						A_HOUR_R : $('#jam_pulang_dttr').val(),
						A_MINUTE_R : $('#menit_pulang_dttr').val(),
						DEPARTURE_FROM_THE_DESTINATION      : saampermh_drtr,
						D_HOUR_R : $('#jam_saampermh_drtr').val(),
						D_MINUTE_R : $('#menit_saampermh_drtr').val(),
                        PRICE_ARRIVAL       : $('#priceberangkattr').val(),
						PRICE_DEPARTURE		: $('#pricepulangtr').val(),
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
		
		});
    });
 });
 </script> 