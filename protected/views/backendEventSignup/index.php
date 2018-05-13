<?php
/* @var $this BackendEventSignupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Signups',
);

$this->menu=array(
	array('label'=>'Create EventSignup', 'url'=>array('create')),
	array('label'=>'Manage EventSignup', 'url'=>array('admin')),
);
?>

<h1>Event Signups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
