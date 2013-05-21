<div class="row">
  <div class="small-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'My projects'); ?></h3>
  </div>
  <div class="small-12 columns panel edit-content">
    
<?php
foreach($user['idea'] AS $key => $idea){
	if ($idea['type_id'] != 1) continue;
?>
    <div class="row panel">

        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Delete"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>        

        <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><?php echo $idea['title'];?></h5></a>
        <small class="meta">
          <?php echo Yii::t('app', 'created on'); ?> <a><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?></a> | 
          <?php echo Yii::t('app', 'has <a>{n} member</a>| has <a>{n} members</a>',0); ?> | 
          <?php echo Yii::t('app', 'viewed <a>{n} time</a>| viewed <a>{n} times</a>',$idea['num_of_clicks']); ?>
        </small>

    </div>
<?php
}
?>    
    
  </div>
</div>

<div class="row">
  <div class="small-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Projects I\'m member of'); ?></h3>
  </div>
  <div class="small-12 columns panel edit-content">
    
<?php
foreach($user['idea'] AS $key => $idea){
	if ($idea['type_id'] != 2) continue;
?>
    <div class="row panel">

        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Leave"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>

        <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><?php echo $idea['title'];?></h5></a>
        <small class="meta">
          <?php echo Yii::t('app', 'created on'); ?> <a><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?></a> | 
          <?php echo Yii::t('app', 'has <a>{n} member</a>| has <a>{n} members</a>',0); ?> | 
          <?php echo Yii::t('app', 'viewed <a>{n} time</a>| viewed <a>{n} times</a>',$idea['num_of_clicks']); ?>
        </small>

    </div>
<?php
}
?>    
    
  </div>
</div>

<?php

Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.idea');
