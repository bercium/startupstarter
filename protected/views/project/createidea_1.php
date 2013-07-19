<?php
  $this->pageTitle=Yii::t('app','Create - step 1');
?>
<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/sugestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Project presentation'); ?>
    </h3>

    <ul class="breadcrumbs meta">
       <li><strong> 1.<?php echo Yii::t('app', 'Presentation'); ?></strong></li>
       <li> 2.<?php echo Yii::t('app', 'Team'); ?></li>
       <?php /* ?><li><strong>3.<?php echo Yii::t('app', 'Social'); ?></strong></li> <?php */ ?>
      <li><?php echo Yii::t('app',"You are done!");?></li>
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
</div>
