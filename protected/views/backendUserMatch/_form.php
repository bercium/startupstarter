<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-match-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->textField($model, 'available', array('maxlength' => 2)); ?>
		<?php echo $form->error($model,'available'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>
		<?php echo $form->error($model,'country_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>
		<?php echo $form->error($model,'city_id'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->