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
          
      <?php  if($member['type_id'] != 1){
            echo CHtml::ajaxButton(Yii::t("app","Remove"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to remove this member from the team!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); } ?>
        </div>        

      <a href="<?php echo Yii::app()->createUrl("person/{$member['id']}"); ?>"><h5><img src="<?php echo avatar_image($member['avatar_link'], $member['id']); ?>" width="25"> <?php echo $member['name'] . " ". $member['surname'];?></h5></a>
        
    </div>

<?php }} ?>


<?php if ($invitees){ ?>
<hr>

  <?php echo CHtml::beginForm('','post',array("class"=>"custom large-6")); ?>

      <?php echo CHtml::label(Yii::t('app','New members email'),'message'); ?>
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


<h5><?php echo Yii::t('app','Invited to project'); ?></h5>
<p>
  <?php foreach($invitees as $row){ ?>
  <?php echo $row->email; ?>,
  <?php } ?>
</p>
<?php } ?>

