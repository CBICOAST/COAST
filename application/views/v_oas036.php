<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS036
* Program Name     : Report Expense Claim Division
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 15-10-2014 23:50:00 ICT 2014
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
		<h2><b>Report Expense Claim Division</b></h2>
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
						<input type="text" id="employeeid_divisi" class="form-control claim-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="group_divisi" class="" style="max-width:150px;">
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
						<input type="text" id="year_divisi" class="form-control claim-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						<!-- <input type="text" id="claim-list-search-name" class="form-control claim-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeename']; ?>"> -->
						<select id="name_divisi">
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
						<select id="division_divisi" class="" style="max-width:150px;">
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
						<!-- <input type="text" id="claim-list-search-month" class="form-control claim-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['month']; ?>"> -->
						<select id="month_divisi" class="" style="max-width:150px;">
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
						Charge Code Type :
					</td>
					<td>
						<select id="chargecodetype_divisi" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($list_chargecodetype as $key => $chargecodetype) { ?>
                        <option value="<?= $chargecodetype['id'] ?>"
                        	<?php if($search && $search_param['chargecodetype_id']==$chargecodetype['id']) echo 'selected';?>><?= $chargecodetype['name'] ?></option>
                        <?php } ?>
						
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Charge Code :
					</td>
					<td>
						<select id="chargecode_divisi" class="" style="max-width:150px;">
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
						Claim Type :
					</td>
					<td>
						<select id="type_divisi" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($list_claim_type_divisi as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['claimtype']==$type['id']) echo 'selected';?>><?= $type['name'] ?></option>
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
						<select id="statuslistclaim_divisi" class="" style="max-width:150px;">
						<option value="-1"
						<?php if($search && $search_param['claimstatus']=='-1') echo 'selected';?>>-- All --</option>
                       
                        <option value="9"
                        	<?php if($search && $search_param['claimstatus']=='2') echo 'selected';?>> Has been approved by Finance Head 
                        </option>
						<option value="10"
                        	<?php if($search && $search_param['claimstatus']=='2') echo 'selected';?>> Has been approved by Director
                        </option>
                     
                        <option value="6"
                        	<?php if($search && $search_param['claimstatus']=='6') echo 'selected';?>> Has been paid by Finance Admin
                        </option>
                    </select>
					</td>
					<td>
					</td>
					<td colspan="2">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td colspan="2">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" onclick="change_page(this, 'c_oas036/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim"  onclick="doSearch_divisi(this);">Search</button>
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
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload_divisi(this);">
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
			<col width="19%">
			<col width="18%">
			<col width="10%">
			<col width="11%">
			<col width="10%">
			<col width="13%">
			<col width="8%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Claim Type </th>
				<th>Charge Code</th>
				<th>Receipt Date</th>
				<th>Accepted Date</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			$total = 0;
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr>
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['claim_id'] ?>"><a href="#" title="Datail" onclick="change_page(this, 'c_oas025/load_form/<?= $value['claim_id'] ?>/reportDivision')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['claim_type'] ?>
					<td><?= $value['charge_code'] ?></td>
					<td><?= date('d F Y',strtotime($value['tgl_kwitansi'])) ?></td>
					<td><?= date('d F Y',strtotime($value['accepted_dt'])) ?></td>
					<td align="right"><?= number_format($value['total'],0,",",".")?></td>	
					<? $total += $value['total'];?>					
				</tr>
			<?php }
			 }else{?>			
				<tr>
					<td class="text-center" colspan="8">NOT FOUND!</td>
				</tr>			
			<?php }
			if(isset($submission_list)){?>
				<tr>
					<td colspan="7" align="right"><b>TOTAL</b> </td>
					<td align="right"><b><?echo number_format($total,0,",",".");?> </b></td>				
				</tr>
			<?}?>
			
		</tbody>
	</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var employeeid = $('#employeeid_divisi').val();
	var employeename = $('#name_divisi').val();
	var claimtype = $('#type_divisi').val();
	var claimstatus = $('#statuslistclaim_divisi').val();
	var year  = $('#year_divisi').val();
	var month = $('#month_divisi').val();
	var position = $('#division_divisi').val();
	var group = $('#group_divisi').val();
	var division = $('#division_divisi').val();
	var chargecodetype = $('#chargecodetype_divisi').val();
	var chargecode = $('#chargecode_divisi').val();
	if(position == ""){
		var position = $('#group_divisi').val();
	}

	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(claimtype != ''){
		url += "claimtype="+claimtype+"&";
	}
	if(claimstatus != ''){
		url += "claimstatus="+claimstatus+"&";
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
	if(chargecodetype != ''){
		url += "chargecodetype="+chargecodetype+"&";
	}
	if(chargecode != ''){
		url += "chargecode="+chargecode+"&";
	}

	return url;
}


function doSearch_divisi(elm)
{
	var url="c_oas036/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

function doDownload_divisi(elm)
{
	var url="c_oas036/download?"+get_filter_param();
	window.location.href = host+url;
}

$(function() { 
	$('#group_divisi').change(function(){
        
        $("#division_divisi > option").remove();
        $(".wait").removeClass('hide');
        $("#division_divisi").addClass('hide');
        var sub_unsur_id = $('#group_divisi').val();
        $.ajax({
            type: "POST",
            url: "c_oas036/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#division_divisi').append(opt);
                });
                $(".wait").addClass('hide');
                $("#division_divisi").removeClass('hide');
            }

        });
        
    });
	
	
});
$(function() { 
	$('#chargecodetype_divisi').change(function(){
        
        $("#chargecode_divisi > option").remove();
        $(".wait").removeClass('hide');
        $("#chargecode_divisi").addClass('hide');
        var sub_unsur_id = $('#chargecodetype_divisi').val();
        $.ajax({
            type: "POST",
            url: "c_oas036/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#chargecode_divisi').append(opt);
                });
                $(".wait").addClass('hide');
                $("#chargecode_divisi").removeClass('hide');
            }

        });
        
    });
});


</script>