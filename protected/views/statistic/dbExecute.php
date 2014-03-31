<?php
	$this->pageTitle = 'Create DB queries';
?>

<?php echo CHtml::beginForm('','post',array("class"=>"custom large-7")); ?>


  <p>
    <?php echo CHtml::label(Yii::t('app','SQL'),false); ?>
    <?php echo CHtml::textArea('dbform[sql]', ''); ?>
 </p>
 
<br />

<?php echo CHtml::submitButton(Yii::t('app',"Activate"),array("class"=>"button radius success")); ?>
<?php echo CHtml::endForm(); ?>


<?php 
if ($dataProvider){
  $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'backend-user-grid',
    'dataProvider' => $dataProvider,
    //'filter' => $model,
    //'columns' => $columns,
  ));

}
?>