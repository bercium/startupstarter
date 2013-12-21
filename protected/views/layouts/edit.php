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
    

      <?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"sidebar")); ?> 
    
    
      <div class="section-container sidebar accordion edit-content edit-content-bottom" data-section>
        <section class="section <?php echo isMenuItemActive('index'); ?>">
          <p class="title"><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><span class="icon-user"></span><?php echo Yii::t('app','Profile'); ?></a></p>
        </section>
        <section class="section <?php echo isMenuItemActive(array("create","projects","edit")); ?>">
          <p class="title">
            <a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><span class="icon-lightbulb"></span>
              <?php echo Yii::t('app','My projects'); ?>
            </a>
          </p>
        </section>
        <section class="section <?php echo isMenuItemActive("account"); ?>">
          <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><span class="icon-wrench"></span><?php echo Yii::t('app','Settings'); ?></a></p>
        </section>
        <section class="section <?php echo isMenuItemActive("message"); ?>">
          <p class="title"><a href="<?php echo Yii::app()->createUrl("message/view"); ?>"><span class="icon-envelope icon-awesome"></span><?php echo Yii::t('app','Message history'); ?></a></p>
        </section>
        
        <?php //if(Yii::app()->user->isAdmin()){ ?>
        <section class="section <?php echo isMenuItemActive("notification"); ?>">
          <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/notification"); ?>"><span class="icon-flag"></span><?php echo Yii::t('app','Notifications'); ?></a></p>
        </section><?php //} ?>
      </div>

    
    <?php //$this->widget('ext.SidebarEditMenu.WEditSidebar',array("ideas"=>(isset($ideas)?$ideas:array()))); ?>
    
  </div>
  <div class="large-8 columns">
    
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
