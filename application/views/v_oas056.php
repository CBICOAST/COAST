<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS056
* Program Name     : Paid  Cash Advance Selected
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 25-11-2014 10:20:00 ICT 2014
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
		<h2><b>List Paid Cash Advance Selected</b></h2>
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
						<input type="text" id="PCA_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="PCA_group" class="" style="max-width:150px;">
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
						<input type="text" id="PCA_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						<select id="PCA_name_employee">
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
						<select id="PCA_division" class="" style="max-width:150px;">
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
						
						<select id="PCA_month" class="" style="max-width:150px;">
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
						<select id="PCA_chargecodetype" class="" style="max-width:150px;">
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
						<select id="PCA_chargecode" class="" style="max-width:150px;">
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
						<select id="PCA_type_ca" class="" style="max-width:150px;">
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
					Currency :
					</td>
					<td colspan="2">
						<select id="PCA_currency" class="" style="max-width:150px;">
							<option value=""
							<?php if($search && $search_param['PCA_currency'] <'1') echo 'selected';?>>-- All --</option>
                       
							<option value="1"
                        	<?php if($search && $search_param['PCA_currency']=='1') echo 'selected';?>> IDR 
							</option>
                     
							<option value="2"
                        	<?php if($search && $search_param['PCA_currency']=='2') echo 'selected';?>> USD
							</option>
							
							<option value="3"
                        	<?php if($search && $search_param['PCA_currency']=='3') echo 'selected';?>> SGD
							</option>
						</select>
					</td>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td colspan="6"></td>
					<td colspan="2">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas056/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-PCA-btn"  onclick="doSearch_PCA(this);">Search</button>
						
					</td>
				</tr>
				<tr height="5px">
					<td colspan="8"></td>
					<td>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<form action="/c_oas056/paid_selected" method="post" accept-charset="utf-8">
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
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
				<th>Type</th>
				<th>Submitted Date</th>
				<th>Charge Code</th>				
				<th class="text-center" >Amount</th>
				<th class="text-center"><?php if(isset($submission_list)){?><button type="submit" class=" btn btn-primary btn-slim" id="paid-selected " >Paid Selected</button><input type='checkbox' name='PCA-select-all' id='PCA-select-all' /><?}?></th>
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
					<td class="postit form-number pk" val="<?= $value['ca_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $value['ca_id'] ?>/4')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['ca_type'] ?></td>
					<td><?= $value['submitted_dt'] ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['amount'],0,',','.');?></td>
					<td align="center" ><input type="checkbox" class="chk_ca" name="checkbox<?php echo $no?>"  value="<?= $value['ca_id'] ?>"/></td>
					
					<input type="text" hidden name="PCA-emp-id<?php echo $no?>"  value="<?= $value['employee_id'] ?>"/>
					<input type="text" hidden name="PCA-emp-email<?php echo $no?>"  value="<?= $value['employee_email'] ?>"/>
					<input type="text" hidden name="PCA-emp-name<?php echo $no?>"  value="<?= $value['employee_name'] ?>"/>
					<input type="text" hidden name="PCA-no-ref<?php echo $no?>"  value="<?= $value['no_ref'] ?>"/>
					<input type="hidden" value="<?php echo $no?>" name="loop">
				
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="8">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
			<tr>
				<td colspan="8" align="center">PAGINATION</td>
			</tr>
			</tr>
			
		</tbody>
	</table></table>
	<br>
	<div class="box-footer clearfix">
            <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas065/load_view')">Back...</button>
    </div>
</div>

<script type="text/javascript">
//variabel parameter filter
function printah()
{
windows.print();
}
function get_filter_param()
{
	var url = '';
	var employeeid		= $('#PCA_employeeid').val();
	var employeename	= $('#PCA_name_employee').val();
	var ca_type			= $('#PCA_type_ca').val();
	var PCA_cctype		= $('#PCA_chargecodetype').val();
	var PCA_chargecode	= $('#PCA_chargecode').val();
	var PCA_group		= $('#PCA_group').val();
	var PCA_division	= $('#PCA_division').val();
	var PCA_month		= $('#PCA_month').val();
	var PCA_year		= $('#PCA_year').val();
	var PCA_currency	= $('#PCA_currency').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(ca_type != ''){
		url += "ca_type="+ca_type+"&";
	}
	if(PCA_cctype != ''){
		url += "PCA_cctype="+PCA_cctype+"&";
	}
	if(PCA_chargecode != ''){
		url += "PCA_chargecode="+PCA_chargecode+"&";
	}
	if(PCA_group != ''){
		url += "PCA_group="+PCA_group+"&";
	}
	if(PCA_division != ''){
		url += "PCA_division="+PCA_division+"&";
	}
	if(PCA_month != ''){
		url += "PCA_month="+PCA_month+"&";
	}
	if(PCA_year != ''){
		url += "PCA_year="+PCA_year+"&";
	}
	if(PCA_currency != ''){
		url += "PCA_currency="+PCA_currency+"&";
	}
	return url;
}
//function search
function doSearch_PCA(elm)
{
	var url="c_oas056/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}
//function fiter devisi
$(function() { 
	$('#PCA_group').change(function(){
        
        $("#PCA_division > option").remove();
        $(".wait").removeClass('hide');
        $("#PCA_division").addClass('hide');
        var sub_unsur_id = $('#PCA_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas056/load_division/"+sub_unsur_id,
            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PCA_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PCA_division").removeClass('hide');
            }
        });  
    });
});

//function filter chargecode
$(function() { 
	$('#PCA_chargecodetype').change(function(){
        
        $("#PCA_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#PCA_chargecode").addClass('hide');
        var sub_unsur_id = $('#PCA_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas056/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PCA_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PCA_chargecode").removeClass('hide');
            }
        });
    });
});
//function checkbox
function toggleChecked(status) {
  $(".checkbox").each( function() {
  	$(this).attr("checked",status);
  })
}
//function check all
$('#PCA-select-all').click(function(event) {   
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