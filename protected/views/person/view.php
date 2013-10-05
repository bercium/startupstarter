<?php
/* @var $this SiteController */
$this->pageTitle = "";
$user = $data['user'];
?>


<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
  <div class="contact-form">
    
 <?php
 if (Yii::app()->user->isGuest) echo Yii::t('msg','You must be loged in to contact this person.'); 
 else { ?>    
    
  <?php echo CHtml::beginForm(Yii::app()->createUrl("person/contact",array("id"=>$user['id'])),'post',array("class"=>"custom")); ?>

      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message') ?>
      <br />
      <div class="login-floater">
      <?php echo CHtml::submitButton(Yii::t("app","Send"),array("class"=>"button small radius")); ?>
      </div>

  <?php echo CHtml::endForm();
    }
  ?>
      
  </div>
</div>

<div class="row person-details">
	
	
   		<div class="large-3 columns radius panel card-person">
		<div class="card-person-title">
		<img class="card-avatar" src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />
		<h1><?php echo $user['name'] . " " . $user['surname']; ?></h1>
		</div>
		<p>
					
						<span class="icon-map-marker"></span>
						<small class="meta">
						<?php echo $user['address']; ?></small><br />
						
						<?php if ($user['city'] || $user['country']) { ?>
						
						<strong>
							<small class="" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'], $user['address']); ?>'>">

								<?php
								echo $user['city'];
								if ($user['city'] && $user['country'])
									echo ', ';
								echo $user['country'];
								?>
							<?php //echo $user['address'];  ?>
							</small>	
							<br />
        <?php } ?>

					</strong>
					<span class="icon-user"></span>
					<small class="meta"><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
						<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></small>
				</p>

		<?php if (count($user['link']) > 0) { ?>
		

		<!-- <p class="meta-field"><?php // echo Yii::t('app', 'My links') ?>:</p> -->
		<?php 
		foreach ($user['link'] as $link) {
		?>
		<p><span class="icon-external-link"></span>
      
      <small class="meta"><a href="<?php echo "http://".$link['url']; ?>" target="_blank">
      <img src="<?php echo getLinkIcon($link['url']); ?>">
      <?php echo $link['title']; ?>  </a></small>
    </p><?php 
		}
		?>

		<?php } ?>
				<div class="card-floater large-12">
					<a class="button success large-12 radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact me') ?></a>
  			</div>
	</div>

	<div class="large-9 columns">

	<div class="large-12 columns radius panel card-person">
		<div class="skills"  >
		
		<h3 class="card-person-title">
		<?php	echo Yii::t('app', 'Skilled in');?>:
		</h3
		<p class="meta-field">

		<?php 
		foreach ($user['skillset'] as $skillset){
		//echo "<br />".$skillset['skillset']." with skills in<br />";
		foreach ($skillset['skill'] as $skill){
		?>
		<span class="label radius success-alt meta_tags" data-tooltip title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>
		<?php
		}
		}

		/*foreach ($user['skill'] as $skill) {
		?>
		</span>
		<span class="button tiny secondary meta_tags" data-tooltip title="<?php echo $skill['skillset']; ?>"><?php echo $skill['skill']; ?></span>
		<?php
		}*/
		?>

		</p>
		</div>

		<?php if(Yii::app()->user->hasFlash('contactPersonMessage')){ ?>
		<div data-alert class="alert-box radius success">
		<?php echo Yii::app()->user->getFlash('contactPersonMessage'); ?>
		<a href="#" class="close">&times;</a>
		</div>
		<?php } ?> 
		<?php if(Yii::app()->user->hasFlash('contactPersonError')){ ?>
		<div data-alert class="alert-box radius alert">
		<?php echo Yii::app()->user->getFlash('contactPersonError'); ?>
		<a href="#" class="close">&times;</a>
		</div>
		<?php } ?>       

		<div class="columns" >
		<?php if (Yii::app()->user->id == $user['id']) { ?>
		<a class="edit-profile" href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo Yii::t('app', 'Edit profile') ?></a>
		<?php } ?>


		</div>

	</div>
	
	<div class="large-6 columns radius panel card-person"  >				
		
		<?php if (count($user['collabpref']) > 0) { ?>

		
			<h3 class="card-person-title">
		<?php echo Yii::t('app', 'Collaboration') ?>:</p>
		</h3>
		<p class="meta-field">
		<p class="meta">
		<?php
		$firsttime = true;
		if (is_array($user['collabpref']))
		foreach ($user['collabpref'] as $collab) {
		if (!$collab['active']) continue;
		if (!$firsttime)
		echo ", ";
		$firsttime = false;
		echo $collab['name'];
		}
		?>
		</p>
		<?php } ?>	
	</div>

	<div class="large-6 columns radius panel card-person lbf1"  >				
		
		<?php if ($user['available_name']) { ?>
		
			<h3 class="card-person-title">
			<?php echo Yii::t('app', 'Available') ?>:
		</h3>
			<p class="meta-field">
		<p class="meta"><?php echo $user['available_name']; ?></p>
		</p>
		<?php } ?>
		
	</div>



			
	<div class="large-12 columns radius panel card-person"  >
		<?php if (count($user['idea']) > 0) { ?>
			<h3 class="card-person-title">
		<?php echo Yii::t('app', 'Involved in {n} project|Involved in {n} projects', array(count($user['idea']))) ?>:</p>
		</h3>
		<p class="meta-field">
		<?php
		if (is_array($user['idea']))
		foreach ($user['idea'] as $idea_data) {
		?><div class="idea-list"><p><a class="" href="<?php echo Yii::app()->createUrl("project/" . $idea_data['id']); ?>"><span class="icon-lightbulb"></span><?php echo $idea_data['title']; ?></a></p></div><?php 
		}
		?>
		<?php } ?>
	</div> 


	<div class="large-12 columns radius panel card-person"  >
		
			<h3 class="card-person-title">
		Nekaj o meni:
		</h3>
		<p class="meta-field">
			Pri cofinderju skrbim za motivacijo ekipe in nemoten razvoj. Trudim pa se k sodelovanju privabiti čimveč ljudi. 
			Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja.
		</p>
	</div>   

	</div>  
			

</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
