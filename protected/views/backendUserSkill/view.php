<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
			'name' => 'match',
			'type' => 'raw',
			'value' => $model->match !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->match)), array('userMatch/view', 'id' => GxActiveRecord::extractPkValue($model->match, true))) : null,
			),
array(
			'name' => 'skillset',
			'type' => 'raw',
			'value' => $model->skillset !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->skillset)), array('skillset/view', 'id' => GxActiveRecord::extractPkValue($model->skillset, true))) : null,
			),
array(
			'name' => 'skill',
			'type' => 'raw',
			'value' => $model->skill !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->skill)), array('skill/view', 'id' => GxActiveRecord::extractPkValue($model->skill, true))) : null,
			),
	),
)); ?>

