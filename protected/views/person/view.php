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
	<?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact",array("id"=>$user['id'])),'post',array("class"=>"custom")); ?>
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
<div class="row wrapped-content ball" style="margin-top:50px; padding-top: 35px; padding-bottom:60px;">


<div class="large-4 columns profile side">
	<div class="edit-content-title">
	<img class="card-avatar" src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />
		<br>
	
	<h1 class=""><?php echo $user['name'] . " " . $user['surname']; ?></h1>

	<div class="">
	<p>
	<?php if ($user['city'] || $user['country'] || $user['address']) { ?>
	<span class="icon-map-marker ico-awesome"></span><a><span class="" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'], $user['address']); ?>'>">
	<?php echo $user['address']; ?>
	<br>
	<?php
	echo $user['city'];
	if ($user['city'] && $user['country'])
	echo ', ';
	echo $user['country'];
	?>
	<?php //echo $user['address'];  ?>
	</span>	</a>
	<?php } ?>
	</p>
	</div>
	</div>



	<div class="item">
	<a class="button contact-me success large large-12 small-12 radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact me') ?></a>
	

	
			
		<p>		
		<?php if ($user['available_name']) { ?>
		<h4 class=""> <?php echo Yii::t('app', 'Available') ?>:</h4>
		<?php echo $user['available_name']; ?>
		<?php } ?>
		</p>
	</div>

	<div class="item">
	<p>
	<h4><?php echo Yii::t('app', 'Registered') ?>:</h4>
	<span class="meta"><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
	<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></span>
	</p>
	</div>

	<?php if (count($user['link']) > 0) { ?>
	
	<!-- <p class="meta-field"><?php // echo Yii::t('app', 'My links') ?>:</p> -->
	<div class="item">
	<?php 
	foreach ($user['link'] as $link) {
	?>
	
	<p><span class="meta"><a href="<?php echo add_http($link['url']); ?>" target="_blank">
	<img class="link-icon" src="<?php echo getLinkIcon($link['url']); ?>">
	<?php echo $link['title']; ?>  </a></span>
	</p>
	<?php 
	}
	?>
	<?php } ?>
	</div>	

		

		</div>
<div class="large-8 right main">
<div class="skills large-12 columns radius"  >
<h3 class="edit-content-title">
<?php	echo Yii::t('app', 'Skilled in');?>:
</h3>

<?php 
foreach ($user['skillset'] as $skillset){
//echo "<br />".$skillset['skillset']." with skills in<br />";
foreach ($skillset['skill'] as $skill){
?>


<span data-alert class="label radius profile-skills" id="skill_<?php echo $skill['id']; ?>">
<?php echo $skill['skill']."<small class='skill-industry'>".$skillset['skillset']."</small>"; ?>
</span>




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

<!-- <hr> -->
<br>
<br>
</div>

<div class="large-12 columns radius  collaboration" >				
<?php if (count($user['collabpref']) > 0) { ?>


<?php echo "<h3 class='edit-content-title'>" . Yii::t('app', 'Collaboration') . ':</h3>' ?>



		<?php
		$firsttime = true;
		if (is_array($user['collabpref'])) ?>

		<?php
		foreach ($user['collabpref'] as $collab) {
		if (!$collab['active']) continue;
		if (!$firsttime)
		echo "";
		$firsttime = false;?>

		<?php echo '<span class="label secondary radius small disabled">' .  $collab['name'] . "</span>"; 
		}
		?>

<?php } ?>	
<br>
<br>
</div>
<div class="large-12 columns radius   about-me"  >
<br>
<!-- <hr> -->
	
		
	
		<h3 class="edit-content-title">
		Nekaj o meni:
		</h3>
		<p class="meta-field">
		Pri cofinderju skrbim za motivacijo ekipe in nemoten razvoj. Trudim pa se k sodelovanju privabiti čimveč ljudi. 
		Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja.
		</p>
	 
</div> 
<div class="large-12 columns radius  involved-in "  >
<!-- <hr> -->
<?php if (count($user['idea']) > 0) { ?>
<h3 class="edit-content-title">
<?php echo Yii::t('app', 'Involved in {n} project|Involved in {n} projects', array(count($user['idea']))) ?>:
</h3>
<p class="meta-field">
<?php
if (is_array($user['idea']))
foreach ($user['idea'] as $idea_data) {
?><div class="idea-list radius panel"><p><a class="" href="<?php echo Yii::app()->createUrl("project/" . $idea_data['id']); ?>"><span class="icon-angle-right"></span> <?php echo $idea_data['title']; ?></a></p></div><?php 
}
?>
<?php } ?>
</div> 
</div>
</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
