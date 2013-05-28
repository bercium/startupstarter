<?php
/* @var $this TranslationController */
	$this->pageTitle = Yii::t('app','Translations');
?>

<?php echo CHtml::beginForm(Yii::app()->createUrl("translation/index"),'get',array("class"=>"custom")); ?>

<?php echo CHtml::label(Yii::t('app','Language').":",'SifTranslate_language'); ?>
<?php echo CHtml::dropDownList('SifTranslate[language]',(isset($_GET['SifTranslate']['language'])?$_GET['SifTranslate']['language']:''),ELangPick::getLanguageList(true), array('empty' => '&nbsp;',"style"=>"display:none")); ?>

<?php echo CHtml::label(Yii::t('app','Code list').":",'SifTranslate_codelist'); ?>
<?php echo CHtml::dropDownList('SifTranslate[codelist]',(isset($_GET['SifTranslate']['codelist'])?$_GET['SifTranslate']['codelist']:''),$codeLists, array('empty' => '&nbsp;',"style"=>"display:none")); ?>

<?php echo CHtml::submitButton(Yii::t("app","Show"),array("class"=>"button small radius")); ?>

<?php echo CHtml::endForm(); ?>

<?php if ($trans){ ?>


<h3><?php echo Yii::t('app','List of translations'); ?></h3>


<?php if(Yii::app()->user->hasFlash('translationsMessage')){ ?>
<div data-alert class="alert-box radius success">
  <?php echo Yii::app()->user->getFlash('translationsMessage'); ?>
  <a href="#" class="close">&times;</a>
</div>
<?php } ?>


<?php echo CHtml::beginForm(Yii::app()->createUrl("translation/translate"),'post',array("class"=>"custom")); ?>

<?php echo CHtml::hiddenField('language',$_GET['SifTranslate']['language']); ?>
<?php echo CHtml::hiddenField('codelist',$_GET['SifTranslate']['codelist']); ?>

<?php 
foreach ($trans as $id => $row){
  echo CHtml::label($row['eng'].":",'Translations_'.$id);
  echo CHtml::textField('Translations['.$id.']',$row['trans']);
} ?>

<?php echo CHtml::submitButton(Yii::t("app","Save"),array("class"=>"button small success radius")); ?>

<?php echo CHtml::endForm(); ?>


<?php } ?>