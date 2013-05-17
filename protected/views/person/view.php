<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$user = $data['user'];
?>


<div id="drop-msg" class="f-dropdown content" data-dropdown-content>
  <div class="msg-form">
  <?php echo CHtml::beginForm(Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]),'post',array("class"=>"custom")); ?>

      <?php echo CHtml::label(Yii::t('app','Email').":",'UserLogin_email'); ?>
      <?php echo CHtml::textField('UserLogin[email]') ?>

      <?php echo CHtml::label(Yii::t('app','Password').":",'UserLogin_password'); ?>
      <?php echo CHtml::passwordField('UserLogin[password]') ?>

      <div class="login-floater">
      <?php echo CHtml::submitButton(Yii::t("app","Login"),array("class"=>"button small radius")); ?>
      </div>

      <label for="UserLogin_rememberMe"><?php echo CHtml::checkBox('UserLogin[rememberMe]',true); ?>
      <?php echo Yii::t('app','Remember me'); ?></label>

      <br />
      <?php //echo CHtml::link(Yii::t("app","Register"),Yii::app()->getModule('user')->registrationUrl); ?> 
      <small><?php echo CHtml::link(Yii::t("app","Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?></small>

  <?php echo CHtml::endForm(); ?>
  </div>
</div>



<div class="row person-details">
	<div class="large-12 small-12 columns radius panel card-person">

		<div class="row card-person-title">
			<div class="large-10 small-12 columns" >
				<?php if (Yii::app()->user->id == $user['id']) { ?>
					<div class="card-floater">
						<a style="" href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo Yii::t('app', 'Edit profile') ?></a>
					</div>
				<?php } ?>

				<img src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" style="height:100px; margin-right: 10px; float:left;" />
				<h1><?php echo $user['name'] . " " . $user['surname']; ?></h1>
				<p>
					<small class="meta">
						<?php echo $user['address']; ?></small><br />
					<strong><span class="foundicon-location general meta"></span>
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
			<div class="large-2 small-12 columns card-floater">
					<a class="button success radius" href="#" <?php 
                if (Yii::app()->user->isGuest){ 
                echo "onclick=\"alert('".Yii::t('msg','You must be loged in to contact this person.')."');\""; 
                }else {
                  echo 'data-dropdown="drop-msg"';
                } ?> ><?php echo Yii::t('app', 'Contact me') ?></a>
				</div>
		</div>

		<div  class="row">
			<div class="large-4 small-12 columns"  >
				<p class="meta">
					<span class="meta-field">
					<?php
					echo Yii::t('app', 'Skilled in') . ":";

					foreach ($user['skill'] as $skill) {
						?>
					</span>
						<span class="button tiny secondary meta_tags" data-tooltip title="<?php echo $skill['skillset']; ?>"><?php echo $skill['skill']; ?></span>
						<?php
					}
					?>
				</p><hr>
					<?php if (count($user['collabpref']) > 0) { ?>
					<p class="meta">
						<span class="meta-field">
							<?php echo Yii::t('app', 'Collaboration') ?>:
						</span>
							 <a>
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
						</a>
					</p><hr>
				<?php } ?>
				<p class="meta">
				<span class="meta-field">
				<?php if ($user['available_name']) { ?>
				<span>
					<span class="meta"><?php echo Yii::t('app', 'Available') ?>: <a><?php echo $user['available_name']; ?></a></span><hr>
				<?php } ?>
				<?php if (count($user['link']) > 0) { ?>
					<span class="meta"><?php echo Yii::t('app', 'My links') ?>: 
						<?php 
						foreach ($user['link'] as $link) {
						 ?>
							<a href="<?php echo "http://".$link['url']; ?>" target="_blank"><?php echo $link['title']; ?></a><br /><?php 
							}
						?>
					</span><br>
				<?php } ?>
			</div>
			
			<div class="large-6 small-12 columns panel"  >
				<?php if (count($user['num_of_rows']) > 0) { ?>
				<p class="meta"><span class="meta-field"><?php echo Yii::t('app', 'Involved in ') ?><a><?php echo Yii::t('app', '{n} project|{n} projects', array($user['num_of_rows'])) ?></a>:</span>
				
				<?php
				if (is_array($user['idea']))
					foreach ($user['idea'] as $idea) {
						 ?><span class="general foundicon-idea alt" ></span><a class="alt" href="<?php echo Yii::app()->createUrl("idea/" . $idea['id']); ?>"><?php echo $idea['title']; ?></a><br><?php 
					}
				?>
				<?php } ?>
			</div>    
		</div>

	</div>
</div>

<?php
Yii::log(arrayLog($idea), CLogger::LEVEL_INFO, 'custom.info.user');
