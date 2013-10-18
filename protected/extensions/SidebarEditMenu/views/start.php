<div class="section-container sidebar accordion" data-section>
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
      <a class="idea-new" href="<?php echo Yii::app()->createUrl("project/create"); ?>" class="ideas-aside-new <?php echo isMenuItemActive("create"); ?>">
        <?php echo Yii::t('app','Create a new project').' +'; ?>
      </a>
      <?php
      if ($ideas)
        foreach ($ideas as $idea){ ?>
      <a href="<?php echo Yii::app()->createUrl("project/edit/".$idea['id']); ?>" >
        <div class="idea-each alpha omega" >
          <span class="alt"><?php echo $idea['title']; ?></span>
          <small class="meta"><?php echo Yii::t("app","viewed {n} time|viewed {n} times",array($idea['num_of_clicks'])); ?></small>
          <small class="meta right"><?php if ($idea['type_id'] == 1) echo Yii::t("app","owner"); else echo Yii::t("app","member"); ?></small>
        </div>
        </a>
      <?php } ?>
    </div>
  </section>
  <section class="section <?php echo isMenuItemActive("account"); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><span class="general foundicon-settings"></span><?php echo Yii::t('app','Settings'); ?></a></p>
  </section>
  <?php //if(Yii::app()->user->isAdmin()){ ?>
  <section class="section <?php echo isMenuItemActive("notification"); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/notification"); ?>"><span class="icon-flag"></span><?php echo Yii::t('app','Notifications'); ?></a></p>
  </section><?php //} ?>
</div>