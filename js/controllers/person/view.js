 function sendMSG(inUrl) {
 
  $('#drop-msg').toggle();
  return;
  var data=$("#contact-form").serialize()+'&ajax=1';

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

