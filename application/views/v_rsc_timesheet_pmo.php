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

        function form_edit_timesheet_pmo(title, url){
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
             	 
             	   $("#approve_pmo").css("display","none");
            $('#table_timesheet_pmo tbody tr').remove(); 
                var trHTML = '';
                if(data ===0){
                    $('#table_timesheet_pmo tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                    $("#validasi-form").css({'display':'none'});
                    $('#approve_pmo').css("display","none");
                }
                else{
                	 var total=0;
                $.each(data, function (i, item) {
             	   no=i+1;
             	 
                	var item_status=item.status==2?'<a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet_pmo(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'/2\')"><i class="fa fa-pencil-square-o"></i>Edit</a>':'Already Send';
                	var count_status_zero=item.status==2?1:0;
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
                    $('#table_timesheet_pmo tbody').append(trHTML);
                    $("#validasi-form").css({'display':'none'}); 
                    $('[data-toggle="tooltip"]').tooltip();
                    if(total<=0){
    					$('#approve_pmo').css("display","none");
                        }else{
                        	$('#approve_pmo').css("display","block");
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
        
        function send_timesheet(url,title,employee,periode){
            var url_link=url;
            var employee_id=employee;
            var periode_date=periode;
            if(dialog === null)
                {
                    dialog = $.Zebra_Dialog('Are you sure to approve <strong>ALL TIMESHEET</strong> on periode <strong>'+periode_date+'</strong>?', {
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
                },
                success:function(data){
                	$('.wait').css('display','none');
                	 $('#success').css('display','block');
                    var trHTML = '';
                    	 var total=0;
                    	 $('#table_timesheet_pmo tbody tr').remove(); 
                            $.each(data.data_sheet, function (i, item) {
                            	 no=i+1;
                            	 
                              	var item_status=item.status==2?'<a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet_pmo(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'/2\')"><i class="fa fa-pencil-square-o"></i>Edit</a>':'Already Send';
                            	var count_status_zero=item.status==2?1:0;
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
                        $('#table_timesheet_pmo tbody').append(trHTML);
                        $("#validasi-form").css({'display':'none'});
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
        					$('#approve_pmo').css("display","none");
                            }else{
                            	$('#approve_pmo').css("display","block");
                                }
                    
                       },
                  error: function(xhr, resp, text) {
                	  $('#success').css('display','none');
                	  $('#failed').css('display','block');
                	  $('#failed').fadeOut("slow");
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
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/load_data_pmo/',
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
                            $('#table_timesheet_pmo tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                            $('#send').css("display","none");
                        }
                        else{
                            var total=0;
                            $.each(data, function (i, item) {
                            	  no=i+1;
                            	  var overtime=item.holiday=='Yes'?item.hours:((item.hours-9)<0)?0:(item.hours-9);
                                 	var item_status=item.status==2?'<a class="btn btn-info btn-xs" onclick=\"form_edit_timesheet_pmo(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'/2\')"><i class="fa fa-pencil-square-o"></i>Edit</a>':'Already Send';
                            	var count_status_zero=item.status==2?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours
                      +'</td><td class="text-center">'+overtime 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status
                      +'</td></tr>';
              total +=count_status_zero
                        });
                        $('#table_timesheet_pmo tbody').append(trHTML);
                        $('[data-toggle="tooltip"]').tooltip();
                        $("#approve_pmo").css("display","none");
                        if(total<=0){
        					$('#approve_pmo').css("display","none");
                            }else{
                            	$('#approve_pmo').css("display","block");
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
		<?php $date = date_create($periode) ?>
		<table border="0">
		<colgroup>
					<col width="130px">
					<col width="30px">
					<col width="150px">
					
					
				</colgroup>
				<tbody>
				<tr>
		<td><b style="font-size: 15px;">Employee ID</b></td>
		<td>:</td>
		<td><b style="font-size: 15px;"><?php echo $employee_id; ?></b></td>
		
		</tr>
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
		<div class="text-center" id="failed" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Timesheet Approval Failed</div>
		<div class="text-center" id="success" style="background-color: #dff0d8;border: 1px solid #ccc;color:#3c763d ;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Timesheet Approval Success</div>
        <div class="wait text-center" style="display:none;background-color: #fcf8e3;color: #8a6d3b;border: 1px solid #ccc;padding: 6px 6px 6px 6px;">Wait...</div>
        <div>
        
        </div>
        
<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="table_timesheet_pmo">
                    
                <thead>
			<tr>
				
                                <th class="text-center">Date</th>
                                <th class="text-center">Holiday</th>
                                <th class="text-center">Work Description</th>
                                <th class="text-center">Hours</th>
                                <th class="text-center">Over Time</th>
                                <th class="text-center">Charge Description</th>
                                <th class="text-center">Activity</th>
                                <th class="text-center">Action</th>
                                
			</tr>
		</thead>
                
                <tbody>
                    
                </tbody>
                
                </table>
                
        
<button type="button" class="pull-left btn btn-warning" id="back-btn" onclick="change_page(this, 'c_resource_timesheet/approve_pmo_emp/<?php echo $periode; ?>')">Back...</button>
<button type="button"  id="approve_pmo" style="display:none;" class="pull-right btn btn-success" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_pmo_accepted','APPROVE ALL TIMESHEET','<?php echo $employee_id; ?>','<?php echo $periode; ?>')"><i class="fa fa-check-square-o"></i>Approve All</button>


        
