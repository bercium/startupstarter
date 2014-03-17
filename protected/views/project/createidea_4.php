<?php
$this->pageTitle =  Yii::t('app', "You are done!");
?>
<script>
  var inviteMember_url = '<?php echo Yii::app()->createUrl("project/suggestMember",array("ajax"=>1)) ?>'; 
</script>

        <?php
        $this->renderPartial('_formmembers', array(
            'ideadata' => $ideadata,
            'invitees' => $invites['data']));
        ?>

        <hr>

        <?php
        $this->renderPartial('_addlink', array(
            'link' => $link,
            'links' => $links,
            'idea_id' => $idea_id));
        ?>

        <hr>

        <div class="clearfix">
            <?php if(isset($idea_id) && $idea->deleted == 2){ ?>
                <a style="width: 100%" class="button large success radius right" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4, 'publish'=>1)); ?>><?php echo Yii::t('app', 'Publish'); ?></a>
            <?php } elseif(isset($idea_id) && $idea->deleted == 0){ ?>
                <a style="width: 100%" class="button large alert radius right" href=<?php echo Yii::app()->createUrl('project/edit', array('id'=>$idea_id, 'step' => 4, 'publish'=>0)); ?>><?php echo Yii::t('app', 'Unpublish'); ?></a>
            <?php } ?>
        </div>

        <br style="clear: both" />