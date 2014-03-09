<div class="columns large-12 small-12"> 
	<h2 class="meta-title l-inline"><?php echo Yii::t('app','Featured projects'); ?></h2>

    
		<div class="right l-inline">
			<ul class="pagination hide-for-small">
			</ul>
		</div>


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
