 function recentUsersPage(inUrl){
  $.ajax({
   type: 'GET',
   url: inUrl,
   data:{ajax: 1},
        success:function(indata){
          data = JSON.parse(indata);
					if (!data.status){
						$('#recent_users').html(data.data);
          }
					if (data.message) alert(data.message);
        },
        error: function(data,e,t) { // if error occured
           alert(e+': '+t);
           //alert(data);
        },
 
  dataType:'html'
  });
 
}


 function recentProjectsPage(inUrl){
  $.ajax({
   type: 'GET',
   url: inUrl,
   data:{ajax: 1},
        success:function(indata){
          data = JSON.parse(indata);
					if (!data.status){
						$('#recent_projects').html(data.data);
          }
					if (data.message) alert(data.message);
        },
        error: function(data,e,t) { // if error occured
           alert(e+': '+t);
           //alert(data);
        },
 
  dataType:'html'
  });
 
}


	var cityCache = {};
	//var skillSuggest_url = 'profile/sugestSkill';
	
  $(function() {
    $( "#SearchForm_city" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
			.autocomplete({
				delay:300,
        source: function( request, response ) {
					
					$.getJSON( citySuggest_url, { term: extractLast( request.term ) }, function( data, status, xhr ) {
						if (data.status == 0){
							cityCache[ extractLast( request.term ) ] = data.data;
							response( data.data );
						}else alert(data.message);
					});
        },
        /*search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },*/
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = splitComa( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
		
  });