<h1><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($idea->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($idea)); ?></h1>

<?php
$this->renderPartial('_formidea', array(
		'idea' => $idea,
		'translation' => $translation));
?>