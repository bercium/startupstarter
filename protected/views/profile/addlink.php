<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($link->label()); ?></h1>

<?php
$this->renderPartial('_formlink', array(
		'link' => $link,
		'buttons' => 'create'));
?>