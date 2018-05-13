<?php
/* @var $this BackendEventSignupController */
/* @var $data EventSignup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idea_id')); ?>:</b>
	<?php echo CHtml::encode($data->idea_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment')); ?>:</b>
	<?php echo CHtml::encode($data->payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('survey')); ?>:</b>
	<?php echo CHtml::encode($data->survey); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('canceled')); ?>:</b>
	<?php echo CHtml::encode($data->canceled); ?>
	<br />

	*/ ?>

</div>