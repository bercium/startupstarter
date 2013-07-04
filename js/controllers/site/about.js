function showPerson(person){
  $('#team_image').attr('src','../images/team-'+person+'.jpg');
  $('#team_desc_'+person).css('color','#89B561');
}

function hidePerson(person){
  $('#team_image').attr('src','../images/team.jpg');
  $('#team_desc_'+person).css('color','#403A36');
}