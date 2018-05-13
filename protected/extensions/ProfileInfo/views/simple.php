<img src="<?php echo avatar_image(Yii::app()->user->getState('avatar_link'),Yii::app()->user->id); ?>" class="top-bar-avatar" />
<div class="top-bar-person">
  <?php echo Yii::app()->user->getState('fullname'); ?>

  <div class="progress <?php echo $percClass; ?> round" style="height:10px;">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
</div>
