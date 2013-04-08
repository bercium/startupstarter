<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($skill->label()); ?></h1>

<?php
$this->renderPartial('_formskill', array(
		'skill' => $skill,
		'buttons' => 'create'));
?>