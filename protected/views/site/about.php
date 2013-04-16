<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>About the project page</h1>
<div class="row">
<div class="large-8 small-12 columns">
  ha ha o tem se gre kej ane  
</div>
<div class="large-4 small-12 columns radius panel card-idea">
    <div class="row card-idea-title" onclick="">
      <div class="large-12 small-12 columns"  >
        <h5>Super naslov moje super ideje</h5>
       <small><span class="meta">Stage: </span><a href="#">prototype</a></small>
        <div class="card-floater">
         <a href="#" class="heart">&hearts;</a> 
        </div>
		  </div>
	  </div>

    <div  class="row">
      <div class="large-12 small-12 columns">
        <div class="card-summary">
          <p>
        	 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
          </p>
        <hr>
        <small class="meta">
          Looking for skills:
           <span class="button tiny secondary meta_tags" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> <span class="button tiny secondary meta_tags" data-tooltip title="Sales">Economics</span>
           <span class="button tiny secondary meta_tags" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> <span class="button tiny secondary meta_tags" data-tooltip title="Sales">Economics</span>

        </small>
        </div>
        <p>
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          +3
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Has image" alt="Has image" class="card-icons" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Has file" alt="Has file" class="card-icons" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="has image" alt="has image" class="card-icons" />
        </p>
        <hr>
        <small class="meta">Updated: 31.5.2012</small>
        <div class="card-floater">
          <a class="button small radius"  href=""><?php echo Yii::t('app','details') ?></a>
        </div>
		  </div>
	  </div>
    
  </div>
  </div>