<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('url')); ?>:
	<?php echo GxHtml::encode($data->url); ?>
	<br />

</div>