<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'invite-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'sender_id'); ?>
		<?php echo $form->dropDownList($model, 'sender_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'sender_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model, 'key', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'key'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'idea_id'); ?>
		<?php echo $form->dropDownList($model, 'idea_id', GxHtml::listDataEx(Idea::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'idea_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'receiver_id'); ?>
		<?php echo $form->dropDownList($model, 'receiver_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'receiver_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_invited'); ?>
		<?php echo $form->textField($model, 'time_invited'); ?>
		<?php echo $form->error($model,'time_invited'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model, 'code', array('maxlength' => 126)); ?>
		<?php echo $form->error($model,'code'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'registered'); ?>
		<?php echo $form->checkBox($model, 'registered'); ?>
		<?php echo $form->error($model,'registered'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->