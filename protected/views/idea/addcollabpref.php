<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($idea->label()); ?></h1>

<?php
$this->renderPartial('_formcollabpref', array(
		'idea' => $idea,
		'collabpref' => $collabpref,
		'buttons' => 'create'));
?>