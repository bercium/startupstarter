$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
      dayClick: function() {
        //alert('a day has been clicked!');
      },
      eventClick: function(calEvent, jsEvent, view) {

        alert('Event: ' + calEvent.content);

        // change the border color just for fun
        $(this).css('border-color', 'red');

      },
      loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			},
      events: events
    })

});