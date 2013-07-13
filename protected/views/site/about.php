<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row" style="margin-top:20px;">
	<div class="columns edit-header">
		<h1><?php echo Yii::t('app','What is cofinder'); ?></h1>
	</div>
  <div class="  columns panel edit-content">
   <div class="large-8  columns">
		 
		<p>
		<?php 
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.');
		?>
		</p>
	
		
		<h4><?php echo Yii::t('app','Brief history'); ?></h4>
		<p>
      <?php echo Yii::t('msg','
		Ideja se je porodila konec oktobra 2012 na dogodku v PopUp domu. Ob pogovoru z enim izmed ustanovitljev ljubljanskega coworkinga sem prišel na idejo, ki bi razširila ta koncept preko fizičnih meja, saj sem imel tudi sam v preteklosti problem iskanja zanesljivih partnerjev za uresničevanje svojih zamisli. Problem sem videl v relativni majhnosti posameznikovega socialnega kroga, ki zajema predvsem ljudi znotraj njegove glavne panoge.
		Sredi decembra sva se povezala z Blažem, ki je ravno takrat reševal tak problem. Skupaj sva pričela razvijati koncept ideje, ko se nama je pridružil tudi tretji član z istim problemom, ki trenutno ni več aktiven. 
		Do konca februarja smo koncept pripeljali tako daleč, da smo ga na Sedi 5 v Kinu Šiška tudi predstavili. Pozitiven odziv poslušalcev nas je motiviral, da smo se odločili, da projekt tudi realiziramo. Po predstavitvi se nam je pridružil tudi Jure in v začetku marca smo se lotili realizacije.'); ?>
      
		</p> 
		
    </div>

    <div class="large-4 columns">
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </div>
    
  </div>
  
</div>


<div class="row">
	<div class="  columns edit-header">
    <div class="edit-floater">
			<a href="#" class="button small radius success" onclick="contact(this);"><?php echo Yii::t('app','Contact us'); ?></a>
    </div>		
		<h1><?php echo Yii::t('app','Who is behind cofinder'); ?></h1>
  </div>
  <div class="  columns panel edit-content">
    <div class="large-5  columns">
      <img id="team_image" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg" alt="cofinder team" title="cofinder team">
      <div style="top:30px;left:70px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')"></div>
      <div style="top:200px;left:90px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')"></div>
      <div style="top:100px;left:240px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')"></div>
    </div>
    <div class="large-7  columns">
      <h4 onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')">Žiga Berce</h4>
      <p id="team_desc_zb" onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')">
     <?php echo Yii::t('msg',"
      Within cofinder I take care of development while motivating the team and trying my hardest to engage others to join our project. Too much ideas and not enough time forced me to commit only to projects I really love, like making my own surfboard and bike, building websites or organizing social tournaments. Remaining time I spend on outdoor sports.
      <br />Since the only constant in life are changes it is important not to fall asleep on past successes or to give up at the first problems. Tomorrow is a new day, even at cofinder."); ?>
      </p>
    	<h4 onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')">Blaž Beuermann</h4>
      <p id="team_desc_bb" onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')">
      <?php echo Yii::t('msg',"My designation at cofinder.eu is to take care of our online foundations, otherwise I’m a creative with a wide span of expertise, given to me by curiousity. From previous startup experience I am aware of the importance of a team, but what also brought me here is the desire to solve wider societal issues. The dark skies of current economies needs hope. As a human I enjoy other people’s company, a bike ride, a cruise with my board, or a search of a new hidden place in nature."); ?>
      </p>
      <h4 onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')">Jure Ravlič</h4>
      <p id="team_desc_jr" onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')">
        <?php echo Yii::t('msg',"Hi! My name is Jure Ravlič and I come from Ljubljana (Slovenia). I've been interested in building things from the very young age. After elementary I applied for design school and passed all entry tests, but in the end decided for a classic program. Nevertheless, I kept my interest in creativity trough drawing and lettering. As the popularity of internet expanded, I figured that it would be pretty awesome to apply my skills to the web, so I started learning, Photoshop, HTML, CSS, Javascript and PHP. My early websites weren't much, but ever since I got my first W3C validation badge (which i thought was the most awesome thing at the time) I never looked back.
        When not working/learning, I usually go to Lindy hop, 6-count swing partys at Caffee Union and SEM. I also like playing basketball and occasional hiking and sport climbing."); ?>
      </p>
    </div>
  </div>
</div>

<div class="row">
	<div class="  columns edit-header">
		<h1><?php echo Yii::t('app','Our supporters'); ?></h1>
	</div>
  <div class="  columns panel edit-content">
  </div>
</div>

