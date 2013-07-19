<?php
  $this->pageTitle=Yii::t('app','Create - step 3');
?>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Spread the word'); ?>
    </h3>

    <ul class="breadcrumbs meta">
       <li><strong>1.<?php echo Yii::t('app', 'Presentation'); ?></strong></li>
       <li>2.<?php echo Yii::t('app', 'Team'); ?></li>
       <?php /* ?><li><strong>3.<?php echo Yii::t('app', 'Social'); ?></strong></li> <?php */ ?>
      <li><?php echo Yii::t('app','You are done!');?></li>
    </ul>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formsocial', array(
          'translation' => $translation,
          'idea_id' => $idea_id,
          'buttons' => 'create'));
    ?>
  </div>
</div>
