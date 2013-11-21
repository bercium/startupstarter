<?php
	$this->pageTitle = Yii::t('app','Newsletter');
?>

    
      <?php echo CHtml::beginForm('','post',array('class'=>"custom")); ?>

      <?php echo CHtml::errorSummary($model,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
      
      <a onclick="$('#showNewsletterEmails').show();"><?php echo Yii::t('app','Custom emails'); ?></a><br /><br />
      <div style="display:none" id="showNewsletterEmails">
      <?php echo CHtml::activeLabelEx($model,'newsletterEmails'); ?>
      <span class="description">
        <?php echo Yii::t('msg','Separate emails with commas'); ?>
      </span>        
      <?php echo CHtml::activeTextField($model,'newsletterEmails'); ?>
      </div>
        
      <?php echo CHtml::activeLabelEx($model,'newsletterTitle'); ?>
      <?php echo CHtml::activeTextField($model,'newsletterTitle'); ?>

      <?php echo CHtml::activeLabelEx($model,'newsletter'); ?>
      <?php $this->widget('ext.tinymce.TinyMce', array(
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
    
      <br />
    
      <?php echo CHtml::submitButton(Yii::t("app","Send newsletter"),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("app","Are you sure?") )
              ); ?>

    <?php echo CHtml::endForm(); ?>
  