<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="row header-margin">
  <?php $this->widget('ext.Invitation.WInvitation'); ?>  



  <div class="large-12 columns hint-alert" >
  	<?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"hint")); ?>


    <!-- here moved alert-box from \protected\views\profile\profile.php -->
    <?php if(Yii::app()->user->hasFlash('profileMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
      <a href="#" class="icon-remove-sign">&times;</a>
    </div>
    <?php } ?>
    <?php if(Yii::app()->user->hasFlash('profileMessageError')){ ?>
    <div data-alert class="alert-box radius alert">
      <?php echo Yii::app()->user->getFlash('profileMessageError'); ?>
      <a href="#" class="icon-remove-sign">&times;</a>
    </div>
    <?php } ?>
    
  </div>
  
  <div class="large-3 sidebar-wrap columns">
    
    <?php $this->widget('ext.SidebarEditMenu.WEditSidebar',array("ideas"=>(isset($ideas)?$ideas:array()))); ?>
    <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"sidebar")); ?>	
  </div>
  <div class="large-9 columns">
    
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
