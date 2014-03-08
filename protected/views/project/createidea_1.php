<?php
$this->pageTitle = Yii::t('app', 'Create - step 1');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>

<?php if(isset($idea_id) && $idea->deleted == 2){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1, 'publish'=>1)); ?>><?php echo Yii::t('app', 'Publish'); ?></a>
<?php } elseif(isset($idea_id) && $idea->deleted == 0){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1, 'publish'=>0)); ?>><?php echo Yii::t('app', 'Unpublish'); ?></a>
<?php } ?>

<div class="row createidea">
    <div class="columns edit-header">
        <h3>
            <?php echo Yii::t('app', 'Project presentation'); ?>
        </h3>
        <?php if(isset($idea_id)){ ?>
        <ul class="button-group radius right mt10">
            <li><a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>>1. <?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>>2. <?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>>3. <?php echo Yii::t('app', 'Team'); ?></a></li>
            <li><a class="button tiny secondary" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>>4. <?php echo Yii::t('app', "You are done!"); ?></a></li>
        </ul>
        <?php } else { ?>
        <ul class="button-group radius right mt10">
            <li><a class="button tiny">1. <?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button tiny secondary">2. <?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button tiny secondary">3. <?php echo Yii::t('app', 'Team'); ?></a></li>
            <li><a class="button tiny secondary">4. <?php echo Yii::t('app', "You are done!"); ?></a></li>
        </ul>
        <?php } ?>
    </div>
    <div class="columns panel edit-content">
        <?php
        $this->renderPartial('_formidea', array(
            'idea' => $idea,
            'language' => $language,
            'translation' => $translation,
            'buttons' => 'create'));
        ?>
    </div>
