<?php
  $this->pageTitle=Yii::t('app','Create - step 1');
?>
<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Project presentation'); ?>
    </h3>

    <ul class="button-group radius">
       <li><a class="button tiny">1.<?php echo Yii::t('app', 'Presentation'); ?></a></li>
       <li><a class="button tiny secondary">2.<?php echo Yii::t('app', 'Team'); ?></a></li>
       <?php /* ?><li><strong>3.<?php echo Yii::t('app', 'Social'); ?></strong></li> <?php */ ?>
      <li><a  class="button tiny secondary"><?php echo Yii::t('app',"You are done!");?></a></li>
    </ul>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formidea', array(
          'idea' => $idea,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    ?>
  </div>
