 function addLink()
 {
 
   var data=$("#LinkForm").serialize();
 
  $.ajax({
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl("profile/addLink"); ?>',
   data:data,
        success:function(data){
                alert(data); 
                link = '<div data-alert class="alert-box radius secondary">';
                link += 'Facebook: <a >facebook.com</a>';
                link += '<a href="#" class="close" onclick="removeLink(1)">&times;</a>';
                link += '</div>';
                $('.linkList').append(link);
               },
         error: function(data) { // if error occured
           alert("Error occured.please try again");
           //alert(data);
        },
 
  dataType:'html'
  });
 
}


function removeLink(link_id){
    $.ajax({
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl("profile/removeLink"); ?>',
   data:{ id: link_id},
        success:function(data){
                alert(data); 
               },
         error: function(data) { // if error occured
           alert("Error occured.please try again");
           alert(data);
        },
 
  dataType:'html'
  });
}