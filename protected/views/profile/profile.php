<h1><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($user->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($user)); ?></h1>

<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($user); ?>
	<?php echo $form->errorSummary($match); ?>

		<div class="row">
		<?php echo $form->labelEx($user,'name'); ?>
		<?php echo $form->textField($user, 'name', array('maxlength' => 128)); ?>
		<?php echo $form->error($user,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($user,'surname'); ?>
		<?php echo $form->textField($user, 'surname', array('maxlength' => 128)); ?>
		<?php echo $form->error($user,'surname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($user,'avatar_link'); ?>
		<?php echo $form->textField($user, 'avatar_link', array('maxlength' => 128)); ?>
		<?php echo $form->error($user,'avatar_link'); ?>
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
		<?php echo $form->labelEx($user,'address'); ?>
		<?php echo $form->textField($user, 'address', array('maxlength' => 128)); ?>
		<?php echo $form->error($user,'address'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->