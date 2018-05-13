<?php
/* @var $this BackendEventCofinderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Cofinders',
);

$this->menu=array(
	array('label'=>'Create EventCofinder', 'url'=>array('create')),
	array('label'=>'Manage EventCofinder', 'url'=>array('admin')),
);
?>

<h1>Event Cofinders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
