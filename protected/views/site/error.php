<?php
	$this->pageTitle = Yii::t('app','Error')." ".$code;
?>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>