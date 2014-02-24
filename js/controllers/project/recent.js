 $(window).load(function() {
   pageScrollName = 'project_recent';
    $('.list-holder').infinitescroll({
      debug:true,
      navSelector  : ".pagination",
      nextSelector : ".pagination li:last a",    
      itemSelector : ".list-holder div.list-items",
			animate:true,
			bufferPx:200,
			prefill:true,
      loading:{
        img: "../images/ajax-loader.gif",
        msgText: Yii.t('js','Loading...'),
        finishedMsg: Yii.t('js','No more results!'),
        finished:addPageToList
      }
    }, function(elements) {
          $('.card-content').foundation('section', 'reflow');
      });
 });

    // slimScroll  
  $(function(){
    $('.slimscroll140').slimScroll({
        height: '140px'
        
    });
});