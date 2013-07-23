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
