<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS069
* Program Name     : List Total Per Charge  Codeon
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma/Dwi Irawati
* Version          : 01.00.00
* Creation Date    : 09-12-2014 23:50:00 ICT 2014
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
$totalca_idr = 0;
$totalca_usd = 0;
$totalca_sgd = 0;
					
$totalbt = 0;
$totalcl = 0;
?>
<div class="box-content no-padding">
	<div class="search-fields bs-callout list-title">
		<h2><b>List Amount Per Charge Code</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
					padding-bottom: 0px;">
			<table border="0" cellpadding="1" cellspacing="1">
				<colgroup>
					<col width="130px">
					<col width="150px">
					<col width="50px">
				</colgroup>
				<tr>
					<td>
						Year :
					</td>
					<td>
						<input type="text" id="year_divisi" class="form-control claim-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
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
						<select id="chargecode_divisi" class="">
						<option value="">-- All --</option>
						<?php if($search){
							foreach ($list_chargecode as $key => $chargecode) {?>
								<option value="<?= $chargecode['id'] ?>"
	                        	<?php if($search && $search_param['chargecode_id']==$chargecode['id']) echo 'selected';?>><?= $chargecode['name'] ?></option>
							<?php }
						} ?>
						
                    	</select>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas069/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearch_chargecode(this);">Search</button>
					</td>
				</tr>
				<tr height="5px">
					<td colspan="8">
						
					</td>
				</tr>
			
			</table>
		</div>
		</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="10%">
			<col width="40%">
			<col width="20%">
			<col width="15%">
			<col width="20%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>Charge Code</th>
				<th>Charge Code Name</th>
				<th>Employee Name</th>
				<th>Date</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<tr>
				<td colspan="6" align="left"><b>Exspanse Claim</b></td>
			</tr>
			<?php $no = 0;
			
			if(isset($submission_list_cl)){
			foreach ($submission_list_cl as $key => $value) { 
				$no++;?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $value['chargecode_id'] ?></td>
					<td><?= $value['chargecode_name'] ?></td>
					<td><?= $value['empl_name'] ?></td>
					<td><?= date('d F Y',strtotime($value['submited_dt'])) ;?></td>
					<td align="right"><?php  echo 'Rp. '. number_format($value['amount_cl'],0,',','.'); ?></td>
					<? $totalcl += $value['amount_cl'];?>
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="6">NOT FOUND!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="5" align="right"><b>TOTAL CL</b> </td>
				<td align="right"><b><?php  echo 'Rp. '. number_format($totalcl,0,',','.'); ?> </b></td>
			
			</tr>
			<tr>
				<td colspan="6" align="left"><b>Business Travel</b></td>
			</tr>
			<?php $no = 0;
			
			if(isset($submission_list_bt)){
			foreach ($submission_list_bt as $key => $value) { 
				$no++;?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $value['chargecode_id'] ?></td>
					<td><?= $value['chargecode_name'] ?></td>
					<td><?= $value['empl_name'] ?></td>
					<td><?= date('d F Y',strtotime($value['submited_dt'])) ;?></td>
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. ' ;}else{echo '$ ';}?><?php echo number_format($value['amount_bt'],0,',','.'); ?></td>
					<? $totalbt += $value['amount_bt'];?>
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="6">NOT FOUND!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="5" align="right"><b>TOTAL BT</b> </td>
				<td align="right"><b><?php echo 'Rp. ' ;?><?php echo number_format($totalbt,0,',','.'); ?> </b></td>
			
			</tr>
			<tr>
				<td colspan="6" align="left"><b>Cash Advance</b></td>
			</tr>
			<?php $no = 0;
			
			if(isset($submission_list_ca)){
			foreach ($submission_list_ca as $key => $value) { 
				$no++;?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $value['chargecode_id'] ?></td>
					<td><?= $value['chargecode_name'] ?></td>
					<td><?= $value['empl_name'] ?></td>
					<td><?= date('d F Y',strtotime($value['submited_dt'])); ?></td>
					<td align="right"><?php if ($value['currency']=='1'){ echo 'Rp. '.number_format($value['amount_ca_idr'],0,',','.') ;}if ($value['currency']=='2'){echo '$ '.number_format($value['amount_ca_usd'],0,',','.');}if ($value['currency']=='3'){echo '$ '.number_format($value['amount_ca_sgd'],0,',','.');}?></td>
					<? $totalca_idr += $value['amount_ca_idr'];?>
					<? $totalca_usd += $value['amount_ca_usd'];?>
					<? $totalca_sgd += $value['amount_ca_sgd'];?>
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="6">NOT FOUND!</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="5" align="right"><b>TOTAL CA</b> </td>
				<td align="right"><b><?php echo 'Rp. ' ;?><?php echo number_format($totalca_idr,0,',','.'); ?> </b></td>
			
			</tr>
			<tr>
				<td colspan="5" align="right"><b></b> </td>
				<td  align="right"><b><?php echo '$. ' ;?><?php echo number_format($totalca_usd,0,',','.'); ?> </b></td>
			
			</tr>
			<tr>
				<td colspan="5" align="right"><b></b> </td>
				<td align="right"><b><?php echo '$. ' ;?><?php echo number_format($totalca_sgd,0,',','.'); ?> </b></td>
			
			</tr>
			
		</tbody>
		<tr>
				<td colspan="6" align="left"><b>Calculate Chargecode</b></td>
				
		</tr>
		<tr>
				
				<td colspan="5" align="right"><b>TOTAL ALL :</b></td>
				<td colspan="1" align="right"><b><?echo 'Rp. '. number_format((($totalca_idr)+($totalbt)+($totalcl)),0,',','.');?></b></td>
		</tr>
		<tr>
				
				<td colspan="5" align="right"><b> </b></td>
				<td colspan="1" align="right"><b><?echo '$. '. number_format($totalca_usd,0,',','.');?></b></td>
		</tr>
		<tr>
				
				<td colspan="5" align="right"><b> </b></td>
				<td colspan="1" align="right"><b><?echo '$. '. number_format($totalca_sgd,0,',','.');?></b></td>
		</tr>
	</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var year  = $('#year_divisi').val();
	var month = $('#month_divisi').val();
	var chargecodetype = $('#chargecodetype_divisi').val();
	var chargecode = $('#chargecode_divisi').val();
	
	if(year != ''){
		url += "year="+year+"&";
	}
	if(month != ''){
		url += "month="+month+"&";
	}
	
	if(chargecodetype != ''){
		url += "chargecodetype="+chargecodetype+"&";
	}
	if(chargecode != ''){
		url += "chargecode="+chargecode+"&";
	}

	return url;
}


function doSearch_chargecode(elm)
{
	var url="c_oas069/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

function doDownload_divisi(elm)
{
	var url="c_oas069/download?"+get_filter_param();
	window.location.href = host+url;
	// search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}


$(function() { 
	$('#group_divisi').change(function(){
        
        $("#division_divisi > option").remove();
        $(".wait").removeClass('hide');
        $("#division_divisi").addClass('hide');
        var sub_unsur_id = $('#group_divisi').val();
        $.ajax({
            type: "POST",
            url: "c_oas069/load_division/"+sub_unsur_id,

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
            url: "c_oas069/load_chargecode/"+sub_unsur_id,

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