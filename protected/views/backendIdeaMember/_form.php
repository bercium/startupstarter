<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-member-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'idea_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_id', GxHtml::listDataEx(Idea::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'idea_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'match_id'); ?>
		<?php echo $form->dropDownList($model, 'match_id', GxHtml::listDataEx(UserMatch::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'match_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model, 'type_id', GxHtml::listDataEx(Membertype::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'type_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->