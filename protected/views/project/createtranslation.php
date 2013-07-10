<h1><?php echo Yii::t('app', 'Translate project'); ?></h1>

<?php
$this->renderPartial('_formtranslation', array(
		'translation' => $translation,
		'buttons' => 'create'));
?>