<div class="sidebar profile-info  edit-content radius panel side">
  <h4><?php echo Yii::t('app',"Profile completeness"); ?> </h4>
  <a href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" title="<?php echo Yii::t('msg','Your profile is {n}% completed.',array($perc)); ?>" data-tooltip>
  <div class="progress <?php echo $percClass; ?> round">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
  </a>
  


  <a class="button radius small-12 secondary" href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" ><?php echo Yii::t('app','Profile details'); ?></a>

 

  <div class="item">
  <h4 class="l-inline">
    <?php echo Yii::t('app',"Profile viewed"); ?>: </h4>
    <p class="l-inline"> <?php echo Yii::t('app',"{n} time|{n} times",$views); ?></p>
   </div>
    <div class="item">
      <h4 class="l-iblock">
    <?php echo Yii::t('app',"Member since"); ?>: </h4>
    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($memberDate),"long",null); ?>

  </div>
     <?php if ($invites > 0){ ?>
  <a class="button radius small-12"  href="#" data-dropdown="drop-invitation-msg"><?php echo Yii::t('app','Send invitation <span class="label round secondary">{n}</span>',array($invites)); ?></a>
  <?php } ?>
  </div>


