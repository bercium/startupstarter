<?php
	$this->pageTitle = ''; // leave this empty
	$this->pageDesc = '';

  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  
  $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css');
  $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.10.3.custom.min.js',CClientScript::POS_END);
?>

<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>


<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/sugestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/sugestCity",array("ajax"=>1)) ?>';
	var countrySuggest_url = '<?php echo Yii::app()->createUrl("site/sugestCountry",array("ajax"=>1)) ?>';
</script>

<?php //if (!Yii::app()->user->getState('fpi')){ ?>

<div class="intro" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
  <div  class="row" >
    <div class="large-10 large-offset-1 small-12 columns" style="text-align: center;" >

<!-- Content if guest -->
      <h1><?php echo Yii::t('msg','With the <span>right team</span> <br> any <span>idea</span> can change your <span>life</span>'); ?></h1>
      <p>
          <?php echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.'); ?>
      </p>
    </div>
    <div class="large-12 center columns hide-for-small">
      <?php if (Yii::app()->user->isGuest){ ?>
      <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>" class="button radius success" ><?php echo Yii::t('msg','Find talent') ?></a> 
      <a href="#" data-dropdown="drop-login" class="button radius " ><?php echo Yii::t('msg','Discover projects') ?> </a>
      <?php }else{ ?>
      <h4 style="text-align: center;">
      <?php echo Yii::t('msg',"{username} welcome to coFinder!",array('{username}'=>Yii::app()->user->getState('fullname'))); ?>
      </h4>
      <?php } ?>
    </div>
    
  </div>
</div>
<?php // } ?>


<?php /* ?>
	<div class="close pagination-centered ">
		
			<a  href="#"  id="showhide" class="button tiny secondary">hide intro<span class='icon-angle-up'></span></a>                      
        </div>
        <script type="text/javascript">
	
$("#showhide").click(function() {
  $(".intro").animate({ opacity: 1.0 },200).slideToggle(500, function() {
    $("#showhide").html($(".intro").is(':visible') ? "hide intro <span class='icon-angle-up'></span>" : "show intro <span class='icon-angle-down'></span>");

  });
});
		</script>
<?php */ ?>



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

} ?>








<div class="row panel searchpanel radius" style="margin-top: 40px;">
	<div class="large-12 small-12 columns search_content edit-header">
    <a class="anchor-link" id="filter_search"></a>
    
		<div class="row">
		  <div class="large-3 small-12 columns">
    		<h4 class="meta-title"><?php echo Yii::t('app','Sort your search by'); ?> </h4>
      </div>
		  <div class="large-9 small-12 columns">
				<div class="left toggle_search switch large-3 small round small-3" onclick="$('.filter_projects').toggle();$('.filter_people').toggle();">
					<input id="project_0" name="SearchForm[isProject]" type="radio" value="1" <?php if ($filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_0" onclick=""><?php echo Yii::t('app','Projects'); ?></label>

					
					<input id="project_1" name="SearchForm[isProject]"  type="radio" value="0" <?php if (!$filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_1" onclick=""><?php echo Yii::t('app','People') ?></label>
					<span></span>
				</div>
        
				
					<a class="exp_srch large-3 small-3 button small secondary right round" href="#" onclick="$('.advance').toggle(); return false;"><?php echo Yii::t('msg','Advanced search'); ?> <span class="icon-caret-down"></span></a>
				
        
      </div>
		</div>

    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
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
				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" class="button reset-btn small radius secondary"><?php echo Yii::t("app","Reset"); ?></a>
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
		
		
    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
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
  







<?php if ($filter->checkSearchForm()){ ?>
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
            <?php 
              if ($filter->isProject) $this->renderPartial('//project/_project', array('idea' => $result));
              else $this->renderPartial('//person/_user', array('user' => $result));
            ?>
            </li>
          <?php } ?>
        </ul>
      </div>
		</div>

		<div class="pagination-centered">
			<?php $this->widget('ext.Pagination.WPagination',array("url"=>"site/index","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'],"getParams"=>$_GET)); ?>
		</div>
	<?php }else{	?>
	
	<h3><?php echo Yii::t('msg','No results found with this filters.') ?></h3>
	
	<?php } ?>
</div>	
<?php } ?>

