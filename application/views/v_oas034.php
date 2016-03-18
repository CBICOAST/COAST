<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS034
* Program Name     : List Paid Expense Claim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 31-10-2014 10:20:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
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
		<h2><b>List Paid Expense Claim</b></h2>
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
						<input type="text" id="claim-list-search-employeeid_paid" class="form-control claim-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="claim-list-search-group_paid" class="" style="max-width:150px;">
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
						<input type="text" id="claim-list-search-year_paid" class="form-control claim-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						<select id="claim-list-search-name_paid">
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
						<select id="claim-list-search-division_paid" class="" style="max-width:150px;">
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
						<select id="claim-list-search-month_paid" class="" style="max-width:150px;">
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
						Claim Type :
					</td>
					<td>
						<select id="claim-list-search-type_paid" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($list_claim_type as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['claimtype']==$type['id']) echo 'selected';?>><?= $type['name'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas034/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearch_paid(this);">Search</button>
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
				</tr>
			</table>
		</div>
	</div>
	<form action="/c_oas034/paid_selected" method="post" accept-charset="utf-8">
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="19%">
			<col width="13%">
			<col width="10%">
			<col width="15%">
			<col width="10%">
			<col width="13%">
			<col width="8%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Charge Code</th>				
				<th>Claim Type</th>
				<th>Receipt Date</th>
				<th>Accepted Date</th>
				<th>Amount</th>
				<?if(isset($submission_list)){?>
				<th class="text-center"><button type="submit" class=" btn btn-primary btn-slim" id="paid-selected " >Paid Selected</button><br><input type='checkbox' name='select-all_paidClaim' id='select-all_paidClaim' /></th>
				<?}?>
				

			</tr>
		</thead>
		<tbody>
	
			<?php 
			
			$idx = 0;
			$total = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$idx++;?>
				<tr>
					<td><?= $idx ?></td>
					<td class="postit form-number pk" val="<?= $value['claim_id'] ?>"><a href="#" title="Datail" onclick="change_page(this, 'c_oas025/load_form/<?= $value['claim_id'] ?>/paid')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<?if ($value['category'] != '1'){?>					
						<td><?= $value['charge_code'] ?></td>
					<?} else{?>
						<td align = 'center'> - </td>
					<?}?>
					<td><?= $value['claim_type'] ?></td>
					<td><?= date('d F Y ',strtotime($value['tgl_kwitansi'] ))?></td>
					<td><?= date('d F Y H:i:s',strtotime($value['accepted_dt'])) ?></td>
					<td align="right"><?= $value['total']?></td>
					<? $total += $value['total'];?>
					<td align="center">
					<?php if(($value['status_id']=='11' && $value['category']=='1') ||($value['status_id']=='9' && $value['type_id']!='4') or ($value['status_id']=='10' && $value['type_id']=='4')){?> 
					<input type="checkbox" class="chk" name="checkbox<?php echo $idx?>"  value="<?= $value['claim_id'] ?>"/></td>	
					<? }else{?>
					
					-
					<?}?>
					
					<input type="text" hidden name="PCL-emp-id<?php echo $idx?>"  value="<?= $value['employee_id'] ?>"/>
					<input type="text" hidden name="PCL-emp-email<?php echo $idx?>"  value="<?= $value['employee_email'] ?>"/>
					<input type="text" hidden name="PCL-emp-name<?php echo $idx?>"  value="<?= $value['employee_name'] ?>"/>
					<input type="text" hidden name="PCL-no-ref<?php echo $idx?>"  value="<?= $value['no_ref'] ?>"/>
					<input type="hidden" value="<?php echo $idx?>" name="loop">
		
					 
				</tr>
				
			<?php }
			
			 }
			
			 else{
			?>
			
			<tr>
				<?if(isset($submission_list)){?>
					<td class="text-center" colspan="9">NOT FOUND!</td>
				<?}else{?>
					<td class="text-center" colspan="8">NOT FOUND!</td>
				<?}?>
			</tr>
			
			<?php } ?>
			<?if(isset($submission_list)){?>
			<tr>
				<td colspan="7" align="right"><b>TOTAL</b> </td>
				<td align="right"><b><?echo $total;?> </b></td>
				<td></td>					
			</tr>
			<?}?>
			
			</tr>
			<tr>
				
			</tr>
			
		</tbody>
	</table></table>
	<br>
		 <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas065/load_view')">Back...</button>
            </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	$("#buttonClass").click(function() {
	    getValueUsingClass();
	});
	
});
var chkArray = [];
var selected;
function getValueUsingClass(){
	$(".chk:checked").each(function() {
		chkArray.push($(this).val());
		
	});
	selected = chkArray.join(',');
		for(var a=0; a<= chkArray.length-1;a++){
		alert("checkbox" + a+"="+chkArray[a]+"&");	
		}
}

var formid = "";
function get_filter_param()
{
	var url = '';
	var employeeid = $('#claim-list-search-employeeid_paid').val();
	var employeename = $('#claim-list-search-name_paid').val();
	var claimtype = $('#claim-list-search-type_paid').val();
	
	var year  = $('#claim-list-search-year_paid').val();
	var month = $('#claim-list-search-month_paid').val();
	var position = $('#claim-list-search-division_paid').val();
	var group = $('#claim-list-search-group_paid').val();
	var division = $('#claim-list-search-division_paid').val();
	if(selected != ''){
		url += "che="+employeeid+"&";
	}
	
	if(position == ""){
		var position = $('#claim-list-search-group_paid').val();
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
	
	if(year != ''){
		url += "year="+year+"&";
	}
	if(month != ''){
		url += "month="+month+"&";
	}
	if(group != ''){
		url += "group="+group+"&";
	}
	if(division != ''){
		url += "division="+division+"&";
	}

	return url;
}


function doSearch_paid(elm)
{
	var url="c_oas034/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

function doDownload_paid(elm)
{
	var url="c_oas034/download?"+get_filter_param();
	window.location.href = host+url;
}

$(function() { 
	$('#claim-list-search-group_paid').change(function(){
        
        $("#claim-list-search-division_paid > option").remove();
        $(".wait").removeClass('hide');
        $("#claim-list-search-division_paid").addClass('hide');
        var sub_unsur_id = $('#claim-list-search-group_paid').val();
        $.ajax({
            type: "POST",
            url: "c_oas034/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#claim-list-search-division_paid').append(opt);
                });
                $(".wait").addClass('hide');
                $("#claim-list-search-division_paid").removeClass('hide');
            }

        });
        
    });
});


function toggleChecked(status) {
  $(".checkbox").each( function() {
  	$(this).attr("checked",status);
  })
}

$('#select-all_paidClaim').click(function(event) {   
    if(this.checked) {
      // Iterate each checkbox
      $(':checkbox').each(function() {
        this.checked = true;  
      });
    }
    else {
      // Iterate each checkbox
      $(':checkbox').each(function() {
        this.checked = false;
      });
    }
  });
  
</script>