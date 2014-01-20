<?php
	$this->pageTitle = Yii::t('app','Find talent'); // leave this empty
	$this->pageDesc = 'Find interesting talent for your project';
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/suggestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
	var countrySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCountry",array("ajax"=>1)) ?>';
</script>

<div id="drop-local-project" class="f-dropdown content small" data-dropdown-content>
  <div class="invitation-form">

      <?php echo CHtml::label(Yii::t('app','City'),'message'); ?>
      <div class="row collapse">
        <div class="small-9 columns">
          <?php echo CHtml::textField('search_local','',array('class'=>'city')); ?>
        </div>
        <div class="small-3 columns">
           <?php echo CHtml::button(Yii::t("app","Find"),array("class"=>"search_local_button postfix button radius",
                  'onclick'=>"location.href='".Yii::app()->createUrl("person/discover")."?SearchForm[city]='+$('#search_local').val()+'&Category=city';")); ?>
        </div>
      </div>    
  </div>
</div>

<div class="panel-top mb20 bb"><!-- panel-top -->
	<div class="row">
		<div class="columns">
    <h1><?php echo Yii::t('app','Find talent'); ?></h1>
    
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[skill]'=>'Designer, GraphicDesigner', 'Category'=>'skill')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","Search for designers") ?>"><?php echo Yii::t("app","Designers"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[skill]'=>'Business developer', 'Category'=>'skill')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","Search for people who can help you develop your business.") ?>"><?php echo Yii::t("app","Business developers"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[skill]'=>'Programming, Computer Software', 'Category'=>'skill')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","People who understand programming languages.") ?>"><?php echo Yii::t("app","Programmers"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[skill]'=>'Engineer', 'Category'=>'skill')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","People who have great engineering skills.") ?>"><?php echo Yii::t("app","Engineers"); ?></a>
    <br />
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[available]'=>'8','SearchForm[skill]'=>'Programming, Computer Software, Computer Hardware', 'Category'=>'available')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","Computer wizards who work on weekends.") ?>" ><?php echo Yii::t("app","Weekend hackers"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[available]'=>'60', 'Category'=>'available')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","People that just can't stop working.") ?>" ><?php echo Yii::t("app","Workaholics"); ?></a>   
    <a href="<?php echo Yii::app()->createUrl("person/discover",array('SearchForm[collabPref]'=>'1', 'SearchForm[available]'=>'60', 'Category'=>'collabpref')); ?>" class="button success  radius small" data-tooltip title="<?php echo Yii::t("msg","People searching for regular jobs.") ?>" ><?php echo Yii::t("app","Employees"); ?></a>    
    <a href="#" data-dropdown="drop-local-project" onclick="$('#search_local').focus()" class="button success dropdown radius small" data-tooltip title="<?php echo Yii::t('app','People that are available in a specific area will be shown first!');?>" ><?php echo Yii::t("app","Local people"); ?></a>
	</div>
	</div>
  
  <div class="searchpanel">
    <div class="row">
    	<div class="columns">
	    <a class="button small radius secondary" href="#" style="margin-top:15px;" onclick="$('#searchpanel').slideToggle(); return false;"><?php echo Yii::t('app','Show search options'); ?></a>
	    </div>
		</div>
  </div>

	<div id="searchpanel" class="searchpanel" <?php if (!$filter->checkSearchForm()) echo "style='display:none'"; ?> >
		<div class="search_content">
	    <a class="anchor-link" id="filter_search"></a>
	    
			<div class="row">
			  <div class="large-3 columns">
	    		
	      </div>
			 
			</div>
			
	    <?php echo CHtml::beginForm(Yii::app()->createUrl("person/discover")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
			
				<div class="row filter_people" <?php if ($filter->isProject) echo 'style="display:none"'; ?>>

					<div class="large-6 columns">
					<label><?php echo Yii::t('app','Skill'); ?></label>
					<?php echo CHtml::textField('SearchForm[skill]',$filter->skill,array("class"=>"skill")); ?>
					</div>

					<div class="large-3 columns left">
					<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

					<?php echo CHtml::label(Yii::t('app','Collaboration'),''); ?>
					<?php echo CHtml::dropDownList('SearchForm[collabPref]',$filter->collabPref, 
					//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
					CHtml::listData(Collabpref::model()->findAllTranslated(),"id","name")
					, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
					</div>

					


				</div>			
				
				<div class="row">

					<div class="large-3 columns">
					<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

					<?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
					<?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
					//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
					CHtml::listData(Available::model()->findAllTranslated(),"id","name")
					, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
					</div>	     

					<div class="large-3 columns">
						<label><?php echo Yii::t('app','City'); ?></label>
						<?php echo CHtml::textField('SearchForm[city]',$filter->city,array("class"=>"city")); ?>
					</div>

					<?php /* ?>
					<div class="large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
						
						<?php echo CHtml::label(Yii::t('app','Country'),''); ?>
						<?php echo CHtml::dropDownList('SearchForm[country]','', 
		              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
		              CHtml::listData(Country::model()->findAll(),"id","name")
									, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
					</div><?php */ ?>
					<div class="large-3 columns">
						<label><?php echo Yii::t('app','Country'); ?></label>
						<?php echo CHtml::textField('SearchForm[country]',$filter->country,array("class"=>"country")); ?>
					</div>

					<div class="large-3 columns mt10">
							<?php echo CHtml::submitButton(Yii::t("app","Search"),
									array('class'=>"button small radius")
							); ?>
						 &nbsp; 
							<?php echo CHtml::button(Yii::t("app","Reset"),
										array('class'=>"button small radius secondary")
								); ?>
			    	</div>
						
				</div>		
	      
	    <?php echo CHtml::endForm(); ?>
		
		</div>
	</div>
 
</div><!-- panel-top end -->


<div class="row mb40" id="recent_projects">
	<div class="columns large-12 small-12">
		<?php
		if (!empty($searchResult['data']) && count($searchResult['data']) > 0){
			Yii::log(arrayLog($searchResult), CLogger::LEVEL_INFO, 'custom.info.search_result'); 
			?>
	  
	    <div class="hide-for-medium-down">
	      <div class="page-navigation">
	        <ul>
	          <li><a class="button secondary small radius" href="#page1"><?php echo Yii::t("app", "Page"); ?> 1</a></li>
	        </ul>
	      </div>
	    </div>

			<div class="list-holder">
	      
	      <div class="list-items">
	        <a id="page<?php echo $searchResult['page']; ?>" class="anchor-link"></a>
	        
	        <h5><?php echo Yii::t("app","Page")." ".$searchResult['page']; ?></h5>
	        <ul class="small-block-grid-1 large-block-grid-3">
	          <?php 
	          foreach ($searchResult['data'] as $result){ ?>
	            <li>
	            <?php $this->renderPartial('//person/_user', array('user' => $result)); ?>
	            </li>
	          <?php } ?>
	        </ul>
	      </div>
			</div>

			<div class="pagination-centered">
				<?php if (!Yii::app()->user->isGuest) $this->widget('ext.Pagination.WPagination',array("url"=>"person/discover","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'],"getParams"=>$_GET)); ?>
			</div>
		<?php }else{	?>
		
		<h3><?php echo Yii::t('msg','No results found with these filters.') ?></h3>
		
		<?php } ?>
	</div>
</div>


