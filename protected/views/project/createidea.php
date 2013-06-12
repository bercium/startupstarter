<div class="row createidea">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Create a project'); ?></h3>

    <ol class="breadcrumbs meta">      
      <li>Presentation</li>
      <li> Team</li>
      <li> Social</li>
      <li> You're done!</li>
    </ol>
   
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
