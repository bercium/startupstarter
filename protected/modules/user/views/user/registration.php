<?php
$this->pageTitle = Yii::t('app', 'Registration');

if (isset($event)) $this->pageTitle .= " - ".$event->title;
?>

<?php if(Yii::app()->user->hasFlash('registration')):
  writeFlash("registration");
  else: ?>

<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions' => array('enctype'=>'multipart/form-data',"class"=>"custom"),
)); ?>

<?php /* ?>
	<p class="note"><?php echo Yii::t('msg','Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php */ //echo $form->errorSummary(array($model,$profile)); ?>
<?php if (isset($event)){  ?>
<div class="large-12">
  <h3>
  <?php echo Yii::t('msg','Event description'); ?>
  </h3>
  <p>
    <?php echo $event->content; ?>
  </p>
  <br />
  <h3>
  <?php echo Yii::t('msg','Cofinder members login to register for this event'); ?>
  </h3>
  <a href="#" onclick="$('#UserLogin_redirect').val('<?php echo Yii::app()->createUrl('event/signup',array("id"=>Yii::app()->session['event'])); ?>')" data-dropdown="drop-login" class="button small radius large-6">
  <?php echo Yii::t('app','Login to register'); ?>
  </a>
</div>

<hr class="mb4">
<div class="text-center mb20 meta" style="margin-top: -12px">
  <strong>
  <?php echo Yii::t('msg','OR'); ?>
  </strong>
</div>

<h3>
  <?php echo Yii::t('msg','New members register here'); ?>
</h3>
<br />

<?php } ?>
	<div>
  <p class="large-6">
    
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name'); ?>

 	<?php  echo $form->labelEx($model,'surname'); ?>
	<?php echo $form->textField($model,'surname');  ?>

	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	
	<?php echo $form->labelEx($model,'password'); ?>
	<span class="description">
	<?php echo Yii::t('msg',"Minimal password length is 6 symbols."); ?>
	</span>  
	<?php echo $form->passwordField($model,'password'); ?>
	
	<?php /* echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); */ ?>

	
	<?php  if (UserModule::doCaptcha('registration')): ?>
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		
		<span class="description"><?php echo Yii::t('msg',"Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo Yii::t('msg',"Letters are not case-sensitive."); ?></span>
	<?php endif;  ?>
  </p>
  <label for="RegistrationForm_tos" <?php if ($form->error($model,'tos')) echo 'class="error"'; ?>>
 	<?php echo $form->checkBox($model,'tos',array('style'=>'display:none')); ?>
	<?php 
   $tos = Yii::t('app','Terms of service');
   echo Yii::t('msg','I have read and agree to the following {tos}',array('{tos}'=>'<a href="'.Yii::app()->createUrl('site/terms').'" target="_blank">'.$tos.'</a>')); ?>
  </label>
  <span class="error"><?php echo $form->error($model,'tos'); ?></span>
  <br /><br />
	
	<?php echo CHtml::submitButton(Yii::t('app',"Register"),array("class"=>"radius small button")); ?>
  </div>
<?php $this->endWidget(); ?>
<?php endif; ?>