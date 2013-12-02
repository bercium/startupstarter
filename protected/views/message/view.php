<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
  <div class="contact-form">
    
  <?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact"),'post',array("class"=>"customs")); ?>

      <?php echo CHtml::hiddenField("user",''); ?>
      <?php echo CHtml::hiddenField("project",''); ?>
      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message'); ?>
      <br />
      
      <label for="notify_me">
        <?php echo CHtml::checkBox('notify_me',true); ?>
        <?php echo Yii::t('app','Send me a copy'); ?>
      </label>
      
      <br />
      <div class="login-floater">
      <?php echo CHtml::submitButton(Yii::t("app","Send"),array("class"=>"button small radius")); ?>
      </div>

  <?php echo CHtml::endForm(); ?>
      
  </div>
</div>

  <?php /* ?>
  <div class="large-12 columns hint-alert" >
  	<?php $this->widget('ext.ProfileInfo.WProfileInfo',array("style"=>"hint")); ?>
    <!-- here moved alert-box from \protected\views\profile\profile.php -->
  </div><?php //*/ ?>
  
<div class="row header-margin">
  <div class="large-4 sidebar-wrap columns">
    
        
     <div class="section-container sidebar tabs" data-section="tabs">
      <section class="<?php if ($group == 'user') echo "active"; ?>">
        <p class="title"><a href="#p1"><span class="icon-user"></span><?php echo Yii::t('app','People'); ?></a></p>

        <div class="content" data-slug="p1">
          <?php if (is_array($msgList['users'])){
            ?>
            <div class="section-container sidebar accordion" data-section>
              <?php foreach ($msgList['users'] as $listPeople){ ?>
              <section class="section <?php if (($listPeople['id'] == $_GET['id']) && ($group == "user"))  echo "active"; ?>">
                <p class="title"><a href="<?php echo Yii::app()->createUrl("message/view",array("id"=>$listPeople['id'],"group"=>'user')); ?>"><?php echo $listPeople['name']; ?></a></p>
              </section>
              <?php } ?>
            </div>
            <?php
          }else{ ?>
            <p><?php echo Yii::t('app','No contacted people.'); ?></p>
          <?php } ?>
        </div>
      </section>


      <section class="<?php if ($group == 'project') echo "active"; ?>">
        <p class="title"><a href="#p2"><span class="icon-lightbulb"></span><?php echo Yii::t('app','Projects'); ?></a></p>
        <div class="content" data-slug="p2">
          <?php if (is_array($msgList['projects'])){
            ?>
            <div class="section-container sidebar accordion" data-section>
              <?php foreach ($msgList['projects'] as $listProject){ ?>
              <section class="section <?php if (($listProject['id'] == $_GET['id']) && ($group == "project"))  echo "active"; ?>">
                <p class="title"><a href="<?php echo Yii::app()-> createUrl("message/view",array("id"=>$listProject['id'],"group"=>'project')); ?>"><?php echo $listProject['name']; ?></a></p>
              </section>
              <?php } ?>
            </div>
            <?php
          }else{ ?>
            <p><?php echo Yii::t('app','No contacted projects.'); ?></p>
          <?php } ?>
          
        </div>
      </section>
    </div>
    
    
    
  </div>
  <div class="large-8 columns">
    <?php if ($chatList['name']){ ?>
      <div class="columns edit-header">
        
        <?php if ($group == 'user'){ ?>
        <a href="<?php echo Yii::app()-> createUrl("person/view",array("id"=>$_GET['id'])); ?>" >
          <h3><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary tiny" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $_GET['id']; ?>','');"><?php echo Yii::t('app',"Send message"); ?></a>
        <?php }else{ ?>
        <a href="<?php echo Yii::app()-> createUrl("project/view",array("id"=>$_GET['id'])); ?>" >
          <h3><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary tiny" href="#" data-dropdown="drop-msg" onclick="setReplayID('','<?php echo $_GET['id']; ?>');" ><?php echo Yii::t('app',"Group message"); ?></a>
        <?php } ?>
      </div>
    
      <div class="columns panel edit-content">
        <?php foreach ($chatList['messages'] as $msg){ ?>
        
          <strong><?php echo $msg['from']; ?></strong>
          <?php if (($msg['from_id'] != Yii::app()->user->id) && ($group == 'project')){ ?>
            <a class="button radius right secondary tiny" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $msg['from_id']; ?>','');"><?php echo Yii::t('app',"PM"); ?></a>
            <a class="button radius right secondary tiny" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $msg['from_id']; ?>','<?php echo $_GET['id']; ?>');"><?php echo Yii::t('app',"Replay"); ?></a>
          <?php } ?>
          <br />
          <span class="description"><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($msg['time']),"medium","short"); ?></span><br />
          <p><?php echo $msg['content']; ?></p>
          <hr>
          
        <?php } ?>
      </div>
    <?php } ?>
  </div>

</div>