<a class="button radius small left" href="#"
   onclick="$('.addLinks').toggle(); return false;"><?php echo Yii::t('app', "Custom links"); ?>
    <span class="icon-plus"></span>
</a>
<br/>
<div class="addLinks" style="display:none">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'LinkForm',
//             'enableClientValidation'=>true,
        'htmlOptions' => array(
            'onsubmit' => "return false;", /* Disable normal form submit */
            //'onkeypress'=>" if(event.keyCode == 13){ addLink('".Yii::app()->createUrl("profile/addLink")."'); } " /* Do ajax call when user presses enter key */
        ),
    )); ?>

    <?php echo $form->errorSummary($link); ?>

    <div class="clearfix" style="clear: both">
        <?php echo $form->labelEx($link, 'title'); ?>
        <span class="description">
                     <?php echo Yii::t('msg', 'Chose a name to represent your link.'); ?>
                  </span>
        <?php echo $form->textField($link, 'title'); ?>

        <?php echo $form->labelEx($link, 'url'); ?>
        <?php echo $form->textField($link, 'url'); ?>

        <?php echo CHtml::submitButton(Yii::t("app", "Add link"),
                array('class' => "button small success radius",
                    'onclick' => 'addLink(\'' . Yii::app()->createUrl("project/addLink/" . $idea_id) . '\');')
            );
        ?>

        <?php $this->endWidget(); ?>
    </div>

</div>
</p>
<div class="linkList">
    <?php if (isset($links) && is_array($links)) {
        foreach ($links as $url => $title) { ?>
            <div data-alert class="alert-box radius secondary" id="link_div_<?php echo $url; ?>">
                <img src="<?php echo getLinkIcon($url); ?>">
                <?php echo $title; ?>: <a href="<?php echo add_http($url); ?>" target="_blank"><?php echo $url; ?></a>
                <a href="#" class="close" onclick="removeLink('<?php echo $url; ?>','<?php if ($idea_id) {
                    echo Yii::app()->createUrl("project/deleteLink/" . $idea_id);
                } else {
                    echo Yii::app()->createUrl("project/sDeleteLink");
                } ?>')">&times;</a>
            </div>
        <?php }
    } ?>
</div>