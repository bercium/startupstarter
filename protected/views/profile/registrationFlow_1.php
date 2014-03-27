<?php 
  $this->pageTitle = Yii::t('app', 'Your personal information');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var skillRemove_url = '<?php echo Yii::app()->createUrl("profile/deleteSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)); ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>


<?php 
  if ($perc < PROFILE_COMPLETENESS_MIN) $percClass = 'alert';
  else if ($perc < PROFILE_COMPLETENESS_OK) $percClass = '';
  else $percClass = 'success';
?>
<div class="right mb10" style="width:100px;" data-tooltip title="<?php echo Yii::t('app','Completed {perc}%',array('{perc}'=>$perc)); ?>">
  <div class="progress <?php echo $percClass; ?> round" style="height:10px;">
    <span class="meter" style="width:<?php echo $perc; ?>%;">
    </span>
  </div>
</div>

<br />

<p class="meta f-small">

  <?php echo Yii::t('msg','We are really happy you have decided to join our community. '
          . 'We strive to offer high quality profiles and project. '
          . 'This is why we decide on per person basis if we approve your registration or not.'); ?>
  
  <br /><br />
  <strong>
    <?php echo Yii::t('msg','Thoroughly fill your profile to expedite your approval.'); ?>
  </strong>
    <hr>
</p>


  <?php echo CHtml::beginForm(Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>2)),'post',array('class'=>"custom",'id'=>'after_register_form')); ?>
  
  
  <div class="row">
      <div class="large-4 small-10 right columns mr30 mt15">
      <?php 
       //echo Yii::app()->getBaseUrl(true)."/".Yii::app()->params['tempFolder'];
         //echo "<img class='avatar' src='".avatar_image($user->avatar_link, $user->id)."'>";

           $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
              'id'=>'image',
              'config'=>array(
                 'action'=>Yii::app()->createUrl('/profile/upload'),
                 'allowedExtensions'=>array("jpg", "jpeg", "png"),
                 'template'=> '<div class="qq-uploader">' .
                     '<div class="qq-upload-drop-area avatar-drop-area"><span>'.Yii::t('msg','Drop file here to change your profile picture.').'</span></div>' .
                     '<div class="qq-upload-button">
                       <div class="avatar-loading"><span class="qq-upload-spinner"></span></div>
                       <img class="avatar" src="'.avatar_image($user->avatar_link, $user->id, false).'" >
                      <div class="button secondary radius small avatar-change">'.Yii::t('app','Change image').' <span class="icon-upload"></span></div> 
                      <span class="icon-info-sign" style="color: inherit"></span><span class="description">'.Yii::t('msg','To change your picture, drag a new image on the top or click on the button').'</span>
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
                    'typeError'=>Yii::t('msg',"{file} has invalid extension. Only {extensions} are allowed."),
                    'sizeError'=>Yii::t('msg',"{file} is too large, maximum file size is {sizeLimit}."),
                    'emptyError'=>Yii::t('msg',"{file} is empty, please select files again without it."),
                    'onLeave'=>Yii::t('msg',"The files are being uploaded, if you leave now the upload will be cancelled."),
                 ),
              )
         )); 

       ?>
      <?php echo CHtml::activeHiddenField($user,'avatar_link'); ?>
      </div>
      <div class="large-7 left columns">
        <br />
      <?php //if (!$user->surname){ ?>
      <?php echo CHtml::activeLabelEx($user,'name'); ?>
      <?php echo CHtml::activeTextField($user,"name", array('maxlength' => 128)); ?>
      <?php //} ?>
        <br />
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>        
        <br />
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>
        <br /><br />
      <?php echo CHtml::activeLabelEx($match,'city'); ?>
      <?php echo CHtml::activeTextField($match, 'city', array("class"=>"city")); ?>

      <?php // echo CHtml::activeLabelEx($user,'address'); ?>
      <?php // echo CHtml::activeTextField($user, 'address', array('maxlength' => 128)); ?>

    </div>
    
   </div>
<?php echo CHtml::endForm(); ?>		
    
<a class="button success radius right" trk="registration_save_step1" onclick="$('#after_register_form').submit();" ><?php echo Yii::t("app","Next");?><span class="icon-angle-right f-medium ml10"></span></a>
    

