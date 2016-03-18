<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
*Program Id       : OAS022
* Program Name     : Daftar Pengajuan Klaim
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 26-09-2014 13:14:00 ICT 2014
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
		<h2><b>Expense Claim List</b></h2>
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
						<input type="text" id="claim-list-search-employeeidlistclaim" class="form-control claim-list-search" maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="claim-list-search-grouplistclaim" class="" style="max-width:150px;">
						<option value="">-- All --</option>
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
						<input type="text" id="claim-list-search-yearlistclaim" class="form-control claim-list-search" maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Employee Name :
					</td>
					<td>
						<select id="claim-list-search-namelistclaim">
							<option value=''>-- All --</option>
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
						<select id="claim-list-search-divisionlistclaim" class="" style="max-width:150px;">
						<option value="">-- All --</option>
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
						<select id="claim-list-search-monthlistclaim" class="" style="max-width:150px;">
						<option value="">-- All --</option>
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
						<select id="claim-list-search-typelistclaim" class="" style="max-width:150px;">
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
						Status :
					</td>
					<td>
						<select id="claim-list-search-statuslistclaim" class="" style="max-width:150px;">
						<option value="-1"
						<?php if($search && $search_param['claimstatus']=='-1') echo 'selected';?>>-- All --</option>
                        
                        <option value="0"
                        	<?php if($search && $search_param['claimstatus']=='0') echo 'selected';?>> Needs to be approved by RM/Group Head
                        </option>
                        <option value="1"
                        	<?php if($search && $search_param['claimstatus']=='1') echo 'selected';?>> Needs to be accepted by Finance Admin
                        </option>
						<option value="7"
                        	<?php if($search && $search_param['claimstatus']=='7') echo 'selected';?>> Needs to be revised by Requester
                         </option>  				 
						 <option value="8"
                        	<?php if($search && $search_param['claimstatus']=='8') echo 'selected';?>> Has been revised by Requester
                         </option>
						 <option value="11"
                        	<?php if($search && $search_param['claimstatus']=='11') echo 'selected';?>>Has been accepted by Finance Admin
                         </option>
						 <option value="9"
                        	<?php if($search && $search_param['claimstatus']=='9') echo 'selected';?>> Has been approved by Finance Head
                         </option>						
						 <option value="10"
                        	<?php if($search && $search_param['claimstatus']=='10') echo 'selected';?>>Has been approved by Director
                         </option>
                        <option value="6"
                        	<?php if($search && $search_param['claimstatus']=='6') echo 'selected';?>> Has been paid by Finace Admin
                        </option>
						<option value="4"
                        	<?php if($search && $search_param['claimstatus']=='4') echo 'selected';?>> Has been rejected by RM/Group Head 
                        </option>                      
                        <option value="3"
                        	<?php if($search && $search_param['claimstatus']=='3') echo 'selected';?>> Has not been accepted by Finance Admin
                        </option>
						<option value="12"
                        	<?php if($search && $search_param['claimstatus']=='12') echo 'selected';?>> Has been rejected by Director
                        </option>		
                    </select>
					</td>
					<td>
					</td>
					<td>
						
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim"  onclick="change_page(this, 'c_oas022/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" onclick="doSearchClaimList(this);">Search</button>
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
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownload(this);">
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
			<col width="15%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="8%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>No. Ref</th>
				<th>Employee Name</th>
				<th>Group</th>
				<th>Division</th>
				<th>Claim Type</th>
				<th>Amount</th>
				
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
					<td class="postit form-number pk" val="<?= $value['claim_id'] ?>"><a href="#"  title="Detail" onclick="change_page(this, 'c_oas025/load_form/<?= $value['claim_id'] ?>/list')"><?= $value['no_ref'] ?><br>
					<code><?
					if( ($value['status_id'] != 1) &&($value['status_id'] != 9)&&($value['status_id'] != 11)){
						echo $value['status'] ;}
					if( $value['status_id'] == 1){
						echo "Has been approved by RM/Group Head. <br> ".$value['status'] ;}
					if( ($value['status_id'] == 9) && ($value['type_id'] == 4)){// Jika telah di aprove F2 dan butuh approve dir
						echo $value['status'] .".<br>Needs to be approved by Director ";}
					if( ($value['status_id'] == 9) && ($value['type_id'] != 4)){// Jika telah di aprove F2 dan TIDAK BUTUH approve dir
						echo $value['status'] ;}
					if( ($value['status_id'] == 11) && ($value['category'] == 1)){// Jika telah di accept F1 dan BUKAN klaim divisi
						echo $value['status'] ;}
					if( ($value['status_id'] == 11) && ($value['category'] == 2)){// Jika telah di accept F1 dan merupakan klaim divisi
						echo $value['status'] .". <br> Needs to be approved by Finance Head" ;}?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['employee_group_name'] ?></td>
					<td><?= $value['employee_division_name'] ?></td>
					<td><?= $value['leave_type'] ?></td>
					<td><?= number_format($value['total'],0,",",".") ?></td>
					<td>
					<?php if ($value['category']=='2'){ ?>
												
						<?php if(($value['akuntan']==$this_id && $value['status_id']=='1' )||( $value['approval']==$this_id && ($value['status_id']=='0' || $value['status_id']=='8') ) ||( $detail_admin['id']==$this_id && ($value['status_id']=='0' ||  $value['status_id']=='8') )||( $detail_admin['id']==$this_id && $value['status_id']=='1' ) || ( ($detail_admin['id']==$this_id || $detail_f2['id']==$this_id )&& $value['status_id']=='11' )|| ( ($detail_admin['id']==$this_id || $detail_dir['id']==$this_id) && $value['status_id']=='9' && $value['type_id']=='4' )){ ?>
						<a href="#" class="opt approval" title="Confirmation" onclick="change_page(this, 'c_oas033/load_form/<?= $value['claim_id'] ?>')"></a>
						<?php } ?>
						
						<?php if($value['employee_id']==$this_id && ($value['status_id']=='0'||$value['status_id']=='7')){ ?>
						<a href="#" class="opt edit" title="Edit" onclick="change_page(this, 'c_oas023/load_form_edit/<?= $value['claim_id'] ?>')"></a>
						<?php } ?>
						
						
					<?php  } ?>
					<?php if ($value['category']=='1'){ ?>
				
						
						<?php if(( $value['approval']==$this_id && $value['status_id']=='1' )||($detail_admin['id']==$this_id && $value['status_id']=='1' )){ ?>
						<a href="#" class="opt approval" title="Confirmation" onclick="change_page(this, 'c_oas033/load_form/<?= $value['claim_id'] ?>')"></a>
						<?php } ?>
						<?php if($value['employee_id']==$this_id && $value['status_id']=='1'){ ?>
						<a href="#" class="opt edit" title="Edit" onclick="change_page(this, 'c_oas023/load_form_edit/<?= $value['claim_id'] ?>')"></a>
						<?php } ?>
						
<?php  } ?>
					</td>
					
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="8">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
		</tbody>
	</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var employeeid = $('#claim-list-search-employeeidlistclaim').val();
	var employeename = $('#claim-list-search-namelistclaim').val();
	var claimtype = $('#claim-list-search-typelistclaim').val();
	var claimstatus = $('#claim-list-search-statuslistclaim').val();
	var year  = $('#claim-list-search-yearlistclaim').val();
	var month = $('#claim-list-search-monthlistclaim').val();
	var position = $('#claim-list-search-divisionlistclaim').val();
	var group = $('#claim-list-search-grouplistclaim').val();
	var division = $('#claim-list-search-divisionlistclaim').val();
	if(position == ""){
		var position = $('#claim-list-search-grouplistclaim').val();
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
	if(group != ''){
		url += "group="+group+"&";
	}
	if(division != ''){
		url += "division="+division+"&";
	}

	return url;
}

function doSearchClaimList(elm)
{
	var url="c_oas022/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

function doDownload(elm)
{
	var url="c_oas022/download?"+get_filter_param();
	window.location.href = host+url;
}

$(function() { 
	$('#claim-list-search-grouplistclaim').change(function(){
        
        $("#claim-list-search-divisionlistclaim > option").remove();
        $(".wait").removeClass('hide');
        $("#claim-list-search-divisionlistclaim").addClass('hide');
        var sub_unsur_id = $('#claim-list-search-grouplistclaim').val();
        $.ajax({
            type: "POST",
            url: "c_oas022/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#claim-list-search-divisionlistclaim').append(opt);
                });
                $(".wait").addClass('hide');
                $("#claim-list-search-divisionlistclaim").removeClass('hide');
            }

        });
        
    });
});
</script>