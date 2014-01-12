<div class="sidebar profile-info  edit-content radius panel s-ide">
  <a class="button radius small right secondary" trk="profileSidebar_click_profileDetails" href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" ><?php echo Yii::t('app', 'Details'); ?></a>
  
  <h4 style="margin-top:8px;margin-bottom:12px;"><?php echo Yii::t('app',"Profile completeness"); ?>
  </h4>
  <a href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" trk="profileSidebar_click_progressBar">
  <div class="progress <?php echo $percClass; ?> round" title="<?php echo Yii::t('msg','Your profile is {n}% completed.',array($perc)); ?>" data-tooltip>
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
  </a>
  <p><span class="meta">
      <?php echo Yii::t('app', "Profile viewed"); ?> </span>
    <?php echo Yii::t('app', "{n} time|{n} times", $views); ?></p>
  <p><span class="meta">
      <?php echo Yii::t('app', "Member since"); ?>: </span>
    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($memberDate), "long", null); ?></p>


  <?php if ($invites > 0) { ?>
    <a class="button radius small-12" href="#" trk="profileSidebar_click_invite" data-dropdown="drop-invitation-msg"><?php echo Yii::t('app', 'Send invitation ({n})', array($invites)); ?></a>
  <?php } ?>

</div>