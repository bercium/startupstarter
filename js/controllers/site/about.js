function showPerson(person){
  $('#team_image').attr('src','../images/team/team-'+person+'.jpg');
  $('#team_desc_'+person).css('font-weight','bold');
}

function hidePerson(person){
  $('#team_image').attr('src','../images/team/team.jpg');
  $('#team_desc_'+person).css('font-weight','normal');
}