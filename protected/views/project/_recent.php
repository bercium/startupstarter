<div class="columns large-12 small-12"> 
	<h2 class="meta-title l-inline"><?php echo $ideaType; ?></h2>
		
	 

	 <?php if (!Yii::app()->user->isGuest){ ?>

    
		<div class="right l-inline">
			
			
			<ul class="pagination hide-for-small">
				<?php if ($page > 1){ ?>
				<li class="arrow"><a trk="project_recent_prev" class="button secondary small radius" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/discover",array("id"=>$page-1)); ?>'); return false;"><span class="icon-angle-left"></span>
	</a></li>
				<?php }else{ ?>
	      <li class="arrow unavailable"><a class="button small radius secondary disabled"><span class="icon-angle-left"></span>
	</a></li>
				<?php } ?>
				
				<?php if ($page < $maxPage){ ?>
				<li class="arrow"><a trk="project_recent_next" class="button secondary small radius" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/discover",array("id"=>$page+1)); ?>'); return false;"><span class="icon-angle-right"></span>
	</a></li>
				<?php }else{ ?>
	      <li class="arrow unavailable"><a class="button small radius secondary disabled"><span class="icon-angle-right"></span>
	</a></li>



				<?php } ?>

				<li><a href="<?php echo Yii::app()->createUrl("project/discover"); ?>" class="right button radius small secondary"><?php echo Yii::t('app','show all'); ?> </a></li>
			</ul>
		
		</div>
			<small class="show-for-small">
				<a trk="project_recent_showAll" href="<?php echo Yii::app()->createUrl("project/discover"); ?>"  class="button secondary large expand"><?php echo Yii::t('app','show all'); ?></a>
			</small>

	  <?php }else{ ?>

    
		<div class="right l-inline">
			
			<ul class="pagination hide-for-small">
	      <li class="arrow unavailable"><a trk=disabled_click_projectBack" class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-left"></span>
	      </a></li>
          <li><?php echo (round($maxPage*3/50)*50); ?>+</li>
	      <li class="arrow unavailable"><a trk="disabled_click_projectForward" class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-right"></span>
	      </a></li>
			</ul>
			
		</div>

		<small class="show-for-small">
			<a class="button large secondary expand disabled secondary" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><?php echo Yii::t('app','show all'); ?></a>
		</small>

	<?php } ?>


	 <ul class="small-block-grid-1 large-block-grid-3">
			<?php 
			//$i = 0;
			//$page = 1;
			//$maxPage = 3;
      if ($ideas)
			foreach ($ideas as $idea){
				?>
				<li>
				<?php  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
				</li>
			<?php } ?>
	  </ul>

</div>
