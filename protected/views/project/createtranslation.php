<?php $this->pageTitle = Yii::t('app','Translation'); ?>

<div class="row createidea">
  <div class="columns edit-header">
<h1><?php echo Yii::t('app', 'Translate project'); ?></h1>
  </div>
  <div class="columns panel edit-content">
<?php
$this->renderPartial('_formtranslation', array(
		'translation' => $translation,
    "id" => $idea['id'],
		'buttons' => 'create'));
?>
  </div>
</div>