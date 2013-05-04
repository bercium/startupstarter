<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t('app',"Change password");
$this->breadcrumbs=array(
	Yii::t('app',"Login") => array('/user/login'),
	Yii::t('app',"Change password"),
);
?>

<h1><?php echo Yii::t('app',"Change password"); ?></h1>


<div class="form">
<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo Yii::t('msg','Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'password'); ?>
	<?php echo CHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo Yii::t('msg',"Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo CHtml::submitButton(Yii::t('app',"Save")); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->