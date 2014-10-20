<?php
/* @var $this BackendEventCofinderController */
/* @var $model EventCofinder */

$this->breadcrumbs=array(
	'Event Cofinders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventCofinder', 'url'=>array('index')),
	array('label'=>'Create EventCofinder', 'url'=>array('create')),
	array('label'=>'Update EventCofinder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventCofinder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventCofinder', 'url'=>array('admin')),
);
?>

<h1>View EventCofinder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'event_id',
		'price_person',
		'price_idea',
	),
)); ?>
