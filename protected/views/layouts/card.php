<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row header-margin mb40">
	<div class="large-10 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo $this->pageTitle; ?></h1>
	</div>
  <div class="columns panel edit-content">
  	
    <?php echo $content; ?>
  </div>
  </div>
</div>

<?php $this->endContent(); ?>