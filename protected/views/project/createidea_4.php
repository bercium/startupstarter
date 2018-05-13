<?php
$this->pageTitle =  Yii::t('app', "Present extra details via links");
?>

<?php echo CHtml::beginForm('', 'post', array('class' => "custom formidea","id"=>'form-link-save')); ?>

<div class="row  pt40 pb40">
  <div class="large-4 columns">
     <div class="mt10"><?php echo CHtml::activeLabelEx($idea, 'website'); ?></div>
  </div>

  <div class="large-8 columns">
       
       
            <?php echo CHtml::activeTextField($idea, "website", array('maxlength' => 128, 'class' => 'lin-edit')); ?>
        
    </div>
</div>        


<div class="row  pt40 pb40 btop">
  <div class="large-4 columns">
     <?php echo CHtml::activeLabelEx($idea, 'video_link'); ?>
      <span class="description">
      <?php echo Yii::t('msg', 'Link of the project\'s video presentation.'); ?>
     </span>
  </div>

  <div class="large-8 columns">
       
       
           <?php echo CHtml::activeTextField($idea, "video_link", array('maxlength' => 128, 'class' => 'lin-edit')); ?>
        
    </div>
</div>

<?php echo CHtml::endForm(); ?>

        <?php
        $this->renderPartial('_addlink', array(
            'link' => $link,
            'links' => $links,
            'idea_id' => $idea_id));
        ?>

    <a href="#" onclick="$('#form-link-save').submit()" class="button large success radius right">
        <?php echo Yii::t("app", "Next >>"); ?>
    </a>