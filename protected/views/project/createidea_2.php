<?php
$this->pageTitle = Yii::t('app', 'Create - step 2');

  $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
  
    $cs->registerCssFile($baseUrl.'/css/tagmanager.css');
    $cs->registerScriptFile($baseUrl.'/js/tagmanager.js');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
    var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
    var inviteMember_url = '<?php echo Yii::app()->createUrl("project/suggestMember",array("ajax"=>1)) ?>';
</script>

<div class="mb40 row pb0">
     
    <div class="stageflow" style="">
        <div class="large-12">
           
            <ul class="button-group mb0">
            <li><a class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>><?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button small mb0 before-selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button small mb0 selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>><?php echo Yii::t('app','Open positions'); ?></a></li>
            <li><a  class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>><?php echo Yii::t('app',"You are done!");?></a></li>
            </ul>  

 


      </div>
    </div>
    
</div>



<div class="row">
    <div class="large-centered large-10 columns edit-header">
        
        <h3 ><?php if (!isset($candidate)) {
                echo Yii::t('app', 'Open positions');
            } else echo Yii::t('app', 'New positions');?>
        </h3>
        
      
    </div>
    <div class="large-centered large-10 columns panel edit-content">
        <div class="large-centered large-10 columns">
            <div class="row">
                <div class="" style="text-align:center;">
                    <?php if (!isset($candidate)) { ?>

                    <p><?php echo yii::t('msg','Post an open position for you project. Tell us who are you looking for.') ?></p>
                    
                    
                        <a class="button large-6 mb40 abtn radius" style="margin-bottom:0;"
                           href="<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3, 'candidate' => 'new')); ?>">
                            
                            <span class="icon-plus"></span> <?php echo Yii::t('app', 'Add new position') ?>
                            
                        </a>
                    <?php } ?>
                </div>
            </div>

            <?php if (isset($candidate) && isset($match)) {
                $this->renderPartial('_formteam', array(
                    'ideadata' => $ideadata,
                    'idea_id' => $idea_id,
                    'candidate' => $candidate,
                    'collabprefs' => $collabprefs,
                    'match' => $match,
                    'buttons' => 'create'));
            } else {
                $this->renderPartial('_formteam', array(
                    'ideadata' => $ideadata,
                    'idea_id' => $idea_id,
                    'buttons' => 'create'));
            }?>
        </div>
    </div>

    <?php

    if (!isset($_GET['candidate'])) {
        ?>
            <a href="<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>" class="button large success radius right">
                <?php echo Yii::t("app", "Next >>"); ?>
            </a>
        <?php
    } ?>

</div>
