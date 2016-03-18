<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS066
* Program Name     : Paid Settlement
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 26-11-2014 10:52:00 ICT 2014
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
		<h2><b>List Paid Cash Advance Settlement </b></h2>
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
						<input type="text" id="PST_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="PST_group" class="" style="max-width:150px;">
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
						<input type="text" id="PST_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="PST_name_employee">
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
						<select id="PST_division" class="" style="max-width:150px;">
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
						
						<select id="PST_month" class="" style="max-width:150px;">
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
						<select id="PST_chargecodetype" class="" style="max-width:150px;">
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
						<select id="PST_chargecode" class="" style="max-width:150px;">
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
						Cash Advance Type :
					</td>
					<td>
						<select id="PST_type_ca" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($list_cash_advance_type as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['ca_type']==$type['id']) echo 'selected';?>><?= $type['type'] ?></option>
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
						<select id="PST_status_form_open" class="" style="max-width:150px;">
						<option value=""
						<?php if($search && $search_param['open'] <'1') echo 'selected';?>>-- All --</option>
                       
                        <option value="1"
                        	<?php if($search && $search_param['open']=='1') echo 'selected';?>> Open 
                        </option>
                     
                        <option value="2"
                        	<?php if($search && $search_param['open']=='2') echo 'selected';?>> Closed
                        </option>
                    </select>
					</td>
					<td>
					
					</td>
					<td>
					Currency :
						
					</td>
					<td colspan="2">
						<select id="PST_currency" class="" style="max-width:150px;">
							<option value=""
							<?php if($search && $search_param['PST_currency'] <'1') echo 'selected';?>>-- All --</option>
                       
							<option value="1"
                        	<?php if($search && $search_param['PST_currency']=='1') echo 'selected';?>> IDR 
							</option>
                     
							<option value="2"
                        	<?php if($search && $search_param['PST_currency']=='2') echo 'selected';?>> USD
							</option>
						</select>
					</td>
					<td colspan="2">
						
					</td>
				</tr>
				<tr height="5px">
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas066/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-PST-btn"  onclick="doSearch_PCA(this);">Search</button>
					</td>
				</tr>
			
			</table>
		</div>
	</div>
	<form action="/c_oas066/paid_selected" method="post" accept-charset="utf-8">
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
			<col width="13%">
			<col width="8%">
			<col width="8%">
			<col width="5%">
			<col width="8%">
			<col width="8%">
			<col width="6%">
			<col width="4%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th class="text-center">No. Ref</th>
				<th class="text-center">Employee Name</th>
				<th class="text-center">Type</th>
				<th class="text-center">Charge Code</th>
				<th class="text-center">Status Form</th>				
				<th class="text-center">Liability Employee</th>			
				<th class="text-center">Liability Company</th>
				<th class="text-center"><?php if(isset($submission_list)){?><button type="submit" class=" btn btn-primary btn-slim" id="paid-selected-settlement " >Paid Selected</button><br><input type='checkbox' name='PST-select-all' id='PST-select-all' /><?}?></th>
				<th class="text-center">Not Paid</th>
				

			</tr>
		</thead>
		<tbody>
	
			<?php 
			
			$no = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr class="<?php if ($value['status_id']=='0' && $value['approval']==$this_id) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['ca_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $value['ca_id'] ?>/5')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['ca_type'] ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					<td ><?= $value['form_status_name'] ?></td>
					
					<td  align="right"><?if ($value['sisa']  > 0){if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format(($value['sisa']),0,',','.');}else echo '0';?></td>
					<td  align="right"><?if ($value['sisa']  < 0){if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format((($value['sisa'])* -1),0,',','.');}else echo '0';?></td>
					<td>
						<center>
							<input type="checkbox" class="chk_st" name="checkbox<?php echo $no?>"  value="<?= $value['ca_id'] ?>"/>
						</center>
					</td>
					<td class="text-center">
					<?if ($value['sisa']  < 0){?>
						<a href="#" rel="detail" class="opt delete" title="Not Paid" id ="np" onclick="change_page(this, 'c_oas066/notpaid/<?= $value['ca_id'] ?>')"></a>
						<?}?>
					</td>
					<input type="text" hidden name="PST-emp-id<?php echo $no?>"  value="<?= $value['employee_id'] ?>"/>
					<input type="text" hidden name="PST-emp-email<?php echo $no?>"  value="<?= $value['employee_email'] ?>"/>
					<input type="text" hidden name="PST-emp-name<?php echo $no?>"  value="<?= $value['employee_name'] ?>"/>
					<input type="text" hidden name="PST-no-ref<?php echo $no?>"  value="<?= $value['no_ref'] ?>"/>
					<input type="hidden" value="<?php echo $no?>" id="loop" name="loop">
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="10">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
			
			</tr>
			
		</tbody>
	</table></table>
	<br>
		 <div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas065/load_view')">Back...</button>
            </div>
</div>
<!-- Page script -->
<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var employeeid		= $('#PST_employeeid').val();
	var employeename	= $('#PST_name_employee').val();
	var ca_type			= $('#PST_type_ca').val();
	var PST_cctype		= $('#PST_chargecodetype').val();
	var PST_chargecode	= $('#PST_chargecode').val();
	var PST_group		= $('#PST_group').val();
	var PST_division	= $('#PST_division').val();
	var PST_month		= $('#PST_month').val();
	var PST_year		= $('#PST_year').val();
	var PST_STAT_OPEN	= $('#PST_status_form_open').val();
	var PST_currency	= $('#PST_currency').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(ca_type != ''){
		url += "ca_type="+ca_type+"&";
	}
	if(PST_cctype != ''){
		url += "PST_cctype="+PST_cctype+"&";
	}
	if(PST_chargecode != ''){
		url += "PST_chargecode="+PST_chargecode+"&";
	}
	if(PST_group != ''){
		url += "PST_group="+PST_group+"&";
	}
	if(PST_division != ''){
		url += "PST_division="+PST_division+"&";
	}
	if(PST_month != ''){
		url += "PST_month="+PST_month+"&";
	}
	if(PST_year != ''){
		url += "PST_year="+PST_year+"&";
	}
	if(PST_STAT_OPEN != ''){
		url += "PST_STAT_OPEN="+PST_STAT_OPEN+"&";
	}
	if(PST_currency != ''){
		url += "PST_currency="+PST_currency+"&";
	}
	return url;
}

function doSearch_PCA(elm)
{
	var url="c_oas066/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

function doDownload_paid(elm)
{
	var url="c_oas066/download?"+get_filter_param();
	window.location.href = host+url;
}

$(function() { 
	$('#PST_group').change(function(){
        
        $("#PST_division > option").remove();
        $(".wait").removeClass('hide');
        $("#PST_division").addClass('hide');
        var sub_unsur_id = $('#PST_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas066/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PST_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PST_division").removeClass('hide');
            }

        });
        
    });
	
	
});


$(function() { 
	$('#PST_chargecodetype').change(function(){
        
        $("#PST_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#PST_chargecode").addClass('hide');
        var sub_unsur_id = $('#PST_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas066/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PST_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PST_chargecode").removeClass('hide');
            }

        });
        
    });
});

function toggleChecked(status) {
  $(".checkbox").each( function() {
  	$(this).attr("checked",status);
  })
}




$('#PST-select-all').click(function(event) {   
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