<div  class="row">
	<h1><?php echo CHtml::encode(Yii::t('app','Recent users')); ?></h1>
	
	<?php if ($users){ ?>
	<div class="list-holder">
  <ul class="small-block-grid-1 large-block-grid-3 list-items">
		<?php 
		//$i = 0;
		//$page = 1;
		//$maxPage = 3;
		
		foreach ($users as $user){ ?>
			<li>
			<?php  $this->renderPartial('_user', array('user' => $user));  ?>
			</li>
		<?php } ?>
  </ul>
	</div>
	
	<div class="pagination-centered">
		
		<?php $this->widget('ext.Pagination.WPagination',array("url"=>"person/recent","page"=>$page,"maxPage"=>$maxPage)); ?>

	</div>
	<?php } ?>
	
</div>