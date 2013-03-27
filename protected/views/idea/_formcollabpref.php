<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($collabpref); ?>

		<div class="row">
		<?php echo $form->labelEx($collabpref,'collab_id'); ?>
		<?php echo $form->dropDownList($collabpref, 'collab_id', GxHtml::listDataEx(Collabpref::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($collabpref,'collab_id'); ?>
		</div><!-- row -->
		<div class="row">

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->