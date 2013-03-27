<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($skill); ?>

		<div class="row">
		<?php echo $form->labelEx($skill,'skillset_id'); ?>
		<?php echo $form->dropDownList($skill, 'skillset_id', GxHtml::listDataEx(Skillset::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($skill,'skillset_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($skill,'skill_id'); ?>
		<?php echo $form->dropDownList($skill, 'skill_id', GxHtml::listDataEx(Skill::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($skill,'skill_id'); ?>
		</div><!-- row -->
		<div class="row">

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->