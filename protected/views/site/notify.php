<?php
	$this->pageTitle = Yii::t('app','Registration - Invitations');
?>

<?php if(Yii::app()->user->hasFlash('interestMessage')){ ?>
<div data-alert class="alert-box radius success">
  <?php echo Yii::app()->user->getFlash('interestMessage'); ?>
  <a href="#" class="close">&times;</a>
</div>
<?php } ?>  

<p>
  <strong>
    <?php echo Yii::t('msg',"Thank you for your interest!"); ?>
  </strong>
  <br />
  <?php echo Yii::t('msg',"We are curently in a private beta stage and as such only except registrations with invitations."); ?>
  <br />
  <?php echo Yii::t('msg','If you wish to be invited or notified when we go live please leave your email address below.'); ?>
</p>

<?php echo CHtml::beginForm('','post',array("class"=>"custom large-6")); ?>

  <?php echo CHtml::label(Yii::t('app','Your email'),'email'); ?>
  <?php echo CHtml::textField("email") ?>

  <p><?php echo CHtml::submitButton(Yii::t('app',"Notify me"),array("class"=>"button radius small success")); ?></p>

<?php echo CHtml::endForm(); ?>
