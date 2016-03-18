<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS008
* Program Name     : Leave Type List
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 22-08-2014 23:50:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04-nov-2014	   Metta Kharisma H		  Merubah view jadi b.inggris
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>


<div class="box-content no-padding">
	<div class="search-fields bs-callout list-title">
		<h2><b>List Type Leave Employee</b></h2>
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
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="form_dialog('ADD NEW LEAVE TYPE', 'c_oas019/load_form')">
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
					<th class="hide">No</th>
					<th height="5px">No</th>
					<th>Leave Name</th>
					<th>Description Leave</th>
					<th width="75" class="text-center">Status</th>
					<th width="50" class="text-center">.:::.</th>

				</tr>
			</thead>
				<tbody>
					<?php $idx = 0;
						if(isset($type_list)){
						foreach($type_list as $item) { 
							$idx++;
					?>
						<tr>
							<td class="hide"></td>
							<td><?php echo $idx; ?></td>
							<td><?php echo $item['LEAVE_TYPE_NAME']; ?></td>						
							<td><?php echo $item['LEAVE_TYPE_DESCRIPTION']; ?></td>
							<td><?php echo $item['STATUS']; ?></td>
							<td class="text-center">
								<a href="#" class="opt edit" title="Edit" onclick="form_dialog('EDIT LEAVE TYPE', 'c_oas019/load_edit_form/<?php echo $item["LEAVE_TYPE_ID"]; ?>')"></a>
							</td>
						</tr>
					<?php }
					}else{ ?>
					<tr>
						<td class="text-center" colspan="6">DATA TIDAK DITEMUKAN!</td>
					</tr>
					<?php } ?>
				</tbody>
		</table>
</div>