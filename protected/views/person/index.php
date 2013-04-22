<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$user = $data['user'];

print_r($user);
?>
<div class="row">
<div class="large-12 small-12 columns radius panel card-person">
  
  <div class="row card-person-title">
    <div class="large-12 small-12 columns" >
      <img src="<?php echo avatar_image($user['avatar_link'],$user['id'],false); ?>" style="height:100px; margin-right: 10px; float:left;" />
      <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
      <small class="meta">Naslov 15</small><br />
      <strong><small class="meta">Ljubljana, Slovenia</small></strong><br />
      <small class="meta"><?php echo Yii::t('app','Member since:') ?> 
        <a><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']),"long",null); ?></a></small>
      <div class="card-floater">
        <a class="small button success radius" style="margin-bottom:0;" href=""><?php echo Yii::t('app','Contact me') ?></a>
      </div>
    </div>
  </div>

  <div  class="row">
    <div class="large-5 small-12 columns"  >
      <small class="meta">
        <?php echo Yii::t('app','Has skills:'); ?> 
        <span class="button tiny secondary meta_tags" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> 
        <span class="button tiny secondary meta_tags" data-tooltip title="Sales">Economics</span>
      </small>        
      <small class="meta"><?php echo Yii::t('app','Colaboration:') ?> <a>monetary, cofinder</a></small><br />
      <small class="meta"><?php echo Yii::t('app','Available:') ?> <a>part time</a></small><br />
      <small class="meta"><?php echo Yii::t('app','Involved in') ?> <a><?php echo Yii::t('app','{n} project|{n} projects',array(3)) ?></a></small>
      <div class="card-floater" style="border:none;">
        <a class="small button success radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>"><?php echo Yii::t('app','details...') ?></a>
      </div>
    </div>
    <div class="large-7 small-12 columns"  >
      <small class="meta">
        <?php echo Yii::t('app','Has skills:'); ?> 
        <span class="button tiny secondary meta_tags" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> 
        <span class="button tiny secondary meta_tags" data-tooltip title="Sales">Economics</span>
      </small>        
      <small class="meta"><?php echo Yii::t('app','Colaboration:') ?> <a>monetary, cofinder</a></small><br />
      <small class="meta"><?php echo Yii::t('app','Available:') ?> <a>part time</a></small><br />
      <small class="meta"><?php echo Yii::t('app','Involved in') ?> <a><?php echo Yii::t('app','{n} project|{n} projects',array(3)) ?></a></small>
      <div class="card-floater" style="border:none;"> 
        <a class="small button success radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>"><?php echo Yii::t('app','details...') ?></a>
      </div>
    </div>    
  </div>

</div>
</div>
