<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Create a project'); ?></h3>

    <div class="breadcrumbs">
      1. Presentation | 2. Team | 3. Social | You're done!
    </div>
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
