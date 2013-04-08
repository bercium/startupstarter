<h1><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($user->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($user)); ?></h1>

<?php
$this->renderPartial('_formuser', array(
		'user' => $user,
		'data' => $data,
		'match' => $match));
?>