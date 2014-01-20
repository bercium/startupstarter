$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
      timeFormat: {
        // for agendaWeek and agendaDay
        agendaWeek: 'H:mm{ - H:mm}', // 5:00 - 6:30
        agendaDay: 'H:mm{ - H:mm}', // 5:00 - 6:30
        // for all other views
        '': 'H:mm'
      },
      events: events,
      axisFormat: 'HH:mm',
      columnFormat:{
        month:"ddd",
        agendaWeek: "ddd d.M.",
        agendaDay: "ddd d.M."
      },
      eventColor: '#89B561',
      firstDay:1,
      dayClick: function() {
        //alert('a day has been clicked!');
      },
      eventClick: function(calEvent, jsEvent, view) {
        $('#drop-login').show();
        Foundation.libs.dropdown['toggle']($('#drop-login'));
        $("#drop-cal-info").css('top', '50px');
        // change the border color just for fun
      },
      loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}
    })

});