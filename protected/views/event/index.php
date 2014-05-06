
	<h2 class="meta-title l-inline"><?php echo Yii::t('app','Event|Events', 1) . " " . $event['title'];?></h2>&nbsp;&nbsp;&nbsp;&nbsp;

	<?php if($event['user_id'] == Yii::app()->user->id){ ?>

		<?php if(($event['idea_id'] > 0 && $event['payment'] != $event['price_idea']) || (!$event['idea_id'] && $event['payment'] != $event['price_person'])){ ?>
		<a href="<?php echo Yii::app()->createUrl("event/signup", array('id' => $event['id'], 'step' => 2)); ?>" class="button radius tiny"><?php echo Yii::t('app','Payment');?></a>
		<?php } ?>

		<div class="right">
			<a href="<?php echo Yii::app()->createUrl("event/signup", array('id' => $event['id'])); ?>" class="button radius tiny"><?php echo Yii::t('app','Edit signup');?></a>
			
           <?php
           	//!!!FIX LINK (there was some problem with generating)
            echo CHtml::link(Yii::t("app", "Unsubscribe"), Yii::app()->createUrl("event/view", array('id' => $event['id'], 'unsubscribe'=>'true')),
                array('class' => "button radius tiny alert",
                    'confirm' => Yii::t("msg", "You are about to unsubscribe from this event!") . "\n" . Yii::t("msg", "Are you sure?"),
                    'onclick' => "$(document).stopPropagation();",
                )
            );?>
		</div>

	<?php } ?>

	<?php if (isset($event['ideas']) && count($event['ideas']) > 0 && !$event['idea_id']){ ?>
		<div class="row mt40">
			<div class="columns large-12 small-12"> 
				<h2 class="meta-title l-inline"><?php echo Yii::t('app','Projects signed up'); ?></h2><br/><br/>

				<ul class="small-block-grid-1 large-block-grid-3">
						<?php 
						//$i = 0;
						//$page = 1;
						//$maxPage = 3;
						foreach ($event['ideas'] as $idea){
							if(isset($idea['id'])){
							?>
							<li>
							<?php  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
							</li>
						<?php }} ?>
				  </ul>

			</div>
		</div>

	<?php } ?>

	<?php if (isset($event['people']) && count($event['people']) > 0){ ?>
		<div class="row mt40">
			<div class="columns large-12 small-12"> 
				<h2 class="meta-title l-inline"><?php echo Yii::t('app','People signed up'); ?></h2><br/><br/>

				<ul class="small-block-grid-1 large-block-grid-3">
						<?php 
						//$i = 0;
						//$page = 1;
						//$maxPage = 3;
						foreach ($event['people'] as $user){
							if(isset($user['id'])){
							?>
							<li>
							<?php  $this->renderPartial('//person/_user', array('user' => $user));  ?>
							</li>
						<?php }} ?>
				  </ul>

			</div>
		</div>

	<?php } ?>

	<?php if (isset($event['ideas']) && count($event['ideas']) > 0 && $event['idea_id'] > 0){ ?>
		<div class="row mt40">
			<div class="columns large-12 small-12"> 
				<h2 class="meta-title l-inline"><?php echo Yii::t('app','Projects signed up'); ?></h2><br/><br/>

				<ul class="small-block-grid-1 large-block-grid-3">
						<?php 
						//$i = 0;
						//$page = 1;
						//$maxPage = 3;
						foreach ($event['ideas'] as $idea){
							if(isset($idea['id'])){
							?>
							<li>
							<?php  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
							</li>
						<?php }} ?>
				  </ul>

			</div>
		</div>

	<?php } ?>