$.getScript(fullURL+"/js/includes/skill.js");

function addLink(inUrl)
 {
 
   var data=$("#LinkForm").serialize()+'&ajax=1';

	$.ajax({
   type: 'POST',
   url: inUrl,
   data:data,
        success:function(indata){
          data = JSON.parse(indata);
					if (!data.status){
            link = '<div data-alert class="radius secondary label" id="link_div_'+data.data.id+'">';
            link += data.data.title+': <a href="http://'+data.data.url+'" target="_blank">'+data.data.url+'</a>';
            link += '<a href="#" class="close" onclick="removeLink('+data.data.id+',\''+data.data.location+'\')">&times;</a>';
            link += '</div>';
            $('.linkList').append(link);
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


function removeLink(link_id, inUrl){
    $.ajax({
   type: 'POST',
   url: inUrl,//'<?php echo Yii::app()->createAbsoluteUrl("profile/removeLink"); ?>',
   data:{ id: link_id, ajax: 1},
        success:function(data){
          data = JSON.parse(indata);
          if (data.message != '') alert(data.message);
          else {
            //$('#link_div_'+data.data.id).fadeOut('slow');
          }
        },
        error: function(data,e,t) { // if error occured
           alert(e+': '+t);
        },
 
  dataType:'html'
  });

}

	//var skillSuggest_url = 'profile/suggestSkill';
	
  $(function() {
    
    //if ($('.skill').length != 0)
      
     
          
    if ($('.city').length != 0)
    $( ".city" )
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
					
					$.getJSON( citySuggest_url, { term: extractLast( request.term ) }, function( data, status, xhr ) {
						if (data.status == 0){
							cityCache[ extractLast( request.term ) ] = data.data;
							response( data.data );
						}else alert(data.message);
					});
        }
      });
      
  });
