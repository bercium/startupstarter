<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'ideas-members-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'idea_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_id', GxHtml::listDataEx(Ideas::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'idea_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(Users::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model, 'type'); ?>
		<?php echo $form->error($model,'type'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->