<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row" style="margin-top:20px;">
  <div class="large-3 columns">
    <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"sidebar")); ?>
    <?php $this->widget('ext.SidebarEditMenu.WEditSidebar',array("ideas"=>(isset($ideas)?$ideas:array()))); ?>
  </div>
  <div class="large-9 columns">
    <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"hint")); ?>
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
