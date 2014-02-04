<?php
/* @var $this TranslationController */
	$this->pageTitle = Yii::t('app','Translations');
?>
<?php echo CHtml::beginForm('','get',array("class"=>"custom")); ?>

<?php echo CHtml::label(Yii::t('app','Language')."",'SifTranslate_language'); ?>
<?php echo CHtml::dropDownList('SifTranslate[language]',(isset($_GET['SifTranslate']['language'])?$_GET['SifTranslate']['language']:''),ELangPick::getLanguageList(true), array('empty' => '&nbsp;',"style"=>"display:none")); ?>
<?php echo CHtml::label(Yii::t('app','Code list')."",'SifTranslate_codelist'); ?>
<?php echo CHtml::dropDownList('SifTranslate[codelist]',(isset($_GET['SifTranslate']['codelist'])?$_GET['SifTranslate']['codelist']:''),$codeLists, array('empty' => '&nbsp;',"style"=>"display:none")); ?>
<?php echo CHtml::submitButton(Yii::t("app","Show"),array("class"=>"button small radius")); ?>
<?php echo CHtml::endForm(); ?>
<?php if ($trans){ ?>
<h3><?php echo Yii::t('app','List of translations'); ?></h3>
<?php echo CHtml::beginForm(Yii::app()->createUrl("translation/translate"),'post',array("class"=>"custom")); ?>
<?php echo CHtml::hiddenField('language',$_GET['SifTranslate']['language']); ?>
<?php echo CHtml::hiddenField('codelist',$_GET['SifTranslate']['codelist']); ?>
<?php if (isset($_GET['key'])) echo CHtml::hiddenField('key',$_GET['key']); ?>
<?php 
foreach ($trans as $id => $row){
  echo "<p>".CHtml::label(strtr($row['eng'],Array("<"=>"&lt;","&"=>"&amp;"))."",'Translations_'.$id);
  $class = "error";
  if ($row['trans']) $class="success";
  echo CHtml::textArea('Translations['.$id.']',$row['trans'],array("class"=>$class,"onchange"=>"$(this).removeClass()"))."</p>";
} ?>
<?php echo CHtml::submitButton(Yii::t("app","Save"),array("class"=>"button small success radius")); ?>
<?php echo CHtml::endForm(); ?>
<?php } ?>