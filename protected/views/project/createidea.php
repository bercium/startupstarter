<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/sugestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
  <div class="small-12 large-12 columns edit-header">
    <h3>
      <?php if($step == 1) echo Yii::t('app', 'Project presentation'); ?>
      <?php if($step == 2) echo Yii::t('app', 'Team'); ?>
      <?php if($step == 3) echo Yii::t('app', 'Spread the word'); ?>
    </h3>

    <ol class="breadcrumbs meta"> 
      <?php if($step == 1) echo "<strong>"; 
          echo "<li>1.". Yii::t('app', 'Presentation') ."</li>";
          if($step == 1) echo "</strong>"; ?>     
      <?php if($step == 2) echo "<strong>"; 
            echo "<li>2.". Yii::t('app', 'Team');
            if($step == 2) echo "</li></strong>"; ?>
      |
      <?php /*if($step == 3) echo "<strong>"; 
            echo "<li>3.". Yii::t('app', 'Social');
            if($step == 3) echo "</li></strong>"; */?>
      <li> You're done!</li>
    </ol>
   
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
          'idea' => $idea,
          'idea_id' => $idea_id));
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
  if(isset($candidate) && isset($match)){
      $this->renderPartial('_formteam', array(
          'idea' => $idea,
          'candidate' => $candidate,
          'match' => $match,
          'buttons' => 'create'));
  } else {
      $this->renderPartial('_formteam', array(
          'idea' => $idea,
          'buttons' => 'create'));
  }
  echo CHtml::submitButton(Yii::t("app","Finish"),
            array('class'=>"button small success radius",
                'onclick'=>'window.location.href=(\''.$idea_id.'\');')
        );
}?>