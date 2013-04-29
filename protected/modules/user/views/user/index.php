<?php
$this->breadcrumbs=array(
	Yii::t('app',"Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>Yii::t('app','Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>Yii::t('app','Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h1><?php echo Yii::t('app',"List User"); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'email',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->email),array("user/view","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
	),
)); ?>
