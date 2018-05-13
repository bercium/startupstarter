<?php
$this->pageTitle = Yii::t('app', 'Login');
?>

<p><?php echo Yii::t('msg', "Please fill out the following form with your login credentials"); ?></p>

<div class="form">
	<?php echo CHtml::beginForm('','post',array('class'=>"custom  large-6 small-12")); ?>

	<?php echo CHtml::errorSummary($model,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
	
  <?php echo CHtml::label(Yii::t('app','Email'),'UserLogin_email'); ?>
	<?php echo CHtml::activeTextField($model, 'email') ?>

  <?php echo CHtml::label(Yii::t('app','Password'),'UserLogin_password'); ?>
	<?php echo CHtml::activePasswordField($model, 'password') ?>

	<div class=" rememberMe">
     <label for="UserLogin_rememberMe">
			 <?php echo CHtml::checkBox('UserLogin[rememberMe]',true, array("style"=>"display:none")); ?>
			 <?php echo Yii::t('app','Remember me'); ?>
		 </label>
	</div>
	<br />

	<?php echo CHtml::submitButton(Yii::t('app', "Login"), array("class" => "radius small button")); ?>
	
	<p class="hint meta-title">
		<?php echo CHtml::link(Yii::t('app', "Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
	</p>
	

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
