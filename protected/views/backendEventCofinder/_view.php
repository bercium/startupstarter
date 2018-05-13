<?php
/* @var $this BackendEventCofinderController */
/* @var $data EventCofinder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_person')); ?>:</b>
	<?php echo CHtml::encode($data->price_person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_idea')); ?>:</b>
	<?php echo CHtml::encode($data->price_idea); ?>
	<br />


</div>