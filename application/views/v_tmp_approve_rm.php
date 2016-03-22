<script src="<?php echo js_url();?>jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript">
function send_timesheet(url,employee,periode){
    var url_link=url;
    var employee_id=employee;
    var periode_date=periode;
    	 $.ajax({
             url:url_link,
             type:'POST',
             dataType:'json',
             data:{
                 employeeid:employee_id,
                 periode_dates:periode_date
             },
             beforeSend: function(){
					$('.before_process').css('display','none');
					$('.wait').css('display','block');
				},
             success:function(data){
                 var trHTML = '';
                 if(data.email_status===0){
						$('#email_success').css('display','none');
						$('#email_failed').css('display','block');
						var totals=0;
	                 	 $('#table_timesheet tbody tr').remove(); 
	                         $.each(data.data_sheet, function (i, item) {
	                         	var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
	                         	var count_status_zero=item.status==0?1:0;
	           trHTML +='<tr><td class="text-center">'+item.date_ts
	                   +'</td><td class="text-center">'+item.holiday 
	                   +'</td><td class="text-center">'+item.work_desc 
	                   +'</td><td class="text-center">'+item.hours 
	                   +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
	                   +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
	                   +'</a></td><td class="text-center">'+item_status+'</td></tr>';
	           totals +=count_status_zero;
	                     });
	                     $('#table_timesheet tbody').append(trHTML);
	                     $("#validasi-form").css({'display':'none'});
	                     $('[data-toggle="tooltip"]').tooltip();
	                     if(totals<=0){
								$('#send').css("display","none");
	                         }else{
	                         	$('#send').css("display","block");
	                             }
                     }else{
                     	$('#email_success').css('display','block');
							$('#email_failed').css('display','none');
							var totals=0;
		                 	 $('#table_timesheet tbody tr').remove(); 
		                         $.each(data.data_sheet, function (i, item) {
		                         	var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
		                         	var count_status_zero=item.status==0?1:0;
		           trHTML +='<tr><td class="text-center">'+item.date_ts
		                   +'</td><td class="text-center">'+item.holiday 
		                   +'</td><td class="text-center">'+item.work_desc 
		                   +'</td><td class="text-center">'+item.hours 
		                   +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
		                   +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
		                   +'</a></td><td class="text-center">'+item_status+'</td></tr>';
		           totals +=count_status_zero;
		                     });
		                     $('#table_timesheet tbody').append(trHTML);
		                     $("#validasi-form").css({'display':'none'});
		                     $('[data-toggle="tooltip"]').tooltip();
		                     if(totals<=0){
									$('#send').css("display","none");
		                         }else{
		                         	$('#send').css("display","block");
		                             }
                         }
                 form_dialog_close();
                    },
               error: function(xhr, resp, text) {
               console.log(xhr, resp, text);
                     }
         });
        
    
}
</script>
<div class="before_process" style="display:block;">Are you sure to send you'r <strong>ALL TIMESHEET</strong> on periode <strong><?php echo $periode;?></strong>?</div>
<input type="submit" value="Send For Approval" style="display: block;" class="pull-right btn btn-primary before_process" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_rm','<?php echo $employee_id; ?>','<?php echo $periode; ?>')">
<div class="wait"  style="display: none;">Wait....</div>
