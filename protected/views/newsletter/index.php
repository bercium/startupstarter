

<?php if(Yii::app()->user->hasFlash('newsletter')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('newsletter'); ?>
</div>

<?php else: ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'newsletter-form',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'newsletterTitle'); ?>
		<?php echo $form->textField($model,'newsletterTitle'); ?>
		<?php //echo $form->error($model,'newsletterTitle'); ?>
	</div>

  
	<div class="row">
    <?php echo $form->labelEx($model,'newsletter'); ?>
		<?php $form->widget('ext.tinymce.TinyMce', array(
           'model' => $model, 
           'attribute' => 'newsletter',
            // Optional config
            /*'compressorRoute' => 'tinyMce/compressor',
            'spellcheckerRoute' => 'tinyMce/spellchecker',
            /*'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'admin/elfinder/connector',
            ),*/
            'htmlOptions' => array(
                'rows' => 6,
                'cols' => 60,
            ),
          'settings'=>array(
            'skin' => "o2k7",
            'skin_variant' => "silver",
            'theme_advanced_buttons1' => "fullscreen,code,preview,|,undo,redo,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,outdent,indent,blockquote,|,forecolor,backcolor,styleprops",
            'theme_advanced_buttons2' => "formatselect,fontselect,fontsizeselect,|,link,unlink,image,media,charmap,insertdate,inserttime,|,table,hr,",
            'theme_advanced_buttons3' => "",
            'theme_advanced_buttons4' => "",
          ),
        )); ?>
		<?php //echo $form->error($model,'newsletter'); ?>
	</div>
<br />
  	<div class="row buttons">
		<?php echo CHtml::submitButton('Send mail'); ?>
	</div>

<?php $this->endWidget(); ?>


<?php endif; ?>