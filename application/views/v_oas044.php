<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS044
* Program Name     : Cash Advance List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 14-11-2014 12:45:00 ICT 2014
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
		<h2><b> List Employee Cash Advance   </b></h2>
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
						<input type="text" id="CA_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="CA_group" class="" style="max-width:150px;">
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
						<input type="text" id="CA_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="CA_name_employee">
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
						<select id="CA_division" class="" style="max-width:150px;">
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
						<select id="CA_month" class="" style="max-width:150px;">
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
						<select id="CA_chargecodetype" class="" style="max-width:150px;">
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
						<select id="CA_chargecode" class="" style="max-width:150px;">
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
						<select id="CA_type_ca" class="" style="max-width:150px;">
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
						Status Form :
					</td>
					<td>
						<select id="CA_status_form_open" class="" style="max-width:150px;">
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
						&nbsp;
					</td>
					<td>
					Status :
					</td>
					<td colspan="2">
						<select id="CA_currency" class="" style="max-width:150px;">
							<option value="-1"
							<?php if($search && $search_param['CA_currency'] =='-1') echo 'selected';?>>-- All --</option>
                       
							<option value="0"
                        	<?php if($search && $search_param['CA_currency']=='0') echo 'selected';?>> Need to be approved by Group Head 
                        </option>

                        <option value="1"
                        	<?php if($search && $search_param['CA_currency']=='1') echo 'selected';?>> Need to be accepted by Finance Admin
                        </option>

                        <option value="7"
                        	<?php if($search && $search_param['CA_currency']=='7') echo 'selected';?>> Need to be revise from Group Head
                        </option>
                     
                        <option value="8"
                        	<?php if($search && $search_param['CA_currency']=='8') echo 'selected';?>> Has been revised. Need to be approve by Group Head
                        </option>
						
                        <option value="16"
                        	<?php if($search && $search_param['CA_currency']=='16') echo 'selected';?>> Need to be confirmed by Finance Head
                        </option>

                        <option value="18"
                        	<?php if($search && $search_param['CA_currency']=='18') echo 'selected';?>> Need to be revise from Finance Head
                        </option>
                     
                        <option value="19"
                        	<?php if($search && $search_param['CA_currency']=='19') echo 'selected';?>> Has been revised. Need to be approve by Finance Head
                        </option>
						
                     
                        <option value="2"
                        	<?php if($search && $search_param['CA_currency']=='2') echo 'selected';?>> Need to be approved by Director
                        </option>
						
						<option value="3"
                        	<?php if($search && $search_param['CA_currency']=='3') echo 'selected';?>> Request Accepted 
                        </option>
                     
                        <option value="4"
                        	<?php if($search && $search_param['CA_currency']=='4') echo 'selected';?>> Not accepted by Finance Admin
                        </option>

                        <option value="17"
                        	<?php if($search && $search_param['CA_currency']=='17') echo 'selected';?>> Not confirmed by Finance Head
                        </option>
						
						<option value="5"
                        	<?php if($search && $search_param['CA_currency']=='5') echo 'selected';?>> Rejected by Director 
                        </option>
                     
                        <option value="6"
                        	<?php if($search && $search_param['CA_currency']=='6') echo 'selected';?>> Rejected by Group Head
                        </option>
						
						<option value="9"
                        	<?php if($search && $search_param['CA_currency']=='9') echo 'selected';?>> Need to be settled 
                        </option>
                     
                        <option value="10"
                        	<?php if($search && $search_param['CA_currency']=='10') echo 'selected';?>> Settlement form submited 
                        </option>
						
						<option value="11"
                        	<?php if($search && $search_param['CA_currency']=='11') echo 'selected';?>> Settlement Accepted
                        </option>
                     
                        <option value="12"
                        	<?php if($search && $search_param['CA_currency']=='12') echo 'selected';?>> Settlement paid
                        </option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas044/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearch_Ca(this);">Search</button>
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
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload_CA(this);">
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
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="15%">
			<col width="6%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Type</th>
				<th>Charge Code</th>
				<th>Amount</th>
				<th>Balance Settle</th>
				<th width="50" class="text-center">..:::..
			</tr>
		</thead>
		
		<tbody>
			<?php $no = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr class="<?php if ($value['type_id'] !='1' && (($value['status_id']=='0' && $value['approval']==$this_id)||($value['status_id']=='1' && $detail_akun['id']==$this_id)||($value['status_id']=='16' && $detail_akun2['id']==$this_id) || ($detail_dir['id']==$this_id && $value['status_id']=='2'))) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['ca_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $value['ca_id'] ?>/1')"><?= $value['no_ref'] ?><br>
					<code>

					<?php if($value['type_id'] =='1' && ($value['status_id']=='0' ||  $value['status_id'] == '1' || $value['status_id'] == '2' || $value['status_id'] == '7' || $value['status_id'] == '8' || $value['status_id'] == '16' || $value['status_id'] == '18' || $value['status_id'] == '19')){ echo 'BT in progress of acceptance';}
					if ($value['type_id'] =='1' && ($value['status_id']=='4' || $value['status_id']=='5' ||  $value['status_id'] == '6')){echo 'BT has been Rejected'; }
					if ($value['type_id'] !='1' || ($value['type_id'] =='1' && ($value['status_id']=='3' || ($value['status_id']>'8' &&  $value['status_id'] < '16')))) {echo  $value['status'] ;}?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['ca_type'] ?></td>
					
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['amount'],0,',','.'); ?></td>
					<td><?if ($value['balance']  < 0){ if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format((($value['balance'])* -1),0,',','.'); ?><code><? echo 'company';?></code><?}elseif($value['balance']  >0 && $value['balance']  !='0' ){ if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['balance'],0,',','.');?><code><? echo 'employee';?></code><?}elseif($value['balance']  =='0'){ echo '0';} else { echo '-';}?></td>
					<td>
					<?php if($value['type_id'] !='1' &&  (($detail_akun['id']==$this_id && $value['status_id']=='1' )||( $value['approval']==$this_id && ($value['status_id']=='0' || $value['status_id']=='8' )) ||( $detail_dir['id']==$this_id && $value['status_id']=='2' ) ||( $detail_akun2['id']==$this_id && ($value['status_id']=='16' || $value['status_id']=='19'  )) ||( $detail_admin['id']==$this_id && $value['employee_id']!=$this_id &&($value['status_id']=='19' || $value['status_id']=='0' || $value['status_id']=='1' || $value['status_id']=='2' || $value['status_id']=='16' || $value['status_id']=='8')))){ ?>
						<a href="#" class="opt approval" title="Konfirmasi" onclick="change_page(this, 'c_oas040/load_form/<?= $value['ca_id'] ?>')"></a>
					<?php } ?>
					<?php if(( $detail_akun['id']==$this_id && ($value['status_id']=='10' || $value['status_id']=='15' )) ||( $detail_admin['id']==$this_id && ($value['status_id']=='10' || $value['status_id']=='15' ))){ ?>
						<a href="#" class="opt approval" title="Konfirmasi settle" onclick="change_page(this, 'c_oas052/load_form/<?= $value['ca_id'] ?>')"></a>
					<?php } ?>
					<?php if($value['type_id'] !='1' && ($value['employee_id']==$this_id && ($value['status_id']=='0'|| $value['status_id']=='7' || $value['status_id']=='18'))){ ?>
						<a href="#" class="opt edit" title="Edit" onclick="change_page(this, 'c_oas038/load_edit/<?= $value['ca_id'] ?>')"></a>
					<?php } ?>
					<?php if($value['type_id'] !='1' && ($value['employee_id']==$this_id && ($value['status_id']=='10' || $value['status_id']=='14' ))){ ?>
						<a href="#" class="opt edit" title="Edit settle" onclick="change_page(this, 'c_oas039/load_edit/<?= $value['ca_id'] ?>')"></a>
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
	var employeeid		= $('#CA_employeeid').val();
	var employeename	= $('#CA_name_employee').val();
	var ca_type			= $('#CA_type_ca').val();
	var CA_cctype		= $('#CA_chargecodetype').val();
	var CA_chargecode	= $('#CA_chargecode').val();
	var CA_group		= $('#CA_group').val();
	var CA_division	= $('#CA_division').val();
	var CA_month		= $('#CA_month').val();
	var CA_year		= $('#CA_year').val();
	var CA_STAT_OPEN	= $('#CA_status_form_open').val();
	var CA_currency	= $('#CA_currency').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(ca_type != ''){
		url += "ca_type="+ca_type+"&";
	}
	if(CA_cctype != ''){
		url += "CA_cctype="+CA_cctype+"&";
	}
	if(CA_chargecode != ''){
		url += "CA_chargecode="+CA_chargecode+"&";
	}
	if(CA_group != ''){
		url += "CA_group="+CA_group+"&";
	}
	if(CA_division != ''){
		url += "CA_division="+CA_division+"&";
	}
	if(CA_month != ''){
		url += "CA_month="+CA_month+"&";
	}
	if(CA_year != ''){
		url += "CA_year="+CA_year+"&";
	}
	if(CA_STAT_OPEN != ''){
		url += "CA_STAT_OPEN="+CA_STAT_OPEN+"&";
	}
	if(CA_currency != ''){
		url += "CA_currency="+CA_currency+"&";
	}
	return url;
}

//function search
function doSearch_Ca(elm)
{
	var url="c_oas044/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

//function download
function doDownload_CA(elm)
{
	var url="c_oas044/download?"+get_filter_param();
	window.location.href = host+url;
}

//function filter divisi
$(function() { 
	$('#CA_group').change(function(){
        
        $("#CA_division > option").remove();
        $(".wait").removeClass('hide');
        $("#CA_division").addClass('hide');
        var sub_unsur_id = $('#CA_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas044/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#CA_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#CA_division").removeClass('hide');
            }
        }); 
    });
});

//function chargecode
$(function() { 
	$('#CA_chargecodetype').change(function(){
        
        $("#CA_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#CA_chargecode").addClass('hide');
        var sub_unsur_id = $('#CA_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas044/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#CA_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#CA_chargecode").removeClass('hide');
            }
        });
    });
});

</script>