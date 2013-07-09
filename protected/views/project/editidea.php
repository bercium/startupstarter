<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <div class="edit-floater">

      <?php  
      
      if($isOwner){
        echo CHtml::link(Yii::t("app","Delete"),Yii::app()->createUrl('project/deleteIdea',array('id'=>$idea['id'])),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","You are about to delete this project!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );?>
      <?php 
      }else{
      echo CHtml::link(Yii::t("app","Leave project"),Yii::app()->createUrl('project/leaveIdea',array('id'=>$idea['id'])),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","You are about to leave this project!\nYou will have to be re invited to be a member.\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); 
      }?>
      
    </div>
    <h3><?php echo Yii::t('app', 'Edit project'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
  <?php
  $this->renderPartial('_formidea', array(
      'idea' => $idea,
      'data' => $data,
      'user' => $user,
      'buttons' => 'edit',
      'translation' => $translation));
  ?>
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Searching for'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>
