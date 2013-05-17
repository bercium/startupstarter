 $(window).load(function() {
    $('.list-holder').infinitescroll({
      debug:true,
      navSelector  : ".pagination",
      nextSelector : ".pagination li:last a",    
      itemSelector : ".list-holder ul.list-items",
			animate:true,
			bufferPx:200,
			prefill:true,
      loading:{
        img: "../images/ajax-loader.gif",
        msgText: "",
        finishedMsg: ""
      }
    });
 });