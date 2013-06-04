<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Profile details'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">

    <?php if(Yii::app()->user->hasFlash('profileMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    <?php if(Yii::app()->user->hasFlash('profileMessageError')){ ?>
    <div data-alert class="alert-box radius alert">
      <?php echo Yii::app()->user->getFlash('profileMessageError'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
    <?php echo CHtml::beginForm('','post',array('class'=>"custom  large-6 small-12")); ?>
    <p>
			
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabelEx($match,'available'); ?>
    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>
    
    <?php 
		echo Yii::t('app','Collaboration preferences');
		foreach ($data['user']['collabpref'] as $colabpref){ ?>
			<label for="CollabPref_<?php echo $colabpref['id']; ?>"><?php echo CHtml::checkBox('CollabPref['.$colabpref['id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
       <?php echo $colabpref['name'] ?></label>
 			 <?php
		}
		
		?>

    <?php /* extra data ?>
    <?php echo Yii::t('app','Extra information'); ?>
		<span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add some extra information like what you can offer..."); ?>"></span>
		
    <?php echo CHtml::textArea("extraInformation"); ?>
    <?php //*/ ?> 
          
		</p>
		
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>

	<?php echo CHtml::endForm(); ?>		
		
		<hr>
		<p>
   <a href="#" onclick="$('.addSkils').toggle(); return false;"><?php echo Yii::t('app',"My skills"); ?> +</a>
    <div class="addSkils" style="display:none">

    
<script>
	var cache = {};
  $(function() {
    $( "#skill" ).autocomplete({
      //minLength: 1,
			delay:300,
      source: function( request, response ) {
        var term = request.term;
        if ( term in cache ) {
          response( cache[ term ] );
          return;
        }
 
        $.getJSON( "<?php echo Yii::app()->createUrl("profile/sugestSkill",array("ajax"=>1)) ?>", request, function( data, status, xhr ) {
					if (data.status == 0){
						cache[ term ] = data.data;
						response( data.data );
					}else alert(data.message);
        });
      },
			//source:projects,
      focus: function( event, ui ) {
        $( "#project" ).val( ui.item.skill );
        return false;
      },
      select: function( event, ui ) {
        $( "#skill" ).val( ui.item.skill );
				$('#skillset').val(ui.item.skillset_id); 
				Foundation.libs.forms.refresh_custom_select($('#skillset'),true);
				
        $( "#project-id" ).val( ui.item.id );
 
        return false;
      }
    })
    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.skill + "<br><small>" + item.skillset + "</small></a>" )
        .appendTo( ul );
    };
  });
  </script>		
	
          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'SkillForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
															'class'=>'custom',
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addSkill('".Yii::app()->createUrl("profile/addSkill")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>
	
		<?php echo '<label for="skill">'.Yii::t('app','Skill');  ?>	
		<span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add as many relevant skills you. Bla bla blaaa"); ?>"></span>
    <?php echo '</label>'; ?>
    <?php echo CHtml::textField("skill","", array('maxlength' => 128)); ?>
	
 
    <?php echo CHtml::label(Yii::t('app','Skill group'),''); ?>
    <?php echo CHtml::dropDownList('skillset', '', CHtml::listData(Skillset::model()->findAll(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none')); ?>
	
		<?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addSkill(\''.Yii::app()->createUrl("profile/addSkill").'\');')
                ); ?>
		
		<?php $this->endWidget(); ?>  
	
		</div>
	
		<div class="skillList">
		<?php foreach ($userSkills as $skill){ ?>
			<span data-alert class="label alert-box radius secondary profile-skils" id="skill_<?php echo $skill->id; ?>">
          <?php echo $skill->skill->name."<br /><small class='meta'>".$skill->skillset->name."</small>"; ?>
          <a href="#" class="close" onclick="removeSkill(<?php echo $skill->id; ?>,'<?php echo Yii::app()->createUrl("profile/deleteSkill"); ?>')">&times;</a>
	   </span>
		<?php } ?>
		</div>
		
	  </p>
		
		<?php
    //!!! remove this and import JUI js and CSS :)
    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'name'=>'city',
				// additional javascript options for the autocomplete plugin
        'htmlOptions'=>array("style"=>'display:none'),
		));
		?>
    
  </div>
</div>

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
    
     <?php echo CHtml::beginForm('','post',array('class'=>"custom large-12 small-12")); ?>

      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
      <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <div class="row">
      <div class="small-12 large-4 right columns">
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
      <div class="small-12 large-7 left columns">

      <?php echo CHtml::activeLabelEx($user,'name'); ?>
      <?php echo CHtml::activeTextField($user,"name", array('maxlength' => 128)); ?>
      
      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>
      
         
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($match,'city_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true,array('order'=>'name'))), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($user,'address'); ?>
      <?php echo CHtml::activetextField($user, 'address', array('maxlength' => 128)); ?>

    
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>
      <?php echo CHtml::endForm(); ?>
    </div>
      </div>
      
   
      <hr>
			<p>
      <a href="#" onclick="$('.addLinks').toggle(); return false;"><?php echo Yii::t('app',"My custom links"); ?> +</a>
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
              <?php echo $form->textField($link,'title'); ?>

              <?php echo $form->labelEx($link,'url'); ?>
              <?php echo $form->textField($link,'url'); ?>

              <?php echo CHtml::submitButton(Yii::t("app","Add link"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addLink(\''.Yii::app()->createUrl("profile/addLink").'\');')
                ); ?>

          <?php $this->endWidget(); ?>        
        
      </div>
			</p>
      <div class="linkList">
        <?php foreach ($data['user']['link'] as $link){ ?>
        <div data-alert class="alert-box radius secondary" id="link_div_<?php echo $link['id']; ?>">
          <?php echo $link['title']; ?>: <a href="http://<?php echo $link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a>
          <a href="#" class="close" onclick="removeLink(<?php echo $link['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteLink"); ?>')">&times;</a>
        </div>
        <?php } ?>
      </div>

      
  </div>
</div>



<?php 
	Yii::log(arrayLog($data['user']), CLogger::LEVEL_INFO, 'custom.info.user'); 
?>