<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'ID'); ?>
		<?php echo $form->textField($model, 'ID', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'language_code'); ?>
		<?php echo $form->dropDownList($model, 'language_code', GxHtml::listDataEx(Languages::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'idea_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_id', GxHtml::listDataEx(Ideas::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'pitch'); ?>
		<?php echo $form->textArea($model, 'pitch'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description_public'); ?>
		<?php echo $form->dropDownList($model, 'description_public', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tweetpitch'); ?>
		<?php echo $form->textField($model, 'tweetpitch', array('maxlength' => 140)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'deleted'); ?>
		<?php echo $form->textField($model, 'deleted'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
