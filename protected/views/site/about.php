<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row" style="margin-top:20px;">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','About project'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
   <div class="large-8 small-12 columns">
		 
		<p>
		<?php 
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.');
		?>
		</p>
	
		
		<h4>Brief history</h4>
		<p>
		Ideja se je porodila konec oktobra 2012 na dogodku v PopUp domu. Ob pogovoru z enim izmed ustanovitljev ljubljanskega coworkinga sem prišel na idejo, ki bi razširila ta koncept preko fizičnih meja, saj sem imel tudi sam v preteklosti problem iskanja zanesljivih partnerjev za uresničevanje svojih zamisli. Problem sem videl v relativni majhnosti posameznikovega socialnega kroga, ki zajema predvsem ljudi znotraj njegove glavne panoge.
		Sredi decembra sva se povezala z Blažem, ki je ravno takrat reševal tak problem. Skupaj sva pričela razvijati koncept ideje, ko se nama je pridružil tudi tretji član z istim problemom, ki trenutno ni več aktiven. 
		Do konca februarja smo koncept pripeljali tako daleč, da smo ga na Sedi 5 v Kinu Šiška tudi predstavili. Pozitiven odziv poslušalcev nas je motiviral, da smo se odločili, da projekt tudi realiziramo. Po predstavitvi se nam je pridružil tudi Jure in v začetku marca smo se lotili realizacije. 
		</p> 
		
    </div>

    <div class="large-4 small-12 columns">
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </div>
    
  </div>
  
</div>


<div class="row">
	<div class="small-12 large-12 columns edit-header">
    <div class="edit-floater">
			<a href="#" class="button small radius success" onclick="contact(this);"><?php echo CHtml::encode(Yii::t('app','Contact us')); ?></a>
    </div>		
		<h1><?php echo Yii::t('app','Our team'); ?></h1>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    <div class="large-6 small-12 columns">
      <img id="team_image" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg" alt="coFinder team" title="coFinder team">
    </div>
    <div class="large-6 small-12 columns">
      <h4 onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-zb.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">Žiga Berce</h4>
      <p onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-zb.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">
        
      </p>
    	<h4 onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-bb.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">Blaž Beuermann</h4>
      <p onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-bb.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">
      Raziskujem realnost in ideale; ljudi, sistem, tehnologijo, okolje. Živimo v posebnih časih, znanja in veščine so naša orodja in naša odgovornost. Sledite srcu ter bodite drzni, vključujte soljudi, za skupno dobro. Pri coFinder.eu skrbim za temelje spletne platforme.
      </p>
      <h4 onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-jr.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">Jure Ravlič</h4>
      <p onmouseover="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team-jr.jpg')" onmouseout="$('#team_image').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/team.jpg')">
        Hi! My name is Jure Ravlič and I come from Ljubljana (Slovenia). I've been interested in building things from the very young age. After elementary I applied for design school and passed all entry tests, but in the end decided for a classic program. Nevertheless, I kept my interest in creativity trough drawing and lettering. As the popularity of internet expanded, I figured that it would be pretty awesome to apply my skills to the web, so I started learning, Photoshop, HTML, CSS, Javascript and PHP. My early websites weren't much, but ever since I got my first W3C validation badge (which i thought was the most awesome thing at the time) I never looked back.
        When not working/learning, I usually go to Lindy hop, 6-count swing partys at Caffee Union and SEM. I also like playing basketball and occasional hiking and sport climbing.         
      </p>
    </div>
  </div>
</div>

<div class="row">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','Supporters'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>

