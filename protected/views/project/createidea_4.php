<?php
$this->pageTitle = Yii::t('app', 'Edit - step 2');
?>
<script>
  var inviteMember_url = '<?php echo Yii::app()->createUrl("project/suggestMember",array("ajax"=>1)) ?>'; 
</script>

<div class="mb40 row pb0">
     
    <div class="stageflow" style="">
        <div class="large-12">
           
            <ul class="button-group mb0">
            <li><a class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 1)); ?>><?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button small mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 2)); ?>><?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button small mb0 before-selected" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 3)); ?>><?php echo Yii::t('app','Open positions'); ?></a></li>
            <li><a  class="button small selected mb0" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4)); ?>><?php echo Yii::t('app',"You are done!");?></a></li>
            </ul>            
      </div>
    </div>
    
</div>

<?php if(isset($idea_id) && $idea->deleted == 2){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4, 'publish'=>1)); ?>><?php echo Yii::t('app', 'Publish'); ?></a>
<?php } elseif(isset($idea_id) && $idea->deleted == 0){ ?>
<a class="button tiny" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4, 'publish'=>0)); ?>><?php echo Yii::t('app', 'Unpublish'); ?></a>
<?php } ?>

<div class="row createidea">
    <div class="columns edit-header">
        <h3>
            <?php echo Yii::t('app', "You are done!"); ?>
        </h3>

       
    </div>
    <div class="columns panel edit-content">
        <?php
        $this->renderPartial('_formmembers', array(
            'ideadata' => $ideadata,
            'invitees' => $invites['data']));
        ?>

        <?php
        $this->renderPartial('_addlink', array(
            'link' => $link,
            'links' => $links,
            'idea_id' => $idea_id));
        ?>
    </div>
</div>