<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'tag-user-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'tag_id'); ?>
		<?php echo $form->dropDownList($model, 'tag_id', GxHtml::listDataEx(Tag::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'tag_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'added_by'); ?>
		<?php echo $form->dropDownList($model, 'added_by', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'added_by'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'added_time'); ?>
		<?php echo $form->textField($model, 'added_time'); ?>
		<?php echo $form->error($model,'added_time'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'revoked_by'); ?>
		<?php echo $form->dropDownList($model, 'revoked_by', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'revoked_by'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'revoked_time'); ?>
		<?php echo $form->textField($model, 'revoked_time'); ?>
		<?php echo $form->error($model,'revoked_time'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->