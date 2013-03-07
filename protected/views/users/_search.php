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
		<?php echo $form->label($model, 'VIRTUAL'); ?>
		<?php echo $form->textField($model, 'VIRTUAL'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'surname'); ?>
		<?php echo $form->textField($model, 'surname', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'md5_pass'); ?>
		<?php echo $form->textField($model, 'md5_pass', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'time_registered'); ?>
		<?php echo $form->textField($model, 'time_registered', array('maxlength' => 11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'time_updated'); ?>
		<?php echo $form->textField($model, 'time_updated', array('maxlength' => 11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'avatar_link'); ?>
		<?php echo $form->textField($model, 'avatar_link', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'time_per_week'); ?>
		<?php echo $form->textField($model, 'time_per_week', array('maxlength' => 3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'newsletter'); ?>
		<?php echo $form->textField($model, 'newsletter'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'language_code'); ?>
		<?php echo $form->dropDownList($model, 'language_code', GxHtml::listDataEx(Languages::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', GxHtml::listDataEx(Countries::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'city_id'); ?>
		<?php echo $form->dropDownList($model, 'city_id', GxHtml::listDataEx(Cities::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'address'); ?>
		<?php echo $form->textField($model, 'address', array('maxlength' => 128)); ?>
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
