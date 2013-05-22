<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row" style="margin-top:20px;">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo $this->pageTitle; ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>