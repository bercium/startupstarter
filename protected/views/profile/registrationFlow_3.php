<?php 
  $this->pageTitle = Yii::t('app', 'Thanks! Now show off yourself!');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var skillRemove_url = '<?php echo Yii::app()->createUrl("profile/deleteSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)); ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>



  <ul class="button-group radius left">
    <?php $step = 1; if (isset($_GET['step'])) $step = $_GET['step']; ?>
    <li><a class="button tiny <?php if ($step != 1) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>1)); ?>">1. <?php echo Yii::t('app','Personal'); ?></a></li>
    <li><a class="button tiny <?php if ($step != 2) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>2)); ?>">2. <?php echo Yii::t('app','Skills'); ?></a></li>
    <li><a class="button tiny <?php if ($step != 3) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>3)); ?>">3. <?php echo Yii::t('app','Done'); ?></a></li>
  </ul>

<hr>
<br />


<br />

  <?php echo CHtml::beginForm(Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>4)),'post',array('class'=>"custom",'id'=>'after_register_form')); ?>
  
  <p>

  <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

  <?php echo CHtml::activeLabelEx($match,'available'); ?>
  <span class="description"><?php echo Yii::t('msg','Select how much time you have to work on projects.'); ?></span>
    
  <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllTranslated(),"id","name"), array('empty' => '&nbsp;','style'=>'display:none')); ?>

    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on projects.'); ?>
    </span>
  <?php foreach ($data['user']['collabpref'] as $colabpref){ ?>
    <label for="CollabPref_<?php echo $colabpref['collab_id']; ?>">
     <?php echo CHtml::checkBox('CollabPref['.$colabpref['collab_id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
     <?php echo $colabpref['name'] ?></label>
    <span class="description">
       <?php 
       switch ($colabpref['collab_id']){
         case 1:echo Yii::t('msg','Get paid for your work'); break;
         case 2:echo Yii::t('msg','Are prepared to work for a share in a company'); break;
         case 3:echo Yii::t('msg','Will work and invest equally'); break;
         case 4:echo Yii::t('msg','Want to invest in interesting projects only'); break;
         case 5:echo Yii::t('msg','Just want to help'); break;
       }
        ?>
    </span>
  
     <?php
  }

  ?><br />
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

      <?php if (!$user->surname){ ?>
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>
      <?php } ?>
        
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($match,'city'); ?>
      <?php echo CHtml::activeTextField($match, 'city', array("class"=>"city")); ?>

      <?php // echo CHtml::activeLabelEx($user,'address'); ?>
      <?php // echo CHtml::activeTextField($user, 'address', array('maxlength' => 128)); ?>

      <?php echo CHtml::activeLabelEx($user,'bio'); ?>
      <span class="description"><?php echo Yii::t('msg','Tell people something interesting about yourself.'); ?></span>
      
      <?php echo CHtml::activeTextArea($user, 'bio', array()); ?>

    </div>
    
   </div>
<?php echo CHtml::endForm(); ?>		
    
    
      <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'SkillForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              'class'=>'custom large-8',
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addSkill('".Yii::app()->createUrl("profile/addSkill")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>

    <p>
    <?php echo Yii::t('msg','We know you have some awesome skills so why not show them to the others. Add all the things you are really good at and do not limit yourself by writing only formal education or job specific subjects.'); ?>
    </p>
    <label><?php echo Yii::t('app','Where do you see yourself'); ?></label>
    <a onclick="selectIndustry(25);" class="button radius small secondary"><?php echo Yii::t('app','Programming'); ?></a>
    <a onclick="selectIndustry(33);" class="button radius small secondary"><?php echo Yii::t('app','Designing'); ?></a>
    <a onclick="selectIndustry(83);" class="button radius small secondary"><?php echo Yii::t('app','Marketing'); ?></a>
    <a onclick="$('#customSkills').show();" class="button radius small secondary"><?php echo Yii::t('app','Other'); ?></a>
    
    
    <div id="customSkills" class="hide">
      <?php echo CHtml::label(Yii::t('app','Industry'),''); ?>
      <span class="description"><?php echo Yii::t('msg','Choose an industry.'); ?></span>
      <?php echo CHtml::dropDownList('industry', '', CHtml::listData(Industry::model()->findAll(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none', 'class'=>'industry')); ?>

      
      <?php echo '<label for="skill">'.Yii::t('app','What are you good at');  ?> 
      <?php echo '</label>'; ?>

      <span class="description"><?php echo Yii::t('msg','Tell others what you are good at in the selected industry. Add one skill at a time.') ?></span>
      <?php echo CHtml::textField("skill","", array('maxlength' => 128,'class'=>'skill')); ?>
      <span class="description"><strong><?php echo Yii::t('msg','Switch industry to diversity your skillset') ?></strong></span>

      <?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                      array('class'=>"button small  radius",
                          'onclick'=>'addSkill(\''.Yii::app()->createUrl("profile/addSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)).'\');')
                  ); ?>
      
      
  
      <div class="skillList">
        <?php if(isset($data['user']['skill'])){
                foreach ($data['user']['skill'] as $skill){
                  ?>

          <span data-alert class="label radius secondary profile-skills" id="skill_<?php echo $skill['id']; ?>">
              
              <a href="#" class="close right" onclick="removeSkill(<?php echo $skill['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteSkill"); ?>')">&times;</a>
              <?php echo $skill['skill']."<small class='skill-industry'>".$skill['skill']."</small>"; ?>
         </span>
        <?php }} ?>    
      </div> 
      
    </div>
    
    <?php $this->endWidget(); ?>     

    

    <?php echo CHtml::button(Yii::t("app","Finish"),
      array('class'=>"button success radius right",'onclick'=>"$('#after_register_form').submit();")
      ); ?>