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

	<?php echo $form->errorSummary($match); ?>

		<div class="row">
		<?php echo $form->labelEx($match,'available'); ?>
		<?php echo $form->dropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($match,'available'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($match,'country_id'); ?>
		<?php echo $form->dropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($match,'country_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($match,'city_id'); ?>
		<?php echo $form->dropDownList($match, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($match,'city_id'); ?>
		</div><!-- row -->
		<div class="row">

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->