<div class="large-12 columns">
<?php $this->pageTitle = Yii::t('app','Settings'); ?>
<div class="row">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Settings'); ?></h3>
  </div>
  <div class="columns panel edit-content">
    
    
      <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>
    
      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

      <?php //echo CHtml::activeLabelEx($user,'email'); ?>
      <label for="UserEdit_email"><?php echo Yii::t('app',"Email"); ?>
      </label>
      <span class="description">
         <?php echo Yii::t('msg',"Email cannot be changed at the moment."); ?>
      </span>
    
      <?php echo CHtml::activeTextField($user,"email", array("class"=>"small secondary readonly","disabled"=>true)); ?>
      
      <?php echo CHtml::activeLabelEx($user,'language_id'); ?>
      <?php echo CHtml::activedropDownList($user,'language_id', 
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(ELangPick::getLanguageList(),"id","native_name")
              , array('empty' => '&nbsp;',"style"=>"display:none")); ?>

      <?php echo CHtml::activeLabelEx($user,'newsletter'); ?>
      <div class="switch small round" style="width:120px">
        <input id="newsletter_0" name="UserEdit[newsletter]" type="radio" value="0" <?php if (!$user->newsletter) echo 'checked="checked"' ?>>
        <label for="newsletter_0" onclick=""><?php echo Yii::t('app','Off');?></label>

        <input id="newsletter_1" name="UserEdit[newsletter]" type="radio" value="1" <?php if ($user->newsletter) echo 'checked="checked"' ?>>
        <label for="newsletter_1" onclick=""><?php echo Yii::t('app','On');?></label>
        <span></span>
      </div>
    
      <label for="UserEdit_vanityURL"><?php echo Yii::t('app',"Public name"); ?></label>
      <?php if (!$allowVanityURL){ ?>
        <span class="description"><?php echo Yii::t('msg',"<strong>Invite 3 people</strong> to enable your own personal URL."); ?></span>
      <?php }else{ ?>
        <span class="description"><?php echo Yii::t('msg',"Chose your own personal URL."); ?></span>
        
      <?php } ?>
        
    <div class="row collapse">
      <div class="small-5 columns">
        <span class="prefix">www.cofinder.eu/</span>
      </div>
      <div class="small-7 columns">
        <?php if (!$allowVanityURL) {
           echo CHtml::activeTextField($user,"vanityURL", array("class"=>"small secondary readonly",
                                                                "disabled"=>true,
                                                                "title"=>Yii::t('app','Invite at least 3 people'),
                                                                "data-tooltip"=>'',
                                                                "placeholder"=>substr(Yii::app()->user->email, 0, strpos(Yii::app()->user->email,"@")))); 
          }else{ 
            echo CHtml::activeTextField($user,"vanityURL", array("class"=>"small secondary","placeholder"=>  str_replace(".", "", substr(Yii::app()->user->email, 0, strpos(Yii::app()->user->email,"@")) ) )); 
          }?>
      </div>
        <?php /*if (!$allowVanityURL){ ?>
          <div class="small-2 columns">
            <a data-dropdown="drop-invitation-msg" href="#" class="postfix button radius">Invite</a>
          </div>
        <?php } */ ?>
    </div>
    
    <br />
    <label for="UserEdit_qrcodepair"><?php echo Yii::t('app',"Account paired with phone"); ?>
    <?php if ($user->qrcode){ ?>
    </label>
    <div class="switch small round" style="width:120px">
      <input id="newsletter_0" name="UserEdit[qrcodepair]" type="radio" value="0" <?php if (!$user->qrcode) echo 'checked="checked"' ?>>
      <label for="qrcodepair_0" onclick=""><?php echo Yii::t('app','Unpair');?></label>

      <input id="newsletter_1" name="UserEdit[qrcodepair]" type="radio" value="1" <?php if ($user->qrcode) echo 'checked="checked"' ?>>
      <label for="qrcodepair_1" onclick=""><?php echo Yii::t('app','Paired');?></label>
      <span></span>
    </div>
    
    <?php }else{ ?>
      <span class="label radius" data-tooltip title="<?php echo Yii::t('msg','Logout and scan QR code on next login to pair your phone!'); ?>"><?php echo Yii::t('app','Not paired'); ?></span>
      </label>
      <br />
    <?php } ?>
      <?php /* echo CHtml::label(Yii::t("app","First page intro"),"fpi"); ?>
      <div class="switch small round small-4 large-3">
        <input id="fpi_0" name="UserEdit[fpi]" type="radio" value="0" <?php if (!$fpi) echo 'checked="checked"' ?>>
        <label for="fpi_0" onclick="">Off</label>

        <input id="fpi_1" name="UserEdit[fpi]" type="radio" value="1" <?php if ($fpi) echo 'checked="checked"' ?>>
        <label for="fpi_1" onclick="">On</label>
        <span></span>
      </div> <?php */ ?>
    
      <br />
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
                        'confirm'=>Yii::t("msg","This action will change your password!")."\n".Yii::t("msg","Are you sure?") )
              ); ?>

    <?php echo CHtml::endForm(); ?>
  
  </div>
</div>

<div class="row mb60">
  <div class="columns edit-header">
    <h3><?php echo Yii::t('app', 'Deactivate account'); ?></h3>
          <?php echo CHtml::submitButton(Yii::t("app","Open"),
                array('class'=>"button small secondary radius",
                      'onclick'=>"$('#deactivate').show();"
                    )
            ); ?>
    
    
  </div>
  <div class="columns panel edit-content" id="deactivate" style="display:none;">
    <p>
      <?php echo Yii::t('msg', 'To deactivate your account change "Account status" to off and click deactivate. You will then be loged out of the system.'); ?>
      <br />
      <?php echo Yii::t('msg', 'We purge all deactivated accounts on first day of each month. You have until then to reactivate it by clicking "Lost Password?" in login form.'); ?>
      
      <div data-alert class='alert-box radius alert'>
        <span class="icon-warning-sign"></span> <?php echo Yii::t('msg', 'When we purge your account all data connected to it will also be removed.'); ?>
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
                      'confirm'=>Yii::t("msg","This action will deactivate your account.")."\n".Yii::t("msg","Are you sure?") )
            ); ?>

    <?php echo CHtml::endForm(); ?>
  
  </div>
 


</div>


</div>


<!-- form -->
