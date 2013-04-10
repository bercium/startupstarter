<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row">
  <div class="small-12 large-3 columns">
    <div class="profile-info">
    Profile completness:
    <?php $this->widget('ext.ProgressBar.WProgressBar'); ?>
    Member since: <strong>30.11.2011</strong>
    </div>
   <sidebar> 
    <div class="section-container sidebar accordion" data-section>
      <section class="section">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></p>
      </section>
      <section class="section active">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Ideas')); ?></a></p>
        <div class="content ideas-aside">
         <a href="#"><small class="alt">Ideja 1</small><small class="meta">seen: 130 times</small></a>
          <a href="#"><small class="alt">Ideja 1</small><small class="meta">seen: 130 times</small></a>
           <a href="#"><small class="alt">Ideja 1</small><small class="meta">seen: 130 times</small></a>
         <a href="#"><small class="alt">Ideja 1</small><small class="meta">seen: 130 times</small></a>

        </div>
      </section>
      <section class="section">
        <p class="title"><a href="#"><?php echo CHtml::encode(Yii::t('app','Settings')); ?></a></p>
      </section>
    </div>
  </sidebar>
  </div>
  <div class="small-12 large-9 columns">
    <?php echo $content; ?>
  </div>
</div>

<?php $this->endContent(); ?>