<?php 
  $this->pageTitle=Yii::t('app',"Change password");
?>

<?php echo CHtml::beginForm('','post',array("class"=>"custom")); ?>

  <?php echo CHtml::errorSummary($form,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

	<p class="note"><?php echo Yii::t('msg','Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo CHtml::activeLabelEx($form,'password'); ?>
	<?php echo CHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo Yii::t('msg',"Minimal password length 6 symbols."); ?>
	</p>
	
	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
	
	
	<?php echo CHtml::submitButton(Yii::t('app',"Save"),array("class"=>"button small radius success")); ?>

<?php echo CHtml::endForm(); ?>
