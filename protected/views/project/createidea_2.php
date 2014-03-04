<?php
$this->pageTitle = Yii::t('app', 'Create - step 2');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
    var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
    var inviteMember_url = '<?php echo Yii::app()->createUrl("project/suggestMember",array("ajax"=>1)) ?>';
</script>

<div class="row">
    <div class="columns edit-header">
        <div class="right">
            <?php if (!isset($candidate)) { ?>
                <a class="small button abtn secondary radius" style="margin-bottom:0;"
                   href="<?php echo Yii::app()->createUrl('project/edit', array('step' => 2, 'candidate' => 'new')); ?>">
                    <?php echo Yii::t('app', 'Add new') ?>
                    <span class="icon-plus"></span>
                </a>
            <?php } ?>
        </div>

        <h3><?php if (!isset($candidate)) {
                echo Yii::t('app', 'Open positions');
            } else echo Yii::t('app', 'New positions');?>
        </h3>

    </div>
    <div class="columns panel edit-content">

        <?php if (isset($candidate) && isset($match)) {
            $this->renderPartial('_formteam', array(
                'ideadata' => $ideadata,
                'candidate' => $candidate,
                'match' => $match,
                'buttons' => 'create'));
        } else {
            $this->renderPartial('_formteam', array(
                'ideadata' => $ideadata,
                'buttons' => 'create'));
        }?>


        <?php

        if (!isset($_GET['candidate'])) {

            echo "<hr>" . CHtml::submitButton(Yii::t("app", "Finish"),
                    array('class' => "button small success radius",
                        'onclick' => 'window.location.href=(\'' . $idea_id . '\');')
                );

        } ?>

    </div>
</div>    
