function addSkill(inUrl)
 {
 
   var data=$("#SkillForm").serialize()+'&ajax=1';

	$.ajax({
   type: 'POST',
   url: inUrl,
   data:data,
        success:function(indata){
          data = JSON.parse(indata);
					if (!data.status){
            skill = '<span data-alert class="label radius secondary profile-skils" id="skill_'+data.data.id+'">';
            skill += data.data.title+"<br /><small class='skill-industry'>"+data.data.desc+"</small>";
            if (data.data.multi == 1) skill += '<a href="#" class="close topright" onclick="removeSkill('+data.data.id+')">&times;</a>';
            skill += '</div>';
            $('.skillList').append(skill);
            $('#skill').val('');
            $('#skill').focus();
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

function removeSkill(skill_id, inUrl){
    $.ajax({
   type: 'POST',
   url: inUrl,
   data:{ id: skill_id, ajax: 1},
        success:function(indata){
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

function selectIndustry(id){
  $('.skillset').val(id); 
  //Foundation.libs.forms.refresh_custom_select($('.skillset'),true);
  $(".skillset").trigger("liszt:updated");
  $('#customSkills').show();
}


var cache = {};
var cityCache = {};
  
$(function() {
    
    if ($('.skill').length != 0)
    $( ".skill" )
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
          $.getJSON( skillSuggest_url, { term: term, category:$("#skillset").val() }, function( data, status, xhr ) {
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
          this.value = ui.item.skill;
          return false;
        },
        select: function( event, ui ) {
          //var terms = splitComa( this.value );
          
          // remove the current input
          //terms.pop();
          // add the selected item
          //terms.push( ui.item.skill );
          this.value = ui.item.skill;
          tagApi.tagsManager("pushTag", ui.item.skill);
          return false;

      		$('.skillset').val(ui.item.skillset_id); 
    			//Foundation.libs.forms.refresh_custom_select($('.skillset'),true);
          $(".skillset").trigger("liszt:updated");
          //$( "#project-id" ).val( ui.item.id );
          // add placeholder to get the comma-and-space at the end
          //terms.push( "" );
          //this.value = terms.join( ", " );
          return false;
        }
      })
     .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.skill + "</a>" )
        //.append( "<a>" + item.skill + "<br><small>" + item.skillset + "</small></a>" )
        .appendTo( ul );
    };
    
    
    var tagApi = $(".skill").tagsManager({
     prefilled:$(".skill").val(),
     delimiters: [9, 13, 44, 59],
     backspace:[],
     blinkBGColor_1:'#C64747',
     blinkBGColor_2:'#999999',
     tagClass:'label radius'
   });
   
  });