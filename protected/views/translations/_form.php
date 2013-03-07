<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'translations-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'language_code'); ?>
		<?php echo $form->dropDownList($model, 'language_code', GxHtml::listDataEx(Languages::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'language_code'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'table'); ?>
		<?php echo $form->textField($model, 'table', array('maxlength' => 64)); ?>
		<?php echo $form->error($model,'table'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'row_id'); ?>
		<?php echo $form->textField($model, 'row_id', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'row_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'translation'); ?>
		<?php echo $form->textField($model, 'translation', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'translation'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->