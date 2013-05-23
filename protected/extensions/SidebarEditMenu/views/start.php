<div class="section-container sidebar accordion" data-section>
  <section class="section <?php echo isMenuItemActive(""); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><span class="general foundicon-smiley"></span><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></p>
  </section>
  <section class="section <?php echo isMenuItemActive(array("create","projects","edit")); ?>">
    <p class="title">
      <a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><span class="general foundicon-idea"></span>
        <?php echo CHtml::encode(Yii::t('app','Projects')); ?>
      </a>
    </p>
    <div class="content ideas-aside">
      <a class="idea-new" href="<?php echo Yii::app()->createUrl("project/create"); ?>" class="ideas-aside-new <?php echo isMenuItemActive("create"); ?>">
        <?php echo CHtml::encode(Yii::t('app','Create a new project').' +'); ?>
      </a>
      <?php foreach ($ideas as $idea){ ?>
      <a href="<?php echo Yii::app()->createUrl("project/edit/".$idea['id']); ?>" >
        <div class="idea-each alpha omega" >
          <span class="alt"><?php echo $idea['title']; ?></span>
          <small class="meta"><?php echo Yii::t("app","viewed {n} time|viewed {n} times",array($idea['num_of_clicks'])); ?></small>
        </div>
        </a>
      <?php } ?>
    </div>
  </section>
  <section class="section <?php echo isMenuItemActive("account"); ?>">
    <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><span class="general foundicon-settings"></span><?php echo CHtml::encode(Yii::t('app','Settings')); ?></a></p>
  </section>
</div>