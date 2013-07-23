<?php $this->pageTitle = Yii::t('app','Create invitation'); ?>


<?php if(Yii::app()->user->hasFlash('invitationMessage')){ ?>
<div data-alert class="alert-box radius success">
  <?php echo Yii::app()->user->getFlash('invitationMessage'); ?>
  <a href="#" class="close">&times;</a>
</div>
<?php } ?>
<?php if(Yii::app()->user->hasFlash('invitationMessageError')){ ?>
<div data-alert class="alert-box radius alert">
  <?php echo Yii::app()->user->getFlash('invitationMessageError'); ?>
  <a href="#" class="close">&times;</a>
</div>
<?php } ?>

<p>
  <?php echo Yii::t('msg',"This form will generate an invite for specific email address and return invite address <strong>Invitation email will not be sent!</strong>."); ?>
</p>
<?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>

  <label for="invite-email"><?php echo Yii::t('app',"Email"); ?></label>
<?php echo CHtml::textField("invite-email",""); ?>

  
<?php echo CHtml::submitButton(Yii::t("app","Generate invite"),
            array('class'=>"button small radius",
                  'confirm'=>Yii::t("msg","This action will create an invitation.\nAre you sure?") )
        ); ?>
  
<?php echo CHtml::endForm(); ?>
