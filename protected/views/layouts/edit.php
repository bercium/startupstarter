<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row" style="margin-top:20px;">
  <div class="small-12 large-3 columns">
    <div class="profile-info">
      Profile completness:
      <?php $this->widget('ext.ProgressBar.WProgressBar'); ?>
      Member since: <strong>30.11.2011</strong>
    </div>
    <div class="section-container sidebar accordion" data-section>
      <section class="section <?php echo isMenuItemActive(""); ?>">
        <p class="title"><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></p>
      </section>
      <section class="section <?php echo isMenuItemActive(array("create","projects","edit")); ?>">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Projects')); ?></a></p>
        <div class="content ideas-aside">
          <a href="<?php echo Yii::app()->createUrl("idea/create"); ?>" class="ideas-aside-new <?php echo isMenuItemActive("create"); ?>">
            <?php echo CHtml::encode(Yii::t('app','Create new project')); ?>
          </a>
          <a href="#" >
            <span class="alt">Ideja 1</span>
            <small class="meta">seen: 130 times</small>
          </a>
          <a href="#">
            <span class="alt">Ideja 2</span>
            <small class="meta">seen: 25 times</small>
          </a>
          <a href="#">
            <span class="alt">Ideja 3</span>
            <small class="meta">seen: 13 times</small>
          </a>
        </div>
      </section>
      <section class="section <?php echo isMenuItemActive("account"); ?>">
        <p class="title"><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><?php echo CHtml::encode(Yii::t('app','Settings')); ?></a></p>
      </section>
    </div>
  </div>
  <div class="small-12 large-9 columns">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>
