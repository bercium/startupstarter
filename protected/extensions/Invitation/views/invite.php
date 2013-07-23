<?php if ($invitations > 0){ ?>

<div id="drop-invitation-msg" class="f-dropdown content small" data-dropdown-content>
  <div class="invitation-form">
  <?php echo CHtml::beginForm('','post',array("class"=>"custom")); ?>

      <?php echo CHtml::label(Yii::t('app','Email'),'message'); ?>
      <div class="row collapse">
        <div class="small-9 columns">
          <?php echo CHtml::textField('invite-email') ?>
        </div>
        <div class="small-3 columns">
           <?php echo CHtml::submitButton(Yii::t("app","Invite"),array("class"=>"postfix button radius")); ?>
        </div>
      </div>    
 
  <?php echo CHtml::endForm(); ?>
  </div>
</div>
<?php } ?>

<?php writeFlash("invitationMessage"); ?>
