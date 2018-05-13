<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
  <br />
	<?php echo GxHtml::encode($data->getAttributeLabel('country_code')); ?>:
	<?php echo GxHtml::encode($data->country_code); ?>
	<br />

</div>