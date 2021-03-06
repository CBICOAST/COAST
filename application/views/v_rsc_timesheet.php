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
      //fungsi untuk merubah row pada timesheet
        function form_edit_timesheet(title, url){
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
                                               
                                               if($(".select_charge").chosen().val().length !== 0 && $(".select_act").chosen().val().length!==0 && $('textarea#work').val().length!==0 && $('#hours').val().length!==0 && $(".date_ts").val().length !== 0){
                                                   $.ajax({
                       url:'<?php echo base_url(); ?>'+'c_resource_timesheet/edit_timesheet',
                       type:'POST',
                       dataType:'json',
                       data:$("#form-edit-timesheet").serialize(),
                       success:function(data) {
                   $('#table_timesheet tbody tr').remove(); 
                       
                       var trHTML = '';
                       if(data ===0){
                           $('#table_timesheet tbody').append('<tr><td colspan="8" class="text-center">Data Not Found</td></tr>');
                           $("#validasi-form").css({'display':'none'});
                           $('#send').css("display","none");
                       }
                       else{
                       	 var total=0;
                       $.each(data, function (i, item) {
                       	var item_status=item.status==0?'<a class="btn btn-danger btn-xs" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"><i class="fa fa-times"></i>Delete</a>&nbsp;&nbsp; <a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"><i class="fa fa-edit">Edit</i></a>':'Already Send';
                       	var count_status_zero=item.status==0?1:0;
                 trHTML +='<tr><td class="text-center">'+item.date_ts
                         +'</td><td class="text-center">'+item.holiday 
                         +'</td><td class="text-center">'+item.work_desc 
                         +'</td><td class="text-center">'+item.hours
                         +'</td><td class="text-center">'+item.overtime 
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
                       }
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
		
      //fungsi untuk menambahkan row pada timesheet
        function form_save_timesheet(title, url){
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
                                                    if($(".select_charge").chosen().val().length !== 0 && $(".select_act").chosen().val().length!==0 && $('textarea#work').val().length!==0 && $('#hours').val().length!==0 && $(".date_ts").val().length !== 0){
                    $.ajax({
                            url:'<?php echo base_url(); ?>'+'c_resource_timesheet/upload_timesheet',
                            type:'POST',
                            dataType:'json',
                            data:$("#timesheet_form").serialize(),
                            success:function(data) {
                        $('#table_timesheet tbody tr').remove(); 
                            var trHTML = '';
                            if(data ===0){
                                $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                                $("#validasi-form").css({'display':'none'});
                                $('#send').css("display","none");
                            }
                            else{
                            	 var total=0;
                            $.each(data, function (i, item) {
                                var item_status=item.status==0?'<a class="btn btn-danger btn-xs" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"><i class="fa fa-times"></i>Delete</a>&nbsp;&nbsp; <a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"><i class="fa fa-edit">Edit</i></a>':'Already Send';
                                var count_status_zero=item.status==0?1:0;
                      trHTML +='<tr><td class="text-center">'+item.date_ts
                              +'</td><td class="text-center">'+item.holiday 
                              +'</td><td class="text-center">'+item.work_desc 
                              +'</td><td class="text-center">'+item.hours
                              +'</td><td class="text-center">'+item.overtime 
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
                            }
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
        function delete_timesheet(url,date,charge,employee,act,periode){
        var url_link=url;
        var date_ts=date;
        var charge_code=charge;
        var employee_id=employee;
        var act_code=act;
        var periode_date=periode;
        if(dialog === null)
            {
                dialog = $.Zebra_Dialog('Are you sure to remove your timesheet data on <strong>'+date_ts+'</strong> with Chargecode <strong>'+charge_code+'</strong>?', {
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
                date:date_ts,
                chargecode:charge_code,
                employeeid:employee_id,
                actcode:act_code,
                periode_dates:periode_date
            },
            success:function(data){
                var trHTML = '';
                if(data ===0){
                	$('#table_timesheet tbody tr').remove(); 
                    $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                    $("#validasi-form").css({'display':'none'});
                    $('#send').css("display","none");
                }
                else{
                	 var total=0;
                	 $('#table_timesheet tbody tr').remove(); 
                        $.each(data, function (i, item) {
                        	var item_status=item.status==0?'<a class="btn btn-danger btn-xs" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"><i class="fa fa-times"></i>Delete</a>&nbsp;&nbsp; <a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"><i class="fa fa-edit">Edit</i></a>':'Already Send';
                        	var count_status_zero=item.status==0?1:0;
          trHTML +='<tr><td class="text-center">'+item.date_ts
                  +'</td><td class="text-center">'+item.holiday 
                  +'</td><td class="text-center">'+item.work_desc 
                  +'</td><td class="text-center">'+item.hours
                  +'</td><td class="text-center">'+item.overtime 
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
        
        function send_timesheet(url,title,employee,periode){
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
                    periode_dates:periode_date
                },
                beforeSend: function() {
                    $('.wait').css('display','block');
                    $('#send').css('display','none');
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
                            	var item_status=item.status==0?'<a class="btn btn-danger btn-xs" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"><i class="fa fa-times"></i>Delete</a>&nbsp;&nbsp; <a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"><i class="fa fa-edit">Edit</i></a>':'Already Send';
                            	var count_status_zero=item.status==0?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours
                      +'</td><td class="text-center">'+item.overtime 
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
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/load_data/',
                    type:'POST',
                    dataType:'json',
                    data:{
                        periode:'<?php echo $periode; ?>',
                        employeeid:'<?php echo $employee_id; ?>'
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
                            	var item_status=item.status==0?'<a class="btn btn-danger btn-xs" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"><i class="fa fa-times"></i>Delete</a>&nbsp;&nbsp; <a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"><i class="fa fa-edit">Edit</i></a>':'Already Send';
                            	var count_status_zero=item.status==0?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours
                      +'</td><td class="text-center">'+item.overtime  
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero
                        });
                        $('#table_timesheet tbody').append(trHTML);
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
							$('#send').css("display","none");
                            }else{
                            	$('#send').css("display","block");
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
		<h2><b>Form Timesheet</b></h2>
		<?php $date = date_create($periode) ?>
		<table border="0">
		<colgroup>
					<col width="130px">
					<col width="30px">
					<col width="150px">
					
					
				</colgroup>
				<tbody>
		<tr>
		<td><b style="font-size: 15px;">Employee Name</b></td>
		<td>:</td>
		<td><b style="font-size: 15px;"><?php echo $employee_name[0]['EMPLOYEE_NAME']; ?></b></td>
		
		</tr>
		<tr>
		<td><b style="font-size: 15px;">Timesheet Periode</b></td>
		<td>:</td>
		<td><b style="font-size: 15px;"><?php echo date_format($date,'F Y'); ?></b></td>
		
		</tr>
		</tbody>
		</table>
		
		
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
        <button class="btn btn-primary"  onclick="form_save_timesheet('ADD TIMESHEET RECORD', 'c_resource_timesheet/form_timesheet/<?php echo $periode; ?>');"><i class="fa fa-plus-square-o fa-lg"></i> Add Rows</button>
        </div>
        <form id="send-approve" >
<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="table_timesheet">
                    
                <thead>
			<tr>
				
                                <th class="text-center">Date</th>
                                <th class="text-center">Holiday</th>
                                <th class="text-center">Work Description</th>
                                <th class="text-center">Hours</th>
                                <th class="text-center">Overtime</th>
                                <th class="text-center">Charge Description</th>
                                <th class="text-center">Activity</th>
                                <th class="text-center">Action</th>
                                
			</tr>
		</thead>
                
                <tbody>
                    
                </tbody>
                
                </table>
                </form>
        
<button type="button" class="pull-left btn btn-warning" id="back-btn" onclick="change_page(this, 'c_resource_timesheet/resource_timesheet');">Back...</button>
<button   id="send" style="display:none;" class="pull-right btn btn-success" name="button" onclick="send_timesheet('c_resource_timesheet/approve_rm','SEND ALL TIMESHEET','<?php echo $employee_id; ?>','<?php echo $periode; ?>')"><i class="fa fa-check-square-o"></i>Send For Approval</button>
<script type="text/javascript">

        $(document).ready(function(){
            var mindate='<?php echo $min_date; ?>';
            var maxdate='<?php echo $max_date; ?>';
            var active_dates = <?php echo $holiday_date; ?>;
            
        $('.date_ts').datepicker({
                format: "yyyy-mm-dd",
                startDate: mindate,
                endDate: maxdate, 
                autoclose: true,
                beforeShowDay: function(date){
         var d = date;
         var curr_date = d.getDate();
         var curr_month = d.getMonth() + 1; //Months are zero based
         var curr_year = d.getFullYear();
         var formattedDate = curr_year + "-" + curr_month + "-" + curr_date;

           if ($.inArray(formattedDate, active_dates) !== -1){
               return {
                  classes: 'activeClassdt'
               };
           }
          return;
      }
            });
            var charcode = <?php echo $charge_code; ?>;
            var actcode = <?php echo $act_code; ?>;
            
            $(".select_charge").select2({
                data:charcode
            });
            $(".select_act").select2({
                data:actcode
            });
            $(".select_charge1").change(function() {
               var approvedby=$(".select_charge1").val();
            $(".approved_by1").val(approvedby);
            });
           
        });
        
        </script>
        
