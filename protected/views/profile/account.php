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

		<a href="#">Change Email</a><br/>
		<a href="#">Change Password</a><br/>
		<div class="row">
		<?php echo $form->labelEx($user,'language_id'); ?>
		<?php echo $form->dropDownList($user, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($user,'language_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($user,'newsletter'); ?>
		<?php echo $form->textField($user, 'newsletter', array('maxlength' => 128)); ?>
		<?php echo $form->error($user,'newsletter'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->