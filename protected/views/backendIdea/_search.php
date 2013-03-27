<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'time_registered'); ?>
		<?php echo $form->textField($model, 'time_registered'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'time_updated'); ?>
		<?php echo $form->textField($model, 'time_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'status_id'); ?>
		<?php echo $form->dropDownList($model, 'status_id', GxHtml::listDataEx(IdeaStatus::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'website'); ?>
		<?php echo $form->textField($model, 'website', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'video_link'); ?>
		<?php echo $form->textField($model, 'video_link', array('maxlength' => 128)); ?>
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
