<?php
	$this->pageTitle = Yii::t('app','Discover projects'); // leave this empty
	$this->pageDesc = 'Discover interestnig project';
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
                  'onclick'=>"location.href='".Yii::app()->createUrl("project/discover")."?SearchForm[city]='+$('#search_local').val()+'&Category=city';")); ?>
        </div>
      </div>    
  </div>
</div>


<div class="panel-top mb20 bb"><!-- panel-top -->
  <div class="row">
    <div class="columns">
    <h1><?php echo Yii::t('app','Discover projects'); ?></h1>

    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[stage]'=>'1', 'Category'=>'stage')); ?>" class="button radius success small"><?php echo Yii::t("app","Interesting ideas"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[available]'=>'8', 'Category'=>'available')); ?>" class="button success radius small"><?php echo Yii::t("app","Weekend jobs"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[available]'=>'40', 'Category'=>'available')); ?>" class="button success radius small"><?php echo Yii::t("app","Full time projects"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[collabPref]'=>'4', 'Category'=>'collabpref')); ?>" class="button success radius small"><?php echo Yii::t("app","Investments"); ?></a>
    <a href="#" data-dropdown="drop-local-project" onclick="$('#search_local').focus()" class="button success dropdown  radius small" ><?php echo Yii::t("app","Local projects"); ?></a>
  </div>
</div>
<!--
    <hr>
    <p class="l-inline"><?php // echo Yii::t('app','Or use advanced search'); ?>:</p><a class="button ml10 small radius secondary" href="#" onclick="$('.searchpanel').toggle(); return false;"><span class="icon-plus"></span></a>
  -->

<div class="searchpanel">
    <div class="row">
      <div class="columns"> 
    <a class="button small radius secondary" href="#" style="margin-top:15px;" onclick="$('#searchpanel').slideToggle(); return false;"><?php echo Yii::t('app','More options'); ?></a>
      </div>
    </div>
  </div>

	<div id="searchpanel" class="searchpanel" <?php if (!$filter->checkSearchForm()) echo "style='display:none'"; ?> >

			<div class="search_content">
		    <a class="anchor-link" id="filter_search"></a>

		    <?php echo CHtml::beginForm(Yii::app()->createUrl("project/discover")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
				
				<div class="row filter_projects">
						
					<div class="large-3 columns">
						<label><?php echo Yii::t('app','Keywords'); ?></label>
						<?php echo CHtml::textField('SearchForm[keywords]',$filter->keywords); ?>
					</div>

					<div class="large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
						
						<?php echo CHtml::label(Yii::t('app','Stage of project'),''); ?>
						<?php echo CHtml::activedropDownList($filter,'stage', 
		              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
		              CHtml::listData(IdeaStatus::model()->findAllTranslated(),"id","name")
									, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
					</div>

					<div class="large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

						<?php echo CHtml::label(Yii::t('app','Language'),''); ?>
						<?php echo CHtml::activedropDownList($filter,'language', 
									//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
									CHtml::listData(Language::model()->findAllAttributes(null, true),"id","native_name")
									, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
					</div>


					<div class="large-3 columns" style="text-align: center; padding-top: 16px;">
							<?php echo CHtml::submitButton(Yii::t("app","Search"),
										array('class'=>"button small radius")
								); ?>
						 &nbsp; 
							<?php echo CHtml::button(Yii::t("app","Reset"),
										array('class'=>"button small radius secondary")
								); ?>
		      </div>
					
						
	
          <div class="large-6 columns">
            <label><?php echo Yii::t('app','Skill'); ?></label>
            <?php echo CHtml::textField('SearchForm[skill]',$filter->skill,array("class"=>"skill")); ?>
          </div>				

          <div class="large-3 columns">
            <label><?php echo Yii::t('app','Country'); ?></label>
            <?php echo CHtml::textField('SearchForm[country]',$filter->country,array("class"=>"country")); ?>
          </div>

          <div class="large-3 columns">
            <label><?php echo Yii::t('app','City'); ?></label>
            <?php echo CHtml::textField('SearchForm[city]',$filter->city,array("class"=>"city")); ?>
          </div>

          <div class="large-3 columns">
            <?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

            <?php echo CHtml::label(Yii::t('app','Collaboration'),''); ?>
            <?php echo CHtml::dropDownList('SearchForm[collabPref]',$filter->collabPref, 
                  //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
                  CHtml::listData(Collabpref::model()->findAllTranslated(),"id","name")
                  , array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
          </div>

          <div class="large-3 columns">
            <?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

            <?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
            <?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
                  //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
                  CHtml::listData(Available::model()->findAllTranslated(),"id","name")
                  , array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
          </div>	

          <div class="large-3 columns end" style="padding-top:20px">
            <label for="SearchForm_extraDetail">
              <?php echo CHtml::activeCheckBox($filter,'extraDetail',array("style"=>"display:none")); ?>
              <?php echo Yii::t('app','Has extra detail'); ?>
            </label>
          </div>
							

				</div>
				<?php echo CHtml::endForm(); ?>		
			
		</div><!-- searchpanel end -->

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
          <ul class="button-group">
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
              <?php $this->renderPartial('//project/_project', array('idea' => $result)); ?>
              </li>
            <?php } ?>
          </ul>
        </div>
  		</div>

  		<div class="pagination-centered">
  			<?php if (!Yii::app()->user->isGuest) $this->widget('ext.Pagination.WPagination',array("url"=>"project/discover","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'],"getParams"=>$_GET)); ?>
  		</div>
  	<?php }else{	?>
  	
  	<h3><?php echo Yii::t('msg','No results found with these filters.') ?></h3>
  	
  	<?php } ?>
  </div>
</div>	
