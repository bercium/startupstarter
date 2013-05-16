<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
$user = $data['user'];
?>
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
					<a class="button success radius" style="margin-bottom:0;" href=""><?php echo Yii::t('app', 'Contact me') ?></a>
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
