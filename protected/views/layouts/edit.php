<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="row header-margin">
  <?php $this->widget('ext.Invitation.WInvitation'); ?>  

  <?php /* ?>
  <div class="large-12 columns hint-alert" >
  	<?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"hint")); ?>
    <!-- here moved alert-box from \protected\views\profile\profile.php -->
  </div><?php //*/ ?>
  
  <div class="large-4 sidebar-wrap columns">
    
    <?php $this->widget('ext.SidebarEditMenu.WEditSidebar',array("ideas"=>(isset($ideas)?$ideas:array()))); ?>
    <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"sidebar")); ?> 
    
  </div>
  <div class="large-8 columns">
    
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
