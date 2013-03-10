<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'users-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'VIRTUAL'); ?>
		<?php echo $form->textField($model, 'VIRTUAL'); ?>
		<?php echo $form->error($model,'VIRTUAL'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'surname'); ?>
		<?php echo $form->textField($model, 'surname', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'surname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'md5_pass'); ?>
		<?php echo $form->textField($model, 'md5_pass', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'md5_pass'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_registered'); ?>
		<?php echo $form->textField($model, 'time_registered', array('maxlength' => 11)); ?>
		<?php echo $form->error($model,'time_registered'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_updated'); ?>
		<?php echo $form->textField($model, 'time_updated', array('maxlength' => 11)); ?>
		<?php echo $form->error($model,'time_updated'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'avatar_link'); ?>
		<?php echo $form->textField($model, 'avatar_link', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'avatar_link'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'time_per_week'); ?>
		<?php echo $form->textField($model, 'time_per_week', array('maxlength' => 3)); ?>
		<?php echo $form->error($model,'time_per_week'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'newsletter'); ?>
		<?php echo $form->textField($model, 'newsletter'); ?>
		<?php echo $form->error($model,'newsletter'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'language_id'); ?>
		<?php echo $form->dropDownList($model, 'language_id', GxHtml::listDataEx(Languages::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'language_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', GxHtml::listDataEx(Countries::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'country_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model, 'city_id', GxHtml::listDataEx(Cities::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'city_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model, 'address', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model, 'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('ideasMembers')); ?></label>
		<?php echo $form->checkBoxList($model, 'ideasMembers', GxHtml::encodeEx(GxHtml::listDataEx(IdeasMembers::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('usersCollabprefs')); ?></label>
		<?php echo $form->checkBoxList($model, 'usersCollabprefs', GxHtml::encodeEx(GxHtml::listDataEx(UsersCollabprefs::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('usersLinks')); ?></label>
		<?php echo $form->checkBoxList($model, 'usersLinks', GxHtml::encodeEx(GxHtml::listDataEx(UsersLinks::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('usersSkills')); ?></label>
		<?php echo $form->checkBoxList($model, 'usersSkills', GxHtml::encodeEx(GxHtml::listDataEx(UsersSkills::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->