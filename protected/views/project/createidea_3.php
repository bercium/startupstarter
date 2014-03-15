<?php
$this->pageTitle = Yii::t('app', 'Edit - step 2');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>


<div class="mb40 row pb0">
     
    <div class="stageflow" style="">
        <div class="large-12">
           
            <ul class="button-group mb0">
            <li><a class="button small before-selected mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>><?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button small mb0 selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>><?php echo Yii::t('app','Open positions'); ?></a></li>
            <li><a  class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>><?php echo Yii::t('app',"You are done!");?></a></li>
            </ul>            
      </div>
    </div>
    
</div>


<div class="row createidea">
    <div class="columns edit-header">
        <div class="large-centered large-10 columns">
        <h3>
            <?php echo Yii::t('app', 'Project story'); ?>
        </h3>

        </div>

       
    </div>
    <div class="columns panel edit-content">
        <div class="large-centered large-10 columns">

        <?php
        $this->renderPartial('_formidea3', array(
            'translation' => $translation,
            'buttons' => 'create'));
        ?>
        </div>
    </div>

    <?php echo CHtml::submitButton(Yii::t("app", "Next >>"),
    array('class' => "button large success radius right mt10")
); ?>
<?php echo CHtml::endForm(); ?>