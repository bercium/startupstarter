<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'skillset-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('skillsetSkills')); ?></label>
		<?php echo $form->checkBoxList($model, 'skillsetSkills', GxHtml::encodeEx(GxHtml::listDataEx(SkillsetSkill::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('userSkills')); ?></label>
		<?php echo $form->checkBoxList($model, 'userSkills', GxHtml::encodeEx(GxHtml::listDataEx(UserSkill::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->