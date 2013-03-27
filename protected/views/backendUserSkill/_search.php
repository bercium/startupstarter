<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'match_id'); ?>
		<?php echo $form->dropDownList($model, 'match_id', GxHtml::listDataEx(UserMatch::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'skillset_id'); ?>
		<?php echo $form->dropDownList($model, 'skillset_id', GxHtml::listDataEx(Skillset::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'skill_id'); ?>
		<?php echo $form->dropDownList($model, 'skill_id', GxHtml::listDataEx(Skill::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
