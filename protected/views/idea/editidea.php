<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <div class="edit-floater">
      <a class="small button alert radius" style="margin-bottom:0;" href=""><?php echo Yii::t('app','Delete') ?></a>
    </div>
    <h3><?php echo Yii::t('app', 'Edit project'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
  <?php
  $this->renderPartial('_formidea', array(
      'idea' => $idea,
      'data' => $data,
      'buttons' => 'edit',
      'translation' => $translation));
  ?>
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Searching for'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>
