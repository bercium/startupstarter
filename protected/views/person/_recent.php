<h6 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Recent users')); ?></h6>
	
  <ul class="small-block-grid-1 large-block-grid-3">
		<?php 
		//$i = 0;
		//$page = 1;
		//$maxPage = 3;
		foreach ($users as $user){
			?>
			<li>
			<?php  $this->renderPartial('//person/_user', array('user' => $user));  ?>
			</li>
		<?php } ?>
  </ul>

	<div class="pagination-centered">
		<small class="hide-for-small"><a href="<?php echo Yii::app()->createUrl("person/recent/1"); ?>"  class="right button small secondary"><?php echo Yii::t('app','show all'); ?></a></small>
		
		<ul class="pagination hide-for-small">
			<?php if ($page > 1){ ?>
			<li class="arrow"><a class="button small secondary" href="#" onclick="recentUsersPage('<?php echo Yii::app()->createUrl("person/recent",array("id"=>$page-1)); ?>'); return false;">&laquo;</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary disabled">&laquo;</a></li>
			<?php } ?>
			
			<?php if ($page < $maxPage){ ?>
			<li class="arrow"><a class="button small secondary" href="#" onclick="recentUsersPage('<?php echo Yii::app()->createUrl("person/recent",array("id"=>$page+1)); ?>'); return false;">&raquo;</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary disabled">&raquo;</a></li>
			<?php } ?>
		</ul>
		
	</div>

	<small class="show-for-small">
		<a href="<?php echo Yii::app()->createUrl("person/recent/1"); ?>"  class="button large secondary expand secondary"><?php echo Yii::t('app','show all'); ?></a>
	</small>