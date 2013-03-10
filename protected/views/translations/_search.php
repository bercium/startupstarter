<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'ID'); ?>
		<?php echo $form->textField($model, 'ID', array('maxlength' => 8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'language_id'); ?>
		<?php echo $form->dropDownList($model, 'language_id', GxHtml::listDataEx(Languages::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'table'); ?>
		<?php echo $form->textField($model, 'table', array('maxlength' => 64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'row_id'); ?>
		<?php echo $form->textField($model, 'row_id', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'translation'); ?>
		<?php echo $form->textField($model, 'translation', array('maxlength' => 128)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
