<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->ID)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->ID), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'ID',
'VIRTUAL',
'name',
'surname',
'email',
'md5_pass',
'time_registered',
'time_updated',
'avatar_link',
'time_per_week',
'newsletter',
array(
			'name' => 'languageCode',
			'type' => 'raw',
			'value' => $model->languageCode !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->languageCode)), array('languages/view', 'id' => GxActiveRecord::extractPkValue($model->languageCode, true))) : null,
			),
array(
			'name' => 'country',
			'type' => 'raw',
			'value' => $model->country !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->country)), array('countries/view', 'id' => GxActiveRecord::extractPkValue($model->country, true))) : null,
			),
array(
			'name' => 'city',
			'type' => 'raw',
			'value' => $model->city !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->city)), array('cities/view', 'id' => GxActiveRecord::extractPkValue($model->city, true))) : null,
			),
'address',
'deleted',
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('ideasMembers')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->ideasMembers as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('ideasMembers/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('usersCollabprefs')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->usersCollabprefs as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('usersCollabprefs/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('usersLinks')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->usersLinks as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('usersLinks/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('usersSkills')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->usersSkills as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('usersSkills/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>