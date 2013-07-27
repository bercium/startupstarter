;(function ($, window, undefined) {
  $(document).foundation();
  

//.parallax(xPosition, speedFactor, outerHeight) options:
	//xPosition - Horizontal position of the element
	//inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
	//outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
	//$('#intro').parallax("50%", 0.4);
	//$('#outro').parallax("50%", 0.4);
  
  
  'use strict';

  var $doc = $(document),
      Modernizr = window.Modernizr;

  
  $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
  $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
  $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
  $('input, textarea').placeholder();
  
  
  $.fn.foundationButtons          ? $doc.foundationButtons() : null;
  
  
  $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;
  
  
  $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;
  
  $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
  $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
  
    
    $.fn.foundationTabs             ? $doc.foundationTabs() : null;
    
  

  // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
  // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
  // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
  // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
  // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

  // Hide address bar on mobile devices
  if (Modernizr.touch) {
    $(window).load(function () {
      setTimeout(function () {
        window.scrollTo(0, 1);
      }, 0);
    });
  }
  
  $(window).scroll(function(){
    var visibility = (20-$(document).scrollTop())/20;
    if ($(document).scrollTop() > 20) visibility = 0;
    $("#image-beta").fadeTo(0,visibility);
    //if ($(document).scrollTop() > 10) $("#image-beta").fadeOut();
    //else if ($("#image-beta").is(':hidden')) $("#image-beta").fadeIn();
  });
  
  $(".lin-hidden").each(function(){
    if ($(this).find('.lin-edit').val() == '') $(this).hide();
  });
  $(".lin-edit").focusout(function(){
    if ($(this).val() == '') $(this).parents('.lin-hidden').hide();
    if ($(this).hasClass('lin-hidden')) $(this).hide();
  });
  $(".lin-trigger").hover(
    function(){
      $(this).find('.lin-hidden').show();
    }, 
    function(){
      if (!$(this).find(".lin-edit").is(':focus') && $(this).find(".lin-edit").val() == '') $(this).find('.lin-hidden').hide();
    });

    $('select').chosen({no_results_text: Yii.t('js','Oops, nothing found!'), allow_single_deselect: true, width:'100%' });
})(jQuery, this);


function contact(e){
	var pri = "@";
	e.href = "mailto:info";
	e.href += pri+"cofinder.eu";
}

function splitComa( val ) {
  return val.split( /,\s*/ );
}
		
function extractLast( term ) {
	return splitComa( term ).pop();
}

var pageNavCount = 1;
function addPageToList(e){
  //alert('da');
  pageNavCount++;
  $(".page-navigation").fadeIn('normal');
  $(".page-navigation ul").append('<li><a href="#page'+pageNavCount+'">'+Yii.t('js','Page')+' '+pageNavCount+'</a></li>');
  e.loading.msg.fadeOut('normal');
}