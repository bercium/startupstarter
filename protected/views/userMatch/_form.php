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
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'available'); ?>
		<?php echo $form->textField($model, 'available', array('maxlength' => 2)); ?>
		<?php echo $form->error($model,'available'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'country_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'city_id'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('ideaMembers')); ?></label>
		<?php echo $form->checkBoxList($model, 'ideaMembers', GxHtml::encodeEx(GxHtml::listDataEx(IdeaMember::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('userCollabprefs')); ?></label>
		<?php echo $form->checkBoxList($model, 'userCollabprefs', GxHtml::encodeEx(GxHtml::listDataEx(UserCollabpref::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('userSkills')); ?></label>
		<?php echo $form->checkBoxList($model, 'userSkills', GxHtml::encodeEx(GxHtml::listDataEx(UserSkill::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->