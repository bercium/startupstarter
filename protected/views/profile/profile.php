<?php
  $this->pageTitle = Yii::t('app','Profile');
?>


<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>

 

<?php echo CHtml::beginForm('','post',array('class'=>"custom",'id'=>'profile_save_form')); ?>

<div class="">
  <div class="columns edit-header">
    <a id="link_personal" class="anchor-link"></a>
    <h3><?php echo Yii::t('app', 'Personal information'); ?></h3>
    <a class="button radius small  right secondary" href="person/<?php echo $user['id']; ?>" target="_blank"><?php echo Yii::t('app',"Preview"); ?> </a>    
  </div>
  <div class="columns panel edit-content">
    
     

      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
      <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <div class="">
     
      
     <div class="large-4 small-6 push-7 right columns small-centered large-uncentered">
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
                      <span class="icon-info-sign" style="color: inherit"></span><span class="description">'.Yii::t('app','To change drag new image on top or click this button').'</span>
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
      
      <div class="large-7 pull-4 left columns">

      <?php echo CHtml::activeLabelEx($user,'name'); ?>
      <?php echo CHtml::activeTextField($user,"name", array('maxlength' => 128)); ?>
      
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>
      
         
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($match,'city'); ?>
      <?php echo CHtml::activeTextField($match, 'city', array("class"=>"city")); ?>

      <?php echo CHtml::activeLabelEx($user,'address'); ?>
      <?php echo CHtml::activeTextField($user, 'address', array('maxlength' => 128)); ?>


    </div>      
           
    
      <div class="columns">
        <?php echo CHtml::activeLabelEx($user,'bio'); ?>
        <span class="description"><?php echo Yii::t('msg','Tell people something interesting about yourself.'); ?></span>
        
        <?php echo CHtml::activeTextArea($user, 'bio', array()); ?>
        <br />

        <?php /* echo CHtml::submitButton(Yii::t("app","Save"),
              array('class'=>"button small success radius")
          );*/ ?>
        <?php //echo CHtml::endForm(); ?>
      </div>
   </div>
      
      
		
      
  </div><!-- edit-content end -->

</div>
 
<div class="">
  <div class="columns edit-header">   
    <h3><?php echo Yii::t('app', 'Profile details'); ?></h3>
    
  </div>
  <div class="columns panel edit-content">

    <!-- moved alert-box success to \protected\views\layouts\edit.php -->
    
    <?php // echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>
    <p>
			
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabel($match,'available'); ?>
    <span class="description">
      <?php /* ?><span style="float:left; margin-right:2px; color:#89B561;" class="icon-question-sign"></span><?php */ ?>
       <?php echo Yii::t('msg','Select how much time you have to work on projects.'); ?>
    </span>

    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllTranslated(),"id","name"), array('empty' => '&nbsp;','style'=>'display:none')); ?>
    
    
    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on a project.'); ?>
    </span>
    
		<?php foreach ($data['user']['collabpref'] as $colabpref){ ?>
			<label for="CollabPref_<?php echo $colabpref['collab_id']; ?>">
        <?php echo CHtml::checkBox('CollabPref['.$colabpref['collab_id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
       <?php echo $colabpref['name'] ?></label>
      
    <span class="description">
       <?php 
       switch ($colabpref['collab_id']){
         case 1:echo Yii::t('msg','Get paid for your work'); break;
         case 2:echo Yii::t('msg','Are prepered to work for a share in company'); break;
         case 3:echo Yii::t('msg','Will work and invest equaly'); break;
         case 4:echo Yii::t('msg','Want to invest in interesting projects only'); break;
         case 5:echo Yii::t('msg','Just want to help'); break;
       }
        ?>
    </span>      
 			 <?php
		}

		?>

    <?php /* extra data ?>
    <?php echo Yii::t('app','Extra information'); ?>
		<span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add some extra information like what you can offer..."); ?>"></span>
		
    <?php echo CHtml::textArea("extraInformation"); ?>
    <?php //*/ ?> 
          
		</p>
		
      <?php /*echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        );*/ ?>

  </div>
</div>
	<?php echo CHtml::endForm(); ?>



<div class="">
  <div class="columns edit-header">
    <a id="link_skill" class="anchor-link"></a>
    
    

    <h3 id="sec2"><?php echo Yii::t('app', 'My skills'); ?></h3>
    
      <a class="button secondary radius small right" href="#" onclick="$('.addSkils').toggle(); return false;"><?php echo Yii::t('app',"Add skills"); ?> 
        <span class="icon-plus"></span>
      </a>
    

  </div>
  <div class="columns panel edit-content add-skills">

    
    <div class="addSkils" style="display:none">
          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'SkillForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              //'class'=>'customs',
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addSkill('".Yii::app()->createUrl("profile/addSkill")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>
      
      <label><?php echo Yii::t('app','Some examples'); ?></label>
      <a onclick="selectIndustry(25);" class="button radius small secondary"><?php echo Yii::t('app','Programming'); ?></a>
      <a onclick="selectIndustry(83);" class="button radius small secondary"><?php echo Yii::t('app','Design'); ?></a>
      <a onclick="selectIndustry(33);" class="button radius small secondary"><?php echo Yii::t('app','Marketing'); ?></a>

      <?php echo CHtml::label(Yii::t('app','Industry'),''); ?>
      <span class="description"><?php echo Yii::t('msg','Chose a group that best represents skills you are about to add.'); ?></span>
      <?php echo CHtml::dropDownList('skillset', '', CHtml::listData(Skillset::model()->findAll(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none', 'class'=>'skillset')); ?>

      
      <?php echo '<label for="skill">'.Yii::t('app','What are you good at');  ?> 
      <?php echo '</label>'; ?>

      <span class="description"><?php echo Yii::t('msg','Tell others what are you good at in selected industry. Add one skill at a time.') ?></span>
      <?php echo CHtml::textField("skill","", array('maxlength' => 128,'class'=>'skill')); ?>
      <span class="description"><strong><?php echo Yii::t('msg','Switch industry to diversity your skillset') ?></strong></span>

      <?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                      array('class'=>"button small success radius",
                          'onclick'=>'addSkill(\''.Yii::app()->createUrl("profile/addSkill").'\');')
                  ); ?>
      
    
    <?php $this->endWidget(); ?>  
    <hr>
    </div>
  
    
  
      <div class="skillList">
        <?php if(isset($data['user']['skillset'])){
              foreach ($data['user']['skillset'] as $skillset){
                foreach ($skillset['skill'] as $skill){
                  ?>

          <span data-alert class="label radius secondary profile-skils" id="skill_<?php echo $skill['id']; ?>">
              
              <a href="#" class="close right" onclick="removeSkill(<?php echo $skill['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteSkill"); ?>')">&times;</a>
              <?php echo $skill['skill']."<small class='skill-industry'>".$skillset['skillset']."</small>"; ?>
         </span>
        <?php }}} ?>    
      </div> 


    
  </div>
</div>








<div>

  <div class="edit-header columns"><h3><?php echo Yii::t('app',"My links"); ?></h3>

   <?php /* ?><a href="#" onclick="$('.addLinks').toggle(); return false;"><?php echo Yii::t('app',"My custom links"); ?> +</a> <?php */ ?>
      <a class="button radius secondary small" href="#" onclick="$('.addLinks').toggle(); return false;"><?php echo Yii::t('app',"Add links"); ?> <span class="icon-link"></span></a>


  </div>
  <div class="edit-content columns">      
          
     
      <div class="addLinks" style="display:none">

          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'LinkForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addLink('".Yii::app()->createUrl("profile/addLink")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>


              <?php echo $form->errorSummary($link); ?>

              <?php echo $form->labelEx($link,'title'); ?>
              <span class="description">
                 <?php echo Yii::t('msg','Chose a name to represent your link.'); ?>
              </span>
              <?php echo $form->textField($link,'title'); ?>

              <?php echo $form->labelEx($link,'url'); ?>
              <?php echo $form->textField($link,'url'); ?>

              <?php echo CHtml::submitButton(Yii::t("app","Add link"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addLink(\''.Yii::app()->createUrl("profile/addLink").'\');')
                ); ?>

          <?php $this->endWidget(); ?>        
        
      </div>
      
      <ul class="linkList">
        <?php foreach ($data['user']['link'] as $link){ ?>
        <li><div data-alert class="label radius secondary" id="link_div_<?php echo $link['id']; ?>">
          <img src="<?php echo getLinkIcon($link['url']); ?>">
          <?php echo $link['title']; ?>: <a href="<?php echo add_http($link['url']); ?>" target="_blank"><?php echo $link['url']; ?></a>
          <a href="#" class="close" onclick="removeLink(<?php echo $link['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteLink"); ?>')">&times;</a>
        </div></li>
        <?php } ?>
      </ul>


  </div>
  
</div>


    <?php echo CHtml::button(Yii::t("app","Save my profile"),
      array('class'=>"button small success radius",'onclick'=>"$('#profile_save_form').submit();")
      ); ?>
<br /><br />
<?php 
	Yii::log(arrayLog($data['user']), CLogger::LEVEL_INFO, 'custom.info.user'); 
