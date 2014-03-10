<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

 <?php if(isset($idea_id)){ ?>
        <div class="mb40 row pb0">     
            <div class="stageflow" style="">
                <div class="large-12">
                    <ul class="button-group mb0">
                        <li><a class="button small selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>><?php echo Yii::t('app', 'Presentation'); ?></a></li>
                        <li><a class="button small" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', 'Story'); ?></a></li>
                        <li><a class="button small" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>><?php echo Yii::t('app', 'Team'); ?></a></li>
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


<div class="row header-margin mb40">
	<div class="large-10 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo $this->pageTitle; ?></h1>
	</div>
  <div class="columns panel edit-content">
  	
    <?php echo $content; ?>
  </div>
  </div>
</div>

<?php $this->endContent(); ?>