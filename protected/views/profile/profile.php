<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Personal information'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    <?php if(Yii::app()->user->hasFlash('personalMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('personalMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    
    
     <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6 small-12")); ?>

      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
      <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <div class="row">
      <div class="small-12 large-3 columns">
      <?php 
       //echo Yii::app()->getBaseUrl(true)."/".Yii::app()->params['tempFolder'];
         //echo "<img class='avatar' src='".avatar_image($user->avatar_link, $user->id)."'>";

           $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
              'id'=>'image',
              'config'=>array(
                 'action'=>Yii::app()->createUrl('/profile/upload'),
                 'allowedExtensions'=>array("jpg", "jpeg", "png"),
                 'template'=> '<div class="qq-uploader">' .
                     '<div class="qq-upload-drop-area avatar-drop-area"><span>'.Yii::t('app','Drop file here to change.').'</span></div>' .
                     '<div class="qq-upload-button avatar-button">
                       <div class="avatar-loading"><span class="qq-upload-spinner"></span></div>
                       <img class="avatar" src="'.avatar_image($user->avatar_link, $user->id, false).'" >
                       <div class="avatar-change">'.Yii::t('app','Change image').'</div>
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
                                    $('#UserEdit_avatar_link').val(responseJSON['filename']);
                                  });
                                  $('.avatar').attr('src', '".Yii::app()->baseUrl."/".Yii::app()->params['tempFolder']."'+responseJSON['filename']);
                                }",
                 'messages'=>array(
                    'typeError'=>Yii::t('app',"{file} has invalid extension. Only {extensions} are allowed."),
                    'sizeError'=>Yii::t('app',"{file} is too large, maximum file size is {sizeLimit}."),
                    'emptyError'=>Yii::t('app',"{file} is empty, please select files again without it."),
                    'onLeave'=>Yii::t('app',"The files are being uploaded, if you leave now the upload will be cancelled."),
                 ),
              )
         )); 

       ?>
      <?php echo CHtml::activeHiddenField($user,'avatar_link'); ?>
      </div>
      <div class="small-12 large-9 columns">

      <?php echo CHtml::activeLabelEx($user,'name'); ?>
      <?php echo CHtml::activeTextField($user,"name", array('maxlength' => 128)); ?>
      
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>
      </div>
      </div>
      

      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>

      <?php echo CHtml::activeLabelEx($match,'city_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>

      <?php echo CHtml::activeLabelEx($user,'address'); ?>
      <?php echo CHtml::activetextField($user, 'address', array('maxlength' => 128)); ?>

    
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>
      <?php echo CHtml::endForm(); ?>
    
      <hr>
      <a href="#" onclick="$('.addLinks').toggle(); return false;"><?php echo Yii::t('app',"My custom links"); ?> +</a>
      <div class="addLinks" style="display:none">

          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'LinkForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>


              <?php echo $form->errorSummary($link); ?>

              <?php echo $form->labelEx($link,'title'); ?>
              <?php echo $form->textField($link,'title'); ?>

              <?php echo $form->labelEx($link,'url'); ?>
              <?php echo $form->textField($link,'url'); ?>

              <?php echo CHtml::submitButton(Yii::t("app","Add"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addLink(\''.Yii::app()->createUrl("profile/addLink").'\');')
                ); ?>

          <?php $this->endWidget(); ?>        
        
      </div>
      <div class="linkList">
        <?php foreach ($data['user']['link'] as $link){ ?>
        <div data-alert class="alert-box radius secondary" id="link_div_<?php echo $link['id']; ?>">
          <?php echo $link['title']; ?>: <a ><?php echo $link['url']; ?></a>
          <a href="#" class="close" onclick="removeLink(<?php echo $link['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteLink"); ?>')">&times;</a>
        </div>
        <?php } ?>
      </div>

      
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Profile detail'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">

    <?php if(Yii::app()->user->hasFlash('profileMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
    <?php echo CHtml::beginForm('','post',array('class'=>"custom  large-6 small-12")); ?>
    
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabelEx($match,'available'); ?>
    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>
    
    
    
    <br /><br /><br /><br /><br /><br /><br />
    
    
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
    'name'=>'city',
    'source'=>'function( request, response ) {
            var term = request.term;

            if ( term in cache ) {
              response( cache[ term ] );
              return;
            }

            lastXhr = $.getJSON( "search.php", request, function( data, status, xhr ) {
              cache[ term ] = data;

              if ( xhr === lastXhr ) {
                response( data );
              }
            });
          }',
    // additional javascript options for the autocomplete plugin
    'options'=>array(
        'minLength'=>'2',
    ),
    'htmlOptions'=>array(
        'style'=>'',
    ),
));
 ?>
 
    
      Colaboration<br />
      Skills<br />
      Extra data<br />

      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>
    <?php echo CHtml::endForm(); ?>
  </div>
</div>

