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
	<div class="large-12 small-12 columns radius panel card-person">
   
		<div class="row card-person-title">

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
			

  			<div class="card-floater">
					<a class="button success radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact me') ?></a>
  			</div>

				<img src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />
				<h1><?php echo $user['name'] . " " . $user['surname']; ?></h1>
				<p>
					<small class="meta">
						<?php echo $user['address']; ?></small><br />
					<strong><span class="icon-map-marker"></span>
						<?php if ($user['city'] || $user['country']) { ?>
							<small class="" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'], $user['address']); ?>'>">

								<?php
								echo $user['city'];
								if ($user['city'] && $user['country'])
									echo ', ';
								echo $user['country'];
								?>
							<?php //echo $user['address'];  ?>
							</small>
        <?php } ?>

					</strong><br />
					<small class="meta"><?php echo Yii::t('app', 'Member since') ?>: 
						<a><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></a></small>
				</p>
				

			</div>
		</div>

		<div  class="row">


			<div class="large-12 small-12 columns skills"  >
						<p class="meta-field">
					<?php	echo Yii::t('app', 'Skilled in');?>:
          
          <?php 
          foreach ($user['skillset'] as $skillset){
            //echo "<br /><a>".$skillset['skillset']."</a> with skills in<br />";
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

				<div class="large-4 small-12 columns"  >
				
			
					
				
					<?php if (count($user['collabpref']) > 0) { ?>
					
						<p class="meta-field">
							<?php echo Yii::t('app', 'Collaboration') ?>:</p>
							 <p class="meta">
							<?php
							$firsttime = true;
							if (is_array($user['collabpref']))
								foreach ($user['collabpref'] as $collab) {
									if (!$firsttime)
										echo ", ";
									$firsttime = false;
									echo $collab['name'];
								}
							?>
						</p>
						
				<?php } ?>

				<hr>
					
					<?php if ($user['available_name']) { ?>
					<p class="meta-field"><?php echo Yii::t('app', 'Available') ?>:</p>
					<p class="meta"><?php echo $user['available_name']; ?></p>
					
			   		<?php } ?>
				
			
				<?php if (count($user['link']) > 0) { ?>
				<hr>
					<p class="meta-field"><?php echo Yii::t('app', 'My links') ?>:</p>
						<?php 
						foreach ($user['link'] as $link) {
						 ?>
							<p><a href="<?php echo "http://".$link['url']; ?>" target="_blank"><?php echo $link['title']; ?> <span class="icon-external-link"></span> </a></p><?php 
							}
						?>
					
				<?php } ?>

			</div>
			
			<div class="large-6 small-12 column "  >
				<?php if (count($user['num_of_rows']) > 0) { ?>
				<p class="meta-field"><?php echo Yii::t('app', 'Involved in') ?><?php echo Yii::t('app', '{n} project|{n} projects', array($user['num_of_rows'])) ?>:</p>
				
				<?php
				if (is_array($user['idea']))
					foreach ($user['idea'] as $idea_data) {
						 ?><div class="idea-list"><p><a class="" href="<?php echo Yii::app()->createUrl("project/" . $idea_data['id']); ?>"><span class="icon-lightbulb"></span><?php echo $idea_data['title']; ?></a></p></div><?php 
					}
				?>
				<?php } ?>
			</div>    
		</div>

	</div>
</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
