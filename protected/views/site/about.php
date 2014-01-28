<?php
	$this->pageTitle = Yii::t('app','About us');
?>


<div class="row about" style="margin-top:50px;">
  <div class="columns">
	
  <div class="columns main ball wrapped-content">
   
   <div class="large-7  columns">
    <h1><?php echo Yii::t('app','What is cofinder'); ?></h1>

		<p>
		<?php 
			echo Yii::t('cont','We are a group of enthusiasts with a mission to help anyone with a great idea to assemble a successful start-up team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the like-minded entrepreneurs and search for interesting projects.');
		?>
		</p>
	
		
		<h2><?php echo Yii::t('app','Brief history'); ?></h2>
		<p>
      <?php echo Yii::t('cont',"The idea was born during the conversation that took place in October, 2012 at PopUp home. Talking to one of the founders of Slovenia co-working made me realise that the concept of co-working could be introduced to a broader community by the online platform. It would help solve a problem of finding the right team to build new products and services. Blaž joined me in the middle of December. He has been facing the same problem, a difficulty finding a reliable team outside his social circles. Soon after that, the third member joined our team. At the end of February, 2013 we developed and presented our concept to Slovenia\'s co-working community. A positive feedback gave us more than enough motivation to proceed with the development of the web platform. The forth member joined our team and the development process soon after that presentation"); ?>
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
              <p><a href="<?php echo Yii::app()->createUrl("person",array('id'=>1)); ?>"><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-ziga.jpg" alt="Žiga Berce" title="Žiga Berce"></a>
                </p>
            </div>
            <div class="small-8 columns">
              <h3><a href="<?php echo Yii::app()->createUrl("person",array('id'=>1)); ?>">Žiga Berce</a></h3>
              <p>
                <?php echo Yii::t('msg',"I take care of the development, motivate the team and engage others to join our projects."); ?>
              </p>
            </div>
          </div>
        </li>
        
        <li>        
          <div class="row">
            <div class="small-4 columns">
              <p><a href="<?php echo Yii::app()->createUrl("person",array('id'=>4)); ?>"><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-blaz.jpg" alt="Blaž Beuermann" title="Blaž Beuermann"></a>
                </p>
            </div>
            <div class="small-8 columns">
              <h3><a href="<?php echo Yii::app()->createUrl("person",array('id'=>4)); ?>">Blaž Beuermann</a></h3>
              <p>
                <?php echo Yii::t('msg',"My task at Cofinder is to take care of our online foundations."); ?>
              </p>
            </div>
          </div>
        </li>
        
        
        <li>
          <div class="row">
          <div class="small-4 columns">
            <p><a href="<?php echo Yii::app()->createUrl("person",array('id'=>6)); ?>"><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jure.jpg" alt="Jure Ravlič" title="Jure Ravlič"></a>
              </p>
          </div>
          <div class="small-8 columns">
            <h3><a href="<?php echo Yii::app()->createUrl("person",array('id'=>6)); ?>">Jure Ravlič</a></h3>
            <p>
              <?php echo Yii::t('msg',"My primal focus on Cofinder is to take care of the entire design."); ?>
            </p>
          </div>
        </div>  
        </li>
        
        
        <li>
        <div class="row">
          <div class="small-4 columns">
            <p><a href="<?php echo Yii::app()->createUrl("person",array('id'=>10)); ?>"><img class="th" src="<?php echo Yii::app()->request->baseUrl; ?>/images/team/team-jernejm.jpg" alt="Jernej Mirt" title="Jernej Mirt"></a>
              </p>
          </div>
          <div class="small-8 columns">
            <h3><a href="<?php echo Yii::app()->createUrl("person",array('id'=>10)); ?>">Jernej Mirt</a></h3>
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
      
    

       <p>
         <a href="http://coworking.si/" target="_blank">
           <img class="supporters" src="<?php echo Yii::app()->request->baseUrl; ?>/images/supporters/slovenia_coworking.png" title="Slovenia coworking" data-tooltip>
         </a>
         
         <a href="http://www.coinvest.si/" target="_blank">
           <img class="supporters" src="<?php echo Yii::app()->request->baseUrl; ?>/images/supporters/coinvest.png" title="Coinvest" data-tooltip>
         </a>
         
         <a href="http://mladipodjetnik.si" target="_blank">
           <img class="supporters" src="<?php echo Yii::app()->request->baseUrl; ?>/images/supporters/mladi_podjetnik.png" title="Mladi podjetnik" data-tooltip>
         </a>
         
         <a href="http://www.ustvarjalnik.org/" target="_blank">
           <img class="supporters" src="<?php echo Yii::app()->request->baseUrl; ?>/images/supporters/ustvarjalnik.png" title="Ustvarjalnik" data-tooltip>
         </a>
         
         <a href="http://hekovnik.com/" target="_blank">
           <img class="supporters" src="<?php echo Yii::app()->request->baseUrl; ?>/images/supporters/hekovnik.png" title="Hekovnik - startup school" data-tooltip>
         </a>         
       </p>
       
  </div>
     
  </div>
  
   </div>
</div>



	


