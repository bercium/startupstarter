
<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>
<?php if (!Yii::app()->user->getState('fpi')){ ?>
<div class="intro">
  <div  class="row" >
    <div class="large-12 small-12 columns" style="text-align: center;" >

      <h1>With the <span>right team</span> any <span class="isc">idea</span> can change your life</h1>

      <div class="row">
        <div class="large-7 small-12 columns <?php if (!Yii::app()->user->isGuest) echo ""; ?>">
          <p>
            <?php echo CHtml::encode(Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.')); ?>
          </p>
        </div>
				<?php if (Yii::app()->user->isGuest){ ?>
        <div class="large-5 small-12 columns hide-for-small">
          
          <br>
          <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button right round large success" >Register here </a> 
          <a href="#" data-dropdown="drop-login" class="button right round large secondary" >Login </a>
          
         
        </div>
        <div class="large-6 small-12 columns show-for-small">
          <br>
          <br>
          <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button round large success" >Register here </a> 
          <a href="#" data-dropdown="drop-login" class="button round large secondary" >Login </a>
          
         
        </div>

        <?php } ?>
      </div>

      <a  href="#" class="row close centered" data-tooltip title="<?php echo CHtml::encode(Yii::t('app','Hide intro')); ?>" onclick="$('.intro').slideUp('slow');"><span class="general-enclosed foundicon-up-arrow"></span></a>

    </div>
  </div>
</div>
<?php } ?>


<div class="row panel searchpanel radius" style="margin-top: 20px;">
	<div class="large-12 small-12 columns search_content edit-header">
     <?php echo CHtml::beginForm('','post',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>

      
		<div class="row">
		  <div class="large-4 small-12 columns">
    		<h4 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Narrow your search to:')); ?> </h4>
      </div>
		  <div class="large-8 small-12 columns">
          <div  class="exp_srch">
      <a class="meta" href="#" onclick="$('.advance').slideToggle('slow'); return false;">Advanced search <span class="general-enclosed foundicon-down-arrow"></span></a>
    </div>

			<div class="switch large-3 left small round small-3" onclick="$('#filter_projects').toggle();$('#filter_people').toggle();">
        <input id="project_0" name="SearchForm[isProject]" type="radio" value="1" <?php if ($filter->isProject) echo 'checked="checked"' ?>>
        <label for="project_0" onclick=""><?php echo Yii::t('app','Projects'); ?></label>

        <input id="project_1" name="SearchForm[isProject]" type="radio" value="0" <?php if (!$filter->isProject) echo 'checked="checked"' ?>>
        <label for="project_1" onclick=""><?php echo Yii::t('app','People') ?></label>
        <span></span>
      </div>
      </div>
		</div>
    
    <div class="advance">
		 <div class="row">
      <hr>

      
      <div id="filter_projects" <?php if (!$filter->isProject) echo 'style="display:none"'; ?>>
         <div class="large-3 small-6 columns">
		    <label>search by keywords:</label>
		    <input type="text" placeholder="keywords">
          </div>
          <div class="large-3 small-6 columns">
            <label>search by skills:</label>
            <input type="text" placeholder="skills">
          </div>
         <div class="large-3 left small-6 columns">

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
      <div class="small-12 large- columns">
            <?php echo CHtml::submitButton(Yii::t("app","Search"),
                  array('class'=>"button small radius")
              ); ?>
      </div>
    </div>
    </div>
      
    <?php echo CHtml::endForm(); ?>
    
  
	
	</div>
</div>
  


<?php if (isset($data['user'])){ ?>

	<div class="row" id="recent_users">
		<?php $this->renderPartial('//person/_recent', array('users' => $data['user'],"page"=>1,"maxPage"=>3)); ?>
    </div>

<?php } ?>


<?php if (isset($data['idea'])){ ?>

	<div class="row" id="recent_projects">
		<?php $this->renderPartial('//project/_recent', array('ideas' => $data['idea'],"page"=>1,"maxPage"=>3)); ?>
	</div>

<?php } ?>


<?php 

Yii::log(arrayLog($data['idea']), CLogger::LEVEL_INFO, 'custom.info.idea'); 
Yii::log(arrayLog($data['user']), CLogger::LEVEL_INFO, 'custom.info.user'); 
?>
