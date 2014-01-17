<div class="large-12 columns">
<?php $this->pageTitle = Yii::t('app','My notifications'); ?>

<div class="row myprojects">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Invitations to projects'); ?></h3>
  </div>
  <div class="columns panel edit-content">
    <?php //writeFlash("notificationMessage"); ?>
    
    <?php foreach ($invites as $row){ ?>
        
    <div class="panel">
        <div class="edit-floater">
          
      <?php 
          echo CHtml::link(Yii::t("app","Accept"),Yii::app()->createUrl('/profile/acceptInvitation',array('id'=>$row['id'])),
              array('class'=>"button small success radius",
                    'confirm'=>Yii::t("msg","You are about to join this project!")."\n".Yii::t("msg","Are you sure?"),
                    'onclick'=>"$(document).stopPropagation();",
                  )
          );
           ?>
          
             <?php
          echo CHtml::link(Yii::t("app","Decline"),Yii::app()->createUrl('/profile/declineInvitation',array('id'=>$row['id'])),
              array('class'=>"button small secondary radius",
                    'confirm'=>Yii::t("msg","You are about to remove your invitation!")."\n".Yii::t("msg","Are you sure?"),
                    'onclick'=>"$(document).stopPropagation();",
                  )
          );
      
        ?>
        </div>        
      <a href="<?php echo Yii::app()->createUrl("project",array("id"=>$row['id'])); ?>">
      <h5>
        <?php echo $row['title']; ?>
      </h5>
      </a>
      <small class="meta">
      <img src="<?php echo avatar_image($row['user']->avatar_link, $row['user']->id); ?>" width="15"> <?php echo $row['user']->name . " ". $row['user']->surname; ?>
      </small>
    </div>
    
    <?php } ?>
  </div>

  
</div>
</div>
