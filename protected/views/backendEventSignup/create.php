<?php
/* @var $this BackendEventSignupController */
/* @var $model EventSignup */

$this->breadcrumbs=array(
	'Event Signups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventSignup', 'url'=>array('index')),
	array('label'=>'Manage EventSignup', 'url'=>array('admin')),
);
?>

<h1>Create EventSignup</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>