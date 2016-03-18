<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS060
* Program Name     : Report Cash Advance
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 22-11-2014 22:26:00 ICT 2014
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


<div class="box-content no-padding">
	<div class="search-fields bs-callout list-title">
		<h2><b>Business Travel Report  </b></h2>
		<div style="height:100%;					
					padding-top: 10px;
					padding-left: 15px;
					padding-bottom: 0px;">
			<table border="0" cellpadding="1" cellspacing="1">
				<colgroup>
					<col width="130px">
					<col width="150px">
					<col width="50px">
					<col width="130px">
					<col width="150px">
					<col width="50px">
					<col width="130px">
					<col width="150px">
				</colgroup>
				<tr>
					<td>
						NIK :
					</td>
					<td>
						<input type="text" id="RBT_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="RBT_group" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($list_group as $key => $group) { ?>
                        <option value="<?= $group['id'] ?>"
                        	<?php if($search && $search_param['group_id']==$group['id']) echo 'selected';?>><?= $group['name'] ?></option>
                        <?php } ?>
						
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Year :
					</td>
					<td>
						<input type="text" id="RBT_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="RBT_name_employee">
							<option value=''>-- ALL --</option>
							<?php foreach ($employee_list as $key => $employee) {?>
								<option value='<?= $employee['EMPLOYEE_ID'] ?>'
									<?php if($search && $search_param['employeename']==$employee['EMPLOYEE_ID'])echo 'selected' ?>><?= $employee['EMPLOYEE_NAME'] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Division :
					</td>
					<td>
						<select id="RBT_division" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
						<?php if($search){
							foreach ($list_division as $key => $division) {?>
								<option value="<?= $division['id'] ?>"
	                        	<?php if($search && $search_param['division_id']==$division['id']) echo 'selected';?>><?= $division['name'] ?></option>
							<?php }
						} ?>
						
                    	</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Month :
					</td>
					<td>
						
						<select id="RBT_month" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($month_list as $key => $month) { ?>
                        <option value="<?= $month['id'] ?>"
                        	<?php if($search && $search_param['month']==$month['id']) echo 'selected';?>><?= $month['name'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>					
					<td>
						Charge Code Type :
					</td>
					<td>
						<select id="RBT_chargecodetype" class="" style="max-width:150px;">
							<option value="">-- ALL --</option>
							<?php foreach ($list_chargecodetype as $key => $chargecodetype) { ?>
							<option value="<?= $chargecodetype['id'] ?>"
                        	<?php if($search && $search_param['chargecodetype_id']==$chargecodetype['id']) echo 'selected';?>><?= $chargecodetype['name'] ?></option>
							<?php } ?>	
						</select>						
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Charge Code :
					</td>
					<td>
						<select id="RBT_chargecode" class="" style="max-width:150px;">
						<option value="">-- All --</option>
						<?php if($search){
							foreach ($list_chargecode as $key => $chargecode) {?>
								<option value="<?= $chargecode['id'] ?>"
	                        	<?php if($search && $search_param['chargecode_id']==$chargecode['id']) echo 'selected';?>><?= $chargecode['name'] ?></option>
							<?php }
						} ?>						
                    	</select>
					</td>
					<td>
						&nbsp;
					</td>	
					
					<td>
						Destination :
					</td>
					<td>
						<select id="RBT_destination" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($destination as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['destination']==$type['id']) echo 'selected';?>><?= $type['destination'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						Status :
					</td>
					<td>
						<select id="RBT_status" class="" style="max-width:150px;">
						<option value="-1"
						<?php if($search && $search_param['bt_status']=='-1') echo 'selected';?>>-- All --</option>
                       
                        <option value="0"
                        	<?php if($search && $search_param['bt_status']=='0') echo 'selected';?>> Need to be approved Group Head
                        </option>
                     
                        <option value="1"
                        	<?php if($search && $search_param['bt_status']=='1') echo 'selected';?>> Need to be approved GA1
                        </option>
						
						<option value="2"
                        	<?php if($search && $search_param['bt_status']=='2') echo 'selected';?>> Need to be accepted GA2
                        </option>
						
						<option value="3"
                        	<?php if($search && $search_param['bt_status']=='3') echo 'selected';?>> Accepted 
                        </option>
                     
                        <option value="4"
                        	<?php if($search && $search_param['bt_status']=='4') echo 'selected';?>> Not acceptance GA2
                        </option>
						
						<option value="5"
                        	<?php if($search && $search_param['bt_status']=='5') echo 'selected';?>> Rejected GA1
                        </option>
                     
                        <option value="6"
                        	<?php if($search && $search_param['bt_status']=='6') echo 'selected';?>> Rejected Group Head
                        </option>
						
						<option value="7"
                        	<?php if($search && $search_param['bt_status']=='7') echo 'selected';?>> Need to be revised
                        </option>
                     
                        <option value="8"
                        	<?php if($search && $search_param['bt_status']=='8') echo 'selected';?>> Canceled
                        </option>
						
						<option value="9"
                        	<?php if($search && $search_param['bt_status']=='9') echo 'selected';?>> Paid 
                        </option>
                    </select>
					</td>
					<td>
					
					</td>
					<td>
						Transportation By :
					</td>
					<td>
						<select id="RBT_transportationby" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($transportation as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['transport_id']==$type['id']) echo 'selected';?>><?= $type['transportation'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					</td>
					<td colspan="3">
						
					</td>
					</tr>
					<tr>
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas060/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearch_allBT(this);">Search</button>
					</td>
				</tr>
				<tr height="5px">
					<td colspan="8">
						
					</td>
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
<?php if(isset($submission_list)){ ?>
					<td colspan="2">
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload_report_CA(this);">
							<i class="fa fa-download"></i>
							.xls
						</button>
					</td>
<?php } ?>
				</tr>
			</table>
		</div>
		</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="29%">
			<col width="15%">
			<col width="19%">
			<col width="13%">
			<col width="9%">
			<col width="7%">
			<col width="6%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Client/Location/Purpose</th>
				<th>Date/Duration</th>
				<th>Charge Code</th>
				<th>Amount</th>
				<th width="50" class="text-center">..:::..
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr class="<?php if ($value['status_id']=='0' && $value['aprove']==$this_id) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['bt_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas081/load_form/<?= $value['bt_id'] ?>')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?echo $value['client_name'].'/'.$value['location'].'/'.$value['bt_purpose']; ?></td>
					<td><?echo $value['departure'].'/'.$value['duration'].' day(s)'; ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?= $value['amount']?></td>
					<td>
					
					</td>
					
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="9">NOT FOUND!</td>
			</tr>
			<?php } ?>
			<tr>
				
				
			</tr>
			<tr>
				<td colspan="9" align="center">PAGINATION</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var employeeid		= $('#RBT_employeeid').val();
	var employeename	= $('#RBT_name_employee').val();
	var RBT_destination	= $('#RBT_destination').val();
	var RBT_cctype		= $('#RBT_chargecodetype').val();
	var RBT_chargecode	= $('#RBT_chargecode').val();
	var RBT_group		= $('#RBT_group').val();
	var RBT_division	= $('#RBT_division').val();
	var RBT_month		= $('#RBT_month').val();
	var RBT_year		= $('#RBT_year').val();
	var RBT_STAT_BT	= $('#RBT_status').val();
	var RBT_transportationby	= $('#RBT_transportationby').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(RBT_destination != ''){
		url += "RBT_destination="+RBT_destination+"&";
	}
	if(RBT_cctype != ''){
		url += "RBT_cctype="+RBT_cctype+"&";
	}
	if(RBT_chargecode != ''){
		url += "RBT_chargecode="+RBT_chargecode+"&";
	}
	if(RBT_group != ''){
		url += "RBT_group="+RBT_group+"&";
	}
	if(RBT_division != ''){
		url += "RBT_division="+RBT_division+"&";
	}
	if(RBT_month != ''){
		url += "RBT_month="+RBT_month+"&";
	}
	if(RBT_year != ''){
		url += "RBT_year="+RBT_year+"&";
	}
	if(RBT_STAT_BT != ''){
		url += "RBT_STAT_BT="+RBT_STAT_BT+"&";
	}
	if(RBT_transportationby != ''){
		url += "RBT_transportationby="+RBT_transportationby+"&";
	}
	return url;
}


function doSearch_allBT(elm)
{
	var url="c_oas060/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
	
}

function doDownload_report_CA(elm)
{
	var url="c_oas060/download?"+get_filter_param();
	window.location.href = host+url;
}


$(function() { 
	$('#RBT_group').change(function(){
        
        $("#RBT_division > option").remove();
        $(".wait").removeClass('hide');
        $("#RBT_division").addClass('hide');
        var sub_unsur_id = $('#RBT_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas060/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#RBT_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#RBT_division").removeClass('hide');
            }

        });
        
    });
	
	
});


$(function() { 
	$('#RBT_chargecodetype').change(function(){
        
        $("#RBT_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#RBT_chargecode").addClass('hide');
        var sub_unsur_id = $('#RBT_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas060/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#RBT_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#RBT_chargecode").removeClass('hide');
            }

        });
        
    });
});


</script>