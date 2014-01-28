$(document).ready(function() {

    // page is now ready, initialize the calendar...


    var dv = 'month';
    var va = {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      };
    if (!seio){
      dv = 'agendaWeek';
      va = {
          left: '',
          center: 'title',
          right: 'agendaWeek'
        };
     }

    $('#calendar').fullCalendar({
      defaultView:dv,
      header: va,
			editable: false,
      minTime:7,
      maxTime:22,
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
      /*eventClick: function(calEvent, jsEvent, view) {
        alert(calEvent.title);
        $('#drop-login').show();
        Foundation.libs.dropdown['toggle']($('#drop-login'));
        $("#drop-cal-info").css('top', '50px');
        // change the border color just for fun
      },*/
      loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			},
      eventAfterRender: function(event, element, view) {
        //$(element).attr('title',event.title);
        $(element).attr('data-dropdown','drop-cal-info');
        $(element).click(function(){
          $('#drop-cal-info-title').html(event.title);
          $('#drop-cal-info-content').html(event.content);
          $('#drop-cal-info-link').attr('href',event.link);
          $('#drop-cal-info-location').html(event.location);
          
        });
      }
    });
    
    
    

});