<?php
$this->pageTitle = Yii::t('app', 'Login');
?>

<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

	<div class="success">
		<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
	</div>

<?php endif; ?>

<p><?php echo Yii::t('msg', "Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
	<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($model); ?>

	<?php echo CHtml::activeLabelEx($model, 'email'); ?>
	<?php echo CHtml::activeTextField($model, 'email') ?>

	<?php echo CHtml::activeLabelEx($model, 'password'); ?>
	<?php echo CHtml::activePasswordField($model, 'password') ?>

	<p class="hint meta-title">
		<?php echo CHtml::link(Yii::t('app', "Register"), Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(Yii::t('app', "Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
	</p>

	<div class=" rememberMe">
		<?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
	</div>

	<?php echo CHtml::submitButton(Yii::t('app', "Login"), array("class" => "radius button")); ?>

	<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
/*
  $form = new CForm(array(
  'elements'=>array(
  'email'=>array(
  'type'=>'text',
  /*'maxlength'=>32,* /
  ),
  'password'=>array(
  'type'=>'password',
  'maxlength'=>32,
  ),
  'rememberMe'=>array(
  'type'=>'checkbox',
  )
  ),

  'buttons'=>array(
  'login'=>array(
  'type'=>'submit',
  'label'=>'Login',
  ),
  ),
  ), $model); */
?>
