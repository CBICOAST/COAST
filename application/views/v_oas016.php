<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS016
* Program Name     : Master Tanggal Libur
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 26-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04-nov-2014	   Metta Kharisma H		  Merubah view jadi b.inggris
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
						echo "Holiday List";
					}else{
						echo "Setting Holiday Date";
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
						Year :
					</td>
					<td>
						<!-- <input type="text" id="holiday-list-search-year" value="<?php if($search) echo $search_param['year'] ?>" class="form-control search" maxlength="15" style="text-align: left; width: 150px"> -->
						<select id="holiday-list-search-year">
							<option value="">-- ALL --</option>
							<?php foreach ($year_list as $key => $year) { ?>
								<option value="<?= $year['id'] ?>"
									<?php if($search && $search_param['year'] == $year['id']) echo "selected"; ?>><?= $year['name'] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<!-- Keterangan Libur : -->
						&nbsp;
					</td>
					<td>
						<!-- <input type="text" class="form-control search" maxlength="15" style="text-align: left; width: 150px"> -->
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<!-- Jenis Libur : -->
						&nbsp;
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas016/<?php if (isset($readonly))echo'load_view_read_only'; else echo'load_view'?>');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearchHolidayList(this);">Search</button>
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
						<?php if (!isset($readonly)) {?>
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="form_dialog('ADD NEW HOLIDAY DATE', 'c_oas017/load_form')">
							<i class="fa fa-plus"></i>
							Add New
						</button>
						<?php } ?> 
						&nbsp;
					</td>
				</tr>
			</table>
		</div>
	</div>
	
		<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
			<colgroup>
				<col width="2%">
				<col width="20%">
				<col width="72%">
				<?php if (!isset($readonly)){ ?>
				<col width="6%">
				<?php } ?>
			</colgroup>
			<thead>
				<tr>
					<th class="hide">No</th>
					<th height="5px">No</th>
					<th>Date</th>
					<th>Remark Holiday Date</th>
					<?php if (!isset($readonly)){ ?>
					<th width="50" class="text-center">.:::.</th>
					<?php } ?>

				</tr>
			</thead>
				<tbody>
					<?php if(isset($type_list)){
						$idx = 0;
						foreach($type_list as $item) { 
							$idx++;?>
						<tr>
							<td class="hide"></td>
							<td><?php echo $idx; ?></td>
							<td><?php echo date('F d, Y',strtotime($item['TANGGAL'])); ?></td>						
							<td><?php echo $item['KETERANGAN']; ?></td>
							<?php if (!isset($readonly)) { ?>
							<td class="text-center">
								<a href="#" rel="detail" class="opt edit" title="Edit" onclick="form_dialog('EDIT HOLIDAY DATE', 'c_oas017/load_form_edit/<?= $item['ID']; ?>')">
								<!-- <a href="#" rel="detail" class="opt delete" title="Delete" onclick="open_detail(this, 'Leave', 'c_oas014/load_form')"> -->
							</td>
							<?php } ?>
						</tr>
					<?php }
						}else{	?>
						<tr>
							<td class="text-center" colspan="6">DATA NOT FOUND!</td>
						</tr>
					<?php } ?>
				</tbody>
		</table>
			
</div>
<script type="text/javascript">
function doSearchHolidayList(elm)
{

	var year  = $('#holiday-list-search-year').val();
	

	var url="c_oas016/search?";
	<?php if (isset($readonly)){ ?>
		url="c_oas016/search_readonly?";
	<?php } ?>

	if(year != ''){
		url += "year="+year+"&";
	}
	search_redirect(elm, encodeURI(host+url));
	// alert(encodeURI(host+url));
}

</script>