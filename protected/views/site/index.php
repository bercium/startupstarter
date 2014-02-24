<?php
	$this->pageTitle = ''; // leave this empty
	$this->pageDesc = '';
?>

<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>


<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/suggestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
	var countrySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCountry",array("ajax"=>1)) ?>';
</script>

<?php //if (!Yii::app()->user->getState('fpi')){ ?>

<?php /* if (Yii::app()->user->isGuest){ ?>
<div  class="row" >
  <div class="column hide-for-small">
    <img class="logo image-beta" alt="Invite" title="invite" src="<?php echo Yii::app()->request->baseUrl; ?>/images/invite-<?php echo Yii::app()->getLanguage(); ?>.png" style="position: absolute; top: -4px; right:-10px; z-index: 98;" />
  </div>
</div>
<?php } */ ?>


<?php /* ?>
<div class="m-event">
<?php $imeEventa = 'Sestavi svojo ekipo';?>

	
	<div class="row">
		<div class="columns large-12 mb10">
			<center>			
			<a href="http://www.cofinder.eu/events/sestavi-svojo-ekipo"><img class="" src='<?php echo Yii::app()->request->baseUrl; ?>/images/sestavi-svojo-ekipo-cofinder-event.png'></a>

			</center>
		</div>

	</div>
</div>
<?php //*/ ?>
    
    <?php if (!Yii::app()->user->isGuest){  ?>

<div class="intro mb0 pt0 bb-strong" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
	<div  class="row">
		<div class="mb0 pb10 pt20 columns ">
			

			
			<h1 class="mt10 mb10"><?php echo Yii::t('app','What is new'); ?></h1>
			<?php $this->widget('ext.Invitation.WInvitation'); ?> 

			<ul class="large-block-grid-3">
        <li>
          <div class="small-12">
            
            <div class="pall125em radius-all  whats-new radius fancy-border" style="min-height:203px;">
              <h2><?php echo Yii::t('app', 'Project images'); ?></h2>
              <p>
                <?php echo Yii::t('msg', 'Projects now have images. Please contact us to get more information on how to add it to your project.'); ?>
              </p>
              <?php /* ?><a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="index_click_createProject" class="button small  radius small-12" ><?php echo Yii::t('app','Create your project'); ?> </a>
                <?php */ ?>
            </div>
              
          </div>
        </li>
            
        <li>
          <div class="small-12">

            <div class="pall125em radius-all whats-new radius fancy-border">
              <h2 ><?php echo Yii::t('app', 'Invite friends'); ?></h2>
              <p>
                <?php echo Yii::t('msg', 'Invite team members and friends to Cofinder'); ?>
              </p>
              <a href="<?php echo Yii::app()->createUrl("profile"); ?>" trk="index_click_invite" data-dropdown="drop-invitation-msg" class="button success radius small small-12"><?php echo Yii::t('msg', 'Invite to Cofinder'); ?></a>
            </div>
            
          </div>
        </li>

        <li>
          <div class="small-12">

            <div class="pall125em radius-all  whats-new radius fancy-border">
              <h2><?php echo Yii::t('app','Public profile'); ?></h2>
              <p>
              <?php echo Yii::t('msg','Get your own personal url on Cofinder'); ?>
              </p>

              <a href="<?php echo Yii::app()->createUrl("profile/account"); ?>" trk="index_click_vanityURL" class="button success small radius small-12">www.cofinder.eu/ <?php echo str_replace(".", "", substr(Yii::app()->user->email, 0, strpos(Yii::app()->user->email,"@")) ); ?></a>

            </div>
          </div>
        </li>
			</ul>


			
			
		</div>
	</div>
</div>


<div class="panel-top hide-for-small bb-strong">
	<div class="row">
		<div class="columns">
		
      <div class="large-offset-3 ml20">
      	
      	<h2 class="large-12">

      		<?php if (date('Y.m.d', strtotime(Yii::app()->user->create_at)) == date ('Y.m.d')) {
         echo Yii::t('msg',"{username} Welcome to cofinder!",array('{username}'=>Yii::app()->user->getState('fullname'))); 
        
          } else { 

          	 echo Yii::t('msg',"{username} Welcome Back!",array('{username}'=>Yii::app()->user->getState('fullname'))); 

          }

          	?>
        </h2>	
      	

     
        <a href="<?php echo Yii::app()->createUrl("person/discover"); ?>" trk="index_click_findCofounder" class="button radius success" ><?php echo Yii::t('app','Find a cofounder'); ?></a> 
        <span style="margin:0 13px 0 13px;"> <?php echo Yii::t('app','or'); ?> </span>
        <a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="index_click_createProject" class="button radius" style="margin-right: 0;" ><?php echo Yii::t('app','Create your project'); ?> </a>
        

      
      </div>
      </div>
    </div>
</div>

    
    <?php }else{ ?>

	<div class="intro pb10 bb-strong pt60" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
		
		<div class="row">
					
			<div  class="columns large-8 mb0 pl20">
				<div class="ml40">
					<div class="large-12 columns">				 	
					 	<h2 class="big-text mt20 mb0"><span class="alt-1"><?php echo Yii::t('msg','Work for a Startup'); ?></span></h2>
					 	<h2 class="big-text mb40 mt0"><span class="alt-2"><?php echo Yii::t('msg','or find a cofounder'); ?></span></h2>
					 	<h2 class="mb60"><span class="alt-3"><?php echo Yii::t('msg','Resource of skills & interesting projects'); ?></span></h2>
					</div>	
				 	<div class="large-6 columns">	 							
						<span class="icon-rocket left mr15 mt5"></span>
						<h2 class="alt-4">Startups</h2>					
						<h3 class="call-to mb20"><?php echo Yii::t('msg','Find a talent'); ?></h3>
						<p><?php echo Yii::t('msg','Share what you\'re working on<br />Find people with the right skills'); ?></p>	 				
					</div>
					<div class="large-6 columns"> 					
						<!-- Content if guest -->
						<span class="icon-user left mr15 mt5"></span>
						<h2 class="alt-4">Individuals</h2>						
						<h3 class="call-to mb20"><?php echo Yii::t('msg','Join a project'); ?></h3>
						<p><?php echo Yii::t('msg','Tell us what you\'re good at<br />Get invited to startup'); ?></p>					
					</div>
				</div>
			</div>
			<div class="large-4 columns panel fancy-border radius">
       
				<img class="mt10 ml50 hide-for-small" src='<?php echo Yii::app()->request->baseUrl; ?>/images/logo-big.png'>
				<div class="small-12 large-12 columns">
        <h2 class="alt-5" ><?php echo Yii::t('msg','Sign up for Cofinder'); ?></h2>
				<p><?php echo Yii::t('msg','Create your account, tell us about yourself and start exploring'); ?></p>	
        <a class="button radius large large-12 mb0" href="<?php echo Yii::app()->createUrl("user/registration"); ?>"><?php echo Yii::t('app','Start here'); ?></a>
				<p class="description small-8 small-centered"><?php echo Yii::t('msg','Already have an account?'); ?> <a href="#" data-dropdown="drop-login"><?php echo Yii::t('app','Login here'); ?>.</a></p>		
        </div>       
			</div>

		</div>

		<div  class="row" >  


    <?php /* ?>
   <div class="center columns">
      <div class="right large-5 small-12">
        
        <?php echo CHtml::beginForm(Yii::app()->createUrl("site/notify"),'post',array("style"=>"margin-bottom:0;")); ?>
        
        <h2 style="margin-bottom:5px;">
          <label for="email" style="font-size:1em; font-weight: bold;">
            <?php echo Yii::t('app','Want to get invited?'); ?>
          </label>
        </h2>
        <span class="description">
        <?php echo Yii::t('msg','Leave your email address and we will get back to you.'); ?>
        </span>
        <div class="row collapse">
          <div class="small-9 columns">
            <?php echo CHtml::textField("email") ?>
          </div>
          <div class="small-3 columns">
             <?php echo CHtml::submitButton(Yii::t("app","YES"),array("class"=>"postfix button radius success")); ?>
          </div>
        </div>  

        <?php echo CHtml::endForm(); ?>

      </div>
    </div>
    <?php */ ?>
	</div>
	</div>
	<?php } ?>
    
  
<?php // } ?>



<?php if (!$filter->checkSearchForm()){ ?>


	<?php if (isset($data['idea'])){ ?>
		<div class="row mt40" id="recent_projects">			
			<?php $this->renderPartial('//project/_recent', array('ideas' => $data['idea'],"page"=>1,"maxPage"=>$maxPageIdea)); ?>		  
	  </div>
	<?php } ?>

	<?php if (isset($data['user'])){ ?>
		<div class="row mt40" id="recent_users">
			<?php $this->renderPartial('//person/_recent', array('users' => $data['user'],"page"=>1,"maxPage"=>$maxPagePerson)); ?>			
		</div>

	<?php } 
} ?>




<div class="main-quote">
  
  <div class="row" >
    <div class="columns large-11 large-offset-1">
    	<h2 class=""><?php echo Yii::t('app','What others are saying'); ?></h2>
      
      <ul data-orbit data-options="timer_speed:8000; bullets:false; navigation_arrows:false; resume_on_mouseout:true;">
      <li>  
        <div class="columns pt0 pb0 mt10 large-8 large-centered">
          <span class="icon-quote-left large"></span>
          <?php echo Yii::t('cont','As a yung startup we were looking for specific type of profesionals. We were able to quickly find them with the help of Cofinder.'); ?>
          <span class="icon-quote-right large"></span
          <br />
          <span class="mt40 right l-iblock" >
           <a class="f-bold mt20" href="http://www.cofinder.eu/project/view/9"><?php echo Yii::t('cont','Peter from Biometrics'); ?></a>
          </span>
        </div>
      </li>
      
      <li>
        <div class="columns pt0 pb0 mt10 large-8 large-centered">
          <span class="icon-quote-left large"></span>
          <?php echo Yii::t('cont','After I opened a new position for my project I immediately got contacted by interesting people.'); ?>
          
          <span class="icon-quote-right large"></span
          <br />
          <span class="mt40 right l-iblock">
           <a class="f-bold mt20" href="http://www.cofinder.eu/project/view/32"><?php echo Yii::t('cont','Boštjan from Studio 404'); ?></a>
          </span>
        </div>
      </li>
      
     </ul>
    </div>  
  </div>  
  
</div>
