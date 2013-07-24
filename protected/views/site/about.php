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
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the like minded entrepreneurs and search for interesting projects to join.');
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
    <div class="large-5  columns hide-for-small">
      <img id="team_image" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team.jpg" alt="cofinder team" title="cofinder team">
      <div style="top:30px;left:70px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')"></div>
      <div style="top:200px;left:90px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')"></div>
      <div style="top:100px;left:240px;position:absolute;width:140px;height:140px;" onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')"></div>
    </div>
    <div class="large-7  columns">
      <div class="row" onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')">
        <div class="small-4 columns show-for-small">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-ziga.jpg" alt="Žiga Berce" title="Žiga Berce">
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_zb">Žiga Berce
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/1">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Žiga Berce" title="Žiga Berce">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',"Within cofinder I take care of development while motivating the team and try to engage others to join our project."); ?>
          </p>
        </div>
        
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          <?php echo Yii::t('msg',"The only constant in life is change so it's important not to fall asleep on past successes or to give up at the sight of problems."); ?>
          </blockquote>
        </div>
      </div>
      
      <div class="row" onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')">
        <div class="small-4 columns show-for-small">
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-blaz.jpg" alt="Blaž Beuermann" title="Blaž Beuermann">
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_bb">Blaž Beuermann
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/4">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Blaž Beuermann" title="Blaž Beuermann">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',"My designation at cofinder is to take care of our online foundations."); ?>
          </p>
        </div>
        
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          <?php echo Yii::t('msg',""); ?>
          </blockquote>
        </div>
      </div>
      
      <div class="row" onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')">
        <div class="small-4 columns show-for-small">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jure.jpg" alt="Jure Ravlič" title="Jure Ravlič">
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_jr">Jure Ravlič
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/6">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Jure Ravlič" title="Jure Ravlič">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',"Taking care of overall design is my primary focus here on cofinder."); ?>
          </p>
        </div>
        
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          <?php echo Yii::t('msg',""); ?>
          </blockquote>
        </div>
      </div>

      
      <div class="row">
        <div class="small-4 columns show-for-small">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jureg.jpg" alt="Jure Grahek" title="Jure Grahek" >
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_zb">Jure Grahek
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/5">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Jure Ravlič" title="Jure Grahek">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',""); ?>
          </p>
        </div>
        
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          <?php echo Yii::t('msg',""); ?>
          </blockquote>
        </div>
      </div>
      

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

