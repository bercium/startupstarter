 function addLink(inUrl)
 {
 
   var data=$("#LinkForm").serialize();
 
  $.ajax({
   type: 'POST',
   url: inUrl,
   data:data,
        success:function(indata){
          data = JSON.parse(indata);
          if (data.message != '') alert(data.message);
          else {
            link = '<div data-alert class="alert-box radius secondary" id="link_div_'+data.data.id+'">';
            link += data.data.title+': <a>'+data.data.url+'</a>';
            link += '<a href="#" class="close" onclick="removeLink('+data.data.id+',\''+data.data.location+'\')">&times;</a>';
            link += '</div>';
            $('.linkList').append(link);
          }
        },
        error: function(data) { // if error occured
           alert("Error: "+data);
           //alert(data);
        },
 
  dataType:'html'
  });
 
}


function removeLink(link_id, inUrl){
    $.ajax({
   type: 'POST',
   url: inUrl,//'<?php echo Yii::app()->createAbsoluteUrl("profile/removeLink"); ?>',
   data:{ id: link_id},
        success:function(data){
          data = JSON.parse(indata);
          if (data.message != '') alert(data.message);
          else {
            //$('#link_div_'+data.data.id).fadeOut('slow');
          }
        },
        error: function(data) { // if error occured
           alert("Error: "+data);
        },
 
  dataType:'html'
  });
}