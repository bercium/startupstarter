<?php
  $this->pageTitle=Yii::t('app','Edit project');

  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  
  $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css');
  $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.10.3.custom.min.js',CClientScript::POS_END);
?>

<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/sugestSkill",array("ajax"=>1)) ?>';
  var citySuggest_url = '<?php echo Yii::app()->createUrl("site/sugestCity",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
  <div class="columns edit-header">
   
    <div class="edit-floater">
      
        <?php 
          if($isOwner){
        echo CHtml::link(Yii::t("app","Delete project"),Yii::app()->createUrl('project/deleteIdea',array('id'=>$idea['id'])),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>
      <?php 
      }else{
      echo CHtml::link(Yii::t("app","Leave project"),Yii::app()->createUrl('project/leaveIdeas',array('id'=>$idea['id'])),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nYou will have to be re invited to be a member.\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); 
      }      
      ?>
    </div>
      
    <h3>
      <?php echo Yii::t('app', 'Project presentation'); ?>
    </h3>
      
    
    
      <div class="columns languages" style="margin-bottom: 10px;">
        <span style="float:left; margin-right: 8px; margin-top:5px;"><?php echo Yii::t('app','Languages'); ?>:</span> 
        <ul class="button-group radius">
          <li><a class="button tiny"><?php echo $ideadata['language']; ?></a></li>
          <?php 
           if (count($ideadata['translation_other'])){ 
              foreach ($ideadata['translation_other'] as $trans){
                echo '<li><a href="?lang='.$trans['language_code'].'" class="button tiny secondary">'.$trans['language']."</a></li>";
              }
            
            }
           ?>
          <li><a class="button success tiny"  href="<?php echo Yii::app()->createUrl("project/translate",array("id"=>$id)); ?>"><?php echo Yii::t('app', 'New translation'); ?></a></li>
          </ul>
      </div>    
          
          
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formideaedit', array(
          'id' => $id,
          'lang' => $lang,
          'idea' => $idea,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    ?>
  </div>
</div>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Team'); ?>
    </h3>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formmembersedit', array(
          'id' => $id,
          'lang' => $lang,
          'ideadata' => $ideadata,
          'idea_id' => $idea_id));
    ?>
  </div>
</div>


<div class="row">
  <div class="columns edit-header">
    <a id="link_position" class="anchor-link"></a>
      
    <div class="edit-floater">
      <?php if(!isset($candidate)){ ?>
      <a class="small button radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl('project/edit',array('id'=>$id,'lang'=>$lang,'candidate'=>'new')); ?>#link_position">
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
      $this->renderPartial('_formteamedit', array(
          'id' => $id,
          'lang' => $lang,
          'ideadata' => $ideadata,
          'candidate' => $candidate,
          'match' => $match,
          'buttons' => 'create'));
  } else {
      $this->renderPartial('_formteamedit', array(
          'id' => $id,
          'lang' => $lang,
          'ideadata' => $ideadata,
          'buttons' => 'create'));
  }?>
    
</div>
</div>    

<?php /* ?>
<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Spread the word'); ?>
    </h3>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formsocialedit', array(
          'id' => $id,
          'lang' => $lang,
          'translation' => $translation,
          'idea_id' => $idea_id,
          'buttons' => 'create'));
    ?>
  </div>
</div>
<?php */ ?>