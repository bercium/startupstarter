<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($idea->label()); ?></h1>

<?php
$this->renderPartial('_formskill', array(
		'idea' => $idea,
		'skill' => $skill,
		'buttons' => 'create'));
?>