 <?php // ckeditor files
 $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();

    
    //$cs->registerScriptFile($baseUrl.'/js/ckeditor/ckeditor.js',CClientScript::POS_HEAD);

    ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>

   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>


    <?php echo CHtml::errorSummary($idea,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    <?php echo CHtml::errorSummary($translation,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

    <?php echo CHtml::activeLabelEx($translation,'title'); ?>
    <span class="description">
      <?php echo Yii::t('msg','What do you call it? Write one or two words, please. You can always change it later.'); ?>
    </span>
    <?php echo CHtml::activeTextField($translation,"title", array('maxlength' => 128)); ?>

    <?php echo CHtml::activeLabelEx($translation,'pitch'); ?>
    <span class="description">
        <?php echo Yii::t('msg','This is your pitch. Be brief and to the point.'); ?>
    </span>
    <?php echo CHtml::activeTextArea($translation,"pitch"); ?>

<br />
    <?php echo CHtml::activeLabelEx($idea,'status_id'); ?>
     <span class="description">
      <?php echo Yii::t('msg','Status of the project.'); ?>
     </span>
    <?php echo CHtml::activedropDownList($idea, 'status_id', GxHtml::listData(IdeaStatus::model()->findAllTranslated(),'id','name'), array('empty' => '&nbsp;', 'style' => 'display: none;')); ?>



    <?php echo CHtml::activeLabelEx($translation,'description'); ?>
    
     <span class="description">
       <?php echo Yii::t('msg','Describe your project in detail.'); ?>
     </span>
    <?php echo CHtml::activeTextArea($translation,"description",array('class'=>'lin-edit ckeditor')); ?> 

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
      <?php echo Yii::t('msg','At the end we will append this link to your project <a href="{url}" target="_blank">{url}</a>',array('{url}'=>short_url_google(Yii::app()->createAbsoluteUrl("project/view",array("id"=>$id))) )); ?>
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
      <?php echo Yii::t('msg','Link of the project\'s video presentation.'); ?>
     </span>
    <?php echo CHtml::activeTextField($idea,"video_link", array('maxlength' => 128,'class'=>'lin-edit')); ?> 
    </div>
  </div>

      <?php /* ?>
      <div class="large-4 small-4 columns">
      <?php 
       //echo Yii::app()->getBaseUrl(true)."/".Yii::app()->params['tempFolder'];
         //echo "<img class='avatar' src='".avatar_image($user->avatar_link, $user->id)."'>";
           $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
              'id'=>'image',
              'config'=>array(
                 'action'=>Yii::app()->createUrl('/project/upload'),
                 'allowedExtensions'=>array("jpg", "jpeg", "png"),
                 'template'=> '<div class="qq-uploader">' .
                     '<div class="qq-upload-drop-area avatar-drop-area"><span>'.Yii::t('msg','Drop file here to upload a new cover image.').'</span></div>' .
                     '<div class="qq-upload-button">
                       <div class="avatar-loading"><span class="qq-upload-spinner"></span></div>
                       <img class="avatar" src="'.idea_image($ideagallery, $idea->id, false).'" >
                      <div class=" button disabled secondary radius small avatar-change">'.Yii::t('app','Add cover image').' <span class="icon-upload"></div> 
                      </div>' .
                     '<div class="qq-upload-list" style="display:none"></div>' .
                  '</div>',
                 'sizeLimit'=>4*1024*1024,// maximum file size in bytes
                 'onSubmit'=>"js:function(file, extension) { 
                                $('avatar-loading').show();
                              }",
                 'onComplete'=>"js:function(file, response, responseJSON) {
                                  $('.avatar').load(function(){
                                    $('avatar-loading').hide();
                                    $('.avatar').unbind();
                                    $('#IdeaImage_avatar_link').val(responseJSON['filename']);
                                  });
                                  $('.avatar').attr('src', '".Yii::app()->baseUrl."/".Yii::app()->params['tempFolder']."'+responseJSON['filename']);
                                }",
                 'messages'=>array(
                    'typeError'=>Yii::t('msg',"{file} has invalid extension. Only {extensions} are allowed."),
                    'sizeError'=>Yii::t('msg',"{file} is too large, maximum file size is {sizeLimit}."),
                    'emptyError'=>Yii::t('msg',"{file} is empty, please select files again without it."),
                    'onLeave'=>Yii::t('msg',"The files are being uploaded, if you leave now the upload will be cancelled."),
                 ),
              )
         )); 

       ?>
      <input name="IdeaGallery[url]" id="IdeaImage_avatar_link" type="hidden" value="<?php echo $ideagallery;?>" />
      </div>
      <?php */ ?>
    
<hr>
    <?php echo CHtml::submitButton(Yii::t("app","Save"),
          array('class'=>"button small success radius")
      ); ?>
    <?php echo CHtml::endForm(); ?>  
