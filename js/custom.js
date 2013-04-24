
// Display only 60 characters in the idea-title card
$(function() {
var longText = $('.card-idea-title h5');
longText.text(longText.text().substr(0, 60) + "...");
});

// Display only 250 characters in the idea-title card
$(function() {

var longText = $('.card-abstract p');
longText.text(longText.text().substr(0, 251)  + "...");

});

// Display only 250 characters in the idea-title card
$(function() {

var Skills = $('.idea-skills .button');
var countSkills = Skills.length;

});




