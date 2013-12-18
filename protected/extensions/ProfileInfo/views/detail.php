<div class="sidebar profile-info  edit-content radius panel side">
  <h4 style="text-align:center;"><?php echo Yii::t('app',"Profile completeness"); ?> </h4>
  <a href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" title="<?php echo Yii::t('msg','Your profile is {n}% completed.',array($perc)); ?>" data-tooltip>
  <div class="progress <?php echo $percClass; ?> round">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
  </a>

  <a class="button radius small-12 secondary" href="<?php echo Yii::app()->createUrl("profile/completeness"); ?>" ><?php echo Yii::t('app','Improve your profile'); ?></a>

  </div>


