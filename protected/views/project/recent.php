<div  class="row">
	<h1><?php echo CHtml::encode(Yii::t('app','Recent projects')); ?></h1>
	
	<?php if ($ideas){ ?>
	<div class="list-holder">
  <ul class="small-block-grid-1 large-block-grid-3 list-items">
		<?php 
		//$i = 0;
		//$page = 1;
		//print
		//$maxPage = 3;
		foreach ($ideas as $idea){ ?>
			<li>
			<?php  $this->renderPartial('_project', array('idea' => $idea));  ?>
			</li>
		<?php } ?>
  </ul>
	</div>
	
	<div class="pagination-centered">
		
		<?php $this->widget('ext.Pagination.WPagination',array("url"=>"project/recent","page"=>$page,"maxPage"=>$maxPage)); ?>
		
	</div>
	<?php } ?>
	
</div>