<div class="sidebar profile-info  edit-content radius panel">
  <?php echo Yii::t('app',"Profile completeness"); ?>: 
  <a href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>">
  <div class="progress <?php echo $percClass; ?> round">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
  </a>
  <p><span class="meta">
    <?php echo Yii::t('app',"Profile viewed"); ?> </span>
    <?php echo Yii::t('app',"{n} time|{n} times",$views); ?></p>
    <p><span class="meta">
    <?php echo Yii::t('app',"Member since"); ?>: </span>
    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($memberDate),"long",null); ?></p>


  <?php if ($invites > 0){ ?>
  <a class="button radius large-12"  href="#" data-dropdown="drop-invitation-msg"><?php echo Yii::t('app','Send invitation ({n})',array($invites)); ?></a>
  <?php } ?>



</div>


