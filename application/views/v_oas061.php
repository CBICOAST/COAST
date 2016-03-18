<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS061
* Program Name     : Paid Business Travel 
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
		<h2><b>List Business Travel</b></h2>
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
						<input type="text" id="search-employeeid_paidBT"maxlength="15" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['employeeid']; ?>" placeholder="<?php if($search) echo $search_param['employeename']; ?>">
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Group :
					</td>
					<td>
						<select id="search-grup_paidBT" class="" style="max-width:150px;">
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
						<input type="text" id="search-year_paidBT"  maxlength="100" style="text-align: left; width: 150px" value="<?php if($search) echo $search_param['year']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						Name :
					</td>
					<td>
						<select id="search-name_paidBT">
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
						<select id="search-division_paidBT" class="" style="max-width:150px;">
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
						<select id="search-month_paidBT" class="" style="max-width:150px;">
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
						Destination :
					</td>
					<td>
						<select id="search-destination_paidBT" class="" style="max-width:150px;">
						<option value="">-- All --</option>
                        <?php foreach ($list_destination as $key => $type) { ?>
                        <option value="<?= $type['id'] ?>"
                        	<?php if($search && $search_param['PBTdestination']==$type['id']) echo 'selected';?>><?= $type['name'] ?></option>
                        <?php } ?>
                        </select>
					</td>
					
					<td>
						&nbsp;
					</td>
					<td>
						<!-- Bulansa : -->
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas061/load_view');">Clear</button>
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
					<td colspan="2">
						
					</td>
				</tr>
			</table>
		</div>
	</div>
	<form action="/c_oas061/paid_selected" method="post" accept-charset="utf-8">
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
				<th>Client/Location/Purpose</th>
				<th>Submitted Date</th>
				<th>Charge Code</th>
				<th>Destination</th>
				<th>Amount</th>
				<th class="text-center"><button type="submit" class=" btn btn-primary btn-slim" id="paid-selected " >Paid Selected</button><br><input type='checkbox' name='select-all' id='select-all' /></th>
				

			</tr>
		</thead>
		<tbody>
	
			<?php 
			
			$idx = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$idx++;?>
				<tr>
					<td><?= $idx ?></td>
					<td class="postit form-number pk" val="<?= $value['bt_id'] ?>"><a href="#" title="Datail" onclick="change_page(this, 'c_oas062/load_form/<?= $value['bt_id'] ?>')"><?= $value['no_ref'] ?><code><?= $value['status'] ?></code></a></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?echo $value['client_name'].'/'.$value['customer_location'].'/'.$value['purpose']; ?></td>
					<td><?= $value['submitted_dt'] ?></td>
					<td title="<?= $value['cc_name'] ?>"><?= $value['chargecode'] ?></td>
					
					<td align="right"><?= $value['destination_name']?></td>
					<td align="right"><?= $value['total']?></td>
					
					<td align="center">
					<?php if($value['stat']==3){?> 
					<input type="checkbox" class="chk" name="checkbox<?php echo $idx?>"  value="<?= $value['bt_id'] ?>"/></td>	
					<? }else{?>
					
					-
					<?}?>
					<input type="text" hidden name="PBT-emp-id<?php echo $idx?>"  value="<?= $value['employee_id'] ?>"/>
					<input type="text" hidden name="PBT-no-ref<?php echo $idx?>"  value="<?= $value['no_ref'] ?>"/>
				<input type="hidden" value="<?php echo $idx?>" name="loop">
		
					 
				</tr>
				
			<?php }
			
			 }
			
			 else{
			?>
			<tr>
				<td class="text-center" colspan="9">Not Found!</td>
			</tr>
			<?php } ?>
			<tr>
				<td>
					</td>
					
			</tr>
			<tr>
				<td colspan="9" align="center">PAGINATION</td>
			</tr>
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
	var employeeid = $('#search-employeeid_paidBT').val();
	var employeename = $('#search-name_paidBT').val();
	var PBTdestination = $('#search-destination_paidBT').val();
	
	var year  = $('#search-year_paidBT').val();
	var month = $('#search-month_paidBT').val();
	var position = $('#search-division_paidBT').val();
	var group = $('#search-grup_paidBT').val();
	var division = $('#search-division_paidBT').val();
	if(selected != ''){
		url += "che="+employeeid+"&";
	}
	
	if(position == ""){
		var position = $('#search-grup_paidBT').val();
	}

	if(employeeid != ''){
		url += "employeeid="+employeeid+"&";
	}
	if(employeename != ''){
		url += "employeename="+employeename+"&";
	}
	if(PBTdestination != ''){
		url += "PBTdestination="+PBTdestination+"&";
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

	return url;
}


function doSearch_paid(elm)
{
	var url="c_oas061/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

function doDownload_paid(elm)
{
	var url="c_oas061/download?"+get_filter_param();
	window.location.href = host+url;
	// search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

$(function() { 
	$('#search-grup_paidBT').change(function(){
        
        $("#search-division_paidBT > option").remove();
        $(".wait").removeClass('hide');
        $("#search-division_paidBT").addClass('hide');
        var sub_unsur_id = $('#search-grup_paidBT').val();
        $.ajax({
            type: "POST",
            url: "c_oas061/load_division/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#search-division_paidBT').append(opt);
                });
                $(".wait").addClass('hide');
                $("#search-division_paidBT").removeClass('hide');
            }

        });
        
    });
});


function toggleChecked(status) {
  $(".checkbox").each( function() {
  	$(this).attr("checked",status);
  })
}




$('#select-all').click(function(event) {   
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