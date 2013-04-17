<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'New project'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    <?php
    $this->renderPartial('_formidea', array(
        'idea' => $idea,
        'user' => $user,
        'translation' => $translation,
        'buttons' => 'create'));
    ?>
  </div>
</div>
