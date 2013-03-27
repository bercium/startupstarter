<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($translation); ?>

		<div class="row">
		<?php echo $form->labelEx($translation,'title'); ?>
		<?php echo $form->textField($translation, 'title', array('maxlength' => 128)); ?>
		<?php echo $form->error($translation,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($translation,'language_id'); ?>
		<?php echo $form->dropDownList($translation, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($translation,'language_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($translation,'pitch'); ?>
		<?php echo $form->textArea($translation, 'pitch'); ?>
		<?php echo $form->error($translation,'pitch'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($translation,'description'); ?>
		<?php echo $form->textArea($translation, 'description'); ?>
		<?php echo $form->error($translation,'description'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($translation,'description_public'); ?>
		<?php echo $form->checkBox($translation, 'description_public'); ?>
		<?php echo $form->error($translation,'description_public'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($translation,'tweetpitch'); ?>
		<?php echo $form->textField($translation, 'tweetpitch', array('maxlength' => 140)); ?>
		<?php echo $form->error($translation,'tweetpitch'); ?>
		</div><!-- row -->
		<div class="row">

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->