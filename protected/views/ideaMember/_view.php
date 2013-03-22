<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('idea_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idea)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('match_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->match)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('type')); ?>:
	<?php echo GxHtml::encode($data->type); ?>
	<br />

</div>