<?php $this->pageTitle=Yii::t('app',"Restore your password");
?>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): 
  writeFlash("recoveryMessage");
else: ?>

<?php echo CHtml::beginForm('','post',array("class"=>"custom")); ?>

  <?php echo CHtml::errorSummary($form,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

	
  <?php echo CHtml::activeLabel($form,'login_or_email'); ?>
  <?php echo CHtml::activeTextField($form,'login_or_email') ?>

  <p><?php echo CHtml::submitButton(Yii::t('app',"Restore"),array("class"=>"button radius small")); ?></p>

<?php echo CHtml::endForm(); ?>
<?php endif; ?>