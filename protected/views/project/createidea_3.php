<?php
$this->pageTitle = Yii::t('app', 'Story');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>



        <?php
        $this->renderPartial('_formidea3', array(
            'translation' => $translation,
            'buttons' => 'create'));
        ?>


    <?php echo CHtml::submitButton(Yii::t("app", "Next >>"),
    array('class' => "button large success radius right mt10")
); ?>
