<div class="large-12 columns">
<?php $this->pageTitle = Yii::t('app','My projects'); ?>

<div class="row myprojects">
  <div class="columns edit-header">
   
		
    <h3><?php echo Yii::t('app', 'My projects'); ?></h3>
    <a class="button small radius secondary" href="<?php echo Yii::app()->createUrl("project/create"); ?>"><?php echo Yii::t('app','Create a new project'); ?> <span class="icon-plus"></span></a>
  </div>
    
<?php
if (isset($user['idea']))
foreach($user['idea'] AS $key => $idea){
	if ($idea['type_id'] != 1) continue;
?>
      <div class="columns edit-content middle">
        <div class="edit-floater">
          
      <?php  echo CHtml::link(Yii::t("app","Edit"),Yii::app()->createUrl('project/edit',array('id'=>$idea['id'])),
                  array('class'=>"button small radius",
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>
        </div>        

        <p class="mt10"><a href="<?php echo Yii::app()->createUrl("project",array('id'=>$key)); ?>"><?php echo $idea['title'];?></a></p>
        <small class="mb10 block">
          <span class=""><?php echo Yii::t('app', 'created on'); ?> </span><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?> | 
          <?php echo Yii::t('app', '<span class="">has</span> {n} member| has {n} members',count($idea['member'])); ?> | 
          <?php echo Yii::t('app', '<span class="">viewed</span> {n} time| viewed {n} times',$idea['num_of_clicks']); ?>
           </small>
           <small>
          <?php 
           if (isset($idea['translation_other']) && count($idea['translation_other'])){ ?>
           <span class=""><?php echo Yii::t('app','Translations'); ?></span>:
          <?php foreach ($idea['translation_other'] as $trans){ ?>
            <a href="<?php echo Yii::app()->createUrl("project/edit",array('id'=>$key,'lang'=>$trans['language_code'])); ?>"><?php echo $trans['language'];?></a> | 
          <?php }          
            }
          ?>
        </small>
      </div>
<?php
}
?>    
    
</div>
 
     <!-- <a class="small button success radius" style="margin-bottom:0;" href="<?php //echo  Yii::app()->createUrl("project/create"); ?>"><?php // echo Yii::t('app','Create a new project') ?></a> -->
   

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
                  array('class'=>"button small  secondary radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nYou will have to be re invited to be a member.\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
      <?php  echo CHtml::link(Yii::t("app","Edit"),Yii::app()->createUrl('project/edit',array('id'=>$idea['id'])),
                  array('class'=>"button small radius",
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>          
        </div>

        <p class="mt10"><a href="<?php echo Yii::app()->createUrl("project",array('id'=>$key)); ?>"><?php echo $idea['title'];?></a></p>
        <small class="">
          <p><?php echo Yii::t('app', 'created on'); ?> <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['time_registered']),"long",null); ?> | 
          <?php echo Yii::t('app', 'has <span>{n} member</span>| has <span>{n} members</span>',count($idea['member'])); ?> | 
          <?php echo Yii::t('app', 'viewed <span>{n} time</span>| viewed <span>{n} times</span>',$idea['num_of_clicks']); ?>
          </p>
        </small>
        <small>
          <?php 
           if (isset($idea['translation_other']) && count($idea['translation_other'])){ ?>
           <span class=""><?php echo Yii::t('app','Translations'); ?></span>:
          <?php foreach ($idea['translation_other'] as $trans){ ?>
            <a href="<?php echo Yii::app()->createUrl("project/edit",array('id'=>$key,'lang'=>$trans['language_code'])); ?>"><?php echo $trans['language'];?></a> | 
          <?php }          
            }
          ?>
        </small>
    </div>
<?php
}
?>    
    
</div>

<?php

Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.idea'); ?>
</div>