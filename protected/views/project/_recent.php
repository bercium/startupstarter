<h4 class="meta-title"><?php echo Yii::t('app','Recent projects'); ?></h4>
	
  <ul class="small-block-grid-1 large-block-grid-3">
		<?php 
		//$i = 0;
		//$page = 1;
		//$maxPage = 3;
		foreach ($ideas as $idea){
			?>
			<li>
			<?php  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
			</li>
		<?php } ?>
  </ul>

 <?php if (!Yii::app()->user->isGuest){ ?>
	<div class="pagination-centered">
		<small class="hide-for-small"><a href="<?php echo Yii::app()->createUrl("project/recent"); ?>" class="right button radius small secondary"><?php echo Yii::t('app','show all'); ?> </a></small>
		
		<ul class="pagination hide-for-small">
			<?php if ($page > 1){ ?>
			<li class="arrow"><a class="button secondary small radius" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/recent",array("id"=>$page-1)); ?>'); return false;"><span class="icon-angle-left"></span>
</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small radius secondary disabled"><span class="icon-angle-left"></span>
</a></li>
			<?php } ?>
			
			<?php if ($page < $maxPage){ ?>
			<li class="arrow"><a class="button secondary small radius" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/recent",array("id"=>$page+1)); ?>'); return false;"><span class="icon-angle-right"></span>
</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small radius secondary disabled"><span class="icon-angle-right"></span>
</a></li>
			<?php } ?>
		</ul>
	
	</div>
		<small class="show-for-small">
			<a href="<?php echo Yii::app()->createUrl("project/recent/1"); ?>"  class="button secondary large expand"><?php echo Yii::t('app','show all'); ?></a>
		</small>

  <?php }else{ ?>
	<div class="pagination-centered">
		<small class="hide-for-small">
      <a class="right button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><?php echo Yii::t('app','show all'); ?></a>
    </small>
		
		<ul class="pagination hide-for-small">
      <li class="arrow unavailable"><a class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-left"></span>
      </a></li>
			
      <li class="arrow unavailable"><a class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-right"></span>
      </a></li>
		</ul>
		
	</div>

	<small class="show-for-small">
		<a class="button large secondary expand disabled secondary" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><?php echo Yii::t('app','show all'); ?></a>
	</small>

<?php } ?>
