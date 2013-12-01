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
    
  <?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact"),'post',array("class"=>"custom")); ?>
      <?php echo CHtml::hiddenField("user",$user['id']); ?>
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

<div class="row person-details card-person panel radius" style="margin-top:50px; padding-top: 35px; padding-bottom:60px;">
	<div class="large-12 columns">

			<?php if (Yii::app()->user->id == $user['id']) { ?>
			<a class="button tiny  radius secondary edit-profile right" href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo Yii::t('app', 'Edit profile') ?><span class="ico-awesome icon-wrench"></span></a>
			<?php } ?>

		</div>
	
   		<div class="large-3 columns profile ">
		<div class="edit-content-title">
		<img class="card-avatar" src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />
		<h1><?php echo $user['name'] . " " . $user['surname']; ?></h1>
		</div>
		<p>
					
						<?php if ($user['city'] || $user['country'] || $user['address']) { ?>
						
						
				<span class="icon-map-marker ico-awesome"></span>			<small class="meta" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'], $user['address']); ?>'>">
                
                <?php echo $user['address']; ?>
               

								<?php
								echo $user['city'];
								if ($user['city'] && $user['country'])
									echo ', ';
								echo $user['country'];
								?>
							<?php //echo $user['address'];  ?>
							</small>	
							
        <?php } ?>
		</p>
		<p>
					
					<span class="icon-user ico-awesome"></span>
					<small class="meta"><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
						<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></small>
				</p>

		<?php if (count($user['link']) > 0) { ?>
		

		<!-- <p class="meta-field"><?php // echo Yii::t('app', 'My links') ?>:</p> -->
		<?php 
		foreach ($user['link'] as $link) {
		?>
		<p><span class="icon-external-link ico-awesome"></span>
      
      <small class="meta"><a href="<?php echo add_http($link['url']); ?>" target="_blank">
      <img src="<?php echo getLinkIcon($link['url']); ?>">
      <?php echo $link['title']; ?>  </a></small>
    </p><?php 
		}
		?>

		<?php } ?>
		<br>
				<div class="large-12">
					<a class="button success large-12 radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact me') ?></a>
  			</div>
  			
	</div>
	
	<div class="large-8 right person-data">
				
				<div class="skills large-12 columns radius"  >
					<h3 class="edit-content-title"><span class="icon-suitcase ico-awesome"></span>
				<?php	echo Yii::t('app', 'Skilled in');?>:
				</h3>
				
				
				<p class="meta-field">

				<?php 
				foreach ($user['skillset'] as $skillset){
				//echo "<br />".$skillset['skillset']." with skills in<br />";
				foreach ($skillset['skill'] as $skill){
				?>
				<p class="label radius success-alt meta_tags" data-tooltip title='<?php echo $skillset['skillset']; ?>' ><?php echo $skill['skill']; ?></p>


				
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

				<!-- <hr> -->
					<br>
				</div>
				
				<div class="large-6 columns radius available"  >				
					
					<?php if ($user['available_name']) { ?>
					
						<h3 class="edit-content-title">
						<span class="icon-time ico-awesome"></span>	
						<?php echo Yii::t('app', 'Available') ?>:
					</h3>
						<?php echo '<p class=""><span class="icon-angle-right"></span> ' . $user['available_name'] . '</p>'; ?>
					<?php } ?>
					<br>
				</div>

				<div class="large-6 columns radius  collaboration" >				
				
					<?php if (count($user['collabpref']) > 0) { ?>

					<h3 class="edit-content-title">
					<span class="icon-group ico-awesome"></span> <?php echo Yii::t('app', 'Collaboration') ?>:
					</h3>
					<p class="">

					<span class="icon-angle-right"></span>
						
					<?php
					$firsttime = true;
					if (is_array($user['collabpref']))
					foreach ($user['collabpref'] as $collab) {
					if (!$collab['active']) continue;
					if (!$firsttime)
					echo "<br><span class='icon-angle-right'></span> ";
					$firsttime = false;
					echo $collab['name']; 
					}
					?>

					 </p>
					<?php } ?>	
					<br>
				</div>

				
			



			
			
			<div class="large-12 columns radius   about-me"  >

				
					<!-- <hr> -->

					<h3 class="edit-content-title">
				<span class="icon-info ico-awesome"></span> Nekaj o meni:
				</h3>

				<p class="meta-field">
					Pri cofinderju skrbim za motivacijo ekipe in nemoten razvoj. Trudim pa se k sodelovanju privabiti čimveč ljudi. 
					Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja.
				</p>
			 
			
			</div> 
					
			<div class="large-12 columns radius  involved-in "  >
				<!-- <hr> -->

				

				<?php if (count($user['idea']) > 0) { ?>
					<h3 class="edit-content-title"><span class="icon-lightbulb ico-awesome"></span>
				<?php echo Yii::t('app', 'Involved in {n} project|Involved in {n} projects', array(count($user['idea']))) ?>:
				</h3>
				<p class="meta-field">
				<?php
				if (is_array($user['idea']))
				foreach ($user['idea'] as $idea_data) {
				?><div class="idea-list"><p><a class="" href="<?php echo Yii::app()->createUrl("project/" . $idea_data['id']); ?>"><span class="icon-angle-right"></span><?php echo $idea_data['title']; ?></a></p></div><?php 
				}
				?>
				<?php } ?>
			
			</div> 
	
	</div>
			

</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
