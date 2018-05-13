<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>
<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile($baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_HEAD);


echo CHtml::beginForm('', 'post', array('class' => "custom formidea"));

 ?>

<p class="meta f-small"><?php echo yii::t('msg','Tell us what is your project about. What problems are you solving and how you plan to solve them.'); ?></p> 

<span class="description">

<?php echo CHtml::activeTextArea($translation, "description", array('class' => 'lin-edit ckeditor')); ?>

    <br/>
    <!--    --><?php //echo CHtml::activeLabelEx($translation, 'description_public'); ?>
    <!--    <div class="switch small round" style="text-align: center; width:120px;">-->
    <!--        <input id="description_public_0" name="IdeaTranslation[description_public]" type="radio"-->
    <!--               value="0" --><?php //if (!$translation->description_public) echo 'checked="checked"' ?><!-->
    <!--        <label for="description_public_0" onclick="">--><?php //echo Yii::t('app', 'Off'); ?><!--</label>-->
    <!---->
    <!--        <input id="description_public_1" name="IdeaTranslation[description_public]" type="radio"-->
    <!--               value="1" --><?php //if ($translation->description_public) echo 'checked="checked"' ?><!-->
    <!--        <label for="description_public_1" onclick="">--><?php //echo Yii::t('app', 'On'); ?><!--</label>-->
    <!--        <span></span>-->
    <!--    </div>-->