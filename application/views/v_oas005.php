<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS005
* Program Name     : Daftar User & Karyawan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili & Metta Kharisma H
* Version          : 01.00.00
* Creation Date    : 24-08-2014 15:46:00 & 16-10-2014 10:52:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 1.0				 04 Nov 2014	   Metta Kharisma H		 Memfungsikan button download
* 2.0				 04 Nov 2014	   Metta Kharisma H		 Menambah Function Get filter param
* 3.0				 04 Nov 2014	   Metta Kharisma H		 Menambah Function doDownload
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
						echo "Employee List";
					}else{
						echo "Employee Management";
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
						Employee Name :
					</td>
					<td>
						<select id="employee-list-search-name">
							<option value=''>-- ALL --</option>
							<?php foreach ($employee_list as $key => $employee) {?>
								<option value='<?= $employee['EMPLOYEE_ID'] ?>'
									<?php if($search && $search_param['employeeid']==$employee['EMPLOYEE_ID'])echo 'selected' ?>><?= $employee['EMPLOYEE_NAME'] ?></option>
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
						<select id="employee-list-search-status">
							<option value="-1"
						<?php if($search && $search_param['statusid']=='-1') echo 'selected';?>>-- All --</option>
                       
                        <option value="1"
                        	<?php if($search && $search_param['statusid']=='1') echo 'selected';?>> Active 
                        </option>
                     
                        <option value="0"
                        	<?php if($search && $search_param['statusid']=='0') echo 'selected';?>> Not Active
                        </option>
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
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td colspan="2">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas005/<?php if (isset($readonly))echo'load_view_read_only'; else echo'load_view'?>');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearchEmployeeList(this);">Search</button>
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
					<?	if(isset($user_list)){?>
							<td colspan="2">
								<!-- Button download belum diselesaikan, harap segera diselesaikan fungsinya! -->
								<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="doDownloadEmployee(this);">
									<i class="fa fa-download"></i>
									.xls
								</button>
							<?}?>
						<button type="button" class="pull-right btn btn-default btn-slim" id="xls-down-btn" onclick="form_dialog('ADD NEW USER', 'c_oas006/load_view')">
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
					<col width="100px">
					<col width="180px">
					<col width="200px">
					<col width="170px">
					<col width="100px">
					<col width="60px">
					
					<col width="10px">
					
				</colgroup>
		<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Employee Id</th>
				<th class="text-center">Employee Name</th>
				<th class="text-center">Email</th>
				<th class="text-center">Employee Status</th>
				<?php if (!isset($readonly)) { ?>
				<th class="text-center">User Type</th>
				<?php } ?>
				<th class="text-center"> Status</th>
				
				<th class="text-center">.::.</th>
				
			</tr>
		</thead>
		
		<tbody style="height: 10px; overflow: scroll;">
				<?php $idx = 0; 
				if(isset($user_list)){
				foreach ($user_list as $key => $user) { 
					$idx++;?>
				<tr class="active">
					
					<td class="text-center"><?= $idx ?></td>
					<td class="postit form-number pk text-center" val="<?= $user['EMPLOYEE_ID'] ?>"><?= $user['EMPLOYEE_ID'] ?></td>
					<td><?= $user['EMPLOYEE_NAME'] ?></td>
					<td><?= $user['USER_EMAIL'] ?></td>
					<td><?= $user['STATUSEMP'] ?></td>
					<?php if (!isset($readonly)) { ?>
					<td class="text-center"><?= $user['USER_GROUP_NAME'] ?></td>
					<?php } ?>
					<td class="text-center"><?= $user['STATUS'] ?></td>
					
					<td class="text-center">
						<?php if (!isset($readonly)) { ?>
						<a href="#" rel="detail" class="opt edit" title="Edit" onclick="form_dialog('EDIT EMPLOYEE', 'c_oas006/load_edit/<?= $user['EMPLOYEE_ID'] ?>')"></a>
						<?php }else{ ?>
						<a href="#" rel="detail" class="opt detail" title="Datail" onclick="form_dialog('EMPLOYEE INFO', 'c_oas006/load_read_only/<?= $user['EMPLOYEE_ID'] ?>')"></a>
						<?php } ?>
					</td>
					
				</tr>
				<?php }
				}else{ ?>
					<tr>
						<td class="text-center" colspan="6">Data Not Found!</td>
					</tr>
				<?php } ?>
			
		</tbody>
		</div>
	</table>
</div>

<script type="text/javascript">
function get_filter_param()
{
	var url = '';
	var employeeid  = $('#employee-list-search-name').val();
	var statusid  = $('#employee-list-search-status').val();
	
	if(employeeid != ''){
			url += "employeeid="+employeeid+"&";
		}
		
	if(statusid != ''){
			url += "statusid="+statusid+"&";
		}
		
	// if(position != ''){
	// 	url += "position="+position;
	// }

	return url;
}

	function doSearchEmployeeList(elm)
	{
		
		var url="c_oas005/search?"+get_filter_param();
		<?php if (isset($readonly)){ ?>
			url="c_oas005/search_readonly?"+get_filter_param();
		<?php } ?>
	search_redirect(elm, encodeURI(host+url));
	}
	
	function doDownloadEmployee(elm)
{
	var url="c_oas005/download?"+get_filter_param();
	window.location.href = host+url;
}
</script>