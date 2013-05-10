 function recentUsersPage(inUrl){
	$('#recent_users ul').fade();
  /*$.ajax({
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
  });*/
 
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