<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->

        
<!-- Latest compiled and minified JavaScript -->
       <!-- <link rel="stylesheet" href="http://localhost/COAST2/assets/css/select2/select2.css"> -->
       <link rel="stylesheet" href="<?php echo js_url(); ?>plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="<?php echo css_url(); ?>chosen/chosen.css">
<div class="box box-success">
    <!-- <div class="box-header">
        <h3 class="box-title">GANTI PASSWORD</h3>
    </div> -->
    <div class="box-body">


        <h3 style="display: inline-block">Form Edit Timesheet</h3>
        <div class="requester-input form-section-container input-section">
            <form method="post" id="form-edit-timesheet">
                <div class="form-group">
                <label for="date_ts" class="col-sm-4">Date<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input readonly=""  style="text-align: left; width: 175px;height: 100%;" value="<?php echo $edit_data_timesheet[0]['date_ts']; ?>" class="form-control holo date_ts" id="date_ts" name="date_ts">
                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['date_ts']; ?>" name="date_ts2"/>
                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['holiday']; ?>" name="holiday" id="holiday" />
                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['employee_id']; ?>" name="employee_id"/>
                    <input type="hidden" id="periode" name="periode" value="<?php echo $edit_data_timesheet[0]['periode_date']; ?>"/>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>   
<?php if ($st_approve==0){ ?>
<div class="form-group">
                <label for="approved" class="col-sm-4 control-label">Approved By<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-check"></i>
                    </div>
                    <select name="approved[]"  data-placeholder="Choose Your Approval" id="charge" class="select_charge select_charge1 pull-right" style="width: 300px">
                                <option value=""></option>
                                <?php foreach ($employee_names as $key =>$value){
                                    if($value['id']==$edit_data_timesheet[0]['approved_by']){
                                        echo "<option value=\"$value[id]\" selected>".$value['text']."</option>";
                                    }
                                    else{
                                        echo "<option value=\"$value[id]\">".$value['text']."</option>";
                                    }
                                } ?>
                    </select>
                    <input type="hidden" value="<?php echo $st_approve; ?>" name="jenis"/>
                  
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>


  <?php } else {?>

                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['approved_by']; ?>" name="employee_id"/>
                    <input type="hidden" value="<?php echo $st_approve; ?>" name="jenis"/>
                    <?php }?>
                <div class="form-group">
                <label for="hours" class="col-sm-4 control-label">Hours<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input value="<?php echo $edit_data_timesheet[0]['hours']; ?>" style="text-align: left; width: 25px;height: 100%;" value="" class="form-control holo" id="hours" name="hours">
                    
                </div>
				
            </div>
                <div class="form-group">
                <label for="charge" class="col-sm-4 control-label">Charge Code<span id="spanId" style="color:red;font-size: 17px;">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-asterisk"></i>
                    </div>
                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['charge_code']; ?>" style="text-align: left; width: 164px;height: 100%;background:none;border: none;"  class="form-control holo"  name="charge_code2">
                    <select name="charge_code[]" style="width: 500px" data-placeholder="Choose your Charge Code" id="charge" class="select_charge select_charge1 pull-right" >
                                <option value="" ></option>
                                <?php foreach ($charge_code as $key =>$value){
                                    if($value['id']==$edit_data_timesheet[0]['charge_code']){
                                        echo "<option value=\"$value[id]\" selected>".$value['text']."</option>";
                                    }
                                    else{
                                        echo "<option value=\"$value[id]\">".$value['text']."</option>";
                                    }
                                    
                                } ?>
                    </select>
                    
                </div>
				
            </div>
                <div class="form-group">
                <label for="activity" class="col-sm-4 control-label">Activity Code<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-asterisk"></i>
                    </div>
                    <input type="hidden" value="<?php echo $edit_data_timesheet[0]['act_code']; ?>" style="text-align: left; width: 175px;height: 100%;background:none;border: none;"  class="form-control holo"  name="activity2">
                    <select name="activity[]" style="width: 300px" data-placeholder="Choose your Activity" class="select_act pull-right" >
                                <option value="" ></option>
                                <?php foreach ($act_code as $key =>$value){
                                    if($value['id']==$edit_data_timesheet[0]['act_code']){
                                        echo "<option value=\"$value[id]\" selected>".$value['text']."</option>";
                                    }
                                    else{
                                        echo "<option value=\"$value[id]\">".$value['text']."</option>";
                                    }
                                } ?>
                    </select>
                </div>
				
            </div>
                <div class="form-group">
                <label for="work" class="col-sm-4 control-label">Work Description<span id="spanId" style="color:red;font-size: 17px;">*</span></label>
                <div class="input-group">
                    <textarea style="text-align: left; width: 300px;height: 100%;resize: none;" class="form-control"  rows="3" id="work" name="work"><?php echo $edit_data_timesheet[0]['work_desc']; ?></textarea>
                    
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                
                
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    
    $('#date_ts').change(function(){
            $.ajax({
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/holiday_status/',
                    type:'POST',
                    dataType:'json',
                    data:{
                    periode:$('#periode').val(),
                    date:$('#date_ts').val()
                    },
                    success:function(data){
                    $('#holiday').val(data[0].Holiday_Status);
                        
},
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
                });
        });

            var mindate='<?php echo $min_date; ?>';
            var maxdate='<?php echo $max_date; ?>';
            var active_dates = <?php echo $holiday_date; ?>;
            
            $("#hours").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
        
        $('#date_ts').datepicker({
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
            //var charcode = <?php echo $charge_code; ?>;
            //var actcode = <?php echo $act_code; ?>;
            var config = {
      '.select_charge'  : {allow_single_deselect:true},
      '.select_act'  : {allow_single_deselect:true}
    };
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }

            });
            
</script>