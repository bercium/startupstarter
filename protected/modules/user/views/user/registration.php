<?php
$this->pageTitle = Yii::t('app', 'Registration');
if (isset($_GET['event'])) $this->pageTitle .= " - ".$_GET['event'];
?>

<?php if(Yii::app()->user->hasFlash('registration')):
  writeFlash("registration");
  else: ?>

<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions' => array('enctype'=>'multipart/form-data',"class"=>"custom"),
)); ?>

<?php /* ?>
	<p class="note"><?php echo Yii::t('msg','Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php */ //echo $form->errorSummary(array($model,$profile)); ?>
<?php if (isset($_GET['event'])){ ?>
<div class="right panel radius large-5 small-12">
  <p><?php echo Yii::t('msg','Cofinder members login to apply for this event'); ?></p>
  <a href="#" onclick="$('#UserLogin_redirect').val('<?php echo Yii::app()->createUrl('site/applyForEvent',array("event"=>$_GET['event'])); ?>')" data-dropdown="drop-login" class="button small radius small-12"><?php echo Yii::t('app','Login here'); ?></a>
</div>
<?php } ?>
	<div>
  <p class="large-6">
  <?php if (isset($_GET['event'])){ ?>
    
    <?php echo CHtml::label(Yii::t('app','Do you wish to')." *",false); ?>
    <?php echo CHtml::radioButton('UserLogin[present]',false,array("value"=>"idea")).Yii::t('app','Present you'); ?>
    <br />
    <?php echo CHtml::radioButton('UserLogin[present]',false,array("value"=>"myself")).Yii::t('app','');  ?>
    <br /><br />
    <?php echo CHtml::label(Yii::t('app','Have you ever been a cofounder?')." *",false); ?>
    <?php echo CHtml::radioButton('UserLogin[cofounder]',false,array("value"=>"yes")).Yii::t('app','Yes'); ?>
    <br />
    <?php echo CHtml::radioButton('UserLogin[cofounder]',false,array("value"=>"no")).Yii::t('app','No');  ?>
    <br /><br />    
  <?php } ?>
    
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name'); ?>

 	<?php  echo $form->labelEx($model,'surname'); ?>
	<?php echo $form->textField($model,'surname');  ?>

	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	
	<?php echo $form->labelEx($model,'password'); ?>
	<span class="description">
	<?php echo Yii::t('msg',"Minimal password length is 6 symbols."); ?>
	</span>  
	<?php echo $form->passwordField($model,'password'); ?>
	
	<?php /* echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); */ ?>

	
	<?php  if (UserModule::doCaptcha('registration')): ?>
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		
		<span class="description"><?php echo Yii::t('msg',"Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo Yii::t('msg',"Letters are not case-sensitive."); ?></span>
	<?php endif;  ?>
  </p>
  <label for="RegistrationForm_tos" <?php if ($form->error($model,'tos')) echo 'class="error"'; ?>>
 	<?php echo $form->checkBox($model,'tos',array('style'=>'display:none')); ?>
	<?php 
   $tos = Yii::t('app','Terms of service');
   echo Yii::t('msg','I have read and agree to the following {tos}',array('{tos}'=>'<a href="'.Yii::app()->createUrl('site/terms').'" target="_blank">'.$tos.'</a>')); ?>
  </label>
  <span class="error"><?php echo $form->error($model,'tos'); ?></span>
  <br /><br />
	
	<?php echo CHtml::submitButton(Yii::t('app',"Register"),array("class"=>"radius small button")); ?>
  </div>
<?php $this->endWidget(); ?>
<?php endif; ?>