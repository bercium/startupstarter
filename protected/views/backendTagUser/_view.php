<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('tag_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->tag)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('added_by')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->addedBy)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('added_time')); ?>:
	<?php echo GxHtml::encode($data->added_time); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('revoked_by')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->revokedBy)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('revoked_time')); ?>:
	<?php echo GxHtml::encode($data->revoked_time); ?>
	<br />

</div>