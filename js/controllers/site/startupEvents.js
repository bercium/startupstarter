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
          if (event.link == '') $('#drop-cal-info-link').hide();
          else $('#drop-cal-info-link').show();
          $('#drop-cal-info-location').html(event.location);
          
          gase("calendar-infoClick-"+event.id);
          
          var link = 'http://www.google.com/calendar/event?action=TEMPLATE'
          link += '&text='+event.title;
          link += '&dates='+event.gcal;
          link += '&details='+event.content;
          link += '&location='+event.location;
          link += '&trp=true&sprop=Cofinder&sprop=name:http%3A%2F%2Fwww.cofinder.eu%2Fsite%2FstartupEvents%2F';
          
          $('#drop-cal-link').attr("href",link);
          
        });
      }
    });
    
    
    var cache = {};
    if ($('#filter').length != 0)
    $( "#filter" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
			.autocomplete({
				delay:300,
				minLength: 2,
        source: function( request, response ) {
					
          //var term = extractLast( request.term );
          var term = request.term;
          if ( term in cache ) {
            response( cache[ term ] );
            return;
          }
          
          //Yii.app().createUrl("profile/suggestSkill",{ajax:1})
          $.getJSON( cityCountrySuggest_url, { term: term }, function( data, status, xhr ) {
            if (data.status == 0){
              cache[ term ] = data.data;
              response( data.data );
            }else alert(data.message);
          });
        },
        focus: function( event, ui ) {
          this.value = ui.item.value;
          return false;
        },
        select: function( event, ui ) {
          this.value = ui.item.value;
          //tagApi.tagsManager("pushTag", ui.item.value);
          return false;
        }
      })
     .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.value + ' (' + item.count + ")</a>" )
        //.append( "<a>" + item.skill + "<br><small>" + item.skillset + "</small></a>" )
        .appendTo( ul );
    };    

});