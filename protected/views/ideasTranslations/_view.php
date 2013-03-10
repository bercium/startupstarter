<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('language_code')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->languageCode)); ?>
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
	*/ ?>

</div>