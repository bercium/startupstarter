<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('ID')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->ID), array('view', 'id' => $data->ID)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('VIRTUAL')); ?>:
	<?php echo GxHtml::encode($data->VIRTUAL); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('surname')); ?>:
	<?php echo GxHtml::encode($data->surname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('md5_pass')); ?>:
	<?php echo GxHtml::encode($data->md5_pass); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('time_registered')); ?>:
	<?php echo GxHtml::encode($data->time_registered); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('time_updated')); ?>:
	<?php echo GxHtml::encode($data->time_updated); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('avatar_link')); ?>:
	<?php echo GxHtml::encode($data->avatar_link); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('time_per_week')); ?>:
	<?php echo GxHtml::encode($data->time_per_week); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('newsletter')); ?>:
	<?php echo GxHtml::encode($data->newsletter); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('language_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->language)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('country_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->country)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('city_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->city)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('address')); ?>:
	<?php echo GxHtml::encode($data->address); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('deleted')); ?>:
	<?php echo GxHtml::encode($data->deleted); ?>
	<br />
	*/ ?>

</div>