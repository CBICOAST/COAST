<?php
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS026
* Program Name     : CHARGE CODE LIST
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 19-09-2014 11:09:00 ICT 2014
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
		<h2><b>
			<?php if (isset($readonly)) {
						echo "Charge Code List";
					}else{
						echo "Charge Code Management";
					}  ?>
		</b></h2>
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
						Charge Code Type :
					</td>
					<td>
						<select id="claim-list-search-chargecodetype" class="" style="max-width:150px;">
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
						<select id="claim-list-search-chargecode" class="" style="max-width:200px;">
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
					<td>
						<select id="cc-list-search-status" class="" style="max-width:150px;">
						<option value="">-- ALL --</option>
                        <?php foreach ($status as $key => $statuscc) { ?>
                        <option value="<?= $statuscc['id'] ?>"
                        	<?php if($search && $search_param['statuschargecode']==$statuscc['id']) echo 'selected';?>><?= $statuscc['val'] ?></option>
                        <?php } ?>
						
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
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
<tr>
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas026/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearchChargeCodeList(this);">Search</button>
					</td>
					</tr>
					<tr><td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td colspan="2">
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="form_dialog('ADD NEW CHARGE CODE', 'c_oas027/load_form')">
							<i class="fa fa-plus"></i>
							Add New
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
		<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
			<thead>
				<tr>
					<th height="5px">No</th>
					<th>Charge Code</th>
					<th>Descripsi Charge Code</th>
					<th>Type Project</th>
					<th width="75" class="text-center">Status</th>
					<th width="50" class="text-center">.:::.</th>
				</tr>
			</thead>
				<tbody>
			<?php $idx = 0;
			
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$idx++;?>
				<tr>
					<td><?= $idx ?></td>
					<td><?php echo $value['id']; ?></td>	
					<td><?php echo $value['deskripsi']; ?></td>	
					<td><?php echo $value['TYPE']; ?></td>	
					<td><?php if ($value['status'] == '1'){echo 'Enable';} else{echo 'Disable';} ?></td>
					<td class="text-center">
						<a href="#" class="opt edit" title="Edit" onclick="form_dialog('EDIT CHARGE CODE', 'c_oas027/load_edit_form/<?php echo $value["id"]; ?>')"></a>
					</td>
				</tr>
				<?php }
			}
			else{ ?>
				<tr>
					<td class="text-center" colspan="6">NOT FOUND!</td>
				</tr>
					<?php } ?>
				</tbody>
		</table>
</div>

<script type="text/javascript">

function get_filter_param()
{
	var url = '';
	var chargecodetype = $('#claim-list-search-chargecodetype').val();
	var chargecode = $('#claim-list-search-chargecode').val();
	var statuscc = $('#cc-list-search-status').val();
	
	if(chargecodetype != ''){
		url += "chargecodetype="+chargecodetype+"&";
	}
	if(chargecode != ''){
		url += "chargecode="+chargecode+"&";
	}
	if(statuscc != ''){
		url += "statuscc="+statuscc+"&";
	}

	return url;
}

function doSearchChargeCodeList(elm)
{
	var url="c_oas026/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}

function doDownload(elm)
{
	var url="c_oas026/download?"+get_filter_param();
	window.location.href = host+url;
}


$(function() { 
	$('#claim-list-search-chargecodetype').change(function(){        
        $("#claim-list-search-chargecode > option").remove();
        $(".wait").removeClass('hide');
        $("#claim-list-search-chargecode").addClass('hide');
        var sub_unsur_id = $('#claim-list-search-chargecodetype').val();
        $.ajax({
            type: "POST",
            url: "c_oas026/load_chargecode/"+sub_unsur_id,

            success: function(cities)
            {
                $.each(cities,function(id,city)
                {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(city);
                    $('#claim-list-search-chargecode').append(opt);
                });
                $(".wait").addClass('hide');
                $("#claim-list-search-chargecode").removeClass('hide');
            }

        });
        
    });
});
</script>