<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS108
* Program Name     : List Approval
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 01-04-2015 09:33:00 ICT 2015
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
		
		<h2>
			<b><?php echo "Data Approval"; ?></b>
		
		<td colspan="2">
		<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim"  onclick="change_page(this, 'c_oas108/<?php  echo'load_view'?>');">Clear</button>
		</td>
		</h2>
	</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th class="text-center" rowspan="2">No</th>
				<th  class="text-center" rowspan="2">Employee ID </th>
				<th  class="text-center" rowspan="2">Employee Name </th>
				<th class="text-center"  rowspan="2">Approval For</th>
				<th class="text-center" rowspan="2">.::.</th>				
			</tr>		
		</thead>
		
		<tbody style="height: 10px; overflow: scroll;">
				<?php $idx = 0; 
				if(isset($approval_list)){
				foreach ($approval_list as $key => $apr) { 
					$idx++;?>
				<tr class="active">					
					<td class="text-center"><?= $idx ?></td>
					<td><?= $apr['nik'] ?></td>	
					<td><?= $apr['nama'] ?></td>	
					<td><?= $apr['value'] ?></td>	
					<td class="text-center">						
						<a href="#" rel="detail" class="opt edit" title="Edit" onclick="form_dialog('Setting Approval', 'c_oas030/load_view/<?= $apr['untuk']?>')"></a>
					</td>
				</tr>
				<?php }
				}else{ ?>
					<tr>
						<td class="text-center" colspan="6">Not Found!</td>
					</tr>
				<?php } ?>			
		</tbody>
	</table>
</div>
<div>
</div>