<div class="large-12 columns">
<?php
  $this->pageTitle=Yii::t('app','Edit project');
?>

<script>
  var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
  var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>





<div class="row createidea">
     
  <div class="">   

          <ul class="button-group radius" style="float: left">
            <li><a class="button small secondary"  href="<?php echo Yii::app()->createUrl("project/translate",array("id"=>$id)); ?>"><?php echo Yii::t('app', 'New translation'); ?></a></li>
            <li><?php if (count($ideadata['translation_other'])){ ?>
    
      
        <?php 
        echo CHtml::link(Yii::t("app","Delete this translation"),Yii::app()->createUrl('project/deleteTranslation',array('id'=>$idea['id'],'lang'=>$ideadata['language_code'])),
                  array('class'=>"button small secondary",
                        'confirm'=>Yii::t("msg","You are about to delete this translation!")."\n".Yii::t("msg","Are you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );
        ?></li>
          </ul>
    
              <?php 
          if($isOwner){
        echo CHtml::link(Yii::t("app","Delete project"),Yii::app()->createUrl('project/deleteIdea',array('id'=>$idea['id'])),
                  array('class'=>"button small right alert radius",
                        'confirm'=>Yii::t("msg","You are about to delete this project!")."\n".Yii::t("msg","Are you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>
      <?php 
      }else{
      echo CHtml::link(Yii::t("app","Leave project"),Yii::app()->createUrl('project/leaveIdeas',array('id'=>$idea['id'])),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nYou will have to be re invited to be a member.")."\n".Yii::t("msg","Are you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); 
      }      
      ?>
    
   
      
     
  </div>
  
  <div class="edit-header columns">
    <h3>
      <?php echo Yii::t('app', 'Project presentation'); ?>
    </h3>

  </div>

 
  <div class="columns panel edit-content">

    <div class="columns">
        <p style=""><?php echo Yii::t('app','Languages'); ?>:</p> 
        <ul class="button-group radius">
          <li><a class="button small"><?php echo $ideadata['language']; ?></a></li>
          <?php 
           if (count($ideadata['translation_other'])){ 
              foreach ($ideadata['translation_other'] as $trans){
                echo '<li><a href="?lang='.$trans['language_code'].'" class="button small secondary">'.$trans['language']."</a></li>";
              }
            
            }
           ?>          
          </ul>  
          

    </div>
    

    <hr>
    
    
    
    <?php } ?>
    
    <?php
      $this->renderPartial('_formideaedit', array(
          'id' => $id,
          'lang' => $lang,
          'idea' => $idea,
          'ideagallery' => $ideagallery,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create' ));
    ?>

    <?php
      $this->renderPartial('_addlink', array(
          'link' => $link,
          'links' => $links,
          'idea_id' => $idea_id ));
    ?>
  </div>
</div>

<div class="row createidea">
  <div class="columns edit-header">
    <h3>
      <?php echo Yii::t('app', 'Project team'); ?>
    </h3>
  </div>
  <div class="columns panel edit-content">
    <?php
      $this->renderPartial('_formmembersedit', array(
          'id' => $id,
          'lang' => $lang,
          'ideadata' => $ideadata,
          'idea_id' => $idea_id,
          'invitees' => $invite['data'],
          'invitations' => $invite['count'],
          'isOwner'=>$isOwner));
    ?>
  </div>
</div>


<div class="row">
  <div class="columns edit-header">
    <a id="link_position" class="anchor-link"></a>
      
    <div class="right">
      <?php if(!isset($candidate)){ ?>
      <a class="small abtn secondary button radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl('project/edit',array('id'=>$id,'lang'=>$lang,'candidate'=>'new')); ?>#link_position">
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
