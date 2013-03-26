<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->language)); ?>
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