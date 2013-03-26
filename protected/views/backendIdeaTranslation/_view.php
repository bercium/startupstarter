<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->language)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('idea_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->idea)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('pitch')); ?>:
	<?php echo GxHtml::encode($data->pitch); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description')); ?>:
	<?php echo GxHtml::encode($data->description); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('description_public')); ?>:
	<?php echo GxHtml::encode($data->description_public); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('tweetpitch')); ?>:
	<?php echo GxHtml::encode($data->tweetpitch); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('deleted')); ?>:
	<?php echo GxHtml::encode($data->deleted); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
	<?php echo GxHtml::encode($data->title); ?>
	<br />
	*/ ?>

</div>