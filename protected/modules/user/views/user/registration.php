<?php
$this->pageTitle = Yii::t('app', 'Registration');
?>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions' => array('enctype'=>'multipart/form-data',"class"=>"custom large-6 small-12"),
)); ?>

	<p class="note"><?php echo Yii::t('msg','Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php //echo $form->errorSummary(array($model,$profile)); ?>
	
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name'); ?>

 	<?php echo $form->labelEx($model,'surname'); ?>
	<?php echo $form->textField($model,'surname'); ?>

	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<p class="hint">
	<?php echo Yii::t('msg',"Minimal password length 4 symbols."); ?>
	</p>
	
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>

	
	<?php if (UserModule::doCaptcha('registration')): ?>
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		
		<p class="hint"><?php echo Yii::t('msg',"Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo Yii::t('msg',"Letters are not case-sensitive."); ?></p>
	<?php endif; ?>
	
	<?php echo CHtml::submitButton(Yii::t('app',"Register"),array("class"=>"radius small button")); ?>

<?php $this->endWidget(); ?>
<?php endif; ?>