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
<?php if ($hint){ ?>
  <div data-alert class="alert-box radius">
    <?php echo $hint; ?>
    <a href="#" class="close">&times;</a>
  </div>
<?php } ?>
