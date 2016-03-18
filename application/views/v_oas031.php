<?php 

/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS031
* Program Name     : List Document
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Ok :)
* Version          : 01.00.00
* Creation Date    : 14-9-2015 23:50:00 ICT 2014
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
		<h2><b>Document List  </b></h2>
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
						Document Name :
					</td>
					<td>
						
						<select id="doc_name">
							<option value=''>-- ALL --</option>
							<?php foreach ($doc_list as $key => $doc) {?>
								<option value='<?= $doc['id'] ?>'
									<?php if($search && $search_param['nama']==$doc['id'])echo 'selected' ?>><?= $doc['nama'] ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Year :
					</td>
					<td>
						<select id="document-list-search-year">
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
										<td colspan="3">
						
					</td>
					</tr>
					<tr>
					<td colspan="8">
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas031/load_view');">Refresh</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn"  onclick="doSearchDocument(this);">Search</button>
							</td>
				</tr>
				<tr height="5px">
					<td colspan="8">
						<?php if( $detail_admin['id']==$this_id){?>			
						<a href="#" onclick="form_dialog('New Document', 'c_oas110/load_view')">+ New Document</a><?}?>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				
				</tr>
			</table>
		</div>
		</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="30%">
			<col width="30%">
			<col width="50%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>Document Name</th>
				<th>Uploaded By</th>
				<th> Description </th>
				<th width="50" class="text-center">..:::..</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			if(isset($submission_list)){
			foreach ($submission_list as $key => $value) { 
				$no++;?>
				<tr>
					<td><?= $no ?></td>
					
					<td><?= $value['nama'] ?></td>
					<td><?= $value['oleh'] ?></td>
					<td><?= $value['deskripsi'] ?></td>
					
					<td><a style="font-size:150%"href="<?=$value['docloc'];?>">Download</a><?php if( $detail_admin['id']==$this_id){?>
					<a href="#"style="color:red;font-size:150%"onclick="beforeDelete(<?=$value['id']?>)">Delete </a> <?php }?>
						
						
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
				
				
			</tr>
			<tr>
				<td colspan="9" align="center">PAGINATION</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	var item_id = null;
	function beforeDelete(id){
		 item_id =  id;
		 confirmation_dialog('', 'Are you sure want to delete this item?', 'question', doDelete, this);
	};
	
	function doDelete(id)
	{
		var form_data = {
			item_id         : id
		};
		
		
		$.ajax({
			url: "c_oas031/delete_doc",
			data: {"item_id":item_id},
			cache: false,
			success: function(data) {
				alert("Delete Success, Please Click Refresh Button");
			},
			error: function(){ 	
				alert("Failled");
            }
		});
	}

	
function get_filter_param()
{
	var url = '';
	var doc_id =  $('#doc_name').val();
	var year		=  $('#document-list-search-year').val();
	if(doc_id != ''){
		url += "doc_id="+doc_id+"&";
	}
	if(year != ''){
		url += "year="+year+"&";
	}
	return url;
}


function doSearchDocument(elm)
{
	var url="c_oas031/search?"+get_filter_param();
	search_redirect(elm, encodeURI(host+url));
}
	


</script>