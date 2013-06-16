<?php
	$this->pageTitle = ''; // leave this empty
	$this->pageDesc = '';
?>

<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>
<?php if (!Yii::app()->user->getState('fpi')){ ?>


<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/sugestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/sugestCity",array("ajax"=>1)) ?>';
	var countrySuggest_url = '<?php echo Yii::app()->createUrl("site/sugestCountry",array("ajax"=>1)) ?>';
</script>

		
		<?php
    //!!! remove this and import JUI js and CSS :)
    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'name'=>'xyz',
				// additional javascript options for the autocomplete plugin
        'htmlOptions'=>array("style"=>'display:none'),
		));
		?>

<div class="intro" <?php if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
  <div  class="row" >
    <div class="large-12 small-12 columns" style="text-align: center;" >

<!-- Content if guest -->
<!-- #################################################################  -->
<?php if (Yii::app()->user->isGuest){ ?>
      <h1>With the <span>right team</span> any <span class="isc">idea</span> can change your life</h1>
      <div class="row">      	
        <div class="large-6 small-12 columns <?php if (!Yii::app()->user->isGuest) echo ""; ?>"></div>				
		<p>
            <?php echo CHtml::encode(Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.')); ?>
  		</p>
        <div class="large-5 small-12 columns hide-for-small">          
          <br>
          <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button right round medium success" >Register here </a> 
          <a href="#" data-dropdown="drop-login" class="button right round medium secondary" >Login </a>     
        </div>
        <div class="large-6 small-12 columns show-for-small">
          <br>
          <br>
          <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button round medium success" >Register here </a> 
          <a href="#" data-dropdown="drop-login" class="button round medium secondary" >Login </a>
        </div>

<!-- Content if logged in -->
<!-- #################################################################  -->
        <?php }
        	else { ?>
        	<h2>Welcome to user pages John Doe!<br>
        		Find the <span><a class="c_cofinder" href="#">right team</a></span> or post your <span class="isc"><a href="">idea</a></span>.</h2>
        	<p style="text-align: center;">
            <?php echo CHtml::encode(Yii::t('msg','Bi se lahko tukaj dalo pravilo da se zgornje izpiše ko se nekdo prvič prijavi? In pa: naprimer če klikne na find the right team se ga lahko pelje skozi proces izpolnitve svojega profila, kokr da bo tko lažje prišel do pravega teama.')); ?>
          </p>
		<div class="large-12 small-12  center  columns hide-for-small">
			
			<br>
<a href="#"  class="button round  medium secondary" >Learn more </a>	
<a href="#" class="button round medium " >Explore</a>	
<a  href="#" class="right button tiny secondary radius" data-tooltip title="<?php //echo CHtml::encode(Yii::t('app','hide the INTRO above')); ?>" onclick="$('.intro').slideUp('slow');">hide this intro<span class="icon-collapse-top"></span></a>
                      
        </div>
        <div class="large-6 small-12 columns show-for-small">
        
          <br>
          
          <a href="#"  class="button round medium secondary" >Learn more </a>	
<a href="#" class="button round medium " >Explore</a>	
          
         
        </div>

        <?php }
         ?>
      </div>      

    </div>
  </div>
</div>
<?php } ?>


<div class="row panel searchpanel radius" style="margin-top: 20px;">
	<div class="large-12 small-12 columns search_content edit-header">
      
		<div class="row">
		  <div class="large-4 small-12 columns">
    		<h4 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Narrow your search to:')); ?> </h4>
      </div>
		  <div class="large-8 small-12 columns">
				<div  class="exp_srch">
					<a class="button small secondary radius" href="#" onclick="$('.advance').toggle(); return false;">Advanced search <span class="icon-collapse"></span></a>
				</div>

				<div class="toggle_search switch large-3 right small round small-3" onclick="$('.filter_projects').toggle();$('.filter_people').toggle();">
					<input id="project_0" name="SearchForm[isProject]" type="radio" value="1" <?php if ($filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_0" onclick=""><?php echo Yii::t('app','Projects'); ?></label>

					
					<input id="project_1" name="SearchForm[isProject]"  type="radio" value="0" <?php if (!$filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_1" onclick=""><?php echo Yii::t('app','People') ?></label>
					<span></span>
				</div>
      </div>
		</div>

    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index"),'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
		<?php echo CHtml::hiddenField("SearchForm[isProject]", "1");  ?>
		
		<div class="row filter_projects" <?php if (!$filter->isProject) echo 'style="display:none"'; ?>>
			<div class="small-12 large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Stage'),''); ?>
				<?php echo CHtml::activedropDownList($filter,'stage', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(IdeaStatus::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
			</div>

			<div class="small-12 large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

				<?php echo CHtml::label(Yii::t('app','Language'),''); ?>
				<?php echo CHtml::activedropDownList($filter,'language', 
							//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
							CHtml::listData(Language::model()->findAllAttributes(null, true,array('order'=>'name')),"id","name")
							, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
			</div>

			<div class="small-12 large-3 columns">
				<label><?php echo Yii::t('app','Keywords'); ?></label>
				<?php echo CHtml::textField('SearchForm[keywords]',$filter->keywords); ?>
			</div>

			
			<div class="small-12 large-3 columns" style="text-align: center; padding-top: 16px;">
					<?php echo CHtml::submitButton(Yii::t("app","Search"),
								array('class'=>"button small radius")
						); ?>
				 &nbsp; 
				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" class="button small radius secondary"><?php echo Yii::t("app","Reset"); ?></a>
      </div>
			
				
			<div class="advance" <?php if (!$filter->checkAdvanceForm()) echo "style='display:none'"; ?>>
		    <hr>
									
					<div class="small-12 large-3 columns">
						<label><?php echo Yii::t('app','Skill'); ?></label>
						<?php echo CHtml::textField('SearchForm[skill]',$filter->skill,array("class"=>"skill")); ?>
					</div>				

					<div class="small-12 large-3 columns">
						<label><?php echo Yii::t('app','Country'); ?></label>
						<?php echo CHtml::textField('SearchForm[country]',$filter->country,array("class"=>"country")); ?>
					</div>
				
					<div class="small-12 large-3 columns">
						<label><?php echo Yii::t('app','City'); ?></label>
						<?php echo CHtml::textField('SearchForm[city]',$filter->city,array("class"=>"city")); ?>
					</div>
				
					<div class="small-12 large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

						<?php echo CHtml::label(Yii::t('app','Colaboration'),''); ?>
						<?php echo CHtml::dropDownList('SearchForm[collabPref]',$filter->collabPref, 
									//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
									CHtml::listData(Collabpref::model()->findAllTranslated(),"id","name")
									, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
					</div>
				
					<div class="small-12 large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

						<?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
						<?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
									//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
									CHtml::listData(Available::model()->findAllTranslated(),"id","name")
									, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
					</div>	

					<div class="small-12 large-3 extra_detail columns end">
						<label for="SearchForm_extraDetail">
							<?php echo CHtml::activeCheckBox($filter,'extraDetail',array("style"=>"display:none")); ?>
							<?php echo Yii::t('app','Has extra detail'); ?>
						</label>
					</div>			
					
				
			</div>			
		</div>
		<?php echo CHtml::endForm(); ?>		
		
		
    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index"),'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
		<?php echo CHtml::hiddenField("SearchForm[isProject]", "0");  ?>
		
		<div class="row filter_people" <?php if ($filter->isProject) echo 'style="display:none"'; ?>>
			<div class="small-12 large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Colaboration'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[collabPref]',$filter->collabPref, 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Collabpref::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
				
				
			</div>
			<div class="small-12 large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Available::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
			</div>
			<?php /* ?>
			<div class="small-12 large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Country'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[country]','', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Country::model()->findAll(),"id","name")
							, array('empty' => '&nbsp;',"class"=>"small-12 large-3","style"=>"display:none")); ?>
			</div><?php */ ?>
			<div class="small-12 large-3 columns">
				<label><?php echo Yii::t('app','Country'); ?></label>
				<?php echo CHtml::textField('SearchForm[country]',$filter->country,array("class"=>"country")); ?>
			</div>
			
			
			<div class="small-12 large-3 columns"  style="text-align: center;">
					<?php echo CHtml::submitButton(Yii::t("app","Search"),
							array('class'=>"button small radius")
					); ?>
				 &nbsp; 
				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" class="button small radius secondary"><?php echo Yii::t("app","Reset"); ?></a>
				
	    </div>
			
			<div class="advance" <?php if (!$filter->checkAdvanceForm()) echo "style='display:none'"; ?>>
		      <hr>

					<div class="small-12 large-3 columns">
						<label><?php echo Yii::t('app','City'); ?></label>
						<?php echo CHtml::textField('SearchForm[city]',$filter->city,array("class"=>"city")); ?>
					</div>

					<div class="small-12 large-9 columns">
						<label><?php echo Yii::t('app','Skill'); ?></label>
						<?php echo CHtml::textField('SearchForm[skill]',$filter->skill,array("class"=>"skill")); ?>
					</div>
			</div>
		</div>
      
    <?php echo CHtml::endForm(); ?>
	
	</div>
</div>
  


<?php if (!$filter->checkSearchForm()){ ?>
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

}else{ ?>
<div class="row" id="recent_projects">
	<?php
	if (count($searchResult) && count($searchResult['data'])){
		Yii::log(arrayLog($searchResult), CLogger::LEVEL_INFO, 'custom.info.user'); 
		?>

		<div class="list-holder">
		<ul class="small-block-grid-1 large-block-grid-3 list-items">
			<?php 
			foreach ($searchResult['data'] as $result){ ?>
				<li>
				<?php 
					if ($filter->isProject) $this->renderPartial('//project/_project', array('idea' => $result));
					else $this->renderPartial('//person/_user', array('user' => $result));
				?>
				</li>
			<?php } ?>
		</ul>
		</div>

		<div class="pagination-centered">
			<?php $this->widget('ext.Pagination.WPagination',array("url"=>"site/index","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'])); ?>
		</div>
	<?php }else{	?>
	
	<h3><?php echo Yii::t('msg','No results found with this filters.') ?></h3>
	
	<?php } ?>
</div>	
<?php } ?>

