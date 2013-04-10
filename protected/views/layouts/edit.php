<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row">
  <div class="small-12 large-3 columns">
    <div class="profile-info">
    Profile completness:
    <?php $this->widget('ext.ProgressBar.WProgressBar'); ?>
    Member since: <strong>30.11.2011</strong>
    </div>
    <div class="section-container accordion" data-section>
      <section class="section">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></p>
      </section>
      <section class="section active">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Ideas')); ?></a></p>
        <div class="content">
          <a href="#"><p>Ideja 1<br /><span class="idea-detail">seen: 130 times</span></p></a>
          <a href="#"><p>Ideja 2<br /><span>seen: 13 times</span></p></a>
          <a href="#"><p>Ideja 3<br /><span>seen: 45 times</span></p></a>
        </div>
      </section>
      <section class="section">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Settings')); ?></a></p>
      </section>
    </div>
  </div>
  <div class="small-12 large-9 columns">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>