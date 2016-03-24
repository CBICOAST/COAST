<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : RSC_TIMESHEET
* Program Name     : List Timesheet
* Description      : Halaman Pengisian Timeshet
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

 <!-- Latest compiled and minified CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->

        <!-- Optional theme -->
        <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous"> -->
<!-- Latest compiled and minified JavaScript -->
        <!-- <link rel="stylesheet" href="http://localhost/COAST2/assets/css/select2/select2.css"> -->
       
        <link rel="stylesheet" href="<?php echo js_url(); ?>plugins/datepicker/datepicker3.css">
        <script type="text/javascript">
        function send_timesheet(url,title,employee,periode,approve){
            var url_link=url;
            var employee_id=employee;
            var periode_date=periode;
            if(dialog === null)
                {
                    dialog = $.Zebra_Dialog('Are you sure to send you\'r <strong>ALL TIMESHEET</strong> on periode <strong>'+periode_date+'</strong>?', {
                                    'type': 'question',
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    title,
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
                    employeeid:employee_id,
                    periode_dates:periode_date,
                    approved_by:approve
                    
                },
                beforeSend: function() {
                    $('.wait').css('display','block');
                },
                success:function(data){
                	$('.wait').css('display','none');
                    var trHTML = '';
                    if(data.email_status<=0){
                        $('#email_failed').css('display','block');
                        $('#email_success').css('display','none');
                        }
                    else{
                    	$('#email_failed').css('display','none');
                        $('#email_success').css('display','block');
                        }
                    	 var total=0;
                    	 $('#table_timesheet tbody tr').remove(); 
                            $.each(data.data_sheet, function (i, item) {
                            	var item_status=item.status==1?'Need Approve':'Already Send';
                            	var count_status_zero=item.status==1?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero;
                        });
                        $('#table_timesheet tbody').append(trHTML);
                        $("#validasi-form").css({'display':'none'});
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
        					$('#send').css("display","none");
                            }else{
                            	$('#send').css("display","block");
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
        $(document).ready(function (){
            $.ajax({
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/load_data_rm/',
                    type:'POST',
                    dataType:'json',
                    data:{
                        periode:'<?php echo $periode; ?>',
                        employeeid:'<?php echo $employee_id; ?>',
                        approvedby:'<?php echo $approved_by;?>'
                        },
                    success:function(data){
                    var trHTML = '';
                        if(data ===0){
                            $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                            $('#send').css("display","none");
                        }
                        else{
                            var total=0;
                            $.each(data, function (i, item) {
                            	var item_status=item.status==1?'Need Approve':'Already Send';
                            	var count_status_zero=item.status==1?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero
                        });
                        $('#table_timesheet tbody').append(trHTML);
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
							$('#send').css("display","none");
							$('#send-back').css("display","none");
                            }else{
                            	$('#send').css("display","block");
                            	$('#send-back').css("display","block");
                                }
                        }
                        },
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
                });
        });
        
        </script>
        <div class="box-content no-padding">
    <div class="search-fields bs-callout list-title">
		<h2><b>Check Timesheet</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
                                        padding-bottom: 0px;">
                    
                </div>
    </div>
    
</div>
		<div class="text-center" id="validasi-form" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Data Can't be Saved (the required data is not complete)</div>
		<div class="text-center" id="email_failed" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Email Failed to send for approval</div>
		<div class="text-center" id="email_success" style="background-color: #dff0d8;border: 1px solid #ccc;color:#3c763d ;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Email Notification Already Send to approval</div>
        <div class="wait text-center" style="display:none;background-color: #fcf8e3;color: #8a6d3b;border: 1px solid #ccc;padding: 6px 6px 6px 6px;">Wait...</div>
        <div>
        
        </div>
        
<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="table_timesheet">
                    
                <thead>
			<tr>
				
                                <th class="text-center">Date</th>
                                <th class="text-center">Holiday</th>
                                <th class="text-center">Work Description</th>
                                <th class="text-center">Hours</th>
                                <th class="text-center">Charge Description</th>
                                <th class="text-center">Activity</th>
                                <th class="text-center">Action</th>
                                
			</tr>
		</thead>
                
                <tbody>
                    
                </tbody>
                
                </table>
                
        
<button type="button" class="pull-left btn btn-warning" id="back-btn" onclick="change_page(this, 'c_resource_timesheet/approve_rm_emp/<?php echo $approved_by; ?>/<?php echo $periode; ?>')">Back...</button>
<input type="submit" value="Approve" id="send" style="display:none;" class="pull-right btn btn-primary" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_pmo','APPROVE ALL TIMESHEET','<?php echo $employee_id; ?>','<?php echo $periode; ?>','<?php echo $approved_by; ?>')"/>
<input type="submit" value="Send Back" id="send-back" style="display:none;" class="pull-right btn btn-warning" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_pmo','APPROVE ALL TIMESHEET','<?php echo $employee_id; ?>','<?php echo $periode; ?>')"/>

        
