<div class="section-container sidebar accordion edit-content" data-section>
  <section class="section <?php echo isMenuItemActive('index'); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><span class="icon-user"></span><?php echo Yii::t('app','Profile'); ?></a></p>
  </section>
  <section class="section <?php echo isMenuItemActive(array("create","projects","edit")); ?>">
    <p class="title">
      <a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><span class="icon-lightbulb"></span>
        <?php echo Yii::t('app','Projects'); ?>
      </a>
    </p>
    <div class="content ideas-aside">
      <small><a class="button success large-12" href="<?php echo Yii::app()->createUrl("project/create"); ?>" class="ideas-aside-new <?php echo isMenuItemActive("create"); ?>">
        <?php echo Yii::t('app','Create a new project').' <span class="right icon-plus"></span>'; ?>
      </a></small>
      <?php
      if ($ideas)
        foreach ($ideas as $idea){ ?>
      <a href="<?php echo Yii::app()->createUrl("project/edit/".$idea['id']); ?>" >
        <div class="idea-each" ><p>
          <span class="idealist"><?php echo $idea['title']; ?></span>
        <div class="meta-wrap">
           <span class="meta"><?php echo Yii::t("app","viewed {n} time|viewed {n} times",array($idea['num_of_clicks'])); ?></span>
          <small class="meta right"><?php if ($idea['type_id'] == 1) echo "<span class='label'>".Yii::t("app","owner")."</span>"; else echo Yii::t("app","Member"); ?></small>
        </div>
        </div>
        </a>
      <?php } ?>
    </p></div>
  </section>
  <section class="section <?php echo isMenuItemActive("account"); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><span class="icon-wrench"></span><?php echo Yii::t('app','Settings'); ?></a></p>
  </section>
  <?php //if(Yii::app()->user->isAdmin()){ ?>
  <section class="section nob <?php echo isMenuItemActive("notification"); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/notification"); ?>"><span class="icon-flag"></span><?php echo Yii::t('app','Notifications'); ?></a></p>
  </section><?php //} ?>


  
</div>
