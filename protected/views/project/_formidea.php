 <?php if(Yii::app()->user->hasFlash('personalMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('personalMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    

   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>

    <?php echo CHtml::errorSummary($idea,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    <?php echo CHtml::errorSummary($translation,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

    <?php echo CHtml::activeLabelEx($translation,'title'); ?>
    <p>What are you calling it? One or two words please, you can always change it later.<span data-tooltip title="Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. "<i  style="float:right" class="icon-question-sign"></i></span></p>
    <?php echo CHtml::activeTextField($translation,"title", array('maxlength' => 128)); ?>


    <?php echo CHtml::activeLabelEx($translation,'language_id'); ?>
    <p>Choose your language that you want to write your idea in.<span data-tooltip title="Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. "<i  style="float:right" class="icon-question-sign"></i></span></p>
    <?php echo CHtml::activedropDownList($translation, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(array("id","native_name"), true),"id","native_name"), array('empty' => '&nbsp;')); ?>

    <?php echo CHtml::activeLabelEx($translation,'pitch'); ?>
    <p>This is your pitch. Be short.<span data-tooltip title="Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. "<i  style="float:right" class="icon-question-sign"></i></span></p>
    <?php echo CHtml::activeTextArea($translation,"pitch"); ?>

    <?php echo CHtml::activeLabelEx($translation,'description'); ?>
     <p>This is your pitch. Be short.<span data-tooltip title="Lorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. "<i  style="float:right" class="icon-question-sign"></i></span></p>
    <?php echo CHtml::activeTextArea($translation,"description"); ?>
    <br />
    
    <?php echo CHtml::activeLabelEx($translation,'description_public'); ?>
    <div class="switch small round small-2">
      <input id="description_public_0" name="IdeaTranslation[description_public]" type="radio" value="0" <?php if (!$translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_0" onclick="">Off</label>

      <input id="description_public_1" name="IdeaTranslation[description_public]" type="radio" value="1" <?php if ($translation->description_public) echo 'checked="checked"' ?>>
      <label for="description_public_1" onclick="">On</label>
      <span></span>
    </div>

    <?php echo CHtml::activeLabelEx($translation,'tweetpitch'); ?>
    <?php echo CHtml::activeTextArea($translation,"tweetpitch", array('maxlength' => 140,"onkeydown"=>'countTweetChars()',"onkeyup"=>'countTweetChars()',"onchange"=>'countTweetChars()')); ?>
    <div class="meta" id="tweetCount" >140</div>
    <br />
    
    <?php echo CHtml::activeLabelEx($idea,'status_id'); ?>
    <?php echo CHtml::activedropDownList($idea, 'status_id', GxHtml::listDataEx(IdeaStatus::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>

    
    <?php echo CHtml::activeLabelEx($idea,'website'); ?>
    <?php echo CHtml::activeTextField($idea,"website", array('maxlength' => 128)); ?>

    <?php echo CHtml::activeLabelEx($idea,'video_link'); ?>
    <?php echo CHtml::activeTextField($idea,"video_link", array('maxlength' => 128)); ?>
    

    <?php echo CHtml::submitButton(Yii::t("app","Save"),
          array('class'=>"button small success radius")
      ); ?>
    <?php echo CHtml::endForm(); ?>  
