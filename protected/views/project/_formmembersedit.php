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

        <a href="<?php echo Yii::app()->createUrl("person/{$member['id']}"); ?>"><h5><?php echo $member['name'] . " ". $member['surname'];?></h5></a>
        
    </div>

<?php }} ?>


<?php echo CHtml::label('member','member'); ?>
<?php echo CHtml::textField('member', '', array("class"=>"finduser")); ?>           
