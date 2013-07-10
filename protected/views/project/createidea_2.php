<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/sugestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Team'); ?>
    </h3>

    <ul class="breadcrumbs meta">
       <li> <a href="<?php echo Yii::app()->createUrl('project/create',array('step'=>1)); ?>">1.<?php echo Yii::t('app', 'Presentation'); ?></a></li>
       <li> <strong>2.<?php echo Yii::t('app', 'Team'); ?></strong></li>
       <?php /* ?><li><strong>3.<?php echo Yii::t('app', 'Social'); ?></strong></li> <?php */ ?>
      <li> You're done!</li>
    </ul>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formmembers', array(
          'ideadata' => $ideadata,
          'idea_id' => $idea_id));
    ?>
  </div>
</div>


<div class="row">
  <div class="columns edit-header">
    <div class="edit-floater">
      <?php if(!isset($candidate)){ ?>
      <a class="small button radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl('project/create',array('step'=>2,'candidate'=>'new')); ?>">
        <?php echo Yii::t('app','Add new') ?>
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
          'ideadata' => $ideadata,
          'candidate' => $candidate,
          'match' => $match,
          'buttons' => 'create'));
  } else {
      $this->renderPartial('_formteam', array(
          'ideadata' => $ideadata,
          'buttons' => 'create'));
  }?>
    
  
  <?php
  
  if (!isset($_GET['candidate'])){
    
  echo "<hr>".CHtml::submitButton(Yii::t("app","Finish"),
            array('class'=>"button small success radius",
                'onclick'=>'window.location.href=(\''.$idea_id.'\');')
        );
  
   } ?>
    
</div>
</div>    
