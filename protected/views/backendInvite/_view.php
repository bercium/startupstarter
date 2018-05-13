<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('sender_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->senderId)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('key')); ?>:
	<?php echo GxHtml::encode($data->key); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('idea_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->ideaId)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('receiver_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->receiverId)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('time_invited')); ?>:
	<?php echo GxHtml::encode($data->time_invited); ?>
	<br />
	
	<?php echo GxHtml::encode($data->getAttributeLabel('code')); ?>:
	<?php echo GxHtml::encode($data->code); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('registered')); ?>:
	<?php echo GxHtml::encode($data->registered); ?>
	<br />


</div>