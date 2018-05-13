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
			'name' => 'senderId',
			'type' => 'raw',
			'value' => $model->senderId !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->senderId)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->senderId, true))) : null,
			),
'key',
'email',
array(
			'name' => 'ideaId',
			'type' => 'raw',
			'value' => $model->ideaId !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->ideaId)), array('idea/view', 'id' => GxActiveRecord::extractPkValue($model->ideaId, true))) : null,
			),
array(
			'name' => 'receiverId',
			'type' => 'raw',
			'value' => $model->receiverId !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->receiverId)), array('user/view', 'id' => GxActiveRecord::extractPkValue($model->receiverId, true))) : null,
			),
'time_invited',
'code',
'registered:boolean',
	),
)); ?>

