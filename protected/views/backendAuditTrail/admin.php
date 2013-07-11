<?php
$this->breadcrumbs=array(
	'Audit Trails'=>array('/auditTrail'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List AuditTrail', 'url'=>array('index')),
	array('label'=>'Create AuditTrail', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('audit-trail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Audit Trails</h1>

<p>
<?php echo Yii::t('msg','You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-trail-grid',
	'dataProvider'=>$model->search(array('sort'=> array('defaultOrder'=>'id DESC'))),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'action',
		'model',
		'field',
		'old_value',
		'new_value',
    array(
        'name' => 'stamp',
        'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->stamp),"medium","medium")'
    ),      
		'user_id',
		'model_id',
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
));
?>

