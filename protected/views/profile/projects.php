<div class="row">
  <div class="small-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'My projects'); ?></h3>
  </div>
  <div class="small-12 columns panel edit-content">
    
<?php
foreach($this->data['user']['idea'] AS $key => $idea){
?>
    <div class="row panel">

        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Delete"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("app","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>        

        <a href="<?php echo Yii::app()->createUrl("idea/edit/{$key}"); ?>"><h5><?php echo $idea['title'];?></h5></a>
        <small class="meta">
          <?php echo Yii::t('app', 'created on'); ?> <a><?php echo $idea['time_registered'];?></a> | 
          <?php echo Yii::t('app', 'has <a>{n} member</a>| has <a>{n} members</a>',3); ?> | 
          <?php echo Yii::t('app', 'viewed <a>{n} time</a>| viewed <a>{n} times</a>',3); ?>
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
foreach($this->data['user']['idea'] AS $key => $idea){
?>
    <div class="row panel">

        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Leave"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("app","You are about to leave this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>

        <a href="<?php echo Yii::app()->createUrl("idea/edit/{$key}"); ?>"><h5><?php echo $idea['title'];?></h5></a>
        <small class="meta">
          <?php echo Yii::t('app', 'created on'); ?> <a><?php echo $idea['time_registered'];?></a> | 
          <?php echo Yii::t('app', 'has <a>{n} member</a>| has <a>{n} members</a>',3); ?> | 
          <?php echo Yii::t('app', 'viewed <a>{n} time</a>| viewed <a>{n} times</a>',3); ?>
        </small>

    </div>
<?php
}
?>    
    
  </div>
</div>

<div class="row">
  <div class="small-12 columns edit-header">
    <h3><?php echo Yii::t('app', "Projects I'm member of"); ?></h3>
  </div>
  <div class="small-12 columns panel edit-content">
    
    <div class="row panel" >
        <div class="edit-floater">
          
      <?php  echo CHtml::ajaxButton(Yii::t("app","Delete"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("app","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>        
        <a href="<?php echo Yii::app()->createUrl("idea/edit/1"); ?>"><h5>Moja super ideja</h5></a>
        <small class="meta">created on <a>3.1.2013</a> | has <a>3 members</a> | viewed <a>3 times</a></small>
    </div>

    
  </div>
</div>

<?php print_r($data);?>