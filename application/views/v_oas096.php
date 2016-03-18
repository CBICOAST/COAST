<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS096
* Program Name     : Daftar Setting Limit Nominal Notif to Director
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 16-03-2015 19:00:00 ICT 2014
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
			<?php if (isset($readonly)) {
						echo "Setting Nominal to Director List";
					}else{
						echo "Setting Nominal to Director Management";
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
						Currency :
					</td>
					<td>
						<select id="currency-list-search-name-pr">
							<option value=''>-- All --</option>
							<?php foreach ($currency_list as $key => $currency) {?>
								<option value='<?= $currency['cc'] ?>'
									<?php if($search && $search_param['currencyid']==$currency['cc'])echo 'selected' ?>><?= $currency['val'] ?></option>
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
						<button type="submit" class="pull-right btn btn-danger btn-flat btn-slim" id="clear-btn" onclick="change_page(this, 'c_oas096/<?php if (isset($readonly))echo'load_view_read_only'; else echo'load_view'?>');">Clear</button>
						<button type="button" class="pull-right btn btn-success btn-flat btn-slim" id="search-btn" onclick="doSearchCurrencyListPR(this);">Search</button>
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
						
					</td>
					<?php } ?>
				</tr>
			</table>
		</div>
	</div>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" data-toggle="table" data-height="10">
		<colgroup>
					<col width="5px">
					<col width="50px">
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
				<th class="text-center">Currency</th>
				<th class="text-center">Nominal</th>
				
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
					<td class="postit form-number pk text-center" val="<?= $user['val'] ?>"><?= $user['val'] ?></td>
					
					<td><?= number_format( $user['nominal'],0,',','.');  ?></td>
					
					<td class="text-center">
						<?php if (!isset($readonly)) { ?>
						<a href="#" rel="detail" class="opt edit" title="Edit" onclick="form_dialog('EDIT SETTING LIMIT TO DIRECTOR', 'c_oas097/load_edit_form/<?php echo $user["ccid"]; ?>')"></a>
						<?php }else{ ?>
						<a href="#" rel="detail" class="opt detail" title="Datail" onclick="form_dialog('SETTING LIMIT TO DIRECTOR INFO', 'c_oas097/load_read_only/<?= $user['ccid'] ?>')"></a>
						<?php } ?>
					</td>
					
				</tr>
				<?php }
				}else{ ?>
					<tr>
						<td class="text-center" colspan="6">DATA TIDAK DITEMUKAN!</td>
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
	function doSearchCurrencyListPR(elm)
	{
		
		var currencyid  = $('#currency-list-search-name-pr').val();
		

		var url="c_oas096/search?";
		<?php if (isset($readonly)){ ?>
			url="c_oas096/search_readonly?";
		<?php } ?>

		if(currencyid != ''){
			url += "currencyid="+currencyid+"&";
		}
		search_redirect(elm, encodeURI(host+url));
	}
</script>