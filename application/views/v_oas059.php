<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
*Program Id    	   : OAS059
* Program Name     : Daftar Sisa Cuti Tahunan
* Description      :
* Environment      : PHP 5.4.4
* Author           : Winni Oktaviani
* Version          : 01.00.00
* Creation Date    : 18-12-2014 13:14:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description* 
* 1					16/02/2015 		   Dwi Irawati			Edit Annual Leave
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ($status_edit == 0){

?>


<div class="box-content no-padding">
	<center>
		<h2><b>List Employee Annual Leave</b></h2>
		</center>
	<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
			<col width="2%">
			<col width="20%">
			<col width="25%">
			<col width="10%">
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th height="5px">No</th>
				<th>Employee ID</th>
				<th>Employee Name</th>
				<th>Limit Annual Leave</th>
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
					<td><?= $value['employee_id'] ?></td>
					<td><?= $value['employee_name'] ?></td>
					<td><?= $value['annual_leave'] ?></td>
					<td class="text-center">
					<a href="#" class="opt edit" title="Edit sisa cuti" onclick="change_page(this, 'c_oas059/load_edit/<?= $value['employee_id'] ?>')"></a>
					</td>
				</tr>
			<?php }
			 }else{
			?>
			<tr>
				<td class="text-center" colspan="4">NOT FOUND!</td>
			</tr>
			<?php } ?>
			
		</tbody>
	</table>
</div>
<?php } else { ?> 

<div class="row"> 
    <div class="col-md-7">

        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">Edit Employee Annual Leave</h3>
            </div>
            <div class="box-body">


    	<div class="requester-detail form-section-container">
    		<div class="form-group">
    			<label class="col-sm-4 control-label">Employee ID</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text" id="employee_id" readonly class="form-control holo" value="<?php echo $form_detail['employee_id']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->

    		<div class="form-group">
    			<label class="col-sm-4 control-label">Employee Name</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text"  id="employee_name" readonly class="form-control holo" value="<?php echo $form_detail['employee_name']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->
			
			<div class="form-group">
    			<label class="col-sm-4 control-label">Balance Leave Annual</label>
    			<div class="input-group">
    				<div class="input-group-addon">
    					<i class="fa fa-pencil"></i>
    				</div>
    				<input type="text"  id="annual_leave" maxlength="2" class="form-control holo" onkeyup="formatAngka(this, '.')" value="<?php echo $form_detail['annual_leave']; ?>">
    			</div><!-- /.input group -->
    		</div><!-- /.form group -->


    	</div><!-- /.form group -->
    
    <div class="box-footer clearfix">
    	<div class="pull-left" id="new-leave-msg"></div>
    	<button class="pull-right btn btn-primary" id="update_balance-leave" type="submit">Update</button>
		
		</div><!-- /.box-body -->
    </div>

</div><!-- /.box -->

<?php } ?>


<script type="text/javascript">
var url 		 = "<?php echo 'c_oas059/update_annualleave'; ?>";
var this_id = "<?= $form_detail['employee_id'] ?>";
var year = "<?= $form_detail['year'] ?>";

//function untuk validasi input angka
function formatAngka(objek, separator) {

  a = objek.value;
  b = a.replace(/[^\d]/g,"");
  c = "";
  panjang = b.length;
  j = 0;

  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (((j % 3) == 1) && (j != 1)) {
      c = b.substr(i-1,1) + separator + c;
    } else {
      c = b.substr(i-1,1) + c;
    }
  }
  objek.value = c;
}

 $(function() {
    
     $('#update_balance-leave').on('click', function(){
		var form_data = {
			BALANCE 	: $('#annual_leave').val(),
			YEAR		: year,
			EMPLOYEE_ID	: this_id,
			ajax		: 1
			
		   
		}; 
		var id = $( this ).closest( "div.tab-pane" ).attr("id");
                    console.log(form_data);
		  $.ajax({
                    url: url,
                    type: 'POST',
                    async : false,
                    data: form_data,
                    timeout: 10000, //1000ms
                        success: function(data) { 
                            $("#"+id ).html("<h4><code>Sukses updated</code></h4>" + data
                                +"");
                        },
                       error: function(){                      
                            $("#"+id ).html("Terjadi kesalahan dalam menghubungi server."
                                +"<br><button onclick='change_page(this, \"c_oas059/load_view\")'>Back</button>");
                      
                        }
                });
    });
 });
 </script> 