<div  class="row">
	<h6 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Recent users')); ?></h6>
	
  <ul class="small-block-grid-1 large-block-grid-3">
		<?php 
		//$i = 0;
		//$pagedata['filter']['page'] = 1;
		//$maxPage = 3;
		foreach ($data['user'] as $user){ ?>
			<li>
			<?php  $this->renderPartial('_user', array('user' => $user));  ?>
			</li>
		<?php } ?>
  </ul>

	
	<div class="pagination-centered">
		
		<ul class="pagination">
			<?php if ($pagedata['filter']['page'] > 1){ ?>
			<li class="arrow"><a href="<?php echo Yii::app()->createUrl("person/recent/".$pagedata['filter']['page']-1); ?>">&raquo;</a></li>
			<?php }else{ ?>
			<li class="arrow"><a>&laquo;</a></li>
			<?php } ?>
			
			<?php 
			  for ($i=1; $i <= $maxPage; $i++){
					if ($i == $pagedata['filter']['page']){ ?><li class="current"><?php }else{ ?><li><?php } ?>
					
					<a href="<?php echo Yii::app()->createUrl("person/recent/".$i); ?>"><?php echo $i; ?></a>
					</li>
			<?php	} ?>
					 
			
			<?php if ($pagedata['filter']['page'] < $maxPage){ ?>
			<li class="arrow"><a href="<?php echo Yii::app()->createUrl("person/recent/".$pagedata['filter']['page']+1); ?>">&raquo;</a></li>
			<?php }else{ ?>
			<li class="arrow"><a>&raquo;</a></li>
			<?php } ?>
		</ul>
	</div>
	
</div>
