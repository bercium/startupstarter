<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'click-idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'time_registered'); ?>
		<?php echo $form->textField($model, 'time_registered'); ?>
		<?php echo $form->error($model,'time_registered'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_updated'); ?>
		<?php echo $form->textField($model, 'time_updated'); ?>
		<?php echo $form->error($model,'time_updated'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'idea_click_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_click_id', GxHtml::listDataEx(Idea::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'idea_click_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->