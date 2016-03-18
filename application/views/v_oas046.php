<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS046
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
		<h2><b>Report Cash Advance  </b></h2>
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
						<input type="text" id="RCA_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="RCA_group" class="" style="max-width:150px;">
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
						<input type="text" id="RCA_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="RCA_name_employee">
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
						<select id="RCA_division" class="" style="max-width:150px;">
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
						
						<select id="RCA_month" class="" style="max-width:150px;">
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
						<select id="RCA_chargecodetype" class="" style="max-width:150px;">
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
						<select id="RCA_chargecode" class="" style="max-width:150px;">
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
						CA Type :
					</td>
					<td>
						<select id="RCA_type_ca" class="" style="max-width:150px;">
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
						<select id="RCA_status_form_open" class="" style="max-width:150px;">
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
					<td colspan="1">
						<select id="RCA_currency" class="" style="max-width:150px;">
							<option value=""
							<?php if($search && $search_param['RCA_currency'] <'1') echo 'selected';?>>-- All --</option>
                       
							<option value="1"
                        	<?php if($search && $search_param['RCA_currency']=='1') echo 'selected';?>> IDR 
							</option>
                     
							<option value="2"
                        	<?php if($search && $search_param['RCA_currency']=='2') echo 'selected';?>> USD
							</option>
							<option value="3"
                        	<?php if($search && $search_param['RCA_currency']=='3') echo 'selected';?>> SGD
							</option>
						</select>
					</td>
					<td colspan="1">
						
					</td>
				</tr>
				<tr height="5px">
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas046/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearch_allCa(this);">Search</button>
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
					<td colspan="2" >
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload_report_CA(this);">
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
			<col width="8%">
			<col width="8%">
			<col width="7%">
			<col width="7%">
			<col width="10%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Type</th>
				<th>Charge Code</th>
				<th>Company's liability</th>
				<th>Employee's liability</th>
				<th>Amount Settlement Company</th>
				<th>Amount Settlement Employee</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			$setl_amount_IDR = 0;
			$setl_amount_USD = 0;
			$setl_amount_SGD = 0;
			$setl_amount_IDR_employee = 0;
			$setl_amount_USD_employee = 0;
			$setl_amount_SGD_employee = 0;
			$liability_IDR = 0;
			$liability_USD = 0;
			$liability_SGD = 0;
			$liability_IDR_employee = 0;
			$liability_USD_employee = 0;
			$liability_SGD_employee = 0;
			
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr class="<?php if ($value['status_id']=='0' && $value['approval']==$this_id) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['ca_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas043/load_form/<?= $value['ca_id'] ?>')"><?= $value['no_ref'] ?>/ </br><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['ca_type'] ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['liability_setl_amount'],0,',','.'); ?></td>
					<? $liability_IDR += $value['liability_IDR'];?>
					<? $liability_IDR_employee += $value['liability_IDR_employee'];?>
					
					<? $liability_USD += $value['liability_USD'];?>
					<? $liability_SGD += $value['liability_SGD'];?>
					
					<? $liability_USD_employee += $value['liability_USD_employee'];?>
					<? $liability_SGD_employee += $value['liability_SGD_employee'];?>
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['liability_setl_amount_employee'],0,',','.'); ?></td>
					
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['setl_amount'],0,',','.'); ?></td>
					<? $setl_amount_IDR += $value['setl_amount_IDR'];?>
					<? $setl_amount_IDR_employee += $value['setl_amount_IDR_employee'];?>
					
					<? $setl_amount_USD += $value['setl_amount_USD'];?>
					<? $setl_amount_SGD += $value['setl_amount_SGD'];?>
					
					<? $setl_amount_USD_employee += $value['setl_amount_USD_employee'];?>
					<? $setl_amount_SGD_employee += $value['setl_amount_SGD_employee'];?>
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['setl_amount_employee'],0,',','.'); ?></td>
					
					
					
				</tr>
				
			<?php }
			?><tr id ="RCA_totalIDR">
				<td colspan="5" align="right"><b>TOTAL (IDR)</b> </td>
				<td align="right"><?php echo 'Rp. '.number_format($liability_IDR,0,',','.'); ?></td>
				<td align="right"> <?php echo 'Rp. '.number_format($liability_IDR_employee,0,',','.'); ?></td>
				<td align="right"> <?php echo 'Rp. '.number_format($setl_amount_IDR,0,',','.'); ?></td>
				<td align="right"> <?php echo 'Rp. '.number_format($setl_amount_IDR_employee,0,',','.'); ?></td>
				
			
			</tr><tr id ="RCA_totalUSD">
				<td colspan="5" align="right"><b>TOTAL (USD)</b> </td>
				<td align="right"><b><?php echo '$. '.number_format($liability_USD,0,',','.'); ?></b></td>
				<td align="right"><b><?php echo '$. '.number_format($liability_USD_employee,0,',','.'); ?> </b></td>
				<td align="right"><b><?php echo '$. '.number_format($setl_amount_USD,0,',','.'); ?></b></td>
				<td align="right"><b><?php echo '$. '.number_format($setl_amount_USD_employee,0,',','.'); ?> </b></td>
				
			
			</tr>
			<tr id ="RCA_totalSGD">
				<td colspan="5" align="right"><b>TOTAL (SGD)</b> </td>
				<td align="right"><b><?php echo '$. '.number_format($liability_SGD,0,',','.'); ?></b></td>
				<td align="right"><b><?php echo '$. '.number_format($liability_SGD_employee,0,',','.'); ?> </b></td>
				<td align="right"><b><?php echo '$. '.number_format($setl_amount_SGD,0,',','.'); ?></b></td>
				<td align="right"><b><?php echo '$. '.number_format($setl_amount_SGD_employee,0,',','.'); ?> </b></td>
				
			
			</tr><?
			 }else{
			?>
			
			<tr>
				<td class="text-center" colspan="9">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
			
		</tbody>
	</table>
</div>

<script type="text/javascript">

<?php if($search && $search_param['RCA_currency']=='1') {?>
	$('#RCA_totalUSD').hide();
	$('#RCA_totalSGD').hide();<?}
else if($search && $search_param['RCA_currency']=='2') {?>
	$('#RCA_totalIDR').hide();
	$('#RCA_totalSGD').hide();<?}
else if($search && $search_param['RCA_currency']=='3') {?>
	$('#RCA_totalUSD').hide();
	$('#RCA_totalIDR').hide();<?}
else  {?>
	$('#RCA_totalIDR').show();
	$('#RCA_totalUSD').show();
	$('#RCA_totalSGD').show();<?}	?>
function get_filter_param()
{
	var url = '';
	var employeeid		= $('#RCA_employeeid').val();
	var employeename	= $('#RCA_name_employee').val();
	var ca_type			= $('#RCA_type_ca').val();
	var RCA_cctype		= $('#RCA_chargecodetype').val();
	var RCA_chargecode	= $('#RCA_chargecode').val();
	var RCA_group		= $('#RCA_group').val();
	var RCA_division	= $('#RCA_division').val();
	var RCA_month		= $('#RCA_month').val();
	var RCA_year		= $('#RCA_year').val();
	var RCA_STAT_OPEN	= $('#RCA_status_form_open').val();
	var RCA_currency	= $('#RCA_currency').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(ca_type != ''){
		url += "ca_type="+ca_type+"&";
	}
	if(RCA_cctype != ''){
		url += "RCA_cctype="+RCA_cctype+"&";
	}
	if(RCA_chargecode != ''){
		url += "RCA_chargecode="+RCA_chargecode+"&";
	}
	if(RCA_group != ''){
		url += "RCA_group="+RCA_group+"&";
	}
	if(RCA_division != ''){
		url += "RCA_division="+RCA_division+"&";
	}
	if(RCA_month != ''){
		url += "RCA_month="+RCA_month+"&";
	}
	if(RCA_year != ''){
		url += "RCA_year="+RCA_year+"&";
	}
	if(RCA_STAT_OPEN != ''){
		url += "RCA_STAT_OPEN="+RCA_STAT_OPEN+"&";
	}
	if(RCA_currency != ''){
		url += "RCA_currency="+RCA_currency+"&";		
	}
	return url;	
	
}

function doSearch_allCa(elm)
{
	var url="c_oas046/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));	
}

function doDownload_report_CA(elm)
{
	var url="c_oas046/download?"+get_filter_param();
	window.location.href = host+url;
}


$(function() { 
	$('#RCA_group').change(function(){
        
        $("#RCA_division > option").remove();
        $(".wait").removeClass('hide');
        $("#RCA_division").addClass('hide');
        var sub_unsur_id = $('#RCA_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas046/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#RCA_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#RCA_division").removeClass('hide');
            }

        });
        
    });
	
	
});


$(function() { 
	$('#RCA_chargecodetype').change(function(){
        
        $("#RCA_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#RCA_chargecode").addClass('hide');
        var sub_unsur_id = $('#RCA_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas046/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#RCA_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#RCA_chargecode").removeClass('hide');
            }

        });
        
    });
});


</script>