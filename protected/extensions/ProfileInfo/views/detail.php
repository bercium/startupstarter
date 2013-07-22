<div class="profile-info">
  <?php echo Yii::t('app',"Profile completeness"); ?>: 
  <div class="progress <?php echo $percClass; ?> round">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
    <?php echo Yii::t('app',"Profile viewed"); ?> 
    <strong><?php echo Yii::t('app',"{n} time|{n} times",$views); ?></strong>
    <br />
    <?php echo Yii::t('app',"Member since"); ?>: 
    <strong><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($memberDate),"long",null); ?></strong>
</div>

<?php if ($invites > 0){ ?>
<div id="drop-invitation-msg" class="f-dropdown content large" data-dropdown-content>
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

<div style="text-align: center;">
     <?php if(Yii::app()->user->hasFlash('invitationMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('invitationMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?> 
  <?php if ($invites > 0){ ?>
  <a class="button alert radius small"  href="#" data-dropdown="drop-invitation-msg"><?php echo Yii::t('app','Send invitation ({n})',array($invites)); ?></a>
  <?php } ?>
</div>
