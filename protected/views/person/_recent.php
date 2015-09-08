<div class="columns large-12 small-12"> 
<h2 class="meta-title l-inline"><?php echo $userType; ?></h2>
	
  

 <?php if (!Yii::app()->user->isGuest){ ?>

	<div class="right">
		
		
		<ul class="right l-inline pagination hide-for-small">
			<?php if ($page > 1){ ?>
			<li class="arrow"><a trk="person_recent_prev" class="button small secondary radius" href="#" onclick="recentUsersPage('<?php echo Yii::app()->createUrl("person/discover",array("id"=>$page-1)); ?>'); return false;"><span class="icon-angle-left"></span></a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary radius disabled "><span class="icon-angle-left"></span>
</a></li>
			<?php } ?>
			
			<?php if ($page < $maxPage){ ?>
			<li class="arrow"><a trk="person_recent_next" class="button small secondary radius" href="#" onclick="recentUsersPage('<?php echo Yii::app()->createUrl("person/discover",array("id"=>$page+1)); ?>'); return false;"><span class="icon-angle-right"></span>
</a></li>
			<?php }else{ ?>
      <li class="arrow unavailable"><a class="button small secondary radius disabled"><span class="icon-angle-right"></span>
</a></li>
			<?php } ?>
			<li><a href="<?php echo Yii::app()->createUrl("person/discover"); ?>" trk="person_recent_showAll" class="right button radius small secondary radius"><?php echo Yii::t('app','show all'); ?></a></li>
		</ul>
		
	</div>

	<small class="show-for-small">
		<a href="<?php echo Yii::app()->createUrl("person/discover"); ?>" trk="person_recent_showAll" class="button large secondary expand secondary"><?php echo Yii::t('app','show all'); ?></a>
	</small>

  <?php }else{ ?>

	<div class="right l-inline">
		
		<ul class="pagination hide-for-small">
      <li class="arrow unavailable"><a trk="disabled_click_personBack" class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-left"></span>
      </a></li>
    <li><?php echo (round($maxPage*5/50)*50); ?>+</li>
      <li class="arrow unavailable"><a trk="disabled_click_personForward" class="button small secondary disabled" data-tooltip title="<?php echo Yii::t('msg','Please login to use this functionality!'); ?>"><span class="icon-angle-right"></span>
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
		foreach ($users as $user){
			if(isset($user['id'])){
			?>
			<li>
			<?php  $this->renderPartial('//person/_user', array('user' => $user));  ?>
			</li>
		<?php }} ?>
  </ul>

  </div>
