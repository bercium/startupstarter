<?php 
  $this->pageTitle = Yii::t('app', 'Registration finished');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var skillRemove_url = '<?php echo Yii::app()->createUrl("profile/deleteSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)); ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>

    <?php if(Yii::app()->user->hasFlash('profileMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>

<p>
<?php echo Yii::t('msg','Thank you for your registration. You will shortly receive our confirmation email.'); ?>
<br /><br />
<strong>
<?php echo Yii::t('msg','While you wait for our confirmation email fill in some of your profile information.'); ?>
</strong>
</p>
<br />


  <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6",'id'=>'after_register_form')); ?>
  <p>

  <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

  <?php echo CHtml::activeLabelEx($match,'available'); ?>
  <span class="description"><?php echo Yii::t('msg','Select how much time you have to work on projects.'); ?></span>
    
  <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on a project. Paid work - get paid for your work, Sweat equity - will work for a share in company, Equal investors - prepared to invest equal share of money, Sole investor - want to invest only, Volunteer - just want to help'); ?>
    </span>
  <?php foreach ($data['user']['collabpref'] as $colabpref){ ?>
    <label for="CollabPref_<?php echo $colabpref['collab_id']; ?>">
      <?php echo CHtml::checkBox('CollabPref['.$colabpref['collab_id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
     <?php echo $colabpref['name'] ?></label>
     <?php
  }

  ?>
  </p>
  
  
  
  
  <div class="row">
      <div class="large-4 right columns">
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
                     '<div class="qq-upload-button avatar-button">
                       <div class="avatar-loading"><span class="qq-upload-spinner"></span></div>
                       <img class="avatar" src="'.avatar_image($user->avatar_link, $user->id, false).'" >
                       <div class="avatar-change">'.Yii::t('app','Change image').' <span class="general foundicon-photo"></div>
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

      <?php if (!$user->surname){ ?>
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>
      <?php } ?>
        
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($match,'city'); ?>
      <?php echo CHtml::activeTextField($match, 'city', array("class"=>"city")); ?>

      <?php echo CHtml::activeLabelEx($user,'address'); ?>
      <?php echo CHtml::activetextField($user, 'address', array('maxlength' => 128)); ?>

    
    </div>
      </div>
      

<?php echo CHtml::endForm(); ?>		
    
    
          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'SkillForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              'class'=>'custom large-6',
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addSkill('".Yii::app()->createUrl("profile/addSkill")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>
    
   
    <?php echo '<label for="skill">'.Yii::t('app','Skill');  ?> 
    <?php echo '</label>'; ?>

    <span class="description"><?php echo Yii::t('msg','Name of skill you posess. You can write multiple skills for the same industry separated by commas.') ?></span>
    <?php echo CHtml::textField("skill","", array('maxlength' => 128,'class'=>'skill')); ?>
  
 
    <?php echo CHtml::label(Yii::t('app','Industry'),''); ?>
    <span class="description"><?php echo Yii::t('msg','Select group which represents your skill the closest.'); ?></span>
    <?php echo CHtml::dropDownList('skillset', '', CHtml::listData(Skillset::model()->findAll(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none', 'class'=>'skillset')); ?>
  
    <?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addSkill(\''.Yii::app()->createUrl("profile/addSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)).'\');')
                ); ?>
      
  
    <div class="skillList">
    
    <?php if(isset($data['user']['skillset'])){
          foreach ($data['user']['skillset'] as $skillset){
            foreach ($skillset['skill'] as $skill){
              ?>

      <span data-alert class="label alert-box radius secondary profile-skils" id="skill_<?php echo $skill['id']; ?>">
          <?php echo $skill['skill']."<br /><small class='meta'>".$skillset['skillset']."</small>"; ?>
          <a href="#" class="close" onclick="removeSkill(<?php echo $skill['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteSkill"); ?>')">&times;</a>
     </span>
    <?php }}} ?>    
    

    </div>  
    
    <?php $this->endWidget(); ?>     

    
    <hr>
    
        <?php echo CHtml::button(Yii::t("app","Save"),
          array('class'=>"button small success radius",'onclick'=>"$('#after_register_form').submit();")
      ); ?>
