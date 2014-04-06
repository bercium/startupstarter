
  $(function() {
      
    var inviteCache = {};
    if ($('.invite-member-email').length != 0)
    $( ".invite-member-email" )
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
          if ( term in inviteCache ) {
            response( inviteCache[ term ] );
            return;
          }

          $.getJSON( referrer_url, { term: term}, function( data, status, xhr ) {
            if (data.status == 0){
              cache[ term ] = data.data;
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
        focus: function( event, ui ) {
          //$('.skillset').val( ui.item.skill );
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          //var terms = splitComa( this.value );

          this.value = ui.item.fullname;

          $('#referrer-user-id').val(ui.item.user_id); 
          return false;
        }
      })
     .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a><img src=\"" + item.img + "\" height=\"30\" class=\"card-avatar\">" + item.fullname + "</a>" )
        .appendTo( ul );
    };      
        
  });
