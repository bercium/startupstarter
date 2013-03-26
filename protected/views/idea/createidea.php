<h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($idea->label()); ?></h1>

<?php
$this->renderPartial('_formidea', array(
		'idea' => $idea,
		'translation' => $translation,
		'buttons' => 'create'));
?>