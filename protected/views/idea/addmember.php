<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($idea->label()); ?></h1>

<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'idea-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($member); ?>

		<div class="row">
		<?php echo $form->labelEx($member,'match_id'); ?>
		<?php echo $form->dropDownList($member, 'match_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($member,'match_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($member,'type'); ?>
		<?php echo $form->textField($member, 'type', array('maxlength' => 2)); ?>
		<?php echo $form->error($member,'type'); ?>
		</div><!-- row -->
		<div class="row">

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->