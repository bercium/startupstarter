<?php
/* @var $this BackendEventCofinderController */
/* @var $model EventCofinder */

$this->breadcrumbs=array(
	'Event Cofinders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventCofinder', 'url'=>array('index')),
	array('label'=>'Create EventCofinder', 'url'=>array('create')),
	array('label'=>'View EventCofinder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventCofinder', 'url'=>array('admin')),
);
?>

<h1>Update EventCofinder <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>