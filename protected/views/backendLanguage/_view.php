<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_code')); ?>:
	<?php echo GxHtml::encode($data->language_code); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
  <?php echo GxHtml::encode($data->getAttributeLabel('native_name')); ?>:
	<?php echo GxHtml::encode($data->native_name); ?>
	<br />
  
</div>