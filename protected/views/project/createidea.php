<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Create a project'); ?></h3>

    <div class="breadcrumbs">
      <?php if($step == 1) echo "<strong>"; ?>1. Presentation <?php if($step == 1) echo "</strong>"; ?>| 
      <?php if($step == 2) echo "<strong>"; ?>2. Team <?php if($step == 2) echo "</strong>"; ?>| 
      <?php if($step == 3) echo "<strong>"; ?>3. Social <?php if($step == 3) echo "</strong>"; ?>| 
       You're done!
    </div>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    <?php
    if($step == 1){
      $this->renderPartial('_formcreateidea', array(
          'idea' => $idea,
          'user' => $user,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    } elseif($step == 2){
      $this->renderPartial('_formteam', array(
          'idea' => $idea,
          'user' => $user,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    } elseif($step == 3){
      $this->renderPartial('_formsocial', array(
          'idea' => $idea,
          'user' => $user,
          'language' => $language,
          'translation' => $translation,
          'buttons' => 'create'));
    }
    ?>
  </div>
</div>
