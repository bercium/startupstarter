<h6 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Recent projects')); ?></h6>
	
  <ul class="small-block-grid-1 large-block-grid-3">
		<?php 
		//$i = 0;
		//$page = 1;
		//$maxPage = 3;
		foreach ($ideas as $idea){
			?>
			<li>
			<?php  $this->renderPartial('//idea/_idea', array('idea' => $idea));  ?>
			</li>
		<?php } ?>
  </ul>

	<div class="pagination-centered">
		<ul class="pagination hide-for-small">
			<?php if ($page > 1){ ?>
			<li class="arrow"><a href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("idea/recent",array("id"=>$page-1)); ?>'); return false;">&laquo;</a></li>
			<?php } ?>
			
			<?php if ($page < $maxPage){ ?>
			<li class="arrow"><a href="#" onclick="recentProjectsPage('<?php echo Yii::app()->createUrl("idea/recent",array("id"=>$page+1)); ?>'); return false;">&raquo;</a></li>
			<?php } ?>
			
			<small>&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("idea/recent/1"); ?>" class="">show all</a></small>
		</ul>
		<small class="show-for-small">&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("idea/recent/1"); ?>" class="">show all</a></small>
	</div>