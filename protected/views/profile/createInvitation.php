<?php $this->pageTitle = Yii::t('app','Create invitation'); ?>


<p>
  <?php echo Yii::t('msg',"This form will generate an invite for specific email address and return invite address <strong>Invitation email will not be sent!</strong>."); ?>
</p>
<?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>

  <label for="invite-email"><?php echo Yii::t('app',"Email"); ?></label>
<?php echo CHtml::textField("invite-email",""); ?>

  
<?php echo CHtml::submitButton(Yii::t("app","Generate invite"),
            array('class'=>"button small radius",
                  'confirm'=>Yii::t("msg","This action will create an invitation.")."\n".Yii::t("msg","Are you sure?") )
        ); ?>
  
<?php echo CHtml::endForm(); ?>
