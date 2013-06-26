<?php if (($page > 1) || ($maxPage > 1)){ // show pagination only if needed ?>
<ul class="pagination">
	<?php if ($page > 1){ ?>
	<li class="arrow"><a href="<?php echo Yii::app()->createUrl($url,array_merge($getParams,array("id"=>$page-1))); ?>">&laquo;</a></li>
	<?php }else{ ?>
	<li class="arrow unavailable"><a>&laquo;</a></li>
	<?php } ?>

	<?php 
		if ($pageNumbers){
		for ($i=1; $i <= $maxPage; $i++){
			if ($i == $page){ ?><li class="current"><?php }else{ ?><li><?php } ?>

			<a href="<?php echo Yii::app()->createUrl($url,array_merge($getParams,array("id"=>$i))); ?>"><?php echo $i; ?></a>
			</li>
	<?php	} 
			} ?>


	<?php if ($page < $maxPage){ ?>
	<li class="arrow"><a href="<?php echo Yii::app()->createUrl($url,array_merge($getParams,array("id"=>$page+1))); ?>">&raquo;</a></li>
	<?php }else{ ?>
	<li class="arrow unavailable"><a>&raquo;</a></li>
	<?php } ?>
</ul>
<?php } ?>