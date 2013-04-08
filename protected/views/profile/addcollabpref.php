<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($collabpref->label()); ?></h1>

<?php
$this->renderPartial('_formcollabpref', array(
		'collabpref' => $collabpref,
		'buttons' => 'create'));
?>