<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'ideas-statuses-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('ideases')); ?></label>
		<?php echo $form->checkBoxList($model, 'ideases', GxHtml::encodeEx(GxHtml::listDataEx(Ideas::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->