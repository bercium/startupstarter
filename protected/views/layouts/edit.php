<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row" style="margin-top:20px;">
  <div class="small-12 large-3 columns">
    <div class="profile-info">
      Profile completness:
      <?php $this->widget('ext.ProgressBar.WProgressBar'); ?>
      Member since: <strong>30.11.2011</strong>
    </div>
    <?php $this->widget('ext.SidebarEditMenu.WEditSidebar'); ?>
  </div>
  <div class="small-12 large-9 columns">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
