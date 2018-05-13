<?php
/* @var $this BackendEventCofinderController */
/* @var $model EventCofinder */

$this->breadcrumbs=array(
	'Event Cofinders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventCofinder', 'url'=>array('index')),
	array('label'=>'Manage EventCofinder', 'url'=>array('admin')),
);
?>

<h1>Create EventCofinder</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>