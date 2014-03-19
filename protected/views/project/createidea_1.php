<?php
$this->pageTitle = Yii::t('app', 'Basic info');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>


        <?php
        $this->renderPartial('_formidea', array(
            'idea' => $idea,
            'language' => $language,
            'translation' => $translation,
            'ideagallery' => $ideagallery,
            'idea_id' => $idea_id,
            'buttons' => 'create'));
        ?>
