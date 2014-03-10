// if cookie alert is visible set margin to intro h1
$(function() {
  if ($('.cc-cookies').length > 0) { 
      $('.intro h1').css('margin-top','50px');
  }
});



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
  
  /*$(window).scroll(function(){
    var visibility = (20-$(document).scrollTop())/20;
    if ($(document).scrollTop() > 20) visibility = 0;
    $(".image-beta").fadeTo(0,visibility);
    //if ($(document).scrollTop() > 10) $("#image-beta").fadeOut();
    //else if ($("#image-beta").is(':hidden')) $("#image-beta").fadeIn();
  });*/
  
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

  $.cookieCuttr();
  
  //tracking with code
  // regular events CATEGORY_ACTION_LABEL_VALUE
  // sharing events share_SOCIALNETWORK_ACTION_BUTTON
  $("[trk]").each(function() {
      var id = $(this).attr("trk");
      //var target = $(this).attr("target");
      //var text = $(this).text();
      var thisEvent = null;
      if ($(this).is("[onclick]")) thisEvent = $(this).attr("onclick");
      
      $(this).click(function(event) { // when someone clicks these links
        gase(id);
        if (thisEvent) eval(thisEvent);
      });
  });
  
  //slimscroll
  $('.slimscrollSmall').slimScroll({
    height: '130px'
  });
  
  $('.slimscrollBig').slimScroll({
    height: '250px'
  });
  
  //scroll events
  $.scrollDepth();
  /*{
  percentage: false,
  userTiming: false,
  pixelDepth: false }*/
  
  $('[limitchars]').each(function(){
    $(this).jqEasyCounter({
        'maxChars': $(this).attr('limitchars'),
        'maxCharsWarning': ($(this).attr('limitchars') - 10)
    });
  });
  
  
})(jQuery, this);


var qrActive = false;
function qrLoad(){
  //alert('d');
//  $.get(Yii.app.createUrl("profile/suggestSkil",{ajax:1,term:'ski'}), function( data ) {
  if (qrActive) return;
  $.get(fullURL+"/qr/create?ajax=1", function( id ) {
    qrActive = true;
    link = 'http://'+document.domain+fullURL+'/qr/scan?qr='+id;
    $(".login-qrcode" ).html('<hr><p>'+Yii.t('msg','Scan QR code with phone to login')+'</p><img src="https://chart.googleapis.com/chart?cht=qr&chld=M|0&chs=300&chl='+link+'" title="QR code login" alt="QR code login" style="opacity:0.8">');
    $(".login-qrcode" ).everyTime('1s',function(i){qrCheck(id);},0);
  });
}

function qrCheck(id){
  $.get(fullURL+"/qr/validate?ajax=1&qr="+id, function( data ) {
    if (data == true) location.reload();
  });
}

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
var pageScrollName = '';
function addPageToList(e){
  //alert('da');
  pageNavCount++;
  $(".page-navigation").fadeIn('normal');
  $(".page-navigation ul").append('<li><a class="button secondary small radius" href="#page'+pageNavCount+'">'+Yii.t('js','Page')+' '+pageNavCount+'</a></li>');
  e.loading.msg.fadeOut('normal');

  var psn = pageScrollName.split("_");
//  //alert(psn[0]+'-'+psn[1]);
  ga('send', 'event', psn[0], psn[1], 'scroll', pageNavCount);
  ga('send', 'event', psn[0], psn[1], 'page-'+pageNavCount, 1);
}

// ga function depending on debuging
function gase(id){
  //if (jQuery.cookie('cc_cookie_accept') != 'cc_cookie_accept') return;  //cookie compliance
  var trk = id.split("_");

  if (trk[0] == 'social'){
    //social_facebook_like_nameOfButton
    // add social event
    if (trk.length > 2) ga('send', 'social', trk[1], trk[2], window.location.pathname);
    // add extra event
    if (trk.length > 3) ga('send', 'event', trk[2], trk[1], trk[3], 1);
  }else{
    // regular events CATEGORY_ACTION_LABEL_VALUE
    if (trk.length > 3) ga('send', 'event', trk[0], trk[1], trk[2], trk[3]);
    else
    if (trk.length > 2) ga('send', 'event', trk[0], trk[1], trk[2]);
    else
    if (trk.length > 1) ga('send', 'event', trk[0], trk[1]);
  }
  
}

function markNotifications(inUrl){
   $.ajax({
   type: 'GET',
   url: inUrl,
   data:{ajax: 1},
   dataType:'html'
  });
}
