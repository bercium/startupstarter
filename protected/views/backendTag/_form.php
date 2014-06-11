<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'tag-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('tagAdmins')); ?></label>
		<?php echo $form->checkBoxList($model, 'tagAdmins', GxHtml::encodeEx(GxHtml::listDataEx(TagAdmin::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('tagEvents')); ?></label>
		<?php echo $form->checkBoxList($model, 'tagEvents', GxHtml::encodeEx(GxHtml::listDataEx(TagEvent::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('tagIdeas')); ?></label>
		<?php echo $form->checkBoxList($model, 'tagIdeas', GxHtml::encodeEx(GxHtml::listDataEx(TagIdea::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('tagUsers')); ?></label>
		<?php echo $form->checkBoxList($model, 'tagUsers', GxHtml::encodeEx(GxHtml::listDataEx(TagUser::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->