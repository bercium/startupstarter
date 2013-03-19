<?php

$this->breadcrumbs = array(
	UserCollabpref::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . UserCollabpref::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . UserCollabpref::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(UserCollabpref::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 