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
            link = '<div data-alert class="alert-box radius secondary" id="link_div_'+data.data.id+'">';
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
            skill = '<span data-alert class="label alert-box radius secondary profile-skils" id="skill_'+data.data.id+'">';
            skill += data.data.title;
            skill += '<a href="#" class="close" onclick="removeSkill('+data.data.id+',\''+data.data.location+'\')">&times;</a>';
            skill += '</div>';
            $('.skillList').append(skill);
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

