<?php $this->pageTitle = Yii::t('app','Settings'); ?>
<div class="row">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Settings'); ?></h3>
  </div>
  <div class="columns panel edit-content">
    
    <?php if(Yii::app()->user->hasFlash('settingsMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('settingsMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    
    
      <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>
    
      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

      <?php //echo CHtml::activeLabelEx($user,'email'); ?>
      <label for="UserEdit_email"><?php echo Yii::t('app',"Email"); ?>
      </label>
      <span class="description">
         <?php echo Yii::t('msg',"Email can't be changed at this time."); ?>
      </span>
    
      <?php echo CHtml::activeTextField($user,"email", array("class"=>"small secondary readonly","disabled"=>true)); ?>
      
      <?php echo CHtml::activeLabelEx($user,'language_id'); ?>
      <?php echo CHtml::activedropDownList($user,'language_id', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(ELangPick::getLanguageList(),"id","native_name")
              , array('empty' => '&nbsp;',"style"=>"display:none")); ?>

      <?php echo CHtml::activeLabelEx($user,'newsletter'); ?>
      <div class="switch small round small-4 large-3">
        <input id="newsletter_0" name="UserEdit[newsletter]" type="radio" value="0" <?php if (!$user->newsletter) echo 'checked="checked"' ?>>
        <label for="newsletter_0" onclick=""><?php echo Yii::t('app','Off');?></label>

        <input id="newsletter_1" name="UserEdit[newsletter]" type="radio" value="1" <?php if ($user->newsletter) echo 'checked="checked"' ?>>
        <label for="newsletter_1" onclick=""><?php echo Yii::t('app','On');?></label>
        <span></span>
      </div>
    
      <?php /* echo CHtml::label(Yii::t("app","First page intro"),"fpi"); ?>
      <div class="switch small round small-4 large-3">
        <input id="fpi_0" name="UserEdit[fpi]" type="radio" value="0" <?php if (!$fpi) echo 'checked="checked"' ?>>
        <label for="fpi_0" onclick="">Off</label>

        <input id="fpi_1" name="UserEdit[fpi]" type="radio" value="1" <?php if ($fpi) echo 'checked="checked"' ?>>
        <label for="fpi_1" onclick="">On</label>
        <span></span>
      </div> <?php */ ?>
    
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
              array('class'=>"button small success radius")
          ); ?>
      <?php echo CHtml::endForm(); ?>
  </div>
</div>

<div class="row">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Change password'); ?></h3>
  </div>
  <div class="columns panel edit-content">

    <?php if(Yii::app()->user->hasFlash('passChangeMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('passChangeMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
      <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>

      <?php echo CHtml::errorSummary($passwordForm,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

      <?php echo CHtml::activeLabelEx($passwordForm,'oldPassword'); ?>
      <?php echo CHtml::activePasswordField($passwordForm,'oldPassword'); ?>
    
      <?php echo CHtml::activeLabelEx($passwordForm,'password'); ?>
      <?php echo CHtml::activePasswordField($passwordForm,'password'); ?>

      <?php echo CHtml::activeLabelEx($passwordForm,'verifyPassword'); ?>
      <?php echo CHtml::activePasswordField($passwordForm,'verifyPassword'); ?>

      <?php echo CHtml::submitButton(Yii::t("app","Save"),
                  array('class'=>"button small alert radius",
                        'confirm'=>Yii::t("msg","This action will change your password!\nAre you sure?") )
              ); ?>

    <?php echo CHtml::endForm(); ?>
  
  </div>
</div>

<div class="row">
  <div class="columns edit-header">
    <div class="edit-floater">
          <?php echo CHtml::submitButton(Yii::t("app","Open"),
                array('class'=>"button small secondary radius",
                      'onclick'=>"$('#deactivate').show();"
                    )
            ); ?>
    </div>
    <h3><?php echo Yii::t('app', 'Deactivate account'); ?></h3>
  </div>
  <div class="columns panel edit-content" id="deactivate" style="display:none;">
    <p>
      <?php echo Yii::t('msg', 'To deactivate your account change "Account status" to off and click deactivate. You will then be loged out of the system.'); ?>
      <br />
      <?php echo Yii::t('msg', 'We purge all deactivated accounts on first day of each month. You have until then to reactivate it by clicking "Lost Password?" in login form.'); ?>
      
      <div data-alert class='alert-box radius alert'>
        <?php echo Yii::t('msg', 'When we purge your account all data connected to it will be removed as well.'); ?>
      </div>
    </p>
    
    <?php echo CHtml::beginForm('','post',array('class'=>"custom")); ?>

    <?php echo CHtml::label(Yii::t('app', 'Account status'),'deactivate_account'); ?>
    <div class="switch small round small-2">
      <input id="deactivate_account_0" name="deactivate_account" type="radio" value="1" >
      <label for="deactivate_account_0" onclick=""><?php echo Yii::t('app','Off');?></label>

      <input id="deactivate_account_1" name="deactivate_account" type="radio" value="0" checked="checked">
      <label for="deactivate_account_1" onclick=""><?php echo Yii::t('app','On');?></label>
      <span></span>
    </div>

    <?php echo CHtml::submitButton(Yii::t("app","Deactivate account"),
                array('class'=>"button small alert radius",
                      'confirm'=>Yii::t("msg","This action will deactivate your account.\nAre you sure?") )
            ); ?>

    <?php echo CHtml::endForm(); ?>
  
  </div>
</div>


<!-- form -->