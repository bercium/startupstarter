<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('skillset_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->skillset)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('skill_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->skill)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('usage_count')); ?>:
	<?php echo GxHtml::encode($data->usage_count); ?>
	<br />

</div>