<?php $this->pageTitle = Yii::t('app','Completeness of profile'); ?>


<div class="row myprojects">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Profile'); ?></h3>
  </div>
    
    <div class="columns edit-content middle">


      <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5>
        <span class="gen-enclosed foundicon-checkmark" style="color: #89B561"></span> </h5>
      </a>
      <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><span class="gen-enclosed foundicon-remove" style="color: #CD3438"></span> hehe</h5></a>
      <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><span class="gen-enclosed foundicon-checkmark" style="color: #89B561"></span> hehe</h5></a>
    </div>
    
</div>

<div class="row myprojects" style="margin-top:20px;">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Projects'); ?></h3>
  </div>
    
    <div class="columns edit-content middle">

      <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><span class="gen-enclosed foundicon-checkmark" style="color: #89B561"></span> hehe</h5></a>
    </div>
    
</div>


<div class="row myprojects" style="margin-top:20px;">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Settings'); ?></h3>
  </div>
    
    <div class="columns edit-content middle">


      <a href="<?php echo Yii::app()->createUrl("project/edit/{$key}"); ?>"><h5><span class="gen-enclosed foundicon-checkmark" style="color: #89B561"></span> hehe
      <small class="meta">
        opis
      </small>
          </h5>
        </a>
    </div>
    
</div>
