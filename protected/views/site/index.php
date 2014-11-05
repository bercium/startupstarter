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

    
    <?php if (!Yii::app()->user->isGuest){  ?>


<?php //* ?>
<div class="m-event">
	
	<div class="row">
		<div class="columns large-12 mb10">
			<center>			
			<a href="http://www.cofinder.eu/events/sestavi-svojo-ekipo-3" trk="index_event_sse3"><img alt="Sestavi svojo ekipo 3" title="Sestavi svojo ekipo 3" class="" src='<?php echo Yii::app()->request->baseUrl; ?>/images/sestavi-svojo-ekipo-3-cofinder-event.png'></a>

			</center>
		</div>

	</div>
</div>
<?php //*/ 
if($tag->name == 'lepagesta'){
//if($tag != NULL && strlen($tag->title) > 0 && strlen($tag->description) > 0){
  //SHOW TAG CONTENT IF LEPAGESTA (REMAKE SOON)
?>

<div class="intro mb0 pt0 bb-strong" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
	<div  class="row">
		<div class="mb0 pb10 pt20 columns ">
			

			
			<h1 class="mt40 mb10"><?php //echo Yii::t('app','What is new'); ?></h1>
			<?php $this->widget('ext.Invitation.WInvitation'); ?> 

			<ul class="large-block-grid-3">
        <li>
          <div class="small-12">
            
            <div class="pall125em radius-all  whats-new radius fancy-border" style="min-height:203px;">
                <h2>Kaj je "lepa gesta"?</h2>
                <p>
                  Staljeno sredico oblikujemo iz vaših lepih gest. Definicijo bomo poslali v črno luknjo, da se zlije z vesoljem.
                </p>
                <br/>
                  <a class=" radius small small-12" trk="index_click_suggested" href="http://lepagesta.org">lepagesta.org</a>

              <?php /* ?><a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="index_click_createProject" class="button small  radius small-12" ><?php echo Yii::t('app','Create your project'); ?> </a>
                <?php */ ?>
            </div>
              
          </div>
        </li>
            
        <li>
          <div class="small-12">

            <div class="pall125em radius-all whats-new radius fancy-border" style="min-height:203px;">
              <h2>Naredi lepo gesto</h2>
              <p>
                Prispevaj svetu svojo energijo, znanja in ideje z dobrim namenom, s svojim projektom ali s pomočjo že obstoječemu.
              </p>
              <br/>
                <a class=" radius small small-12" trk="index_click_suggested" href="<?php echo Yii::app()->createUrl("project/create"); ?>">Prijavi projekt in ti povej</a>
              
            </div>
            
          </div>
        </li>

        <li>
          <div class="small-12">

            <div class="pall125em radius-all  whats-new radius fancy-border" style="min-height:203px;">
              <h2>Lepe geste sem pa tja</h2>
              <p>
              Mreža pomaga pri dobrem namenu. Iskanje ekipe, financiranja, pro-bono marketing, freelance dela, izobraževanja.
              </p>
              <br/>
                <a class=" radius small small-12" href="<?php echo Yii::app()->createUrl("project/create"); ?>">Prijavi podporno storitev v mrežo</a>

            </div>
          </div>
        </li>
			</ul>

			
		</div>
	</div>
</div>
<?php } else { 
  //SHOW COFINDER NEWS BOXES ?>


<div class="intro mb0 pt0 bb-strong" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
  <div  class="row">
    <div class="mb0 pb10 pt20 columns ">
      

      
      <h1 class="mt40 mb10"><?php //echo Yii::t('app','What is new'); ?></h1>
      <?php $this->widget('ext.Invitation.WInvitation'); ?> 

      <ul class="large-block-grid-3">
        <li>
          <div class="small-12">
            
            <div class="pall125em radius-all  whats-new radius fancy-border" style="min-height:203px;">
              <h2><?php echo Yii::t('app', 'Tailored results'); ?></h2>
              <p>
                <?php echo Yii::t('msg', 'We now give you suggestions based on your profile.'); ?>
              </p>
                <a class=" radius small small-12" trk="index_click_suggested" href="?suggested=1"><?php echo Yii::t('app','Switch to suggested'); ?></a>
              
              <?php /* ?><a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="index_click_createProject" class="button small  radius small-12" ><?php echo Yii::t('app','Create your project'); ?> </a>
                <?php */ ?>
            </div>
              
          </div>
        </li>
            
        <li>
          <div class="small-12">

            <div class="pall125em radius-all whats-new radius fancy-border" style="min-height:203px;">
              <?php if ($event['today']){ ?>
                <h2 ><?php echo Yii::t('app', 'What is happening'); ?></h2>
                <p>
                  <?php echo trim_text($event['today']->title, 80); ?>
                </p>
              <?php }elseif($event['next']){ ?>
                <h2 ><?php echo Yii::t('app', 'Upcoming event'); ?></h2>
                <p>
                  <?php echo trim_text($event['next']->title, 80); ?>
                </p>
              <?php } else { ?>
              <h2><?php echo Yii::t('app', 'Currently no events'); ?></h2>
              <?php } ?> 
              <br />
              <a href="<?php echo Yii::app()->createUrl("site/startupEvents"); ?>" trk="index_click_events" class=" radius small small-12"><?php echo Yii::t('app', 'Find your local events'); ?></a>
            </div>
            
          </div>
        </li>

        <li>
          <div class="small-12">

            <div class="pall125em radius-all  whats-new radius fancy-border" style="min-height:203px;">
              <h2><?php echo Yii::t('app','Public profile'); ?></h2>
              <p>
              <?php echo Yii::t('msg','Get your own personal url on Cofinder'); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </p>

              <a href="<?php echo Yii::app()->createUrl("profile/account"); ?>" trk="index_click_vanityURL" class=" success small radius small-12">www.cofinder.eu/ <?php echo str_replace(".", "", substr(Yii::app()->user->email, 0, strpos(Yii::app()->user->email,"@")) ); ?></a>

            </div>
          </div>
        </li>
      </ul>

      
    </div>
  </div>
</div>
<?php } ?>


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
        <a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="index_click_createProject" class="button radius secondary" style="margin-right: 0;" ><?php echo Yii::t('app','Create your project'); ?> </a>
        

      
      </div>
      </div>
    </div>
</div>

    
    <?php }else{ ?>

<script>
  var hideTopBar = true;
</script>

 <?php /* ?>	<div class="intro pb10 bb-strong pt60" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
 <?php */?>

	<div class="intro intro-logout mb0 bb-strong pt60" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
		
		<div class="row">
					
			<div  class="columns large-8 mb0 pl20">
				<div class="">
					<div class="large-12 columns">
					 	<h1 class="big-text mb40 mt20 text-center page-title"><?php echo Yii::t('msg','Helping you assemble <div>a startup team</div>'); ?></h1>
					 	<h2 class="mb60"><span class="alt-3" style="width:100%"><?php echo Yii::t('msg','{n}+ projects looking for a cofounder',array("{n}"=>$numOfProjects)); ?></span></h2>
					</div>	
				 	<div class="large-6 columns">
						<span class="icon-rocket left mr15 mt5"></span>
						<h2 class="alt-4"><?php echo Yii::t('app','Startups'); ?></h2>					
						<h3 class="call-to mb20"><?php echo Yii::t('msg','Find talent'); ?></h3>
						<p><?php echo Yii::t('msg','Pitch your project and find the right people'); ?></p>	 				
					</div>
					<div class="large-6 columns">
						<!-- Content if guest -->
						<span class="icon-user left mr15 mt5"></span>
						<h2 class="alt-4"><?php echo Yii::t('app','Individuals'); ?></h2>						
						<h3 class="call-to mb20"><?php echo Yii::t('msg','Join a project'); ?></h3>
						<p><?php echo Yii::t('msg','Show off your skills and join a startup'); ?></p>					
					</div>
				</div>
			</div>
			<div class="large-4 columns panel fancy-border radius">
       
				<img class="mt10 ml50 hide-for-small" src='<?php echo Yii::app()->request->baseUrl; ?>/images/logo-big.png'>
				<div class="small-12 large-12 columns">
        <h2 class="alt-5" ><?php echo Yii::t('msg','Sign up for Cofinder'); ?></h2>
				<p><?php //echo Yii::t('msg','Create your account, tell us about yourself and start exploring'); ?></p>	
        <a class="button radius large large-12 mb0" href="<?php echo Yii::app()->createUrl("user/registration"); ?>"><?php echo Yii::t('app','Start here'); ?></a>
				<p class="description small-12 small-centered"><?php echo Yii::t('msg','Already have an account?'); ?> 
          <a href="#" data-dropdown="drop-login"><?php echo Yii::t('app','Login here'); ?></a>
        </p>		
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



<?php //* ?>
<div class="m-event mb40">
	
	<div class="row">
		<div class="columns large-12 mb10">
			<center>			
			<a href="http://www.cofinder.eu/events/sestavi-svojo-ekipo-3" trk="index_event_sse3"><img alt="Sestavi svojo ekipo 3" title="Sestavi svojo ekipo 3" class="" src='<?php echo Yii::app()->request->baseUrl; ?>/images/sestavi-svojo-ekipo-3-cofinder-event.png'></a>

			</center>
		</div>

	</div>
</div>
<?php //*/ ?>
	<?php } ?>
    
  
<?php // } ?>



<?php //if (!$filter->checkSearchForm()){ ?>


	<?php if (isset($data['idea'])){ ?>
		<div class="row mt40" id="recent_projects">			
			<?php $this->renderPartial('//project/_recent', array('ideas' => $data['idea'],"page"=>1,"maxPage"=>$maxPageIdea,"ideaType"=>$ideaType)); ?>		  
	  </div>
	<?php } ?>

	<?php if (isset($data['user'])){ ?>
		<div class="row mt40" id="recent_users">
			<?php $this->renderPartial('//person/_recent', array('users' => $data['user'],"page"=>1,"maxPage"=>$maxPagePerson, "userType"=>$userType)); ?>			
		</div>

	<?php } 
//} ?>


<div class="main-quote">
  
  <div class="row" >
    <div class="columns large-11 large-offset-1">
    	<h2 class=""><?php echo Yii::t('app','What others are saying'); ?></h2>
      
      <ul data-orbit data-options="timer_speed:8000; bullets:false; navigation_arrows:false; resume_on_mouseout:true;">
        
      <li>
        <div class="columns pt0 pb0 mt10 large-8 large-centered">
          <span class="icon-quote-left large"></span>
          <?php echo Yii::t('cont','Cofinder events are a very effective way to get connected to the right people.'); ?>

          <span class="icon-quote-right large"></span
          <br />
          <span class="mt40 right l-iblock">
           <a class="f-bold mt20" href="http://www.cofinder.eu/project/view/35"><?php echo Yii::t('cont','Andraž from 3FS'); ?></a>
          </span>
        </div>
      </li>        
        
      <li>
        <div class="columns pt0 pb0 mt10 large-8 large-centered">
          <span class="icon-quote-left large"></span>
          <?php echo Yii::t('cont','As a young startup we were looking for specific type of profesionals. We were able to find them quickly with the help of Cofinder.'); ?>
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
