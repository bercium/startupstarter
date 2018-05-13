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
			'name' => 'tag',
			'type' => 'raw',
			'value' => $model->tag !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->tag)), array('tag/view', 'id' => GxActiveRecord::extractPkValue($model->tag, true))) : null,
			),
array(
			'name' => 'event',
			'type' => 'raw',
			'value' => $model->event !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->event)), array('event/view', 'id' => GxActiveRecord::extractPkValue($model->event, true))) : null,
			),
array(
			'name' => 'addedBy',
			'type' => 'raw',
			'value' => $model->addedBy !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->addedBy)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->addedBy, true))) : null,
			),
'added_time',
array(
			'name' => 'revokedBy',
			'type' => 'raw',
			'value' => $model->revokedBy !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->revokedBy)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->revokedBy, true))) : null,
			),
'revoked_time',
	),
)); ?>

