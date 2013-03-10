<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('link_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->link)); ?>
	<br />

</div>