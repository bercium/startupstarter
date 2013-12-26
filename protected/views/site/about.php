<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row about" style="margin-top:50px;">
  <div class="columns">
	
  <div class="columns main ball wrapped-content">
   
   <div class="large-7  columns">
    <h1><?php echo Yii::t('app','What is cofinder'); ?></h1>
    <h2><?php echo Yii::t('app','Introduction'); ?></h2>
    
		 
		<p>
		<?php 
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the like minded entrepreneurs, find the right people and search for interesting projects to join.');
		?>
		</p>
	
		
		<h2><?php echo Yii::t('app','Brief history'); ?></h2>
		<p>
      <?php echo Yii::t('msg',"The idea was born during the conversation that happened in October 2012 at PopUp home. Talking to one of the founders of Slovenia coworking made me realise that online platform could open up the concept of coworking to a broader community. It will help solving a problem of finding the right team to build new products and services. In mid December Blaž joined me who’s been facing the same problem. We saw this as an opportunity to take this idea further. Together with the third member, three of us developed and presented our concept to Slovenia's coworking community in late February 2013 the. Positive feedback gave us more than enough motivation to go on with the development of the actual web platform. Soon after our presentation Jure joined the team. In the beginning of March we were already in full motion."); ?>
		</p> 
		
    </div>

    <div class="large-5 columns side">

      <ul class="small-block-grid-1 large-block-grid-1">
        <li>
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </li>
    </div>
  

  </div>

    <div class="columns main ball wrapped-content">


    <div class="columns">
      
    <h1><?php echo Yii::t('app','Who is behind cofinder'); ?></h1>
    
  </div>
  <div class="columns">
          
      <ul class="small-block-grid-1 large-block-grid-2"> 
        <li>
          <div class="row">
            <div class="small-4 columns">
              <p><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-ziga.jpg" alt="Žiga Berce" title="Žiga Berce">
                </p>
            </div>
            <div class="small-8 columns">
              <h3>Žiga Berce</h3>
              <p>
                <?php echo Yii::t('msg',"Within cofinder I take care of development while motivating the team and try to engage others to join our project."); ?>
              </p>
            </div>
          </div>
        </li>
        
        <li>        
          <div class="row">
            <div class="small-4 columns">
              <p><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-blaz.jpg" alt="Blaž Beuermann" title="Blaž Beuermann">
                </p>
            </div>
            <div class="small-8 columns">
              <h3>Blaž Beuermann</h3>
              <p>
                <?php echo Yii::t('msg',"My designation at cofinder is to take care of our online foundations."); ?>
              </p>
            </div>
          </div>
        </li>
        
        
        <li>
          <div class="row">
          <div class="small-4 columns">
            <p><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jure.jpg" alt="Jure Ravlič" title="Jure Ravlič">
              </p>
          </div>
          <div class="small-8 columns">
            <h3>Jure Ravlič</h3>
            <p>
              <?php echo Yii::t('msg',"Taking care of overall design is my primary focus here on cofinder."); ?>
            </p>
          </div>
        </div>  
        </li>
        
        
        <li>
        <div class="row">
          <div class="small-4 columns">
            <p><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jernejm.jpg" alt="Jernej Mirt" title="Jernej Mirt">
              </p>
          </div>
          <div class="small-8 columns">
            <h3>Jernej Mirt</h3>
            <p>
              <?php echo Yii::t('msg',"Managing social marketing."); ?>
            </p>
          </div>
        </div>
        </li>
        
      </ul>

      <a href="#" class="button radius success" onclick="contact(this);"><?php echo Yii::t('app','Contact us'); ?></a>

    <h2><?php echo Yii::t('app',"Others that helped us a lot"); ?></h2>
    <p>Jure Grahek</p>

  </div>  
  
  </div>

   <div class="columns main ball wrapped-content">
    <div class="columns">
      <h1><?php echo Yii::t('app','Supporters'); ?></h1>
      </div>
  </div>
  
   </div>
</div>



	


