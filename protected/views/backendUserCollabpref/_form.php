<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-collabpref-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'match_id'); ?>
		<?php echo $form->dropDownList($model, 'match_id', GxHtml::listDataEx(UserMatch::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'match_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'collab_id'); ?>
		<?php echo $form->dropDownList($model, 'collab_id', GxHtml::listDataEx(Collabpref::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'collab_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->