<?php
$this->pageTitle = Yii::t('app', 'Create - step 1');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>


  <?php if(isset($idea_id)){ ?>
        <div class="mb40 row pb0">     
            <div class="stageflow" style="">
                <div class="large-12">
                    <ul class="button-group mb0">
                        <li><a class="button small selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>><?php echo Yii::t('app', 'Presentation'); ?></a></li>
                        <li><a class="button small" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', 'Story'); ?></a></li>
                        <li><a class="button small" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>><?php echo Yii::t('app','Open positions'); ?></a></li>
                        <li><a class="button small" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', "You are done!"); ?></a></li>
                    </ul>
                </div>
            </div>

        </div>

        <?php } else { ?>
        <div class="mb40 row pb0">     
            <div class="stageflow" style="">
                <div class="large-12">
                    <ul class="button-group mb0">
                        <li><a class="button small selected"><?php echo Yii::t('app', 'Presentation'); ?></a></li>
                        <li><a class="button small"><?php echo Yii::t('app', 'Story'); ?></a></li>
                        <li><a class="button small"><?php echo Yii::t('app', 'Team'); ?></a></li>
                        <li><a class="button small"><?php echo Yii::t('app', "You are done!"); ?></a></li>
                    </ul>
             </div>
            </div>
        </div>
        <?php } ?>



<div class="row createidea">
    <div class="columns edit-header">
        <div class="large-centered large-10 columns align-center"><h3>
            <?php echo Yii::t('app', 'Project presentation'); ?>
        </h3>
        </div>

      
    </div>
    <div class="columns panel edit-content">
       <div class="large-10 large-centered columns">

        <?php
        $this->renderPartial('_formidea', array(
            'idea' => $idea,
            'language' => $language,
            'translation' => $translation,
            'ideagallery' => $ideagallery,
            'idea_id' => $idea_id,
            'buttons' => 'create'));
        ?>
        </div>
    </div>
