<?php
/* @var $this BackendEventSignupController */
/* @var $model EventSignup */

$this->breadcrumbs=array(
	'Event Signups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventSignup', 'url'=>array('index')),
	array('label'=>'Create EventSignup', 'url'=>array('create')),
	array('label'=>'View EventSignup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventSignup', 'url'=>array('admin')),
);
?>

<h1>Update EventSignup <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>