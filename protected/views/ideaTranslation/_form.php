<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-translation-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'language_id'); ?>
		<?php echo $form->dropDownList($model, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'language_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'idea_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_id', GxHtml::listDataEx(Idea::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'idea_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'pitch'); ?>
		<?php echo $form->textArea($model, 'pitch'); ?>
		<?php echo $form->error($model,'pitch'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description_public'); ?>
		<?php echo $form->checkBox($model, 'description_public'); ?>
		<?php echo $form->error($model,'description_public'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'tweetpitch'); ?>
		<?php echo $form->textField($model, 'tweetpitch', array('maxlength' => 140)); ?>
		<?php echo $form->error($model,'tweetpitch'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model, 'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->