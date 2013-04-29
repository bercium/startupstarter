<?php
$this->breadcrumbs=array(
	Yii::t('app','Users')=>array('index'),
	$model->email,
);
$this->layout='//layouts/column2';
$this->menu=array(
    array('label'=>Yii::t('app','List User'), 'url'=>array('index')),
);
?>
<h1><?php echo Yii::t('app','View User').' "'.$model->email.'"'; ?></h1>
<?php 

// For all users
	$attributes = array(
			'email',
	);
	
	/*$profileFields=ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => Yii::t('app',$field->title),
					'name' => $field->varname,
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),

				));
		}
	}*/
	array_push($attributes,
		'create_at',
		array(
			'name' => 'lastvisit_at',
			'value' => (($model->lastvisit_at!='0000-00-00 00:00:00')?$model->lastvisit_at:Yii::t('app','Not visited')),
		)
	);
			
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));

?>
