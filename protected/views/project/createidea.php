<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/suggestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row columns createidea">
  <div class="columns edit-header">
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
      <li> <?php echo Yii::t('app',"You are done!");?></li>
    </ol>
   
  </div>
  <div class="columns panel edit-content">
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

<?php if($step == 2){ ?>
<div class="row">
  <div class="columns edit-header">
    <div class="edit-floater">
      <?php if(!isset($candidate)){ ?>
      <a class="small button radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl('project/create?step=2&candidate=new'); ?>"><?php echo Yii::t('app','Add new') ?>
        <span class="icon-plus"></span>
      </a>
        <?php } ?>
    </div>
    
     <h3><?php if(!isset($candidate)){ echo Yii::t('app', 'Open positions'); }
              else echo Yii::t('app', 'New positions');?>
    </h3>
    
  </div>
  <div class="columns panel edit-content">    
    
  <?php if(isset($candidate) && isset($match)){
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

  
   ?>
    
</div>
</div>    
<?php } ?>