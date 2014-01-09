<?php
	$this->pageTitle = ''; // leave this empty
	$this->pageDesc = '';
?>

<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>


<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("site/suggestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
	var countrySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCountry",array("ajax"=>1)) ?>';
</script>

<?php //if (!Yii::app()->user->getState('fpi')){ ?>

<?php /* if (Yii::app()->user->isGuest){ ?>
<div  class="row" >
  <div class="column hide-for-small">
    <img class="logo image-beta" alt="Invite" title="invite" src="<?php echo Yii::app()->request->baseUrl; ?>/images/invite-<?php echo Yii::app()->getLanguage(); ?>.png" style="position: absolute; top: -4px; right:-10px; z-index: 98;" />
  </div>
</div>
<?php } */ ?>


<div class="intro" <?php // if (isset($_GET['SearchForm'])) echo "style='display:none'"; ?>>
  <div  class="row" >
    <div class="large-10 columns large-centered">
    	

<!-- Content if guest -->
      <h1><?php echo Yii::t('msg','With the <span>right team</span> any <span>idea</span> can</br> change your life'); ?></h1>
      

      <p>
          <?php echo Yii::t('msg','We are a group of enthusiasts with a mission to help anyone with a great idea to assemble a successful start-up team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the like-minded entrepreneurs and search for interesting projects.'); ?>
      </p><br />
    </div>
    
    <?php if (!Yii::app()->user->isGuest){  ?>
    <div class="center columns hide-for-small">
      <div class="right">
        <h4 >
        <?php echo Yii::t('msg',"{username} Welcome to cofinder!",array('{username}'=>Yii::app()->user->getState('fullname'))); ?>
        </h4>
        <a href="<?php echo Yii::app()->createUrl("person/discover"); ?>" trk="main_find_cofounder" class="button radius success" ><?php echo Yii::t('app','Find a cofounder'); ?></a> 
        <span style="margin:0 13px 0 0px;"> <?php echo Yii::t('app','or'); ?> </span>
        <a href="<?php echo Yii::app()->createUrl("project/create"); ?>" trk="main_create_project" class="button radius" ><?php echo Yii::t('app','Create your project'); ?> </a>
        
      </div>
    </div>
    <?php }else{ ?>
    
   <div class="center columns">
      <div class="right large-5 small-12">
        
        <?php echo CHtml::beginForm(Yii::app()->createUrl("site/notify"),'post',array("style"=>"margin-bottom:0;")); ?>
        
        <h2 style="margin-bottom:5px;">
          <label for="email" style="font-size:1em; font-weight: bold;">
            <?php echo Yii::t('app','Want to get invited?'); ?>
          </label>
        </h2>
        <span class="description">
        <?php echo Yii::t('msg','Leave your email address and we will get back to you.'); ?>
        </span>
        <div class="row collapse">
          <div class="small-9 columns">
            <?php echo CHtml::textField("email") ?>
          </div>
          <div class="small-3 columns">
             <?php echo CHtml::submitButton(Yii::t("app","YES"),array("class"=>"postfix button radius success")); ?>
          </div>
        </div>  

        <?php echo CHtml::endForm(); ?>

      </div>
    </div>
    <?php } ?>
    
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
			<?php $this->renderPartial('//person/_recent', array('users' => $data['user'],"page"=>1,"maxPage"=>$maxPagePerson)); ?>
			</div>

	<?php } ?>

	<?php if (isset($data['idea'])){ ?>
<br />

		<div class="row" id="recent_projects">
			<?php $this->renderPartial('//project/_recent', array('ideas' => $data['idea'],"page"=>1,"maxPage"=>$maxPageIdea)); ?>
		</div>

	<?php } 
  //if (!Yii::app()->user->isGuest) echo "<hr>";
  
Yii::log(arrayLog($data['idea']), CLogger::LEVEL_INFO, 'custom.info.idea'); 
Yii::log(arrayLog($data['user']), CLogger::LEVEL_INFO, 'custom.info.user'); 

} ?>



<?php /* if ( false && !Yii::app()->user->isGuest){ ?>


<div class="row panel searchpanel radius" style="margin-top: 40px;">
	<div class="columns search_content edit-header">
    <a class="anchor-link" id="filter_search"></a>
    
		<div class="row">
		  <div class="large-3 columns">
    		<h4 class="meta-title"><?php echo Yii::t('app','Sort your search by'); ?> </h4>
      </div>
		  <div class="large-2 columns">
				<div class="left toggle_search switch large-3 small round small-3" onclick="$('.filter_projects').toggle();$('.filter_people').toggle();">
					<input id="project_0" name="SearchForm[isProject]" type="radio" value="1" <?php if ($filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_0" onclick=""><?php echo Yii::t('app','Projects'); ?></label>

					
					<input id="project_1" name="SearchForm[isProject]"  type="radio" value="0" <?php if (!$filter->isProject) echo 'checked="checked"' ?>>
					<label for="project_1" onclick=""><?php echo Yii::t('app','People') ?></label>
					<span></span>
				</div>
      </div>
      
		  <div class="large-7 columns">
					<a class="exp_srch button small secondary right radius" href="#" onclick="$('.advance').toggle(); return false;"><?php echo Yii::t('app','Advanced search'); ?> <span class="icon-caret-down"></span></a>
      </div>
		</div>

    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index")."#filter_search",'get',array("style"=>"margin-bottom:0;")); ?>
		<?php echo CHtml::hiddenField("SearchForm[isProject]", "1");  ?>
		
		<div class="row filter_projects" <?php if (!$filter->isProject) echo 'style="display:none"'; ?>>
			<div class="large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Stage of project'),''); ?>
				<?php echo CHtml::activedropDownList($filter,'stage', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(IdeaStatus::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;')); ?>
			</div>

			<div class="large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

				<?php echo CHtml::label(Yii::t('app','Language'),''); ?>
				<?php echo CHtml::activedropDownList($filter,'language', 
							//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
							CHtml::listData(Language::model()->findAllAttributes(null, true),"id","native_name")
							, array('empty' => '&nbsp;')); ?>
			</div>

			<div class="large-3 columns">
				<label><?php echo Yii::t('app','Keywords'); ?></label>
				<?php echo CHtml::textField('SearchForm[keywords]',$filter->keywords); ?>
			</div>

			
			<div class="large-3 columns" style="text-align: center; padding-top: 16px;">
					<?php echo CHtml::submitButton(Yii::t("app","Search"),
								array('class'=>"button small radius")
						); ?>
				 &nbsp; 
				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
					<?php echo CHtml::button(Yii::t("app","Reset"),
								array('class'=>"button small radius secondary")
						); ?>
         
         </a>
      </div>
			
				
			<div class="advance" <?php if (!$filter->checkAdvanceForm()) echo "style='display:none'"; ?>>
		    <hr>
									
					<div class="large-3 columns">
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
									, array('empty' => '&nbsp;')); ?>
					</div>
				
					<div class="large-3 columns">
						<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>

						<?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
						<?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
									//GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
									CHtml::listData(Available::model()->findAllTranslated(),"id","name")
									, array('empty' => '&nbsp;')); ?>
					</div>	

					<div class="large-3 extra_detail columns end">
						<label for="SearchForm_extraDetail">
							<?php echo CHtml::activeCheckBox($filter,'extraDetail',array()); ?>
							<?php echo Yii::t('app','Has extra detail'); ?>
						</label>
          </div>
					
				
			</div>			
		</div>
		<?php echo CHtml::endForm(); ?>		
		
		
    <?php echo CHtml::beginForm(Yii::app()->createUrl("site/index")."#filter_search",'get',array('class'=>"custom","style"=>"margin-bottom:0;")); ?>
		<?php echo CHtml::hiddenField("SearchForm[isProject]", "0");  ?>
		
		<div class="row filter_people" <?php if ($filter->isProject) echo 'style="display:none"'; ?>>
			<div class="large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Collaboration'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[collabPref]',$filter->collabPref, 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Collabpref::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;')); ?>
				
				
			</div>
			<div class="large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Availability'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[available]',$filter->available, 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Available::model()->findAllTranslated(),"id","name")
							, array('empty' => '&nbsp;')); ?>
			</div>
			<?php /* ?>
			<div class="large-3 columns">
				<?php //echo CHtml::activeTextField($filter,"colabPref"); ?>
				
				<?php echo CHtml::label(Yii::t('app','Country'),''); ?>
				<?php echo CHtml::dropDownList('SearchForm[country]','', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(Country::model()->findAll(),"id","name")
							, array('empty' => '&nbsp;',"class"=>"large-3","style"=>"display:none")); ?>
			</div><?php //* / ?>
			<div class="large-3 columns">
				<label><?php echo Yii::t('app','Country'); ?></label>
				<?php echo CHtml::textField('SearchForm[country]',$filter->country,array("class"=>"country")); ?>
			</div>
			
			
			<div class="large-3 columns" style="text-align: center; padding-top: 16px;">
					<?php echo CHtml::submitButton(Yii::t("app","Search"),
							array('class'=>"button small radius")
					); ?>
				 &nbsp; 
				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" class="button small reset-btn radius secondary"><?php echo Yii::t("app","Reset"); ?></a>
				
	    </div>
			
			<div class="advance" <?php if (!$filter->checkAdvanceForm()) echo "style='display:none'"; ?>>
		      <hr>

					<div class="large-3 columns">
						<label><?php echo Yii::t('app','City'); ?></label>
						<?php echo CHtml::textField('SearchForm[city]',$filter->city,array("class"=>"city")); ?>
					</div>

					<div class="large-9 columns">
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
      <div class="page-navigation panel">
        <ul>
          <li><a  href="#page1"><?php echo Yii::t("app", "Page"); ?> 1</a></li>
        </ul>
      </div>
    </div>

		<div class="list-holder">
      
      <div class="list-items">
        <a id="page<?php echo $searchResult['page']; ?>" class="anchor-link"></a>
        
        <h5><?php echo Yii::t("app","Page")." ".$searchResult['page']; ?></h5>

        <ul class="small-block-grid-1 large-block-grid-3">
          <?php
          if(is_array($searchResult['data']) > 0){
            foreach ($searchResult['data'] as $result){ ?>
            <li>
            <?php 
              if ($filter->isProject) $this->renderPartial('//project/_project', array('idea' => $result));
              else $this->renderPartial('//person/_user', array('user' => $result));
            ?>
            </li>
          <?php }} ?>
        </ul>
      </div>
		</div>

		<div class="pagination-centered">
			<?php $this->widget('ext.Pagination.WPagination',array("url"=>"site/index","page"=>$searchResult['page'],"maxPage"=>$searchResult['maxPage'],"getParams"=>$_GET)); ?>
		</div>
	<?php }else{	?>
	
	<h3><?php echo Yii::t('msg','No results found with these filters.') ?></h3>
	
	<?php } ?>

</div>	
<?php } 

}
*/
?>



<div class="main-quote">
  
  <div class="row" >
    <div class="columns large-centered">
    	<h2><?php echo Yii::t('app','What others are saying'); ?></h2>
    	<div class="large-2 columns">
        <img class="mt20" src='<?php echo Yii::app()->request->baseUrl; ?>/images/logo-biome3cs.png'>
      </div>
      <blockquote class="columns large-10">
      	<span class="icon-quote-left large"></span>
        V podjetju Biome3cs d.o.o, smo se podobno kot številna druga start-up podjetja srečali s problemom pomanjkanja specifičnega kadra. S pomočjo platforme cofinder smo uspešno našli manjkajoče člene v naši ekipi, s katerimi še vedno uspešno sodelujemo. S platformo cofinder smo zelo zadovoljni in jo priporočamo vsem, ki želijo na najbolj enostaven in hiter način najti ljudi, ki bi jim pomagali uresničiti svojo idejo 
        <span class="icon-quote-right large"></span>
      </blockquote>
    </div>  
  </div>  
  
</div>
