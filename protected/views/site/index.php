
<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>
<?php if (!Yii::app()->user->getState('fpi')){ ?>
<div class="intro">
  <div  class="row" >
    <div class="large-12 small-12 columns" style="text-align: center;" >

      <h1>With the <span>right team</span> any <span>idea</span> can change your life</h1>

      <div class="row">
        <div class="large-6 small-12 columns <?php if (!Yii::app()->user->isGuest) echo "large-centered"; ?>">
          <p>
            <?php echo CHtml::encode(Yii::t('app','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.')); ?>
          </p>
        </div>
				<?php if (Yii::app()->user->isGuest){ ?>
        <div class="large-6 small-12 columns">
          <br>
          <br>
          <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button round medium success" >Register here </a> 
          <a href="#" data-dropdown="drop-login" class="button round medium secondary" >Login </a>
        </div><?php } ?>
      </div>

      <a href="#" class="close" data-tooltip title="<?php echo CHtml::encode(Yii::t('app','Hide intro')); ?>" onclick="$('.intro').slideUp('slow');"> &#x25B2; </a>

    </div>
  </div>
</div>
<?php } ?>


<div class="row panel radius" style="margin-top: 20px;">
	<div class="large-12 small-12 columns">
     <?php echo CHtml::beginForm('','post',array('class'=>"custom")); ?>

      
		 <div class="row">
		  <div class="large-5 small-12 columns">
    		<h4 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Narow your search')); ?>: </h4>
      </div>
		  <div class="large-7 small-12 columns">
    		
      <div class="row collapse">
        <div class="small-9 large-10 columns">
          <?php echo CHtml::activeTextField($filter,'generalSearch',array("placeholder"=>Yii::t('app','search by keywords'))); ?>
        </div>
        <div class="small-3 large-2 columns">
          <?php echo CHtml::submitButton(Yii::t("app","Search"),
                      array('class'=>"button postfix radius")
                  ); ?>
        </div>
      </div>
        
      </div>
		</div>
    <div class="advance">
		 <div class="row">
      <hr>
      <div class="switch small round small-2" onclick="$('#filter_projects').toggle();$('#filter_people').toggle();">
        <input id="project_0" name="SearchForm[isProject]" type="radio" value="0" <?php if ($filter->isProject) echo 'checked="checked"' ?>>
        <label for="project_0" onclick=""><?php echo Yii::t('app','Projects'); ?></label>

        <input id="project_1" name="SearchForm[isProject]" type="radio" value="1" <?php if (!$filter->isProject) echo 'checked="checked"' ?>>
        <label for="project_1" onclick=""><?php echo Yii::t('app','People') ?></label>
        <span></span>
      </div>
      
      <div id="filter_projects" <?php if (!$filter->isProject) echo 'style="display:none"'; ?>>
         <div class="large-3 small-6 columns">
		    <label>search by keywords:</label>
		    <input type="text" placeholder="keywords">
          </div>
          <div class="large-3 small-6 columns">
            <label>search by skills:</label>
            <input type="text" placeholder="skills">
          </div>
         <div class="large-3 small-6 columns">

          <label for="customDropdown1">Search by something</label>
          <select id="customDropdown1" class="medium">
            <option>This is a dropdown</option>
            <option>This is another option</option>
            <option>This is another option too</option>
            <option>Look, a third option</option>
          </select>

        </div>
      </div>
      
      <div id="filter_people" <?php if ($filter->isProject) echo 'style="display:none"'; ?>>
        <div class="large-3 small-6 columns">
        <label for="photos"><input type="checkbox" style="display: none;" id="has-photos"><span class="custom checkbox"></span> Photos (44)</label>
        <label for="video"><input type="checkbox" style="display: none;" id="has-video" checked=""><span class="custom checkbox checked"></span> Videos (34)</label>
        <label for="detailed_description"><input type="checkbox" style="display: none;" checked="" id="has-description"><span class="custom checkbox checked"></span> Detailed Description (53)</label>
        <label for="attachment"><input type="checkbox" style="display: none;" id="has-attachment" checked=""><span class="custom checkbox checked"></span> Attachments (34)</label>			
        </div>
      </div>
      
		</div>
    <div class="row">
            <?php echo CHtml::submitButton(Yii::t("app","Search"),
                  array('class'=>"button small radius")
              ); ?>
    </div>
    </div>
      
    <?php echo CHtml::endForm(); ?>
    
    <div><a href="#" onclick="$('.advance').slideToggle('slow'); return false;">Advanced search +</a></div>
	
	</div>
</div>
  



<?php

if (isset($data['user'])){ ?>

<div  class="row">
  <ul class="small-block-grid-1 large-block-grid-3">
    
<?php foreach ($data['user'] as $user){ ?>
  <li>
	<?php  $this->renderPartial('_user', array('user' => $user));  ?>
	</li>
<?php } ?>
    </ul>
</div>

<?php } ?>

  
<?php if (isset($data['idea'])){ ?>

<div  class="row">
  <ul class="small-block-grid-1 large-block-grid-3">
<?php foreach ($data['idea'] as $idea){ ?>    
  
  <li>
	<?php  $this->renderPartial('_idea', array('idea' => $idea));  ?>
  </li>
  
<?php } ?>
</ul>
</div>
  
<?php } ?>

  
  <div class="pagination-centered">
  <ul class="pagination">
    <li class="arrow unavailable"><a href="">&laquo;</a></li>
    <li class="current"><a href="">1</a></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href="">4</a></li>
    <li class="unavailable"><a href="">&hellip;</a></li>
    <li><a href="">12</a></li>
    <li><a href="">13</a></li>
    <li class="arrow"><a href="">&raquo;</a></li>
  </ul>
</div>


<?php  ?>
<div class="row panel radius">
	<div class="large-12 small-12 columns">

<h3>Recent ideas (looking for candidates)</h3>
<?php //print_r($data['idea']); ?>

<h3>Recently registered users</h3>
<?php print_r($data['user']); ?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php   ?>

	</div>
</div>
