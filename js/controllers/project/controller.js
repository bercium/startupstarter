// TODO: move to main.js
function countTweetChars(){
  $('#tweetCount').html((120 - $('#IdeaTranslation_tweetpitch').val().length));
  if ((120 - $('#IdeaTranslation_tweetpitch').val().length) < 0) $('#tweetCount').addClass("alert");
  else $('#tweetCount').removeClass("alert");
}
