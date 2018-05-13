<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('time_registered')); ?>:
	<?php echo GxHtml::encode($data->time_registered); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('time_updated')); ?>:
	<?php echo GxHtml::encode($data->time_updated); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->status)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('website')); ?>:
	<?php echo GxHtml::encode($data->website); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('video_link')); ?>:
	<?php echo GxHtml::encode($data->video_link); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('deleted')); ?>:
	<?php echo GxHtml::encode($data->deleted); ?>
	<br />

</div>