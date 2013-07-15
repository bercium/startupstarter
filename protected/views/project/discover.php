<div class="row pannel radius" style="margin-top: 40px;">
  <div class="columns">
    <h4><?php echo Yii::t('app','Discover'); ?></h4>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[stage]'=>'1')); ?>" class="button round success" style="margin-left:20px;"><?php echo Yii::t("app","Interesting ideas"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[available]'=>'8')); ?>" class="button round success" style="margin-left:20px;"><?php echo Yii::t("app","Weekend jobs"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[available]'=>'40')); ?>" class="button round success" style="margin-left:20px;"><?php echo Yii::t("app","Full time projects"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover",array('SearchForm[collabPref]'=>'4')); ?>" class="button round success" style="margin-left:20px;"><?php echo Yii::t("app","Investments"); ?></a>
    <a href="<?php echo Yii::app()->createUrl("project/discover"); ?>" class="button round success" style="margin-left:20px;"><?php echo Yii::t("app","Local projects"); ?></a>
  </div>
</div>


<div class="row panel searchpanel radius" style="margin-top: 40px;">
	<div class="large-12 small-12 columns search_content edit-header">
    <a class="anchor-link" id="filter_search"></a>
    
		<div class="row">
		  <div class="large-3 small-12 columns">
    		<h4 class="meta-title"><?php echo Yii::t('app','Sort your search by'); ?> </h4>
      </div>
		  <div class="large-9 small-12 columns">
				
			<a class="exp_srch large-3 small-3 button small secondary right round" href="#" onclick="$('.advance').toggle(); return false;"><?php echo Yii::t('msg','Advanced search'); ?> <span class="icon-caret-down"></span></a>
        
      </div>
		</div>

    <?php echo CHtml::beginForm(Yii::app()->createUrl("project/discover")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
		
		<div class="row filter_projects">
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
							CHtml::listData(Language::model()->findAllAttributes(null, true),"id","name")
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
				 <a href="<?php echo Yii::app()->createUrl("project/discover"); ?>" class="button reset-btn small radius secondary"><?php echo Yii::t("app","Reset"); ?></a>
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
	
	</div>
</div>
  




<div class="row" id="recent_projects">
	<?php
	if (count($searchResult) && count($searchResult['data'])){
		Yii::log(arrayLog($searchResult), CLogger::LEVEL_INFO, 'custom.info.search_result'); 
		?>
  
    <div class="hide-for-medium-down">
      <div class="page-navigation">
        <ul>
          <li><a href="#page1"><?php echo Yii::t("app", "Page"); ?> 1</a></li>
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
			<?php $this->widget('ext.Pagination.WPagination',array("url"=>"project/discover","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'],"getParams"=>$_GET)); ?>
		</div>
	<?php }else{	?>
	
	<h3><?php echo Yii::t('msg','No results found with this filters.') ?></h3>
	
	<?php } ?>
</div>	
