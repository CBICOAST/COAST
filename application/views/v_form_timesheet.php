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


        <h3 style="display: inline-block">Form Timesheet</h3>
        <div class="requester-input form-section-container input-section new-employee-form" id="form-timesheet">
            <form method="post" id="timesheet_form">
                <div class="form-group">
                <label for="date_ts" class="col-sm-4">Date<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input readonly="" style="text-align: left; width: 13%;height: 100%;cursor: pointer;font-size: 90%;" value="" class="form-control holo date_ts" id="date_ts" name="date_ts">
                    <input type="hidden" name="holiday" id="holiday" />
                    <input type="hidden" id="periode" name='periode' value="<?php echo $periode; ?>"/>
                    <input type="hidden" value="<?php echo $employee_id; ?>" name="employee_id" id="employee_id"/>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                
                
                <div class="form-group">
                <label for="approved" class="col-sm-4 control-label">Approved By<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-check"></i>
                    </div>
                    <select name="approved[]"  data-placeholder="Choose Your Approval" id="charge" class="select_charge select_charge1 pull-right" style="width: 300px">
                                <option value=""></option>
                                <?php foreach ($employee_names as $key =>$value){
                                    echo "<option value=\"$value[id]\" >".$value['text']."</option>";
                                } ?>
                    </select>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                <div class="form-group">
                <label for="hours" class="col-sm-4 control-label">Hours<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input style="text-align: left; width: 7%;height: 100%;" value="" class="form-control holo decimal hours" id="hours" name="hours">
                    <input style="text-align: left; width: 7%;height: 100%;" value="" class="form-control holo decimal" id="overtime" name="overtime" type="hidden"/>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                <div class="form-group">
                <label for="charge_code" class="col-sm-4 control-label">Charge Code<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-asterisk"></i>
                    </div>
                    <select name="charge_code[]"  data-placeholder="Choose Your Charge Code" id="charge" class="select_charge select_charge1 pull-right" style="width: 500px">
                                <option value=""></option>
                                <?php foreach ($charge_code as $key =>$value){
                                    echo "<option value=\"$value[id]\" >".$value['text']."</option>";
                                } ?>
                    </select>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                <div class="form-group">
                <label for="activity" class="col-sm-4 control-label">Activity Code<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-asterisk"></i>
                    </div>
                    <select data-placeholder="Choose Your Activity" name="activity[]" style="width: 300px;" class="select_act pull-right" >
                                <option value=""></option>
                                <?php foreach ($act_code as $key =>$value){
                                    echo "<option value=\"$value[id]\" >".$value['text']."</option>";
                                } ?>
                    </select>
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                <div class="form-group">
                <label for="work" class="col-sm-4 control-label">Work Description<span id="spanId" style="color:red;font-size: 17px">*</span></label>
                <div class="input-group">
                    
                    <textarea style="text-align: left; width: 300px;height: 100%;resize: none;" value="" class="form-control" id="work" name="work"></textarea>
                    
                </div>
				<span id="spanId"style="color:red;"></span>
            </div>
                <div style="height:50px">
                    
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
            
            $('#hours').bind('paste', function () {
                var self = this;
                setTimeout(function () {
                    if (!/^\d*(\.\d{1,2})+$/.test($(self).val())) $(self).val('');
                }, 0);
            });
            
            $('.decimal').keypress(function (e) {
                var character = String.fromCharCode(e.keyCode)
                var newValue = this.value + character;
                if (isNaN(newValue) || hasDecimalPlace(newValue, 2)) {
                    e.preventDefault();
                    return false;
                }
            });
            
            function hasDecimalPlace(value, x) {
                var pointIndex = value.indexOf('.');
                return  pointIndex >= 0 && pointIndex < value.length - x ;
            }
        
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

        $('.hours').on("change keyup",function(){
			$.ajax({
				url:'<?php echo base_url(); ?>'+'c_resource_timesheet/get_prev_overtime/',
				type:'POST',
                dataType:'json',
                data:{
                hours:$('.hours').val(),
                date_ts:$('#date_ts').val(),
                holiday:$('#holiday').val(),
                employee_id:$('#employee_id').val()
                },
                success:function(data){
                    if(data[0].overtime<=0){
						var dataovertime=0;
                        }
                    else{
						var dataovertime=data[0].overtime;
                        }
                $('#overtime').val(dataovertime);
                    
},
              error: function(xhr, resp, text) {
              console.log(xhr, resp, text);
                    }
				});
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