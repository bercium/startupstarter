<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_code')); ?>:
	<?php echo GxHtml::encode($data->language_code); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />

</div>