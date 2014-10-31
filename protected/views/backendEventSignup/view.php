<?php
/* @var $this BackendEventSignupController */
/* @var $model EventSignup */

$this->breadcrumbs=array(
	'Event Signups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventSignup', 'url'=>array('index')),
	array('label'=>'Create EventSignup', 'url'=>array('create')),
	array('label'=>'Update EventSignup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventSignup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventSignup', 'url'=>array('admin')),
);
?>

<h1>View EventSignup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'event_id',
		'user_id',
		'time',
		'idea_id',
		'payment',
		'survey',
		'canceled',
	),
)); ?>
