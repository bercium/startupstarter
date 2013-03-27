<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'skillset-skill-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'skillset_id'); ?>
		<?php echo $form->dropDownList($model, 'skillset_id', GxHtml::listDataEx(Skillset::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'skillset_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'skill_id'); ?>
		<?php echo $form->dropDownList($model, 'skill_id', GxHtml::listDataEx(Skill::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'skill_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->