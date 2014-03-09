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

<?php if(isset($idea_id) && $idea->deleted == 2){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2, 'publish'=>1)); ?>><?php echo Yii::t('app', 'Publish'); ?></a>
<?php } elseif(isset($idea_id) && $idea->deleted == 0){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2, 'publish'=>0)); ?>><?php echo Yii::t('app', 'Unpublish'); ?></a>
<?php } ?>

<div class="row">
    <div class="columns edit-header">
        <h3><?php if (!isset($candidate)) {
                echo Yii::t('app', 'Open positions');
            } else echo Yii::t('app', 'New positions');?>
        </h3>
      <ul class="button-group radius right mt10">
         <li><a class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>>1.<?php echo Yii::t('app', 'Presentation'); ?></a></li>
         <li><a class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>>2.<?php echo Yii::t('app', 'Story'); ?></a></li>
         <li><a class="button tiny " href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>>3.<?php echo Yii::t('app', 'Team'); ?></a></li>
        <li><a  class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>>4. <?php echo Yii::t('app',"You are done!");?></a></li>
      </ul>
    </div>
    <div class="columns panel edit-content">
        <div class="row">
            <div class="left mb20">
                <?php if (!isset($candidate)) { ?>
                    <a class="small button abtn secondary radius" style="margin-bottom:0;"
                       href="<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3, 'candidate' => 'new')); ?>">
                        <?php echo Yii::t('app', 'Add new') ?>
                        <span class="icon-plus"></span>
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

    <?php

    if (!isset($_GET['candidate'])) {
        ?>
            <a href="<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>" class="button large success radius right">
                <?php echo Yii::t("app", "Next >>"); ?>
            </a>
        <?php
    } ?>

</div>
