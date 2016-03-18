<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS106
* Program Name     : Setting Vendor Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 23-02-215 10:40:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
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
			<?php echo "Setting Vendor";
					 ?>
		</b></h2>
		<div style="height:106%;
					
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
						Vendor:
					</td>
					<td>
						<select id="itemlist-list-searc-management">
							<option value=''>-- ALL --</option>
							<?php foreach ($item_list as $key => $cost) {?>
								<option value='<?= $cost['id'] ?>'
									<?php if($search && $search_param['destination']==$cost['id'])echo 'selected' ?>><?= $cost['destination'] ?></option>
							<?php } ?>
						</select>
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas106/load_view');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearchItem(this);">Search</button>
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
					<?php if (!isset($readonly)) { ?>
					<td colspan="2">
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="form_dialog('ADD NEW VENDOR', 'c_oas094/load_view')">
							<i class="fa fa-plus"></i>
							Add New
						</button>
					</td>
					<?php } ?>
				</tr>
			</table>
		</div>
	</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" data-toggle="table" data-height="10">
		<colgroup>
					<col width="5px">
					<col width="250px">
					<col width="125px">
					<col width="125px">
					
				</colgroup>
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Description</th>
				<th class="text-center">Satuan</th>
				<th class="text-center">.::.</th>
				
			</tr>
		</thead>
		
		<tbody style="height: 10px; overflow: scroll;">
				<?php $idx = 0; 
				if(isset($cost_list)){
				foreach ($cost_list as $key => $list) { 
					$idx++;?>
				<tr class="active">
					
					<td class="text-center"><?= $idx ?></td>
					<td class="text-center"><?= $list['destination']; ?></td>
					<td class="text-center"><?= $list['satuan']; ?></td>
					
					<td class="text-center">
						<?php if (!isset($readonly)) { ?>
						<a href="#" rel="detail" class="opt delete" title="Delete Item" id ="delete-item" onclick="change_page(this, 'c_oas106/delete_item_pr/<?= $list['id'] ?>')"></a>
						<?php }?>
					</td>
					
				</tr>
				<?php }
				}else{ ?>
					<tr>
						<td class="text-center" colspan="4">DATA NOT FOUND!</td>
					</tr>
				<?php } ?>
			
		</tbody>
		</div>
	</table>
</div>
<div><br>
<div class="box-footer clearfix">
                <button type="button" class="pull-left btn btn-default" id="back-btn" onclick="change_page(this, 'c_oas098/load_view')">Back...</button>
            </div></div>

<script type="text/javascript">
	function doSearchItem(elm)
	{	
		var destination  = $('#itemlist-list-searc-management').val();
		var url="c_oas106/search?";
		if(destination != ''){
			url += "destination="+destination+"&";
		}
		search_redirect(elm, encodeURI(host+url));
	}
</script>