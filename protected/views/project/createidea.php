<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3>
      <?php if($step == 1) echo Yii::t('app', 'Project presentation'); ?>
      <?php if($step == 2) echo Yii::t('app', 'Team'); ?>
      <?php if($step == 3) echo Yii::t('app', 'Spread the word'); ?>
    </h3>

    <div class="breadcrumbs">
      <?php if($step == 1) echo "<strong>"; 
            echo "1.". Yii::t('app', 'Presentation');
            if($step == 1) echo "</strong>"; ?>
      | 
      <?php if($step == 2) echo "<strong>"; 
            echo "2.". Yii::t('app', 'Team');
            if($step == 2) echo "</strong>"; ?>
      |
      <?php if($step == 3) echo "<strong>"; 
            echo "3.". Yii::t('app', 'Social');
            if($step == 3) echo "</strong>"; ?>
      | You're done!
    </div>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    <?php
    if($step == 1){
      $this->renderPartial('_formidea', array(
          'idea' => $idea,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    } elseif($step == 2){
      $this->renderPartial('_formmembers', array(
          'idea' => $idea));
    } elseif($step == 3){
      $this->renderPartial('_formsocial', array(
          'translation' => $translation,
          'idea_id' => $idea_id,
          'buttons' => 'create'));
    }
    ?>
  </div>
</div>
<?php if($step == 2){
      $this->renderPartial('_formteam', array(
          'idea' => $idea,
          'candidate' => $candidate,
          'candidate_id' => $candidate_id,
          'buttons' => 'create')); }
      elseif($step == 3){
           echo CHtml::submitButton(Yii::t("app","Finish"),
                    array('class'=>"button small success radius",
                        'onclick'=>'window.location.href=(\''.$idea_id.'\');')
                );
      }