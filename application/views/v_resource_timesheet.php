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
                	$('#timesheet_periode tbody tr').remove(); 
                    $('#timesheet_periode tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                }
                else{
                	 var total=0;
                	 $('#timesheet_periode tbody tr').remove(); 
                        $.each(data, function (i, item) {
                        	var b=i+1;
          trHTML +='<tr><td class="text-center">'+b
                  +'</td><td><a href=\"#\" title=\"Detail\"  onclick=\"change_page(this, \'c_resource_timesheet/load_timesheet_periode/'+item.date_period+'/'+item.employee_id+'\')"><b>'+item.char_period+'</b>'
                  +'</a></td><td class="text-center"><a class=\"btn btn-danger btn-xs\" onclick=\"delete_periode(\'c_resource_timesheet/delete_periode\',\''+item.date_period+'\')"><i class=\"fa fa-times\"></i>Delete</a></td></tr>';
         
                    });
                    $('#timesheet_periode tbody').append(trHTML);
                    
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
		<h2><b>Timeshet List</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
                                        padding-bottom: 0px;">
                    
                </div>
               
    </div>
    <div class="text-center" id="validasi-form" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Data Can't be Saved (the required data is not complete)</div>
     <div>
        
        </div>
    <table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="timesheet_periode">
                    
                <thead>
			<tr>
                            <th width="5" class="text-center">No</th>
				<th class="text-center">Timesheet Periode</th>
                                
			</tr>
		</thead>
                <tbody>
                    <?php
                    $idx=0;
                    foreach ($periode as $key => $value) {
                        $idx++;
                        echo "<tr class='Approved'>";
                        echo "<td class='text-center'>".$idx."</td>";
                        echo "<td ><a href=\"#\" title=\"Detail\" onclick=\"change_page(this, 'c_resource_timesheet/load_timesheet_periode/".$value['date_period']."/".$employee_id."/resource')\"><b>".$value['char_period']."</b></a></td>";
                       
                        echo "</tr>";
     }
                    
                    ?>
                </tbody>
                </table>
    
</div>