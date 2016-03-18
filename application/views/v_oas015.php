<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS015
* Program Name     : Leave Request List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 0.1 				 26 Aug 2014 		Ahmad Nabili		 Perbaikan logika munculnya tombol pada kolom Opsi
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
		<h2><b>List Employee Leave Request</b></h2>
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
						Employee Id :
					</td>
					<td>
						<input type="text" id="leave-list-search-employeeid" class="form-control leave-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="leave-list-search-group" class="" style="max-width:150px;">
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
						<input type="text" id="leave-list-search-year" class="form-control leave-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						<!-- <input type="text" id="leave-list-search-name" class="form-control leave-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeename']; ?>"> -->
						<select id="leave-list-search-name">
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
						<select id="leave-list-search-division" class="" style="max-width:150px;">
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
						<!-- <input type="text" id="leave-list-search-month" class="form-control leave-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['month']; ?>"> -->
						<select id="leave-list-search-month" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($month_list as $key => $month) { ?>
                        <option value="<?= $month['id'] ?>"
                        	<?php if($search && $search_param['month']==$month['id']) echo 'selected';?>><?= $month['name'] ?></option>
                        <?php } ?>
                        </select>
					</td>
				</tr>
				<tr>
					<td>
						Leave type :
					</td>
					<td>
						<select id="leave-list-search-type" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($list_leave_type as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['leavetype']==$type['id']) echo 'selected';?>><?= $type['name'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Status :
					</td>
					<td>
						<select id="leave-list-search-status" class="" style="max-width:150px;">
						<option value="-1"
						<?php if($search && $search_param['leavestatus']=='-1') echo 'selected';?>>-- ALL --</option>
                        
                        <option value="0"
                        	<?php if($search && $search_param['leavestatus']=='0') echo 'selected';?>> Need to be Approved
                        </option>
                        <option value="1"
                        	<?php if($search && $search_param['leavestatus']=='1') echo 'selected';?>> Approved
                        </option>
                        <option value="2"
                        	<?php if($search && $search_param['leavestatus']=='2') echo 'selected';?>> Rejected
                        </option>
                        <option value="3"
                        	<?php if($search && $search_param['leavestatus']=='3') echo 'selected';?>> Canceled
                        </option>
                    </select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<!-- Bulansa : -->
						&nbsp;
					</td>
					<td>
						<!-- <input type="text" class="form-control search" maxlength="15" style="text-align: left; width: 150px"> -->
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td colspan="2">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim"  onclick="change_page(this, 'c_oas015/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" onclick="doSearchLeave(this);">Search</button>
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
					<?if(isset($submission_list)){?>
					<td colspan="2">
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownloadLeave(this);">
							<i class="fa fa-download"></i>
							.xls
						</button>
					</td>
					<?}?>
				</tr>
			</table>
		</div>
	</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
			<col width="20%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="8%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Group</th>
				<th>Division</th>
				<th>Leave Type</th>
				<th>Balance Leave</th>
				<th width="50" class="text-center">.:::.</th>

			</tr>
		</thead>
		<tbody>
			<?php $idx = 0;
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$idx++;?>
				<tr class="<?php if ($value['status_id']=='0' && $value['rm_id']==$this_id) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $idx ?></td>
					<td class="postit form-number pk" val="<?= $value['leave_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas014/load_form/<?= $value['leave_id'] ?>')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['employee_group_name'] ?></td>
					<td><?= $value['employee_division_name'] ?></td>
					<td><?= $value['leave_type'] ?></td>
					<td class="text-center"><?= $value['balance_leave'] ?></td>
					<td class="text-center">
						<?php if(!($value['employee_id']==$this_id || $value['status_id']=='0') ||
									($value['employee_id']==$this_id && ($value['status_id']=='2' || $value['status_id']=='3' )) ||
									 ($value['employee_id']==$this_id && $value['status_id']=='1' && (strtotime($value['start_dt']) <= strtotime('now')))  ){ ?>
						<a href="#" class="opt detail" title="Detail" onclick="change_page(this, 'c_oas014/load_form/<?= $value['leave_id'] ?>')"></a>
						<?php } ?>

						<?php if(($value['rm_id']==$this_id && $value['status_id']=='0') ||($detail_admin['id']==$this_id && $value['status_id']=='0' )) { ?>
						<a href="#" class="opt approval" title="Konfirmasi" onclick="change_page(this, 'c_oas012/load_form/<?= $value['leave_id'] ?>')"></a>
						<?php } ?>
						
						<?php if(($value['employee_id']==$this_id && $value['status_id']=='0')||($detail_admin['id']==$this_id && $value['status_id']=='0' )){ ?>
						<a href="#" class="opt edit" title="Edit" onclick="change_page(this, 'c_oas011/load_edit_form/<?= $value['leave_id'] ?>')"></a>
						<?php } ?>
						
						<?php if($value['employee_id']==$this_id && $value['status_id']=='1' && (strtotime($value['start_dt']) > strtotime('now')) ){ ?>
						<a href="#" class="opt detail" title="Detail &amp; Pembatalan" onclick="change_page(this, 'c_oas013/load_form/<?= $value['leave_id'] ?>')"></a>
						<?php } ?>

					</td>
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="7">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
		</tbody>
	</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var employeeid = $('#leave-list-search-employeeid').val();
	var employeename = $('#leave-list-search-name').val();
	var leavetype = $('#leave-list-search-type').val();
	var leavestatus = $('#leave-list-search-status').val();
	var year  = $('#leave-list-search-year').val();
	var month = $('#leave-list-search-month').val();
	var position = $('#leave-list-search-division').val();
	var group = $('#leave-list-search-group').val();
	var division = $('#leave-list-search-division').val();
	if(position == ""){
		var position = $('#leave-list-search-group').val();
	}

	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(leavetype != ''){
		url += "leavetype="+leavetype+"&";
	}
	if(leavestatus != ''){
		url += "leavestatus="+leavestatus+"&";
	}
	if(year != ''){
		url += "year="+year+"&";
	}
	if(month != ''){
		url += "month="+month+"&";
	}
	// if(position != ''){
	// 	url += "position="+position;
	// }
	if(group != ''){
		url += "group="+group+"&";
	}
	if(division != ''){
		url += "division="+division+"&";
	}

	return url;
}

function doSearchLeave(elm)
{
	var url="c_oas015/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

function doDownloadLeave(elm)
{
	var url="c_oas015/download?"+get_filter_param();
	window.location.href = host+url;
	// search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

$(function() { 
	$('#leave-list-search-group').change(function(){
        
        $("#leave-list-search-division > option").remove();
        $(".wait").removeClass('hide');
        $("#leave-list-search-division").addClass('hide');
        var sub_unsur_id = $('#leave-list-search-group').val();
        $.ajax({
            type: "POST",
            url: "c_oas015/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#leave-list-search-division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#leave-list-search-division").removeClass('hide');
            }

        });
        
    });
});


</script>