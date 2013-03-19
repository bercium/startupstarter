<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('password')); ?>:
	<?php echo GxHtml::encode($data->password); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('activkey')); ?>:
	<?php echo GxHtml::encode($data->activkey); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('create_at')); ?>:
	<?php echo GxHtml::encode($data->create_at); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('lastvisit_at')); ?>:
	<?php echo GxHtml::encode($data->lastvisit_at); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('superuser')); ?>:
	<?php echo GxHtml::encode($data->superuser); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
	<?php echo GxHtml::encode($data->name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('surname')); ?>:
	<?php echo GxHtml::encode($data->surname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('address')); ?>:
	<?php echo GxHtml::encode($data->address); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('avatar_link')); ?>:
	<?php echo GxHtml::encode($data->avatar_link); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('language_id')); ?>:
	<?php echo GxHtml::encode($data->language_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('newsletter')); ?>:
	<?php echo GxHtml::encode($data->newsletter); ?>
	<br />
	*/ ?>

</div>