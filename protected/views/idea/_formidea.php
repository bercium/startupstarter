
<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($idea); ?>
	<?php echo $form->errorSummary($translation); ?>

		<?php echo $form->labelEx($translation,'title'); ?>
		<?php echo $form->textField($translation, 'title', array('maxlength' => 128)); ?>
		<?php echo $form->error($translation,'title'); ?>

		<?php echo $form->labelEx($translation,'language_id'); ?>
		<?php echo $form->dropDownList($translation, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(null, true)), array('empty' => '')); ?>
		<?php echo $form->error($translation,'language_id'); ?>

		<?php echo $form->labelEx($translation,'pitch'); ?>
		<?php echo $form->textArea($translation, 'pitch'); ?>
		<?php echo $form->error($translation,'pitch'); ?>

		<?php echo $form->labelEx($translation,'description'); ?>
		<?php echo $form->textArea($translation, 'description'); ?>
		<?php echo $form->error($translation,'description'); ?>

		<?php echo $form->labelEx($translation,'description_public'); ?>
		<?php echo $form->checkBox($translation, 'description_public'); ?>
		<?php echo $form->error($translation,'description_public'); ?>

		<?php echo $form->labelEx($translation,'tweetpitch'); ?>
		<?php echo $form->textField($translation, 'tweetpitch', array('maxlength' => 140)); ?>
		<?php echo $form->error($translation,'tweetpitch'); ?>

		<?php echo $form->labelEx($idea,'status_id'); ?>
		<?php echo $form->dropDownList($idea, 'status_id', GxHtml::listDataEx(IdeaStatus::model()->findAllAttributes(null, true)), array('empty' => '')); ?>
		<?php echo $form->error($idea,'status_id'); ?>

		<?php echo $form->labelEx($idea,'website'); ?>
		<?php echo $form->textField($idea, 'website', array('maxlength' => 128)); ?>
		<?php echo $form->error($idea,'website'); ?>

		<?php echo $form->labelEx($idea,'video_link'); ?>
		<?php echo $form->textField($idea, 'video_link', array('maxlength' => 128)); ?>
		<?php echo $form->error($idea,'video_link'); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
