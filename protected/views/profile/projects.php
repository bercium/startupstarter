<div class="row">
  <div class="small-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'My projects'); ?></h3>
  </div>
  <div class="small-12 columns panel edit-content">
    
<?php
foreach($this->data['user']['idea'] AS $key => $idea){
?>
    <div class="row panel" onclick="location.href='<?php echo Yii::app()->createUrl("idea/edit/{$key}"); ?>'">

        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Delete"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("app","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>        

        <a href="<?php echo Yii::app()->createUrl("idea/edit/{$key}"); ?>"><h5><?php echo $idea['title'];?></h5></a>
        <small class="meta">created on <a><?php echo $idea['time_registered'];?></a> | has <a>3 members</a> | viewed <a>3 times</a></small>

    </div>
<?php
}
?>    
    
  </div>
</div>

<?php print_r($data);?>