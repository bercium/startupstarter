<script>
  var userSuggest_url = '<?php echo Yii::app()->createUrl("project/suggestUser",array("ajax"=>1)) ?>';
</script>

<?php
if(is_array($ideadata['member'])){
  foreach($ideadata['member'] AS $key => $member){
    //if ($member['type_id'] != 1) continue;
?>
    <div class="panel">

        <div class="edit-floater">
          
      <?php  if (($member['type_id'] != 1) && ($isOwner)){
        echo CHtml::link(Yii::t("app","Remove"),Yii::app()->createUrl('/project/deleteMember',array('id'=>$id,'user_id'=>$member['id'])),
              array('class'=>"button tiny alert radius",
                    'confirm'=>Yii::t("msg","You are about to remove this member!\nAre you sure?"),
                    'onclick'=>"$(document).stopPropagation();",
                  )
          );
        
              } ?>
        </div>        

      <a href="<?php echo Yii::app()->createUrl("person/{$member['id']}"); ?>"><h5><img src="<?php echo avatar_image($member['avatar_link'], $member['id']); ?>" width="25"> <?php echo $member['name'] . " ". $member['surname'];?></h5></a>
        
    </div>

<?php }} ?>


<?php if ($isOwner){ ?>
<span class="description">
  <?php echo Yii::t('msg','In private beta member invitations are disabled.'); ?>
</span>
<?php if ($invitations && yii::app()->user->isAdmin()){ ?>
<hr>

  <?php echo CHtml::beginForm('','post',array("class"=>"custom large-6")); ?>

      <?php echo CHtml::label(Yii::t('app','Invited to project'),'message'); ?>
      <div class="row collapse">
        <div class="small-9 columns">
          <?php echo CHtml::textField('invite-email'); ?>
          <?php echo CHtml::hiddenField('invite-idea',$ideadata['id']); ?>
        </div>
        <div class="small-3 columns">
           <?php echo CHtml::submitButton(Yii::t("app","Invite"),array("class"=>"postfix button radius")); ?>
        </div>
      </div>    
 
  <?php echo CHtml::endForm(); ?>

<?php if ($invitees){ ?>
<h5><?php echo Yii::t('app','Invited to project'); ?></h5>
<p>
  <?php foreach($invitees as $row){ ?>
  <?php echo $row->email; ?>,
  <?php } ?>
</p>
  <?php }
  }
}?>

