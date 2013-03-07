<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'ideas-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'time_registered'); ?>
		<?php echo $form->textField($model, 'time_registered', array('maxlength' => 11)); ?>
		<?php echo $form->error($model,'time_registered'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_updated'); ?>
		<?php echo $form->textField($model, 'time_updated', array('maxlength' => 11)); ?>
		<?php echo $form->error($model,'time_updated'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->dropDownList($model, 'status_id', GxHtml::listDataEx(IdeasStatuses::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'status_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model, 'website', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'website'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'video_link'); ?>
		<?php echo $form->textField($model, 'video_link', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'video_link'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model, 'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('ideasMembers')); ?></label>
		<?php echo $form->checkBoxList($model, 'ideasMembers', GxHtml::encodeEx(GxHtml::listDataEx(IdeasMembers::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('ideasTranslations')); ?></label>
		<?php echo $form->checkBoxList($model, 'ideasTranslations', GxHtml::encodeEx(GxHtml::listDataEx(IdeasTranslations::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->