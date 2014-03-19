<?php // ckeditor files
$this->title = Yii::t('app','Message history');
 //$baseUrl = Yii::app()->baseUrl; 
    //$cs = Yii::app()->getClientScript();    
    //$cs->registerScriptFile($baseUrl.'/js/ckeditor/ckeditor.js',CClientScript::POS_HEAD);
    ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>

<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
  <div class="contact-form">
    
  <?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact"),'post',array("class"=>"customs")); ?>

      <?php echo CHtml::hiddenField("user",''); ?>
      <?php echo CHtml::hiddenField("project",''); ?>
      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message', '', array('class'=>'ckeditor')) ?>
      <br />
      
      <label for="notify_me">
        <?php echo CHtml::checkBox('notify_me',true); ?>
        <?php echo Yii::t('app','Send me a copy via email'); ?>
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
    
     <a href="<?php echo Yii::app()->createUrl('profile'); ?>" class="button small radius secondary large-12"><?php echo Yii::t('app','Back to profile'); ?></a>
      
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
        <a href="<?php echo Yii::app()-> createUrl("person",array("id"=>$id)); ?>" >
          <h3 class="large-8"><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary small" href="#" data-dropdown="drop-msg" trk="contact_history_person" onclick="setReplyID('<?php echo $id; ?>','');"><?php echo Yii::t('app',"Send message"); ?></a>
        <?php }else{ ?>
        <a href="<?php echo Yii::app()-> createUrl("project",array("id"=>$id)); ?>" >
          <h3 class="large-8"><?php echo $chatList['name']; ?></h3>
        </a>
        <a class="button radius right secondary small" href="#" data-dropdown="drop-msg" trk="contact_history_team" data-tooltip title="<?php echo Yii::t('msg',"Send message to team members only"); ?>" onclick="setReplyID('','<?php echo $id; ?>');" ><?php echo Yii::t('app',"Team message"); ?></a>
        <?php } ?>
      </div>
    
      <div class="columns panel edit-content">
        <?php foreach ($chatList['messages'] as $msg){ ?>
        
          <div class="meta mb5">
            <small>
              <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($msg['time']),"medium","short"); ?>
              <span class="right">
                <?php if ($msg['read_time']) echo Yii::t('app','viewed {datetime}',array("{datetime}"=>Yii::app()->dateFormatter->formatDateTime(strtotime($msg['read_time']),"medium","short"))); /*else echo Yii::t('app','unread'); */ ?>
              </span>
            </small>
          </div>
          
          <div class="mb10">
          <a href="<?php echo Yii::app()->createURL('person',array('id'=>$msg['from_id'])); ?>">
            <img class="th th-small" class="left" src="<?php echo avatar_image($msg['avatar_link'], $msg['from_id'], false); ?>" />
            <h3 class="mb0"><?php echo $msg['from']; ?>
              <span class=' icon-arrow-right f-small'></span>
              <font style="color:#A6A6A6">
              <?php 
                if ($msg['to']) echo " ".$msg['to'];
                else echo " ".$msg['cc'];
               ?>
              </font>
            </h3>
            <small class="meta">
            <?php 
              if ($msg['to'] && $msg['cc']) echo " cc: ".$msg['cc'];
              else echo '<br />';
            ?>
            </small>
          </a>
          </div>
            
          <?php if (($msg['from_id'] != Yii::app()->user->id) && ($group == 'project')){ ?>
            <a class="button radius right secondary small" href="#" data-dropdown="drop-msg" data-tooltip title="<?php echo Yii::t('msg',"Send private message to user and project team members"); ?>" trk="contact_history_reply" onclick="setReplyID('<?php echo $msg['from_id']; ?>','<?php echo $id; ?>');"><?php echo Yii::t('app',"Reply"); ?></a>
          <?php } ?>
            

          <p><?php echo $msg['content']; ?></p>
          <hr>
          
        <?php } ?>
      </div>
    <?php } ?>
  </div>

</div>