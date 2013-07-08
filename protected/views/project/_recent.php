<h6 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Recent projects')); ?></h6>
	
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

	<div class="pagination-centered">
		<small class="hide-for-small"><a href="<?php echo Yii::app()->createUrl("project/recent"); ?>" class="right button small secondary">show all </a></small>
		
		<ul class="pagination hide-for-small">
			<?php if ($page > 1){ ?>
			<li class="arrow"><a class="button secondary small" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/recent",array("id"=>$page-1)); ?>'); return false;">&laquo;</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary disabled">&laquo;</a></li>
			<?php } ?>
			
			<?php if ($page < $maxPage){ ?>
			<li class="arrow"><a class="button secondary small" href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("project/recent",array("id"=>$page+1)); ?>'); return false;">&raquo;</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary disabled">&raquo;</a></li>
			<?php } ?>
		</ul>
	
	</div>
		<small class="show-for-small">
			<a href="<?php echo Yii::app()->createUrl("project/recent/1"); ?>"  class="button secondary large expand">show all</a>
		</small>
