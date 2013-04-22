<h2><?php echo Yii::t('app','Add a custom link'); ?></h2>
  

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($link); ?>

		<div class="row">
		<?php echo $form->labelEx($link,'title'); ?>
		<?php echo $form->textField($link, 'title', array('maxlength' => 128)); ?>
		<?php echo $form->error($link,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($link,'url'); ?>
		<?php echo $form->textField($link, 'url', array('maxlength' => 128)); ?>
		<?php echo $form->error($link,'url'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
