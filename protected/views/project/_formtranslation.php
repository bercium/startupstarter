 <?php if(Yii::app()->user->hasFlash('personalMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('personalMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    

   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>

    <?php echo CHtml::errorSummary($translation,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

    <?php echo CHtml::activeLabelEx($translation,'language_id'); ?>
    <span class="description">
      <?php echo Yii::t('msg','Choose the language you want to write your idea in. Later you can add more translations for the same idea'); ?>
    </span>
    <?php echo CHtml::activedropDownList($translation, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(array("id","native_name"), true),"id","native_name"), array('empty' => '&nbsp;','style'=>'display:none')); ?>

    <?php echo CHtml::activeLabelEx($translation,'title'); ?>
    <span class="description">
      <?php echo Yii::t('msg','What are you calling it? One or two words please, you can always change it later.'); ?>
    </span>
    <?php echo CHtml::activeTextField($translation,"title", array('maxlength' => 128)); ?>

    <?php echo CHtml::activeLabelEx($translation,'keywords'); ?>
     <span class="description">
      <?php echo Yii::t('msg','Describe your project with comma separated keywords to increase visibility of your project.'); ?>
     </span>
    <?php echo CHtml::activeTextArea($translation,"keywords"); ?>

    <?php echo CHtml::activeLabelEx($translation,'pitch'); ?>
    <span class="description">
        <?php echo Yii::t('msg','This is your pitch. Be short and to the point.'); ?>
    </span>
    <?php echo CHtml::activeTextArea($translation,"pitch"); ?>

     <br /><br />

  <div class="showhide panel">
    <?php echo CHtml::activeLabelEx($translation,'description'); ?>
     <p>This is your pitch. Be short. Some more info on this subject.<span data-tooltip title="Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. "<i  style="float:right" class="icon-question-sign"></i></span></p>
    <?php echo CHtml::activeTextArea($translation,"description"); ?> 
    <?php echo CHtml::activeLabelEx($translation,'description_public'); ?>
    <div class="switch small round small-3" style="text-align: center;">
      <input id="description_public_0" name="IdeaTranslation[description_public]" type="radio" value="0" <?php if (!$translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_0" onclick=""><?php echo Yii::t('app','Off'); ?></label>

      <input id="description_public_1" name="IdeaTranslation[description_public]" type="radio" value="1" <?php if ($translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_1" onclick=""><?php echo Yii::t('app','On'); ?></label>
      <span></span>
    </div>

  </div>      
    
<hr>
    <?php echo CHtml::submitButton(Yii::t("app","Save"),
          array('class'=>"button small success radius right")
      ); ?>
    <?php echo CHtml::endForm(); ?>  
