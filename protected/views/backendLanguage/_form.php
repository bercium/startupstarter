<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'language-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'language_code'); ?>
		<?php echo $form->textField($model, 'language_code', array('maxlength' => 2)); ?>
		<?php echo $form->error($model,'language_code'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'native_name'); ?>
		<?php echo $form->textField($model, 'native_name', array('maxlength' => 100)); ?>
		<?php echo $form->error($model,'native_name'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->