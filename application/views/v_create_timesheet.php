<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : RESOURCE_TIMESHEET
* Program Name     : List Timesheet
* Description      : Daftar Timesheet yang akan terisi oleh resource
* Environment      : PHP 5.4.4
* Author           : Abi Sa'ad Dimyati
* Version          : 01.00.00
* Creation Date    : 07-03-2016 11:10:00
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<script type="text/javascript">
function form_new_timesheet(title, url){

	if(dialog === null)
	                {
	                    var message = "";
	                    dialog = $.Zebra_Dialog(message, {
	                                    'type':     false,
	                                    'overlay_close': false,
	                                    'custom_class':  'form-dialog',
	                                    'title':    title,
	                                    'animation_speed_hide': 50,
	                                    'animation_speed_show': 1000,
	                                    'source':  {'ajax': url,
	                                                'cache': false},
	                                    'max_height': 550,
	                                    'overlay_opacity': '.75',
	                                    'buttons':  [
	                                    {caption: 'Save', callback: function() {
	                                    	if($(".date_ts").val().length !== 0 && $(".date_ts2").val().length !== 0){
	                                            
	            $.ajax({
	                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/generate_new_timesheet',
	                    type:'POST',
	                    dataType:'json',
	                    data:$("#new_timesheet").serialize(),
	                    success:function(data) {
	                $('#create_timesheet_periode tbody tr').remove(); 
	                    var trHTML = '';
	                    $.each(data, function (i, item) {
	                        var b=i+1;
	                        trHTML +='<tr><td class="text-center">'+b
	                        +'</td><td><b>'+item.char_period+'</b>'
	                        +'</td><td><b><code>'+item.expired_date+'</code></b>'
	                        +'</td><td class="text-center"><a class=\"btn btn-danger btn-xs\" onclick=\"delete_periode(\'c_resource_timesheet/delete_periode\',\''+item.date_period+'\')"><i class=\"fa fa-times\"></i>Delete</a></td></tr>';
	               
	                        });
	                        $('#create_timesheet_periode tbody').append(trHTML); 
	                        $("#validasi-form").css({'display':'none'});
	                            },
	                  error: function(xhr, resp, text) {
	                  console.log(xhr, resp, text);
	                        }
	                });                        
	            
	                                    	}else{
	                                    		$("#validasi-form").css({'display':'block'});
	                                    		}        
	                                    }},
	                                    {caption: 'Cancel', callback: function() { form_dialog_close();}}
	                ],
	                                    'width':1000,
	                                    'height':1000,
	                                    'onClose':  function() {
	                                                    form_dialog_close();
	                                                }
	                                });
	                }

	}

//fungsi untuk menghapus salah satu row timesheet
        function delete_periode(url,periode){
        var url_link=url;
        var periode_date=periode;
        if(dialog === null)
            {
                dialog = $.Zebra_Dialog('Are you sure to remove periode <strong>'+periode_date+'</strong>?', {
                                'type': 'question',
                                'overlay_close': false,
                                'custom_class':  'form-dialog',
                                'title':    'DELETE CONFIRMATION',
                                'animation_speed_hide': 50,
                                'animation_speed_show': 700,
                                'max_height': 550,
                                'overlay_opacity': '.75',
                                'buttons':  [
                                {caption: 'Yes', callback: function() {
                                        $.ajax({
            url:url_link,
            type:'POST',
            dataType:'json',
            data:{
                periode_dates:periode_date,
                employee_id:'<?php echo $employee_id; ?>'
            },
            success:function(data){
                var trHTML = '';
                if(data ===0){
                	$('#create_timesheet_periode tbody tr').remove(); 
                    $('#timesheet_periode tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                }
                else{
                	 var total=0;
                	 $('#create_timesheet_periode tbody tr').remove(); 
                        $.each(data, function (i, item) {
                        	var b=i+1;
          trHTML +='<tr><td class="text-center">'+b
                  +'</td><td><b>'+item.char_period+'</b>'
                  +'</td><td><b><code>'+item.expired_date+'</code></b>'
                  +'</td><td class="text-center"><a class=\"btn btn-danger btn-xs\" onclick=\"delete_periode(\'c_resource_timesheet/delete_periode\',\''+item.date_period+'\')"><i class=\"fa fa-times\"></i>Delete</a></td></tr>';
         
                    });
                    $('#create_timesheet_periode tbody').append(trHTML);
                    
                }
                   },
              error: function(xhr, resp, text) {
              console.log(xhr, resp, text);
                    }
        });
                                }},
                                {caption: 'No', callback: function() { form_dialog_close();}}],
                                'width':1000,
                                'height':1000,
                                'onClose':  function() {
                                                form_dialog_close();
                                            }
                            });
            }
        
    }
</script>
<div class="box-content no-padding">
    <div class="search-fields bs-callout list-title">
		<h2><b>Timeshet Periode List</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
                                        padding-bottom: 0px;">
                    
                </div>
               
    </div>
    <div class="text-center" id="validasi-form" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Data Can't be Saved (the required data is not complete)</div>
     <div>
        <button class="btn btn-primary"  onclick="form_new_timesheet('Create New Timesheet Periode','c_resource_timesheet/form_new_timesheet')"><i class="fa fa-plus-square-o fa-lg"></i> Add Timesheet</button>
        </div>
    <table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="create_timesheet_periode">
                  <colgroup>
					<col width="20px">
					<col width="300px">
					<col width="20px">
					<col width="50px">
				</colgroup>  
                <thead>
			<tr>
                            <th width="5" class="text-center">No</th>
				<th class="text-center">Timesheet Periode</th>
				<th class="text-center">Expired Date</th>
                                <th width="50" class="text-center">.:::.</th>
			</tr>
		</thead>
                <tbody>
                    <?php
                    $idx=0;
                    foreach ($periode as $key => $value) {
                        $idx++;
                        echo "<tr class='Approved'>";
                        echo "<td class='text-center'>".$idx."</td>";
                        echo "<td ><b>".$value['char_period']."</b></td>";
                        echo "<td><code>".$value['expired_date']."</code></td>";
                        echo "<td class=\"text-center\"><a class='btn btn-danger btn-xs' onclick=\"delete_periode('c_resource_timesheet/delete_periode','".$value['date_period']."')\"><i class='fa fa-times'></i>Delete</a></td>";
                        echo "</tr>";
     }
                    
                    ?>
                </tbody>
                </table>
    
</div>