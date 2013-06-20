<?php if (Yii::app()->user->hasFlash('WProfileInfoHint')){
  $hintAction = Yii::app()->user->getFlash('WProfileInfoHint');
  $hint = substr($hintAction, 0, strpos($hintAction, "|"));
  $action = substr($hintAction, strpos($hintAction, "|")+1);
  ?>
  <div data-alert class="alert-box radius">
    <?php echo $hint; ?>
    <a href="<?php echo $action; ?>"><?php echo Yii::t("app",'do it now!') ?></a>
    <a href="#" class="close">&times;</a>
  </div>
<?php } ?>