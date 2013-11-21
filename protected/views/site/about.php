<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row about" style="margin-top:20px;">
	
  <div class=" columns ball wrapped-content">
   
   <div class="large-8  columns">
    <h1><?php echo Yii::t('app','What is cofinder'); ?></h1>
    
		 
		<p>
		<?php 
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the like minded entrepreneurs and search for interesting projects to join.');
		?>
		</p>
	
		
		<h4><?php echo Yii::t('app','Brief history'); ?></h4>
		<p>
      <?php echo Yii::t('msg',"The idea was born during the conversation that happened in October 2012 at PopUp home. Talking to one of the founders of Slovenia coworking made me realise that online platform could open up the concept of coworking to a broader community. It will help solving a problem of finding the right team to build new products and services. In mid December Blaž joined me. He's been facing the same problem. It was difficult for him to find a realiable team of people outside his social circles. Soon after the third member joined our team. In late February 2013 the three of us developed and presented our concept to Slovenia's coworking community. Positive feedback gave us more than enough motivation to go on with the development of the web platform. Soon after our presentation the fourth member joined the team and the developement process."); ?>
		</p> 
		
    </div>

    <div class="large-4 columns side">
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </div>
  
  </div>
  
</div>


<div class="row">
	  <div class="columns panel radius wrapped-content">
      
    
    <div class="large-12 columns">
      <h1><?php echo Yii::t('app','Who is behind cofinder'); ?></h1>
      
      <div class="row">
        <div class="large-6 item small-12 columns" onmouseover="showPerson('zb');" onmouseout="hidePerson('zb')">
        <div class="small-4 columns">
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
        
        <?php /* ?>
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          <?php echo Yii::t('msg',"The only constant in life is change so it's important not to fall asleep on past successes or to give up at the sight of problems."); ?>
          </blockquote>
        </div>
        <?php */ ?>
      </div>
      
      <div class="large-6 item small-12 columns" onmouseover="showPerson('bb');" onmouseout="hidePerson('bb')">
        <div class="small-4 columns ">
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
        <?php /* ?>
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          </blockquote>
        </div><?php */ ?>
      </div>
      </div>

      <div class="row">      
      <div class="large-6 item small-12 columns" onmouseover="showPerson('jr');" onmouseout="hidePerson('jr')">
        <div class="small-4 columns ">
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
        <?php /* ?>
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          </blockquote>
        </div><?php */ ?>
      </div>

      
      <div class="large-6 item small-12 columns">
        <div class="small-4 columns ">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jureg.jpg" alt="Jure Grahek" title="Jure Grahek" >
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_jg">Jure Grahek
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/5">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Jure Ravlič" title="Jure Grahek">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',"Helping with the non-technical side of development."); ?>
          </p>
        </div>
        <?php /* ?>
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          </blockquote>
        </div><?php */ ?>
      </div>
      </div>

      <div clasS="row">      
      <div class="large-6 item small-12 columns">
        <div class="small-4 columns ">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jernejm.jpg" alt="Jernej Mirt" title="Jernej Mirt" >
        </div>
        <div class="small-8 large-12 columns">
          <h4 id="team_desc_jm">Jernej Mirt
            <div class="login-floater">
              <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/person/10">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-cofinder.png" alt="Jernej Mirt" title="Jernej Mirt">
              </a>
            </div>
          </h4>
          <p >
            <?php echo Yii::t('msg',"Managing social marketing."); ?>
          </p>
        </div>
        <?php /* ?>
        <div class="columns">
          <blockquote style="font-size: 0.9em">
          </blockquote>
        </div><?php */ ?>
      </div> 
      </div>     
      

    </div>
    <a href="#" class="button small radius success right" onclick="contact(this);"><?php echo Yii::t('app','Contact us'); ?></a>  
  </div>
</div>

<div class="large-6 item small-12 columns">	
  <div class="radius columns panel edit-content">
    <h1><?php echo Yii::t('app','Our supporters'); ?></h1>
  </div>
</div>

