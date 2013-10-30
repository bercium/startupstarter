<div class="large-12 columns">
<?php $this->pageTitle = Yii::t('app','My projects'); ?>

<div class="row myprojects">
  <div class="columns edit-header">
   
		
    <h3><?php echo Yii::t('app', 'My projects'); ?></h3>
  </div>
    
<?php
if (isset($user['idea']))
foreach($user['idea'] AS $key => $idea){
	if ($idea['type_id'] != 1) continue;
?>
      <div class="columns edit-content middle">
        <div class="edit-floater">
          
      <?php  echo CHtml::link(Yii::t("app","Delete"),Yii::app()->createUrl('project/deleteIdea',array('id'=>$idea['id'])),
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>
        </div>        

        <p class="mt-10"><a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><?php echo $idea['title'];?></a></p>
        <small class="mb-10 block">
          <span class="meta"><?php echo Yii::t('app', 'created on'); ?> </span><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?> | 
          <?php echo Yii::t('app', '<span class="meta">has</span> {n} member| has {n} members',count($idea['member'])); ?> | 
          <?php echo Yii::t('app', '<span class="meta">viewed</span> {n} time| viewed {n} times',$idea['num_of_clicks']); ?>
           </small>
           <small>
          <?php 
           if (isset($idea['translation_other']) && count($idea['translation_other'])){ ?>
           <span class="meta">translations: </span>
          <?php foreach ($idea['translation_other'] as $trans){ ?>
            <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}?lang={$trans['language_code']}"); ?>"><?php echo $trans['language'];?></a>
          <?php }          
            }
          ?>
        </small>
      </div>
<?php
}
?>    
    
</div>
 
     <!-- <a class="small button success radius" style="margin-bottom:0;" href="<?php //echo  Yii::app()->createUrl("project/create"); ?>"><?php // echo Yii::t('app','Create new project') ?></a> -->
   

<div class="row myprojects" style="margin-top:20px;">
  <div class="  columns edit-header">
    <h3><?php echo Yii::t('app', "Projects I'm member of"); ?></h3>
  </div>
    
<?php
if (isset($user['idea']))
foreach($user['idea'] AS $key => $idea){
	if ($idea['type_id'] != 2) continue;
?>
    <div class="columns edit-content middle">

        <div class="edit-floater">
          
      <?php  echo CHtml::link(Yii::t("app","Leave project"),Yii::app()->createUrl('project/leaveIdea',array('id'=>$idea['id'])),
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nYou will have to be re invited to be a member.\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div>

        <p class="mt-10"><a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><?php echo $idea['title'];?></a></p>
        <small class="meta">
          <p><?php echo Yii::t('app', 'created on'); ?> <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?> | 
          <?php echo Yii::t('app', 'has <span>{n} member</span>| has <span>{n} members</span>',count($idea['member'])); ?> | 
          <?php echo Yii::t('app', 'viewed <span>{n} time</span>| viewed <span>{n} times</span>',$idea['num_of_clicks']); ?>
          </p>
        </small>

    </div>
<?php
}
?>    
    
</div>

<?php

Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.idea'); ?>
</div>