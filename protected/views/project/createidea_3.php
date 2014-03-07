<?php
$this->pageTitle = Yii::t('app', 'Edit - step 2');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
    <div class="columns edit-header">
        <h3>
            <?php echo Yii::t('app', 'Project story'); ?>
        </h3>

        <ul class="button-group radius right mt10">
            <li><a class="button tiny secondary">1.<?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button tiny">2.<?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button tiny secondary">3.<?php echo Yii::t('app', 'Team'); ?></a></li>
            <li><a class="button tiny secondary">4.<?php echo Yii::t('app', 'Extras'); ?></a></li>
            <li><a class="button tiny secondary"><?php echo Yii::t('app', "You are done!"); ?></a></li>
        </ul>
    </div>
    <div class="columns panel edit-content">
        <?php
        $this->renderPartial('_formidea3', array(
            'translation' => $translation,
            'buttons' => 'create'));
        ?>
    </div>