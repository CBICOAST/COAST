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
                            	var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
                            	var count_status_zero=item.status==0?1:0;
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
                                <th class="text-center">Charge Description</th>
                                <th class="text-center">Activity</th>
                                <th class="text-center">Action</th>
                                
			</tr>
		</thead>
                
                <tbody>
                    
                </tbody>
                
                </table>
                </form>
        
<button type="button" class="pull-left btn btn-warning" id="back-btn" onclick="change_page(this, 'c_resource_timesheet/load_view');">Back...</button>
<input type="submit" value="Send For Approval" id="send" style="display:none;" class="pull-right btn btn-primary" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_rm','SEND ALL TIMESHEET','<?php echo $employee_id; ?>','<?php echo $periode; ?>')"/>
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
        
