 <?php if(Yii::app()->user->hasFlash('projectMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('projectMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    

   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>


    <?php echo CHtml::errorSummary($idea,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    <?php echo CHtml::errorSummary($translation,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

    <?php echo CHtml::activeLabelEx($translation,'language_id'); ?>
    <span class="description">
      <?php echo Yii::t('msg','Choose the language you want to write your idea in. Later you can add more translations for the same idea'); ?>
    </span>

    <?php
    $lang = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );
    $lang = $lang->id;
    ?>

    <?php echo CHtml::activedropDownList($translation, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(array("id","native_name"), true, array('order' => 'FIELD(id, '.$lang.', 40) DESC')),"id","native_name"), array('style'=>'display:none')); ?>

    <?php echo CHtml::activeLabelEx($translation,'title'); ?>
    <span class="description">
      <?php echo Yii::t('msg','What are you calling it? One or two words please, you can always change it later.'); ?>
    </span>
    <?php echo CHtml::activeTextField($translation,"title", array('maxlength' => 128)); ?>

    <?php echo CHtml::activeLabelEx($translation,'pitch'); ?>
    <span class="description">
        <?php echo Yii::t('msg','This is your pitch. Be short and to the point.'); ?>
    </span>
    <?php echo CHtml::activeTextArea($translation,"pitch"); ?>

<br />
    <?php echo CHtml::activeLabelEx($idea,'status_id'); ?>
     <span class="description">
      <?php echo Yii::t('msg','Status of project.'); ?>
     </span>
    <?php echo CHtml::activedropDownList($idea, 'status_id', GxHtml::listData(IdeaStatus::model()->findAllTranslated(),'id','name'), array('empty' => '&nbsp;', 'style' => 'display: none;')); ?>



    <?php echo CHtml::activeLabelEx($translation,'description'); ?>
    
     <span class="description">
       <?php echo Yii::t('msg','Describe your project in detail.'); ?>
     </span>
    <?php echo CHtml::activeTextArea($translation,"description",array('class'=>'lin-edit')); ?> 
     <br />
    <?php echo CHtml::activeLabelEx($translation,'description_public'); ?>
    <div class="switch small round" style="text-align: center; width:120px;">
      <input id="description_public_0" name="IdeaTranslation[description_public]" type="radio" value="0" <?php if (!$translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_0" onclick=""><?php echo Yii::t('app','Off'); ?></label>

      <input id="description_public_1" name="IdeaTranslation[description_public]" type="radio" value="1" <?php if ($translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_1" onclick=""><?php echo Yii::t('app','On'); ?></label>
      <span></span>
   </div>
     
  <div class="lin-trigger panel">
    <?php echo CHtml::activeLabelEx($translation,'keywords'); ?>
    <div class="lin-hidden">
     <span class="description">
      <?php echo Yii::t('msg','Describe your project with comma separated keywords to increase visibility of your project.'); ?>
     </span>
    <?php echo CHtml::activeTextArea($translation,"keywords",array('class'=>'lin-edit')); ?>
    </div>
  </div>
     
  <div class="lin-trigger panel">
    <?php echo CHtml::activeLabelEx($translation,'tweetpitch'); ?>
    <div class="lin-hidden">
     <span class="description">
      <?php echo Yii::t('msg','Describe your project with 120 characters or less for sharing on social networks.'); ?>
     </span>
    <?php echo CHtml::activeTextArea($translation,"tweetpitch", array('class'=>'lin-edit','maxlength' => 120,"onkeydown"=>'countTweetChars()',"onkeyup"=>'countTweetChars()',"onchange"=>'countTweetChars()')); ?>
    <div class="meta" id="tweetCount"><?php echo (120-strlen($translation->tweetpitch)) ?></div>
    <br /><br />
     <span class="description">
      <?php echo Yii::t('msg','At the end we will append link to your project like this <strong>{url}</strong>',array('{url}'=>short_url_google(Yii::app()->createAbsoluteUrl("project/view",array("id"=>0))) )); ?>
     </span>
    </div>
  </div>      

  <div class="lin-trigger panel">
    <?php echo CHtml::activeLabelEx($idea,'website'); ?>
    <div class="lin-hidden">
    <?php echo CHtml::activeTextField($idea,"website", array('maxlength' => 128,'class'=>'lin-edit')); ?> 
    </div>
  </div>

  <div class="lin-trigger panel">
    <?php echo CHtml::activeLabelEx($idea,'video_link'); ?>
    <div class="lin-hidden">
     <span class="description">
      <?php echo Yii::t('msg','Link to video presentation of project.'); ?>
     </span>
    <?php echo CHtml::activeTextField($idea,"video_link", array('maxlength' => 128,'class'=>'lin-edit')); ?> 
    </div>
  </div>
    
    
<hr>
    <?php echo CHtml::submitButton(Yii::t("app","Next >>"),
          array('class'=>"button small success radius right")
      ); ?>
    <?php echo CHtml::endForm(); ?>  

    <?php
      $this->renderPartial('_addlink', array(
          'link' => $link,
          'links' => $links,
          'idea_id' => $idea_id ));
    ?>