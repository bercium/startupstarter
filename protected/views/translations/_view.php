<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_code')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->languageCode)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('table')); ?>:
	<?php echo GxHtml::encode($data->table); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('row_id')); ?>:
	<?php echo GxHtml::encode($data->row_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('translation')); ?>:
	<?php echo GxHtml::encode($data->translation); ?>
	<br />

</div>