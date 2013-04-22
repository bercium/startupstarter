<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row" style="margin-top:20px;">
  <div class="small-12 large-3 columns">
    <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("detail"=>true)); ?>
    <?php $this->widget('ext.SidebarEditMenu.WEditSidebar',array("data"=>$this->data)); ?>
  </div>
  <div class="small-12 large-9 columns">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
