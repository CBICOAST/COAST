<script src="<?php echo js_url();?>jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo js_url();?>plugins/zebra_dialog/zebra_dialog.js"></script>
<script type="text/javascript">

</script>
<div class="before_process" style="display:block;">Are you sure to send you'r <strong>ALL TIMESHEET</strong> on periode <strong><?php echo $periode;?></strong>?</div>
<input type="submit" value="Send For Approval" style="display: block;" class="pull-right btn btn-primary before_process" name="submit" onclick="send_timesheet('c_resource_timesheet/approve_rm','<?php echo $employee_id; ?>','<?php echo $periode; ?>');">
<div class="wait"  style="display: none;">Wait....</div>
