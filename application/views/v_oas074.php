<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS074
* Program Name     : Purchase Request Report
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma Herdiati
* Version          : 01.00.00
* Creation Date    : 16-02-2015 16:01:00 ICT 2014
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
		<h2><b> List Report Purchase Request   </b></h2>
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
						<input type="text" id="PR_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="PR_group" class="" style="max-width:150px;">
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
						<input type="text" id="PR_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="PR_name_employee">
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
						<select id="PR_division" class="" style="max-width:150px;">
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
						<select id="PR_month" class="" style="max-width:150px;">
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
						<select id="PR_chargecodetype" class="" style="max-width:150px;">
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
						<select id="PR_chargecode" class="" style="max-width:150px;">
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
					Status :
					</td>
					<td colspan="2">
						<select id="PR_currency" class="" style="max-width:150px;">
							<option value="-1"
							<?php if($search && $search_param['PR_currency'] =='-1') echo 'selected';?>>-- All --</option>
                       
							<option value="0"
                        	<?php if($search && $search_param['PR_currency']=='0') echo 'selected';?>> Need to be approved   
                        </option>
                     
                        <option value="1"
                        	<?php if($search && $search_param['PR_currency']=='1') echo 'selected';?>> Need to be accepted Finance
                        </option>
						
						<option value="2"
                        	<?php if($search && $search_param['PR_currency']=='2') echo 'selected';?>> Need to be reviewed 
                        </option>
						
						<option value="3"
                        	<?php if($search && $search_param['PR_currency']=='3') echo 'selected';?>> Need to be accepted Purchase 
                        </option>
                     
                        <option value="4"
                        	<?php if($search && $search_param['PR_currency']=='4') echo 'selected';?>> Accepted
                        </option>
						
						<option value="5"
                        	<?php if($search && $search_param['PR_currency']=='5') echo 'selected';?>> Not accepted by Purchase
                        </option>
                     
                        <option value="6"
                        	<?php if($search && $search_param['PR_currency']=='6') echo 'selected';?>> Rejected by Director
                        </option>
						
						<option value="7"
                        	<?php if($search && $search_param['PR_currency']=='7') echo 'selected';?>> Not accepted by Finance 
                        </option>
                     
                        <option value="8"
                        	<?php if($search && $search_param['PR_currency']=='8') echo 'selected';?>> Rejected by approval
                        </option>
						
						<option value="9"
                        	<?php if($search && $search_param['PR_currency']=='9') echo 'selected';?>> Cenceled 
                        </option>
						<option value="10"
                        	<?php if($search && $search_param['PR_currency']=='10') echo 'selected';?>> Done PO 
                        </option>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
				<td colspan = "8">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas074/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearch_PrReport(this);">Search</button>
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
					<td colspan="2">
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload_PRReport(this);">
							<i class="fa fa-download"></i>
							.xls
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="32%">
			<col width="15%">
			<col width="20%">
			<col width="10%">
			<col width="15%">
			<col width="6%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Submitted Date</th>
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
				<tr class="<?php if (($value['status_id']=='0' && $value['approval']==$this_id)||($value['status_id']=='3' && $detail_akun['id']==$this_id) || ($detail_dir['id']==$this_id && $value['status_id']=='2') || ($detail_pur['id']==$this_id && $value['status_id']=='1')) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['pr_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas082/load_form/<?= $value['pr_id'] ?>')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['submitted_dt'] ?></td>
					<td><?= $value['employee_name'] ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?php echo number_format($value['amount'],0,',','.'); ?></td>
					
					<td>
					<?php if(($detail_akun['id']==$this_id && $value['status_id']=='3' )||( $value['approval']==$this_id && $value['status_id']=='0' ) ||( $detail_pur['id']==$this_id && $value['status_id']=='1' ) ||( $detail_dir['id']==$this_id && $value['status_id']=='2' ) ||( $detail_admin['id']==$this_id && $value['employee_id']!=$this_id &&($value['status_id']=='0' || $value['status_id']=='1' || $value['status_id']=='2' || $value['status_id']=='3' || $value['status_id']=='11'))){ ?>
						<a href="#" class="opt approval" title="Konfirmasi" onclick="change_page(this, 'c_oas071/load_form/<?= $value['pr_id'] ?>')"></a>
					<?php } ?>
					
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
				<td colspan="9" align="center">PAGINATION</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
//buat variabel search
function get_filter_param()
{
	var url = '';
	var employeeid		= $('#PR_employeeid').val();
	var employeename	= $('#PR_name_employee').val();
	var PR_cctype		= $('#PR_chargecodetype').val();
	var PR_chargecode	= $('#PR_chargecode').val();
	var PR_group		= $('#PR_group').val();
	var PR_division	= $('#PR_division').val();
	var PR_month		= $('#PR_month').val();
	var PR_year		= $('#PR_year').val();
	var PR_currency	= $('#PR_currency').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(PR_cctype != ''){
		url += "PR_cctype="+PR_cctype+"&";
	}
	if(PR_chargecode != ''){
		url += "PR_chargecode="+PR_chargecode+"&";
	}
	if(PR_group != ''){
		url += "PR_group="+PR_group+"&";
	}
	if(PR_division != ''){
		url += "PR_division="+PR_division+"&";
	}
	if(PR_month != ''){
		url += "PR_month="+PR_month+"&";
	}
	if(PR_year != ''){
		url += "PR_year="+PR_year+"&";
	}
	if(PR_currency != ''){
		url += "PR_currency="+PR_currency+"&";
	}
	return url;
}

//function search
function doSearch_PrReport(elm)
{
	var url="c_oas074/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

//function download
function doDownload_PRReport(elm)
{
	var url="c_oas074/download?"+get_filter_param();
	window.location.href = host+url;
}

//function filter divisi
$(function() { 
	$('#PR_group').change(function(){
        
        $("#PR_division > option").remove();
        $(".wait").removeClass('hide');
        $("#PR_division").addClass('hide');
        var sub_unsur_id = $('#PR_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas074/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PR_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PR_division").removeClass('hide');
            }
        }); 
    });
});

//function chargecode
$(function() { 
	$('#PR_chargecodetype').change(function(){
        
        $("#PR_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#PR_chargecode").addClass('hide');
        var sub_unsur_id = $('#PR_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas074/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PR_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PR_chargecode").removeClass('hide');
            }
        });
    });
});

</script>