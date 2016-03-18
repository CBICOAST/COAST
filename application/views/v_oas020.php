<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS020
* Program Name     : Show Leave List Calendar
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 28-08-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<!-- fullCalendar -->
<link href="<?php echo css_url();?>fullcalendar/fullcalendar.new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url();?>fullcalendar/fullcalendar.new.print.css" rel="stylesheet" type="text/css" media='print' />

<!-- THE CALENDAR -->
<div class="col-md-9">
	<div class="box box-primary">
	    <div class="box-body no-padding">
	        <!-- THE CALENDAR -->
	        <div id="calendar"></div>
	    </div><!-- /.box-body -->
	</div><!-- /. box -->
</div><!-- /.col -->

<!-- fullCalendar -->
<script src="<?php echo js_url();?>plugins/fullcalendar/fullcalendar.new.min.js" type="text/javascript"></script>
 <script type="text/javascript">
$(function() {
	var date = new Date();
                var d = date.getDate(),
                        m = date.getMonth(),
                        y = date.getFullYear();
	$('#calendar').fullCalendar({
		header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        
        buttonText: {//This is to add icons to the visible buttons
            // prev: "<span class='fa fa-caret-left'></span>",
            // next: "<span class='fa fa-caret-right'></span>",
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
        },
        eventSources: [
	    // your event source
	    {
	        url: host+'c_oas020/feed_event', // use the `url` property
	        
            backgroundColor: "#0073b7", //Blue
            borderColor: "#0073b7" //Blue
	    }
	    // any other sources...
	    ]//,
     //    events: [
	    //     {
	    //         title: 'All Day Event',
	    //         start: new Date(y, m, 4),
	    //         backgroundColor: "#f56954", //red
	    //         borderColor: "#f56954" //red
	    //     },
	    //     {
	    //         title: 'Long Event',
	    //         start: new Date(y, m,26),
	    //         end: new Date(y, m,27),
	    //         backgroundColor: "#f39c12", //yellow
	    //         borderColor: "#f39c12" //yellow
	    //     },
	    //     {
	    //         title: 'Long Event',
	    //         start: new Date(y, m, 27),
	    //         end: new Date(y, m, 28),
	    //         backgroundColor: "#f39c12", //yellow
	    //         borderColor: "#f39c12" //yellow
	    //     },
	    //     {
	    //         title: 'Meeting',
	    //         start: new Date(y, m, d, 10, 30),
	    //         allDay: false,
	    //         backgroundColor: "#0073b7", //Blue
	    //         borderColor: "#0073b7" //Blue
	    //     },
	    //     {
	    //         title: 'Lunch',
	    //         start: new Date(y, m, d, 12, 0),
	    //         end: new Date(y, m, d, 14, 0),
	    //         allDay: false,
	    //         backgroundColor: "#00c0ef", //Info (aqua)
	    //         borderColor: "#00c0ef" //Info (aqua)
	    //     },
	    //     {
	    //         title: 'Birthday Party',
	    //         start: new Date(y, m, d + 1, 19, 0),
	    //         end: new Date(y, m, d + 1, 22, 30),
	    //         allDay: false,
	    //         backgroundColor: "#00a65a", //Success (green)
	    //         borderColor: "#00a65a" //Success (green)
	    //     },
	    //     {
	    //         title: 'Click for Google',
	    //         start: new Date(y, m, 28),
	    //         end: new Date(y, m, 30),
	    //         url: 'http://google.com/',
	    //         backgroundColor: "#3c8dbc", //Primary (light-blue)
	    //         borderColor: "#3c8dbc" //Primary (light-blue)
	    //     }
	    // ]
	});
});