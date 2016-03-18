<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS078
* Program Name     : Purchase Order List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 16:01:00 ICT 2015
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
		<h2><b> List Purchase Order   </b></h2>
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
						<input type="text" id="PO_employeeid" class="form-control" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>"placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="PO_group" class="" style="max-width:150px;">
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
						<input type="text" id="PO_year" class="form-control" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						
						<select id="PO_name_employee">
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
						<select id="PO_division" class="" style="max-width:150px;">
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
						<select id="PO_month" class="" style="max-width:150px;">
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
						<select id="PO_chargecodetype" class="" style="max-width:150px;">
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
						<select id="PO_chargecode" class="" style="max-width:150px;">
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
						<select id="PO_status" class="" style="max-width:150px;">
							<option value="-1"
							<?php if($search && $search_param['PO_status'] =='-1') echo 'selected';?>>-- All --</option>
                       
							<option value="0"
                        	<?php if($search && $search_param['PO_status']=='0') echo 'selected';?>> Need to be Confirmed
                        </option>
                     
                        <option value="1"
                        	<?php if($search && $search_param['PO_status']=='1') echo 'selected';?>> Confirmed
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas078/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearchPO(this);">Search</button>
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
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownloadPO(this);">
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
			<col width="30%">
			<col width="15%">
			<col width="15%">
			<col width="10%">
			<col width="10%">
			<col width="8%">
			<col width="8%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Submitted Date</th>
				<th>Charge Code</th>
				<th>Amount</th>
				<th width="50" class="text-center">..:::..</th>
				<th width="50" class="text-center"><i class="fa fa-download"></i>.pdf</th>
			</tr>
		</thead>
		
		<tbody>
			<?php $no = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr class="<?php if (($value['status_id']=='0' && $value['approval']==$this_id)||($value['status_id']=='3' && $detail_akun['id']==$this_id) || ($detail_dir['id']==$this_id && $value['status_id']=='2') || ($detail_pur['id']==$this_id && ($value['status_id']=='1'|| $value['status_id']=='4'))) echo 'warning'; else echo 'Approved'; ?>">
					<td><?= $no ?></td>
					<td class="postit form-number pk" val="<?= $value['pr_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas080/load_form/<?= $value['pr_id'] ?>')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['submitted_dt'] ?></td>
					<td title="<?= $value['ccdes'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?php echo number_format($value['amount'],0,',','.'); ?></td>
					
					<td>
					<?php if(( $detail_pur['id']==$this_id && $value['status_id']!='3' ) || ($detail_akun['id']==$this_id && $value['status_id']!='3' )  ||( $detail_admin['id']==$this_id && $value['employee_id']!=$this_id &&($value['status_id']!='3' || $value['status_id']!='3' ))){ ?>
						<a href="#" class="opt approval" title="Konfirmasi" onclick="change_page(this, 'c_oas079/load_form/<?= $value['pr_id'] ?>')"></a>
					<?php }?>
					
					</td>
					
					<td>
					<?  if(( $detail_pur['id']==$this_id && ($value['status_id']=='1' || $value['status_id']=='3')) || ($detail_akun['id']==$this_id && ($value['status_id']=='1' || $value['status_id']=='3'))  ||( $detail_admin['id']==$this_id && $value['employee_id']!=$this_id &&($value['status_id']=='1'))) { ?>
					<a href="<?php echo base_url(); ?>./c_oas076/cetak/<?= $value['po_id'] ?>">
					<button id = "print-btn" class="btn btn-small btn-info">
						<i class="icon-download-alt icon-on-right bigger-110"></i>
							<i class="fa fa-download"></i>
							.pdf
						</button>
						<?php }?>
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
	var employeeid		= $('#PO_employeeid').val();
	var employeename	= $('#PO_name_employee').val();
	var PO_cctype		= $('#PO_chargecodetype').val();
	var PO_chargecode	= $('#PO_chargecode').val();
	var PO_group		= $('#PO_group').val();
	var PO_division	= $('#PO_division').val();
	var PO_month		= $('#PO_month').val();
	var PO_year		= $('#PO_year').val();
	var PO_status	= $('#PO_status').val();
	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(PO_cctype != ''){
		url += "PO_cctype="+PO_cctype+"&";
	}
	if(PO_chargecode != ''){
		url += "PO_chargecode="+PO_chargecode+"&";
	}
	if(PO_group != ''){
		url += "PO_group="+PO_group+"&";
	}
	if(PO_division != ''){
		url += "PO_division="+PO_division+"&";
	}
	if(PO_month != ''){
		url += "PO_month="+PO_month+"&";
	}
	if(PO_year != ''){
		url += "PO_year="+PO_year+"&";
	}
	if(PO_status != ''){
		url += "PO_status="+PO_status+"&";
	}
	return url;
}

//function search
function doSearchPO(elm)
{
	var url="c_oas078/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

//function download
function doDownloadPO(elm)
{
	var url="c_oas078/download?"+get_filter_param();
	window.location.href = host+url;
}

//function filter divisi
$(function() { 
	$('#PO_group').change(function(){
        
        $("#PO_division > option").remove();
        $(".wait").removeClass('hide');
        $("#PO_division").addClass('hide');
        var sub_unsur_id = $('#PO_group').val();
        $.ajax({
            type: "POST",
            url: "c_oas078/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PO_division').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PO_division").removeClass('hide');
            }
        }); 
    });
});

//function chargecode
$(function() { 
	$('#PO_chargecodetype').change(function(){
        
        $("#PO_chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#PO_chargecode").addClass('hide');
        var sub_unsur_id = $('#PO_chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas078/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#PO_chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#PO_chargecode").removeClass('hide');
            }
        });
    });
});

</script>