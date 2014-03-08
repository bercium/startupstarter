<?php
  $this->pageTitle = Yii::t('app', 'Login');
?>

	<?php echo CHtml::beginForm('','post',array('class'=>"custom large-6 small-12")); ?>

	<?php echo CHtml::errorSummary($model,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
	
<p>
  <?php echo Yii::t('msg','You need to write your credentials only once. '); ?>
  <br />
  <strong>
  <?php echo Yii::t('msg','Next time you will be loged in automaticaly!'); ?>
  </strong>
</p>

  <?php echo CHtml::label(Yii::t('app','Email'),'LoginForm_email'); ?>
	<?php echo CHtml::activeTextField($model, 'username') ?>

  <?php echo CHtml::label(Yii::t('app','Password'),'LoginForm_password'); ?>
	<?php echo CHtml::activePasswordField($model, 'password') ?>

	<?php echo CHtml::submitButton(Yii::t('app', "Login"), array("class" => "radius small button")); ?>

	<?php echo CHtml::endForm(); ?>