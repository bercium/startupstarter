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
        <?php echo Yii::t('app','Send me a copy by email'); ?>
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
  <?php /* ?>
  <div class="columns">
    <ul class="breadcrumbs">
     <li><a href="http://cofinder.eu"><?php echo Yii::t('app','Home'); ?></a> 
    <li><?php echo Yii::t('app','Message history'); ?></li>

    </ul>
  </div><?php */ ?>
  <div class="large-4 sidebar-wrap columns">
    
        
     <div class="section-container sidebar accordion edit-content edit-content-bottom" data-section="accordion">
      <section class="<?php if ($group == 'user') echo "active"; ?>">
        <p class="title" data-section-title><a href="#p1"><span class="icon-user icon-awesome"></span><?php echo Yii::t('app','People'); ?></a></p>

        <div class="content" data-section-content>
          <?php if (is_array($msgList['users'])){
            ?>
            <ul class="side-nav">
              <?php foreach ($msgList['users'] as $listPeople){ ?>
              <li class="<?php if (($id != 0) && ($listPeople['id'] == $id) && ($group == "user"))  echo "active"; ?>">
               <a href="<?php echo Yii::app()->createUrl("message/view",array("id"=>$listPeople['id'],"group"=>'user')); ?>"><?php echo $listPeople['name']; ?></a>
              </li>
              <?php } ?>
            </ul>
            <?php
          }else{ ?>
            <p><?php echo Yii::t('app','No contacted people.'); ?></p>
          <?php } ?>
        </div>
      </section>


      <section class="<?php if ($group == 'project') echo "active"; ?>">
        <p class="title" data-section-title><a href="#p2"><span class="icon-lightbulb"></span><?php echo Yii::t('app','Projects'); ?></a></p>
       
        <div class="content" data-section-content>
          <?php if (is_array($msgList['projects'])){
            ?>
            <ul class="side-nav">
              <?php foreach ($msgList['projects'] as $listProject){ ?>
              <li class="<?php if (($id != 0) && ($listProject['id'] == $id) && ($group == "project"))  echo "active"; ?>">
                <a href="<?php echo Yii::app()-> createUrl("message/view",array("id"=>$listProject['id'],"group"=>'project')); ?>"><?php echo $listProject['name']; ?></a>
              </li>
              <?php } ?>
            </ul>
            <?php
          }else{ ?>
            <p><?php echo Yii::t('app','No contacted projects.'); ?></p>
          <?php } ?>
          
        </div>
      </section>
    </div>
    
    
    
  </div>
  <div class="large-8 columns">
    <?php if (($id != 0) && $chatList['name']){ ?>
      <div class="columns edit-header">
        
        <?php if ($group == 'user'){ ?>
        <a href="<?php echo Yii::app()-> createUrl("person/view",array("id"=>$id)); ?>" >
          <h3 class="large-8"><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary small" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $id; ?>','');"><?php echo Yii::t('app',"Send message"); ?></a>
        <?php }else{ ?>
        <a href="<?php echo Yii::app()-> createUrl("project/view",array("id"=>$id)); ?>" >
          <h3 class="large-8"><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary small" href="#" data-dropdown="drop-msg" onclick="setReplayID('','<?php echo $id; ?>');" ><?php echo Yii::t('app',"Group message"); ?></a>
        <?php } ?>
      </div>
    
      <div class="columns panel edit-content">
        <?php foreach ($chatList['messages'] as $msg){ ?>
        
          <a href="<?php echo Yii::app()->createURL('person',array('id'=>$msg['from_id'])); ?>">
            <img class="th th-small" class="left" src="<?php echo avatar_image($msg['avatar_link'], $msg['from_id'], false); ?>" />
            <h3><?php echo $msg['from']; ?></h3>
          </a>
          
          <?php if (($msg['from_id'] != Yii::app()->user->id) && ($group == 'project')){ ?>
            
            <ul class="button-group radius right">
             <li><a class="button  secondary small" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $msg['from_id']; ?>','');"><?php echo Yii::t('app',"PM"); ?></a></li>
              <li><a class="button  secondary small" href="#" data-dropdown="drop-msg" onclick="setReplayID('<?php echo $msg['from_id']; ?>','<?php echo $id; ?>');"><?php echo Yii::t('app',"Replay"); ?></a></li>
            </ul>
          <?php } ?>
          <span class="description"><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($msg['time']),"medium","short"); ?></span><br />

          <p><?php echo $msg['content']; ?></p>
          <hr>
          
        <?php } ?>
      </div>
    <?php } ?>
  </div>

</div>